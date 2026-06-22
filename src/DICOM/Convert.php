<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\ConversionException;

/**
 * Image conversion via DCMTK. An instance is constructed from a verified File and
 * renders it to an image (DICOM -> image); the static fromJpeg goes the other way
 * (image -> DICOM). Every method writes a new output file at the path it is given
 * and never mutates the process working directory.
 *
 * Operational failures are DICOM\Exception\ExceptionInterface: IOException (a
 * source vanished or could not be read), ConversionException (the toolkit refused
 * the conversion -- no pixel data, an absent VOI window, an unsupported image, or
 * mismatched multiframe dimensions), ToolkitException (the tool was missing or
 * could not start). A misuse -- an out-of-range quality, an empty image list, or a
 * single-frame SOP class with multiple frames -- raises \InvalidArgumentException.
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
     * Render the image to a baseline JPEG at $outputPath via dcmj2pnm.
     *
     * Windowing defaults to the first stored VOI window (matching v1's
     * `dcm_to_jpg`); scaling defaults to none. Pass a Windowing or Scale to choose
     * another mode. quality is the JPEG quality, 0..100.
     *
     * @throws \InvalidArgumentException quality is outside [0, 100]
     * @throws \DICOM\Exception\IOException the source vanished or became unreadable
     * @throws ConversionException the image could not be rendered (no pixel data,
     *   or the requested VOI window is absent)
     * @throws \DICOM\Exception\ToolkitException dcmj2pnm is missing or could not be started
     */
    public function toJPEG(
        string $outputPath,
        ?Windowing $windowing = null,
        int $quality = 100,
        ?Scale $scale = null,
    ): void {
        if ($quality < 0 || $quality > 100) {
            throw new \InvalidArgumentException("JPEG quality must be within [0, 100], got {$quality}.");
        }
        $windowing ??= Windowing::useWindow(1);
        $scale ??= Scale::none();
        $argv = array_merge(
            ['+oj', '+Jq', (string) $quality],
            $windowing->flags(),
            $scale->flags(),
            [$this->source->path(), $outputPath],
        );
        $result = Tool::run($this->toolkit, 'dcmj2pnm', $argv);
        if (!$result->succeeded()) {
            Tool::assertReadable($this->source->path());
            throw new ConversionException(sprintf(
                "Rendering '%s' to JPEG failed (dcmj2pnm exit %d): %s",
                $this->source->path(),
                $result->exitCode,
                trim($result->stderr),
            ));
        }
    }

    /**
     * Render a scaled-down JPEG thumbnail (v1's `dcm_to_tn`). A thin convenience
     * over toJPEG: the width is scaled to $widthPixels (aspect preserved) at a
     * lower default quality. Windowing defaults to the first stored VOI window.
     *
     * @throws \InvalidArgumentException widthPixels < 1 or quality is outside [0, 100]
     * @throws \DICOM\Exception\IOException the source vanished or became unreadable
     * @throws ConversionException the image could not be rendered
     * @throws \DICOM\Exception\ToolkitException dcmj2pnm is missing or could not be started
     */
    public function toThumbnail(
        string $outputPath,
        int $widthPixels = 125,
        int $quality = 75,
        ?Windowing $windowing = null,
    ): void {
        $this->toJPEG($outputPath, $windowing, $quality, Scale::widthTo($widthPixels));
    }

    /**
     * Create a DICOM Secondary Capture file from one or more JPEG images via
     * img2dcm, returning the opened result so attributes can be stamped on it with
     * the File tag accessors.
     *
     * A single image with the default classic Secondary Capture SOP class yields a
     * single-frame object (v1's `jpg_to_dcm`). Multiple images yield one multiframe
     * object, which requires SopClass::newSC(); the classic class cannot hold more
     * than one frame, so that combination is rejected before img2dcm is invoked.
     * The images must share dimensions for a multiframe result; img2dcm fails loud
     * (writing no output) otherwise. img2dcm invents the required type-1 attributes
     * (SOPInstanceUID and friends), so the result is well-formed without a template.
     *
     * @param list<string> $images one or more source image paths, in frame order
     *
     * @throws \InvalidArgumentException the image list is empty, an entry is not a
     *   non-empty path, or multiple images were given with a single-frame SOP class
     * @throws \DICOM\Exception\IOException a source image could not be read
     * @throws ConversionException img2dcm could not produce a DICOM (unsupported
     *   image, or mismatched multiframe dimensions)
     * @throws \DICOM\Exception\ToolkitException img2dcm is missing or could not be started
     */
    public static function fromJpeg(
        array $images,
        string $outputPath,
        ?SopClass $sopClass = null,
        ?Toolkit $toolkit = null,
    ): File {
        if ($images === []) {
            throw new \InvalidArgumentException('At least one source image is required.');
        }
        foreach ($images as $image) {
            if (!is_string($image) || $image === '') {
                throw new \InvalidArgumentException('Every source image must be a non-empty path string.');
            }
        }
        $sopClass ??= SopClass::secCapture();
        if (count($images) > 1 && !$sopClass->supportsMultipleFrames()) {
            throw new \InvalidArgumentException(
                'Multiple images require a multiframe-capable SOP class; pass SopClass::newSC().'
            );
        }
        $toolkit ??= new Toolkit();
        // img2dcm: [options] imgfile-in... dcmfile-out
        $argv = array_merge($sopClass->flags(), $images, [$outputPath]);
        $result = Tool::run($toolkit, 'img2dcm', $argv);
        if (!$result->succeeded()) {
            foreach ($images as $image) {
                Tool::assertReadable($image);
            }
            throw new ConversionException(sprintf(
                'Creating a DICOM from %d image(s) failed (img2dcm exit %d): %s',
                count($images),
                $result->exitCode,
                trim($result->stderr),
            ));
        }

        return File::open($outputPath, $toolkit);
    }
}
