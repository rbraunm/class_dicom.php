<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\Toolkit;
use DICOM\Exception\InvalidDICOMException;
use DICOM\Exception\ValueExceedsReadLimitException;

/**
 * The data-element collection of an opened DICOM file: the raw, string-valued
 * read/write surface. A single dcmdump is parsed once and cached for every read;
 * a write (dcmodify) invalidates that cache. Values are exactly as dcmdump prints
 * them -- multi-value components stay backslash-separated and typed
 * interpretation is the File layer's concern. This is the low-level route; most
 * consumers use the typed accessors on File.
 *
 * Operational failures are DICOM\Exception\ExceptionInterface:
 * - IOException: the file is missing or unreadable (including if it vanishes
 *   between construction and a later read or write).
 * - InvalidDICOMException: the file reads but its dataset is malformed, or a
 *   write could not be applied.
 * - ToolkitException: a backing DCMTK tool is missing or could not be started.
 * - ValueExceedsReadLimitException: a tag is present but its value was larger
 *   than maxReadLengthKB and was not loaded.
 * An out-of-range maxReadLengthKB raises \InvalidArgumentException, which is
 * misuse rather than an operational failure.
 */
final class Dataset
{
    /** Default +R --max-read-length passed to dcmdump, in kbytes. */
    public const int DEFAULT_MAX_READ_LENGTH_KB = 4;

    /** Bounds DCMTK accepts for +R --max-read-length (kbytes). */
    private const int MIN_READ_LENGTH_KB = 4;
    private const int MAX_READ_LENGTH_KB = 4194302;

    /**
     * Process-wide default used when a Dataset is constructed without an explicit
     * maxReadLengthKB. Set once at bootstrap via configureDefaultMaxReadLengthKB.
     */
    private static int $defaultMaxReadLengthKB = self::DEFAULT_MAX_READ_LENGTH_KB;

    private bool $loaded = false;

    /** @var array<string, string> "gggg,eeee" => raw value */
    private array $values = [];

    /** @var array<string, int> "gggg,eeee" => byte length, for values skipped by -M */
    private array $notLoaded = [];

    private readonly Toolkit $toolkit;
    private readonly int $maxReadLengthKB;

    /**
     * @throws \InvalidArgumentException maxReadLengthKB is outside DCMTK's range
     */
    public function __construct(
        private readonly string $path,
        ?Toolkit $toolkit = null,
        ?int $maxReadLengthKB = null,
    ) {
        $effective = $maxReadLengthKB ?? self::$defaultMaxReadLengthKB;
        self::assertReadLengthInRange($effective);
        $this->toolkit = $toolkit ?? new Toolkit();
        $this->maxReadLengthKB = $effective;
    }

    /**
     * Set the process-wide default maxReadLengthKB for later Dataset construction
     * that does not pass one explicitly.
     *
     * @throws \InvalidArgumentException the value is outside DCMTK's accepted range
     */
    public static function configureDefaultMaxReadLengthKB(int $maxReadLengthKB): void
    {
        self::assertReadLengthInRange($maxReadLengthKB);
        self::$defaultMaxReadLengthKB = $maxReadLengthKB;
    }

    /**
     * Raw value of a top-level tag, exactly as dcmdump prints it. Returns null
     * when the tag is not present.
     *
     * @throws IOException the file vanished or became unreadable since construction
     * @throws InvalidDICOMException the dataset is malformed
     * @throws ToolkitException dcmdump is missing or could not be started
     * @throws ValueExceedsReadLimitException the tag is present but its value
     *   exceeded maxReadLengthKB and was not loaded
     */
    public function get(int $group, int $element): ?string
    {
        $this->ensureLoaded();
        $key = self::key($group, $element);
        if (array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }
        if (array_key_exists($key, $this->notLoaded)) {
            throw new ValueExceedsReadLimitException($key, $this->notLoaded[$key], $this->maxReadLengthKB);
        }

        return null;
    }

    /**
     * Every top-level tag, "gggg,eeee" => raw value. A value that exceeded
     * maxReadLengthKB and was not loaded is listed with a null value; get() throws
     * ValueExceedsReadLimitException for those.
     *
     * @return array<string, ?string>
     *
     * @throws IOException the file vanished or became unreadable since construction
     * @throws InvalidDICOMException the dataset is malformed
     * @throws ToolkitException dcmdump is missing or could not be started
     */
    public function all(): array
    {
        $this->ensureLoaded();
        $all = $this->values;
        foreach (array_keys($this->notLoaded) as $key) {
            $all[$key] = null;
        }
        ksort($all);

        return $all;
    }

    /**
     * Insert or overwrite a top-level tag with a raw string value via
     * `dcmodify -nb -i`, editing the file in place. The value is passed through
     * verbatim (a backslash is DICOM's multi-value separator); the stored value
     * follows DICOM VR normalization, so this does not promise byte-exact
     * round-trip. The read cache is invalidated so the next read reflects the
     * write.
     *
     * @throws IOException the file vanished or became unreadable since construction
     * @throws InvalidDICOMException the write could not be applied
     * @throws ToolkitException dcmodify is missing or could not be started
     */
    public function put(int $group, int $element, string $value): void
    {
        $path = sprintf('(%04x,%04x)', $group, $element);
        $result = Tool::run($this->toolkit, 'dcmodify', ['-nb', '-i', "{$path}={$value}", $this->path]);
        if (!$result->succeeded()) {
            Tool::assertReadable($this->path);
            throw new InvalidDICOMException(sprintf(
                "Writing tag %s to '%s' failed (dcmodify exit %d): %s",
                self::key($group, $element),
                $this->path,
                $result->exitCode,
                trim($result->stderr),
            ));
        }
        $this->loaded = false;
    }

    /**
     * Run dcmdump once and cache its parsed output. -q quiet, -Un raw bracketed
     * UIDs (not name-mapped), -M skip values longer than +R so large binaries are
     * not loaded, +L print loaded values completely (dcmdump otherwise truncates
     * long values in the display regardless of +R), +R the configured limit in
     * kbytes. dcmdump reports a skipped value's byte length in its line comment,
     * which feeds ValueExceedsReadLimitException.
     */
    private function ensureLoaded(): void
    {
        if ($this->loaded) {
            return;
        }
        $result = Tool::run($this->toolkit, 'dcmdump', [
            '-q',
            '-Un',
            '-M',
            '+L',
            '+R',
            (string) $this->maxReadLengthKB,
            $this->path,
        ]);
        if (!$result->succeeded()) {
            // A failure here is either the file having gone unreadable since
            // construction (I/O) or a dataset malformed beyond a shallow check.
            // assertReadable throws IOException if the file is gone; otherwise it
            // is malformed.
            Tool::assertReadable($this->path);
            throw new InvalidDICOMException(sprintf(
                "Reading tags from '%s' failed (dcmdump exit %d): %s",
                $this->path,
                $result->exitCode,
                trim($result->stderr),
            ));
        }
        [$this->values, $this->notLoaded] = self::parseDump($result->stdout);
        $this->loaded = true;
    }

    /**
     * Parse `dcmdump -Un -M +L` output into top-level tag maps. Each element prints
     * as "(gggg,eeee) VR <value>  # <length>, <vm> <Keyword>"; sequence items are
     * indented, so anchoring to the start of the line keeps only top-level
     * elements. A value is either complete or "(not loaded)" (skipped by -M for
     * exceeding +R), whose byte length is kept for ValueExceedsReadLimitException.
     * A zero-length value is the empty string regardless of how dcmdump renders it.
     *
     * @return array{0: array<string, string>, 1: array<string, int>}
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
                $notLoaded[$key] = $length;
            } elseif ($length === 0) {
                $values[$key] = '';
            } elseif ($value !== '' && $value[0] === '[' && str_ends_with($value, ']')) {
                $values[$key] = substr($value, 1, -1);
            } else {
                $values[$key] = $value;
            }
        }

        return [$values, $notLoaded];
    }

    private static function key(int $group, int $element): string
    {
        return sprintf('%04x,%04x', $group, $element);
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
