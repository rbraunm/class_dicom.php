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
    use CapturesUserNotices;

    protected function tearDown(): void
    {
        ShimContract::$dcmdumpTimeoutSeconds = 5.0;
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

    public function testRunDerivesFailureValueFromClosureOnSoftenedFailure(): void
    {
        $result = $this->capture(static fn (): string => ShimContract::run(
            'dep',
            static function (): string {
                throw new IOException('boom');
            },
            static fn (\Throwable $e): string => 'ERR:' . $e->getMessage(),
        ));

        $this->assertSame('ERR:boom', $result);
        $this->assertCount(1, $this->noticesOf(E_USER_DEPRECATED));
        $warnings = $this->noticesOf(E_USER_WARNING);
        $this->assertCount(1, $warnings);
        $this->assertStringContainsString('boom', $warnings[0][1]);
    }

    public function testRunDoesNotInvokeFailureClosureOnSuccess(): void
    {
        $result = $this->capture(static fn (): string => ShimContract::run(
            'dep',
            static fn (): string => 'ok',
            static function (\Throwable $e): string {
                throw new \RuntimeException('failure deriver must not run on success');
            },
        ));

        $this->assertSame('ok', $result);
    }

    public function testRunReturnsCallableStringFailureValueVerbatim(): void
    {
        // 'strlen' is a valid callable string; the Closure check (not is_callable)
        // must return it as-is rather than invoking it.
        $result = $this->capture(static fn (): string => ShimContract::run(
            'dep',
            static function (): string {
                throw new IOException('disk gone');
            },
            'strlen',
        ));

        $this->assertSame('strlen', $result);
    }

    public function testRunSoftensInvalidArgumentToDeprecationNotWarning(): void
    {
        $result = $this->capture(static fn (): string => ShimContract::run(
            'method is deprecated',
            static function (): string {
                throw new \InvalidArgumentException('AE title must be 1 to 16 characters');
            },
            'fallback',
        ));

        $this->assertSame('fallback', $result);
        // No warning -- a strict-validation rejection is surfaced as a deprecation.
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
        // Two deprecations: the method notice, plus the rejection message.
        $deprecations = $this->noticesOf(E_USER_DEPRECATED);
        $this->assertCount(2, $deprecations);
        $this->assertStringContainsString('AE title must be 1 to 16 characters', $deprecations[1][1]);
    }

    public function testRunInvalidArgumentWithClosureDeriverReturnsMessage(): void
    {
        $result = $this->capture(static fn (): string => ShimContract::run(
            'dep',
            static function (): string {
                throw new \InvalidArgumentException('port out of range');
            },
            static fn (\Throwable $e): string => $e->getMessage(),
        ));

        $this->assertSame('port out of range', $result);
        $this->assertSame([], $this->noticesOf(E_USER_WARNING));
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
