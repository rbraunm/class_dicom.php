<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Tests;

use PACS\Association;
use PACS\EchoSCU;
use PACS\Exception\NetworkException;
use PACS\Peer;
use PHPUnit\Framework\TestCase;

final class EchoSCUTest extends TestCase
{
    use StartsStoreScp;

    /** @var list<string> */
    private array $tempDirs = [];

    private function tempDir(): string
    {
        $dir = sys_get_temp_dir() . '/pacs_echo_' . bin2hex(random_bytes(6));
        if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException("Could not create temp dir {$dir}.");
        }
        $this->tempDirs[] = $dir;

        return $dir;
    }

    /** A short connection timeout so the no-peer cases fail fast instead of hanging. */
    private function quickAssociation(string $callingAETitle = 'CLASS_DICOM'): Association
    {
        return new Association(
            callingAETitle: $callingAETitle,
            acseTimeoutSeconds: 5,
            connectionTimeoutSeconds: 2,
        );
    }

    protected function tearDown(): void
    {
        $this->stopStoreScpPeers();
        foreach ($this->tempDirs as $dir) {
            $this->removeDir($dir);
        }
        $this->tempDirs = [];
    }

    private function removeDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        foreach (scandir($dir) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $path = $dir . '/' . $entry;
            is_dir($path) ? $this->removeDir($path) : @unlink($path);
        }
        @rmdir($dir);
    }

    public function testVerifySucceedsAgainstRunningScp(): void
    {
        $this->expectNotToPerformAssertions();
        $port = $this->freePort();
        $this->startStoreScp($port, $this->tempDir());
        (new EchoSCU(new Peer('127.0.0.1', $port)))->verify();
    }

    public function testIsReachableTrueAgainstRunningScp(): void
    {
        $port = $this->freePort();
        $this->startStoreScp($port, $this->tempDir());
        $this->assertTrue((new EchoSCU(new Peer('127.0.0.1', $port)))->isReachable());
    }

    public function testIsReachableFalseWhenNothingListening(): void
    {
        $port = $this->freePort(); // allocated, nothing bound to it
        $echo = new EchoSCU(new Peer('127.0.0.1', $port), $this->quickAssociation());
        $this->assertFalse($echo->isReachable());
    }

    public function testVerifyThrowsWhenNothingListening(): void
    {
        $port = $this->freePort();
        $echo = new EchoSCU(new Peer('127.0.0.1', $port), $this->quickAssociation());
        $this->expectException(NetworkException::class);
        $echo->verify();
    }

    public function testPeerFlagsNameTheCalledAe(): void
    {
        $this->assertSame(['-aec', 'MY_SCP'], (new Peer('127.0.0.1', 104, 'MY_SCP'))->flags());
    }

    public function testAssociationFlagsCarryCallingAeAndOverriddenTimeouts(): void
    {
        $association = new Association(
            callingAETitle: 'CALLER',
            acseTimeoutSeconds: 5,
            connectionTimeoutSeconds: 2,
        );
        // -aet, then only the timeouts that were set, in tool order (ACSE, then connection).
        $this->assertSame(['-aet', 'CALLER', '-ta', '5', '-to', '2'], $association->flags());
    }

    public function testAssociationDefaultOmitsTimeouts(): void
    {
        // Unset timeouts emit no flag, leaving the tool's own defaults in place.
        $this->assertSame(['-aet', 'CLASS_DICOM'], (new Association())->flags());
    }

    public function testRejectsInvalidPeerPort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Peer('127.0.0.1', 70000);
    }

    public function testRejectsOverlongAeTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Peer('127.0.0.1', 11112, 'THIS_AE_TITLE_IS_TOO_LONG');
    }
}
