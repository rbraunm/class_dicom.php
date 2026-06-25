<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Value;

/**
 * A DICOM DT (DateTime) value: a full calendar date (YYYYMMDD) with optional
 * time-of-day down to fractional seconds and an optional UTC offset (+/-HHMM).
 * Partial dates (year- or month-only) are rejected loudly rather than guessed.
 */
final class DateTime
{
    private function __construct(
        public readonly Date $date,
        public readonly ?Time $time,
        public readonly ?int $offsetMinutes,
    ) {
    }

    public static function fromDICOM(string $value): self
    {
        if (!preg_match('/^(\d{8})(\d{2}(?:\d{2}(?:\d{2}(?:\.\d{1,6})?)?)?)?([+-]\d{4})?$/', $value, $m)) {
            throw new \InvalidArgumentException(
                "Not a supported DICOM DT value (expected YYYYMMDD[HHMMSS[.FFFFFF]][+/-HHMM]): '{$value}'."
            );
        }
        $date = Date::fromDICOM($m[1]);
        $time = ($m[2] ?? '') !== '' ? Time::fromDICOM($m[2]) : null;
        $offset = null;
        if (($m[3] ?? '') !== '') {
            $sign = $m[3][0] === '-' ? -1 : 1;
            $offsetHours = (int) substr($m[3], 1, 2);
            $offsetMinutes = (int) substr($m[3], 3, 2);
            if ($offsetHours > 23 || $offsetMinutes > 59) {
                throw new \InvalidArgumentException("Invalid UTC offset in DT: '{$m[3]}'.");
            }
            $offset = $sign * ($offsetHours * 60 + $offsetMinutes);
        }

        return new self($date, $time, $offset);
    }

    public function toDICOM(): string
    {
        $out = $this->date->toDICOM();
        if ($this->time !== null) {
            $out .= $this->time->toDICOM();
        }
        if ($this->offsetMinutes !== null) {
            $sign = $this->offsetMinutes < 0 ? '-' : '+';
            $abs = abs($this->offsetMinutes);
            $out .= sprintf('%s%02d%02d', $sign, intdiv($abs, 60), $abs % 60);
        }

        return $out;
    }
}
