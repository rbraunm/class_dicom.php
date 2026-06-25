# Phase 6 -- Backward-Compatibility Shim: Implementation Plan

Companion to [`v2-rewrite-plan.md`](v2-rewrite-plan.md) (see its sections 8 and 9). The shim is newly authored, delegating code that re-exposes the frozen v1 public surface over the `DICOM\`/`PACS\` wrappers, emits deprecation notices, softens v2's stricter failures so an upgrade to `^2` cannot turn a working call fatal, removes the legacy `class_dicom.php`, and absorbs the three conversion entry points deferred from Phase 3.

Everything here is reconstructed from clean-room-safe sources only: the reflected footprint ([`v1-surface.json`](v1-surface.json)), the capability map ([`v1-capability-map.md`](v1-capability-map.md)), the published README/`examples/`, and empirical blackbox observation of v1 (PHP loads and *runs* the legacy file; its source is never read). The legacy source stays closed (rewrite plan section 2).

---

## 1. The frozen surface to re-expose

From `v1-surface.json`, the v1 public footprint is **two global functions and three global classes**, all non-namespaced:

- `Execute($command)`
- `is_dcm($file)`
- `dicom_convert` -- ctor `__construct($file = "")`; methods `dcm_to_jpg()`, `dcm_to_tn()`, `compress($new_file = "")`, `uncompress($new_file = "")`, `jpg_to_dcm($arr_info)`, `pdf_to_dcm($arr_info)`, `pdf_to_dcmcr($arr_info)`, `multiframe_to_video($format = "mp4", $framerate = 24, $temp_dir = "./video_temp")`; public properties `file`, `jpg_file`, `jpg_quality`, `temp_dir`, `template`, `tn_file`, `tn_size`.
- `dicom_net` -- methods `echoscu($host, $port, $my_ae = "DEANO", $remote_ae = "DEANO")`, `send_dcm($host, $port, $my_ae = "DEANO", $remote_ae = "DEANO", $send_batch = 0)`, `store_server($port, $dcm_dir, $handler_script, $config_file, $debug = 0)`; public properties `file`, `transfer_syntax`.
- `dicom_tag` -- ctor `__construct($file = "")`; methods `get_tag($group, $element)`, `load_tags()`, `write_tags($tag_arr)`; public properties `file`, `tags`.

**Names are reproduced verbatim.** The shim keeps v1's snake_case identifiers, parameter names, and defaults exactly (`dicom_convert`, `jpg_to_dcm`, `$arr_info`, `"DEANO"`); the house `drinkingCamelCaseWithABBR` convention applies only to the shim's own internal helpers, never to the surface it must match.

---

## 2. Delegation map (v1 -> v2)

All array keys are 4-hex-digit `group`/`element`, decoded with `hexdec()`. Return values reproduce v1's observed shapes (section 8).

| v1 surface | v2 delegation | Return / notes |
|---|---|---|
| `is_dcm($file)` | `DICOM\File::isDICOM((string) $file)` | `1` / `0` (int, not bool). |
| `Execute($command)` | deprecated passthrough (proc_open, capture stdout+stderr) | Returns combined output. No v2 replacement -- exec is intentionally outside the substrate. **Decision B.** |
| `dicom_convert::dcm_to_jpg()` | `(new Convert(File::open($this->file)))->toJPEG($out, Windowing::useWindow(1), (int) ($this->jpg_quality ?: 100))` | `$out` = `jpg_file` if set, else `"{file}.jpg"`. Returns `$out`. |
| `dicom_convert::dcm_to_tn()` | `->toThumbnail($out, (int) ($this->tn_size ?: 125), 75, Windowing::useWindow(1))` | `$out` = `tn_file` if set, else `"{file}_tn.jpg"`. Returns `$out`. |
| `dicom_convert::compress($new_file)` | `(new Compress(File::open($this->file)))->compress($out)` | `$out` = `$new_file` if given, else overwrite input. `dcmcjpeg` default = `Compression::losslessSV1()` (v1 parity). Returns `$out`. |
| `dicom_convert::uncompress($new_file)` | `->decompress($out)` | As above. Returns `$out`. |
| `dicom_convert::jpg_to_dcm($arr_info)` | `Convert::fromJpeg([$this->jpg_file], $out)` then apply `$arr_info` tags via `Dataset::put` | `$arr_info` = `"GGGG,EEEE" => value` tag map; `template` is inert. Returns `$out` path. |
| `dicom_convert::pdf_to_dcm($arr_info)` | `Convert::fromPdf($this->file, $out)` then apply `$arr_info` tags | **Improved, not validated compat** -- see Decision A. Returns `$out` path. |
| `dicom_convert::pdf_to_dcmcr($arr_info)` | deprecated alias of `pdf_to_dcm` | **Decision A.** |
| `dicom_convert::multiframe_to_video($format, $framerate, $temp_dir)` | `Convert::toJpegFrames($temp_dir/frame)` then ffmpeg assembly | Returns the video path. **Decision C resolved (section 4).** |
| `dicom_tag::get_tag($group, $element)` | `$this->dataset()->get(hexdec($group), hexdec($element))` in **name-rendering** mode | Returns value string with well-known UIDs as dictionary names (v1 fidelity -- section 5). |
| `dicom_tag::load_tags()` | `$this->dataset()->all()` (name-rendering) -> populate `$this->tags` | Returns `null`. `tags` keyed `"GGGG,EEEE" => value`. |
| `dicom_tag::write_tags($tag_arr)` | per entry: `->put(hexdec($g), hexdec($e), $value)` | `$tag_arr` = `"GGGG,EEEE" => value`. Falsy on success, error string on failure. |
| `dicom_net::echoscu($host, $port, $my_ae, $remote_ae)` | `(new EchoSCU(new Peer($host, (int) $port, $remote_ae), new Association($my_ae)))->verify()` | `0` on success, error string on failure. |
| `dicom_net::send_dcm($host, $port, $my_ae, $remote_ae, $send_batch)` | `new SCU(new Peer(...), new Association($my_ae), $proposal)` then `$send_batch ? sendDirectory(dirname($this->file)) : send(File::open($this->file))` | `transfer_syntax` -> proposal (default `automatic()`). Falsy on success, error string on failure. |
| `dicom_net::store_server($port, $dcm_dir, $handler_script, $config_file, $debug)` | `(new SCP((int) $port, $dcm_dir, postReceiveCommand: "php {$handler_script} #p #f #a #c", ...))->start()` then block | Synchronous (`--exec-sync`). `config_file`/`debug` -> Decision D. |

---

## 3. The shim contract: deprecate, delegate, soften

Every public entry follows one shape, centralized in a small internal helper so it is written once:

1. **Deprecate.** Emit `E_USER_DEPRECATED` naming the v2 replacement (and an `@deprecated` docblock). One notice per call.
2. **Delegate.** Build the v2 objects from the arguments and the object's public properties; invoke the wrapper.
3. **Soften (rewrite plan section 9).** Wrap the delegation in a catch for `DICOM\Exception\ExceptionInterface` and `PACS\Exception\ExceptionInterface`; on a caught exception emit `E_USER_WARNING` naming the real problem and return the v1-shaped failure value rather than letting it propagate. The softening lives only in the shim -- the `DICOM\`/`PACS\` API stays fully fail-loud. Nothing is swallowed silently: the shim warns, it does not hide.

Supporting rules:

- **Public properties preserved and read at delegation time** (`jpg_quality`, `tn_size`, `temp_dir`, `transfer_syntax`, `file`, `tags`). `template` becomes a deprecated no-op property (`img2dcm` needs no XML template) so existing assignments do not error.
- **Lazy file handling.** Constructors keep `$file = ""` and store the path; the `DICOM\File` opens on demand, so `new dicom_convert()` does not fail.
- **No global-state mutation.** v1's `multiframe_to_video` `chdir`'d into its temp dir and never restored the process cwd (capability map). The shim never changes the working directory and uses absolute paths throughout.
- **Provenance.** SPDX header and the clean-room note on every shim file.

---

## 4. The three deferred conversion entry points

- **`jpg_to_dcm($arr_info)`** -> `Convert::fromJpeg([$this->jpg_file], $out)`, then the `$arr_info` tags applied via `Dataset::put`, returning `$out`. `img2dcm` mints the type-1 UIDs itself, so v1's `xml2dcm` SOPInstanceUID bug is impossible by construction.
- **`pdf_to_dcm` / `pdf_to_dcmcr`** -> `Convert::fromPdf`. **Improved functionality, explicitly not a validated compat reproduction** (Decision A). Both are documented in the shim and the migration guide as v2 behavior, not v1 fidelity.
- **`multiframe_to_video($format, $framerate, $temp_dir)`** -> `Convert::toJpegFrames("{temp_dir}/frame")` then ffmpeg. Verified invocation: `ffmpeg -y -framerate {framerate} -start_number 0 -i "{temp_dir}/frame.%d.jpg" -pix_fmt yuv420p {out}.{format}`. ffmpeg is a new, shim-only hard dependency: missing ffmpeg fails loud (then softens to the v1-shaped failure value) rather than silently degrading the way v1 does on current DCMTK. No `chdir`; the temp dir is created and removed explicitly; returns the video path.

---

## 5. UID rendering as a first-class capability (Decision C)

v1's `get_tag`/`load_tags` render well-known UID-valued tags as **dictionary names** -- `get_tag('0002','0010')` returns `'JPEGBaseline'`, `0002,0002` returns `'ComputedRadiographyImageStorage'` -- while unknown UIDs (e.g. an instance UID) stay numeric. This is `dcmdump`'s default rendering; v1 used no `-Un`. v2's `Dataset` reads with `-Un`, so it returns numeric UIDs.

Strict v1 fidelity is required, and the new behavior is **elevated as a proper interface element, not cobbled into the shim**: a `UIDRendering` typed-choice in the `DICOM\` layer, consistent with the existing `Windowing`/`Scale`/`Compression` option objects.

- `UIDRendering::numeric()` -- the current behavior (passes `-Un`); remains the `Dataset` default, so all existing v2 code and tests are unaffected.
- `UIDRendering::dictionaryNames()` -- omits `-Un`, letting `dcmdump` map well-known UIDs to names. This reuses `dcmdump`'s own UID dictionary, so fidelity is exact (well-known -> name, unknown -> numeric) without reimplementing the registry.

The mode threads into the `Dataset` read; the shim's `dicom_tag` reads in `dictionaryNames()` mode. This lands first as a tested, documented core capability (checkpoint 6b) before the shim consumes it.

---

## 6. Autoloading, legacy removal, provenance

- **Autoload.** The two functions via Composer `"files"`; the three global classes via `"classmap"` (or `"files"`). They are deliberately non-namespaced, so PSR-4 does not apply.
- **Legacy removal.** The legacy `class_dicom.php` is deleted in this phase -- the shim replaces it, same public surface, newly authored bodies. A grep confirms nothing else references the old file before removal.
- **Migration map.** The section 2 table is the seed of the Phase 7 migration guide; the two are the same v1->v2 mapping and stay consistent by construction. The `pdf_to_dcm`/`pdf_to_dcmcr` rows carry the "improved, not validated compat" note (Decision A) into that guide.

---

## 7. Testing (the section 9 behavioral check)

- **Call compatibility.** Each v1 entry is callable with its v1 signature and produces the expected v2 effect (file written, tag read, object sent), validated against the pydicom oracle and real `storescp`/`storescu` peers (reusing the Phase 5 traits).
- **Deprecation.** Each call emits exactly one `E_USER_DEPRECATED`, captured via `set_error_handler`.
- **Softening.** A failure v2 is strict about but v1 tolerated produces an `E_USER_WARNING` and the v1-shaped value, not a throw.
- **UID rendering.** `UIDRendering::dictionaryNames()` reproduces the observed v1 strings (`'JPEGBaseline'`, well-known SOP class names) while unknown UIDs stay numeric; `numeric()` is unchanged. The shim's `get_tag`/`load_tags` match v1's blackbox output.
- **No cwd leak.** The process working directory is unchanged after `multiframe_to_video`.
- **Clean-room.** Tests are authored from the footprint and the published surface, never the legacy file.

---

## 8. Decisions

**Resolved by research** (README/`examples/` + blackbox + DCMTK/ffmpeg probes):

- **Array shapes.** `"GGGG,EEEE" => value` for `write_tags`/`jpg_to_dcm`; `get_tag(group, element)` as two 4-hex strings; `tags` keyed `"GGGG,EEEE"`.
- **Output paths.** `dcm_to_jpg` -> `{file}.jpg`, `dcm_to_tn` -> `{file}_tn.jpg` (overridable via `jpg_file`/`tn_file`); `compress`/`uncompress` take an explicit output or overwrite.
- **Return shapes.** `is_dcm` -> `1`/`0`; `load_tags` -> `null` (fills `tags`); `get_tag` -> value string; conversions -> output path; `write_tags`/`send_dcm` -> falsy on success / error string on failure; `echoscu` -> `0` / error string; `multiframe_to_video` -> video path.
- **`send_batch`.** Truthy -> send every file in `dirname($this->file)` via `SCU::sendDirectory`; falsy -> single `send`.
- **`store_server`.** Blocking; handler invoked `php handler.php <dir> <file> <from_ae> <to_ae>`, mapped to `storescp --exec-on-reception` (`-xcr`) with `--exec-sync` (`-xs`) and the `#p #f #a #c` placeholders (man-page placeholders; verified empirically in 6g).
- **ffmpeg.** Required; invocation in section 4 (tested).
- **`transfer_syntax`.** Undocumented/unused in examples; default `automatic()`, map known values if any surface.

**Settled by the owner:**

- **A -- `pdf_to_dcm` / `pdf_to_dcmcr`.** v1's versions are non-functional (no external tool, null return, no output -- blackbox confirms the capability map). v2 provides working Encapsulated PDF conversion via `Convert::fromPdf`, with `pdf_to_dcmcr` a deprecated alias. **Documented as improved v2 functionality, explicitly not a validated compatibility reproduction of v1** -- the shim docblocks and the migration guide state this plainly.
- **B -- `Execute($command)`.** Re-exposed as a deprecated passthrough that preserves v1's documented "shell execution wrapper (captures stdout + stderr)" behavior, but emits `E_USER_DEPRECATED` and is clearly marked a deprecated compatibility layer with no v2 replacement (exec is intentionally outside the substrate).
- **C -- Tag value rendering.** Strict v1 fidelity. Implemented via the elevated `UIDRendering` interface element (section 5), not a one-off shim hack.
- **D -- `store_server` `config_file`/`debug`.** Open sub-point: with v2's `+xa` accepting all supported transfer syntaxes, `config_file` is likely redundant. Proposed: accept and ignore both with a one-time `E_USER_WARNING`, or, if SOP-class restriction turns out to matter, elevate a config option on `PACS\SCP` (same "elevate, don't cobble" rule). Resolve at checkpoint 6g.

---

## 9. Build sequence

One CI-green logical checkpoint per commit on `claude`, in order:

- **6a -- Scaffold + contract helper.** The deprecate/delegate/soften helper, `is_dcm`, `Execute` (Decision B), and the locked v1-shaped return values.
- **6b -- `UIDRendering` on `Dataset` (core).** The typed-choice and the `-Un` toggle, default `numeric()`; name-rendering tested against the observed v1 strings. The one v2-core addition this phase makes.
- **6c -- `dicom_tag`.** `get_tag`/`load_tags` (in `dictionaryNames()` mode), `write_tags`, the `file`/`tags` properties.
- **6d -- `dicom_convert` render + codec.** `dcm_to_jpg`, `dcm_to_tn`, `compress`, `uncompress`, and the render-related properties.
- **6e -- `dicom_convert` creation.** `jpg_to_dcm`, `pdf_to_dcm`, `pdf_to_dcmcr` (Decision A).
- **6f -- `dicom_convert` multiframe.** `multiframe_to_video` + the ffmpeg assembly (section 4).
- **6g -- `dicom_net`.** `echoscu`, `send_dcm`, `store_server` (Decision D; verify the `#p #f #a #c` placeholders), the `file`/`transfer_syntax` properties.
- **6h -- Wire-up + legacy removal.** Composer autoload entries, delete the legacy `class_dicom.php`, seed the Phase 7 migration map from the section 2 table.
