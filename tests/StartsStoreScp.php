<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Tests;

/**
 * Starts a real storescp peer for networking tests and tears it down. Shared by
 * the SCU/SCP/EchoSCU suites so each gets an actual DICOM peer to talk to rather
 * than a mock. storescp accepts C-ECHO and C-STORE, so one peer serves all of
 * them.
 */
trait StartsStoreScp
{
    /** @var list<resource> */
    private array $peerProcesses = [];

    /** Allocate a TCP port that is free right now (small TOCTOU window, fine for tests). */
    private function freePort(): int
    {
        $server = @stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
        if ($server === false) {
            throw new \RuntimeException("Could not allocate a free port: {$errstr} ({$errno}).");
        }
        $name = stream_socket_get_name($server, false);
        fclose($server);
        $colon = strrpos($name, ':');
        $port = $colon === false ? 0 : (int) substr($name, $colon + 1);
        if ($port < 1) {
            throw new \RuntimeException("Could not parse an allocated port from '{$name}'.");
        }

        return $port;
    }

    /** Start a storescp peer on $port storing to $outputDirectory; block until it accepts connections. */
    private function startStoreScp(int $port, string $outputDirectory, string $aeTitle = 'TEST_SCP'): void
    {
        if (!is_dir($outputDirectory) && !mkdir($outputDirectory, 0777, true) && !is_dir($outputDirectory)) {
            throw new \RuntimeException("Could not create peer output directory '{$outputDirectory}'.");
        }
        $descriptors = [
            0 => ['file', '/dev/null', 'r'],
            1 => ['file', '/dev/null', 'w'],
            2 => ['file', '/dev/null', 'w'],
        ];
        $pipes = [];
        $process = proc_open(
            ['storescp', '-od', $outputDirectory, '-aet', $aeTitle, '+xa', (string) $port],
            $descriptors,
            $pipes,
        );
        if (!is_resource($process)) {
            throw new \RuntimeException('Could not start the storescp peer process.');
        }
        $this->peerProcesses[] = $process;

        $deadline = microtime(true) + 5.0;
        while (microtime(true) < $deadline) {
            $client = @stream_socket_client("tcp://127.0.0.1:{$port}", $errno, $errstr, 0.2);
            if ($client !== false) {
                fclose($client);

                return;
            }
            usleep(50000);
        }
        throw new \RuntimeException("storescp peer did not start listening on port {$port}.");
    }

    protected function stopStoreScpPeers(): void
    {
        foreach ($this->peerProcesses as $process) {
            if (is_resource($process)) {
                proc_terminate($process);
                proc_close($process);
            }
        }
        $this->peerProcesses = [];
    }
}
