<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS;

/**
 * The local side of an association: the calling AE title and the four network
 * timeouts DCMTK exposes (ACSE, DIMSE, connection, socket). Each timeout is null
 * by default, meaning "leave the tool's own default in place"; set one to override
 * it. Shared by EchoSCU and SCU.
 */
final class Association
{
    public function __construct(
        private readonly string $callingAETitle = 'CLASS_DICOM',
        private readonly ?int $acseTimeoutSeconds = null,
        private readonly ?int $dimseTimeoutSeconds = null,
        private readonly ?int $connectionTimeoutSeconds = null,
        private readonly ?int $socketTimeoutSeconds = null,
    ) {
        Peer::assertAETitle($this->callingAETitle, 'Calling AE title');
        self::assertTimeout($this->acseTimeoutSeconds, 'ACSE timeout');
        self::assertTimeout($this->dimseTimeoutSeconds, 'DIMSE timeout');
        self::assertTimeout($this->connectionTimeoutSeconds, 'Connection timeout');
        self::assertTimeout($this->socketTimeoutSeconds, 'Socket timeout');
    }

    public function callingAETitle(): string
    {
        return $this->callingAETitle;
    }

    /** The calling-side option fragment: --aetitle plus any overridden timeouts. */
    public function flags(): array
    {
        $flags = ['-aet', $this->callingAETitle];
        if ($this->acseTimeoutSeconds !== null) {
            $flags[] = '-ta';
            $flags[] = (string) $this->acseTimeoutSeconds;
        }
        if ($this->dimseTimeoutSeconds !== null) {
            $flags[] = '-td';
            $flags[] = (string) $this->dimseTimeoutSeconds;
        }
        if ($this->connectionTimeoutSeconds !== null) {
            $flags[] = '-to';
            $flags[] = (string) $this->connectionTimeoutSeconds;
        }
        if ($this->socketTimeoutSeconds !== null) {
            $flags[] = '-ts';
            $flags[] = (string) $this->socketTimeoutSeconds;
        }

        return $flags;
    }

    private static function assertTimeout(?int $seconds, string $label): void
    {
        if ($seconds !== null && $seconds < 1) {
            throw new \InvalidArgumentException("{$label} must be >= 1 second when set, got {$seconds}.");
        }
    }
}
