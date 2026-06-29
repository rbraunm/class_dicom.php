<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
//
// Clean-room note: newly authored. The legacy class_dicom.php source was never
// read; this re-creates v1's global dicom_convert class from the reflected
// footprint and empirical blackbox observation of its methods (including the exact
// dcmj2pnm/dcmcjpeg invocations and the VOI-window fallback). Public names,
// signatures, and return shapes are reproduced verbatim; house naming applies only
// to the internal Compat\ShimContract helper this delegates to.
//
// This file grows over checkpoints 6d-6f: 6d adds the render/codec methods, 6e the
// creation methods (jpg_to_dcm, pdf_to_dcm), and 6f the multiframe_to_video shim.
declare(strict_types=1);

use Compat\ShimContract;
use DICOM\Compress;
use DICOM\Compression;
use DICOM\Convert;
use DICOM\File;
use DICOM\FrameTiming;
use DICOM\VideoFormat;
use DICOM\Windowing;

/**
 * v1 compatibility: render and (de)compress DICOM images.
 *
 * v1 fidelity points reproduced here:
 * - dcm_to_jpg()/dcm_to_tn() take no arguments; the output path is always
 *   "{file}.jpg" / "{file}_tn.jpg". They set $jpg_file / $tn_file to that output
 *   (these are outputs, not inputs) and return it.
 * - Rendering tries VOI window 1, then falls back to min-max for images with no
 *   stored window. dcm_to_jpg uses $jpg_quality (default 100); dcm_to_tn uses a
 *   fixed quality of 75, scaled to $tn_size pixels wide (default 125).
 * - compress()/uncompress() write to $new_file, or overwrite the input when it is
 *   empty, and return the output path. compress defaults to JPEG lossless SV1.
 *
 * @deprecated Use DICOM\Convert (toJPEG/toThumbnail) and DICOM\Compress
 *             (compress/decompress) in new code.
 */
class dicom_convert
{
    /** @var string Path to the source DICOM file, stored verbatim from the constructor. */
    public $file = '';

    /** @var string Path of the JPEG produced by dcm_to_jpg() (set by the method). */
    public $jpg_file = '';

    /** @var string Path of the thumbnail produced by dcm_to_tn() (set by the method). */
    public $tn_file = '';

    /** @var int JPEG quality for dcm_to_jpg(), 0-100. */
    public $jpg_quality = 100;

    /** @var int Thumbnail width in pixels for dcm_to_tn(). */
    public $tn_size = 125;

    /**
     * @var string @deprecated v2 builds DICOM via img2dcm, which mints its own
     *             type-1 UIDs; this dcm2xml template is ignored.
     */
    public $template = '';

    /**
     * @var string @deprecated v2 needs no working directory for creation; ignored.
     */
    public $temp_dir = '';

    public function __construct($file = '')
    {
        $this->file = $file;
    }

    /**
     * Render the image to "{file}.jpg" at $jpg_quality, set $jpg_file to that path,
     * and return it. Tries VOI window 1, falling back to min-max windowing.
     */
    public function dcm_to_jpg()
    {
        $out = (string) $this->file . '.jpg';
        $this->jpg_file = $out;
        $quality = (int) ($this->jpg_quality ?: 100);

        ShimContract::runWithVoiFallback(
            'dcm_to_jpg() is deprecated; use DICOM\\Convert::toJPEG() in new code.',
            'dcm_to_jpg(): the image has no stored VOI window, so it fell back to '
            . 'min-max windowing. This silent fallback will be removed in v3 -- pass '
            . 'an image with a VOI window, or migrate to DICOM\\Convert with an '
            . 'explicit Windowing.',
            fn (): mixed => (new Convert(File::open((string) $this->file)))
                ->toJPEG($out, Windowing::useWindow(1), $quality),
            fn (): mixed => (new Convert(File::open((string) $this->file)))
                ->toJPEG($out, Windowing::minMax(), $quality),
        );

        return $out;
    }

    /**
     * Render a thumbnail to "{file}_tn.jpg" -- fixed quality 75, scaled to $tn_size
     * wide -- set $tn_file to that path, and return it. Same VOI-window fallback.
     */
    public function dcm_to_tn()
    {
        $out = (string) $this->file . '_tn.jpg';
        $this->tn_file = $out;
        $size = (int) ($this->tn_size ?: 125);

        ShimContract::runWithVoiFallback(
            'dcm_to_tn() is deprecated; use DICOM\\Convert::toThumbnail() in new code.',
            'dcm_to_tn(): the image has no stored VOI window, so it fell back to '
            . 'min-max windowing. This silent fallback will be removed in v3 -- pass '
            . 'an image with a VOI window, or migrate to DICOM\\Convert with an '
            . 'explicit Windowing.',
            fn (): mixed => (new Convert(File::open((string) $this->file)))
                ->toThumbnail($out, $size, 75, Windowing::useWindow(1)),
            fn (): mixed => (new Convert(File::open((string) $this->file)))
                ->toThumbnail($out, $size, 75, Windowing::minMax()),
        );

        return $out;
    }

    /**
     * Compress the image to JPEG lossless SV1 (v1's default), writing to $new_file
     * or overwriting the input when $new_file is empty. Returns the output path.
     *
     * @return string
     */
    public function compress($new_file = '')
    {
        $out = $new_file !== '' ? (string) $new_file : (string) $this->file;

        return ShimContract::run(
            'compress() is deprecated; use DICOM\\Compress::compress() in new code.',
            function () use ($out): string {
                (new Compress(File::open((string) $this->file)))->compress($out, Compression::losslessSV1());

                return $out;
            },
            $out,
        );
    }

    /**
     * Decompress the image, writing to $new_file or overwriting the input when
     * $new_file is empty. Returns the output path.
     *
     * @return string
     */
    public function uncompress($new_file = '')
    {
        $out = $new_file !== '' ? (string) $new_file : (string) $this->file;

        return ShimContract::run(
            'uncompress() is deprecated; use DICOM\\Compress::decompress() in new code.',
            function () use ($out): string {
                (new Compress(File::open((string) $this->file)))->decompress($out);

                return $out;
            },
            $out,
        );
    }

    /**
     * Create a DICOM from the JPEG at $jpg_file, apply the "gggg,eeee" => value tags
     * in $arr_info, and return the output path "{jpg_file}.dcm". v2 builds the DICOM
     * via img2dcm, which mints its own type-1 UIDs, so v1's xml2dcm SOPInstanceUID
     * bug cannot occur. This is improved v2 behavior, not a reproduction of v1's
     * template-driven conversion -- a set $template is ignored (with a deprecation).
     *
     * @param array<string, string> $arr_info
     * @return string
     */
    public function jpg_to_dcm($arr_info)
    {
        if ((string) $this->template !== '') {
            ShimContract::deprecate(
                'jpg_to_dcm(): $template is ignored. v2 builds the DICOM via img2dcm, '
                . 'which mints its own type-1 UIDs; move any template tags into the '
                . '$arr_info map. This compatibility behavior may change in v3.',
            );
        }
        $out = (string) $this->jpg_file . '.dcm';

        return ShimContract::run(
            'jpg_to_dcm() is deprecated; use DICOM\\Convert::fromJpeg() in new code.',
            function () use ($out, $arr_info): string {
                Convert::fromJpeg([(string) $this->jpg_file], $out);
                ShimContract::applyTags($out, (array) $arr_info);

                return $out;
            },
            $out,
        );
    }

    /**
     * Create an Encapsulated PDF DICOM from the PDF at $file, apply the
     * "gggg,eeee" => value tags in $arr_info, and return "{file}.dcm". This is
     * working v2 functionality (v1's PDF conversion was non-functional), documented
     * as improved behavior rather than a validated v1 reproduction.
     *
     * @param array<string, string> $arr_info
     * @return string
     */
    public function pdf_to_dcm($arr_info)
    {
        $out = (string) $this->file . '.dcm';

        return ShimContract::run(
            'pdf_to_dcm() is deprecated; use DICOM\\Convert::fromPdf() in new code. '
            . 'This is improved v2 Encapsulated PDF conversion, not a reproduction of '
            . 'v1 (whose PDF conversion was non-functional).',
            function () use ($out, $arr_info): string {
                Convert::fromPdf((string) $this->file, $out);
                ShimContract::applyTags($out, (array) $arr_info);

                return $out;
            },
            $out,
        );
    }

    /**
     * Deprecated alias of pdf_to_dcm(), preserved from v1's surface.
     *
     * @param array<string, string> $arr_info
     * @return string
     */
    public function pdf_to_dcmcr($arr_info)
    {
        ShimContract::deprecate(
            'pdf_to_dcmcr() is a deprecated alias of pdf_to_dcm(); use '
            . 'DICOM\\Convert::fromPdf() in new code.',
        );

        return $this->pdf_to_dcm($arr_info);
    }

    /**
     * Assemble the multiframe image into a video at
     * "{temp_dir}/{basename(file)}.{format}" and return that path. Only the mp4
     * format is supported. The temp_dir is created if missing.
     *
     * One deliberate, safer-than-v1 change: $framerate is honored as a
     * frames-per-second cine rate. v1 ignored its $framerate argument and always
     * fed ffmpeg a fixed 10 fps input rate, so callers who passed a value got no
     * effect; here the value takes effect.
     *
     * This is the narrow v1 surface -- format, framerate, and output directory
     * only. DICOM\\Convert::toVideo() exposes the richer timing (seconds-per-frame,
     * frame multiplier), scaling, quality, and windowing controls.
     *
     * @param string $format    output container; only 'mp4' is supported
     * @param int    $framerate frames per second (v1 default 24)
     * @param string $temp_dir  output directory (v1 default './video_temp')
     * @return string the output path
     */
    public function multiframe_to_video($format = 'mp4', $framerate = 24, $temp_dir = './video_temp')
    {
        $format = (string) $format;
        if (strtolower($format) !== 'mp4') {
            throw new \InvalidArgumentException(
                "multiframe_to_video(): only the 'mp4' format is supported, got '{$format}'."
            );
        }
        $directory = (string) $temp_dir;
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException(
                "multiframe_to_video(): could not create output directory '{$directory}'."
            );
        }
        $out = rtrim($directory, '/') . '/' . basename((string) $this->file) . '.' . $format;

        return ShimContract::run(
            'multiframe_to_video() is deprecated; use DICOM\\Convert::toVideo() in new '
            . 'code. Unlike v1, this honors $framerate (v1 ignored it and always used '
            . '10 fps).',
            function () use ($out, $framerate): string {
                (new Convert(File::open((string) $this->file)))
                    ->toVideo($out, FrameTiming::framesPerSecond((float) $framerate), VideoFormat::mp4());

                return $out;
            },
            $out,
        );
    }
}
