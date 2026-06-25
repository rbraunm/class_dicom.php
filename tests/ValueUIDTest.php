<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Value\UID;
use PHPUnit\Framework\TestCase;

final class ValueUIDTest extends TestCase
{
    public function testValidUIDRoundTrips(): void
    {
        $uid = UID::fromDICOM('1.2.840.10008.1.2.1');

        $this->assertSame('1.2.840.10008.1.2.1', $uid->value);
        $this->assertSame('1.2.840.10008.1.2.1', $uid->toDICOM());
    }

    public function testRejectsNonNumericComponent(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        UID::fromDICOM('1.2.x.4');
    }

    public function testRejectsTrailingDot(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        UID::fromDICOM('1.2.840.');
    }

    public function testRejectsLeadingZeroComponent(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        UID::fromDICOM('1.02.3');
    }

    public function testRejectsOverLongUID(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        UID::fromDICOM(str_repeat('1', 65));
    }
}
