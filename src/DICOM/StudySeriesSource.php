<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * Where a newly created DICOM instance is filed in the Patient -> Study -> Series
 * tree. A single instance always lands on exactly one study and one series; this
 * choice decides whether those are freshly minted or inherited from an existing
 * DICOM object.
 *
 * The flags (--study-from / --series-from) are spelled identically by img2dcm and
 * pdf2dcm with the same meaning, so this one type serves both factories.
 */
final class StudySeriesSource
{
    /** @param list<string> $flags */
    private function __construct(private readonly array $flags)
    {
    }

    /**
     * Mint fresh study and series UIDs (the default for both tools). Emits no flag,
     * because generating is each tool's default and they spell it differently.
     */
    public static function generate(): self
    {
        return new self([]);
    }

    /**
     * Inherit patient and study from $reference, generating a new series. The
     * result files under the same study as the reference but as a distinct series.
     */
    public static function studyFrom(File $reference): self
    {
        return new self(['--study-from', $reference->path()]);
    }

    /**
     * Inherit patient, study, and series from $reference. The result files into the
     * same series as the reference, as another instance alongside it.
     */
    public static function seriesFrom(File $reference): self
    {
        return new self(['--series-from', $reference->path()]);
    }

    /** @return list<string> */
    public function flags(): array
    {
        return $this->flags;
    }
}
