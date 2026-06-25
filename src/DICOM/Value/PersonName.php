<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Value;

/**
 * A DICOM PN (Person Name) value. The alphabetic component group is exposed as
 * its five named components (family, given, middle, prefix, suffix); the
 * ideographic and phonetic groups (rare in Western data) are preserved verbatim
 * so a name round-trips unchanged.
 */
final class PersonName
{
    public function __construct(
        public readonly string $familyName = '',
        public readonly string $givenName = '',
        public readonly string $middleName = '',
        public readonly string $namePrefix = '',
        public readonly string $nameSuffix = '',
        public readonly ?string $ideographic = null,
        public readonly ?string $phonetic = null,
    ) {
    }

    public static function fromDICOM(string $value): self
    {
        $groups = explode('=', $value, 3);
        $alpha = explode('^', $groups[0]);
        if (count($alpha) > 5) {
            throw new \InvalidArgumentException("PN alphabetic group has more than five components: '{$groups[0]}'.");
        }
        $alpha = array_pad($alpha, 5, '');

        return new self(
            $alpha[0],
            $alpha[1],
            $alpha[2],
            $alpha[3],
            $alpha[4],
            $groups[1] ?? null,
            $groups[2] ?? null,
        );
    }

    public function toDICOM(): string
    {
        $alpha = rtrim(
            implode('^', [$this->familyName, $this->givenName, $this->middleName, $this->namePrefix, $this->nameSuffix]),
            '^',
        );
        if ($this->phonetic !== null) {
            return $alpha . '=' . ($this->ideographic ?? '') . '=' . $this->phonetic;
        }
        if ($this->ideographic !== null) {
            return $alpha . '=' . $this->ideographic;
        }

        return $alpha;
    }
}
