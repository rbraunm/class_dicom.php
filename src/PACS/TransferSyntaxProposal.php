<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS;

/**
 * Which transfer syntaxes an SCU proposes when associating, mirroring storescu's
 * proposed-transfer-syntax group. The peer picks one of the proposed syntaxes it
 * supports; forcing a particular proposal is how you talk to an SCP that only
 * accepts certain syntaxes.
 *
 * The modelled set covers the current, build-supported syntaxes. Retired
 * (explicit VR big endian) and syntaxes this DCMTK build lacks (JPEG 2000) or that
 * are niche (RLE, deflated, JPEG-LS, MPEG/HEVC) are not offered; they fit the same
 * shape and can be added if needed.
 */
final class TransferSyntaxProposal
{
    /** @param list<string> $flags */
    private function __construct(private readonly array $flags)
    {
    }

    /** Let storescu propose based on each file's own transfer syntax (its default). */
    public static function automatic(): self
    {
        return new self([]);
    }

    /** Propose all uncompressed transfer syntaxes, explicit VR (storescu --propose-little). */
    public static function uncompressed(): self
    {
        return new self(['-xe']);
    }

    /** Propose implicit VR little endian only (storescu --propose-implicit). */
    public static function implicitVRLittleEndian(): self
    {
        return new self(['-xi']);
    }

    /** Propose the default JPEG lossless transfer syntax (storescu --propose-lossless). */
    public static function jpegLossless(): self
    {
        return new self(['-xs']);
    }

    /** Propose the default JPEG lossy transfer syntax for 8-bit data (storescu --propose-jpeg8). */
    public static function jpegBaseline(): self
    {
        return new self(['-xy']);
    }

    /** Propose the default JPEG lossy transfer syntax for 12-bit data (storescu --propose-jpeg12). */
    public static function jpegExtended(): self
    {
        return new self(['-xx']);
    }

    /** @return list<string> */
    public function flags(): array
    {
        return $this->flags;
    }
}
