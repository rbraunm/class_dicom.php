<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\InvalidDICOMException;
use DICOM\Value\Date;
use DICOM\Value\DateTime;
use DICOM\Value\PersonName;
use DICOM\Value\Time;
use DICOM\Value\UID;

/**
 * A DICOM Part 10 file: detection (dcmftest), the file-meta header accessors,
 * the typed tag API, and ownership of the file's Dataset (its data elements).
 *
 * Tags are addressed by the generated Tag enum and read/written as typed values:
 * getDate(Tag::StudyDate), setPersonName(Tag::PatientName, ...). Each accessor is
 * gated on the tag's value representation -- asking for a date tag as an integer
 * is a programming error and raises \InvalidArgumentException before any tool
 * runs. The raw, string-valued surface is reached via dataset().
 *
 * In DICOM terms this models the Part 10 file (preamble + file-meta group 0002 +
 * dataset); Dataset models the data-element collection the file contains.
 *
 * Operational failures are DICOM\Exception\ExceptionInterface (IOException,
 * InvalidDICOMException, ToolkitException); reads through the Dataset may also
 * raise ValueExceedsReadLimitException. A malformed value stored in the file
 * surfaces as InvalidDICOMException when read through a typed accessor.
 */
final class File
{
    /** Value representation -> typed-accessor family. */
    private const array FAMILIES = [
        'DA' => 'date',
        'TM' => 'time',
        'DT' => 'dateTime',
        'PN' => 'personName',
        'UI' => 'uid',
        'IS' => 'integer', 'US' => 'integer', 'UL' => 'integer',
        'SS' => 'integer', 'SL' => 'integer', 'SV' => 'integer', 'UV' => 'integer',
        'DS' => 'decimal', 'FL' => 'decimal', 'FD' => 'decimal',
        'AE' => 'text', 'AS' => 'text', 'CS' => 'text', 'LO' => 'text', 'LT' => 'text',
        'SH' => 'text', 'ST' => 'text', 'UC' => 'text', 'UR' => 'text', 'UT' => 'text',
    ];

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
     * @throws InvalidDICOMException the dataset is malformed or the UID is absent
     */
    public function transferSyntaxUID(): string
    {
        return $this->requireUID(0x0002, 0x0010, 'TransferSyntaxUID');
    }

    /**
     * MediaStorageSOPClassUID (0002,0002) from the file meta header.
     *
     * @throws InvalidDICOMException the dataset is malformed or the UID is absent
     */
    public function mediaStorageSOPClassUID(): string
    {
        return $this->requireUID(0x0002, 0x0002, 'MediaStorageSOPClassUID');
    }

    // ---- typed reads. Null means the tag is absent. ----

    public function getDate(Tag $tag): ?Date
    {
        return $this->parsed($this->readSingle($this->gate($tag, 'date')), Date::fromDICOM(...));
    }

    public function getTime(Tag $tag): ?Time
    {
        return $this->parsed($this->readSingle($this->gate($tag, 'time')), Time::fromDICOM(...));
    }

    public function getDateTime(Tag $tag): ?DateTime
    {
        return $this->parsed($this->readSingle($this->gate($tag, 'dateTime')), DateTime::fromDICOM(...));
    }

    public function getPersonName(Tag $tag): ?PersonName
    {
        return $this->parsed($this->readSingle($this->gate($tag, 'personName')), PersonName::fromDICOM(...));
    }

    public function getUID(Tag $tag): ?UID
    {
        return $this->parsed($this->readSingle($this->gate($tag, 'uid')), UID::fromDICOM(...));
    }

    public function getInteger(Tag $tag): ?int
    {
        $raw = $this->readSingle($this->gate($tag, 'integer'));
        if ($raw === null) {
            return null;
        }
        $trimmed = trim($raw);
        if (!preg_match('/^[+-]?\d+$/', $trimmed)) {
            throw new InvalidDICOMException(sprintf("Malformed integer value '%s' in '%s'.", $raw, $this->path));
        }

        return (int) $trimmed;
    }

    public function getDecimal(Tag $tag): ?float
    {
        $raw = $this->readSingle($this->gate($tag, 'decimal'));
        if ($raw === null) {
            return null;
        }
        $trimmed = trim($raw);
        if (!is_numeric($trimmed)) {
            throw new InvalidDICOMException(sprintf("Malformed decimal value '%s' in '%s'.", $raw, $this->path));
        }

        return (float) $trimmed;
    }

    public function getText(Tag $tag): ?string
    {
        return $this->readSingle($this->gate($tag, 'text'));
    }

    /**
     * A multi-valued text tag as its list of components. An absent tag is the
     * empty list.
     *
     * @return list<string>
     */
    public function getTextList(Tag $tag): array
    {
        $info = $this->gate($tag, 'text');
        $raw = $this->dataset->get($info->group, $info->element);

        return $raw === null ? [] : explode('\\', $raw);
    }

    // ---- typed writes. Insert-or-overwrite, in place. ----

    public function setDate(Tag $tag, Date $value): void
    {
        $this->write($this->gate($tag, 'date'), $value->toDICOM());
    }

    public function setTime(Tag $tag, Time $value): void
    {
        $this->write($this->gate($tag, 'time'), $value->toDICOM());
    }

    public function setDateTime(Tag $tag, DateTime $value): void
    {
        $this->write($this->gate($tag, 'dateTime'), $value->toDICOM());
    }

    public function setPersonName(Tag $tag, PersonName $value): void
    {
        $this->write($this->gate($tag, 'personName'), $value->toDICOM());
    }

    public function setUID(Tag $tag, UID $value): void
    {
        $this->write($this->gate($tag, 'uid'), $value->toDICOM());
    }

    public function setInteger(Tag $tag, int $value): void
    {
        $this->write($this->gate($tag, 'integer'), (string) $value);
    }

    public function setDecimal(Tag $tag, float $value): void
    {
        $this->write($this->gate($tag, 'decimal'), (string) $value);
    }

    public function setText(Tag $tag, string $value): void
    {
        $this->write($this->gate($tag, 'text'), $value);
    }

    /** @param list<string> $values */
    public function setTextList(Tag $tag, array $values): void
    {
        $this->write($this->gate($tag, 'text'), implode('\\', $values));
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

    /**
     * Resolve the tag and confirm its value representation matches the accessor's
     * family. A mismatch is a programming error (wrong accessor for the tag), not
     * an operational failure, so it raises \InvalidArgumentException before any
     * tool runs.
     */
    private function gate(Tag $tag, string $family): TagInfo
    {
        $info = $tag->info();
        $actual = self::FAMILIES[$info->valueRepresentation] ?? null;
        if ($actual !== $family) {
            throw new \InvalidArgumentException(sprintf(
                '%s is a %s tag (%s); it cannot be accessed as %s.',
                $tag->name,
                $info->valueRepresentation,
                $actual ?? 'an unsupported type',
                $family,
            ));
        }

        return $info;
    }

    /**
     * Read a single-valued element. A backslash means DICOM multiple values,
     * which a single-value accessor cannot represent: fail loudly rather than
     * silently return the first component.
     */
    private function readSingle(TagInfo $info): ?string
    {
        $raw = $this->dataset->get($info->group, $info->element);
        if ($raw !== null && str_contains($raw, '\\')) {
            throw new \InvalidArgumentException(sprintf(
                'Tag (%04x,%04x) holds multiple values; read it via dataset()->get(), or getTextList() for text.',
                $info->group,
                $info->element,
            ));
        }

        return $raw;
    }

    /**
     * Run a stored raw value through a value parser, elevating a parse failure
     * (the file holds a malformed value for this VR) to InvalidDICOMException. A
     * null raw (absent tag) stays null.
     *
     * @template T
     *
     * @param callable(string): T $parse
     *
     * @return T|null
     */
    private function parsed(?string $raw, callable $parse): mixed
    {
        if ($raw === null) {
            return null;
        }
        try {
            return $parse($raw);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidDICOMException(
                sprintf("Malformed value in '%s': %s", $this->path, $e->getMessage()),
                0,
                $e,
            );
        }
    }

    private function write(TagInfo $info, string $encoded): void
    {
        $this->dataset->put($info->group, $info->element, $encoded);
    }
}
