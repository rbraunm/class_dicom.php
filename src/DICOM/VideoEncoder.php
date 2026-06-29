<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DICOM\Exception\ConversionException;

/**
 * Assembles a sequence of still frames into a video with ffmpeg. ffmpeg is not a
 * DCMTK tool and does not live under DCMTK\Toolkit (which, when pinned to a toolkit
 * directory, does not search PATH), so video assembly has its own locator here: an
 * explicit path if configured, otherwise the first ffmpeg on PATH. A missing
 * ffmpeg or a non-zero ffmpeg exit fails loud as a ConversionException -- never a
 * silent no-op.
 */
final class VideoEncoder
{
    public function __construct(private readonly ?string $ffmpegPath = null)
    {
    }

    /**
     * Assemble frames matching $framePattern (an ffmpeg input pattern such as
     * "/tmp/x/frame.%d.jpg", zero-based) into $outputPath at the given timing and
     * format. Writes $outputPath; never changes the working directory.
     *
     * @throws ConversionException ffmpeg is missing/unstartable, or it exited non-zero
     */
    public function assemble(
        string $framePattern,
        FrameTiming $timing,
        VideoFormat $format,
        string $outputPath,
    ): void {
        $ffmpeg = $this->locate();

        $argv = [
            $ffmpeg,
            '-y',
            '-framerate',
            self::rate($timing->inputFramerate()),
            '-start_number',
            '0',
            '-i',
            $framePattern,
        ];
        $argv = array_merge($argv, $format->encodingArgs());
        $outputRate = $timing->outputFramerate();
        if ($outputRate !== null) {
            $argv[] = '-r';
            $argv[] = self::rate($outputRate);
        }
        $argv[] = '-f';
        $argv[] = $format->containerFormat();
        $argv[] = $outputPath;

        [$exitCode, $stderr] = $this->run($argv);
        if ($exitCode !== 0) {
            throw new ConversionException(sprintf(
                "ffmpeg failed to assemble '%s' (exit %d): %s",
                $outputPath,
                $exitCode,
                trim($stderr),
            ));
        }
    }

    private function locate(): string
    {
        if ($this->ffmpegPath !== null) {
            if (is_file($this->ffmpegPath) && is_executable($this->ffmpegPath)) {
                return $this->ffmpegPath;
            }

            throw new ConversionException(
                "Configured ffmpeg path '{$this->ffmpegPath}' is not an executable file.",
            );
        }
        $path = getenv('PATH');
        if ($path !== false) {
            foreach (explode(PATH_SEPARATOR, $path) as $directory) {
                if ($directory === '') {
                    continue;
                }
                $candidate = rtrim($directory, '/') . '/ffmpeg';
                if (is_file($candidate) && is_executable($candidate)) {
                    return $candidate;
                }
            }
        }

        throw new ConversionException('ffmpeg was not found on PATH; install ffmpeg to assemble video.');
    }

    /**
     * @param list<string> $argv
     * @return array{int, string} exit code and captured stderr
     */
    private function run(array $argv): array
    {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = proc_open($argv, $descriptors, $pipes);
        if (!is_resource($process)) {
            throw new ConversionException('ffmpeg could not be started.');
        }
        fclose($pipes[0]);
        // Drain both streams so a full pipe cannot block ffmpeg before it exits.
        stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        return [$exitCode, $stderr === false ? '' : $stderr];
    }

    /** Compact decimal for an ffmpeg rate: "10", "0.5", "0.333333". */
    private static function rate(float $framerate): string
    {
        return rtrim(rtrim(sprintf('%.6f', $framerate), '0'), '.');
    }
}
