<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Exception;

/**
 * The backing DICOM toolkit could not carry out an operation: a required tool is
 * not installed, or its process could not be started. Distinct from IOException
 * (the file cannot be read) and InvalidDICOMException (the file reads but is not
 * DICOM) -- this is an environment/processing failure. The originating
 * `DCMTK\Exception\*` is attached as the previous exception.
 */
class ToolkitException extends \RuntimeException implements ExceptionInterface
{
}
