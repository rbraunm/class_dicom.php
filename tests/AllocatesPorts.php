<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS\Tests;

/**
 * Allocates TCP ports that are free right now, for binding test servers (storescp
 * peers and the SCP under test). There is a small TOCTOU window between releasing
 * the probe socket and the real bind, which is fine for tests.
 */
trait AllocatesPorts
{
    private function freePort(): int
    {
        $server = @stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
        if ($server === false) {
            throw new \RuntimeException("Could not allocate a free port: {$errstr} ({$errno}).");
        }
        $name = stream_socket_get_name($server, false);
        fclose($server);
        $colon = strrpos($name, ':');
        $port = $colon === false ? 0 : (int) substr($name, $colon + 1);
        if ($port < 1) {
            throw new \RuntimeException("Could not parse an allocated port from '{$name}'.");
        }

        return $port;
    }
}
