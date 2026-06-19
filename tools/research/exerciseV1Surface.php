<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm

/*
 * Phase 0.5 -- drive the v1 public API over the example fixtures so the logging shims record which
 * external tool each operation invokes (and with what argv). This calls the documented public API
 * only -- it is usage, like the examples/ scripts, and never reads the library source. Before each
 * operation it writes an "### OP" marker into the shim log so the captured tool calls attribute to
 * the operation that made them.
 *
 * Not exercised here:
 *   - store_server: a blocking listener (storescp). Capture it in Phase 5 when the PACS wrapper is
 *     built; we already know the tool from the README.
 *   - multiframe_to_video: only run when a multiframe fixture path is passed (arg 2), since it needs
 *     a real multi-frame input (and ffmpeg) to reach the encode step.
 *
 * Usage:  V1_SHIM_LOG=/tmp/v1cap/shim.log php exerciseV1Surface.php <workspace> [multiframe.dcm]
 *   <workspace> must already hold copies of the fixtures (test.dcm, test.jpg, pdf.pdf,
 *   jpg_to_dcm.xml). The script chdir's there and writes its outputs there.
 */

declare(strict_types=1);

$legacy = dirname(__DIR__, 2) . '/class_dicom.php';
if (!is_file($legacy)) {
  fwrite(STDERR, "legacy library not found at {$legacy}\n");
  exit(1);
}
require $legacy;

$workspace = $argv[1] ?? '';
if ($workspace === '' || !is_dir($workspace)) {
  fwrite(STDERR, "usage: php exerciseV1Surface.php <workspace-dir> [multiframe.dcm]\n");
  exit(1);
}
$multiframe = $argv[2] ?? '';
chdir($workspace);

$log = getenv('V1_SHIM_LOG') ?: '';

function marker(string $text): void
{
  global $log;
  if ($log !== '') {
    file_put_contents($log, "### {$text}\n", FILE_APPEND);
  }
}

function op(string $name, callable $fn): void
{
  marker("OP: {$name}");
  try {
    $fn();
    fwrite(STDOUT, "[ok]    {$name}\n");
  } catch (Throwable $error) {
    fwrite(STDOUT, "[threw] {$name}: " . $error::class . ': ' . $error->getMessage() . "\n");
  }
}

function ensureDir(string $dir): void
{
  if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
  }
}

function workingCopy(string $source, string $destination): string
{
  if (!is_file($destination) && is_file($source)) {
    copy($source, $destination);
  }
  return $destination;
}

$dcm = 'test.dcm';
$jpg = 'test.jpg';
$pdf = 'pdf.pdf';
$xml = 'jpg_to_dcm.xml';

// Tag set mirrors the documented jpg_to_dcm example (examples/jpg_to_dcm.php).
$tagSet = [
  '0008,0012' => date('Ymd'),
  '0008,0013' => date('Gis'),
  '0008,0050' => 'ACCESSION123',
  '0008,0080' => 'General Hospital',
  '0008,0090' => 'Dr. Example',
  '0008,1030' => 'Study Description',
  '0008,103e' => 'Series Description',
  '0010,0010' => 'DOE^JOHN',
  '0010,0020' => 'PATIENT001',
  '0010,0030' => '19700101',
  '0010,0040' => 'M',
  '0010,21b0' => 'Patient History',
  '0010,4000' => 'Patient Comments',
  '0018,0015' => 'Head',
  '0020,000d' => '1.3.51.0.7.2822962297.26312.19209.44846.7354.10266.42',
  '0020,000e' => '1.3.51.5156.4083.' . date('Ymd') . '.42',
  '0020,0011' => '1',
  '0020,0012' => '1',
  '0020,0013' => '1',
];

// --- standalone functions ---
op('is_dcm(dicom)', function () use ($dcm) {
  is_dcm($dcm);
});
op('is_dcm(non-dicom)', function () {
  is_dcm(__FILE__);
});

// --- dicom_tag ---
op('dicom_tag::load_tags', function () use ($dcm) {
  $tag = new dicom_tag($dcm);
  $tag->load_tags();
});
op('dicom_tag::get_tag', function () use ($dcm) {
  $tag = new dicom_tag($dcm);
  $tag->get_tag('0010', '0010');
});
op('dicom_tag::write_tags', function () use ($dcm) {
  $tag = new dicom_tag();
  $tag->file = workingCopy($dcm, 'write_target.dcm');
  $tag->write_tags(['0010,0010' => 'DOE^JANE', '0008,0080' => 'Example Hospital']);
});

// --- dicom_convert ---
op('dicom_convert::dcm_to_jpg', function () use ($dcm) {
  $convert = new dicom_convert();
  $convert->file = workingCopy($dcm, 'tojpg.dcm');
  $convert->dcm_to_jpg();
});
op('dicom_convert::dcm_to_tn', function () use ($dcm) {
  $convert = new dicom_convert();
  $convert->file = workingCopy($dcm, 'totn.dcm');
  $convert->dcm_to_tn();
});
op('dicom_convert::compress', function () use ($dcm) {
  $convert = new dicom_convert();
  $convert->file = workingCopy($dcm, 'tocompress.dcm');
  $convert->compress('compressed.dcm');
});
op('dicom_convert::uncompress', function () {
  $source = is_file('compressed.dcm') ? 'compressed.dcm' : 'test.dcm';
  $convert = new dicom_convert();
  $convert->file = $source;
  $convert->uncompress('uncompressed.dcm');
});
op('dicom_convert::jpg_to_dcm', function () use ($jpg, $xml, $tagSet) {
  ensureDir('dcm_temp');
  $convert = new dicom_convert();
  $convert->jpg_file = $jpg;
  $convert->template = $xml;
  $convert->temp_dir = 'dcm_temp';
  $convert->jpg_to_dcm($tagSet);
});

// pdf_to_dcm / pdf_to_dcmcr are undocumented (no README usage, no example). The PDF input wiring is
// a guess (the generic `file` property); if it is wrong the op will [threw] before calling a tool,
// which the empty marker section will make obvious.
op('dicom_convert::pdf_to_dcm', function () use ($pdf, $tagSet) {
  ensureDir('dcm_temp');
  $convert = new dicom_convert();
  $convert->file = $pdf;
  $convert->temp_dir = 'dcm_temp';
  $convert->pdf_to_dcm($tagSet);
});
op('dicom_convert::pdf_to_dcmcr', function () use ($pdf, $tagSet) {
  ensureDir('dcm_temp');
  $convert = new dicom_convert();
  $convert->file = $pdf;
  $convert->temp_dir = 'dcm_temp';
  $convert->pdf_to_dcmcr($tagSet);
});

if ($multiframe !== '' && is_file($multiframe)) {
  op('dicom_convert::multiframe_to_video', function () use ($multiframe) {
    ensureDir('video_temp');
    $convert = new dicom_convert();
    $convert->file = workingCopy($multiframe, 'multiframe.dcm');
    $convert->multiframe_to_video('mp4', 24, 'video_temp');
  });
} else {
  marker('OP: dicom_convert::multiframe_to_video (skipped: no multiframe fixture)');
  fwrite(STDOUT, "[skip]  dicom_convert::multiframe_to_video (no multiframe fixture passed)\n");
}

// --- dicom_net (no peer; the tools log their argv, then fail -- fine for capture) ---
op('dicom_net::echoscu', function () {
  $net = new dicom_net();
  $net->echoscu('127.0.0.1', 11112, 'CAP_AE', 'CAP_AE');
});
op('dicom_net::send_dcm', function () use ($dcm) {
  $net = new dicom_net();
  $net->file = $dcm;
  $net->send_dcm('127.0.0.1', 11112, 'CAP_AE', 'CAP_AE');
});

fwrite(STDOUT, "\ndone. shim log: " . ($log !== '' ? $log : '(V1_SHIM_LOG not set)') . "\n");
