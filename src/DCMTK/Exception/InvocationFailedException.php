<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK\Exception;

/**
 * A DCMTK tool invocation did not complete cleanly: its process could not be
 * started, its output could not be read, or it ran and exited non-zero.
 */
class InvocationFailedException extends \RuntimeException implements ExceptionInterface
{
}
