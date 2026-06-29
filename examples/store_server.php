#!/usr/bin/env php
<?php

/**
 * Example -- run a C-STORE SCP that stores received objects and runs a handler
 * per object.
 *
 * PACS\SCP, configured explicitly. start() returns a handle; the loop runs a
 * foreground (blocking) server. The handler runs as a bare command with the
 * #p #f #c #a placeholders appended (so it must be executable).
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use PACS\SCP;

$port = (int) ($argv[1] ?? 104);
$storage = __DIR__ . '/dcm_temp';

$scp = new SCP(
    port: $port,
    outputDirectory: $storage,
    postReceiveCommand: __DIR__ . '/store_server_handler.php #p #f #c #a',
    forkPerAssociation: true,
    presentationConfigFile: __DIR__ . '/store_server_config.cfg',
    debug: true,
    disableHostLookup: true,
    acseTimeoutSeconds: 20,
    dimseTimeoutSeconds: 20,
);

$process = $scp->start();
echo "Listening on port {$port}; storing to {$storage}\n";

while ($process->isRunning()) {
    sleep(1);
}
