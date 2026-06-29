#!/usr/bin/env php
<?php

/**
 * Example -- send every DICOM file in a directory, moving each sent file.
 *
 * PACS\SCU::send() per file (one Peer/Association reused), moving each file on
 * success. For a one-shot bulk send with no per-file tracking,
 * $scu->sendDirectory($dir) sends the whole directory in one association.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\File;
use PACS\Association;
use PACS\Exception\NetworkException;
use PACS\Peer;
use PACS\SCU;

$sourceDir = $argv[1] ?? '../temp';
$backupDir = $argv[2] ?? 'bk';
$host = $argv[3] ?? 'kif.sxrmedical.com';
$port = (int) ($argv[4] ?? 105);

if (!is_dir($sourceDir)) {
    fwrite(STDERR, "USAGE: send_directory.php <SOURCE_DIR> [backup_dir] [host] [port]\n");
    exit(1);
}
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0775, true);
}

$scu = new SCU(new Peer($host, $port, 'BK'), new Association('BK'));

foreach (glob($sourceDir . '/*') ?: [] as $file) {
    if (!is_file($file)) {
        continue;
    }
    echo "Sending " . basename($file) . "...\n";
    try {
        $scu->send(File::open($file));
        rename($file, $backupDir . '/' . basename($file));
        echo "Good Send\n";
    } catch (NetworkException $exception) {
        echo "Send Error: " . $exception->getMessage() . "\n";
    }
}

// One-call alternative (no per-file move): $scu->sendDirectory($sourceDir);
