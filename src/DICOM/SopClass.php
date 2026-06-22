<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * The target SOP class for an image-to-DICOM conversion, mirroring img2dcm's
 * mutually-exclusive target SOP class group. The caller selects one.
 *
 * The two modelled now cover the common cases: classic single-frame Secondary
 * Capture (the default) and the new Secondary Capture classes, which are
 * multiframe-capable. img2dcm's Visible Light Photographic and Ophthalmic targets
 * fit this same shape and can be added when needed.
 */
final class SopClass
{
    /**
     * @param list<string> $flags
     * @param bool $supportsMultipleFrames whether this SOP class can hold more than one frame
     */
    private function __construct(
        private readonly array $flags,
        private readonly bool $supportsMultipleFrames,
    ) {
    }

    /** Classic single-frame Secondary Capture (img2dcm --sec-capture; its default). */
    public static function secCapture(): self
    {
        return new self(['--sec-capture'], false);
    }

    /** The new Secondary Capture classes, which are multiframe-capable (img2dcm --new-sc). */
    public static function newSC(): self
    {
        return new self(['--new-sc'], true);
    }

    /** @return list<string> */
    public function flags(): array
    {
        return $this->flags;
    }

    public function supportsMultipleFrames(): bool
    {
        return $this->supportsMultipleFrames;
    }
}
