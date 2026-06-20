<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK\Exception;

/**
 * A DCMTK tool invocation failed: either its process could not be started, or it
 * ran and exited non-zero.
 */
class InvocationFailedException extends \RuntimeException implements ExceptionInterface
{
}
