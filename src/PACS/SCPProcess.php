<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS;

use DCMTK\Process;

/**
 * A handle to a running SCP (storescp receiver) started by SCP::start. Stop it,
 * check whether it is running, and read the port and output directory it was
 * started with.
 */
final class SCPProcess
{
    public function __construct(
        private readonly Process $process,
        private readonly int $port,
        private readonly string $outputDirectory,
    ) {
    }

    public function stop(): void
    {
        $this->process->stop();
    }

    public function isRunning(): bool
    {
        return $this->process->isRunning();
    }

    public function port(): int
    {
        return $this->port;
    }

    public function outputDirectory(): string
    {
        return $this->outputDirectory;
    }
}
