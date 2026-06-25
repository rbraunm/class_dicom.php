<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Value\PersonName;
use PHPUnit\Framework\TestCase;

final class ValuePersonNameTest extends TestCase
{
    public function testFiveComponentsParseAndRoundTrip(): void
    {
        $pn = PersonName::fromDICOM('Doe^Jane^Q^Dr^Jr');

        $this->assertSame('Doe', $pn->familyName);
        $this->assertSame('Jane', $pn->givenName);
        $this->assertSame('Q', $pn->middleName);
        $this->assertSame('Dr', $pn->namePrefix);
        $this->assertSame('Jr', $pn->nameSuffix);
        $this->assertSame('Doe^Jane^Q^Dr^Jr', $pn->toDICOM());
    }

    public function testTrailingEmptyComponentsAreTrimmedOnEncode(): void
    {
        $pn = PersonName::fromDICOM('Doe^Jane');

        $this->assertSame('Doe', $pn->familyName);
        $this->assertSame('Jane', $pn->givenName);
        $this->assertSame('', $pn->middleName);
        $this->assertSame('Doe^Jane', $pn->toDICOM());
    }

    public function testInternalEmptyComponentIsPreserved(): void
    {
        $pn = PersonName::fromDICOM('Doe^^Smith');

        $this->assertSame('', $pn->givenName);
        $this->assertSame('Smith', $pn->middleName);
        $this->assertSame('Doe^^Smith', $pn->toDICOM());
    }

    public function testIdeographicAndPhoneticGroupsArePreservedVerbatim(): void
    {
        $raw = 'Yamada^Tarou=YAMADA^TAROU=yamada^tarou';
        $pn = PersonName::fromDICOM($raw);

        $this->assertSame('Yamada', $pn->familyName);
        $this->assertSame('YAMADA^TAROU', $pn->ideographic);
        $this->assertSame('yamada^tarou', $pn->phonetic);
        $this->assertSame($raw, $pn->toDICOM());
    }

    public function testRejectsMoreThanFiveComponents(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        PersonName::fromDICOM('a^b^c^d^e^f');
    }
}
