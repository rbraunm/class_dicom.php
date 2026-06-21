<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK;

/**
 * The result of one DCMTK tool invocation. Immutable: the toolkit returns this
 * instead of raw strings so nothing past the substrate boundary handles
 * unstructured output. `succeeded()` is derived from the exit code, not stored.
 */
final class CommandResult
{
    /**
     * @param list<string> $argv arguments passed to the tool, excluding the binary
     */
    public function __construct(
        public readonly string $binary,
        public readonly array $argv,
        public readonly int $exitCode,
        public readonly string $stdout,
        public readonly string $stderr,
        public readonly float $durationSeconds,
    ) {
    }

    public function succeeded(): bool
    {
        return $this->exitCode === 0;
    }
}
