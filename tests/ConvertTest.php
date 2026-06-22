<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Convert;
use DICOM\Exception\InvalidDICOMException;
use DICOM\File;
use DICOM\Scale;
use DICOM\Windowing;
use PHPUnit\Framework\TestCase;

final class ConvertTest extends TestCase
{
    /** @var list<string> */
    private array $temps = [];

    /** A real image: JPEG-baseline Secondary Capture that defines a VOI window. */
    private function image(): File
    {
        return File::open(__DIR__ . '/../examples/dean.dcm');
    }

    private function outPath(): string
    {
        $path = tempnam(sys_get_temp_dir(), 'jpg');
        $this->temps[] = $path;

        return $path;
    }

    protected function tearDown(): void
    {
        foreach ($this->temps as $temp) {
            @unlink($temp);
        }
        $this->temps = [];
    }

    private function assertIsJpeg(string $path): void
    {
        $this->assertFileExists($path);
        $this->assertGreaterThan(0, filesize($path), 'JPEG output is empty');
        $this->assertSame("\xFF\xD8\xFF", file_get_contents($path, length: 3), 'not a JPEG (bad SOI marker)');
    }

    public function testRendersJpegWithDefaultWindowing(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toJPEG($out);
        $this->assertIsJpeg($out);
    }

    public function testRendersWithMinMaxWindowing(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toJPEG($out, Windowing::minMax());
        $this->assertIsJpeg($out);
    }

    public function testRendersWithExplicitWindow(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toJPEG($out, Windowing::setWindow(128.0, 256.0));
        $this->assertIsJpeg($out);
    }

    public function testRendersWithNoWindowing(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toJPEG($out, Windowing::none());
        $this->assertIsJpeg($out);
    }

    public function testQualityOutOfRangeThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Convert($this->image()))->toJPEG($this->outPath(), quality: 101);
    }

    public function testUseWindowNumberBelowOneThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Windowing::useWindow(0);
    }

    public function testMissingPixelDataFailsLoud(): void
    {
        // The metadata-only fixture has no pixel data; dcmj2pnm cannot render it.
        $source = File::open(__DIR__ . '/fixtures/explicit_vr_le.dcm');

        $this->expectException(InvalidDICOMException::class);
        (new Convert($source))->toJPEG($this->outPath());
    }

    public function testAbsentRequestedWindowFailsLoud(): void
    {
        // dean.dcm defines a single VOI window; window 99 does not exist. The chosen
        // mode fails loud rather than silently falling back.
        $this->expectException(InvalidDICOMException::class);
        (new Convert($this->image()))->toJPEG($this->outPath(), Windowing::useWindow(99));
    }

    public function testDoesNotMutateWorkingDirectory(): void
    {
        // v1's multiframe path chdir'd globally and never restored it. Guard against
        // that: a conversion must leave the process cwd untouched.
        $before = getcwd();
        (new Convert($this->image()))->toJPEG($this->outPath());
        $this->assertSame($before, getcwd());
    }

    public function testThumbnailIsScaledTo125pxByDefault(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toThumbnail($out);
        $this->assertIsJpeg($out);
        $this->assertSame(125, getimagesize($out)[0]);
    }

    public function testThumbnailHonorsCustomWidth(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toThumbnail($out, widthPixels: 80);
        $this->assertSame(80, getimagesize($out)[0]);
    }

    public function testToJpegScalesWidthToRequestedPixels(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toJPEG($out, scale: Scale::widthTo(64));
        $this->assertSame(64, getimagesize($out)[0]);
    }

    public function testByFactorScalingRenders(): void
    {
        $out = $this->outPath();
        (new Convert($this->image()))->toJPEG($out, scale: Scale::byFactor(0.5));
        $this->assertIsJpeg($out);
    }

    public function testScaleWidthBelowOneThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Scale::widthTo(0);
    }

    public function testScaleByFactorNotPositiveThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Scale::byFactor(0.0);
    }
}
