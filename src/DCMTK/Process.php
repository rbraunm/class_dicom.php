<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK;

/**
 * A handle to a DCMTK tool running in the background, started by Toolkit::start
 * (for example a storescp receiver). The caller can check whether it is still
 * running, read its PID, and stop it. stdout and stderr were discarded at launch,
 * so there is nothing to drain here -- the tool's real output is its side effects.
 */
final class Process
{
    /**
     * @param resource $handle the proc_open process resource
     */
    public function __construct(
        private $handle,
        private readonly int $pid,
    ) {
    }

    public function pid(): int
    {
        return $this->pid;
    }

    public function isRunning(): bool
    {
        if (!is_resource($this->handle)) {
            return false;
        }

        return (bool) (proc_get_status($this->handle)['running'] ?? false);
    }

    /**
     * Terminate the process (SIGTERM) and reap it. Idempotent: calling it again, or
     * after the process has already exited, does nothing.
     */
    public function stop(): void
    {
        if (!is_resource($this->handle)) {
            return;
        }
        proc_terminate($this->handle);
        proc_close($this->handle);
    }
}
