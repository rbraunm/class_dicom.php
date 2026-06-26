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
use DCMTK\Toolkit;
use DICOM\Dataset;
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
     * $onSoftenedFailure is the value returned on a softened failure -- or, for the
     * shims whose v1 contract returns the error text itself (the dicom_net methods),
     * a Closure that receives the caught exception and derives the value (typically
     * its message). Detection is by Closure instance, not is_callable, so a string
     * failure value (an output path, '') is always returned verbatim and never
     * mistaken for a callback.
     *
     * A v2 \InvalidArgumentException is treated separately. v1 was procedural and
     * never threw -- it passed the value on and returned whatever the tool produced
     * -- so where v2 now validates strictly and would abort, the shim honors v1's
     * non-fatal behavior (return the same v1-shaped value) and surfaces the rejection
     * as an E_USER_DEPRECATED rather than an E_USER_WARNING, because it marks usage
     * that is invalid in v2 going forward, not a runtime failure. The substrate stays
     * fail-loud; only the compatibility layer softens.
     *
     * @template T
     * @param callable():T $delegate
     * @param T|\Closure(\Throwable):T $onSoftenedFailure
     * @return T
     */
    public static function run(string $notice, callable $delegate, mixed $onSoftenedFailure): mixed
    {
        self::deprecate($notice);
        try {
            return $delegate();
        } catch (DICOMException | PACSException | ToolkitException $exception) {
            @trigger_error($exception->getMessage(), E_USER_WARNING);

            return self::softenedValue($onSoftenedFailure, $exception);
        } catch (\InvalidArgumentException $exception) {
            @trigger_error($exception->getMessage(), E_USER_DEPRECATED);

            return self::softenedValue($onSoftenedFailure, $exception);
        }
    }

    /** Resolve a softened-failure value: invoke a Closure deriver, else return verbatim. */
    private static function softenedValue(mixed $onSoftenedFailure, \Throwable $exception): mixed
    {
        return $onSoftenedFailure instanceof \Closure
            ? ($onSoftenedFailure)($exception)
            : $onSoftenedFailure;
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

    /**
     * Read every top-level tag from $file with dcmdump in name-rendering mode (no
     * -Un, so dcmdump maps well-known UIDs to dictionary names) and return a
     * "gggg,eeee" => value map. This is the shim-local counterpart to Dataset's
     * numeric read: the base Dataset always reads with -Un and never produces a
     * name-mapped value, so the name rendering -- and the parse that strips its
     * marker -- live here, not in core. A read failure (e.g. a missing file:
     * dcmdump exits non-zero with no output) yields an empty map, matching v1's
     * loose load_tags. A missing dcmdump binary throws a DCMTK exception for the
     * caller's soften layer.
     *
     * @return array<string, string>
     */
    public static function readNameRenderedTags(Toolkit $toolkit, string $file): array
    {
        $result = $toolkit->run('dcmdump', [
            '-q',
            '-M',
            '+L',
            '+R',
            (string) Dataset::DEFAULT_MAX_READ_LENGTH_KB,
            $file,
        ]);

        return self::parseNameRenderedDump($result->stdout);
    }

    /**
     * Parse dcmdump name-mode output into a "gggg,eeee" => value map. Mirrors the
     * shape Dataset parses, with one addition for this mode: dcmdump prints a
     * name-mapped UID as "=Name" (e.g. "=JPEGBaseline"), so a leading "=" is
     * stripped to yield the bare name. A bracketed value "[...]" (any unmapped
     * value, including a UID dcmdump could not name) has its brackets stripped,
     * exactly as the numeric read does. Values skipped by -M for exceeding +R are
     * omitted from the map.
     *
     * @return array<string, string>
     */
    public static function parseNameRenderedDump(string $dump): array
    {
        $pattern = '/^\((?<group>[0-9a-fA-F]{4}),(?<element>[0-9a-fA-F]{4})\) '
            . '(?<vr>..) (?<value>.*?) +# +(?<length>\d+), +\d+ /m';
        preg_match_all($pattern, $dump, $matches, PREG_SET_ORDER);

        $tags = [];
        foreach ($matches as $match) {
            $key = strtolower($match['group']) . ',' . strtolower($match['element']);
            $value = $match['value'];
            $length = (int) $match['length'];
            if ($value === '(not loaded)') {
                continue;
            }
            if ($length === 0) {
                $tags[$key] = '';
            } elseif ($value !== '' && $value[0] === '[' && str_ends_with($value, ']')) {
                $tags[$key] = substr($value, 1, -1);
            } elseif ($value !== '' && $value[0] === '=') {
                $tags[$key] = substr($value, 1);
            } else {
                $tags[$key] = $value;
            }
        }

        return $tags;
    }

    /**
     * Run a primary render, and on a substrate-layer failure fall back to a second
     * render -- reproducing v1's dcm_to_jpg/dcm_to_tn behavior of trying VOI window
     * 1 and dropping to min-max windowing for images with no stored window. Emits
     * the method deprecation once up front; when the fallback is actually engaged
     * it emits a second E_USER_DEPRECATED ($fallbackNotice) flagging that this
     * silent fallback is going away in v3. If the fallback also fails, the failure
     * is softened to an E_USER_WARNING (the caller still gets back its output path,
     * exactly as v1 returns the path regardless of success).
     *
     * @param callable():void $primary
     * @param callable():void $fallback
     */
    public static function runWithVoiFallback(
        string $notice,
        string $fallbackNotice,
        callable $primary,
        callable $fallback,
    ): void {
        self::deprecate($notice);
        try {
            $primary();

            return;
        } catch (DICOMException | PACSException | ToolkitException $primaryFailure) {
            @trigger_error($fallbackNotice, E_USER_DEPRECATED);
        }
        try {
            $fallback();
        } catch (DICOMException | PACSException | ToolkitException $fallbackFailure) {
            @trigger_error($fallbackFailure->getMessage(), E_USER_WARNING);
        }
    }

    /**
     * Apply a v1 "gggg,eeee" => value tag map to an existing file via Dataset::put.
     * A structurally malformed key (not two hex groups) is skipped with an
     * E_USER_WARNING rather than aborting the whole conversion -- v1 silently
     * ignored such keys, and the shim surfaces the skip instead of hiding it. A
     * Dataset::put that the toolkit rejects throws a marker for the caller's soften.
     *
     * @param array<string, string> $arr_info
     */
    public static function applyTags(string $path, array $arr_info): void
    {
        if ($arr_info === []) {
            return;
        }
        $dataset = new Dataset($path);
        foreach ($arr_info as $key => $value) {
            $parts = explode(',', (string) $key);
            if (count($parts) !== 2 || !ctype_xdigit($parts[0]) || !ctype_xdigit($parts[1])) {
                @trigger_error(
                    "ignored malformed tag key '{$key}' (expected \"GGGG,EEEE\").",
                    E_USER_WARNING,
                );

                continue;
            }
            $dataset->put(hexdec($parts[0]), hexdec($parts[1]), (string) $value);
        }
    }
}
