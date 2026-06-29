#!/usr/bin/env php
<?php

/**
 * Example -- render a DICOM image to a JPEG and a thumbnail.
 *
 * Uses DICOM\Convert: one object, with explicit output paths.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\Convert;
use DICOM\File;

$path = $argv[1] ?? '';
if ($path === '' || !is_file($path)) {
    fwrite(STDERR, "USAGE: dcm_to_jpg.php <FILE>\n");
    exit(1);
}

$base = sys_get_temp_dir() . '/' . pathinfo($path, PATHINFO_FILENAME);
$convert = new Convert(File::open($path));
$convert->toJPEG($base . '.jpg');
$convert->toThumbnail($base . '_tn.jpg');

echo "Wrote {$base}.jpg and {$base}_tn.jpg\n";

// Windowing defaults to the first stored VOI window; pass a
// DICOM\Windowing or DICOM\Scale to toJPEG() to choose another.
