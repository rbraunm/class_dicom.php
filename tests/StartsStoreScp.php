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
    use AllocatesPorts;

    /** @var list<resource> */
    private array $peerProcesses = [];

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
