<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Tests;

/**
 * Creates temp directories for a test and removes them on teardown. Shared by the
 * networking suites, which need scratch space for received objects and send
 * sources.
 */
trait ManagesTempDirs
{
    /** @var list<string> */
    private array $managedTempDirs = [];

    private function tempDir(string $prefix = 'pacs_'): string
    {
        $dir = sys_get_temp_dir() . '/' . $prefix . bin2hex(random_bytes(6));
        if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException("Could not create temp dir {$dir}.");
        }
        $this->managedTempDirs[] = $dir;

        return $dir;
    }

    protected function cleanupTempDirs(): void
    {
        foreach ($this->managedTempDirs as $dir) {
            $this->removeDir($dir);
        }
        $this->managedTempDirs = [];
    }

    private function removeDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        foreach (scandir($dir) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $path = $dir . '/' . $entry;
            is_dir($path) ? $this->removeDir($path) : @unlink($path);
        }
        @rmdir($dir);
    }
}
