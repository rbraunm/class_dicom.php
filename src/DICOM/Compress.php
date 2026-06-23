<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\ConversionException;

/**
 * Transfer-syntax compression and decompression of a DICOM file via DCMTK.
 * Constructed from a verified source File; each method writes a new output file at
 * the path it is given, never mutates the process working directory, and returns
 * the opened result so it can be inspected or tagged further.
 *
 * Scope is JPEG, matching v1: compress wraps dcmcjpeg and decompress wraps
 * dcmdjpeg. JPEG 2000 is not available in this DCMTK build and is a recorded gap.
 * Operational failures are DICOM\Exception\ExceptionInterface: IOException (the
 * source could not be read), ConversionException (the toolkit refused -- e.g. no
 * pixel data to (de)compress), ToolkitException (the tool was missing or could not
 * start).
 */
final class Compress
{
    private readonly Toolkit $toolkit;

    public function __construct(
        private readonly File $source,
        ?Toolkit $toolkit = null,
    ) {
        $this->toolkit = $toolkit ?? new Toolkit();
    }

    /**
     * Compress the pixel data to a JPEG transfer syntax via dcmcjpeg, returning the
     * opened result. The process defaults to lossless SV1, matching v1 (which is
     * also dcmcjpeg's own default).
     *
     * @throws \InvalidArgumentException a lossy quality is outside [0, 100]
     * @throws \DICOM\Exception\IOException the source vanished or became unreadable
     * @throws ConversionException dcmcjpeg refused the input (e.g. no pixel data)
     * @throws \DICOM\Exception\ToolkitException dcmcjpeg is missing or could not be started
     */
    public function compress(string $outputPath, ?Compression $mode = null): File
    {
        $mode ??= Compression::losslessSV1();
        $argv = array_merge($mode->flags(), [$this->source->path(), $outputPath]);
        $result = Tool::run($this->toolkit, 'dcmcjpeg', $argv);
        if (!$result->succeeded()) {
            Tool::assertReadable($this->source->path());
            throw new ConversionException(sprintf(
                "Compressing '%s' failed (dcmcjpeg exit %d): %s",
                $this->source->path(),
                $result->exitCode,
                trim($result->stderr),
            ));
        }

        return File::open($outputPath, $this->toolkit);
    }

    /**
     * Decompress the pixel data via dcmdjpeg, returning the opened result. The
     * output is uncompressed Explicit VR Little Endian (dcmdjpeg's default); there
     * is nothing to choose, so there is no mode parameter.
     *
     * @throws \DICOM\Exception\IOException the source vanished or became unreadable
     * @throws ConversionException dcmdjpeg refused the input (e.g. not compressed,
     *   or no pixel data)
     * @throws \DICOM\Exception\ToolkitException dcmdjpeg is missing or could not be started
     */
    public function decompress(string $outputPath): File
    {
        $result = Tool::run($this->toolkit, 'dcmdjpeg', [$this->source->path(), $outputPath]);
        if (!$result->succeeded()) {
            Tool::assertReadable($this->source->path());
            throw new ConversionException(sprintf(
                "Decompressing '%s' failed (dcmdjpeg exit %d): %s",
                $this->source->path(),
                $result->exitCode,
                trim($result->stderr),
            ));
        }

        return File::open($outputPath, $this->toolkit);
    }
}
