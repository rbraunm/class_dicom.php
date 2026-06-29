#!/usr/bin/env php
<?php

/**
 * Example -- C-STORE send one DICOM file.
 *
 * A Peer + Association drive PACS\SCU, which throws on failure. A
 * TransferSyntaxProposal controls negotiation.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\File;
use PACS\Association;
use PACS\Exception\NetworkException;
use PACS\Peer;
use PACS\SCU;

$path = $argv[1] ?? '';
if ($path === '' || !is_file($path)) {
    fwrite(STDERR, "USAGE: send_dcm.php <FILE> [host] [port]\n");
    exit(1);
}
$host = $argv[2] ?? 'localhost';
$port = (int) ($argv[3] ?? 104);

$peer = new Peer($host, $port, 'example');   // host, port, called AE
$association = new Association('DEANO');      // calling AE

// To negotiate a specific transfer syntax, pass a proposal:
//   new SCU($peer, $association, PACS\TransferSyntaxProposal::jpegLossless());
$scu = new SCU($peer, $association);

try {
    $scu->send(File::open($path));
    echo "Sent!\n";
} catch (NetworkException $exception) {
    fwrite(STDERR, $exception->getMessage() . "\n\nSomething bad happened!\n");
    exit(1);
}
