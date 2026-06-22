<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\InvalidDICOMException;

/**
 * Image conversion of a DICOM file via DCMTK. Constructed from a verified File;
 * each method writes a new output file at the path it is given and never mutates
 * the process working directory.
 *
 * Operational failures are DICOM\Exception\ExceptionInterface: IOException (the
 * source vanished), InvalidDICOMException (the image could not be rendered -- no
 * pixel data, or the requested VOI window is absent), ToolkitException (dcmj2pnm
 * missing or could not start). A misuse -- an out-of-range quality -- raises
 * \InvalidArgumentException.
 */
final class Convert
{
    private readonly Toolkit $toolkit;

    public function __construct(
        private readonly File $source,
        ?Toolkit $toolkit = null,
    ) {
        $this->toolkit = $toolkit ?? new Toolkit();
    }

    /**
     * Render the image to a baseline JPEG at $outputPath via dcmj2pnm. Windowing
     * defaults to the first stored VOI window (matching v1's `dcm_to_jpg`); pass a
     * Windowing to choose another mode. quality is the JPEG quality, 0..100.
     *
     * @throws \InvalidArgumentException quality is outside [0, 100]
     * @throws \DICOM\Exception\IOException the source vanished or became unreadable
     * @throws InvalidDICOMException the image could not be rendered (no pixel data,
     *   or the requested VOI window is absent)
     * @throws \DICOM\Exception\ToolkitException dcmj2pnm is missing or could not be started
     */
    public function toJPEG(string $outputPath, ?Windowing $windowing = null, int $quality = 100): void
    {
        if ($quality < 0 || $quality > 100) {
            throw new \InvalidArgumentException("JPEG quality must be within [0, 100], got {$quality}.");
        }
        $windowing ??= Windowing::useWindow(1);
        $argv = array_merge(
            ['+oj', '+Jq', (string) $quality],
            $windowing->flags(),
            [$this->source->path(), $outputPath],
        );
        $result = Tool::run($this->toolkit, 'dcmj2pnm', $argv);
        if (!$result->succeeded()) {
            Tool::assertReadable($this->source->path());
            throw new InvalidDICOMException(sprintf(
                "Rendering '%s' to JPEG failed (dcmj2pnm exit %d): %s",
                $this->source->path(),
                $result->exitCode,
                trim($result->stderr),
            ));
        }
    }
}
