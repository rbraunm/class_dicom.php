<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Phase 6f: the dicom_convert multiframe_to_video shim. Verifies the v1 surface --
 * output at "{temp_dir}/{basename(file)}.{format}", mp4 only, temp_dir created if
 * missing -- plus the two contract behaviors: the deprecation notice, the
 * soften-on-marker-failure return, and the one deliberate safer-than-v1 change
 * ($framerate is honored). Authored from the v1 footprint and observed behavior,
 * never the legacy source.
 */
final class CompatDicomConvertVideoTest extends TestCase
{
    use CapturesUserNotices;

    private const MULTIFRAME = __DIR__ . '/fixtures/multiframe.dcm';

    /** @var list<string> */
    private array $tempDirs = [];

    protected function tearDown(): void
    {
        foreach ($this->tempDirs as $directory) {
            foreach (glob($directory . '/*') ?: [] as $file) {
                @unlink($file);
            }
            @rmdir($directory);
        }
        $this->tempDirs = [];
    }

    private function tempDir(bool $create = true): string
    {
        $directory = sys_get_temp_dir() . '/mfvShim' . bin2hex(random_bytes(6));
        $this->tempDirs[] = $directory;
        if ($create) {
            mkdir($directory, 0775, true);
        }

        return $directory;
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

    public function testProducesMp4AtTempDirPath(): void
    {
        $directory = $this->tempDir();
        $convert = new \dicom_convert(self::MULTIFRAME);

        $out = $this->capture(fn (): string => $convert->multiframe_to_video('mp4', 10, $directory));

        $this->assertSame($directory . '/multiframe.dcm.mp4', $out);
        $this->assertFileExists($out);
        $this->assertGreaterThan(0, filesize($out));
        $this->assertStringContainsString('ftyp', (string) file_get_contents($out, length: 64));
    }

    public function testEmitsDeprecationNotice(): void
    {
        $directory = $this->tempDir();
        $convert = new \dicom_convert(self::MULTIFRAME);

        $this->capture(fn (): string => $convert->multiframe_to_video('mp4', 10, $directory));

        $deprecations = $this->noticesOf(E_USER_DEPRECATED);
        $this->assertCount(1, $deprecations);
        $this->assertStringContainsString('multiframe_to_video()', $deprecations[0][1]);
        $this->assertStringContainsString('toVideo()', $deprecations[0][1]);
    }

    public function testHonorsFramerateUnlikeV1(): void
    {
        $convert = new \dicom_convert(self::MULTIFRAME);
        $fastDir = $this->tempDir();
        $slowDir = $this->tempDir();

        $fast = $this->capture(fn (): string => $convert->multiframe_to_video('mp4', 10, $fastDir));
        $slow = $this->capture(fn (): string => $convert->multiframe_to_video('mp4', 2, $slowDir));

        $this->assertGreaterThan(
            $this->durationSeconds($fast),
            $this->durationSeconds($slow),
            'a lower framerate should yield a longer video; v1 ignored $framerate',
        );
    }

    public function testCreatesMissingTempDir(): void
    {
        $base = $this->tempDir(create: false);
        $nested = $base . '/nested';
        $convert = new \dicom_convert(self::MULTIFRAME);

        $out = $this->capture(fn (): string => $convert->multiframe_to_video('mp4', 10, $nested));

        $this->assertDirectoryExists($nested);
        $this->assertFileExists($out);
        // Track the nested dir too so tearDown cleans it.
        $this->tempDirs[] = $nested;
    }

    public function testRejectsNonMp4Format(): void
    {
        $convert = new \dicom_convert(self::MULTIFRAME);
        $this->expectException(\InvalidArgumentException::class);
        $convert->multiframe_to_video('avi');
    }

    public function testSoftensMarkerFailureToOutputPath(): void
    {
        $directory = $this->tempDir();
        $missing = $directory . '/missing.dcm';
        $convert = new \dicom_convert($missing);

        $out = $this->capture(fn (): string => $convert->multiframe_to_video('mp4', 10, $directory));

        // The source open fails with an IOException (a DICOM marker); the contract
        // softens it to a warning and returns the v1-shaped output path.
        $this->assertSame($directory . '/missing.dcm.mp4', $out);
        $this->assertFileDoesNotExist($out);
        $this->assertCount(1, $this->noticesOf(E_USER_WARNING));
    }

    public function testDoesNotChangeWorkingDirectory(): void
    {
        $directory = $this->tempDir();
        $convert = new \dicom_convert(self::MULTIFRAME);
        $cwd = getcwd();

        $this->capture(fn (): string => $convert->multiframe_to_video('mp4', 10, $directory));

        $this->assertSame($cwd, getcwd());
    }
}
