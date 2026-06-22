<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

/**
 * Immutable description of one standard DICOM data element: where it lives in the
 * dataset (group, element), its value representation, and its value multiplicity.
 *
 * Instances come from the generated Tag enum (Tag::PatientName->info()), which is
 * produced from the DICOM data dictionary. This type is authored once; the
 * per-element data is generated.
 */
final class TagInfo
{
    public function __construct(
        public readonly int $group,
        public readonly int $element,
        public readonly string $valueRepresentation,
        public readonly string $valueMultiplicity,
    ) {
    }

    /** Canonical "gggg,eeee" key (lowercase hex), matching dcmdump output keys. */
    public function key(): string
    {
        return sprintf('%04x,%04x', $this->group, $this->element);
    }

    /** dcmodify/dcmdump tag path form "(gggg,eeee)". */
    public function path(): string
    {
        return sprintf('(%04x,%04x)', $this->group, $this->element);
    }

    /** True when the element may carry more than one value (VM other than "1"). */
    public function isMultiValued(): bool
    {
        return $this->valueMultiplicity !== '1';
    }
}
