<?php

/**
 * Example -- read tags from a web request (prints dean.dcm's header).
 *
 * Typed accessors on DICOM\File, plus the full map when needed.
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
