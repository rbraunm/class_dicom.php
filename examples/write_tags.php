#!/usr/bin/env php
<?php

/**
 * Example -- write DICOM tags.
 *
 * Typed setters that take validated value objects and persist in place. Prefer
 * these; the raw Dataset::put() remains for tags without a setter. This demo
 * copies the source first so the bundled fixture is never mutated.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\File;
use DICOM\Tag;
use DICOM\Value\PersonName;

$source = $argv[1] ?? (__DIR__ . '/dean.dcm');
if (!is_file($source)) {
    fwrite(STDERR, "USAGE: write_tags.php <FILE>\n");
    exit(1);
}

$path = sys_get_temp_dir() . '/write_tags_demo.dcm';
copy($source, $path);

$file = File::open($path);
$file->setPersonName(Tag::PatientName, PersonName::fromDICOM('VAUGHAN^DEAN'));
$file->setText(Tag::InstitutionName, 'DEANLAND, AR');

echo "Wrote tags to {$path}\n";

$check = File::open($path);
echo 'PatientName:     ' . $check->getPersonName(Tag::PatientName)?->toDICOM() . "\n";
echo 'InstitutionName: ' . $check->getText(Tag::InstitutionName) . "\n";

// For a tag without a typed setter, the raw write still works:
//   (new DICOM\Dataset($path))->put(0x0008, 0x0080, 'DEANLAND, AR');
