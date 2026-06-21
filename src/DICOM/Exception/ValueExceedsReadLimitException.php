<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Exception;

/**
 * A tag is present but its value was larger than the configured read limit
 * (File's maxReadLengthKB, passed to dcmdump as +R) and so was not loaded. The
 * file is valid -- raise maxReadLengthKB to read the value. Distinct from an
 * absent tag (for which tag() returns null) and from InvalidDICOMException (the
 * file is malformed). requiredLimitKB() reports the smallest limit that would
 * load this value.
 */
class ValueExceedsReadLimitException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(
        public readonly string $tag,
        public readonly int $valueLengthBytes,
        public readonly int $currentLimitKB,
    ) {
        parent::__construct(sprintf(
            'Value for (%s) is %d bytes, above the current maxReadLengthKB of %d; '
            . 'set maxReadLengthKB to at least %d to load it.',
            $tag,
            $valueLengthBytes,
            $currentLimitKB,
            $this->requiredLimitKB(),
        ));
    }

    public function requiredLimitKB(): int
    {
        return intdiv($this->valueLengthBytes + 1023, 1024);
    }
}
