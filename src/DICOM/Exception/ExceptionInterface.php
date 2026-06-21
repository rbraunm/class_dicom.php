<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Exception;

/**
 * Marker for every exception the DICOM API throws. A caller can catch the whole
 * layer with one `catch (\DICOM\Exception\ExceptionInterface $e)`.
 */
interface ExceptionInterface extends \Throwable
{
}
