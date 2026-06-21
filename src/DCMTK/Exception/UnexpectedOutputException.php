<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK\Exception;

/**
 * A DCMTK tool exited successfully but produced output that could not be parsed
 * as expected (e.g. a `--version` invocation with no parseable version line).
 */
class UnexpectedOutputException extends \RuntimeException implements ExceptionInterface
{
}
