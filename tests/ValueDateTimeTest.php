<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Value\DateTime;
use PHPUnit\Framework\TestCase;

final class ValueDateTimeTest extends TestCase
{
    public function testDateOnlyHasNoTimeOrOffset(): void
    {
        $dt = DateTime::fromDICOM('20260621');

        $this->assertSame(2026, $dt->date->year);
        $this->assertNull($dt->time);
        $this->assertNull($dt->offsetMinutes);
        $this->assertSame('20260621', $dt->toDICOM());
    }

    public function testFullDateTimeRoundTrips(): void
    {
        $dt = DateTime::fromDICOM('20260621143005');

        $this->assertSame(14, $dt->time->hour);
        $this->assertSame(5, $dt->time->second);
        $this->assertSame('20260621143005', $dt->toDICOM());
    }

    public function testPositiveOffsetParsesToMinutesAndRoundTrips(): void
    {
        $dt = DateTime::fromDICOM('20260621143005+0530');

        $this->assertSame(330, $dt->offsetMinutes);
        $this->assertSame('20260621143005+0530', $dt->toDICOM());
    }

    public function testNegativeOffsetRoundTrips(): void
    {
        $dt = DateTime::fromDICOM('20260621143005-0500');

        $this->assertSame(-300, $dt->offsetMinutes);
        $this->assertSame('20260621143005-0500', $dt->toDICOM());
    }

    public function testRejectsPartialYearOnlyDate(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        DateTime::fromDICOM('2026');
    }
}
