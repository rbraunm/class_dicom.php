<?php

/**
 * Migration example -- read tags from a web request (prints dean.dcm's header).
 *
 * Before (v1): $d = new dicom_tag; $d->load_tags(); $d->get_tag('0010', '0010');
 * After (v2-native): typed accessors on DICOM\File, plus the full map when needed.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\File;
use DICOM\Tag;

header('Content-Type: text/plain; charset=utf-8');

$file = File::open(__DIR__ . '/dean.dcm');

echo 'Patient:  ' . $file->getPersonName(Tag::PatientName)?->toDICOM() . "\n";
echo 'Modality: ' . $file->getText(Tag::Modality) . "\n\n";

print_r($file->dataset()->all());
