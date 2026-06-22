<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Value\Date;
use PHPUnit\Framework\TestCase;

final class ValueDateTest extends TestCase
{
    public function testParsesComponentsAndRoundTrips(): void
    {
        $d = Date::fromDICOM('20260621');

        $this->assertSame(2026, $d->year);
        $this->assertSame(6, $d->month);
        $this->assertSame(21, $d->day);
        $this->assertSame('20260621', $d->toDICOM());
        $this->assertSame('2026-06-21', $d->iso());
    }

    public function testFromYearMonthDayRoundTrips(): void
    {
        $this->assertSame('20000229', Date::fromYearMonthDay(2000, 2, 29)->toDICOM());
    }

    public function testRejectsImpossibleDate(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Date::fromDICOM('20260231');
    }

    public function testRejectsNonLeapFebruary29(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Date::fromYearMonthDay(2026, 2, 29);
    }

    public function testRejectsWrongShape(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Date::fromDICOM('2026-06-21');
    }
}
