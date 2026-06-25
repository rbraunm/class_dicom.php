<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Dataset;
use DICOM\Exception\InvalidDICOMException;
use DICOM\File;
use DICOM\Tag;
use DICOM\Value\Date;
use DICOM\Value\PersonName;
use DICOM\Value\Time;
use DICOM\Value\UID;
use PHPUnit\Framework\TestCase;

final class FileTypedTest extends TestCase
{
    /** @var list<string> */
    private array $temps = [];

    private function sample(): string
    {
        // PatientName DOE^JANE, ImageType ORIGINAL\PRIMARY (multi), Rows 512.
        return __DIR__ . '/fixtures/tags_sample.dcm';
    }

    private function explicitLe(): string
    {
        return __DIR__ . '/fixtures/explicit_vr_le.dcm';
    }

    private function tempCopyOf(string $fixture): string
    {
        $temp = tempnam(sys_get_temp_dir(), 'dcm');
        copy($fixture, $temp);
        $this->temps[] = $temp;

        return $temp;
    }

    protected function tearDown(): void
    {
        foreach ($this->temps as $temp) {
            @unlink($temp);
        }
        $this->temps = [];
    }

    // ---- typed reads off pydicom-written fixtures ----

    public function testGetPersonNameReturnsTypedComponents(): void
    {
        $pn = File::open($this->sample())->getPersonName(Tag::PatientName);

        $this->assertInstanceOf(PersonName::class, $pn);
        $this->assertSame('DOE', $pn->familyName);
        $this->assertSame('JANE', $pn->givenName);
    }

    public function testGetIntegerReturnsInt(): void
    {
        $rows = File::open($this->sample())->getInteger(Tag::Rows);

        $this->assertSame(512, $rows);
    }

    public function testGetUIDReturnsTypedUID(): void
    {
        $uid = File::open($this->explicitLe())->getUID(Tag::SOPClassUID);

        $this->assertInstanceOf(UID::class, $uid);
        $this->assertSame('1.2.840.10008.5.1.4.1.1.7', $uid->value);
    }

    public function testGetTextListSplitsMultiValue(): void
    {
        $imageType = File::open($this->sample())->getTextList(Tag::ImageType);

        $this->assertSame(['ORIGINAL', 'PRIMARY'], $imageType);
    }

    public function testGetReturnsNullForAbsentTag(): void
    {
        // StudyDate is not in the sample fixture.
        $this->assertNull(File::open($this->sample())->getDate(Tag::StudyDate));
    }

    // ---- typed write round-trips ----

    public function testDateRoundTrips(): void
    {
        $file = File::open($this->tempCopyOf($this->sample()));
        $file->setDate(Tag::StudyDate, Date::fromYearMonthDay(2026, 6, 21));

        $this->assertSame('2026-06-21', $file->getDate(Tag::StudyDate)->iso());
    }

    public function testPersonNameRoundTrips(): void
    {
        $file = File::open($this->tempCopyOf($this->sample()));
        $file->setPersonName(Tag::PatientName, new PersonName('Roe', 'Mary'));

        $pn = $file->getPersonName(Tag::PatientName);
        $this->assertSame('Roe', $pn->familyName);
        $this->assertSame('Mary', $pn->givenName);
    }

    public function testIntegerRoundTrips(): void
    {
        $file = File::open($this->tempCopyOf($this->sample()));
        $file->setInteger(Tag::Rows, 256);

        $this->assertSame(256, $file->getInteger(Tag::Rows));
    }

    public function testDecimalRoundTrips(): void
    {
        $file = File::open($this->tempCopyOf($this->sample()));
        $file->setDecimal(Tag::RescaleSlope, 2.5);

        $this->assertSame(2.5, $file->getDecimal(Tag::RescaleSlope));
    }

    public function testTimeRoundTrips(): void
    {
        $file = File::open($this->tempCopyOf($this->sample()));
        $file->setTime(Tag::StudyTime, Time::fromDICOM('143005'));

        $this->assertSame('143005', $file->getTime(Tag::StudyTime)->toDICOM());
    }

    public function testTextListRoundTrips(): void
    {
        $file = File::open($this->tempCopyOf($this->sample()));
        $file->setTextList(Tag::ImageType, ['DERIVED', 'SECONDARY']);

        $this->assertSame(['DERIVED', 'SECONDARY'], $file->getTextList(Tag::ImageType));
    }

    // ---- the VR gate: wrong accessor for the tag, before any tool runs ----

    public function testReadingADateTagAsIntegerThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        File::open($this->sample())->getInteger(Tag::StudyDate);
    }

    public function testWritingAnIntegerTagAsTextThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        File::open($this->tempCopyOf($this->sample()))->setText(Tag::Rows, 'not-an-int');
    }

    // ---- single accessor on a multi-valued element fails loud ----

    public function testSingleAccessorOnMultiValuedElementThrows(): void
    {
        // ImageType is ORIGINAL\PRIMARY; getText reads a single value.
        $this->expectException(\InvalidArgumentException::class);
        File::open($this->sample())->getText(Tag::ImageType);
    }

    // ---- a malformed stored value elevates to InvalidDICOMException ----

    public function testMalformedStoredDateElevatesToInvalidDicom(): void
    {
        $temp = $this->tempCopyOf($this->sample());
        // Inject a value that is not a valid DA via the raw route.
        (new Dataset($temp))->put(0x0008, 0x0020, 'NOTADATE');

        $this->expectException(InvalidDICOMException::class);
        File::open($temp)->getDate(Tag::StudyDate);
    }

    // ---- writes on a compressed file leave it valid and same-syntax ----

    public function testTypedWriteOnCompressedFileLeavesItValid(): void
    {
        $temp = $this->tempCopyOf(__DIR__ . '/fixtures/jpeg_baseline.dcm');
        $file = File::open($temp);
        $before = $file->transferSyntaxUID();

        $file->setPersonName(Tag::PatientName, new PersonName('Comp', 'Patient'));

        $this->assertSame($before, $file->transferSyntaxUID());
        $this->assertSame('Comp', $file->getPersonName(Tag::PatientName)->familyName);
        $this->assertTrue(File::isDICOM($temp));
    }
}
