<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Value;

/**
 * A DICOM TM (Time) value. DICOM times carry optional precision -- hour only,
 * down to fractional seconds -- so the present components are preserved and a
 * value round-trips at the precision it was stored with. Fractional seconds are
 * kept as their raw digits (1-6, no dot) for exact round-trip.
 */
final class Time
{
    private function __construct(
        public readonly int $hour,
        public readonly ?int $minute,
        public readonly ?int $second,
        public readonly ?string $fractionalSeconds,
    ) {
    }

    public static function fromDICOM(string $value): self
    {
        if (!preg_match('/^(\d{2})(?:(\d{2})(?:(\d{2})(?:\.(\d{1,6}))?)?)?$/', $value, $m)) {
            throw new \InvalidArgumentException(
                "Not a DICOM TM value (expected HH[MM[SS[.FFFFFF]]]): '{$value}'."
            );
        }
        $hour = (int) $m[1];
        $minute = ($m[2] ?? '') !== '' ? (int) $m[2] : null;
        $second = ($m[3] ?? '') !== '' ? (int) $m[3] : null;
        $fraction = ($m[4] ?? '') !== '' ? $m[4] : null;

        if ($hour > 23) {
            throw new \InvalidArgumentException("Hour out of range in TM: '{$value}'.");
        }
        if ($minute !== null && $minute > 59) {
            throw new \InvalidArgumentException("Minute out of range in TM: '{$value}'.");
        }
        if ($second !== null && $second > 60) {
            throw new \InvalidArgumentException("Second out of range in TM: '{$value}'.");
        }

        return new self($hour, $minute, $second, $fraction);
    }

    /** Fractional seconds expressed as whole microseconds, or null if absent. */
    public function microseconds(): ?int
    {
        if ($this->fractionalSeconds === null) {
            return null;
        }

        return (int) str_pad($this->fractionalSeconds, 6, '0', STR_PAD_RIGHT);
    }

    public function toDICOM(): string
    {
        $out = sprintf('%02d', $this->hour);
        if ($this->minute !== null) {
            $out .= sprintf('%02d', $this->minute);
        }
        if ($this->second !== null) {
            $out .= sprintf('%02d', $this->second);
        }
        if ($this->fractionalSeconds !== null) {
            $out .= '.' . $this->fractionalSeconds;
        }

        return $out;
    }
}
