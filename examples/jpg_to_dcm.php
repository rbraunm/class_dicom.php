#!/usr/bin/env php
<?php

/**
 * Migration example -- build a DICOM image from a JPEG.
 *
 * Before (v1, removed in v3): a dcm2xml template (jpg_to_dcm.xml) full of
 * (gggg,eeee) placeholders, filled from a raw $tags array, with study/series/SOP
 * UIDs hand-built in the template:
 *     $d = new dicom_convert;
 *     $d->jpg_file = 'test.jpg'; $d->template = 'jpg_to_dcm.xml'; $d->temp_dir = 'dcm_temp';
 *     $dcm = $d->jpg_to_dcm(['0010,0010' => 'VAUGHAN^DEAN', '0020,000d' => '...', ...]);
 *
 * After (v2-native): Convert::fromJpeg() builds the Secondary Capture object and
 * GENERATES the study/series/SOP UIDs (StudySeriesSource::generate()), then typed
 * setters fill the identifying tags. No template and no hand-built UIDs -- the old
 * jpg_to_dcm.xml is obsolete.
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DICOM\Convert;
use DICOM\Tag;
use DICOM\Value\Date;
use DICOM\Value\PersonName;

$jpg = $argv[1] ?? (__DIR__ . '/test.jpg');
if (!is_file($jpg)) {
    fwrite(STDERR, "USAGE: jpg_to_dcm.php <JPEG>\n");
    exit(1);
}

$out = sys_get_temp_dir() . '/jpg_to_dcm_demo.dcm';

// Defaults: SOPClass::secCapture() and StudySeriesSource::generate().
$file = Convert::fromJpeg([$jpg], $out);

$file->setPersonName(Tag::PatientName, PersonName::fromDICOM('VAUGHAN^DEAN'));
$file->setText(Tag::PatientID, 'ID12345');
$file->setDate(Tag::PatientBirthDate, Date::fromYearMonthDay(1970, 3, 3));
$file->setText(Tag::PatientSex, 'M');
$file->setText(Tag::AccessionNumber, 'ACCESSION123');
$file->setText(Tag::StudyDescription, 'Study Description');
$file->setText(Tag::SeriesDescription, 'Series Description');
$file->setText(Tag::BodyPartExamined, 'HEAD');

echo "New file is {$out}\n";
