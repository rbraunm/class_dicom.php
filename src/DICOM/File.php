<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\InvalidDICOMException;
use DICOM\Exception\IOException;

/**
 * A DICOM file. Detection and file-meta reads are wrapped DCMTK invocations:
 * `dcmftest` for the Part 10 check, `dcmdump` (raw UIDs, single tag) for the
 * file-meta UIDs. Substrate failures surface as DICOM exceptions at this boundary.
 */
final class File
{
    private function __construct(
        private readonly string $path,
        private readonly Toolkit $toolkit,
    ) {
    }

    /**
     * True if $path is a DICOM Part 10 file. A readable non-DICOM file returns
     * false; a missing or unreadable file raises IOException.
     */
    public static function isDICOM(string $path, ?Toolkit $toolkit = null): bool
    {
        self::assertReadable($path);
        $toolkit ??= new Toolkit();

        return $toolkit->run('dcmftest', [$path])->succeeded();
    }

    /**
     * Open a DICOM file for metadata access. Raises IOException if the file
     * cannot be read, InvalidDICOMException if it reads but is not DICOM.
     */
    public static function open(string $path, ?Toolkit $toolkit = null): self
    {
        $toolkit ??= new Toolkit();
        if (!self::isDICOM($path, $toolkit)) {
            throw new InvalidDICOMException("Not a DICOM Part 10 file: '{$path}'.");
        }

        return new self($path, $toolkit);
    }

    /** TransferSyntaxUID (0002,0010) from the file meta header. */
    public function transferSyntaxUID(): string
    {
        return $this->requireMetaUID('0002', '0010', 'TransferSyntaxUID');
    }

    /** MediaStorageSOPClassUID (0002,0002) from the file meta header. */
    public function mediaStorageSOPClassUID(): string
    {
        return $this->requireMetaUID('0002', '0002', 'MediaStorageSOPClassUID');
    }

    private function requireMetaUID(string $group, string $element, string $name): string
    {
        // -q quiet, -M skip very long values (pixel data), -Un raw UIDs not names.
        // +P search is intentionally not used: it does not cover the file-meta group,
        // so it returns nothing for 0002,xxxx. Bounding the read to the meta header
        // (e.g. +st) is a follow-up optimization.
        $result = $this->toolkit->run('dcmdump', [
            '-q',
            '-M',
            '-Un',
            $this->path,
        ]);
        if (!$result->succeeded()) {
            throw new InvalidDICOMException(sprintf(
                "Reading %s from '%s' failed (dcmdump exit %d): %s",
                $name,
                $this->path,
                $result->exitCode,
                trim($result->stderr),
            ));
        }
        $value = self::parseMetaUID($result->stdout, $group, $element);
        if ($value === null) {
            throw new InvalidDICOMException(
                "{$name} ({$group},{$element}) is not present in '{$this->path}'.",
            );
        }

        return $value;
    }

    /**
     * Pull a UI-VR value out of a dcmdump line produced with -Un, where the raw
     * UID is printed in brackets, e.g.
     * "(0002,0010) UI [1.2.840.10008.1.2.1]    #  20, 1 TransferSyntaxUID".
     */
    private static function parseMetaUID(string $dump, string $group, string $element): ?string
    {
        $pattern = sprintf(
            '/^\s*\(%s,%s\)\s+UI\s+\[([^\]\r\n]*)\]/mi',
            preg_quote($group, '/'),
            preg_quote($element, '/'),
        );
        if (preg_match($pattern, $dump, $matches) !== 1) {
            return null;
        }
        $value = trim($matches[1]);

        return $value === '' ? null : $value;
    }

    private static function assertReadable(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new IOException("File not readable: '{$path}'.");
        }
    }
}
