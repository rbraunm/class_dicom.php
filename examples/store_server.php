#!/usr/bin/env php
<?php

/**
 * Migration example -- run a C-STORE SCP that stores received objects and runs a
 * handler per object.
 *
 * Before (v1, via the deprecated shim):
 *     $d = new dicom_net;
 *     $d->store_server(104, './dcm_temp', './store_server_handler.php',
 *                      'store_server_config.cfg', 1);   // blocking
 *
 * After (v2-native): PACS\SCP, configured explicitly. start() returns a handle; the
 * loop reproduces v1's foreground (blocking) server. The handler runs as a bare
 * command with v1's #p #f #c #a placeholders appended (so it must be executable).
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
