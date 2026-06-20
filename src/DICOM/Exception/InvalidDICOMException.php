<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Exception;

/**
 * A file is readable but is not valid DICOM (fails the Part 10 check). Distinct
 * from IOException, which is for files that cannot be read at all.
 */
class InvalidDICOMException extends \RuntimeException implements ExceptionInterface
{
}
