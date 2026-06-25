<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM;

use DCMTK\CommandResult;
use DCMTK\Exception\ExceptionInterface as DCMTKException;
use DCMTK\Process;
use DCMTK\Toolkit;
use DICOM\Exception\IOException;
use DICOM\Exception\ToolkitException;

/**
 * The boundary between the DICOM layer and the DCMTK substrate. It runs a DCMTK
 * tool -- translating any substrate failure (a missing tool, or a process that
 * could not start) into a DICOM-layer ToolkitException -- and checks file
 * readability, surfacing a missing or unreadable path as IOException. Detection
 * (File) and element access (Dataset) both go through here, so callers only ever
 * face DICOM\Exception\ExceptionInterface.
 */
final class Tool
{
    /**
     * @param list<string> $argv
     *
     * @throws ToolkitException the tool is missing or the process could not start
     */
    public static function run(Toolkit $toolkit, string $tool, array $argv): CommandResult
    {
        try {
            return $toolkit->run($tool, $argv);
        } catch (DCMTKException $e) {
            throw new ToolkitException(
                sprintf("DICOM toolkit failed running '%s': %s", $tool, $e->getMessage()),
                0,
                $e,
            );
        }
    }

    /**
     * Start a DCMTK tool as a background process (the async sibling of run),
     * returning a handle. Translates a substrate failure into a DICOM-layer
     * ToolkitException, so callers face only DICOM\Exception\ExceptionInterface.
     *
     * @param list<string> $argv
     *
     * @throws ToolkitException the tool is missing or the process could not start
     */
    public static function spawn(Toolkit $toolkit, string $tool, array $argv): Process
    {
        try {
            return $toolkit->start($tool, $argv);
        } catch (DCMTKException $e) {
            throw new ToolkitException(
                sprintf("DICOM toolkit failed starting '%s': %s", $tool, $e->getMessage()),
                0,
                $e,
            );
        }
    }

    /**
     * @throws IOException the path is missing or not readable
     */
    public static function assertReadable(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new IOException("File not readable: '{$path}'.");
        }
    }
}
