#!/usr/bin/env php
<?php

/**
 * Example -- post-reception handler invoked by store_server.
 *
 * storescp calls this once per received object with placeholder order
 * #p #f #c #a: storage dir, filename, called AE (the receiver), calling AE
 * (the sender).
 *
 * Uses a DICOM\File typed accessor.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\File;
use DICOM\Tag;

$dir = $argv[1] ?? '';
$name = $argv[2] ?? '';
$calledAE = $argv[3] ?? '';    // #c -- the AE we received as
$callingAE = $argv[4] ?? '';   // #a -- the AE that sent to us
$path = $dir . '/' . $name;

function logLine(string $message): void
{
    $line = date('Ymd G:i:s') . ' - ' . $message;
    file_put_contents(__DIR__ . '/dcm_temp/store_server.log', $line . "\n", FILE_APPEND);
    echo $line . "\n";
}

if ($name === '' || $dir === '' || !is_file($path)) {
    logLine("missing or nonexistent file: {$path}");
    exit(1);
}

$patient = File::open($path)->getPersonName(Tag::PatientName)?->toDICOM() ?? '(unknown)';
logLine("Received {$patient} (called AE {$calledAE} <- calling AE {$callingAE})");
