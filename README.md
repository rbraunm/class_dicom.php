# class_dicom.php

A PHP library for working with DICOM medical images. Handles tag reading and writing, JPEG conversion, compression, and DICOM networking (C-ECHO, C-STORE send and receive) by wrapping the [DCMTK](https://dicom.offis.de/dcmtk.php.en) command-line toolkit.

Originally created by Dean Vaughan ([deanvaughan.org](http://www.deanvaughan.org/projects/class_dicom_php/)).

## Requirements

- PHP 8.0 or later (CLI or web)
- [DCMTK](https://dicom.offis.de/dcmtk.php.en) command-line utilities installed and accessible

By default the library looks for DCMTK binaries in `/usr/local/bin`. If your installation is elsewhere, edit the `TOOLKIT_DIR` constant at the top of `class_dicom.php`.

On Debian/Ubuntu:

```bash
apt install php-cli dcmtk
```

## Installation

### Composer

```bash
composer require rbraunm/class_dicom
```

### Manual

Copy `class_dicom.php` into your project and require it directly:

```php
require_once('class_dicom.php');
```

## Usage

### Reading DICOM tags

```php
$d = new dicom_tag('/path/to/image.dcm');
$patient_name = $d->get_tag('0010', '0010');
$modality     = $d->get_tag('0008', '0060');

// All loaded tags are available in $d->tags as an associative array
// keyed by "group,element" (e.g. "0010,0010")
```

The constructor calls `load_tags()` automatically if the file exists and passes the `is_dcm()` check. Tags can also be loaded manually:

```php
$d = new dicom_tag;
$d->file = '/path/to/image.dcm';
$d->load_tags();
```

### Writing DICOM tags

```php
$d = new dicom_tag('/path/to/image.dcm');
$d->write_tags([
    '0010,0010' => 'DOE^JOHN',
    '0008,0080' => 'General Hospital',
]);
```

This modifies the file in place using `dcmodify`.

### Converting DICOM to JPEG

```php
$c = new dicom_convert('/path/to/image.dcm');

// Full-size JPEG
$c->jpg_quality = 90;  // 0-100, default 100
$jpg_path = $c->dcm_to_jpg();

// Thumbnail
$c->tn_size = 200;  // width in pixels, default 125
$tn_path = $c->dcm_to_tn();
```

### Compression and decompression

```php
$c = new dicom_convert('/path/to/image.dcm');

// Decompress to a new file (or omit the argument to overwrite)
$c->uncompress('/path/to/output.dcm');

// JPEG lossless compress
$c->compress('/path/to/compressed.dcm');
```

### Converting JPEG to DICOM

> **Known issue:** `jpg_to_dcm()` treats any output from `xml2dcm` as a fatal error. The bundled XML template (`examples/jpg_to_dcm.xml`) produces a SOPInstanceUID mismatch warning on current DCMTK versions, which causes the function to return early without embedding pixel data. The resulting file is a valid DICOM header but contains no image. This will be fixed in v2.0.0.

The intended usage (once fixed) follows the pattern in `examples/jpg_to_dcm.php`:

```php
$c = new dicom_convert;
$c->jpg_file  = '/path/to/photo.jpg';
$c->template  = '/path/to/jpg_to_dcm.xml';  // see examples/jpg_to_dcm.xml
$c->temp_dir  = '/tmp/dcm_temp';

$dcm_path = $c->jpg_to_dcm([
    '0008,0012' => date('Ymd'),
    '0008,0013' => date('Gis'),
    '0008,0050' => 'ACCESSION123',
    '0008,0080' => 'General Hospital',
    '0008,0090' => 'Dr. Smith',
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
]);
```

The tag keys must match the `(group,element)` placeholders in the XML template. See `examples/jpg_to_dcm.php` for the full tag mapping.

### Multiframe DICOM to video

```php
$c = new dicom_convert('/path/to/multiframe.dcm');
$video_path = $c->multiframe_to_video('mp4', 24, '/tmp/video_temp');
```

Requires `ffmpeg` on the system.

### DICOM networking

```php
$n = new dicom_net;

// C-ECHO (DICOM ping)
$result = $n->echoscu('192.168.1.100', 104, 'MY_AE', 'REMOTE_AE');
// Returns 0 on success, error output string on failure

// C-STORE send (single file)
$n->file = '/path/to/image.dcm';
$n->send_dcm('192.168.1.100', 104, 'MY_AE', 'REMOTE_AE');

// C-STORE send (batch — all files in the same directory)
$n->file = '/path/to/image.dcm';
$n->send_dcm('192.168.1.100', 104, 'MY_AE', 'REMOTE_AE', 1);

// C-STORE receive (blocking — starts a DICOM listener)
$n->store_server(
    11112,                              // port
    '/var/dicom/incoming',              // storage directory
    '/path/to/handler_script.php',      // called after each file received
    '/path/to/store_server_config.cfg', // storescp config
);
```

See `examples/store_server.php`, `examples/store_server_handler.php`, and `examples/store_server_config.cfg` for a working receive setup.

### Utility functions

```php
// Check if a file is valid DICOM
if (is_dcm('/path/to/file')) {
    // it's DICOM
}
```

## Testing

The test suite uses PHP + DCMTK for the code under test and Python for independent validation. This ensures DICOM files produced by the library are verified by a completely separate implementation, not just read back by the same tools that wrote them.

### Test dependencies

```bash
# System packages
apt install php-cli dcmtk

# Python packages
pip install pydicom pynetdicom Pillow numpy
```

### Running tests

```bash
python3 tests/test_class_dicom.py
```

The test runner exercises every public method against real DICOM files:

- Tag reads are cross-validated against pydicom
- Tag writes are confirmed by both PHP re-read and pydicom
- JPEG conversions are validated with Pillow (magic bytes, full decode, dimension matching)
- Compress/uncompress cycles verify transfer syntax changes, demographic preservation, and pixel data integrity
- Network operations run against a pynetdicom SCP that confirms C-ECHO events server-side and validates C-STORE round-trips down to pixel-level array equality

## API reference

### Classes

| Class | Purpose |
|-------|---------|
| `dicom_tag` | Read and write DICOM tags via dcmdump/dcmodify |
| `dicom_convert` | Image format conversion, compression, thumbnails |
| `dicom_net` | DICOM networking: C-ECHO, C-STORE SCU/SCP |

### Standalone functions

| Function | Purpose |
|----------|---------|
| `is_dcm($file)` | Returns 1 if the file is valid DICOM, 0 otherwise |
| `Execute($command)` | Shell execution wrapper (captures stdout + stderr) |

## Examples

The `examples/` directory contains working scripts for common operations:

| File | Description |
|------|-------------|
| `get_tags.php` | Read and display tags from a DICOM file |
| `get_tags_webbased.php` | Same, formatted for browser output |
| `write_tags.php` | Modify tags in a DICOM file |
| `dcm_to_jpg.php` | Convert DICOM to JPEG |
| `jpg_to_dcm.php` | Convert JPEG to DICOM with custom tags |
| `jpg_to_dcm.xml` | XML template for JPEG-to-DICOM conversion |
| `compress.php` | JPEG lossless compress a DICOM file |
| `uncompress.php` | Decompress a DICOM file |
| `send_dcm.php` | Send a DICOM file to a remote host |
| `send_directory.php` | Send all files in a directory |
| `store_server.php` | Start a DICOM receive server |
| `store_server_handler.php` | Handler script called after each received file |
| `store_server_config.cfg` | Configuration for the receive server |

## License

MIT
