<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * A scaling choice for rendering a DICOM image, mirroring dcmj2pnm's
 * mutually-exclusive scaling mode group. The single-axis modes auto-compute the
 * other axis, so the pixel aspect ratio is preserved. The caller selects one
 * mode; there is no automatic fallback.
 *
 * The modes modelled now cover the common cases; dcmj2pnm's explicit per-axis
 * factor modes and the aspect/interpolation modifiers fit this same shape and can
 * be added when needed.
 */
final class Scale
{
    /** @param list<string> $flags */
    private function __construct(private readonly array $flags)
    {
    }

    /** No scaling (dcmj2pnm --no-scaling; the tool's own default). */
    public static function none(): self
    {
        return new self(['--no-scaling']);
    }

    /** Scale the width to n pixels, height auto-computed (dcmj2pnm --scale-x-size). */
    public static function widthTo(int $pixels): self
    {
        if ($pixels < 1) {
            throw new \InvalidArgumentException("Scale width must be >= 1 pixel, got {$pixels}.");
        }

        return new self(['--scale-x-size', (string) $pixels]);
    }

    /** Scale the height to n pixels, width auto-computed (dcmj2pnm --scale-y-size). */
    public static function heightTo(int $pixels): self
    {
        if ($pixels < 1) {
            throw new \InvalidArgumentException("Scale height must be >= 1 pixel, got {$pixels}.");
        }

        return new self(['--scale-y-size', (string) $pixels]);
    }

    /** Scale by a factor, aspect preserved (dcmj2pnm --scale-x-factor, y auto-computed). */
    public static function byFactor(float $factor): self
    {
        if ($factor <= 0.0) {
            throw new \InvalidArgumentException("Scale factor must be > 0, got {$factor}.");
        }

        return new self(['--scale-x-factor', self::number($factor)]);
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
