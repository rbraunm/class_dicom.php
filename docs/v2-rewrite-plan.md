# v2.0.0 -- Clean-Room Rewrite & Apache-2.0 Relicensing

**Status:** In progress · roadmap priority #1. Phases 0-5 complete (substrate, detection, tags, conversion, compression, networking); Phase 6 (compatibility shim) and Phase 7 (docs & release) remain.
**Outcome:** a from-scratch, sole-authored, Apache-2.0 reimplementation that **faithfully replaces v1's public surface** with a clean, typed PHP wrapper over DCMTK. v2 does not implement DICOM semantics in PHP -- the format parsing, the pixel codecs, and the DIMSE protocol are DCMTK's; native PHP is limited to orchestration, validation, parsing DCMTK output, and API shaping. v2's job is to invoke DCMTK correctly to deliver exactly what v1 delivered, under a clean license and a modern design. Expanding beyond v1 to broader DCMTK coverage is deferred to **v3** (see §5), which keeps v2 narrow and gets the relicensed replacement out the door sooner.

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
- **Implementation is written only from:** the DICOM standard (NEMA PS3, freely published) and the DCMTK tool documentation (`storescu`, `storescp`, `dcmdump`, `dcmodify`, `dcmj2pnm`, `img2dcm`, `dcmcjpeg`, `dcmdjpeg`, `echoscu`, `dcmftest`, `dcmconv`, etc.). These describe what DICOM requires and how each DCMTK tool is invoked. The research in §6 confirms the historical feature set v2 must preserve; it is not an authoring source for v2's command construction.
- **No expression carries over:** no copied lines, no transcribed method bodies, no replicated internal structure, no original comments. Public capability names dictated by the domain (e.g. "read tags", "send") are fine; mirroring the original's class shape is not. The observed call map is used only to confirm the historical feature set and compatibility expectations; v2's own DCMTK invocations are authored from DCMTK's documentation, never transcribed from the log.
- **Interface facts may be recovered; expression may not.** The v1 public surface (class/method/function names, signatures, properties, constants, visibility) is interface, recoverable via reflection and the README/examples (see §6). The method bodies, structure, and comments are expression and stay off-limits. Observing v1's external behavior as a black box -- its outputs, and the DCMTK tools it invokes -- is observation, not reading expression.
- **The v2 API is designed fresh.** The original is a single god-class; v2 is decomposed into a typed wrapper over DCMTK (see §4). A genuinely new design both improves the library and reinforces the separation.
- **The compatibility shim is held to the same discipline.** v2 ships a shim that re-exposes the v1 public surface (see §9); its class name and member signatures are reconstructed from the reflection footprint, the README, the `examples/`, and the v1->v2 migration map -- never from the legacy file. Re-exposing a public surface reuses interface facts, not protected expression; the shim's bodies are newly authored delegations into the new classes.
- **Provenance is recorded in the work itself:** the first v2 commit states that it is an independent clean-room implementation, and the NOTICE file credits Dean Vaughan's original as the conceptual predecessor while asserting the new code is independently authored.

If at any point the right move seems to be "look at the old file to settle a detail," the answer is to consult the DICOM/DCMTK documentation instead. The standard and the tool docs are the source of truth, not the legacy code.

---

## 3. Licensing & provenance artifacts

Added in Phase 0, before any implementation code exists:

- **`LICENSE`** -- the full Apache License 2.0 text, verbatim.
- **`NOTICE`** -- Apache convention. Copyright line for the maintainer; a short provenance note crediting Dean Vaughan's original `class_dicom.php` as the inspiration for the project's capabilities, and stating that the v2 code is an independent reimplementation.
- **SPDX headers** on every source file: `// SPDX-License-Identifier: Apache-2.0` plus a one-line copyright. Headers are added as files are created, never retrofitted in bulk.
- **`composer.json`** -- change `"license"` from `"MIT"` to `"Apache-2.0"`; correct the `authors` block to reflect the v2 maintainer and the project's role-based attribution convention.

The v1 line keeps its existing `composer.json` as-is on the default branch (see §9). The relicense applies to v2, which is new code.

---

## 4. Target architecture

Modern PHP, no manual configuration, loud failure. v2 is a typed PHP wrapper over the DCMTK command-line toolset.

- **Wrapper-first by design.** Every DICOM operation is a validated invocation of the appropriate DCMTK tool. v2 does not implement DICOM semantics natively: the format parsing, the pixel codecs, and the DIMSE protocol are DCMTK's, and v2 wraps them rather than re-deriving them. Native PHP is where all the orchestration lives -- binary discovery, process execution, argument escaping, command-result objects, `dcmdump` output parsing, tag-value normalization, file-path handling, exceptions, the compat-shim delegation, and any template generation a tool needs (e.g. the XML for `xml2dcm`). The rule is precise: PHP never re-implements something DCMTK already does.
- **DCMTK is a hard runtime requirement.** This matches v1, whose README already requires DCMTK across the board. Its absence fails loud with a descriptive exception. We accept the supply-chain dependency deliberately: the correctness of DICOM operations rides on a 30-year-maintained implementation rather than on hand-rolled PHP.
- **v2's scope is exactly v1's capability set.** v2 faithfully replaces what v1 did -- no more -- under a clean license and a modern design. The broader ambition of a full PHP interface to the DCMTK toolset is real but deliberately deferred to **v3**, so the relicensed replacement ships without the scope growing unmanageable. v1 parity is what the shim guarantees.
- **PSR-4 autoloading** under peer top-level namespaces, `src/` layout, Composer-loadable with no classmap. Namespaces are uppercased per the project's acronym convention: `DICOM\`, `PACS\`, `DCMTK\` -- not `Dicom\`.
- **Decomposed into a substrate plus typed wrappers -- not a god-class.** The v1 god-class conflated file/image operations with network operations and buried the DCMTK exec inside. v2 separates them:
  - `DCMTK\` -- the substrate every wrapper sits on. `DCMTK\Toolkit` handles binary discovery, version detection, argument construction, validated exec (the synchronous `run`), and output parsing; Phase 5 added a background-process sibling (`start`, returning a `DCMTK\Process` handle) for the long-running `storescp` receiver. It is the single place that knows how to call DCMTK safely.
  - `DICOM\` -- file and tag concerns as typed wrappers over the toolkit, following DICOM's own File/Dataset distinction (a Part 10 file contains a data set):
    - `DICOM\File` -- the Part 10 file: detection (`dcmftest`), the file-meta accessors (`transferSyntaxUID`, `mediaStorageSOPClassUID`), and the typed tag API (`getDate(Tag)`, `setPersonName(Tag, ...)`, ...), each gated on the tag's value representation so a wrong-type access fails loud before any tool runs. It owns the file's `Dataset`.
    - `DICOM\Dataset` -- the data-element collection: the raw, string-valued read/write surface (`get`/`all` over a single cached `dcmdump`, `put` via `dcmodify` with cache invalidation). This is the low-level route and the compat-shim's delegate; all the tool plumbing lives here.
    - `DICOM\Tag` / `DICOM\TagInfo` / `DICOM\Value\*` -- the typed tag vocabulary. `Tag` is an enum of every standard data element, generated from the DCMTK data dictionary (`tools/codegen/`, vendored `dicom.dic`), so a consumer reaches a tag by its standard keyword (`Tag::PatientName`) and reads/writes a typed value (`DICOM\Value\Date`, `Time`, `DateTime`, `PersonName`, `UID`; integer/decimal/text stay native PHP). The VR-to-PHP-type families are authored once; the per-tag data is generated, so it cannot drift from what the tools use.
    - `DICOM\Tool` -- the shared DICOM/DCMTK boundary: runs a tool translating substrate failures to `ToolkitException`, and asserts readability as `IOException`, so detection and element access both surface only `DICOM\Exception\ExceptionInterface`.
    - `DICOM\Convert` (image conversion) and `DICOM\Compress` (JPEG codec conversion) -- delivered in Phases 3-4, each paired with per-tool typed-choice option objects (`Windowing`, `Scale`, `SOPClass`, `StudySeriesSource`, `Compression`) that model a tool's mutually-exclusive flag groups.

    Each method builds a DCMTK invocation, runs it through `DCMTK\Toolkit`, and parses the result into typed PHP.
  - `PACS\` -- DICOM networking as a first-class peer, delivered in Phase 5: `PACS\SCU` (C-STORE send), `PACS\SCP` (C-STORE receive + per-reception command hook), `PACS\EchoSCU` (C-ECHO; named `EchoSCU` because `Echo` is a reserved word), each wrapping the corresponding DCMTK network tool over a shared connection vocabulary (`Peer`, `Association`, `TransferSyntaxProposal`). Class names carry the acronym casing per the project convention (`SCU`, not `Scu`).

  Exact class boundaries settle during design.
- **Typed throughout.** Typed, visibility-scoped properties; parameter and return types on all public methods; PHP 8.5+ baseline (the latest stable branch and the recommended floor for new code; 8.4 and earlier are not targeted).
- **Exceptions, never silent returns.** A shared exception hierarchy: a marker interface (so callers can catch broadly) with typed concretes covering "DCMTK binary not found," "DCMTK invocation failed" (non-zero exit), and "DCMTK produced unexpected output." Every failure path throws something descriptive. This matches the project's fail-loud principle: a crash during development is a gift; a silent wrong answer in production is a disaster. It also directly addresses v1's silent-failure habit.
- **Validated exec.** The exec helper validates the binary exists before invoking, checks the exit status, and confirms the output matches what the call was supposed to produce; anything unexpected throws. v2 never accepts a bad or empty result as success.
- **`DCMTK\Toolkit` returns a value object, not raw strings.** Every invocation yields a typed, immutable `CommandResult` carrying the binary, argv, exit code, stdout, stderr, and an optional duration. Wrappers parse and validate that object; raw shell output never leaks past the toolkit boundary. This buys testability, precise error messages, structured logging, and debuggability without spreading shell internals through the codebase.

```php
final readonly class CommandResult
{
  public function __construct(
    public string $binary,
    public array $argv,
    public int $exitCode,
    public string $stdout,
    public string $stderr,
    public ?float $durationSeconds = null,
  ) {}
}
```
- **No global configuration, no `define()`.** DCMTK's location is discovered at the point of use (constructor injection, env var, or PATH), never set as a global. This resolves the hardcoded-`TOOLKIT_DIR`/symlink friction in v1.

---

## 5. Capability scope

v2 faithfully wraps DCMTK's functionality. The correctness of each underlying DICOM operation is DCMTK's responsibility; v2 owns the correctness of the **invocation** -- the right tool, the right arguments, and an output that matches the intended result. The capability set is exactly v1's; broader DCMTK coverage is v3. v2's tool selection and argument construction are authored from DCMTK's documentation; the call-map research in §6 confirms only the historical feature set and compatibility expectations. DCMTK coverage gaps are recorded there too.

v1-parity capabilities and the DCMTK tool that provides each (tool choice and arguments authored from DCMTK docs; the historical feature set confirmed against the call map):

- **Detection / metadata** (`is_dcm`, transfer syntax, read tags) -- `dcmftest` for the Part 10 check, `dcmdump` for transfer syntax and tag values. (v1 itself ran `dcmdump -M +L +Qn` for the `is_dcm` check, not `dcmftest`; `dcmftest` vs `dcmdump` for v2 detection is a Phase 1 choice, not a parity requirement.)
- **Tag modify / insert** -- `dcmodify`.
- **Compression / decompression** (`compress`, `uncompress`) -- `dcmcjpeg` / `dcmdjpeg`; JPEG 2000 only where the DCMTK build includes the module (a recorded gap if not).
- **DICOM -> JPEG / thumbnails / window-level** -- `dcmj2pnm` with the appropriate windowing and scaling flags.
- **JPEG -> DICOM** (`jpg_to_dcm`) -- `img2dcm` (chosen and delivered in Phase 3). v1 instead filled a template and ran `xml2dcm` -- the path where its SOPInstanceUID bug lives; `img2dcm` makes that moot, minting the type-1 UIDs itself, so the bug cannot occur.
- **PDF -> DICOM** (`pdf_to_dcm`, `pdf_to_dcmcr`) -- `pdf2dcm` (confirmed and delivered in Phase 3 as `Convert::fromPdf`, producing Encapsulated PDF Storage). v1's original tool was never observed; the v1 `pdf_to_dcm`/`pdf_to_dcmcr` naming is reconciled in the Phase 6 shim.
- **Multi-frame -> video** -- frame extraction delivered in Phase 3 as `Convert::toJpegFrames` (`dcmj2pnm +Fa`); video encoding is outside DCMTK (it has no consumer-video encoder), confirming the recorded gap, so the ffmpeg assembly step is deferred to the Phase 6 shim/caller.
- **C-ECHO** -- `echoscu`.
- **C-STORE SCU** (`send_dcm`) -- `storescu`.
- **C-STORE SCP** (`store_server`) + post-receive handler hook -- `storescp`.

The committed Phase 1 detection tests (`isDICOM` returns the right bool, `transferSyntaxUID` the right UID) are implementation-agnostic and hold unchanged: they are now satisfied by wrapping `dcmftest`/`dcmdump` rather than by native parsing.

This capability set is reconciled against the frozen capability map (`v1-capability-map.md`). Standalone transfer-syntax conversion (`dcmconv`) was dropped from v1 parity -- no v1 method performs it and the capture never invoked it -- and is deferred to v3. Where v2's planned tool differs from what v1 actually ran (`dcmftest` vs v1's `dcmdump` for detection; `img2dcm` vs v1's `xml2dcm` for JPEG->DICOM), v1's mechanism is recorded but does not bind v2; the final tool is a Phase 1/3 design choice.

Coverage beyond v1 (additional DCMTK tools, C-FIND/C-MOVE, TLS, DICOMDIR, SR, worklist, etc.) is **v3**, staged in `ROADMAP.md`. v2 ships exactly the v1-parity set wrapped (see §8) and nothing more; v2.x is maintenance of that wrapper, not feature growth.

---

## 6. Research methodology

Two clean-room-safe research artifacts establish the surface to preserve and how each capability maps to DCMTK. Both observe interface and behavior only; neither reads the legacy source. The execution environment is a separate planning item -- reflection needs a PHP runtime that can load the class, the harness needs PHP plus DCMTK -- and is not this sandbox. We will settle the where and the sequencing as its own step.

- **Public-surface footprint via reflection.** `ReflectionClass` over every v1 class and `ReflectionFunction` over its standalone functions (`is_dcm`, `Execute`), capturing the complete public footprint: method names, parameters (names, types, defaults), return types, properties, constants, visibility, static-vs-instance, and inheritance. The output is a machine-readable inventory that defines exactly what the compat shim must re-expose -- authoritative and exhaustive, where the README and examples are only illustrative. Reflection extracts interface facts (the surface), never bodies or logic, so it is clean-room-safe. It loads the class to introspect it; it does not execute the methods and does not require DCMTK. Loading is done in isolation, capturing only the reflection output, never the file contents.
- **Capability / call map via logging shims.** Wrapper scripts named exactly like the DCMTK tools are placed at `TOOLKIT_DIR`'s default location, with the real binaries relocated to a sibling directory the shims exec by absolute path (so the legacy file is never edited). Each shim logs tool name, argv, and cwd as JSONL, then execs the real tool. Driving each v1 public operation once against fixtures records which operations v1 supports and how it exercised DCMTK. Its purpose is to **verify the historical feature set and identify compatibility expectations** -- what v2 must continue to provide -- not to dictate how v2 calls DCMTK. v2's command construction is authored from DCMTK's documentation. The networking operations need a DICOM peer, so the runner spins a real `storescp` locally as the target. Needs PHP + DCMTK.
- **pydicom as a check, not a truth.** Outputs are cross-checked against pydicom to catch silent v1 failures and, later, to confirm v2's invocations produce the expected result. Agreement is confidence; disagreement is a flag adjudicated against the standard, never auto-resolved. Metadata and detection checks can be exact; lossy/codec checks use decoded-pixel tolerance or structural properties (valid encoding, dimensions, photometric interpretation), and the artifact says so rather than claiming a precision it lacks. pydicom is itself just an implementation, with its own bugs and its own leniency, so it is never treated as the standard -- only as a tripwire that points at cases worth checking against NEMA PS3.

This research is **Phase 0.5** (see §8). Its outputs are committed as `docs/v1-surface.json` (the frozen reflection footprint) and `docs/v1-capability-map.md` (each capability, its DCMTK tool, and any DCMTK gaps): a frozen compatibility target produced before any wrapper code, so implementation aims at a fixed v1 surface rather than an ambiguous moving one.

---

## 7. DCMTK bug policy

DCMTK owns the correctness of the underlying operations, and the default is to call each tool correctly and trust its output. Where a DCMTK tool genuinely misbehaves, v2 does not silently paper over it. Each issue is recorded in `docs/dcmtk-workarounds.md` with:

- a minimal reproduction,
- the workaround applied in v2 and why it is necessary,
- an upstream-fix note: a TODO until filed, then a link to the DCMTK issue or PR.

Workarounds are the documented exception, not a routine. Anything that looks like a recurring need to compensate for DCMTK is a signal to re-examine whether we are calling the tool correctly first.

---

## 8. Phased delivery

One logical checkpoint per phase; commit per checkpoint on the `claude` branch. v2 covers exactly the v1-parity capability families wrapped; broader DCMTK coverage is deferred to v3.

- **Phase 0 -- License & scaffold.** (done) `LICENSE`, `NOTICE`, SPDX header convention, `composer.json` relicense + PSR-4 autoload, `src/` skeleton, CI workflow. No behavior.
- **Phase 0.5 -- Public surface & capability inventory.** (done) Run the §6 research: reflection produces `docs/v1-surface.json` (the complete, frozen v1 public footprint) and the capability map produces `docs/v1-capability-map.md` (each v1 capability, its DCMTK tool, and any DCMTK gaps). This inventory is the frozen definition of v1 parity, committed before any wrapper code so implementation targets a fixed surface and does not overbuild. No library code.
- **Phase 1 -- DCMTK substrate + detection.** (done) `DCMTK\Toolkit` (discovery, version detection, argument construction, validated exec, output parsing) and the exception hierarchy, plus the first wrapped capability: detection/metadata (`DICOM\File` over `dcmftest`/`dcmdump`). Satisfies the committed detection tests. DCMTK is required from here on.
- **Phase 2 -- Tags.** (done) A `DICOM\Tag` enum generated from the DCMTK data dictionary (every standard element reachable by its keyword) plus a typed value class per VR; the raw, string-valued read/write surface on `DICOM\Dataset` (`dcmdump` read, `dcmodify` write, cache-invalidating) -- the parity/shim floor; and VR-gated typed accessors on `DICOM\File` (`getDate(Tag)`, `setPersonName(Tag, ...)`) that fail loud on a wrong-type access and elevate a malformed stored value to `InvalidDICOMException`. Tested against fixtures with the pydicom oracle.
- **Phase 3 -- Conversion.** (done) `DICOM\Convert`: DICOM -> JPEG and thumbnails (`dcmj2pnm`) with `Windowing` and `Scale` typed choices; JPEG -> DICOM via `img2dcm` (chosen over v1's `xml2dcm`, which it makes moot by minting the type-1 UIDs itself) with `SOPClass` (single- vs multi-frame Secondary Capture) and `StudySeriesSource` (fresh vs inherited study/series) typed choices; PDF -> DICOM via `pdf2dcm`; and frame extraction (`dcmj2pnm +Fa`). Shared `ConversionException`. The `jpg_to_dcm` shortcut, the `pdf_to_dcm`/`pdf_to_dcmcr` naming, and `multiframe_to_video`'s ffmpeg assembly are deferred to the Phase 6 shim.
- **Phase 4 -- Compression.** (done) `DICOM\Compress`: `compress`/`decompress` via `dcmcjpeg`/`dcmdjpeg`, with a `Compression` typed choice (lossless SV1 [default, v1 parity], lossless, baseline, extended; retired processes excluded). JPEG 2000 is absent from this DCMTK build (`dcmj2kc`/`dcmj2kd` not installed) and recorded as a gap. (Standalone transfer-syntax conversion via `dcmconv` remains v3, not v1 parity.)
- **Phase 5 -- Networking (`PACS\`).** (done) `PACS\EchoSCU` (C-ECHO, `echoscu`), `PACS\SCU` (C-STORE send, `storescu`; files, directories, recursive), and `PACS\SCP` (C-STORE receive, `storescp`, + per-reception command hook and fork-per-association), over a shared `Peer`/`Association`/`TransferSyntaxProposal` vocabulary. The blocking receiver runs as a managed background process, which added the `DCMTK\Process` substrate (`Toolkit::start`/`Tool::spawn`, the async siblings of `run`). Tests run against real `storescp`/`storescu` peers on loopback.
- **Phase 6 -- Backward-compatibility shim.** (next) A newly authored global class preserving the v1 public surface (from the reflection footprint), delegating into the `DICOM\`/`PACS\` wrappers and emitting `E_USER_DEPRECATED`; it preserves call compatibility, not bug compatibility (see §9). This phase also picks up the v1-named conversion entry points deferred from Phase 3 -- `jpg_to_dcm`, the `pdf_to_dcm`/`pdf_to_dcmcr` split, and `multiframe_to_video`'s ffmpeg assembly over `Convert::toJpegFrames`. Autoloaded via Composer `classmap`/`files`. The legacy `class_dicom.php` is removed in this phase -- the shim replaces it.
- **Phase 7 -- Docs & release.** README rewrite, migration guide (§9), conformance notes, tag `v2.0.0`.

---

## 9. Compatibility & migration

This is the maintainer's only library with real external consumers via Packagist, so v2 ships a managed deprecation path rather than a hard break.

- **v1 stays put.** The current code remains on the default branch (`main`) for existing `^1` consumers; it is not deleted there and not retroactively relicensed. `v1.1.0` is already tagged, so consumers have a stable pin.
- **v2 introduces a new API** under the `DICOM\` and `PACS\` namespaces. It is not a refactor of the old surface -- it is the fresh, decomposed wrapper design in §4.
- **A backward-compatibility shim ships with v2.** A newly authored class preserves the v1 public surface (the original global class name and member signatures, taken from the reflection footprint), delegating into the new `DICOM\`/`PACS\` wrappers and emitting `E_USER_DEPRECATED` plus `@deprecated` docblocks that name the replacement call. Existing call sites keep working unchanged, then migrate incrementally guided by the warnings.
- **The shim preserves public call compatibility, not bug compatibility.** It keeps the old class name, method signatures, and call patterns working; it does not reproduce v1's defects -- the silent failures, the unsafe path handling, the incidental parsing quirks. Calls run through v2's correct, loud behavior, so a v1 defect is surfaced rather than silently reproduced. That behavior change is intentional and is what a major-version boundary is for; the only v1 quirks worth recreating are ones a real consumer is found to depend on, handled case by case.
- **Surface, don't crash: warn where v1 would have kept running.** Upgrading to `^2` must not turn a working production call into a fatal one. Where v2 is stricter than v1 -- a call that returned non-fatally under v1 now reaches v2's fail-loud path -- the shim catches the v2 exception, emits an `E_USER_WARNING` (or `E_USER_DEPRECATED`) naming the real problem, and returns a v1-shaped value rather than letting the exception propagate. The failure is visible in logs and error handlers without killing the app, so deprecated code can see and fix it on its own schedule. This softening is the shim's alone: the underlying `DICOM\`/`PACS\` API stays fully fail-loud and throws. Nothing is swallowed silently -- the shim warns, it does not hide -- and genuine failures that v1 itself errored on are surfaced the same way.
- **The shim does not reintroduce the licensing defect.** v2 must not ship the legacy `class_dicom.php` itself -- that file is the unlicensed expression. The shim *replaces* it: same public surface, newly authored delegating bodies, surface reconstructed from the reflection footprint and README/examples/migration map (never the legacy file, per §2). It autoloads via Composer `classmap`/`files`, since it is deliberately a global, non-namespaced class.
- **Deprecation lifecycle (SemVer).** `^2` = new API plus the working-but-noisy shim. `^3` is the post-v1 line: it drops the deprecated shim (the warnings have given consumers a full major-version window to migrate) and is where coverage expands beyond v1 toward the broader DCMTK toolset (§5).
- **Migration guide** (Phase 7) maps each v1 call to its v2 equivalent. It is the same v1->v2 mapping the shim implements, so the two stay consistent by construction.
- **Packagist:** the v2 release publishes under the Apache-2.0 license field; the package description keeps its honest origin note.

---

## 10. Testing

Per the project's testing standards -- tests verify real behavior, never monkeypatch the unit under test, and are never satisfied by contorting the code:

- **The validated layer is the invocation, not DCMTK's conformance.** v2's job is to call the right tool with the right arguments and get the intended result; tests assert exactly that. They do not try to re-certify DCMTK.
- **pydicom as a check, not a truth** (per §6). Tag, conversion, compression, and networking outputs are cross-checked against pydicom/pynetdicom; agreement is confidence, disagreement is investigated against the standard. Metadata exact, codec by tolerance/structure.
- **Real DCMTK from Phase 1.** Everything is DCMTK-backed, so tests run against an actual DCMTK install from the first wrapped operation onward -- no mocking the toolkit boundary's logic. Test doubles are acceptable only for genuinely external boundaries (e.g. an unreachable network host), not for the behavior under test.
- **Error paths are first-class.** Missing binary, non-zero exit, unexpected/empty output, missing files, invalid DICOM, unreachable hosts, malformed tags -- each asserts the specific exception, not just "it didn't crash."
- **Fixture breadth.** Multiple transfer syntaxes (Implicit VR, Explicit VR, JPEG Baseline, JPEG Lossless) and modalities (CR, CT, MR, US, multi-frame).
- **CI matrix.** GitHub Actions on PHP 8.5, on every push, with DCMTK installed from Phase 1. Add 8.6 to the matrix when it releases (~Nov 2026).

---

## 11. Done criteria

v2.0.0 is done when:

1. Every v1-parity capability in §5 works as a validated DCMTK invocation, with a descriptive exception on every failure path (binary missing, invocation failed, unexpected output).
2. The CI matrix is green on the PHP version range with DCMTK installed.
3. `LICENSE`, `NOTICE`, and SPDX headers are present and consistent; `composer.json` declares Apache-2.0.
4. No file references, reproduces, or derives from the legacy `class_dicom.php` -- the new classes and the compat shim trace entirely to the DICOM standard, DCMTK docs, the reflection footprint, the published v1 surface (README/examples), and this plan.
5. The backward-compatibility shim preserves the v1 public call surface (matching the reflection footprint) without recreating v1's defects, delegates into the new wrappers, and emits deprecation warnings -- validated against the behavioral check.
6. The migration guide is published; `v1.1.0` is tagged on the default branch and the legacy file is removed from the v2 line.
7. DCMTK is required and discovered at point of use, failing loud when absent; any DCMTK workarounds are recorded in `docs/dcmtk-workarounds.md` with upstream-fix notes.
