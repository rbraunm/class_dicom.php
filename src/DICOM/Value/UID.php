<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Value;

/**
 * A DICOM UI (Unique Identifier) value: a dotted-numeric OID-style string, at
 * most 64 characters, each component free of leading zeros. Construction
 * validates the form and fails loudly on a malformed UID.
 */
final class UID
{
    public function __construct(public readonly string $value)
    {
        if (strlen($value) > 64) {
            throw new \InvalidArgumentException("UID exceeds 64 characters: '{$value}'.");
        }
        if (!preg_match('/^[0-9]+(\.[0-9]+)*$/', $value)) {
            throw new \InvalidArgumentException("Not a valid DICOM UID: '{$value}'.");
        }
        foreach (explode('.', $value) as $component) {
            if (strlen($component) > 1 && $component[0] === '0') {
                throw new \InvalidArgumentException("UID component has a leading zero: '{$component}' in '{$value}'.");
            }
        }
    }

    public static function fromDICOM(string $value): self
    {
        return new self($value);
    }

    public function toDICOM(): string
    {
        return $this->value;
    }
}
