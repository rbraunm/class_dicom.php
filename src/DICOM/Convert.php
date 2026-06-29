<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\ConversionException;

/**
 * Image conversion via DCMTK. An instance is constructed from a verified File and
 * renders it to an image (DICOM -> image) or assembles its frames into a video
 * with ffmpeg (toVideo); the static fromJpeg goes the other way (image -> DICOM).
 * Every method writes a new output file at the path it is given and never mutates
 * the process working directory.
 *
 * Operational failures are DICOM\Exception\ExceptionInterface: IOException (a
 * source vanished or could not be read), ConversionException (the toolkit refused
 * the conversion -- no pixel data, an absent VOI window, an unsupported image,
 * mismatched multiframe dimensions, or ffmpeg missing or failing to assemble the
 * video), ToolkitException (the tool was missing or could not start). A misuse --
 * an out-of-range quality, an empty image list, or a single-frame SOP class with
 * multiple frames -- raises \InvalidArgumentException.
 */
final class Convert
{
    private readonly Toolkit $toolkit;
    private readonly VideoEncoder $videoEncoder;

    public function __construct(
        private readonly File $source,
        ?Toolkit $toolkit = null,
        ?VideoEncoder $videoEncoder = null,
    ) {
        $this->toolkit = $toolkit ?? new Toolkit();
        $this->videoEncoder = $videoEncoder ?? new VideoEncoder();
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
     * Render every frame of the (possibly multiframe) image to a sequence of
     * baseline JPEG files via dcmj2pnm, returning the created paths in frame order.
     *
     * Each frame is written to "{outputPathPrefix}.{index}.jpg" (zero-based) -- the
     * naming dcmj2pnm produces under all-frames extraction. A single-frame object
     * yields one file, "{outputPathPrefix}.0.jpg". Windowing, scaling, and quality
     * behave as in toJPEG and apply uniformly to every frame. To assemble the
     * frames into a video, use toVideo(), which builds on this method.
     *
     * @return list<string> the created frame file paths, in frame order
     *
     * @throws \InvalidArgumentException quality is outside [0, 100]
     * @throws \DICOM\Exception\IOException the source vanished or became unreadable
     * @throws ConversionException a frame could not be rendered, or an expected
     *   frame file was not produced
     * @throws \DICOM\Exception\ToolkitException dcmj2pnm is missing or could not be started
     */
    public function toJpegFrames(
        string $outputPathPrefix,
        ?Windowing $windowing = null,
        int $quality = 100,
        ?Scale $scale = null,
    ): array {
        if ($quality < 0 || $quality > 100) {
            throw new \InvalidArgumentException("JPEG quality must be within [0, 100], got {$quality}.");
        }
        $windowing ??= Windowing::useWindow(1);
        $scale ??= Scale::none();
        $argv = array_merge(
            ['+oj', '+Jq', (string) $quality, '+Fa'],
            $windowing->flags(),
            $scale->flags(),
            [$this->source->path(), $outputPathPrefix],
        );
        $result = Tool::run($this->toolkit, 'dcmj2pnm', $argv);
        if (!$result->succeeded()) {
            Tool::assertReadable($this->source->path());
            throw new ConversionException(sprintf(
                "Extracting frames from '%s' failed (dcmj2pnm exit %d): %s",
                $this->source->path(),
                $result->exitCode,
                trim($result->stderr),
            ));
        }
        // NumberOfFrames is absent on a single-frame object, which yields one file.
        $frameCount = $this->source->getInteger(Tag::NumberOfFrames) ?? 1;
        $paths = [];
        for ($index = 0; $index < $frameCount; $index++) {
            $path = sprintf('%s.%d.jpg', $outputPathPrefix, $index);
            if (!is_file($path)) {
                throw new ConversionException(
                    "dcmj2pnm reported success but expected frame file '{$path}' is missing."
                );
            }
            $paths[] = $path;
        }

        return $paths;
    }

    /**
     * Render every frame and assemble them into a video at $outputPath via ffmpeg.
     *
     * Frames are rendered to a private temporary directory (the same per-frame
     * rendering as toJpegFrames) and handed to the VideoEncoder; the temporary
     * frames are always removed afterward, and the working directory is never
     * changed. timing defaults to ten frames per second and format to MP4
     * (H.264); pass a FrameTiming or VideoFormat to tune pacing or container.
     * Windowing, scaling, and quality apply to every frame as in toJpegFrames.
     *
     * @throws \\InvalidArgumentException quality is outside [0, 100]
     * @throws \\DICOM\\Exception\\IOException the source vanished or became unreadable
     * @throws ConversionException a frame could not be rendered (no pixel data or an
     *   absent VOI window), or ffmpeg was missing or failed to assemble the video
     * @throws \\DICOM\\Exception\\ToolkitException dcmj2pnm is missing or could not be started
     */
    public function toVideo(
        string $outputPath,
        ?FrameTiming $timing = null,
        ?VideoFormat $format = null,
        ?Windowing $windowing = null,
        ?Scale $scale = null,
        int $quality = 100,
    ): void {
        $timing ??= FrameTiming::framesPerSecond(10.0);
        $format ??= VideoFormat::mp4();

        $workspace = self::makeTempDirectory();
        try {
            $prefix = $workspace . '/frame';
            $this->toJpegFrames($prefix, $windowing, $quality, $scale);
            $this->videoEncoder->assemble($prefix . '.%d.jpg', $timing, $format, $outputPath);
        } finally {
            self::removeTempDirectory($workspace);
        }
    }

    private static function makeTempDirectory(): string
    {
        $directory = sys_get_temp_dir() . '/dicomVideo' . bin2hex(random_bytes(8));
        if (!mkdir($directory, 0700) && !is_dir($directory)) {
            throw new ConversionException(
                "Could not create a temporary directory for video frames at '{$directory}'."
            );
        }

        return $directory;
    }

    private static function removeTempDirectory(string $directory): void
    {
        foreach (glob($directory . '/*') ?: [] as $file) {
            @unlink($file);
        }
        @rmdir($directory);
    }

    /**
     * Create a DICOM Secondary Capture file from one or more JPEG images via
     * img2dcm, returning the opened result so attributes can be stamped on it with
     * the File tag accessors.
     *
     * A single image with the default classic Secondary Capture SOP class yields a
     * single-frame object (v1's `jpg_to_dcm`). Multiple images yield one multiframe
     * object, which requires SOPClass::newSC(); the classic class cannot hold more
     * than one frame, so that combination is rejected before img2dcm is invoked.
     * The images must share dimensions for a multiframe result; img2dcm fails loud
     * (writing no output) otherwise. img2dcm invents the required type-1 attributes
     * (SOPInstanceUID and friends), so the result is well-formed without a template.
     *
     * @param list<string> $images one or more source image paths, in frame order
     * @param SOPClass|null $sopClass target SOP class; defaults to single-frame Secondary Capture
     * @param StudySeriesSource|null $studySeries where to file the result in the
     *   Patient/Study/Series tree; defaults to fresh study and series UIDs
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
        ?SOPClass $sopClass = null,
        ?StudySeriesSource $studySeries = null,
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
        $sopClass ??= SOPClass::secCapture();
        if (count($images) > 1 && !$sopClass->supportsMultipleFrames()) {
            throw new \InvalidArgumentException(
                'Multiple images require a multiframe-capable SOP class; pass SOPClass::newSC().'
            );
        }
        $studySeries ??= StudySeriesSource::generate();
        $toolkit ??= new Toolkit();
        // img2dcm: [options] imgfile-in... dcmfile-out
        $argv = array_merge($sopClass->flags(), $studySeries->flags(), $images, [$outputPath]);
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

    /**
     * Create a DICOM Encapsulated PDF file from a PDF via pdf2dcm, returning the
     * opened result so attributes can be stamped on it with the File tag accessors
     * (this is v1's pdf_to_dcm territory).
     *
     * pdf2dcm wraps the whole document as a single Encapsulated PDF Storage
     * instance -- there are no frames and only the one SOP class, so neither the
     * image list nor the SOPClass axis applies here. It generates new study/series
     * UIDs and invents the required type-1 attributes by default, so the result is
     * well-formed without a template. Pass a StudySeriesSource to file the document
     * under an existing study or series instead.
     *
     * @param StudySeriesSource|null $studySeries where to file the result in the
     *   Patient/Study/Series tree; defaults to fresh study and series UIDs
     *
     * @throws \DICOM\Exception\IOException the PDF could not be read
     * @throws ConversionException pdf2dcm could not produce a DICOM (not a valid PDF)
     * @throws \DICOM\Exception\ToolkitException pdf2dcm is missing or could not be started
     */
    public static function fromPdf(
        string $pdfPath,
        string $outputPath,
        ?StudySeriesSource $studySeries = null,
        ?Toolkit $toolkit = null,
    ): File {
        $studySeries ??= StudySeriesSource::generate();
        $toolkit ??= new Toolkit();
        // pdf2dcm: [options] pdffile-in dcmfile-out
        $argv = array_merge($studySeries->flags(), [$pdfPath, $outputPath]);
        $result = Tool::run($toolkit, 'pdf2dcm', $argv);
        if (!$result->succeeded()) {
            Tool::assertReadable($pdfPath);
            throw new ConversionException(sprintf(
                "Creating a DICOM from '%s' failed (pdf2dcm exit %d): %s",
                $pdfPath,
                $result->exitCode,
                trim($result->stderr),
            ));
        }

        return File::open($outputPath, $toolkit);
    }
}
