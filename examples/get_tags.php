#!/usr/bin/env php
<?php

/**
 * Example -- read DICOM tags.
 *
 * Named, typed, validated accessors keyed by the Tag enum. Prefer the typed
 * accessors and fall back to the raw dataset only for tags without one.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\File;
use DICOM\Tag;

$path = $argv[1] ?? '';
if ($path === '' || !is_file($path)) {
    fwrite(STDERR, "USAGE: get_tags.php <FILE>\n");
    exit(1);
}

$file = File::open($path);

// Typed accessors: each returns a validated value (or value object), not a bare
// string parsed from an address. This is the v2 way to read a known tag.
echo 'Patient:     ' . $file->getPersonName(Tag::PatientName)?->toDICOM() . "\n";
echo 'Patient ID:  ' . $file->getText(Tag::PatientID) . "\n";
echo 'Modality:    ' . $file->getText(Tag::Modality) . "\n";
echo 'Study date:  ' . ($file->getDate(Tag::StudyDate)?->iso() ?? '(none)') . "\n";
echo 'SOP UID:     ' . $file->getUID(Tag::SOPInstanceUID)?->value . "\n";

// Need every tag (e.g. to dump the header)? The full map is still there,
// keyed "gggg,eeee":
print_r($file->dataset()->all());

// Only for a tag with no typed accessor, the raw address still works:
//   $file->dataset()->get(0x0028, 0x0010);
