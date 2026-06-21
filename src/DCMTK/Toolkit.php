<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DCMTK;

use DCMTK\Exception\BinaryNotFoundException;
use DCMTK\Exception\InvocationFailedException;
use DCMTK\Exception\UnexpectedOutputException;
use Psr\Log\LoggerInterface;

/**
 * The substrate every DICOM/PACS wrapper runs through: it locates DCMTK tools,
 * executes them without a shell, and returns a typed CommandResult. It does not
 * decide whether a non-zero exit is an error -- that is the caller's call, since
 * some tools (e.g. dcmftest) use a non-zero exit as a normal negative answer.
 */
final class Toolkit
{
    /** @var array<string, string> resolved tool name => absolute path */
    private array $located = [];

    /**
     * @param string|null $toolkitDirectory explicit directory holding the DCMTK
     *   binaries; when null, tools are resolved from PATH.
     * @param LoggerInterface|null $logger optional PSR-3 logger; when set, each
     *   completed invocation is logged at debug with the tool, exit code, and
     *   duration -- never the arguments, which can contain PHI in file paths.
     */
    public function __construct(
        private readonly ?string $toolkitDirectory = null,
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    /** Absolute path to a DCMTK tool; BinaryNotFoundException if it is not installed. */
    public function locate(string $tool): string
    {
        if (isset($this->located[$tool])) {
            return $this->located[$tool];
        }
        foreach ($this->candidatePaths($tool) as $candidate) {
            if (is_file($candidate) && is_executable($candidate)) {
                return $this->located[$tool] = $candidate;
            }
        }
        throw new BinaryNotFoundException(sprintf(
            "DCMTK tool '%s' not found (%s).",
            $tool,
            $this->toolkitDirectory !== null
                ? "looked in '{$this->toolkitDirectory}'"
                : 'searched PATH',
        ));
    }

    /**
     * Run a DCMTK tool and return the result. The tool is invoked directly (no
     * shell), so arguments need no escaping. Throws only when the tool is missing
     * or the process cannot be started; a non-zero exit is returned in the result
     * for the caller to interpret. Assumes bounded tool output (true for the
     * wrapped DCMTK tools); if a future tool can flood a pipe, this read loop
     * should move to stream_select.
     *
     * @param list<string> $argv
     */
    public function run(string $tool, array $argv): CommandResult
    {
        $binary = $this->locate($tool);
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $startedAt = microtime(true);
        $process = proc_open([$binary, ...$argv], $descriptors, $pipes);
        if (!is_resource($process)) {
            throw new InvocationFailedException("Could not start '{$binary}'.");
        }
        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);
        $durationSeconds = microtime(true) - $startedAt;

        // Debug-level only, and deliberately without argv: DICOM arguments are file
        // paths that can embed PHI, which must not reach logs.
        $this->logger?->debug('{tool} completed', [
            'tool' => $tool,
            'exitCode' => $exitCode,
            'durationSeconds' => round($durationSeconds, 4),
        ]);

        return new CommandResult(
            $binary,
            $argv,
            $exitCode,
            $stdout === false ? '' : $stdout,
            $stderr === false ? '' : $stderr,
            $durationSeconds,
        );
    }

    /**
     * First line of a tool's `--version` output (identifies the installed DCMTK).
     * Throws if the tool exits non-zero or emits no parseable version line; never
     * returns an empty string.
     */
    public function version(string $tool = 'dcmdump'): string
    {
        $result = $this->run($tool, ['--version']);
        if (!$result->succeeded()) {
            throw new InvocationFailedException(
                "'{$tool} --version' exited {$result->exitCode}: {$result->stderr}",
            );
        }
        $firstLine = strtok($result->stdout, "\n");
        $version = $firstLine === false ? '' : trim($firstLine);
        if ($version === '') {
            throw new UnexpectedOutputException(
                "'{$tool} --version' produced no parseable version line.",
            );
        }

        return $version;
    }

    /** @return list<string> */
    private function candidatePaths(string $tool): array
    {
        if ($this->toolkitDirectory !== null) {
            return [rtrim($this->toolkitDirectory, '/') . '/' . $tool];
        }
        $path = getenv('PATH');
        if ($path === false || $path === '') {
            return [];
        }
        $candidates = [];
        foreach (explode(PATH_SEPARATOR, $path) as $directory) {
            if ($directory === '') {
                continue;
            }
            $candidates[] = rtrim($directory, '/') . '/' . $tool;
        }

        return $candidates;
    }
}
