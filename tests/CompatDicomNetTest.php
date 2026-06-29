<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\File;
use PACS\Association;
use PACS\Peer;
use PACS\SCPProcess;
use PACS\SCU;
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

    /** @var list<SCPProcess> */
    private array $startedHandles = [];

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
        foreach ($this->startedHandles as $handle) {
            $handle->stop();
        }
        $this->startedHandles = [];
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

    private function tempDir(): string
    {
        $dir = sys_get_temp_dir() . '/netshim' . bin2hex(random_bytes(6));
        mkdir($dir, 0775, true);
        $this->tempDirs[] = $dir;

        return $dir;
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

    public function testTransferSyntaxIsInertButDeprecated(): void
    {
        $net = new \dicom_net();
        $net->file = self::FIXTURES . '/implicit_vr_le.dcm';
        $net->transfer_syntax = '1.2.840.10008.1.2.1'; // ignored, exactly as in v1

        $result = $this->capture(fn (): mixed => $net
            ->send_dcm('127.0.0.1', $this->port, 'SENDSCU', 'ECHOSCP'));

        $this->assertSame(0, $result);
        $this->assertSame(1, $this->countReceived());
        // send_dcm's own deprecation plus the transfer_syntax-ignored one.
        $messages = array_map(fn (array $n): string => $n[1], $this->noticesOf(E_USER_DEPRECATED));
        $this->assertCount(2, $messages);
        $this->assertNotEmpty(
            array_filter($messages, static fn (string $m): bool => str_contains($m, 'transfer_syntax')),
        );
    }

    private function sendObject(int $port, string $callingAE, string $calledAE, string $fixture): void
    {
        (new SCU(new Peer('127.0.0.1', $port, $calledAE), new Association($callingAE)))
            ->send(File::open($fixture));
    }

    /** Write an executable handler that logs each placeholder it receives, one per line. */
    private function writeHandler(string $log): string
    {
        $path = dirname($log) . '/handler.sh';
        file_put_contents($path, "#!/bin/sh\nprintf '%s\\n' \"\$@\" >> " . escapeshellarg($log) . "\n");
        chmod($path, 0755);

        return $path;
    }

    public function testStoreServerRunsHandlerWithPlaceholders(): void
    {
        $recv = $this->tempDir();
        $log = $this->tempDir() . '/handler.log';
        $handler = $this->writeHandler($log);
        $port = $this->freePort();

        $net = new \dicom_net();
        $net->blocking = false; // return the handle instead of blocking
        $handle = $this->capture(fn (): mixed => $net->store_server($port, $recv, $handler));

        $this->assertInstanceOf(SCPProcess::class, $handle);
        $this->startedHandles[] = $handle;
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));

        $this->sendObject($port, 'SENDERAE', 'RECVRAE', self::FIXTURES . '/implicit_vr_le.dcm');

        $args = [];
        $deadline = microtime(true) + 6.0;
        while (microtime(true) < $deadline) {
            $args = is_file($log)
                ? array_values(array_filter(explode("\n", (string) file_get_contents($log)), 'strlen'))
                : [];
            if (count($args) >= 4) {
                break;
            }
            usleep(100000);
        }

        $this->assertCount(4, $args, 'handler did not run with the four placeholders');
        // v1 placeholder order #p #f #c #a: storage dir, stored file, called AE (us), calling AE (sender).
        $this->assertSame(realpath($recv), realpath($args[0]));
        $this->assertFileExists($args[0] . '/' . $args[1]);
        $this->assertSame('RECVRAE', $args[2]);
        $this->assertSame('SENDERAE', $args[3]);
    }

    public function testStoreServerSoftensStartupFailure(): void
    {
        $port = $this->freePort();
        $occupier = (new \PACS\SCP($port, $this->tempDir()))->start();
        $this->startedHandles[] = $occupier;

        $net = new \dicom_net();
        $net->blocking = false;
        $result = $this->capture(fn (): mixed => $net->store_server($port, $this->tempDir(), ''));

        $this->assertNull($result);
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
    }

    public function testStoreServerBlocksUntilStopped(): void
    {
        foreach (['pcntl_fork', 'pcntl_waitpid', 'posix_setsid', 'posix_kill'] as $fn) {
            if (!function_exists($fn)) {
                $this->markTestSkipped("requires {$fn}");
            }
        }

        $port = $this->freePort();
        $recv = $this->tempDir();

        $pid = pcntl_fork();
        $this->assertNotSame(-1, $pid, 'fork failed');
        if ($pid === 0) {
            // Child: new session so the whole group (php child + storescp) can be reaped
            // together. Default blocking=true means store_server never returns here.
            posix_setsid();
            $net = new \dicom_net();
            @$net->store_server($port, $recv, '');
            exit(0);
        }

        $up = false;
        $deadline = microtime(true) + 5.0;
        while (microtime(true) < $deadline) {
            $client = @stream_socket_client("tcp://127.0.0.1:{$port}", $errno, $errstr, 0.2);
            if ($client !== false) {
                fclose($client);
                $up = true;
                break;
            }
            usleep(100000);
        }

        $this->assertTrue($up, 'blocking store_server never started listening');
        // Still blocked (not returned) -> the child has not exited.
        $this->assertSame(0, pcntl_waitpid($pid, $status, WNOHANG), 'store_server returned instead of blocking');

        posix_kill(-$pid, SIGKILL); // kill the child's whole session (php child + storescp)
        pcntl_waitpid($pid, $status);
    }
}
