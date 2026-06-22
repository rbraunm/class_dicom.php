<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\InvalidDICOMException;

/**
 * A DICOM Part 10 file: detection (dcmftest), the file-meta header accessors, and
 * ownership of the file's Dataset (its data elements). Open a file with open();
 * reach the raw, string-valued element read/write surface via dataset(). The
 * typed tag accessors build on this.
 *
 * In DICOM terms this models the Part 10 file (preamble + file-meta group 0002 +
 * dataset); Dataset models the data-element collection the file contains.
 *
 * Operational failures are DICOM\Exception\ExceptionInterface (IOException,
 * InvalidDICOMException, ToolkitException); reads through the Dataset may also
 * raise ValueExceedsReadLimitException.
 */
final class File
{
    private function __construct(
        private readonly string $path,
        private readonly Dataset $dataset,
    ) {
    }

    /**
     * True if $path is a DICOM Part 10 file. A readable non-DICOM file returns
     * false.
     *
     * @throws \DICOM\Exception\IOException the file is missing or unreadable
     * @throws \DICOM\Exception\ToolkitException dcmftest is missing or could not be started
     */
    public static function isDICOM(string $path, ?Toolkit $toolkit = null): bool
    {
        Tool::assertReadable($path);
        $toolkit ??= new Toolkit();

        return Tool::run($toolkit, 'dcmftest', [$path])->succeeded();
    }

    /**
     * Open a DICOM file. maxReadLengthKB sets the Dataset's dcmdump +R read limit
     * (kbytes); when null the process-wide Dataset default is used.
     *
     * @throws \DICOM\Exception\IOException the file is missing or unreadable
     * @throws InvalidDICOMException the file reads but is not DICOM
     * @throws \DICOM\Exception\ToolkitException dcmftest is missing or could not be started
     * @throws \InvalidArgumentException maxReadLengthKB is outside DCMTK's range
     */
    public static function open(string $path, ?Toolkit $toolkit = null, ?int $maxReadLengthKB = null): self
    {
        $toolkit ??= new Toolkit();
        if (!self::isDICOM($path, $toolkit)) {
            throw new InvalidDICOMException("Not a DICOM Part 10 file: '{$path}'.");
        }

        return new self($path, new Dataset($path, $toolkit, $maxReadLengthKB));
    }

    /** The file's data elements: the raw string read/write surface. */
    public function dataset(): Dataset
    {
        return $this->dataset;
    }

    /**
     * TransferSyntaxUID (0002,0010) from the file meta header.
     *
     * @throws \DICOM\Exception\IOException the file vanished or became unreadable since open()
     * @throws InvalidDICOMException the dataset is malformed or the UID is absent
     * @throws \DICOM\Exception\ToolkitException dcmdump is missing or could not be started
     */
    public function transferSyntaxUID(): string
    {
        return $this->requireUID(0x0002, 0x0010, 'TransferSyntaxUID');
    }

    /**
     * MediaStorageSOPClassUID (0002,0002) from the file meta header.
     *
     * @throws \DICOM\Exception\IOException the file vanished or became unreadable since open()
     * @throws InvalidDICOMException the dataset is malformed or the UID is absent
     * @throws \DICOM\Exception\ToolkitException dcmdump is missing or could not be started
     */
    public function mediaStorageSOPClassUID(): string
    {
        return $this->requireUID(0x0002, 0x0002, 'MediaStorageSOPClassUID');
    }

    private function requireUID(int $group, int $element, string $name): string
    {
        $value = $this->dataset->get($group, $element);
        if ($value === null) {
            throw new InvalidDICOMException(sprintf(
                '%s (%04x,%04x) is not present in \'%s\'.',
                $name,
                $group,
                $element,
                $this->path,
            ));
        }

        return $value;
    }
}
