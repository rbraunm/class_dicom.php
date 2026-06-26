<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * How long each source frame is shown in an assembled video, expressed as named
 * intent rather than raw ffmpeg rates. The caller picks one mode; FrameTiming
 * computes the input rate (how fast frames are read) and, where the two differ,
 * the output rate (how fast the video plays).
 *
 * - framesPerSecond(f): a cine rate -- f source frames per second.
 * - secondsPerFrame(s): hold each source frame for s seconds (input rate 1/s).
 * - repeatEachFrame(c, fps): hold each source frame for c output frames at fps
 *   (input rate fps/c, output rate fps) -- the "frame multiplier".
 */
final class FrameTiming
{
    private function __construct(
        private readonly float $inputFramerate,
        private readonly ?float $outputFramerate,
    ) {
    }

    /** A cine rate: $framesPerSecond source frames shown per second. */
    public static function framesPerSecond(float $framesPerSecond): self
    {
        self::assertPositive($framesPerSecond, 'frames per second');

        return new self($framesPerSecond, null);
    }

    /** Hold each source frame for $secondsPerFrame seconds (e.g. 1.0 = one second each). */
    public static function secondsPerFrame(float $secondsPerFrame): self
    {
        self::assertPositive($secondsPerFrame, 'seconds per frame');

        return new self(1.0 / $secondsPerFrame, null);
    }

    /**
     * Hold each source frame for $copies output frames played at
     * $playbackFramesPerSecond -- the frame multiplier. Frames are read at
     * fps/copies and the video plays at fps, so every source frame is duplicated
     * $copies times.
     */
    public static function repeatEachFrame(int $copies, float $playbackFramesPerSecond = 24.0): self
    {
        if ($copies < 1) {
            throw new \InvalidArgumentException("Frame repeat count must be >= 1, got {$copies}.");
        }
        self::assertPositive($playbackFramesPerSecond, 'playback frames per second');

        return new self($playbackFramesPerSecond / $copies, $playbackFramesPerSecond);
    }

    /** The ffmpeg input rate (-framerate before -i): how fast frames are read. */
    public function inputFramerate(): float
    {
        return $this->inputFramerate;
    }

    /** The ffmpeg output rate (-r after -i), or null when it equals the input rate. */
    public function outputFramerate(): ?float
    {
        return $this->outputFramerate;
    }

    private static function assertPositive(float $value, string $label): void
    {
        if ($value <= 0.0) {
            throw new \InvalidArgumentException(ucfirst($label) . " must be > 0, got {$value}.");
        }
    }
}
