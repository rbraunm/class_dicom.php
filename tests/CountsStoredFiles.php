<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Tests;

/**
 * Counts and waits for files written by a receiver. storescp stores received
 * objects asynchronously while the association is open, so the send call can
 * return a hair before the file lands; the wait helpers poll briefly rather than
 * assuming the file is already there.
 */
trait CountsStoredFiles
{
    private function fileCount(string $dir): int
    {
        $count = 0;
        foreach (scandir($dir) ?: [] as $entry) {
            if ($entry !== '.' && $entry !== '..' && is_file($dir . '/' . $entry)) {
                $count++;
            }
        }

        return $count;
    }

    private function waitForFileCount(string $dir, int $expected, float $timeoutSeconds = 3.0): int
    {
        $deadline = microtime(true) + $timeoutSeconds;
        do {
            $count = $this->fileCount($dir);
            if ($count >= $expected) {
                return $count;
            }
            usleep(50000);
        } while (microtime(true) < $deadline);

        return $this->fileCount($dir);
    }

    private function waitForFile(string $path, float $timeoutSeconds = 3.0): bool
    {
        $deadline = microtime(true) + $timeoutSeconds;
        do {
            if (is_file($path)) {
                return true;
            }
            usleep(50000);
        } while (microtime(true) < $deadline);

        return is_file($path);
    }
}
