#!/usr/bin/env php
<?php

/**
 * Example -- build a DICOM image from a JPEG.
 *
 * Convert::fromJpeg() builds the Secondary Capture object and generates the
 * study/series/SOP UIDs (StudySeriesSource::generate()), then typed setters
 * fill the identifying tags.
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
