<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Phase 6c: the v1 dicom_tag shim. Verifies the reproduced contract -- load_tags
 * name-rendering, get_tag's lookup-only semantics, write_tags' 0-or-error-string
 * return -- against the pydicom-independent dcmdump oracle on real fixtures.
 * Authored from the v1 footprint and observed behavior, never the legacy source.
 */
final class CompatDicomTagTest extends TestCase
{
    private const UNMAPPABLE_SOP_INSTANCE_UID =
        '1.2.826.0.1.3680043.8.498.62452443424004353900021327658620487418';

    /** @var list<array{int, string}> */
    private array $captured = [];

    private string $writableCopy = '';

    protected function tearDown(): void
    {
        if ($this->writableCopy !== '' && is_file($this->writableCopy)) {
            unlink($this->writableCopy);
        }
        $this->writableCopy = '';
    }

    private function capture(callable $callable): mixed
    {
        $this->captured = [];
        set_error_handler(function (int $errno, string $message): bool {
            $this->captured[] = [$errno, $message];

            return true;
        });
        try {
            return $callable();
        } finally {
            restore_error_handler();
        }
    }

    /** @return list<array{int, string}> */
    private function noticesOf(int $type): array
    {
        return array_values(array_filter(
            $this->captured,
            static fn (array $notice): bool => $notice[0] === $type,
        ));
    }

    private function fixture(string $name): string
    {
        return __DIR__ . '/fixtures/' . $name;
    }

    private function writableFixtureCopy(string $name): string
    {
        $this->writableCopy = tempnam(sys_get_temp_dir(), 'compat_tag_') . '.dcm';
        copy($this->fixture($name), $this->writableCopy);

        return $this->writableCopy;
    }

    // ---- load_tags --------------------------------------------------------------

    public function testLoadTagsPopulatesNameRenderedTagsAndReturnsNull(): void
    {
        $tag = new \dicom_tag($this->fixture('jpeg_baseline.dcm'));

        $result = $this->capture(static fn (): mixed => $tag->load_tags());

        $this->assertNull($result);
        $this->assertSame('JPEGBaseline', $tag->tags['0002,0010']);
        $this->assertSame('SecondaryCaptureImageStorage', $tag->tags['0008,0016']);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
    }

    public function testLoadTagsRendersUnmappableUidNumerically(): void
    {
        $tag = new \dicom_tag($this->fixture('jpeg_baseline.dcm'));
        $this->capture(static fn (): mixed => $tag->load_tags());

        // SOPInstanceUID has no dictionary name; dcmdump prints it bracketed, so the
        // parse strips the brackets and the value stays the raw UID.
        $this->assertSame(self::UNMAPPABLE_SOP_INSTANCE_UID, $tag->tags['0008,0018']);
    }

    public function testLoadTagsLeavesTagsEmptyAndReturnsNullForMissingFile(): void
    {
        $tag = new \dicom_tag('/no/such/file.dcm');

        $result = $this->capture(static fn (): mixed => $tag->load_tags());

        $this->assertNull($result);
        $this->assertSame([], $tag->tags);
    }

    // ---- get_tag ----------------------------------------------------------------

    public function testGetTagReadsLoadedValueAndReturnsEmptyForMissingKey(): void
    {
        $tag = new \dicom_tag($this->fixture('explicit_vr_le.dcm'));
        $this->capture(static fn (): mixed => $tag->load_tags());

        $this->assertSame('LittleEndianExplicit', $this->capture(static fn (): string => $tag->get_tag('0002', '0010')));
        $this->assertSame('', $this->capture(static fn (): string => $tag->get_tag('9999', '9999')));
    }

    public function testGetTagReturnsEmptyBeforeLoadTagsWithoutReadingTheFile(): void
    {
        // v1's get_tag is a pure lookup: with no load_tags() call, $tags is empty
        // and every lookup returns '' even though the file is a valid DICOM.
        $tag = new \dicom_tag($this->fixture('explicit_vr_le.dcm'));

        $result = $this->capture(static fn (): string => $tag->get_tag('0002', '0010'));

        $this->assertSame('', $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
    }

    // ---- write_tags -------------------------------------------------------------

    public function testWriteTagsReturnsIntZeroOnSuccessAndPersists(): void
    {
        $path = $this->writableFixtureCopy('jpeg_baseline.dcm');
        $tag = new \dicom_tag($path);

        $result = $this->capture(static fn (): mixed => $tag->write_tags([
            '0010,0010' => 'PROBE^WRITE',
            '0010,0020' => 'ID12345',
        ]));

        $this->assertSame(0, $result);

        $reader = new \dicom_tag($path);
        $this->capture(static fn (): mixed => $reader->load_tags());
        $this->assertSame('PROBE^WRITE', $reader->tags['0010,0010']);
        $this->assertSame('ID12345', $reader->tags['0010,0020']);
    }

    public function testWriteTagsReturnsErrorStringForMissingFile(): void
    {
        $tag = new \dicom_tag('/no/such/dir/nope.dcm');

        $result = $this->capture(static fn (): mixed => $tag->write_tags(['0010,0010' => 'X']));

        $this->assertIsString($result);
        $this->assertNotSame('', $result);
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
    }

    public function testWriteTagsReturnsErrorStringForMalformedKey(): void
    {
        $path = $this->writableFixtureCopy('jpeg_baseline.dcm');
        $tag = new \dicom_tag($path);

        $result = $this->capture(static fn (): mixed => $tag->write_tags(['not-a-tag-key' => 'X']));

        $this->assertIsString($result);
        $this->assertStringContainsString('malformed', $result);
    }

    // ---- properties -------------------------------------------------------------

    public function testFilePropertyHoldsConstructorPathVerbatim(): void
    {
        $tag = new \dicom_tag('some/relative/path.dcm');

        $this->assertSame('some/relative/path.dcm', $tag->file);
        $this->assertSame([], $tag->tags);
    }
}
