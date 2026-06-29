# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Removed

- The v1 compatibility shim (`dicom_tag`, `dicom_convert`, `dicom_net`, `is_dcm`, `Execute`). Deprecated in 2.0.0, it is removed here; the namespaced API is the only surface. This is a breaking change targeted for **3.0.0** and currently being soaked as a pre-release (RC).

## [2.0.0] - 2026-06-29

Complete clean-room rewrite of the library for modern PHP. Introduces a namespaced, fully-typed object API with exception-based error handling, alongside a drop-in compatibility layer so existing v1 code keeps running unchanged. Relicensed to Apache-2.0.

The library continues to drive the DCMTK command-line toolkit (a runtime dependency installed separately, not bundled).

### Added

- **Namespaced object API** under PSR-4 (`DICOM\`, `PACS\`, `DCMTK\`):
  - `DICOM\File` -- `open()` returns a typed `Dataset`; VR-validated typed accessors (`getText`, `getDate`, `getTime`, `getDateTime`, `getPersonName`, `getUID`, `getInteger`, `getDecimal`, `getTextList`) with matching setters; static `isDICOM()` detection.
  - `DICOM\Dataset` -- raw group/element access (`get`, `put`, `all`) for tags without a typed accessor.
  - `DICOM\Tag` -- enum of known tags.
  - `DICOM\Value\*` -- `Date`, `Time`, `DateTime`, `PersonName`, `UID` value objects with parsing, formatting, and component access.
  - `DICOM\Convert` -- `toJPEG`, `toThumbnail`, `toVideo` (multiframe), `fromJpeg`, `fromPdf`.
  - `DICOM\Compress` -- `compress` / `decompress` with a `Compression` factory (`losslessSV1`, `lossless`, `baseline`, `extended`).
  - `PACS\EchoSCU` (C-ECHO), `PACS\SCU` (C-STORE send: `send`, `sendDirectory`), `PACS\SCP` (C-STORE receive server), with `PACS\Peer`, `PACS\Association`, and `PACS\TransferSyntaxProposal` for connection, AE, and transfer-syntax negotiation.
  - `DCMTK\Toolkit` -- locates the DCMTK binaries (on `PATH` or an explicit directory).
- **Exception-based error model** -- `DICOM\Exception\IOException`, `PACS\Exception\NetworkException`, and `InvalidArgumentException` replace v1's sentinel return values; failures surface at the call site.
- **Backward-compatibility shim** -- the v1 global surface (`dicom_tag`, `dicom_convert`, `dicom_net`, `is_dcm`, `Execute`) reimplemented on top of v2, so v1.1.0 code runs unchanged while emitting deprecation notices that point at the v2 equivalents.
- **Independent integration test suite** -- conversions, tag operations, compression, and network calls are cross-validated with pydicom and pynetdicom, verifying that produced files are correct when read by a separate DICOM implementation rather than round-tripped through the tools that wrote them. CI runs the suite on PHP 8.5 + DCMTK.
- **Documentation** -- `README.md` rewritten v2-first with examples verified against live PHP and a full API reference; `docs/migration-v1-to-v2.md` with a per-element v1-to-v2 mapping; before/after migration recipes in `examples/`.

### Changed

- **License: relicensed from MIT to Apache-2.0.** The prior MIT declaration asserted terms the project could not grant (the 1.x line was a fork of an originally unlicensed library). The clean-room rewrite is sole-authored, written without reference to the legacy source, and released under Apache-2.0, with provenance recorded in `NOTICE`.
- **Minimum PHP raised to 8.5** (the 1.x line required 8.0+).
- Tag access is typed and VR-validated by default; raw `'gggg,eeee'`-style addressing remains available through `DICOM\Dataset` for tags without a typed accessor.
- Error handling moved from sentinel/return-code style to exceptions throughout.

### Fixed

- **JPEG-to-DICOM works on current DCMTK.** `Convert::fromJpeg()` generates the required UIDs directly and supplies tags via typed setters, replacing the v1 `dcm2xml` template path whose warning handling prevented pixel-data embedding. This resolves the `jpg_to_dcm()` issue tracked as a known limitation in 1.1.0.

### Deprecated

- The entire v1 global surface (`dicom_tag`, `dicom_convert`, `dicom_net`, `is_dcm`, `Execute`). It remains fully functional via the compatibility shim throughout the 2.x line but emits deprecation notices, and is scheduled for removal in 3.0.0.

### Notes

- No code is shared with the original `class_dicom.php` by Dean Vaughan, which is acknowledged as a conceptual predecessor only. See `NOTICE`.

## [1.1.0] - 2026-05-27

PHP 8.x compatibility, bug fixes, an integration test suite, and documentation, on the original procedural library. No breaking API changes from 1.0.0.

### Added

- Integration test suite (`tests/`) using pydicom and pynetdicom for independent cross-validation, so every conversion, tag operation, and network call is verified by a separate DICOM implementation rather than read back by the same tools that wrote it.
- Full `README.md` with usage examples verified against live PHP, an API reference, and testing instructions.
- `ROADMAP.md` outlining the planned v2.0.0 modern-PHP refactor and feature expansion.

### Changed

- Now requires PHP 8.0+ (declared in `composer.json`); tested through PHP 8.4.

### Fixed

- `compress()` was a silent no-op: an undefined variable meant the method did nothing on every call.
- `dcmcjpeg` and `dcmdjpeg` binary paths were swapped, so compress invoked the decompressor and vice versa. Corrected in both the Windows and Linux path blocks.
- PHP 8.2 dynamic property deprecations: added the missing `$template` and `$temp_dir` property declarations on `dicom_convert`.

### Known issues

- `jpg_to_dcm()` did not work on current DCMTK versions due to warning-handling logic that prevented pixel-data embedding. (Resolved in 2.0.0.)

## [1.0.0] - 2025-09-02

- Initial Packagist release of the procedural `class_dicom.php` library (a fork of the original by Dean Vaughan): DICOM tag read/write, JPEG conversion, compression, and DICOM send/receive, wrapping the DCMTK command-line tools.

[Unreleased]: https://github.com/rbraunm/class_dicom.php/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/rbraunm/class_dicom.php/compare/v1.1.0...v2.0.0
[1.1.0]: https://github.com/rbraunm/class_dicom.php/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/rbraunm/class_dicom.php/releases/tag/v1.0.0
