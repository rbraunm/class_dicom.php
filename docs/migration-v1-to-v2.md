# Migrating from class_dicom.php v1 to v2

Version 2 keeps the entire v1 surface working through a compatibility shim, so existing code runs unchanged. Each shim call emits an `E_USER_DEPRECATED` notice naming its v2 replacement. This document maps every v1 element to its v2 home; the [`examples/`](../examples) directory has a runnable migration for each operation.

## How the shim behaves

- Every v1 class (`dicom_tag`, `dicom_convert`, `dicom_net`) and global function (`is_dcm`, `Execute`) is still callable and still honors its v1 return contract.
- Each call triggers a deprecation notice. Run with `E_DEPRECATED | E_USER_DEPRECATED` visible to find remaining v1 usage; when none fire, the shim can be removed.
- **The error model changes when you go native.** v1 returned sentinel values (e.g. `echoscu`/`send_dcm` return `0` on success or an error string); the v2 classes throw typed exceptions instead. Migrating a call means adopting its v2 error handling.

## Global functions

| v1 | v2 | Notes |
|---|---|---|
| `is_dcm($file)` | `DICOM\File::isDICOM($path): bool` | v1 returned `1`/`0`; v2 returns `bool`. |
| `Execute($command)` | *(no equivalent)* | Shell execution is intentionally outside the v2 substrate. Use PHP's own process facilities if you need it. |

## dicom_tag -> DICOM\File / DICOM\Dataset

Read with typed accessors keyed by the `DICOM\Tag` enum -- v1's raw `'gggg,eeee'` addresses existed only because typed access did not. Fall back to the raw `Dataset` only for tags without a typed accessor.

| v1 | v2 | Example |
|---|---|---|
| `new dicom_tag($file)` / `load_tags()` | `DICOM\File::open($path)` | [get_tags.php](../examples/get_tags.php) |
| `$d->tags` (full map) | `$file->dataset()->all()` | [get_tags.php](../examples/get_tags.php) |
| `$d->get_tag('0010', '0010')` | `$file->getPersonName(Tag::PatientName)` (typed) or `$file->dataset()->get(0x0010, 0x0010)` (raw) | [get_tags.php](../examples/get_tags.php) |
| `$d->write_tags(['0010,0010' => $v])` | `$file->setPersonName(Tag::PatientName, PersonName::fromDICOM($v))` / `setText` / ... (typed) or `(new Dataset($path))->put(0x0010, 0x0010, $v)` (raw) | [write_tags.php](../examples/write_tags.php) |
| `$d->file` | the path passed to `File::open()` / `new Dataset()` | |

Typed accessors: `getText`/`setText`, `getInteger`/`setInteger`, `getDecimal`/`setDecimal`, `getDate`/`setDate`, `getTime`/`setTime`, `getDateTime`/`setDateTime`, `getPersonName`/`setPersonName`, `getUID`/`setUID`, `getTextList`/`setTextList`. The structured ones return/accept value objects in `DICOM\Value\*` (`Date`, `Time`, `DateTime`, `PersonName`, `UID`).

## dicom_convert -> DICOM\Convert / DICOM\Compress

| v1 | v2 | Example |
|---|---|---|
| `dcm_to_jpg()` | `(new Convert(File::open($f)))->toJPEG($out, quality: $q)` | [dcm_to_jpg.php](../examples/dcm_to_jpg.php) |
| `dcm_to_tn()` | `(new Convert(File::open($f)))->toThumbnail($out, widthPixels: $w)` | [dcm_to_jpg.php](../examples/dcm_to_jpg.php) |
| `jpg_to_dcm($tags)` (+ `template`, `temp_dir`) | `Convert::fromJpeg([$jpg], $out)` then typed setters | [jpg_to_dcm.php](../examples/jpg_to_dcm.php) |
| `pdf_to_dcm($info)` | `Convert::fromPdf($pdf, $out)` | |
| `pdf_to_dcmcr($info)` | `Convert::fromPdf($pdf, $out)` | |
| `compress($out)` | `(new Compress(File::open($f)))->compress($out, Compression::losslessSV1())` | [compress.php](../examples/compress.php) |
| `uncompress($out)` | `(new Compress(File::open($f)))->decompress($out)` | [uncompress.php](../examples/uncompress.php) |
| `multiframe_to_video($fmt, $fps, $tmp)` | `(new Convert(File::open($f)))->toVideo($out, FrameTiming::framesPerSecond($fps), VideoFormat::mp4())` | |

Property and behavior changes:

- `jpg_quality` -> the `quality:` argument to `toJPEG()`; `tn_size` -> `widthPixels:` on `toThumbnail()`.
- `template` is **obsolete**. `Convert::fromJpeg()` builds the Secondary Capture object and generates the study/series/SOP UIDs; there is no XML template. The old `jpg_to_dcm.xml` is no longer used.
- `temp_dir` is managed internally by `Convert`/`toVideo()`; you no longer supply one.
- `multiframe_to_video()` in v1 accepted a format string; v2 supports MP4 (`VideoFormat::mp4()`). `toVideo()` also exposes richer timing via `FrameTiming` (frames-per-second, seconds-per-frame, repeat-each-frame).
- `compress()` defaults to lossless SV1 (`...1.2.4.70`), matching v1; other modes are `Compression::lossless()`, `::baseline($q)`, `::extended($q)`.

## dicom_net -> PACS\EchoSCU / PACS\SCU / PACS\SCP

| v1 | v2 | Example |
|---|---|---|
| `echoscu($h, $p, $my, $rem)` | `(new EchoSCU(new Peer($h, $p, $rem), new Association($my)))->verify()` | [send_dcm.php](../examples/send_dcm.php) |
| `send_dcm($h, $p, $my, $rem)` | `(new SCU(new Peer($h, $p, $rem), new Association($my)))->send(File::open($f))` | [send_dcm.php](../examples/send_dcm.php) |
| `send_dcm(..., 1)` (batch) | `$scu->sendDirectory(dirname($f))` | [send_directory.php](../examples/send_directory.php) |
| `store_server($port, $dir, $handler, $cfg, $debug)` | `new SCP(port: $port, outputDirectory: $dir, postReceiveCommand: "$handler #p #f #c #a", presentationConfigFile: $cfg, debug: (bool) $debug, forkPerAssociation: true)` then `->start()` | [store_server.php](../examples/store_server.php) |

Property and behavior changes:

- **Error model:** `echoscu`/`send_dcm` returned `0` or an error string; `EchoSCU::verify()` and `SCU::send()` throw `PACS\Exception\NetworkException`. `store_server` blocked the process; `SCP::start()` returns an `SCPProcess` handle -- loop on `isRunning()` for a foreground server.
- `transfer_syntax` was **inert** in v1 (it set nothing on the wire). For real transfer-syntax negotiation pass a `PACS\TransferSyntaxProposal` (`automatic`, `uncompressed`, `implicitVRLittleEndian`, `jpegLossless`, `jpegBaseline`, `jpegExtended`) as the third `SCU` argument.
- The handler runs as a bare command with v1's placeholders appended: `#p #f #c #a` = storage dir, filename, **called** AE (the receiver), **calling** AE (the sender). It must be executable with a shebang.
- The shim's tunable properties (`echo_*_timeout`, `send_*_timeout`, `server_*_timeout`, `fork`, `disable_host_lookup`, `blocking`) map to constructor arguments in v2: `Association($callingAE, $acse, $dimse, $connection)` for echo/send, and `SCP(... acseTimeoutSeconds:, dimseTimeoutSeconds:, forkPerAssociation:, disableHostLookup:)` for the server. v2 blocking is just looping on `SCPProcess::isRunning()`.

## Pointing at a non-PATH DCMTK

v1 used the `TOOLKIT_DIR` constant. In v2, construct a `DCMTK\Toolkit` with the directory and pass it to any entry point (all accept an optional `Toolkit`):

```php
$toolkit = new DCMTK\Toolkit('/opt/dcmtk/bin');
$file = DICOM\File::open($path, $toolkit);
```

## Verifying a migration is complete

Run your application with deprecation notices visible:

```php
error_reporting(E_ALL);   // includes E_DEPRECATED and E_USER_DEPRECATED
```

Every remaining shim call logs its v2 replacement. When a run produces no deprecation notices, the code is fully on the v2 API and the compatibility shim can be dropped.
