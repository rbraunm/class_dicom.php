# v2.0.0 — Clean-Room Rewrite & Apache-2.0 Relicensing

**Status:** Planned · roadmap priority #1
**Outcome:** a from-scratch reimplementation of this library, sole-authored, released under Apache-2.0.

---

## 1. Why a rewrite and not a refactor

This package began as a fork of Dean Vaughan's `class_dicom.php` (originally published ~2011 at deanvaughan.org, mirrored at `github.com/vedicveko/class_dicom.php`). That original was **published without any license**, which under default copyright means all rights are reserved by its author. The `"license": "MIT"` currently declared in this fork's `composer.json` is therefore not backed by a grant from the original author for the portions he wrote — it asserts terms we are not in a position to grant.

The current file is a **derivative work**. Refactoring it — renaming methods, adding types, reorganizing internals — produces another derivative work and carries the same defect forward. No amount of editing the existing source converts it into something we can license freely.

The clean fix is to **stop deriving**. A ground-up reimplementation, written without reference to the legacy source, is original expression authored solely by this project's maintainer. That code can be licensed under Apache-2.0 cleanly, with no dependency on the original author's rights.

Functionality is not the issue: DICOM operations, the use of DCMTK command-line tools, and a class's public capabilities are facts and ideas, not protected expression. We are free to build a library that *does the same things*. What we must not reuse is the original's **expression** — its specific code, structure, and comments.

> A courtesy email to Dean Vaughan asking him to license the original under a permissive license remains worthwhile as a one-shot attempt (use the deanvaughan.org contact, not GitHub — a prior PR went unanswered). It is **not on the critical path**: the rewrite proceeds regardless, and its validity does not depend on a reply.

---

## 2. Clean-room discipline

These rules exist to keep the provenance of v2 defensible. They are not optional.

- **The legacy `class_dicom.php` is not opened, read, or referenced during v2 implementation.** Not for "just checking how it did X." The whole value of the exercise evaporates if the new code is written with the old code in view.
- **Implementation is written only from:** the DICOM standard (NEMA PS3, freely published), the DCMTK tool documentation (`storescu`, `storescp`, `dcmdump`, `dcmodify`, `dcmj2pnm`, `img2dcm`, `dcmcjpeg`, `dcmdjpeg`, `echoscu`, etc.), and the functional capability list in §5 below — which describes *what* the library does, derived from behavior and public docs, never *how* the original expressed it.
- **No expression carries over:** no copied lines, no transcribed method bodies, no replicated internal structure, no original comments. Public capability names that are dictated by the domain (e.g. "read tags", "send") are fine; mirroring the original's class shape is not.
- **The v2 API is designed fresh.** The original is a single god-class; v2 is decomposed (see §4). A genuinely new design both improves the library and reinforces the separation.
- **Provenance is recorded in the work itself:** the first v2 commit states that it is an independent clean-room implementation, and the NOTICE file credits Dean Vaughan's original as the conceptual predecessor while asserting the new code is independently authored.

If at any point the right move seems to be "look at the old file to settle a detail," the answer is to consult the DICOM/DCMTK documentation instead. The standard is the source of truth, not the legacy code.

---

## 3. Licensing & provenance artifacts

Added in Phase 0, before any implementation code exists:

- **`LICENSE`** — the full Apache License 2.0 text, verbatim.
- **`NOTICE`** — Apache convention. Copyright line for the maintainer; a short provenance note crediting Dean Vaughan's original `class_dicom.php` as the inspiration for the project's capabilities, and stating that the v2 code is an independent reimplementation.
- **SPDX headers** on every source file: `// SPDX-License-Identifier: Apache-2.0` plus a one-line copyright. Headers are added as files are created, never retrofitted in bulk.
- **`composer.json`** — change `"license"` from `"MIT"` to `"Apache-2.0"`; correct the `authors` block to reflect the v2 maintainer and the project's role-based attribution convention.

The v1 line keeps its existing `composer.json` as-is on `master` (see §7). The relicense applies to v2, which is new code.

---

## 4. Target architecture

Modern PHP, no manual configuration, loud failure. The design goals already captured in `ROADMAP.md` carry over — restated here as the shape of the *new* code, not edits to the old:

- **PSR-4 autoloading** under a `Dicom\` namespace, `src/` layout, Composer-loadable with no classmap.
- **Decomposed, not a god-class.** Separate responsibilities into focused classes — e.g. `Dicom\File` (a parsed instance), `Dicom\Tags` (read/write), `Dicom\Convert` (image conversion), `Dicom\Net\Scu` / `Dicom\Net\Scp` (networking), `Dicom\Toolkit` (DCMTK discovery + invocation). Exact boundaries settle during design.
- **Typed throughout.** Typed, visibility-scoped properties; parameter and return types on all public methods; PHP 8.1+ baseline.
- **Exceptions, never silent returns.** A dedicated exception hierarchy (`Dicom\Exception\*`). Every failure path throws something descriptive. This is the single biggest correctness improvement over v1, and it matches the project's fail-loud principle: a crash during development is a gift; a silent wrong answer in production is a disaster.
- **Injected toolkit configuration.** No top-level `define()`. DCMTK location is discovered or injected via a `Toolkit` object/constructor. The library is usable without editing any source file.
- **No free-standing global functions.** Execution and detection helpers live in classes; the exec helper validates that a binary exists before invoking it and throws if not.

---

## 5. Capability scope (functional parity)

These are behaviors to replicate — facts about what a DICOM/DCMTK library does, free to implement independently. v2 ships when these work against a real DCMTK install with loud errors on every failure path.

- **Tag read / write** — extract tags into a structured form; modify/insert tags (common VRs first: LO, PN, DA, TM, UI, SH, CS).
- **DICOM → JPEG** and **thumbnail generation**, with window/level control.
- **JPEG → DICOM** — fix the v1.1.0 known issue where a non-fatal `xml2dcm`/SOPInstanceUID warning aborts pixel-data embedding; the v2 path must not treat warnings as failure.
- **Compress / uncompress** across transfer syntaxes (Implicit/Explicit VR, JPEG Baseline, JPEG Lossless; JPEG 2000 is v2.x).
- **C-STORE SCU** (send) and **C-STORE SCP** (receive / store server), including the post-receive handler-script hook.
- **C-ECHO** (verification).
- **DCMTK ergonomics** — binary discovery via `which` / env var / constructor, version detection at startup, single cross-platform path resolver. Resolves the long-standing hardcoded-`TOOLKIT_DIR`/symlink friction directly, rather than carrying it forward.

Feature expansion beyond parity (native parsing, C-FIND/C-MOVE, TLS, pixel access, JPEG 2000, DICOMDIR, SR, UID generation, conformance statement) stays in the existing `ROADMAP.md` v2.x section.

---

## 6. Phased delivery

One logical checkpoint per phase; commit per checkpoint on the `claude` branch.

- **Phase 0 — License & scaffold.** `LICENSE`, `NOTICE`, SPDX header template, `composer.json` relicense + PSR-4 autoload, empty `src/` skeleton, CI workflow stub. No behavior yet. This phase makes the Apache-2.0 footing real before a line of logic is written.
- **Phase 1 — Toolkit foundation.** `Dicom\Toolkit` (discovery, version check, validated exec), exception hierarchy, `is_dcm()`/transfer-syntax detection.
- **Phase 2 — Tags.** Read and write, common VRs, against fixtures.
- **Phase 3 — Conversion.** DICOM↔JPEG, thumbnails, JPEG→DICOM (with the warning-handling fix).
- **Phase 4 — Compression.** Transfer-syntax conversion both directions.
- **Phase 5 — Networking.** C-ECHO, C-STORE SCU, C-STORE SCP + handler hook.
- **Phase 6 — Docs & release.** README rewrite, migration guide (§7), conformance notes, tag `v2.0.0`.

---

## 7. Compatibility & migration

- **v1 stays put.** The current code remains on `master` for existing downstream consumers; it is not deleted and not retroactively relicensed. Tag the current state `v1.1.0` before v2 work begins so consumers have a stable pin.
- **v2 is a deliberate breaking change** — new `Dicom\` namespace, new API. It is not drop-in compatible, and it shouldn't pretend to be.
- **Migration guide** in Phase 6 maps each v1 call to its v2 equivalent so existing users have a clear path.
- Packagist: the v2 release publishes under the Apache-2.0 license field; the package description keeps its honest origin note.

---

## 8. Testing

Per the project's testing standards — tests verify real behavior, never monkeypatch the unit under test, and are never satisfied by contorting the code:

- **Behavioral oracle.** Cross-validate against pydicom/pynetdicom (the existing `tests/` already do this) — tags, conversions, compression, and networking checked against an independent implementation.
- **Real DCMTK, real DICOM.** No mocking of the toolkit boundary's *logic*; tests run against an actual DCMTK install and real sample files. Test doubles are acceptable only for genuinely external boundaries (e.g. an unreachable network host), not for the behavior under test.
- **Error paths are first-class.** Missing files, invalid DICOM, unreachable hosts, malformed tags, missing binaries — each asserts the specific exception, not just "it didn't crash."
- **Fixture breadth.** Multiple transfer syntaxes (Implicit VR, Explicit VR, JPEG Baseline, JPEG Lossless) and modalities (CR, CT, MR, US, multi-frame).
- **CI matrix.** GitHub Actions across PHP 8.1–8.4 against the current DCMTK package, on every push.

---

## 9. Done criteria

v2.0.0 is done when:

1. Every capability in §5 works against real DCMTK, with a descriptive exception on every failure path.
2. The CI matrix is green across the PHP version range.
3. `LICENSE`, `NOTICE`, and SPDX headers are present and consistent; `composer.json` declares Apache-2.0.
4. No file references, reproduces, or derives from the legacy `class_dicom.php` — the implementation is traceable entirely to the DICOM standard, DCMTK docs, and this plan.
5. The migration guide is published and `v1.1.0` is tagged on `master`.
