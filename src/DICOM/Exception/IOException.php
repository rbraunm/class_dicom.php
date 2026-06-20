<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Exception;

/**
 * A file could not be read: it is missing, unreadable, or not a regular file.
 * Distinct from InvalidDICOMException, which is for files that read fine but are
 * not DICOM.
 */
class IOException extends \RuntimeException implements ExceptionInterface
{
}
