#!/usr/bin/env php
<?php

/**
 * Migration example -- decompress a DICOM file.
 *
 * Before (v1, via the deprecated shim):
 *     $c = new dicom_convert; $c->file = $file; $c->uncompress('uncompressed.dcm');
 *
 * After (v2-native): DICOM\Compress::decompress(), with File::transferSyntaxUID().
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\Compress;
use DICOM\File;

$path = $argv[1] ?? '';
if ($path === '' || !is_file($path)) {
    fwrite(STDERR, "USAGE: uncompress.php <FILE>\n");
    exit(1);
}

$source = File::open($path);
echo 'Original:     ' . $source->transferSyntaxUID() . ' (' . filesize($path) . " bytes)\n";

$out = sys_get_temp_dir() . '/uncompressed.dcm';
$result = (new Compress($source))->decompress($out);

echo 'Uncompressed: ' . $result->transferSyntaxUID() . ' (' . filesize($out) . " bytes)\n";
