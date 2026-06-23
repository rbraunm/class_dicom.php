<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * A JPEG compression process for Compress::compress, mirroring dcmcjpeg's JPEG
 * process group. The caller selects one; each maps to a current DICOM JPEG
 * transfer syntax.
 *
 * The four offered are the JPEG processes DICOM still defines as current:
 * lossless SV1 (Process 14 SV1, the default), lossless (Process 14), baseline
 * (Process 1, lossy 8-bit), and extended (Process 2 and 4, lossy 12-bit).
 * dcmcjpeg's spectral-selection and progressive processes are deliberately not
 * offered: their DICOM transfer syntaxes are retired, so we do not create new
 * objects in them. Decompression still reads them, since dcmdjpeg decodes whatever
 * it is given.
 */
final class Compression
{
    /** @param list<string> $flags */
    private function __construct(private readonly array $flags)
    {
    }

    /** JPEG Lossless, Process 14 selection value 1 (dcmcjpeg --encode-lossless-sv1). */
    public static function losslessSV1(): self
    {
        return new self(['+e1']);
    }

    /** JPEG Lossless, Process 14 (dcmcjpeg --encode-lossless). */
    public static function lossless(): self
    {
        return new self(['+el']);
    }

    /** JPEG Baseline, Process 1, lossy 8-bit (dcmcjpeg --encode-baseline). */
    public static function baseline(int $quality = 90): self
    {
        return new self(['+eb', '+q', self::quality($quality)]);
    }

    /** JPEG Extended, Process 2 and 4, lossy 12-bit (dcmcjpeg --encode-extended). */
    public static function extended(int $quality = 90): self
    {
        return new self(['+ee', '+q', self::quality($quality)]);
    }

    /** @return list<string> */
    public function flags(): array
    {
        return $this->flags;
    }

    private static function quality(int $quality): string
    {
        if ($quality < 0 || $quality > 100) {
            throw new \InvalidArgumentException("JPEG quality must be within [0, 100], got {$quality}.");
        }

        return (string) $quality;
    }
}
