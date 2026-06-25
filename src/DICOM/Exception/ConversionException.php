<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Exception;

/**
 * A DCMTK conversion could not be performed: the inputs were present and readable
 * but the toolkit refused or failed to produce the requested output. Examples are
 * a DICOM image with no pixel data, a requested VOI window that the image does not
 * define, an unsupported source image, or multiframe inputs whose dimensions do
 * not match. Distinct from ToolkitException (the tool was missing or could not
 * start) and IOException (a file could not be read).
 */
class ConversionException extends \RuntimeException implements ExceptionInterface
{
}
