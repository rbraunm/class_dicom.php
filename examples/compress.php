#!/usr/bin/env php
<?php

/**
 * Example -- compress a DICOM file (lossless JPEG by default).
 *
 * Uses DICOM\Compress and File::transferSyntaxUID(). The default mode is
 * lossless SV1.
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
$result = (new Compress($source))->compress($out, Compression::losslessSV1());

echo 'Compressed: ' . $result->transferSyntaxUID() . ' (' . filesize($out) . " bytes)\n";
