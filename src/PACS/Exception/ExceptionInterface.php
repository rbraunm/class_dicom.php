<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Exception;

/**
 * Marker for every exception the PACS networking API throws. A caller can catch
 * the whole layer with one `catch (\PACS\Exception\ExceptionInterface $e)`.
 */
interface ExceptionInterface extends \Throwable
{
}
