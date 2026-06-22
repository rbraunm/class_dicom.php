<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * A VOI windowing choice for rendering a DICOM image, mirroring dcmj2pnm's
 * mutually-exclusive VOI LUT transformation modes. The caller selects exactly
 * one mode; there is no automatic fallback -- the chosen mode either applies or
 * the render fails loud.
 *
 * The four modes modelled now cover the common cases; dcmj2pnm offers further
 * modes (VOI LUT, ROI min-max, histogram) that fit this same shape and can be
 * added when needed.
 */
final class Windowing
{
    /** @param list<string> $flags */
    private function __construct(private readonly array $flags)
    {
    }

    /** No VOI windowing (dcmj2pnm --no-windowing; the tool's own default). */
    public static function none(): self
    {
        return new self(['--no-windowing']);
    }

    /** Use the n-th VOI window stored in the image (dcmj2pnm --use-window). */
    public static function useWindow(int $number = 1): self
    {
        if ($number < 1) {
            throw new \InvalidArgumentException("VOI window number must be >= 1, got {$number}.");
        }

        return new self(['--use-window', (string) $number]);
    }

    /** Compute the window from the pixel min and max (dcmj2pnm --min-max-window). */
    public static function minMax(): self
    {
        return new self(['--min-max-window']);
    }

    /** Explicit window center and width (dcmj2pnm --set-window). */
    public static function setWindow(float $center, float $width): self
    {
        if ($width <= 0.0) {
            throw new \InvalidArgumentException("Window width must be > 0, got {$width}.");
        }

        return new self(['--set-window', self::number($center), self::number($width)]);
    }

    /** @return list<string> */
    public function flags(): array
    {
        return $this->flags;
    }

    /** Render a float for dcmj2pnm: fixed-point, trailing zeros trimmed, '.' decimal. */
    private static function number(float $value): string
    {
        $formatted = rtrim(rtrim(sprintf('%.6f', $value), '0'), '.');

        return $formatted === '' || $formatted === '-' ? '0' : $formatted;
    }
}
