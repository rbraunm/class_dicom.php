<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Tag;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class TagDictionaryTest extends TestCase
{
    /**
     * Known standard tags must resolve to their exact dictionary facts. These are
     * stable PS3.6 values; if the generator drifts, one of these breaks.
     *
     * @return list<array{0: Tag, 1: int, 2: int, 3: string, 4: string}>
     */
    public static function knownTags(): array
    {
        return [
            [Tag::PatientName, 0x0010, 0x0010, 'PN', '1'],
            [Tag::PatientID, 0x0010, 0x0020, 'LO', '1'],
            [Tag::StudyDate, 0x0008, 0x0020, 'DA', '1'],
            [Tag::StudyTime, 0x0008, 0x0030, 'TM', '1'],
            [Tag::Modality, 0x0008, 0x0060, 'CS', '1'],
            [Tag::InstanceNumber, 0x0020, 0x0013, 'IS', '1'],
            [Tag::RescaleSlope, 0x0028, 0x1053, 'DS', '1'],
            [Tag::SOPClassUID, 0x0008, 0x0016, 'UI', '1'],
            [Tag::Rows, 0x0028, 0x0010, 'US', '1'],
            [Tag::ImageType, 0x0008, 0x0008, 'CS', '2-n'],
        ];
    }

    #[DataProvider('knownTags')]
    public function testKnownTagResolvesToDictionaryFacts(
        Tag $tag,
        int $group,
        int $element,
        string $valueRepresentation,
        string $valueMultiplicity,
    ): void {
        $info = $tag->info();

        $this->assertSame($group, $info->group);
        $this->assertSame($element, $info->element);
        $this->assertSame($valueRepresentation, $info->valueRepresentation);
        $this->assertSame($valueMultiplicity, $info->valueMultiplicity);
    }

    public function testKeyAndPathFormatting(): void
    {
        $info = Tag::PatientName->info();

        $this->assertSame('0010,0010', $info->key());
        $this->assertSame('(0010,0010)', $info->path());
    }

    public function testValueMultiplicityDistinguishesSingleFromMulti(): void
    {
        $this->assertFalse(Tag::PatientName->info()->isMultiValued());
        $this->assertTrue(Tag::ImageType->info()->isMultiValued());
    }

    /**
     * The surface is the full standard set, not a slice. This locks the count to
     * the vendored dictionary; refreshing the dictionary updates it deliberately.
     */
    public function testCoversFullStandardDictionary(): void
    {
        $this->assertSame(4451, count(Tag::cases()));
    }

    /**
     * Every generated case must carry well-formed dictionary facts: a 16-bit
     * group and element, a two-character VR, and a non-empty VM. A malformed
     * generation would trip this for at least one case.
     */
    public function testEveryCaseHasWellFormedInfo(): void
    {
        foreach (Tag::cases() as $tag) {
            $info = $tag->info();

            $this->assertGreaterThanOrEqual(0, $info->group, $tag->name);
            $this->assertLessThanOrEqual(0xFFFF, $info->group, $tag->name);
            $this->assertGreaterThanOrEqual(0, $info->element, $tag->name);
            $this->assertLessThanOrEqual(0xFFFF, $info->element, $tag->name);
            $this->assertSame(2, strlen($info->valueRepresentation), $tag->name);
            $this->assertNotSame('', $info->valueMultiplicity, $tag->name);
        }
    }
}
