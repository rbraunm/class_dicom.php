#!/usr/bin/env php
<?php

/**
 * Migration example -- compress a DICOM file (lossless JPEG by default).
 *
 * Before (v1, via the deprecated shim): read the transfer syntax by raw address,
 * then dicom_convert::compress():
 *     $d = new dicom_tag; $d->file = $file; $d->load_tags();
 *     $ts = $d->get_tag('0002', '0010');
 *     $c = new dicom_convert; $c->file = $file; $c->compress('compressed.dcm');
 *
 * After (v2-native): DICOM\Compress, and File::transferSyntaxUID() instead of a raw
 * address. The default mode is lossless, matching v1.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\Compress;
use DICOM\Compression;
use DICOM\File;

$path = $argv[1] ?? '';
if ($path === '' || !is_file($path)) {
    fwrite(STDERR, "USAGE: compress.php <FILE>\n");
    exit(1);
}

$source = File::open($path);
echo 'Original:   ' . $source->transferSyntaxUID() . ' (' . filesize($path) . " bytes)\n";

$out = sys_get_temp_dir() . '/compressed.dcm';
$result = (new Compress($source))->compress($out, Compression::lossless());

echo 'Compressed: ' . $result->transferSyntaxUID() . ' (' . filesize($out) . " bytes)\n";
