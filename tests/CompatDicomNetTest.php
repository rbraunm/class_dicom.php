<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use PACS\Tests\StartsStoreScp;
use PHPUnit\Framework\TestCase;

/**
 * Phase 6g: the dicom_net compat class. Verifies the v1 contract against a real
 * storescp peer -- echoscu returns 0 on success and the error string on failure
 * (never throwing), and an AE title the v2 substrate rejects is softened to that
 * error string with a deprecation rather than aborting. Authored from the v1
 * footprint, the README, and blackbox observation, never the legacy source.
 */
final class CompatDicomNetTest extends TestCase
{
    use CapturesUserNotices;
    use StartsStoreScp;

    private int $port;
    private string $recv;

    /** @var list<string> */
    private array $tempDirs = [];

    private const FIXTURES = __DIR__ . '/fixtures';

    protected function setUp(): void
    {
        $this->port = $this->freePort();
        $this->recv = sys_get_temp_dir() . '/netshim' . bin2hex(random_bytes(6));
        mkdir($this->recv, 0775, true);
        $this->startStoreScp($this->port, $this->recv, 'ECHOSCP');
    }

    protected function tearDown(): void
    {
        $this->stopStoreScpPeers();
        foreach (array_merge([$this->recv], $this->tempDirs) as $directory) {
            foreach (glob($directory . '/*') ?: [] as $file) {
                @unlink($file);
            }
            @rmdir($directory);
        }
        $this->tempDirs = [];
    }

    private function countReceived(): int
    {
        return count(glob($this->recv . '/*') ?: []);
    }

    private function settleReceived(int $want, float $seconds = 4.0): void
    {
        $deadline = microtime(true) + $seconds;
        while (microtime(true) < $deadline && $this->countReceived() < $want) {
            usleep(100000);
        }
    }

    public function testEchoscuReturnsZeroOnSuccess(): void
    {
        $result = $this->capture(fn (): mixed => (new \dicom_net())
            ->echoscu('127.0.0.1', $this->port, 'ECHOSCU', 'ECHOSCP'));

        $this->assertSame(0, $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
    }

    public function testEchoscuReturnsErrorStringWhenPeerUnreachable(): void
    {
        $dead = $this->freePort();   // nothing listening here
        $result = $this->capture(fn (): mixed => (new \dicom_net())
            ->echoscu('127.0.0.1', $dead, 'ECHOSCU', 'ECHOSCP'));

        $this->assertIsString($result);
        $this->assertNotSame('', $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
    }

    public function testEchoscuSoftensRejectedAeTitleToErrorStringWithDeprecation(): void
    {
        $tooLong = str_repeat('A', 17);   // v2 rejects AE titles over 16 chars
        $result = $this->capture(fn (): mixed => (new \dicom_net())
            ->echoscu('127.0.0.1', $this->port, $tooLong, 'ECHOSCP'));

        // v1 never threw on a bad AE; the shim returns the rejection as an error
        // string and surfaces it as a deprecation, not a runtime warning.
        $this->assertIsString($result);
        $this->assertStringContainsString('16 characters', $result);
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
        $this->assertCount(2, $this->noticesOf(E_USER_DEPRECATED));
    }

    public function testSendDcmSingleFileReturnsZeroAndStoresOne(): void
    {
        $net = new \dicom_net();
        $net->file = self::FIXTURES . '/explicit_vr_le.dcm';

        $result = $this->capture(fn (): mixed => $net
            ->send_dcm('127.0.0.1', $this->port, 'SENDSCU', 'ECHOSCP'));

        $this->assertSame(0, $result);
        $this->settleReceived(1);
        $this->assertSame(1, $this->countReceived());
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
    }

    public function testSendDcmBatchSendsEveryFileInTheDirectory(): void
    {
        $send = sys_get_temp_dir() . '/netsend' . bin2hex(random_bytes(6));
        mkdir($send, 0775, true);
        $this->tempDirs[] = $send;
        // three DISTINCT objects (distinct SOP Instance UIDs) so all three store
        foreach (['implicit_vr_le.dcm', 'explicit_vr_le.dcm', 'jpeg_baseline.dcm'] as $i => $name) {
            copy(self::FIXTURES . '/' . $name, sprintf('%s/%02d.dcm', $send, $i));
        }

        $net = new \dicom_net();
        $net->file = $send . '/00.dcm';
        $result = $this->capture(fn (): mixed => $net
            ->send_dcm('127.0.0.1', $this->port, 'SENDSCU', 'ECHOSCP', 1));

        $this->assertSame(0, $result);
        $this->settleReceived(3);
        $this->assertSame(3, $this->countReceived());
    }

    public function testSendDcmReturnsErrorStringWhenPeerUnreachable(): void
    {
        $dead = $this->freePort();
        $net = new \dicom_net();
        $net->file = self::FIXTURES . '/explicit_vr_le.dcm';

        $result = $this->capture(fn (): mixed => $net
            ->send_dcm('127.0.0.1', $dead, 'SENDSCU', 'ECHOSCP'));

        $this->assertIsString($result);
        $this->assertNotSame('', $result);
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
    }

    public function testSendDcmReturnsErrorStringWhenFileMissing(): void
    {
        $net = new \dicom_net();
        $net->file = self::FIXTURES . '/does_not_exist.dcm';

        $result = $this->capture(fn (): mixed => $net
            ->send_dcm('127.0.0.1', $this->port, 'SENDSCU', 'ECHOSCP'));

        $this->assertIsString($result);
        $this->assertSame(0, $this->countReceived());
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
    }

    public function testEchoscuConfiguredTimeoutReachesAssociation(): void
    {
        // An out-of-range timeout proves the property is passed through to
        // Association (which rejects < 1); the rejection softens per the contract.
        $net = new \dicom_net();
        $net->echo_acse_timeout = 0;

        $result = $this->capture(fn (): mixed => $net
            ->echoscu('127.0.0.1', $this->port, 'ECHOSCU', 'ECHOSCP'));

        $this->assertIsString($result);
        $this->assertStringContainsString('ACSE timeout', $result);
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
        $this->assertCount(2, $this->noticesOf(E_USER_DEPRECATED));
    }
}
