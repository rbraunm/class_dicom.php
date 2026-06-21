<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\CommandResult;
use DCMTK\Exception\ExceptionInterface as DCMTKException;
use DCMTK\Toolkit;
use DICOM\Exception\InvalidDICOMException;
use DICOM\Exception\IOException;
use DICOM\Exception\ToolkitException;
use DICOM\Exception\ValueExceedsReadLimitException;

/**
 * A DICOM file. Detection and metadata reads are wrapped DCMTK invocations:
 * `dcmftest` for the Part 10 check, and a single `dcmdump` (raw UIDs, large
 * values skipped) whose output is parsed once and cached for every tag read.
 *
 * Operational failures are always `DICOM\Exception\ExceptionInterface`, in one of
 * four concrete forms:
 * - IOException: the file is missing or unreadable (including if it vanishes
 *   between open() and a later read).
 * - InvalidDICOMException: the file reads but is not DICOM, or its dataset is
 *   malformed or missing a required file-meta UID.
 * - ToolkitException: the backing DCMTK tool is missing or could not be started
 *   (a substrate failure translated at this boundary).
 * - ValueExceedsReadLimitException: a tag is present but its value was larger
 *   than maxReadLengthKB and was not loaded.
 * Separately, a programming error -- an out-of-range maxReadLengthKB -- raises
 * \InvalidArgumentException, which is misuse rather than an operational failure.
 */
final class File
{
    /** Default +R --max-read-length passed to dcmdump, in kbytes. */
    public const int DEFAULT_MAX_READ_LENGTH_KB = 4;

    /** Bounds DCMTK accepts for +R --max-read-length (kbytes). */
    private const int MIN_READ_LENGTH_KB = 4;
    private const int MAX_READ_LENGTH_KB = 4194302;

    /**
     * Process-wide default used when open() is called without an explicit
     * maxReadLengthKB. Set once at bootstrap via configureDefaultMaxReadLengthKB;
     * an explicit open() argument still overrides it.
     */
    private static int $defaultMaxReadLengthKB = self::DEFAULT_MAX_READ_LENGTH_KB;

    private bool $tagsLoaded = false;

    /** @var array<string, string> top-level tag "gggg,eeee" => raw value */
    private array $tagValues = [];

    /** @var array<string, int> top-level tag "gggg,eeee" => byte length, for values skipped by -M */
    private array $tagNotLoaded = [];

    private function __construct(
        private readonly string $path,
        private readonly Toolkit $toolkit,
        private readonly int $maxReadLengthKB,
    ) {
    }

    /**
     * True if $path is a DICOM Part 10 file. A readable non-DICOM file returns
     * false.
     *
     * @throws IOException the file is missing or unreadable
     * @throws ToolkitException dcmftest is missing or could not be started
     */
    public static function isDICOM(string $path, ?Toolkit $toolkit = null): bool
    {
        self::assertReadable($path);
        $toolkit ??= new Toolkit();

        return self::runTool($toolkit, 'dcmftest', [$path])->succeeded();
    }

    /**
     * Open a DICOM file for metadata access. maxReadLengthKB sets dcmdump's +R
     * read limit (kbytes) for this file: values larger than it are not loaded and
     * surface as ValueExceedsReadLimitException on read. When null, the
     * process-wide default (DEFAULT_MAX_READ_LENGTH_KB, or whatever
     * configureDefaultMaxReadLengthKB last set) is used.
     *
     * @throws IOException the file is missing or unreadable
     * @throws InvalidDICOMException the file reads but is not DICOM
     * @throws ToolkitException dcmftest is missing or could not be started
     * @throws \InvalidArgumentException maxReadLengthKB is outside DCMTK's range
     */
    public static function open(string $path, ?Toolkit $toolkit = null, ?int $maxReadLengthKB = null): self
    {
        $effectiveMaxReadLengthKB = $maxReadLengthKB ?? self::$defaultMaxReadLengthKB;
        self::assertReadLengthInRange($effectiveMaxReadLengthKB);
        $toolkit ??= new Toolkit();
        if (!self::isDICOM($path, $toolkit)) {
            throw new InvalidDICOMException("Not a DICOM Part 10 file: '{$path}'.");
        }

        return new self($path, $toolkit, $effectiveMaxReadLengthKB);
    }

    /**
     * Set the process-wide default maxReadLengthKB for later open() calls that do
     * not pass one explicitly. An explicit open() argument still overrides it.
     *
     * @throws \InvalidArgumentException the value is outside DCMTK's accepted range
     */
    public static function configureDefaultMaxReadLengthKB(int $maxReadLengthKB): void
    {
        self::assertReadLengthInRange($maxReadLengthKB);
        self::$defaultMaxReadLengthKB = $maxReadLengthKB;
    }

    /**
     * TransferSyntaxUID (0002,0010) from the file meta header.
     *
     * @throws IOException the file vanished or became unreadable since open()
     * @throws InvalidDICOMException the dataset is malformed or the UID is absent
     * @throws ToolkitException dcmdump is missing or could not be started
     */
    public function transferSyntaxUID(): string
    {
        return $this->requireUID(0x0002, 0x0010, 'TransferSyntaxUID');
    }

    /**
     * MediaStorageSOPClassUID (0002,0002) from the file meta header.
     *
     * @throws IOException the file vanished or became unreadable since open()
     * @throws InvalidDICOMException the dataset is malformed or the UID is absent
     * @throws ToolkitException dcmdump is missing or could not be started
     */
    public function mediaStorageSOPClassUID(): string
    {
        return $this->requireUID(0x0002, 0x0002, 'MediaStorageSOPClassUID');
    }

    /**
     * Raw value of a top-level tag, exactly as dcmdump prints it (multi-value
     * components stay backslash-separated; typed parsing is a later concern).
     * Returns null when the tag is not present in the file.
     *
     * @throws IOException the file vanished or became unreadable since open()
     * @throws InvalidDICOMException the dataset is malformed
     * @throws ToolkitException dcmdump is missing or could not be started
     * @throws ValueExceedsReadLimitException the tag is present but its value
     *   exceeded maxReadLengthKB and was not loaded
     */
    public function tag(int $group, int $element): ?string
    {
        $this->ensureTagsLoaded();
        $key = self::tagKey($group, $element);
        if (array_key_exists($key, $this->tagValues)) {
            return $this->tagValues[$key];
        }
        if (array_key_exists($key, $this->tagNotLoaded)) {
            throw new ValueExceedsReadLimitException($key, $this->tagNotLoaded[$key], $this->maxReadLengthKB);
        }

        return null;
    }

    /**
     * Every top-level tag in the file, "gggg,eeee" => raw value. A value that
     * exceeded maxReadLengthKB and was not loaded is listed with a null value;
     * tag() throws ValueExceedsReadLimitException for those.
     *
     * @return array<string, ?string>
     *
     * @throws IOException the file vanished or became unreadable since open()
     * @throws InvalidDICOMException the dataset is malformed
     * @throws ToolkitException dcmdump is missing or could not be started
     */
    public function tags(): array
    {
        $this->ensureTagsLoaded();
        $all = $this->tagValues;
        foreach (array_keys($this->tagNotLoaded) as $key) {
            $all[$key] = null;
        }
        ksort($all);

        return $all;
    }

    private function requireUID(int $group, int $element, string $name): string
    {
        $value = $this->tag($group, $element);
        if ($value === null) {
            throw new InvalidDICOMException(sprintf(
                "%s (%s) is not present in '%s'.",
                $name,
                self::tagKey($group, $element),
                $this->path,
            ));
        }

        return $value;
    }

    /**
     * Run dcmdump once and cache its parsed output. -q quiet, -Un raw bracketed
     * UIDs (not name-mapped), -M skip values longer than +R so large binaries
     * (e.g. pixel data) are not loaded, +L print loaded values completely (dcmdump
     * otherwise truncates long values in the display regardless of +R), +R the
     * configured limit in kbytes. dcmdump reports a skipped value's byte length in
     * its line comment, which feeds ValueExceedsReadLimitException.
     */
    private function ensureTagsLoaded(): void
    {
        if ($this->tagsLoaded) {
            return;
        }
        $result = self::runTool($this->toolkit, 'dcmdump', [
            '-q',
            '-Un',
            '-M',
            '+L',
            '+R',
            (string) $this->maxReadLengthKB,
            $this->path,
        ]);
        if (!$result->succeeded()) {
            // dcmftest passed at open(), so a failure now is either the file having
            // gone unreadable since (I/O) or a dataset malformed beyond the shallow
            // Part 10 check. assertReadable throws IOException if the file is gone;
            // otherwise it is malformed.
            self::assertReadable($this->path);
            throw new InvalidDICOMException(sprintf(
                "Reading tags from '%s' failed (dcmdump exit %d): %s",
                $this->path,
                $result->exitCode,
                trim($result->stderr),
            ));
        }
        [$this->tagValues, $this->tagNotLoaded] = self::parseDump($result->stdout);
        $this->tagsLoaded = true;
    }

    /**
     * Parse `dcmdump -Un -M +L` output into top-level tag maps. Each element prints
     * as "(gggg,eeee) VR <value>  # <length>, <vm> <Keyword>"; sequence items are
     * indented, so anchoring to the start of the line keeps only top-level
     * elements. +L makes dcmdump print loaded values in full, so a value is either
     * complete or "(not loaded)" (skipped by -M because it exceeds +R), whose byte
     * length is kept from the comment for ValueExceedsReadLimitException. A
     * zero-length value is the empty string regardless of how dcmdump renders it.
     *
     * @return array{0: array<string, string>, 1: array<string, int>} loaded values,
     *   then byte lengths of values skipped by -M
     */
    private static function parseDump(string $dump): array
    {
        $pattern = '/^\((?<group>[0-9a-fA-F]{4}),(?<element>[0-9a-fA-F]{4})\) '
            . '(?<vr>..) (?<value>.*?) +# +(?<length>\d+), +\d+ /m';
        preg_match_all($pattern, $dump, $matches, PREG_SET_ORDER);

        $values = [];
        $notLoaded = [];
        foreach ($matches as $match) {
            $key = strtolower($match['group']) . ',' . strtolower($match['element']);
            $value = $match['value'];
            $length = (int) $match['length'];
            if ($value === '(not loaded)') {
                // -M skipped the value: it is larger than +R maxReadLengthKB.
                $notLoaded[$key] = $length;
            } elseif ($length === 0) {
                // Present but empty (type-2), however dcmdump renders zero length.
                $values[$key] = '';
            } elseif ($value !== '' && $value[0] === '[' && str_ends_with($value, ']')) {
                $values[$key] = substr($value, 1, -1);
            } else {
                $values[$key] = $value;
            }
        }

        return [$values, $notLoaded];
    }

    private static function tagKey(int $group, int $element): string
    {
        return sprintf('%04x,%04x', $group, $element);
    }

    /**
     * Run a DCMTK tool through the substrate, translating any substrate failure
     * (a missing tool, or a process that could not start) into a DICOM-layer
     * ToolkitException so callers of this API only ever catch
     * `DICOM\Exception\ExceptionInterface`.
     *
     * @param list<string> $argv
     */
    private static function runTool(Toolkit $toolkit, string $tool, array $argv): CommandResult
    {
        try {
            return $toolkit->run($tool, $argv);
        } catch (DCMTKException $e) {
            throw new ToolkitException(
                sprintf("DICOM toolkit failed running '%s': %s", $tool, $e->getMessage()),
                0,
                $e,
            );
        }
    }

    private static function assertReadable(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new IOException("File not readable: '{$path}'.");
        }
    }

    private static function assertReadLengthInRange(int $maxReadLengthKB): void
    {
        if ($maxReadLengthKB < self::MIN_READ_LENGTH_KB || $maxReadLengthKB > self::MAX_READ_LENGTH_KB) {
            throw new \InvalidArgumentException(sprintf(
                'maxReadLengthKB must be within [%d, %d], got %d.',
                self::MIN_READ_LENGTH_KB,
                self::MAX_READ_LENGTH_KB,
                $maxReadLengthKB,
            ));
        }
    }
}
