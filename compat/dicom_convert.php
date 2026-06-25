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
// This file grows over checkpoints 6d-6f: 6d adds the render/codec methods below;
// the creation (jpg_to_dcm, pdf_to_dcm) and multiframe methods land later.
declare(strict_types=1);

use Compat\ShimContract;
use DICOM\Compress;
use DICOM\Compression;
use DICOM\Convert;
use DICOM\File;
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
}
