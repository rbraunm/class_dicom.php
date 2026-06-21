<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DCMTK\Toolkit;
use DICOM\Exception\ValueExceedsReadLimitException;
use DICOM\File;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;

final class FileTagTest extends TestCase
{
    private function sample(): string
    {
        // Written by tests/generate_fixtures.py: PatientName DOE^JANE, ImageType
        // ORIGINAL\PRIMARY, Rows 512, an empty AccessionNumber, and a 16 KB
        // ICCProfile that exceeds the default +R 4 read limit.
        return __DIR__ . '/fixtures/tags_sample.dcm';
    }

    protected function tearDown(): void
    {
        // The class default is process-wide mutable state; restore it so a test
        // that changes it cannot leak into the others.
        File::configureDefaultMaxReadLengthKB(File::DEFAULT_MAX_READ_LENGTH_KB);
    }

    public function testTagReadsBracketedStringValue(): void
    {
        $this->assertSame('DOE^JANE', File::open($this->sample())->tag(0x0010, 0x0010));
    }

    public function testTagReadsBareNumericValue(): void
    {
        $this->assertSame('512', File::open($this->sample())->tag(0x0028, 0x0010));
    }

    public function testTagPreservesMultiValueBackslashRaw(): void
    {
        // Components stay backslash-separated; splitting is the typed layer's job.
        $this->assertSame('ORIGINAL\PRIMARY', File::open($this->sample())->tag(0x0008, 0x0008));
    }

    public function testTagReturnsEmptyStringForPresentButEmptyValue(): void
    {
        // AccessionNumber is present with zero length: a real empty value, distinct
        // from an absent tag (which returns null).
        $this->assertSame('', File::open($this->sample())->tag(0x0008, 0x0050));
    }

    public function testTagReturnsNullForAbsentTag(): void
    {
        // PatientAge (0010,1010) is not in the fixture.
        $this->assertNull(File::open($this->sample())->tag(0x0010, 0x1010));
    }

    public function testTagThrowsValueExceedsReadLimitForOversizeValue(): void
    {
        // ICCProfile is 16 KB, above the default +R 4, so it is not loaded.
        try {
            File::open($this->sample())->tag(0x0028, 0x2000);
            $this->fail('expected ValueExceedsReadLimitException for the 16 KB value');
        } catch (ValueExceedsReadLimitException $caught) {
            $this->assertSame('0028,2000', $caught->tag);
            $this->assertSame(16384, $caught->valueLengthBytes);
            $this->assertSame(4, $caught->currentLimitKB);
            $this->assertSame(16, $caught->requiredLimitKB());
        }
    }

    public function testRaisingTheLimitLoadsTheValueInFull(): void
    {
        // +R 64 lifts the limit above the 16 KB ICCProfile so it loads, and +L
        // makes dcmdump print it completely. The fixture's value is 16384 zero
        // bytes, rendered as backslash-separated "00" octets, so a complete read
        // contains exactly one "00" per byte and no truncation marker.
        $value = File::open($this->sample(), maxReadLengthKB: 64)->tag(0x0028, 0x2000);
        $this->assertNotNull($value);
        $this->assertStringNotContainsString('...', $value);
        $this->assertSame(16384, substr_count($value, '00'));
    }

    public function testTagsListsTopLevelTagsWithNotAvailableAsNull(): void
    {
        $tags = File::open($this->sample())->tags();

        $this->assertSame('DOE^JANE', $tags['0010,0010']);
        $this->assertSame('512', $tags['0028,0010']);
        // The oversize ICCProfile is listed but rendered null (present, not loaded).
        $this->assertArrayHasKey('0028,2000', $tags);
        $this->assertNull($tags['0028,2000']);
        // An absent tag is simply not a key.
        $this->assertArrayNotHasKey('0010,1010', $tags);
    }

    public function testUidAccessorsReadThroughTheTagCache(): void
    {
        $file = File::open($this->sample());
        $this->assertSame('1.2.840.10008.1.2.1', $file->transferSyntaxUID());
        $this->assertSame('1.2.840.10008.5.1.4.1.1.7', $file->mediaStorageSOPClassUID());
    }

    public function testOneDumpServesEveryReadOnTheSameFile(): void
    {
        $logger = new class extends AbstractLogger {
            /** @var list<array<string, mixed>> */
            public array $contexts = [];

            public function log($level, string|\Stringable $message, array $context = []): void
            {
                $this->contexts[] = $context;
            }
        };

        $file = File::open($this->sample(), new Toolkit(null, $logger));
        $file->tag(0x0010, 0x0010);
        $file->tag(0x0028, 0x0010);
        $file->transferSyntaxUID();
        $file->tags();

        $dumpRuns = array_filter(
            $logger->contexts,
            static fn (array $context): bool => ($context['tool'] ?? null) === 'dcmdump',
        );
        $this->assertCount(1, $dumpRuns);
    }

    public function testOpenRejectsMaxReadLengthBelowRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        File::open($this->sample(), maxReadLengthKB: 0);
    }

    public function testConfigureDefaultRejectsMaxReadLengthOutOfRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        File::configureDefaultMaxReadLengthKB(4194303);
    }

    public function testConfigureDefaultAppliesToLaterOpensWithoutAnExplicitLimit(): void
    {
        // Raise the default to 8 KB -- still below the 16 KB value, so it remains
        // not loaded and reliably throws regardless of dcmdump's display behavior.
        // The exception's currentLimitKB proves the configured default (8), not the
        // constant 4, was the limit applied to an open() with no explicit argument.
        File::configureDefaultMaxReadLengthKB(8);
        try {
            File::open($this->sample())->tag(0x0028, 0x2000);
            $this->fail('expected ValueExceedsReadLimitException at the 8 KB default');
        } catch (ValueExceedsReadLimitException $caught) {
            $this->assertSame(8, $caught->currentLimitKB);
            $this->assertSame(16, $caught->requiredLimitKB());
        }
    }
}
