# class_dicom.php

A PHP library for working with DICOM medical images: tag reading and writing, JPEG conversion, compression, multiframe-to-video, and DICOM networking (C-ECHO, C-STORE send and receive). It drives the [DCMTK](https://dicom.offis.de/dcmtk.php.en) command-line toolkit under a typed, namespaced PHP API.

Version 2 is a clean-room rewrite on PHP 8.5 with a first-class object API (`DICOM\*`, `PACS\*`) and value objects for dates, names, and UIDs. The original procedural surface (`dicom_tag`, `dicom_convert`, `dicom_net`, and the global helpers) is preserved as a compatibility shim so v1 code keeps running unchanged -- it now emits deprecation notices pointing at the v2 equivalents. See [Migrating from v1](#migrating-from-v1).

Acknowledges the original `class_dicom.php` by Dean Vaughan ([deanvaughan.org](http://www.deanvaughan.org/projects/class_dicom_php/)) as a conceptual predecessor; v2 shares no code with it (see [NOTICE](NOTICE)).

## Requirements

- PHP 8.5 or later (CLI or web)
- [DCMTK](https://dicom.offis.de/dcmtk.php.en) command-line utilities on `PATH`
- `ffmpeg` (only for multiframe-to-video)

On Debian/Ubuntu:

```bash
apt install php-cli dcmtk ffmpeg
```

DCMTK tools are resolved from `PATH` by default. If your installation lives elsewhere, construct a `DCMTK\Toolkit` with the directory and hand it to whichever object you use (every entry point accepts an optional `Toolkit`):

```php
use DCMTK\Toolkit;
use DICOM\File;

$toolkit = new Toolkit('/opt/dcmtk/bin');
$file = File::open('/path/to/image.dcm', $toolkit);
```

## Installation

```bash
composer require rbraunm/class_dicom
```

Then load Composer's autoloader (`require __DIR__ . '/vendor/autoload.php';`). There is no single file to copy -- the library is autoloaded.

## Quick start

### Reading tags

```php
use DICOM\File;
use DICOM\Tag;

$file = File::open('/path/to/image.dcm');

// Typed accessors, keyed by the Tag enum -- validated values, not raw strings.
$patient  = $file->getPersonName(Tag::PatientName)?->toDICOM();
$modality = $file->getText(Tag::Modality);
$study    = $file->getDate(Tag::StudyDate)?->iso();
$sopUid   = $file->getUID(Tag::SOPInstanceUID)?->value;

// The full tag map, keyed "gggg,eeee":
$all = $file->dataset()->all();

// A tag with no typed accessor, by raw address:
$rows = $file->dataset()->get(0x0028, 0x0010);
```

### Writing tags

Typed setters take validated value objects and persist in place:

```php
use DICOM\Value\PersonName;

$file->setPersonName(Tag::PatientName, PersonName::fromDICOM('DOE^JOHN'));
$file->setText(Tag::InstitutionName, 'General Hospital');

// Raw write for a tag without a typed setter:
(new DICOM\Dataset('/path/to/image.dcm'))->put(0x0010, 0x0010, 'DOE^JOHN');
```

### DICOM to JPEG

```php
use DICOM\Convert;

$convert = new Convert(File::open('/path/to/image.dcm'));
$convert->toJPEG('/tmp/image.jpg', quality: 90);     // windowing defaults to the first VOI window
$convert->toThumbnail('/tmp/image_tn.jpg', widthPixels: 200);
```

### JPEG to DICOM

`Convert::fromJpeg()` builds a Secondary Capture object and generates the study, series, and SOP UIDs; fill identifying tags with typed setters afterward. No XML template is required.

```php
use DICOM\Value\Date;

$file = Convert::fromJpeg(['/path/to/photo.jpg'], '/tmp/out.dcm');
$file->setPersonName(Tag::PatientName, PersonName::fromDICOM('DOE^JOHN'));
$file->setText(Tag::PatientID, 'PATIENT001');
$file->setDate(Tag::PatientBirthDate, Date::fromYearMonthDay(1970, 1, 1));
```

### Compression

```php
use DICOM\Compress;
use DICOM\Compression;

$source = File::open('/path/to/image.dcm');
$compressed = (new Compress($source))->compress('/tmp/compressed.dcm', Compression::losslessSV1());
$plain      = (new Compress($source))->decompress('/tmp/uncompressed.dcm');

echo $compressed->transferSyntaxUID();   // e.g. 1.2.840.10008.1.2.4.70
```

### Multiframe to video

```php
use DICOM\FrameTiming;
use DICOM\VideoFormat;

$convert = new Convert(File::open('/path/to/multiframe.dcm'));
$convert->toVideo('/tmp/clip.mp4', FrameTiming::framesPerSecond(24.0), VideoFormat::mp4());
```

### Networking

```php
use DICOM\File;
use PACS\Association;
use PACS\EchoSCU;
use PACS\Peer;
use PACS\SCP;
use PACS\SCU;
use PACS\TransferSyntaxProposal;

$peer = new Peer('192.168.1.100', 104, 'REMOTE_AE');   // host, port, called AE
$association = new Association('MY_AE');                 // calling AE

// C-ECHO (verification) -- throws PACS\Exception\NetworkException on failure.
(new EchoSCU($peer, $association))->verify();

// C-STORE send. Pass a TransferSyntaxProposal to control negotiation.
$scu = new SCU($peer, $association, TransferSyntaxProposal::jpegLossless());
$scu->send(File::open('/path/to/image.dcm'));
$scu->sendDirectory('/path/to/dir');

// C-STORE receive. start() returns a handle; loop for a foreground server.
$scp = new SCP(
    port: 11112,
    outputDirectory: '/var/dicom/incoming',
    postReceiveCommand: '/path/to/handler.php #p #f #c #a',   // dir, file, called AE, calling AE
    forkPerAssociation: true,
    presentationConfigFile: '/path/to/store_server_config.cfg',
);
$process = $scp->start();
while ($process->isRunning()) {
    sleep(1);
}
```

## Migrating from v1

Existing v1 code runs unchanged against the compatibility shim, which emits deprecation notices:

```php
$d = new dicom_tag('/path/to/image.dcm');   // deprecated; use DICOM\File
$d->load_tags();
$name = $d->get_tag('0010', '0010');
```

The `examples/` directory contains a worked migration for every operation: each script shows the v1 form as a "Before" block and the runnable v2-native "After" that bypasses the shim. A full element-by-element mapping lives in [`docs/migration-v1-to-v2.md`](docs/migration-v1-to-v2.md).

A few migration notes:

- v1's raw `'gggg,eeee'` addresses were only necessary because v1 had no typed access. Prefer the typed accessors; the raw `Dataset` get/put remains for tags without one.
- v1's `jpg_to_dcm()` XML template is gone -- `Convert::fromJpeg()` generates the UIDs and typed setters supply the tags.
- `dicom_net::$transfer_syntax` was inert in v1 (it set nothing); the shim keeps it inert and warns. Use `PACS\TransferSyntaxProposal` with `PACS\SCU` for real negotiation.

## Testing

The suite runs under PHPUnit, with independent oracles (pydicom and pynetdicom) validating that files the library produces are correct when read by a separate implementation -- not just round-tripped through the same tools that wrote them.

```bash
# System packages
apt install php-cli dcmtk ffmpeg

# Python oracle packages
pip install pydicom pynetdicom Pillow numpy

composer install
composer test
```

## API reference

### v2 API

| Namespace / class | Purpose |
|---|---|
| `DICOM\File` | Open a file; typed get/set accessors keyed by the `Tag` enum |
| `DICOM\Dataset` | Raw tag access by group/element (`get`, `put`, `all`) |
| `DICOM\Tag` | Enum of known tags |
| `DICOM\Convert` | JPEG render, thumbnail, JPEG/PDF import, multiframe video |
| `DICOM\Compress` | Compress / decompress pixel data |
| `DICOM\Value\*` | `PersonName`, `Date`, `Time`, `DateTime`, `UID` value objects |
| `PACS\EchoSCU` | C-ECHO verification |
| `PACS\SCU` | C-STORE send (`send`, `sendDirectory`) |
| `PACS\SCP` | C-STORE receive server |
| `PACS\Peer` / `PACS\Association` / `PACS\TransferSyntaxProposal` | Connection, AE, and negotiation settings |
| `DCMTK\Toolkit` | Locates the DCMTK binaries (PATH or an explicit directory) |

### Compatibility shim (deprecated)

| Class / function | v2 replacement |
|---|---|
| `dicom_tag` | `DICOM\File` / `DICOM\Dataset` |
| `dicom_convert` | `DICOM\Convert` / `DICOM\Compress` |
| `dicom_net` | `PACS\EchoSCU` / `PACS\SCU` / `PACS\SCP` |
| `is_dcm($file)` | `DICOM\File::isDICOM($path)` |
| `Execute($command)` | `DCMTK\Tool` (internal) |

## Examples

Each script in `examples/` is a v1-to-v2 migration recipe.

| File | Operation |
|---|---|
| `get_tags.php`, `get_tags_webbased.php` | Read tags |
| `write_tags.php` | Write tags |
| `dcm_to_jpg.php` | Render to JPEG + thumbnail |
| `jpg_to_dcm.php` | Build a DICOM from a JPEG |
| `compress.php`, `uncompress.php` | Compress / decompress |
| `send_dcm.php` | C-STORE send one file |
| `send_directory.php` | Send and archive a directory |
| `store_server.php`, `store_server_handler.php`, `store_server_config.cfg` | C-STORE receive server |

## Acknowledgments

This library wraps [DCMTK](https://dicom.offis.de/dcmtk.php.en), the DICOM Toolkit developed and maintained by [OFFIS e.V.](https://www.offis.de/en/), a non-profit research institute in Oldenburg, Germany. DCMTK is distributed under a 3-clause BSD license that permits this use freely; it is credited and linked here as a matter of attribution and courtesy, not obligation. DCMTK is a runtime dependency you install separately -- this library invokes its command-line tools and does not bundle or redistribute them.

## License

Apache-2.0. See [LICENSE](LICENSE) and [NOTICE](NOTICE).

---

Supported in part by the work of [OneSourceIT](https://onesourceit.us/open-source.html).
