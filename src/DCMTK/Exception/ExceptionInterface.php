<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK\Exception;

/**
 * Marker for every exception the DCMTK substrate throws. The DICOM/PACS layers
 * catch these at their boundary and re-throw their own API exceptions, so this
 * marker stays internal to the toolkit.
 */
interface ExceptionInterface extends \Throwable
{
}
