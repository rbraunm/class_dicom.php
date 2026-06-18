# v2.0.0 -- Clean-Room Rewrite & Apache-2.0 Relicensing

**Status:** Planned · roadmap priority #1
**Outcome:** a from-scratch reimplementation of this library, sole-authored, released under Apache-2.0, native-first (pure PHP wherever viable) with DCMTK used only for the operations where native is not.

---

## 1. Why a rewrite and not a refactor

This package began as a fork of Dean Vaughan's `class_dicom.php` (originally published ~2011 at deanvaughan.org, mirrored at `github.com/vedicveko/class_dicom.php`). That original was **published without any license**, which under default copyright means all rights are reserved by its author. The `"license": "MIT"` currently declared in this fork's `composer.json` is therefore not backed by a grant from the original author for the portions he wrote -- it asserts terms we are not in a position to grant.

The current file is a **derivative work**. Refactoring it -- renaming methods, adding types, reorganizing internals -- produces another derivative work and carries the same defect forward. No amount of editing the existing source converts it into something we can license freely.

The clean fix is to **stop deriving**. A ground-up reimplementation, written without reference to the legacy source, is original expression authored solely by this project's maintainer. That code can be licensed under Apache-2.0 cleanly, with no dependency on the original author's rights.

Functionality is not the issue: DICOM operations, the use of DCMTK command-line tools, and a class's public capabilities are facts and ideas, not protected expression. We are free to build a library that *does the same things*. What we must not reuse is the original's **expression** -- its specific code, structure, and comments.

> **Contacting Dean Vaughan is a dead path -- do not pursue it.** A prior PR to his repo went unanswered, and his GitHub profile is years dormant. That experiment has already been run. The rewrite does not depend on his cooperation and does not need it: clean-room reimplementation establishes our own clean Apache-2.0 footing outright.

---

## 2. Clean-room discipline

These rules exist to keep the provenance of v2 defensible. They are not optional.

- **The legacy `class_dicom.php` is not opened, read, or referenced during v2 implementation.** Not for "just checking how it did X." The whole value of the exercise evaporates if the new code is written with the old code in view.
- **Implementation is written only from:** the DICOM standard (NEMA PS3, freely published), the DCMTK tool documentation (`storescu`, `storescp`, `dcmdump`, `dcmodify`, `dcmj2pnm`, `img2dcm`, `dcmcjpeg`, `dcmdjpeg`, `echoscu`, etc.), and the functional capability list in §5 below -- which describes *what* the library does, derived from behavior and public docs, never *how* the original expressed it.
- **No expression carries over:** no copied lines, no transcribed method bodies, no replicated internal structure, no original comments. Public capability names that are dictated by the domain (e.g. "read tags", "send") are fine; mirroring the original's class shape is not.
- **The v2 API is designed fresh.** The original is a single god-class; v2 is decomposed (see §4). A genuinely new design both improves the library and reinforces the separation.
- **The compatibility shim is held to the same discipline.** v2 ships a shim that re-exposes the v1 public surface (see §7); its class name and method signatures are reconstructed from the README, the `examples/`, and the v1->v2 migration map -- never from the legacy file. Re-exposing a public surface (names, signatures) reuses interface facts, not protected expression; the shim's bodies are newly authored delegations into the new classes.
- **Provenance is recorded in the work itself:** the first v2 commit states that it is an independent clean-room implementation, and the NOTICE file credits Dean Vaughan's original as the conceptual predecessor while asserting the new code is independently authored.

If at any point the right move seems to be "look at the old file to settle a detail," the answer is to consult the DICOM/DCMTK documentation instead. The standard is the source of truth, not the legacy code.

---

## 3. Licensing & provenance artifacts

Added in Phase 0, before any implementation code exists:

- **`LICENSE`** -- the full Apache License 2.0 text, verbatim.
- **`NOTICE`** -- Apache convention. Copyright line for the maintainer; a short provenance note crediting Dean Vaughan's original `class_dicom.php` as the inspiration for the project's capabilities, and stating that the v2 code is an independent reimplementation.
- **SPDX headers** on every source file: `// SPDX-License-Identifier: Apache-2.0` plus a one-line copyright. Headers are added as files are created, never retrofitted in bulk.
- **`composer.json`** -- change `"license"` from `"MIT"` to `"Apache-2.0"`; correct the `authors` block to reflect the v2 maintainer and the project's role-based attribution convention.

The v1 line keeps its existing `composer.json` as-is on the default branch (see §7). The relicense applies to v2, which is new code.

---

## 4. Target architecture

Modern PHP, no manual configuration, loud failure. The design goals already captured in `ROADMAP.md` carry over -- restated here as the shape of the *new* code, not edits to the old:

- **Native-first by design.** Every capability is implemented in pure PHP wherever that is viable; DCMTK is used only for the specific operations where native is not (realistically the compressed pixel codecs, and possibly DIMSE networking). This is a design-time decision per capability, not a runtime toggle: exactly one implementation per operation, no opt-in/opt-out, no fallback chain. Native operations carry no external dependency at all. The operations implemented via DCMTK require DCMTK at runtime and fail loud (a descriptive exception) if it is absent -- not because DCMTK is "optional," but because that is simply how those operations are built.
- **PSR-4 autoloading** under peer top-level namespaces, `src/` layout, Composer-loadable with no classmap. Namespaces are uppercased per the project's acronym convention (an acronym keeps its casing as a single word): `DICOM\`, `PACS\`, `DCMTK\` -- not `Dicom\`.
- **Decomposed into peers, not a god-class -- and PACS is split out from DICOM.** The v1 god-class conflated file/image operations with network operations. v2 separates them into sibling namespaces:
  - `DICOM\` -- instance, tag, and image concerns, implemented natively: `DICOM\File` (parse + detection), `DICOM\Tags` (read/write), `DICOM\Convert` (image conversion), `DICOM\Compress` (transfer-syntax conversion). The native dataset reader/writer is the foundation these build on.
  - `PACS\` -- DICOM networking as a first-class peer, not a sub-namespace of DICOM: `PACS\Scu` (C-STORE send), `PACS\Scp` (C-STORE receive + post-receive handler hook), `PACS\Echo` (C-ECHO). Native DIMSE vs DCMTK is decided when this phase is reached (see §5).
  - `DCMTK\` -- not a substrate the others sit on, but the home for the operations we deliberately implement via DCMTK (the codec wall, at minimum). `DCMTK\Toolkit` handles binary discovery, version detection, and validated exec for those operations only, and is built when the first DCMTK-backed operation is, not before.

  Exact class boundaries settle during design.
- **Typed throughout.** Typed, visibility-scoped properties; parameter and return types on all public methods; PHP 8.5+ baseline (the latest stable branch and the recommended floor for new code; 8.4 and earlier are not targeted).
- **Exceptions, never silent returns.** A shared exception hierarchy: a marker interface (so callers can catch broadly) with typed `DICOM\Exception\*` and `PACS\Exception\*` concretes, plus a `DCMTK\Exception\*` family that includes the "this operation needs DCMTK and it was not found" case. Every failure path throws something descriptive. This matches the project's fail-loud principle: a crash during development is a gift; a silent wrong answer in production is a disaster.
- **No global configuration, no `define()`.** Where DCMTK is used, its location is discovered at the point of use (constructor injection, env var, or PATH) by the operations that need it, never set as a global. For its native operations the library needs nothing installed beyond PHP.
- **No free-standing global functions.** Execution and detection helpers live in classes; the DCMTK exec helper validates that a binary exists before invoking it and throws if not.

---

## 5. Capability scope (functional parity)

These are behaviors to replicate -- facts about what a DICOM/DCMTK library does, free to implement independently. v2 ships when they all work with loud errors on every failure path. The implementation choice (native vs DCMTK) is noted per capability and is settled as each phase is built, always preferring native.

- **Detection** (`is_dcm`, transfer syntax) -- native. Part 10 preamble / `DICM` magic and the group-0002 File Meta header.
- **Tag read / write** -- native. Parse the dataset per transfer syntax (Implicit/Explicit VR, LE/BE) using the public data dictionary; modify/insert tags (common VRs first: LO, PN, DA, TM, UI, SH, CS).
- **Transfer-syntax conversion** (Implicit <-> Explicit VR) -- native; the same dataset re-encoded.
- **JPEG -> DICOM** -- native encapsulation of a JPEG bitstream into a DICOM instance. Native-first also dissolves the v1.1.0 `xml2dcm`/SOPInstanceUID warning bug, since there is no `xml2dcm` step.
- **DICOM -> JPEG / thumbnails / window-level** -- native for uncompressed pixel data: the windowing math is native, with an imaging library (gd/imagick) only for the final JPEG encode.
- **Compressed pixel codecs** (decode/encode JPEG Baseline, JPEG Lossless, JPEG-LS, JPEG 2000) -- **the wall.** gd cannot; imagick covers JPEG 2000 only if built with openjpeg and effectively not JPEG Lossless or JPEG-LS. Here native may mean a focused C codec (openjpeg / CharLS) or DCMTK may be the pragmatic choice. Decided at Phase 4 with real options in hand; JPEG 2000 stays v2.x.
- **C-ECHO, C-STORE SCU/SCP** + post-receive handler hook -- native DIMSE/ACSE is feasible but heavy (an SCP daemon is awkward in PHP); native vs DCMTK decided at Phase 5.
- **DCMTK ergonomics** (only for operations that use it) -- binary discovery via constructor / env var / PATH, version detection on first use, single cross-platform path resolver. Resolves the hardcoded-`TOOLKIT_DIR`/symlink friction. This is invoked by the DCMTK-backed operations, not run as a global startup step.

Feature expansion beyond parity (C-FIND/C-MOVE, TLS, pixel access, JPEG 2000, DICOMDIR, SR, UID generation, conformance statement) stays in the `ROADMAP.md` v2.x section. Native parsing, previously filed there, is part of v2.0 by design under native-first.

---

## 6. Phased delivery

One logical checkpoint per phase; commit per checkpoint on the `claude` branch.

- **Phase 0 -- License & scaffold.** (done) `LICENSE`, `NOTICE`, SPDX header convention, `composer.json` relicense + PSR-4 autoload, `src/` skeleton, CI workflow. No behavior.
- **Phase 1 -- Native foundation.** The native DICOM file/stream model: Part 10 + File Meta parsing, `is_dcm()`/transfer-syntax detection, and the shared exception hierarchy. No DCMTK.
- **Phase 2 -- Tags.** Native tag read/write across Implicit/Explicit VR using the data dictionary, against fixtures.
- **Phase 3 -- Conversion (native parts).** Implicit<->Explicit VR conversion, JPEG->DICOM encapsulation, and DICOM->JPEG/thumbnails/window-level for uncompressed pixel data (imaging library for the encode only). No DCMTK.
- **Phase 4 -- Compressed codecs (the wall).** Decode/encode for compressed transfer syntaxes. Native where feasible; introduce a DCMTK-backed (or C-codec) implementation only for the codecs where native is not viable. `DCMTK\Toolkit` is built here, if it is needed at all.
- **Phase 5 -- Networking (`PACS\`).** C-ECHO, C-STORE SCU, C-STORE SCP + handler hook. Native DIMSE or DCMTK, decided here.
- **Phase 6 -- Backward-compatibility shim.** A newly authored class preserving the v1 public surface, delegating into the `DICOM\`/`PACS\` classes and emitting `E_USER_DEPRECATED` (see §7). Shipped via Composer `classmap`/`files` autoload, since it is intentionally a global (non-namespaced) class; tested against the same behavioral oracle as the real classes. The legacy `class_dicom.php` is removed in this phase -- the shim replaces it.
- **Phase 7 -- Docs & release.** README rewrite, migration guide (§7), conformance notes, tag `v2.0.0`.

---

## 7. Compatibility & migration

This is the maintainer's only library with real external consumers via Packagist, so v2 ships a managed deprecation path rather than a hard break.

- **v1 stays put.** The current code remains on the default branch (`main`) for existing `^1` consumers; it is not deleted there and not retroactively relicensed. `v1.1.0` is already tagged, so consumers have a stable pin.
- **v2 introduces a new API** under the `DICOM\` and `PACS\` namespaces. It is not a refactor of the old surface -- it is the fresh, decomposed design in §4.
- **A backward-compatibility shim ships with v2.** A newly authored class preserves the v1 public surface (the original global class name and method signatures), delegating into the new `DICOM\`/`PACS\` classes and emitting `E_USER_DEPRECATED` plus `@deprecated` docblocks that name the replacement call. Existing consumers move to `^2` without code changes, then migrate incrementally guided by the warnings.
- **The shim does not reintroduce the licensing defect.** v2 must not ship the legacy `class_dicom.php` itself -- that file is the unlicensed expression. The shim *replaces* it: same public surface, newly authored delegating bodies, with the surface reconstructed from the README/examples/migration map (never the legacy file, per §2). It autoloads via Composer `classmap`/`files`, since it is deliberately a global, non-namespaced class.
- **Deprecation lifecycle (SemVer).** `^2` = new API plus the working-but-noisy shim. The shim is removed in `^3`, by which point the warnings have given consumers a full major-version window to migrate.
- **Migration guide** (Phase 7) maps each v1 call to its v2 equivalent. It is the same v1->v2 mapping the shim implements, so the two stay consistent by construction.
- **Packagist:** the v2 release publishes under the Apache-2.0 license field; the package description keeps its honest origin note.

---

## 8. Testing

Per the project's testing standards -- tests verify real behavior, never monkeypatch the unit under test, and are never satisfied by contorting the code:

- **Behavioral oracle.** Cross-validate against pydicom/pynetdicom (the existing `tests/` already do this) -- tags, conversions, compression, and networking checked against an independent implementation.
- **Real inputs; real DCMTK only where used.** Native paths are tested directly against real DICOM files with pydicom as the oracle. For any operation implemented via DCMTK, tests run against an actual DCMTK install -- no mocking the toolkit boundary's logic. Test doubles are acceptable only for genuinely external boundaries (e.g. an unreachable network host), not for the behavior under test.
- **Error paths are first-class.** Missing files, invalid DICOM, unreachable hosts, malformed tags, missing binaries -- each asserts the specific exception, not just "it didn't crash."
- **Fixture breadth.** Multiple transfer syntaxes (Implicit VR, Explicit VR, JPEG Baseline, JPEG Lossless) and modalities (CR, CT, MR, US, multi-frame).
- **CI matrix.** GitHub Actions on PHP 8.5, on every push. The native phases need only PHP; DCMTK is installed in CI only once a DCMTK-backed operation exists (Phase 4+). Add 8.6 to the matrix when it releases (~Nov 2026).

---

## 9. Done criteria

v2.0.0 is done when:

1. Every capability in §5 works -- native where chosen, DCMTK where chosen -- with a descriptive exception on every failure path.
2. The CI matrix is green across the PHP version range.
3. `LICENSE`, `NOTICE`, and SPDX headers are present and consistent; `composer.json` declares Apache-2.0.
4. No file references, reproduces, or derives from the legacy `class_dicom.php` -- the new classes and the compat shim trace entirely to the DICOM standard, DCMTK docs, the published v1 surface (README/examples), and this plan.
5. The backward-compatibility shim preserves the v1 public surface, delegates into the new classes, and emits deprecation warnings -- validated against the behavioral oracle.
6. The migration guide is published; `v1.1.0` is tagged on the default branch and the legacy file is removed from the v2 line.
7. Native operations carry no external runtime dependency; DCMTK is required only by the operations implemented via it, which fail loud with a descriptive exception when it is absent.
