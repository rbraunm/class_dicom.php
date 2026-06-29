<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Convert;
use DICOM\Dataset;
use DICOM\File;
use DICOM\Windowing;
use PHPUnit\Framework\TestCase;

/**
 * Phase 6e: the dicom_convert creation methods. jpg_to_dcm and pdf_to_dcm are the
 * improved v2 mappings (img2dcm / pdf2dcm, which mint their own type-1 UIDs),
 * documented as improved-not-faithful; a set $template is ignored with a
 * deprecation, and pdf_to_dcmcr is a deprecated alias. Authored from the v1
 * footprint and observed behavior, never the legacy source.
 */
final class CompatDicomConvertCreateTest extends TestCase
{
    use CapturesUserNotices;

    private const TS_ENCAPSULATED_PDF = '1.2.840.10008.5.1.4.1.1.104.1';

    /** @var list<string> */
    private array $tempPaths = [];

    protected function tearDown(): void
    {
        foreach ($this->tempPaths as $path) {
            if (is_file($path)) {
                unlink($path);
            }
        }
        $this->tempPaths = [];
    }

    private function track(string $path): string
    {
        $this->tempPaths[] = $path;

        return $path;
    }

    /** Render a baseline JPEG from the windowed example image. */
    private function sourceJpeg(): string
    {
        $jpg = $this->track(tempnam(sys_get_temp_dir(), 'cv_src_') . '.jpg');
        (new Convert(File::open(__DIR__ . '/../examples/dean.dcm')))->toJPEG($jpg, Windowing::useWindow(1));

        return $jpg;
    }

    /** A copy of the example PDF in a temp location, so its .dcm output stays in tmp. */
    private function samplePdf(): string
    {
        $pdf = $this->track(tempnam(sys_get_temp_dir(), 'cv_pdf_') . '.pdf');
        copy(__DIR__ . '/../examples/pdf.pdf', $pdf);

        return $pdf;
    }

    private function tagValue(string $path, int $group, int $element): string
    {
        return (string) (new Dataset($path))->get($group, $element);
    }

    // ---- jpg_to_dcm -------------------------------------------------------------

    public function testJpgToDcmCreatesDicomAtJpgPathWithAppliedTags(): void
    {
        $jpg = $this->sourceJpeg();
        $convert = new \dicom_convert();
        $convert->jpg_file = $jpg;

        $out = $this->capture(static fn (): mixed => $convert->jpg_to_dcm([
            '0010,0010' => 'CREATE^TEST',
            '0010,0020' => 'ID-JPG-1',
        ]));
        $this->track((string) $out);

        $this->assertSame($jpg . '.dcm', $out);
        $this->assertSame('CREATE^TEST', $this->tagValue($out, 0x0010, 0x0010));
        $this->assertSame('ID-JPG-1', $this->tagValue($out, 0x0010, 0x0020));
        // No fallback/template noise on the normal path: only the method deprecation.
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
    }

    public function testJpgToDcmMintsConsistentSopInstanceUidAvoidingV1Bug(): void
    {
        $jpg = $this->sourceJpeg();
        $convert = new \dicom_convert();
        $convert->jpg_file = $jpg;

        $out = $this->capture(static fn (): mixed => $convert->jpg_to_dcm([]));
        $this->track((string) $out);

        // v1's xml2dcm path left the MetaHeader and Dataset SOPInstanceUID different;
        // img2dcm mints one consistent UID, so the two match and are non-empty.
        $metaUid = $this->tagValue($out, 0x0002, 0x0003);
        $dataUid = $this->tagValue($out, 0x0008, 0x0018);
        $this->assertNotSame('', $dataUid);
        $this->assertSame($metaUid, $dataUid);
    }

    public function testJpgToDcmDeprecatesWhenTemplateIsSet(): void
    {
        $jpg = $this->sourceJpeg();
        $convert = new \dicom_convert();
        $convert->jpg_file = $jpg;
        $convert->template = 'some_template.xml';

        $out = $this->capture(static fn (): mixed => $convert->jpg_to_dcm([]));
        $this->track((string) $out);

        $deprecations = $this->noticesOf(E_USER_DEPRECATED);
        $this->assertCount(2, $deprecations);
        $templateNotice = implode("\n", array_map(static fn (array $n): string => $n[1], $deprecations));
        $this->assertStringContainsString('template', $templateNotice);
        $this->assertStringContainsString('v3', $templateNotice);
    }

    public function testJpgToDcmSkipsMalformedTagKeyWithWarningButStillCreatesFile(): void
    {
        $jpg = $this->sourceJpeg();
        $convert = new \dicom_convert();
        $convert->jpg_file = $jpg;

        $out = $this->capture(static fn (): mixed => $convert->jpg_to_dcm([
            'not-a-key' => 'X',
            '0010,0010' => 'STILL^APPLIED',
        ]));
        $this->track((string) $out);

        $this->assertFileExists($out);
        $this->assertSame('STILL^APPLIED', $this->tagValue($out, 0x0010, 0x0010));
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
    }

    public function testJpgToDcmReturnsPathAndWarnsWhenSourceMissing(): void
    {
        $convert = new \dicom_convert();
        $convert->jpg_file = '/no/such/source.jpg';

        $out = $this->capture(static fn (): mixed => $convert->jpg_to_dcm([]));

        $this->assertSame('/no/such/source.jpg.dcm', $out);
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
        $this->assertFileDoesNotExist('/no/such/source.jpg.dcm');
    }

    // ---- pdf_to_dcm / pdf_to_dcmcr ----------------------------------------------

    public function testPdfToDcmCreatesEncapsulatedPdfWithAppliedTags(): void
    {
        $pdf = $this->samplePdf();
        $convert = new \dicom_convert($pdf);

        $out = $this->capture(static fn (): mixed => $convert->pdf_to_dcm([
            '0010,0010' => 'PDF^TEST',
        ]));
        $this->track((string) $out);

        $this->assertSame($pdf . '.dcm', $out);
        $this->assertSame(self::TS_ENCAPSULATED_PDF, $this->tagValue($out, 0x0008, 0x0016));
        $this->assertSame('PDF^TEST', $this->tagValue($out, 0x0010, 0x0010));
    }

    public function testPdfToDcmcrIsAliasEmittingItsOwnDeprecation(): void
    {
        $pdf = $this->samplePdf();
        $convert = new \dicom_convert($pdf);

        $out = $this->capture(static fn (): mixed => $convert->pdf_to_dcmcr([]));
        $this->track((string) $out);

        $this->assertSame($pdf . '.dcm', $out);
        $this->assertSame(self::TS_ENCAPSULATED_PDF, $this->tagValue($out, 0x0008, 0x0016));
        // The alias deprecation plus the underlying pdf_to_dcm deprecation.
        $this->assertCount(2, $this->noticesOf(E_USER_DEPRECATED));
    }

    // ---- properties -------------------------------------------------------------

    public function testCreationPropertyDefaults(): void
    {
        $convert = new \dicom_convert('x.pdf');

        $this->assertSame('', $convert->template);
        $this->assertSame('', $convert->temp_dir);
    }
}
