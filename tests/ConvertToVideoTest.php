<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Convert;
use DICOM\Exception\ConversionException;
use DICOM\File;
use DICOM\FrameTiming;
use DICOM\VideoEncoder;
use DICOM\VideoFormat;
use DICOM\Windowing;
use PHPUnit\Framework\TestCase;

final class ConvertToVideoTest extends TestCase
{
    /** @var list<string> */
    private array $temps = [];

    /** An 8-frame MONOCHROME2 image with a VOI window. */
    private function multiframe(): File
    {
        return File::open(__DIR__ . '/fixtures/multiframe.dcm');
    }

    private function outPath(): string
    {
        $path = tempnam(sys_get_temp_dir(), 'mp4');
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

    private function assertIsMp4(string $path): void
    {
        $this->assertFileExists($path);
        $this->assertGreaterThan(0, filesize($path), 'video output is empty');
        $head = (string) file_get_contents($path, length: 64);
        $this->assertStringContainsString('ftyp', $head, 'not an MP4 (no ftyp box)');
    }

    private function frameCount(string $path): int
    {
        $output = [];
        exec(
            'ffprobe -v error -count_frames -select_streams v:0 '
            . '-show_entries stream=nb_read_frames -of csv=p=0 ' . escapeshellarg($path),
            $output,
        );

        return (int) trim(implode('', $output));
    }

    private function durationSeconds(string $path): float
    {
        $output = [];
        exec(
            'ffprobe -v error -show_entries format=duration -of csv=p=0 ' . escapeshellarg($path),
            $output,
        );

        return (float) trim(implode('', $output));
    }

    public function testFrameTimingFramesPerSecond(): void
    {
        $timing = FrameTiming::framesPerSecond(10.0);
        $this->assertSame(10.0, $timing->inputFramerate());
        $this->assertNull($timing->outputFramerate());
    }

    public function testFrameTimingSecondsPerFrame(): void
    {
        $timing = FrameTiming::secondsPerFrame(2.0);
        $this->assertSame(0.5, $timing->inputFramerate());
        $this->assertNull($timing->outputFramerate());
    }

    public function testFrameTimingRepeatEachFrame(): void
    {
        $timing = FrameTiming::repeatEachFrame(3, 24.0);
        $this->assertSame(8.0, $timing->inputFramerate());
        $this->assertSame(24.0, $timing->outputFramerate());
    }

    public function testFrameTimingRejectsNonPositiveFramesPerSecond(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        FrameTiming::framesPerSecond(0.0);
    }

    public function testFrameTimingRejectsNonPositiveSecondsPerFrame(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        FrameTiming::secondsPerFrame(-1.0);
    }

    public function testFrameTimingRejectsZeroRepeatCount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        FrameTiming::repeatEachFrame(0);
    }

    public function testVideoFormatMp4(): void
    {
        $format = VideoFormat::mp4();
        $this->assertSame('mp4', $format->fileExtension());
        $this->assertContains('libx264', $format->encodingArgs());
        $this->assertContains('yuv420p', $format->encodingArgs());
    }

    public function testToVideoProducesPlayableMp4(): void
    {
        $out = $this->outPath();
        (new Convert($this->multiframe()))->toVideo($out);
        $this->assertIsMp4($out);
        // One output frame per source frame at the default cine rate.
        $this->assertSame(8, $this->frameCount($out));
    }

    public function testFrameMultiplierDuplicatesFrames(): void
    {
        $out = $this->outPath();
        (new Convert($this->multiframe()))->toVideo($out, FrameTiming::repeatEachFrame(3, 24.0));
        $this->assertIsMp4($out);
        // Eight source frames held three output frames each.
        $this->assertSame(24, $this->frameCount($out));
    }

    public function testSecondsPerFrameLengthensTheVideo(): void
    {
        $fast = $this->outPath();
        $slow = $this->outPath();
        $convert = new Convert($this->multiframe());
        $convert->toVideo($fast, FrameTiming::framesPerSecond(10.0));
        $convert->toVideo($slow, FrameTiming::secondsPerFrame(1.0));
        $this->assertGreaterThan(
            $this->durationSeconds($fast),
            $this->durationSeconds($slow),
            'holding each frame one second should outlast a ten-per-second cine rate',
        );
    }

    public function testToVideoAcceptsExplicitWindowing(): void
    {
        $out = $this->outPath();
        (new Convert($this->multiframe()))->toVideo($out, windowing: Windowing::minMax());
        $this->assertIsMp4($out);
    }

    public function testToVideoRejectsOutOfRangeQuality(): void
    {
        $out = $this->outPath();
        $this->expectException(\InvalidArgumentException::class);
        (new Convert($this->multiframe()))->toVideo($out, quality: 101);
    }

    public function testVideoEncoderFailsLoudWhenFfmpegMissing(): void
    {
        $encoder = new VideoEncoder('/no/such/ffmpeg');
        $this->expectException(ConversionException::class);
        $encoder->assemble('frame.%d.jpg', FrameTiming::framesPerSecond(10.0), VideoFormat::mp4(), $this->outPath());
    }

    public function testToVideoCleansUpTemporaryFrames(): void
    {
        $glob = sys_get_temp_dir() . '/dicomVideo*';
        $before = glob($glob) ?: [];
        (new Convert($this->multiframe()))->toVideo($this->outPath());
        $after = glob($glob) ?: [];
        $this->assertSame(count($before), count($after), 'toVideo left temporary frame directories behind');
    }

    public function testToVideoDoesNotChangeWorkingDirectory(): void
    {
        $cwd = getcwd();
        (new Convert($this->multiframe()))->toVideo($this->outPath());
        $this->assertSame($cwd, getcwd());
    }
}
