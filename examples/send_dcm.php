#!/usr/bin/env php
<?php

/**
 * Migration example -- C-STORE send one DICOM file.
 *
 * Before (v1, via the deprecated shim):
 *     $d = new dicom_net; $d->file = $file;
 *     $out = $d->send_dcm('localhost', '104', 'DEANO', 'example');  // 0 ok, error string on fail
 *     // $d->transfer_syntax was accepted but did nothing.
 *
 * After (v2-native): a Peer + Association drive PACS\SCU, which throws on failure.
 * The real payoff: a TransferSyntaxProposal actually controls negotiation, where
 * v1's transfer_syntax property was inert.
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

// To actually negotiate a transfer syntax (v1 could not), pass a proposal:
//   new SCU($peer, $association, PACS\TransferSyntaxProposal::jpegLossless());
$scu = new SCU($peer, $association);

try {
    $scu->send(File::open($path));
    echo "Sent!\n";
} catch (NetworkException $exception) {
    fwrite(STDERR, $exception->getMessage() . "\n\nSomething bad happened!\n");
    exit(1);
}
