<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Tests;

use DICOM\Compress;
use DICOM\Convert;
use DICOM\File;
use DICOM\Scale;
use PACS\Association;
use PACS\Exception\NetworkException;
use PACS\Peer;
use PACS\SCU;
use PACS\TransferSyntaxProposal;
use PHPUnit\Framework\TestCase;

final class SCUTest extends TestCase
{
    use StartsStoreScp;
    use ManagesTempDirs;

    private function example(): File
    {
        return File::open(__DIR__ . '/../examples/dean.dcm');
    }

    /** An uncompressed (Explicit VR LE) DICOM, which a default storescp accepts. */
    private function uncompressedDicom(string $path): File
    {
        return (new Compress($this->example()))->decompress($path);
    }

    /** A second uncompressed DICOM with a distinct SOP Instance UID (img2dcm mints one). */
    private function distinctUncompressedDicom(string $path): File
    {
        $jpg = $this->tempDir() . '/frame.jpg';
        (new Convert($this->example()))->toJPEG($jpg, scale: Scale::widthTo(120));
        $wrapped = Convert::fromJpeg([$jpg], $this->tempDir() . '/wrapped.dcm');

        return (new Compress($wrapped))->decompress($path);
    }

    private function quickAssociation(): Association
    {
        return new Association(acseTimeoutSeconds: 5, connectionTimeoutSeconds: 2);
    }

    private function fileCount(string $dir): int
    {
        $count = 0;
        foreach (scandir($dir) ?: [] as $entry) {
            if ($entry !== '.' && $entry !== '..' && is_file($dir . '/' . $entry)) {
                $count++;
            }
        }

        return $count;
    }

    private function waitForFileCount(string $dir, int $expected, float $timeoutSeconds = 3.0): int
    {
        $deadline = microtime(true) + $timeoutSeconds;
        do {
            $count = $this->fileCount($dir);
            if ($count >= $expected) {
                return $count;
            }
            usleep(50000);
        } while (microtime(true) < $deadline);

        return $this->fileCount($dir);
    }

    protected function tearDown(): void
    {
        $this->stopStoreScpPeers();
        $this->cleanupTempDirs();
    }

    public function testSendDeliversFileToScp(): void
    {
        $received = $this->tempDir();
        $port = $this->freePort();
        $this->startStoreScp($port, $received);

        (new SCU(new Peer('127.0.0.1', $port)))->send($this->uncompressedDicom($this->tempDir() . '/a.dcm'));

        $this->assertSame(1, $this->waitForFileCount($received, 1));
    }

    public function testSendMultipleDeliversAll(): void
    {
        $received = $this->tempDir();
        $port = $this->freePort();
        $this->startStoreScp($port, $received);

        (new SCU(new Peer('127.0.0.1', $port)))->send(
            $this->uncompressedDicom($this->tempDir() . '/a.dcm'),
            $this->distinctUncompressedDicom($this->tempDir() . '/b.dcm'),
        );

        $this->assertSame(2, $this->waitForFileCount($received, 2));
    }

    public function testSendEmptyThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new SCU(new Peer('127.0.0.1', $this->freePort())))->send();
    }

    public function testSendThrowsWhenPeerUnreachable(): void
    {
        $port = $this->freePort(); // nothing listening
        $scu = new SCU(new Peer('127.0.0.1', $port), $this->quickAssociation());

        $this->expectException(NetworkException::class);
        $scu->send($this->uncompressedDicom($this->tempDir() . '/a.dcm'));
    }

    public function testSendVanishedFileThrowsIoException(): void
    {
        $path = $this->tempDir() . '/gone.dcm';
        $file = $this->uncompressedDicom($path);
        unlink($path);

        $this->expectException(\DICOM\Exception\IOException::class);
        (new SCU(new Peer('127.0.0.1', $this->freePort())))->send($file);
    }

    public function testSendDirectoryDeliversAll(): void
    {
        $received = $this->tempDir();
        $port = $this->freePort();
        $this->startStoreScp($port, $received);

        $sendDir = $this->tempDir();
        $this->uncompressedDicom($sendDir . '/a.dcm');
        $this->distinctUncompressedDicom($sendDir . '/b.dcm');

        (new SCU(new Peer('127.0.0.1', $port)))->sendDirectory($sendDir);

        $this->assertSame(2, $this->waitForFileCount($received, 2));
    }

    public function testSendDirectoryRecursiveIncludesNested(): void
    {
        $received = $this->tempDir();
        $port = $this->freePort();
        $this->startStoreScp($port, $received);

        $sendDir = $this->tempDir();
        mkdir($sendDir . '/nested', 0777, true);
        $this->uncompressedDicom($sendDir . '/nested/deep.dcm');

        (new SCU(new Peer('127.0.0.1', $port)))->sendDirectory($sendDir, recursive: true);

        $this->assertSame(1, $this->waitForFileCount($received, 1));
    }

    public function testRejectsNonDirectory(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new SCU(new Peer('127.0.0.1', $this->freePort())))->sendDirectory('/no/such/directory');
    }

    public function testProposalFlags(): void
    {
        $this->assertSame([], TransferSyntaxProposal::automatic()->flags());
        $this->assertSame(['-xe'], TransferSyntaxProposal::uncompressed()->flags());
        $this->assertSame(['-xi'], TransferSyntaxProposal::implicitVRLittleEndian()->flags());
        $this->assertSame(['-xs'], TransferSyntaxProposal::jpegLossless()->flags());
    }
}
