<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Dataset;
use PHPUnit\Framework\TestCase;

/**
 * Phase 6d: the dicom_convert render + codec methods. Verifies the reproduced v1
 * contract -- fixed output paths, jpg_file/tn_file as outputs, the VOI window 1 ->
 * min-max fallback with its v3-removal deprecation, and the lossless-SV1 compress
 * default -- against real renders and transfer-syntax checks. Authored from the v1
 * footprint and observed behavior, never the legacy source.
 */
final class CompatDicomConvertTest extends TestCase
{
    private const TS_JPEG_LOSSLESS_SV1 = '1.2.840.10008.1.2.4.70';
    private const TS_EXPLICIT_VR_LE = '1.2.840.10008.1.2.1';

    /** @var list<array{int, string}> */
    private array $captured = [];

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

    private function track(string $path): string
    {
        $this->tempPaths[] = $path;

        return $path;
    }

    /** A renderable windowed image: examples/dean.dcm defines a VOI window. */
    private function windowedImageCopy(): string
    {
        $path = $this->track(tempnam(sys_get_temp_dir(), 'cv_win_') . '.dcm');
        copy(__DIR__ . '/../examples/dean.dcm', $path);

        return $path;
    }

    /** A renderable image with no VOI window, forcing the min-max fallback. */
    private function noWindowImageCopy(): string
    {
        $path = $this->track(tempnam(sys_get_temp_dir(), 'cv_now_') . '.dcm');
        copy(__DIR__ . '/fixtures/pixels_nowindow.dcm', $path);

        return $path;
    }

    private function compressedImageCopy(): string
    {
        $path = $this->track(tempnam(sys_get_temp_dir(), 'cv_cmp_') . '.dcm');
        copy(__DIR__ . '/fixtures/jpeg_baseline.dcm', $path);

        return $path;
    }

    private function isJpeg(string $path): bool
    {
        return is_file($path) && filesize($path) > 0 && str_starts_with((string) file_get_contents($path, length: 2), "\xFF\xD8");
    }

    private function transferSyntax(string $path): string
    {
        return (string) (new Dataset($path))->get(0x0002, 0x0010);
    }

    // ---- dcm_to_jpg -------------------------------------------------------------

    public function testDcmToJpgRendersWindowedImageWithoutFallback(): void
    {
        $source = $this->windowedImageCopy();
        $tag = new \dicom_convert($source);

        $out = $this->capture(static fn (): mixed => $tag->dcm_to_jpg());
        $this->track($out);

        $this->assertSame($source . '.jpg', $out);
        $this->assertSame($out, $tag->jpg_file);
        $this->assertTrue($this->isJpeg($out));
        // Windowed image: window 1 succeeds, so only the method deprecation fires.
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
    }

    public function testDcmToJpgFallsBackToMinMaxAndFlagsV3Removal(): void
    {
        $source = $this->noWindowImageCopy();
        $tag = new \dicom_convert($source);

        $out = $this->capture(static fn (): mixed => $tag->dcm_to_jpg());
        $this->track($out);

        $this->assertTrue($this->isJpeg($out));
        $deprecations = $this->noticesOf(E_USER_DEPRECATED);
        $this->assertCount(2, $deprecations);
        $this->assertStringContainsString('v3', $deprecations[1][1]);
        $this->assertStringContainsString('min-max', $deprecations[1][1]);
    }

    public function testDcmToJpgSetsJpgFileToOutputIgnoringAnyPresetValue(): void
    {
        $source = $this->windowedImageCopy();
        $tag = new \dicom_convert($source);
        $tag->jpg_file = '/tmp/ignored_preset.jpg';

        $out = $this->capture(static fn (): mixed => $tag->dcm_to_jpg());
        $this->track($out);

        $this->assertSame($source . '.jpg', $out);
        $this->assertSame($source . '.jpg', $tag->jpg_file);
    }

    // ---- dcm_to_tn --------------------------------------------------------------

    public function testDcmToTnRendersThumbnailToUnderscoreTnPath(): void
    {
        $source = $this->windowedImageCopy();
        $tag = new \dicom_convert($source);

        $out = $this->capture(static fn (): mixed => $tag->dcm_to_tn());
        $this->track($out);

        $this->assertSame($source . '_tn.jpg', $out);
        $this->assertSame($out, $tag->tn_file);
        $this->assertTrue($this->isJpeg($out));
    }

    public function testDcmToTnFallsBackToMinMaxAndFlagsV3Removal(): void
    {
        $source = $this->noWindowImageCopy();
        $tag = new \dicom_convert($source);

        $out = $this->capture(static fn (): mixed => $tag->dcm_to_tn());
        $this->track($out);

        $this->assertTrue($this->isJpeg($out));
        $deprecations = $this->noticesOf(E_USER_DEPRECATED);
        $this->assertCount(2, $deprecations);
        $this->assertStringContainsString('v3', $deprecations[1][1]);
    }

    // ---- compress / uncompress --------------------------------------------------

    public function testCompressOverwritesInPlaceWithLosslessSV1(): void
    {
        $source = $this->noWindowImageCopy();
        $tag = new \dicom_convert($source);

        $out = $this->capture(static fn (): mixed => $tag->compress());

        $this->assertSame($source, $out);
        $this->assertSame(self::TS_JPEG_LOSSLESS_SV1, $this->transferSyntax($source));
    }

    public function testCompressWritesToNewFileLeavingSourceUntouched(): void
    {
        $source = $this->noWindowImageCopy();
        $target = $this->track(tempnam(sys_get_temp_dir(), 'cv_out_') . '.dcm');
        $tag = new \dicom_convert($source);

        $out = $this->capture(static fn (): mixed => $tag->compress($target));

        $this->assertSame($target, $out);
        $this->assertSame(self::TS_JPEG_LOSSLESS_SV1, $this->transferSyntax($target));
        $this->assertSame(self::TS_EXPLICIT_VR_LE, $this->transferSyntax($source));
    }

    public function testUncompressProducesUncompressedTransferSyntax(): void
    {
        $source = $this->compressedImageCopy();
        $target = $this->track(tempnam(sys_get_temp_dir(), 'cv_unc_') . '.dcm');
        $tag = new \dicom_convert($source);

        $out = $this->capture(static fn (): mixed => $tag->uncompress($target));

        $this->assertSame($target, $out);
        $this->assertSame(self::TS_EXPLICIT_VR_LE, $this->transferSyntax($target));
    }

    public function testCompressReturnsOutputPathAndWarnsOnFailure(): void
    {
        $tag = new \dicom_convert('/no/such/dir/missing.dcm');

        $out = $this->capture(static fn (): mixed => $tag->compress('/tmp/never_written.dcm'));

        $this->assertSame('/tmp/never_written.dcm', $out);
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
        $this->assertFileDoesNotExist('/tmp/never_written.dcm');
    }

    // ---- properties -------------------------------------------------------------

    public function testPropertyDefaults(): void
    {
        $tag = new \dicom_convert('some/path.dcm');

        $this->assertSame('some/path.dcm', $tag->file);
        $this->assertSame(100, $tag->jpg_quality);
        $this->assertSame(125, $tag->tn_size);
        $this->assertSame('', $tag->jpg_file);
        $this->assertSame('', $tag->tn_file);
    }
}
