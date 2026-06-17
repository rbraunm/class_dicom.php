# v2.0.0 -- Clean-Room Rewrite & Apache-2.0 Relicensing

**Status:** Planned · roadmap priority #1
**Outcome:** a from-scratch reimplementation of this library, sole-authored, released under Apache-2.0.

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

- **PSR-4 autoloading** under peer top-level namespaces, `src/` layout, Composer-loadable with no classmap. Namespaces are uppercased per the project's acronym convention (an acronym keeps its casing as a single word): `DICOM\`, `PACS\`, `DCMTK\` -- not `Dicom\`.
- **Decomposed into peers, not a god-class -- and PACS is split out from DICOM.** The v1 god-class conflated file/image operations with network operations. v2 separates them into sibling namespaces over a shared toolkit layer:
  - `DICOM\` -- instance, tag, and image concerns: e.g. `DICOM\File` (a parsed instance), `DICOM\Tags` (read/write), `DICOM\Convert` (image conversion), `DICOM\Compress` (transfer-syntax conversion).
  - `PACS\` -- DICOM networking as a first-class peer, not a sub-namespace of DICOM: `PACS\Scu` (C-STORE send), `PACS\Scp` (C-STORE receive + post-receive handler hook), `PACS\Echo` (C-ECHO).
  - `DCMTK\` -- the toolkit substrate both depend on: `DCMTK\Toolkit` (discovery, version check, validated exec). Modelling DCMTK as its own layer keeps DICOM and PACS independent of each other and gives the future native-implementation work (`ROADMAP.md` v2.x) a single seam to replace.

  Exact class boundaries settle during design.
- **Typed throughout.** Typed, visibility-scoped properties; parameter and return types on all public methods; PHP 8.4+ baseline (the current actively-supported floor -- 8.1 and earlier are end-of-life).
- **Exceptions, never silent returns.** A shared exception hierarchy -- a marker interface (so callers can catch broadly) with typed `DICOM\Exception\*` and `PACS\Exception\*` concretes. Every failure path throws something descriptive. This is the single biggest correctness improvement over v1, and it matches the project's fail-loud principle: a crash during development is a gift; a silent wrong answer in production is a disaster.
- **Injected toolkit configuration.** No top-level `define()`. DCMTK location is discovered or injected via the `DCMTK\Toolkit` object/constructor. The library is usable without editing any source file.
- **No free-standing global functions.** Execution and detection helpers live in classes; the exec helper validates that a binary exists before invoking it and throws if not.

---

## 5. Capability scope (functional parity)

These are behaviors to replicate -- facts about what a DICOM/DCMTK library does, free to implement independently. v2 ships when these work against a real DCMTK install with loud errors on every failure path.

- **Tag read / write** -- extract tags into a structured form; modify/insert tags (common VRs first: LO, PN, DA, TM, UI, SH, CS).
- **DICOM → JPEG** and **thumbnail generation**, with window/level control.
- **JPEG → DICOM** -- fix the v1.1.0 known issue where a non-fatal `xml2dcm`/SOPInstanceUID warning aborts pixel-data embedding; the v2 path must not treat warnings as failure.
- **Compress / uncompress** across transfer syntaxes (Implicit/Explicit VR, JPEG Baseline, JPEG Lossless; JPEG 2000 is v2.x).
- **C-STORE SCU** (send) and **C-STORE SCP** (receive / store server), including the post-receive handler-script hook.
- **C-ECHO** (verification).
- **DCMTK ergonomics** -- binary discovery via `which` / env var / constructor, version detection at startup, single cross-platform path resolver. Resolves the long-standing hardcoded-`TOOLKIT_DIR`/symlink friction directly, rather than carrying it forward.

Feature expansion beyond parity (native parsing, C-FIND/C-MOVE, TLS, pixel access, JPEG 2000, DICOMDIR, SR, UID generation, conformance statement) stays in the existing `ROADMAP.md` v2.x section.

---

## 6. Phased delivery

One logical checkpoint per phase; commit per checkpoint on the `claude` branch.

- **Phase 0 -- License & scaffold.** `LICENSE`, `NOTICE`, SPDX header template, `composer.json` relicense + PSR-4 autoload, empty `src/` skeleton, CI workflow stub. No behavior yet. This phase makes the Apache-2.0 footing real before a line of logic is written.
- **Phase 1 -- Toolkit foundation.** `DCMTK\Toolkit` (discovery, version check, validated exec), the shared exception hierarchy, `is_dcm()`/transfer-syntax detection.
- **Phase 2 -- Tags.** Read and write, common VRs, against fixtures.
- **Phase 3 -- Conversion.** DICOM↔JPEG, thumbnails, JPEG→DICOM (with the warning-handling fix).
- **Phase 4 -- Compression.** Transfer-syntax conversion both directions.
- **Phase 5 -- Networking (`PACS\`).** C-ECHO, C-STORE SCU, C-STORE SCP + handler hook.
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
- **Real DCMTK, real DICOM.** No mocking of the toolkit boundary's *logic*; tests run against an actual DCMTK install and real sample files. Test doubles are acceptable only for genuinely external boundaries (e.g. an unreachable network host), not for the behavior under test.
- **Error paths are first-class.** Missing files, invalid DICOM, unreachable hosts, malformed tags, missing binaries -- each asserts the specific exception, not just "it didn't crash."
- **Fixture breadth.** Multiple transfer syntaxes (Implicit VR, Explicit VR, JPEG Baseline, JPEG Lossless) and modalities (CR, CT, MR, US, multi-frame).
- **CI matrix.** GitHub Actions across PHP 8.4 and 8.5 (the actively-supported branches) against the current DCMTK package, on every push.

---

## 9. Done criteria

v2.0.0 is done when:

1. Every capability in §5 works against real DCMTK, with a descriptive exception on every failure path.
2. The CI matrix is green across the PHP version range.
3. `LICENSE`, `NOTICE`, and SPDX headers are present and consistent; `composer.json` declares Apache-2.0.
4. No file references, reproduces, or derives from the legacy `class_dicom.php` -- the new classes and the compat shim trace entirely to the DICOM standard, DCMTK docs, the published v1 surface (README/examples), and this plan.
5. The backward-compatibility shim preserves the v1 public surface, delegates into the new classes, and emits deprecation warnings -- validated against the behavioral oracle.
6. The migration guide is published; `v1.1.0` is tagged on the default branch and the legacy file is removed from the v2 line.
