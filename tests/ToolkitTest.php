<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DCMTK\Exception\InvocationFailedException;
use DCMTK\Exception\UnexpectedOutputException;
use DCMTK\Toolkit;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

final class ToolkitTest extends TestCase
{
    public function testVersionReportsInstalledDCMTK(): void
    {
        $version = (new Toolkit())->version('dcmdump');

        $this->assertNotSame('', $version);
        $this->assertStringContainsStringIgnoringCase('dcmtk', $version);
    }

    public function testVersionThrowsInvocationFailedOnNonZeroExit(): void
    {
        // `false` exits non-zero regardless of arguments, so version() sees a
        // failed invocation rather than a version line.
        $this->expectException(InvocationFailedException::class);
        (new Toolkit())->version('false');
    }

    public function testVersionThrowsUnexpectedOutputOnEmptyVersionLine(): void
    {
        // A tool that exits 0 with no stdout: version() succeeds but has nothing
        // to parse, so it must raise rather than return an empty string.
        $dir = sys_get_temp_dir() . '/dcmtk-test-' . uniqid();
        mkdir($dir);
        $tool = 'quietzero';
        file_put_contents("{$dir}/{$tool}", "#!/bin/sh\nexit 0\n");
        chmod("{$dir}/{$tool}", 0o755);
        try {
            (new Toolkit($dir))->version($tool);
            $this->fail('expected UnexpectedOutputException');
        } catch (UnexpectedOutputException $caught) {
            $this->assertStringContainsString($tool, $caught->getMessage());
        } finally {
            unlink("{$dir}/{$tool}");
            rmdir($dir);
        }
    }

    public function testRunLogsCompletionAtDebugWithDuration(): void
    {
        $logger = new class extends AbstractLogger {
            /** @var list<array{level: mixed, message: string, context: array<string, mixed>}> */
            public array $records = [];

            public function log($level, string|\Stringable $message, array $context = []): void
            {
                $this->records[] = [
                    'level' => $level,
                    'message' => (string) $message,
                    'context' => $context,
                ];
            }
        };

        (new Toolkit(null, $logger))->run('dcmdump', ['--version']);

        $this->assertCount(1, $logger->records);
        $record = $logger->records[0];
        $this->assertSame(LogLevel::DEBUG, $record['level']);
        $this->assertSame('dcmdump', $record['context']['tool']);
        $this->assertSame(0, $record['context']['exitCode']);
        $this->assertArrayHasKey('durationSeconds', $record['context']);
        $this->assertIsFloat($record['context']['durationSeconds']);
    }

    public function testRunReturnsNonZeroExitAndCapturesStderr(): void
    {
        // dcmdump on a missing file: run() returns the non-zero result rather than
        // throwing, and the error text is captured from the stderr pipe (exercises
        // the concurrent drain on stderr).
        $result = (new Toolkit())->run('dcmdump', [__DIR__ . '/fixtures/does_not_exist.dcm']);

        $this->assertNotSame(0, $result->exitCode);
        $this->assertNotSame('', $result->stderr);
    }
}
