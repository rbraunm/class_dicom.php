<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Value\Time;
use PHPUnit\Framework\TestCase;

final class ValueTimeTest extends TestCase
{
    public function testFullPrecisionRoundTrips(): void
    {
        $t = Time::fromDICOM('143005');

        $this->assertSame(14, $t->hour);
        $this->assertSame(30, $t->minute);
        $this->assertSame(5, $t->second);
        $this->assertNull($t->fractionalSeconds);
        $this->assertSame('143005', $t->toDICOM());
    }

    public function testPartialPrecisionPreservesPresentComponents(): void
    {
        $t = Time::fromDICOM('1430');

        $this->assertSame(14, $t->hour);
        $this->assertSame(30, $t->minute);
        $this->assertNull($t->second);
        $this->assertSame('1430', $t->toDICOM());
    }

    public function testFractionalSecondsRoundTripExactlyAndConvertToMicroseconds(): void
    {
        $t = Time::fromDICOM('143005.250');

        $this->assertSame('250', $t->fractionalSeconds);
        $this->assertSame(250000, $t->microseconds());
        $this->assertSame('143005.250', $t->toDICOM());
    }

    public function testRejectsMinuteOutOfRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Time::fromDICOM('1460');
    }

    public function testRejectsColonSeparated(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Time::fromDICOM('14:30');
    }
}
