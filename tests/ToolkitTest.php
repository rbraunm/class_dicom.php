<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

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
