<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

/**
 * Shared helper for the compat-shim tests. Runs a callable with a scoped error
 * handler that records the E_USER_* notices the shim emits and keeps them from
 * reaching PHPUnit's failOnWarning handler -- the same way a deprecation-aware
 * caller would observe them.
 */
trait CapturesUserNotices
{
    /** @var list<array{int, string}> */
    private array $captured = [];

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
}
