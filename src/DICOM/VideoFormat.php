<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * The container and codec for an assembled video, as an option-object so further
 * formats slot in without changing toVideo's signature. Only mp4() is modelled
 * now; webm/gif/etc. fit this same shape (a file extension plus the ffmpeg
 * encoding arguments) and can be added when needed.
 */
final class VideoFormat
{
    /** @param list<string> $encodingArgs */
    private function __construct(
        private readonly string $fileExtension,
        private readonly string $containerFormat,
        private readonly array $encodingArgs,
    ) {
    }

    /** H.264 in an MP4 container, yuv420p pixel format for broad player compatibility. */
    public static function mp4(): self
    {
        return new self('mp4', 'mp4', ['-c:v', 'libx264', '-pix_fmt', 'yuv420p']);
    }

    public function fileExtension(): string
    {
        return $this->fileExtension;
    }

    /** The ffmpeg muxer name (-f), passed explicitly so output never depends on the path's extension. */
    public function containerFormat(): string
    {
        return $this->containerFormat;
    }

    /** @return list<string> ffmpeg output-encoding arguments for this format. */
    public function encodingArgs(): array
    {
        return $this->encodingArgs;
    }
}
