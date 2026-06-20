<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK\Exception;

/** A required DCMTK tool could not be located on PATH or in the configured directory. */
class BinaryNotFoundException extends \RuntimeException implements ExceptionInterface
{
}
