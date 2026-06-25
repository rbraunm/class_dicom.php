<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Value;

/**
 * A DICOM DA (Date) value: a calendar date, no time component (YYYYMMDD on the
 * wire). Construction validates the date; an impossible date fails loudly.
 */
final class Date
{
    private function __construct(
        public readonly int $year,
        public readonly int $month,
        public readonly int $day,
    ) {
    }

    public static function fromDICOM(string $value): self
    {
        if (!preg_match('/^(\d{4})(\d{2})(\d{2})$/', $value, $m)) {
            throw new \InvalidArgumentException("Not a DICOM DA value (expected YYYYMMDD): '{$value}'.");
        }

        return self::fromYearMonthDay((int) $m[1], (int) $m[2], (int) $m[3]);
    }

    public static function fromYearMonthDay(int $year, int $month, int $day): self
    {
        if (!checkdate($month, $day, $year)) {
            throw new \InvalidArgumentException(sprintf('Not a valid date: %04d-%02d-%02d.', $year, $month, $day));
        }

        return new self($year, $month, $day);
    }

    public function toDICOM(): string
    {
        return sprintf('%04d%02d%02d', $this->year, $this->month, $this->day);
    }

    public function iso(): string
    {
        return sprintf('%04d-%02d-%02d', $this->year, $this->month, $this->day);
    }
}
