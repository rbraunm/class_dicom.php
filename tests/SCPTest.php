<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Tests;

use DICOM\Compress;
use DICOM\Exception\IOException;
use DICOM\File;
use PACS\Exception\NetworkException;
use PACS\Peer;
use PACS\SCP;
use PACS\SCPProcess;
use PACS\SCU;
use PHPUnit\Framework\TestCase;

final class SCPTest extends TestCase
{
    use AllocatesPorts;
    use ManagesTempDirs;
    use CountsStoredFiles;

    /** @var list<SCPProcess> */
    private array $startedScps = [];

    private function example(): File
    {
        return File::open(__DIR__ . '/../examples/dean.dcm');
    }

    /** An uncompressed (Explicit VR LE) DICOM, which storescp negotiates cleanly. */
    private function uncompressedDicom(string $path): File
    {
        return (new Compress($this->example()))->decompress($path);
    }

    private function startScp(SCP $scp): SCPProcess
    {
        $handle = $scp->start();
        $this->startedScps[] = $handle;

        return $handle;
    }

    private function sendOneTo(int $port): void
    {
        (new SCU(new Peer('127.0.0.1', $port)))->send($this->uncompressedDicom($this->tempDir() . '/send.dcm'));
    }

    protected function tearDown(): void
    {
        foreach ($this->startedScps as $handle) {
            $handle->stop();
        }
        $this->startedScps = [];
        $this->cleanupTempDirs();
    }

    public function testReceivesSentObject(): void
    {
        $received = $this->tempDir();
        $port = $this->freePort();
        $handle = $this->startScp(new SCP($port, $received));

        $this->assertTrue($handle->isRunning());
        $this->sendOneTo($port);
        $this->assertSame(1, $this->waitForFileCount($received, 1));
    }

    public function testPostReceiveCommandFires(): void
    {
        $received = $this->tempDir();
        $marker = $this->tempDir() . '/fired.marker';
        $port = $this->freePort();
        $this->startScp(new SCP($port, $received, postReceiveCommand: 'touch ' . escapeshellarg($marker)));

        $this->sendOneTo($port);

        $this->assertTrue($this->waitForFile($marker), 'post-reception command did not run');
    }

    public function testStopHaltsTheServer(): void
    {
        $port = $this->freePort();
        $handle = $this->startScp(new SCP($port, $this->tempDir()));
        $this->assertTrue($handle->isRunning());

        $handle->stop();

        $this->assertFalse($handle->isRunning());
    }

    public function testStartFailsWhenPortInUse(): void
    {
        $port = $this->freePort();
        $this->startScp(new SCP($port, $this->tempDir())); // occupies the port

        $this->expectException(NetworkException::class);
        (new SCP($port, $this->tempDir()))->start();
    }

    public function testStartThrowsWhenOutputDirMissing(): void
    {
        $this->expectException(IOException::class);
        (new SCP($this->freePort(), '/no/such/output/directory'))->start();
    }

    public function testRejectsInvalidPort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new SCP(0, $this->tempDir());
    }

    public function testRejectsInvalidAeTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new SCP($this->freePort(), $this->tempDir(), aeTitle: 'THIS_AE_TITLE_IS_TOO_LONG');
    }

    public function testHandleExposesPortAndOutputDirectory(): void
    {
        $received = $this->tempDir();
        $port = $this->freePort();
        $handle = $this->startScp(new SCP($port, $received));

        $this->assertSame($port, $handle->port());
        $this->assertSame($received, $handle->outputDirectory());
    }

    public function testStartsWithPresentationConfigFile(): void
    {
        // A minimal storescp config whose "Default" profile accepts the sent object
        // (ComputedRadiography, uncompressed), exercising the -xf <file> Default path.
        $config = $this->tempDir() . '/scp.cfg';
        file_put_contents($config, <<<CFG
            [[TransferSyntaxes]]
            [Uncompressed]
            TransferSyntax1 = LittleEndianExplicit
            TransferSyntax2 = LittleEndianImplicit

            [[PresentationContexts]]
            [StorageContexts]
            PresentationContext1 = VerificationSOPClass\\Uncompressed
            PresentationContext2 = ComputedRadiographyImageStorage\\Uncompressed

            [[Profiles]]
            [Default]
            PresentationContexts = StorageContexts
            CFG);

        $received = $this->tempDir();
        $port = $this->freePort();
        $this->startScp(new SCP($port, $received, presentationConfigFile: $config));

        $this->sendOneTo($port);
        $this->assertSame(1, $this->waitForFileCount($received, 1));
    }

    public function testRejectsMissingPresentationConfigFile(): void
    {
        $this->expectException(IOException::class);
        (new SCP($this->freePort(), $this->tempDir(), presentationConfigFile: '/no/such/scp.cfg'))->start();
    }

    public function testRejectsOutOfRangeTimeout(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new SCP($this->freePort(), $this->tempDir(), acseTimeoutSeconds: 0);
    }
}
