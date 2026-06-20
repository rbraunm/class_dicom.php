<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK\Exception;

/** A DCMTK tool ran but exited non-zero. Carries the CommandResult for context. */
class InvocationFailedException extends \RuntimeException implements ExceptionInterface
{
}
