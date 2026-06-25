<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS;

/**
 * A remote DICOM application entity to connect to: its network address and the
 * AE title to call it by. This is the SCP side of an operation -- what you are
 * talking to.
 */
final class Peer
{
    public function __construct(
        private readonly string $host,
        private readonly int $port,
        private readonly string $calledAETitle = 'ANY-SCP',
    ) {
        if ($this->host === '') {
            throw new \InvalidArgumentException('Peer host must not be empty.');
        }
        if ($this->port < 1 || $this->port > 65535) {
            throw new \InvalidArgumentException("Peer port must be within [1, 65535], got {$this->port}.");
        }
        self::assertAETitle($this->calledAETitle, 'Called AE title');
    }

    public function host(): string
    {
        return $this->host;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function calledAETitle(): string
    {
        return $this->calledAETitle;
    }

    /** The option fragment naming the peer's AE (echoscu/storescu --call). */
    public function flags(): array
    {
        return ['-aec', $this->calledAETitle];
    }

    /**
     * Validate a DICOM AE title: 1 to 16 characters, no leading or trailing spaces.
     * Shared with Association so both AE titles are checked the same way.
     */
    public static function assertAETitle(string $title, string $label): void
    {
        $length = strlen($title);
        if ($length < 1 || $length > 16) {
            throw new \InvalidArgumentException("{$label} must be 1 to 16 characters, got {$length}.");
        }
        if ($title !== trim($title)) {
            throw new \InvalidArgumentException("{$label} must not have leading or trailing spaces.");
        }
    }
}
