<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK\Exception;

/**
 * A DCMTK tool succeeded but produced output that could not be parsed as the
 * caller expected (e.g. a tag the parser required was absent).
 */
class UnexpectedOutputException extends \RuntimeException implements ExceptionInterface
{
}
