#!/usr/bin/env php
<?php

/**
 * Migration example -- render a DICOM image to a JPEG and a thumbnail.
 *
 * Before (v1, via the deprecated shim):
 *     $d = new dicom_convert; $d->file = $file;
 *     $d->dcm_to_jpg();   // wrote $file.jpg
 *     $d->dcm_to_tn();    // wrote $file_tn.jpg
 *
 * After (v2-native): DICOM\Convert -- one object, explicit output paths, no shim.
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
$convert->toJPEG($base . '.jpg');           // replaces dcm_to_jpg()
$convert->toThumbnail($base . '_tn.jpg');   // replaces dcm_to_tn()

echo "Wrote {$base}.jpg and {$base}_tn.jpg\n";

// Windowing defaults to the first stored VOI window (as in v1); pass a
// DICOM\Windowing or DICOM\Scale to toJPEG() to choose another.
