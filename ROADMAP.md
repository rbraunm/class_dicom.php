# Roadmap

## Priority #1 — Clean-room rewrite & Apache-2.0 relicensing

This package is a fork of Dean Vaughan's originally-unlicensed `class_dicom.php`, so the current `MIT` declaration asserts terms we can't grant and any refactor of the existing file inherits the same defect. The top priority is therefore a **from-scratch, clean-room reimplementation** — sole-authored, written without reference to the legacy source — released under **Apache-2.0**. This supersedes the "refactor preserving the API surface" framing previously attached to v2.0.0 below.

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

## v2.0.0 — clean-room rewrite (Apache-2.0)

A ground-up reimplementation written without reference to the legacy source (see [docs/v2-rewrite-plan.md](docs/v2-rewrite-plan.md) for the clean-room discipline and the licensing/provenance rationale). The result is sole-authored, Apache-2.0-licensed, installable via Composer with no manual configuration, modern in its conventions, and loud when something goes wrong. The design targets below describe the shape of the **new** code, not edits to the existing file.

### Language and structure

- **Namespaces and PSR-4 autoloading.** Move classes under a `Dicom\` namespace with a `src/` directory layout that Composer can autoload without a classmap.
- **Typed properties and return types.** Replace `var` declarations with typed, visibility-scoped properties. Add parameter and return type declarations to all public methods.
- **Exception-based error handling.** Every method that currently returns `0` or an empty string on failure should throw a descriptive exception. Silent failures are the primary source of bugs in the current codebase.
- **Configurable toolkit path.** Replace the top-level `define('TOOLKIT_DIR', ...)` with constructor injection or a configuration object. The library should be usable without editing source files.
- **Remove global functions.** `Execute()` and `is_dcm()` should move into appropriate classes or a utility namespace. `Execute()` specifically should validate that the binary exists before attempting to run it.

### DCMTK dependency management

- **Binary discovery.** Auto-detect DCMTK installation path via `which` / environment variable / constructor parameter, falling back to a configurable default. Throw on missing binaries at construction time, not at first use.
- **Version detection.** Read DCMTK version at startup and warn or fail on known-incompatible versions.
- **Windows path handling.** The current Windows detection works but the binary path construction is fragile. Consolidate into a single path resolver.

### Testing

- **CI pipeline.** GitHub Actions workflow running the existing pydicom/pynetdicom test suite on push. PHP 8.0, 8.1, 8.2, 8.3, 8.4 matrix against the current DCMTK package.
- **Error path coverage.** Tests for missing files, invalid DICOM, unreachable hosts, and malformed tags.
- **Fixture expansion.** Test against multiple transfer syntaxes (Implicit VR, Explicit VR, JPEG Baseline, JPEG Lossless, JPEG 2000) and modalities (CR, CT, MR, US, multi-frame).

## v2.x — feature expansion toward pydicom/pynetdicom parity

These are targeted additions where PHP users currently have to shell out to DCMTK or reach for a Python stack. Full pydicom parity is not the goal — the goal is covering the operations that matter in a PHP web application receiving, routing, and serving DICOM images.

### Native DICOM parsing (reduce DCMTK dependency)

DCMTK is developed and maintained by [OFFIS e.V.](https://www.offis.de/en/), a non-profit research institute in Oldenburg, Germany, and is distributed under a 3-clause BSD license. It is actively maintained on a roughly annual release cadence (3.7.0 in January 2026) with development continuing between releases — a healthy dependency, not an abandoned one. The motivation for reducing and eventually replacing it is **dependency footprint, not licensing**: every downstream consumer of this library implicitly takes on DCMTK as an external runtime dependency they must install and keep patched. Because it parses untrusted DICOM input, DCMTK receives security fixes over time (e.g. CVE-2025-14607, a memory-corruption bug in `dcmdata`), so depending on this library means accepting that patch-tracking responsibility. Eliminating the external toolchain entirely — the read path first, then conversion and networking — is the long-term aim the items below build toward.

- **Tag reading without dcmdump.** Parse the DICOM binary format directly in PHP for tag extraction. This removes the most common reason to shell out and makes the library usable on hosts without DCMTK installed (read-only use case).
- **Tag writing without dcmodify.** Binary-level tag insertion and modification for the common VR types (LO, PN, DA, TM, UI, SH, CS). Complex VRs (SQ, OW, OF) can remain DCMTK-dependent initially.
- **Transfer syntax detection.** Read the transfer syntax UID from file meta without a full tag parse, so `is_dcm()` can work without DCMTK.

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
