# Roadmap

## Priority #1 -- Clean-room rewrite & Apache-2.0 relicensing

This package is a fork of Dean Vaughan's originally-unlicensed `class_dicom.php`, so the current `MIT` declaration asserts terms we can't grant and any refactor of the existing file inherits the same defect. The top priority is therefore a **from-scratch, clean-room reimplementation** -- sole-authored, written without reference to the legacy source -- released under **Apache-2.0**. This supersedes the "refactor preserving the API surface" framing previously attached to v2.0.0 below.

Full plan, clean-room discipline, licensing artifacts, and phased delivery: **[docs/v2-rewrite-plan.md](docs/v2-rewrite-plan.md)**.

## v1.1.0 (current)

PHP 8.x compatibility fixes and an integration test suite.

- Fixed swapped `dcmcjpeg`/`dcmdjpeg` binary definitions (compress and decompress were calling each other's binaries)
- Fixed undefined variable in `compress()` that caused the method to silently do nothing
- Added missing property declarations on `dicom_convert` (`$template`, `$temp_dir`) to eliminate PHP 8.2 dynamic property deprecations
- Added `php >= 8.0` requirement to `composer.json`
- Added integration test suite with pydicom/pynetdicom cross-validation covering tags, conversions, compression, and DICOM networking

### Known issues

- `jpg_to_dcm()` returns early when `xml2dcm` produces any output, including non-fatal warnings. The bundled XML template triggers a SOPInstanceUID mismatch warning on current DCMTK versions, preventing the `img2dcm` step from embedding pixel data. The output file contains only a DICOM header with no image.

## v2.0.0 -- clean-room rewrite (Apache-2.0)

A ground-up reimplementation written without reference to the legacy source (see [docs/v2-rewrite-plan.md](docs/v2-rewrite-plan.md) for the clean-room discipline and the licensing/provenance rationale). The result is sole-authored, Apache-2.0-licensed, installable via Composer with no manual configuration, modern in its conventions, and loud when something goes wrong. The design targets below describe the shape of the **new** code, not edits to the existing file.

Because this package has external Packagist consumers, v2 ships a backward-compatibility shim that preserves the v1 public surface with deprecation warnings, delegating into the new classes; the shim replaces the legacy file rather than shipping it (see [docs/v2-rewrite-plan.md](docs/v2-rewrite-plan.md) §7).

### Language and structure

- **Namespaces and PSR-4 autoloading.** Move classes under peer `DICOM\` and `PACS\` namespaces (plus a `DCMTK\` namespace housing the operations implemented via DCMTK), `src/` layout, Composer-autoloadable without a classmap. PACS networking is split out as a peer rather than conflated into the DICOM class as in v1; casing follows the project's acronym convention. See [docs/v2-rewrite-plan.md](docs/v2-rewrite-plan.md) §4.
- **Typed properties and return types.** Replace `var` declarations with typed, visibility-scoped properties. Add parameter and return type declarations to all public methods.
- **Exception-based error handling.** Every method that currently returns `0` or an empty string on failure should throw a descriptive exception. Silent failures are the primary source of bugs in the current codebase.
- **Configurable toolkit path.** Replace the top-level `define('TOOLKIT_DIR', ...)` with constructor injection or a configuration object. The library should be usable without editing source files.
- **Remove global functions.** `Execute()` and `is_dcm()` should move into appropriate classes or a utility namespace. `Execute()` specifically should validate that the binary exists before attempting to run it.

### Native-first, DCMTK only where needed

The design is native-first (see [docs/v2-rewrite-plan.md](docs/v2-rewrite-plan.md) §4-§5): parsing, tag read/write, transfer-syntax detection, Implicit<->Explicit VR conversion, JPEG->DICOM encapsulation, and uncompressed image rendering are pure PHP and need nothing installed beyond PHP. DCMTK is the chosen implementation only where native is not viable -- realistically the compressed pixel codecs, and possibly DIMSE networking. This is a design-time choice per capability, not a runtime toggle.

- **Discovery on first use, not at startup.** For the operations that use DCMTK, its path is resolved (constructor / env var / PATH) the first time such an operation runs, via a single cross-platform resolver; a missing binary throws a descriptive exception at that point. Native operations never trigger discovery.
- **Version detection on first use,** with a clear error on a known-incompatible version.
- **The DCMTK that gets used** is maintained by [OFFIS e.V.](https://www.offis.de/en/), a non-profit research institute in Oldenburg, under a 3-clause BSD license, actively maintained (3.7.0, January 2026). Because it parses untrusted input it receives security fixes (e.g. CVE-2025-14607 in `dcmdata`), so a consumer using a DCMTK-backed operation takes on tracking a patched version. Consumers using only native operations take on no such dependency.

### Testing

- **CI pipeline.** GitHub Actions workflow running the existing pydicom/pynetdicom test suite on push. PHP 8.5 against the current DCMTK package (the baseline and latest stable; add 8.6 to the matrix when it releases).
- **Error path coverage.** Tests for missing files, invalid DICOM, unreachable hosts, and malformed tags.
- **Fixture expansion.** Test against multiple transfer syntaxes (Implicit VR, Explicit VR, JPEG Baseline, JPEG Lossless, JPEG 2000) and modalities (CR, CT, MR, US, multi-frame).

## v2.x -- feature expansion toward pydicom/pynetdicom parity

These are targeted additions where PHP users currently have to shell out to DCMTK or reach for a Python stack. Full pydicom parity is not the goal -- the goal is covering the operations that matter in a PHP web application receiving, routing, and serving DICOM images.

### DICOM networking

- **C-FIND (Query).** Query a remote PACS for studies, series, or instances by patient name, date range, modality, accession number, or study UID. This is the single most-requested DICOM network feature for web applications.
- **C-MOVE / C-GET (Retrieve).** Trigger a PACS to send images to a specified AE title, or pull them directly.
- **Association negotiation control.** Expose transfer syntax and abstract syntax negotiation so callers can control what gets proposed and accepted. The current `send_dcm` hard-codes a small set of known syntaxes.
- **TLS support.** DICOM TLS for C-STORE and C-FIND, since many hospital networks now require encrypted DICOM traffic.

### Image handling

- **Pixel data access.** Decode pixel data into a PHP array or GD/Imagick resource for server-side image processing without converting to JPEG first. Support for windowing and level adjustment.
- **JPEG 2000 support.** The current compress/uncompress only handles JPEG baseline/lossless. Add JPEG 2000 lossless and lossy (transfer syntaxes 1.2.840.10008.1.2.4.90 and .91).
- **Multi-frame handling.** Extract individual frames as images without converting the entire stack to video. Frame-level access is essential for ultrasound and fluoroscopy workflows.

### Metadata and conformance

- **DICOM-DIR support.** Read and write DICOMDIR files for media interchange (CD/DVD burning, portable media).
- **Structured report reading.** Parse SR documents (radiologist reports, CAD results) into a traversable PHP structure.
- **UID generation.** Generate conformant DICOM UIDs with a registered root, so files created by the library are traceable and don't collide.
- **Conformance statement.** Document which SOP classes, transfer syntaxes, and DIMSE services the library supports, in the format PACS administrators expect.
