<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use Compat\ShimContract;
use DICOM\Exception\IOException;
use PHPUnit\Framework\TestCase;

/**
 * Phase 6a: the shim scaffold -- the deprecate/delegate/soften contract helper,
 * Execute(), and is_dcm(). Each shim call is wrapped in a scoped error handler
 * (capture()) that records the E_USER_* notices and keeps them from reaching
 * PHPUnit's failOnWarning handler, which is exactly how a deprecation-aware caller
 * would observe them. Authored from the v1 footprint and observed behavior, never
 * the legacy source.
 */
final class CompatShimTest extends TestCase
{
    /** @var list<array{int, string}> */
    private array $captured = [];

    protected function tearDown(): void
    {
        ShimContract::$dcmdumpTimeoutSeconds = 5.0;
    }

    /**
     * Run $callable with a scoped handler that records E_USER_* notices and returns
     * true so they do not propagate to PHPUnit. Returns the callable's result.
     */
    private function capture(callable $callable): mixed
    {
        $this->captured = [];
        set_error_handler(function (int $errno, string $message): bool {
            $this->captured[] = [$errno, $message];

            return true;
        });
        try {
            return $callable();
        } finally {
            restore_error_handler();
        }
    }

    /** @return list<array{int, string}> */
    private function noticesOf(int $type): array
    {
        return array_values(array_filter(
            $this->captured,
            static fn (array $notice): bool => $notice[0] === $type,
        ));
    }

    private function fixture(string $name): string
    {
        return __DIR__ . '/fixtures/' . $name;
    }

    // ---- ShimContract::run -- the deprecate / delegate / soften contract --------

    public function testRunEmitsExactlyOneDeprecationAndReturnsDelegateResult(): void
    {
        $result = $this->capture(
            static fn (): string => ShimContract::run('dep', static fn (): string => 'ok', 'fallback'),
        );

        $this->assertSame('ok', $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
    }

    public function testRunSoftensLayerExceptionToFailureValueWithOneWarning(): void
    {
        $result = $this->capture(static fn (): string => ShimContract::run(
            'dep',
            static function (): string {
                throw new IOException('disk gone');
            },
            'fallback',
        ));

        $this->assertSame('fallback', $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $warnings = $this->noticesOf(E_USER_WARNING);
        $this->assertCount(1, $warnings);
        $this->assertStringContainsString('disk gone', $warnings[0][1]);
    }

    public function testRunLetsNonLayerExceptionPropagate(): void
    {
        $this->expectException(\RuntimeException::class);

        $this->capture(static fn (): mixed => ShimContract::run(
            'dep',
            static function (): void {
                throw new \RuntimeException('not a layer failure');
            },
            'fallback',
        ));
    }

    // ---- Execute ----------------------------------------------------------------

    public function testExecuteReturnsStdoutVerbatimWithoutTrim(): void
    {
        $result = $this->capture(static fn (): string => \Execute('printf "a\nb"'));

        $this->assertSame("a\nb", $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
    }

    public function testExecuteCapturesStdoutIncludingTrailingNewline(): void
    {
        $result = $this->capture(static fn (): string => \Execute('echo OUT'));

        $this->assertSame("OUT\n", $result);
    }

    public function testExecuteEmptyCommandReturnsEmptyString(): void
    {
        $result = $this->capture(static fn (): string => \Execute(''));

        $this->assertSame('', $result);
    }

    public function testExecuteDoesNotCaptureStderrFromCompoundCommand(): void
    {
        // v1 appends 2>&1, but for a compound command whose last stage redirects to
        // fd2 the redirect mis-binds, so the explicit stderr write leaks to the
        // parent and the return holds only the stdout stage.
        $result = $this->capture(static fn (): string => \Execute('echo OUT; echo ERR >&2'));

        $this->assertSame("OUT\n", $result);
    }

    // TODO: assert Execute() fails loud (throws) when proc_open cannot start a
    // shell. There is no reliable way to force a proc_open start failure in this
    // sandbox, so this is left as a tracked gap rather than a stub that would
    // inflate the pass count.

    // ---- is_dcm -----------------------------------------------------------------

    public function testIsDcmReturnsIntOneForDicomFileWithNoWarning(): void
    {
        // The literal v1 oracle `dcmdump -M +L +Qn <file>` exits 0 for a DICOM file,
        // so is_dcm reports 1 -- as an int, not a bool. The normal path emits only
        // the deprecation, no warning.
        $result = $this->capture(fn (): int => \is_dcm($this->fixture('tags_sample.dcm')));

        $this->assertSame(1, $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
    }

    public function testIsDcmReturnsIntZeroForNonDicomFileWithNoWarning(): void
    {
        // dcmdump exits non-zero on a file that is not DICOM, so is_dcm reports 0.
        $result = $this->capture(fn (): int => \is_dcm($this->fixture('not_dicom.bin')));

        $this->assertSame(0, $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
    }

    public function testIsDcmNeverThrowsAndReturnsIntZeroForAMissingPath(): void
    {
        // A missing file is not DICOM: dcmdump exits non-zero, is_dcm returns 0,
        // loosely (never throws), matching v1.
        $result = $this->capture(fn (): int => \is_dcm('/no/such/path/at/all.dcm'));

        $this->assertIsInt($result);
        $this->assertSame(0, $result);
    }

    // TODO: exercise the dcmdumpDetect wall-clock guard (warn + 0 when the tool
    // does not return). dcmdump returns promptly on the +Qn argv in practice, and
    // the literal-v1 argv is hardcoded by design, so a slow stand-in cannot be
    // injected without parameterizing the call to suit the test. Tracked, not
    // stubbed.
}
