<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DCMTK\Toolkit;
use DICOM\Dataset;
use DICOM\Exception\ValueExceedsReadLimitException;
use DICOM\File;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;

final class DatasetTest extends TestCase
{
    /** @var list<string> temp files to clean up */
    private array $temps = [];

    private function sample(): string
    {
        // Written by tests/generate_fixtures.py: PatientName DOE^JANE, ImageType
        // ORIGINAL\PRIMARY, Rows 512, an empty AccessionNumber, and a 16 KB
        // ICCProfile that exceeds the default +R 4 read limit.
        return __DIR__ . '/fixtures/tags_sample.dcm';
    }

    /** A writable temp copy of a fixture so committed fixtures stay untouched. */
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
        // The class default is process-wide mutable state; restore it so a test
        // that changes it cannot leak into the others.
        Dataset::configureDefaultMaxReadLengthKB(Dataset::DEFAULT_MAX_READ_LENGTH_KB);
    }

    public function testGetReadsBracketedStringValue(): void
    {
        $this->assertSame('DOE^JANE', (new Dataset($this->sample()))->get(0x0010, 0x0010));
    }

    public function testGetReadsBareNumericValue(): void
    {
        $this->assertSame('512', (new Dataset($this->sample()))->get(0x0028, 0x0010));
    }

    public function testGetPreservesMultiValueBackslashRaw(): void
    {
        $this->assertSame('ORIGINAL\PRIMARY', (new Dataset($this->sample()))->get(0x0008, 0x0008));
    }

    public function testGetReturnsEmptyStringForPresentButEmptyValue(): void
    {
        // AccessionNumber is present with zero length: a real empty value, distinct
        // from an absent tag (which returns null).
        $this->assertSame('', (new Dataset($this->sample()))->get(0x0008, 0x0050));
    }

    public function testGetReturnsNullForAbsentTag(): void
    {
        // PatientAge (0010,1010) is not in the fixture.
        $this->assertNull((new Dataset($this->sample()))->get(0x0010, 0x1010));
    }

    public function testGetThrowsValueExceedsReadLimitForOversizeValue(): void
    {
        try {
            (new Dataset($this->sample()))->get(0x0028, 0x2000);
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
        $value = (new Dataset($this->sample(), maxReadLengthKB: 64))->get(0x0028, 0x2000);
        $this->assertNotNull($value);
        $this->assertStringNotContainsString('...', $value);
        $this->assertSame(16384, substr_count($value, '00'));
    }

    public function testAllListsTopLevelTagsWithNotLoadedAsNull(): void
    {
        $tags = (new Dataset($this->sample()))->all();

        $this->assertSame('DOE^JANE', $tags['0010,0010']);
        $this->assertSame('512', $tags['0028,0010']);
        $this->assertArrayHasKey('0028,2000', $tags);
        $this->assertNull($tags['0028,2000']);
        $this->assertArrayNotHasKey('0010,1010', $tags);
    }

    public function testOneDumpServesEveryReadOnTheSameDataset(): void
    {
        $logger = new class extends AbstractLogger {
            /** @var list<array<string, mixed>> */
            public array $contexts = [];

            public function log($level, string|\Stringable $message, array $context = []): void
            {
                $this->contexts[] = $context;
            }
        };

        $dataset = new Dataset($this->sample(), new Toolkit(null, $logger));
        $dataset->get(0x0010, 0x0010);
        $dataset->get(0x0028, 0x0010);
        $dataset->all();

        $dumpRuns = array_filter(
            $logger->contexts,
            static fn (array $context): bool => ($context['tool'] ?? null) === 'dcmdump',
        );
        $this->assertCount(1, $dumpRuns);
    }

    public function testConstructRejectsMaxReadLengthBelowRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Dataset($this->sample(), maxReadLengthKB: 0);
    }

    public function testConfigureDefaultRejectsMaxReadLengthOutOfRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Dataset::configureDefaultMaxReadLengthKB(4194303);
    }

    public function testConfigureDefaultAppliesToLaterConstructionWithoutAnExplicitLimit(): void
    {
        // Raise the default to 8 KB -- still below the 16 KB value, so it remains
        // not loaded. The exception's currentLimitKB proves the configured default
        // (8), not the constant 4, was the limit applied to a Dataset built with no
        // explicit argument.
        Dataset::configureDefaultMaxReadLengthKB(8);
        try {
            (new Dataset($this->sample()))->get(0x0028, 0x2000);
            $this->fail('expected ValueExceedsReadLimitException at the 8 KB default');
        } catch (ValueExceedsReadLimitException $caught) {
            $this->assertSame(8, $caught->currentLimitKB);
            $this->assertSame(16, $caught->requiredLimitKB());
        }
    }

    public function testPutOverwritesExistingValue(): void
    {
        $dataset = new Dataset($this->tempCopyOf($this->sample()));
        $dataset->put(0x0010, 0x0010, 'NEW^NAME');

        $this->assertSame('NEW^NAME', $dataset->get(0x0010, 0x0010));
    }

    public function testPutInsertsAbsentValue(): void
    {
        $dataset = new Dataset($this->tempCopyOf($this->sample()));
        // PatientSex (0010,0040) is absent in the fixture.
        $this->assertNull($dataset->get(0x0010, 0x0040));

        $dataset->put(0x0010, 0x0040, 'F');

        $this->assertSame('F', $dataset->get(0x0010, 0x0040));
    }

    public function testPutInvalidatesTheReadCache(): void
    {
        $dataset = new Dataset($this->tempCopyOf($this->sample()));
        // Prime the cache with the original value, then overwrite and re-read: the
        // second read must reflect the write, proving the cache was invalidated.
        $this->assertSame('DOE^JANE', $dataset->get(0x0010, 0x0010));
        $dataset->put(0x0010, 0x0010, 'CHANGED^X');
        $this->assertSame('CHANGED^X', $dataset->get(0x0010, 0x0010));
    }

    public function testPutMultiValueRoundTripsRaw(): void
    {
        $dataset = new Dataset($this->tempCopyOf($this->sample()));
        $dataset->put(0x0008, 0x0008, 'DERIVED\SECONDARY');

        $this->assertSame('DERIVED\SECONDARY', $dataset->get(0x0008, 0x0008));
    }

    public function testPutOnCompressedFileLeavesTransferSyntaxAndDicomValidityIntact(): void
    {
        $temp = $this->tempCopyOf(__DIR__ . '/fixtures/jpeg_baseline.dcm');
        $dataset = new Dataset($temp);
        $before = $dataset->get(0x0002, 0x0010);

        $dataset->put(0x0010, 0x0010, 'COMPRESSED^PATIENT');

        $this->assertSame($before, $dataset->get(0x0002, 0x0010));
        $this->assertSame('COMPRESSED^PATIENT', $dataset->get(0x0010, 0x0010));
        $this->assertTrue(File::isDICOM($temp));
    }
}
