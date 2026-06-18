# Roadmap

## v2.0.0 (priority #1) -- Clean-room rewrite & Apache-2.0 relicense

This package is a fork of Dean Vaughan's originally-unlicensed `class_dicom.php`, so the current `MIT` declaration asserts terms we can't grant, and any refactor of the existing file inherits the same defect. The fix is a **from-scratch, clean-room reimplementation** -- sole-authored, written without reference to the legacy source -- released under **Apache-2.0**. v2 faithfully replaces v1's public surface as a clean, typed PHP wrapper over DCMTK, and ships a backward-compatibility shim so existing Packagist consumers move to `^2` without code changes.

The full plan -- clean-room discipline, licensing and provenance artifacts, architecture, capability scope, research methodology, phased delivery, testing, and done criteria -- lives in **[docs/v2-rewrite-plan.md](docs/v2-rewrite-plan.md)** and is maintained there only. This roadmap intentionally does not restate it.

## v1.1.0 (current)

PHP 8.x compatibility fixes and an integration test suite.

- Fixed swapped `dcmcjpeg`/`dcmdjpeg` binary definitions (compress and decompress were calling each other's binaries)
- Fixed undefined variable in `compress()` that caused the method to silently do nothing
- Added missing property declarations on `dicom_convert` (`$template`, `$temp_dir`) to eliminate PHP 8.2 dynamic property deprecations
- Added `php >= 8.0` requirement to `composer.json`
- Added integration test suite with pydicom/pynetdicom cross-validation covering tags, conversions, compression, and DICOM networking

### Known issues

- `jpg_to_dcm()` returns early when `xml2dcm` produces any output, including non-fatal warnings. The bundled XML template triggers a SOPInstanceUID mismatch warning on current DCMTK versions, preventing the `img2dcm` step from embedding pixel data. The output file contains only a DICOM header with no image.

## v3 -- expansion beyond v1

v2 deliberately stops at v1's surface (see the plan). v3 is the post-v1 line: it drops the deprecated compatibility shim and grows the wrapper to cover more of the DCMTK toolset than v1 ever did. The goal is not full pydicom/pynetdicom parity but the operations that matter in a PHP web application receiving, routing, and serving DICOM images. Each item is another DCMTK tool wrapped under the same discipline as v2.

### DICOM networking

- **C-FIND (Query).** Query a remote PACS for studies, series, or instances by patient name, date range, modality, accession number, or study UID (`findscu`). The single most-requested DICOM network feature for web applications.
- **C-MOVE / C-GET (Retrieve).** Trigger a PACS to send images to a specified AE title, or pull them directly (`movescu` / `getscu`).
- **Association negotiation control.** Expose transfer syntax and abstract syntax negotiation so callers can control what gets proposed and accepted, rather than the fixed set v1's `send_dcm` hard-codes.
- **TLS support.** DICOM TLS for C-STORE and C-FIND, since many hospital networks now require encrypted DICOM traffic.

### Image handling

- **Pixel data access.** Decode pixel data into a PHP array or GD/Imagick resource for server-side processing without converting to JPEG first, including windowing and level adjustment.
- **JPEG 2000 support.** Beyond v1's JPEG baseline/lossless: JPEG 2000 lossless and lossy (transfer syntaxes 1.2.840.10008.1.2.4.90 and .91), where the DCMTK build provides it.
- **Multi-frame handling.** Extract individual frames as images without converting the whole stack to video. Frame-level access is essential for ultrasound and fluoroscopy workflows.

### Metadata and conformance

- **DICOMDIR support.** Read and write DICOMDIR files for media interchange (CD/DVD, portable media).
- **Structured report reading.** Parse SR documents (radiologist reports, CAD results) into a traversable PHP structure.
- **UID generation.** Generate conformant DICOM UIDs with a registered root, so files the library creates are traceable and don't collide.
- **Conformance statement.** Document which SOP classes, transfer syntaxes, and DIMSE services the library supports, in the format PACS administrators expect.
