<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
//
// Clean-room note: this file is newly authored. The legacy class_dicom.php source
// was never read; the v1 surface the shim re-exposes was reconstructed from the
// reflected footprint, the published README/examples, and empirical blackbox runs.
declare(strict_types=1);

namespace Compat;

use DCMTK\Exception\ExceptionInterface as ToolkitException;
use DICOM\Exception\ExceptionInterface as DICOMException;
use PACS\Exception\ExceptionInterface as PACSException;

/**
 * Internal helper shared by the v1 compatibility shim. It centralizes the one
 * shape every shim entry follows -- deprecate, delegate, soften -- and owns the
 * process primitives the global shim functions need. This is not part of the
 * public surface, so the house drinkingCamelCaseWithABBR naming applies here,
 * never to the snake_case v1 functions/classes the shim must match verbatim.
 */
final class ShimContract
{
    /**
     * Wall-clock limit for the dcmdump invocation behind is_dcm(). The literal v1
     * argv returns promptly on a healthy toolchain; this guard is defensive, so a
     * dcmdump that stalls (a corrupt file, a wedged filesystem) cannot block the
     * caller indefinitely. Configurable so a deployment -- or a test -- can tune it
     * without touching the call sites.
     */
    public static float $dcmdumpTimeoutSeconds = 5.0;

    private function __construct()
    {
    }

    /**
     * Emit a single deprecation notice. Suppressed with @ so that upgrading a
     * working v1 call to v2 cannot turn fatal under a strict (throw-on-deprecation)
     * error handler; a handler that opts in -- a test, or deprecation tooling --
     * still receives it.
     */
    public static function deprecate(string $notice): void
    {
        @trigger_error($notice, E_USER_DEPRECATED);
    }

    /**
     * The shim contract: deprecate, delegate, soften. Emits one E_USER_DEPRECATED,
     * runs the delegate, and on a substrate-layer failure -- the DICOM, PACS, or
     * DCMTK marker interface -- emits an E_USER_WARNING and returns the v1-shaped
     * failure value instead of letting the exception propagate. Any other throwable
     * propagates untouched: the softening is deliberately narrow, so a genuine
     * programming error still fails loud.
     *
     * @template T
     * @param callable():T $delegate
     * @param T $onSoftenedFailure
     * @return T
     */
    public static function run(string $notice, callable $delegate, mixed $onSoftenedFailure): mixed
    {
        self::deprecate($notice);
        try {
            return $delegate();
        } catch (DICOMException | PACSException | ToolkitException $exception) {
            @trigger_error($exception->getMessage(), E_USER_WARNING);

            return $onSoftenedFailure;
        }
    }

    /**
     * Execute()'s engine. Runs the command through a shell with v1's `2>&1`
     * appended, captures stdout, and lets stderr inherit the parent process. That
     * reproduces v1 exactly, including the compound-command quirk: when the command
     * already redirects fd1 (e.g. `cmd >&2`), the appended `2>&1` mis-binds and the
     * stderr text leaks to the parent rather than being captured. The returned
     * string is verbatim -- no trim. A genuine inability to start the shell fails
     * loud rather than masquerading as empty output.
     */
    public static function shellCapture(string $command): string
    {
        $command .= ' 2>&1';
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => fopen('php://stderr', 'w'),
        ];
        $process = proc_open($command, $descriptors, $pipes);
        if (!is_resource($process)) {
            throw new \RuntimeException("Execute() could not start a shell for: {$command}");
        }
        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        proc_close($process);

        return $stdout === false ? '' : $stdout;
    }

    /**
     * is_dcm()'s engine. Issues v1's literal `dcmdump -M +L +Qn <file>` and maps
     * the result to 1/0 -- preserving v1's use of dcmdump (not dcmftest) as the
     * detection oracle. dcmdump exits 0 for a DICOM file and non-zero otherwise, so
     * 1 means DICOM and 0 means not. The call is wall-clock guarded: if it does not
     * finish in time the process is killed, an E_USER_WARNING is emitted, and 0 is
     * returned so the caller is never blocked. Never throws.
     */
    public static function dcmdumpDetect(string $binary, string $file): int
    {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = proc_open([$binary, '-M', '+L', '+Qn', $file], $descriptors, $pipes);
        if (!is_resource($process)) {
            @trigger_error("is_dcm(): could not start dcmdump for '{$file}'.", E_USER_WARNING);

            return 0;
        }
        fclose($pipes[0]);
        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $deadline = microtime(true) + self::$dcmdumpTimeoutSeconds;
        $timedOut = false;
        while (true) {
            $status = proc_get_status($process);
            // Drain both pipes each tick so a tool that fills one cannot deadlock.
            stream_get_contents($pipes[1]);
            stream_get_contents($pipes[2]);
            if (!$status['running']) {
                break;
            }
            if (microtime(true) >= $deadline) {
                $timedOut = true;
                proc_terminate($process, 9);
                break;
            }
            usleep(20000);
        }
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        if ($timedOut) {
            @trigger_error(
                "is_dcm(): dcmdump did not return within " . self::$dcmdumpTimeoutSeconds
                . "s for '{$file}'; returning 0.",
                E_USER_WARNING,
            );

            return 0;
        }

        return $exitCode === 0 ? 1 : 0;
    }
}
