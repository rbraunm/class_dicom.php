# class_dicom.php v1 capability map

For each v1 public operation, the external command-line tool(s) it invokes and the
argv observed when the operation runs. This is the second Phase 0.5 artifact (the first
is [`v1-surface.json`](v1-surface.json), the reflected public surface). Together they fix
the v1 contract the v2 rewrite must reproduce.

**Capture method.** Empirical. The committed research harness drives every public entry
point (`tools/research/exerciseV1Surface.php`) while logging shims installed in
`/usr/local/bin` (`tools/research/makeToolShims.sh`) intercept and record every external
tool call before delegating to the real binary in `/usr/bin`. The table below is built
from the resulting shim log; no legacy source was read. Tool calls are attributed to the
operation under whose `### OP:` marker they were logged.

**DCMTK version.** `dcmdump v3.6.9 2024-12-11` (DCMTK 3.6.9).

Paths are generalized to placeholders (`<in.dcm>`, `<out.jpg>`, ...). Tool flags, and the
network parameters supplied by the harness (AE titles, host, port), are shown as observed.

| Operation | Tool(s) | Observed argv | Notes |
|---|---|---|---|
| `is_dcm` | `dcmdump` | `-M +L +Qn <file>` | Probes any file to decide if it is DICOM. Per `dcmdump --help`: `-M` (`--load-short`) do not load very long values such as pixel data; `+L` (`--print-all`) print long tag values completely; `+Qn` (`--quote-nonascii`) quote non-ASCII and control chars as XML markup (note: this is *not* quiet mode — quiet is `-q`). Run on both a DICOM and a non-DICOM input. |
| `dicom_tag::load_tags` | `dcmdump` | `-M +L +Qn <in.dcm>` | Same dump invocation; logged 3x in one `load_tags` call. |
| `dicom_tag::get_tag` | `dcmdump` | `-M +L +Qn <in.dcm>` | Same dump; logged 2x. Tag value is parsed from the dump output. |
| `dicom_tag::write_tags` | `dcmodify` | `-i (0010,0010)=<value> -i (0008,0080)=<value> -nb <target.dcm>` | One `-i` per tag written; `-nb` = no backup file. Edits in place. |
| `dicom_convert::dcm_to_jpg` | `dcmj2pnm` | `+oj +Jq 100 --use-window 1 <in.dcm> <out.jpg>` | JPEG output (`+oj`), quality 100, VOI window 1. |
| `dicom_convert::dcm_to_tn` | `dcmj2pnm` | `+oj +Jq 75 +Sxv 125 --use-window 1 <in.dcm> <out_tn.jpg>` | Thumbnail: scale to 125px (`+Sxv 125`), quality 75. |
| `dicom_convert::compress` | `dcmcjpeg` | `<in.dcm> <out.dcm>` | JPEG-compress the dataset. |
| `dicom_convert::uncompress` | `dcmdjpeg` | `<in.dcm> <out.dcm>` | Decompress the dataset. |
| `dicom_convert::jpg_to_dcm` | `xml2dcm` | `<temp.xml> <out.dcm>` | Only `xml2dcm` was intercepted (no `dcm2xml`): the XML is built from the bundled template (`jpg_to_dcm.xml`) and converted to DICOM. The known SOPInstanceUID issue is not visible at the argv level (it would live inside the generated XML); not observed in this capture. |
| `dicom_convert::pdf_to_dcm` | *(none observed)* | — | No external tool was intercepted under this operation. The op reported `[ok]`. The expected DCMTK tool (`pdf2dcm`) did not appear, so either the guess is wrong, the tool was not reached on this fixture, or it is invoked by a name/path outside the shimmed set. Flagged for follow-up. |
| `dicom_convert::pdf_to_dcmcr` | *(none observed)* | — | Same as `pdf_to_dcm`: no intercepted tool call. Flagged for follow-up. |
| `dicom_convert::multiframe_to_video` | `dcmj2pnm` (ffmpeg expected but not reached) | `+Fa +oj +Jq 100 <in.dcm> frame` | Frame extraction: `+Fa` = all frames, written to a `video_temp` working dir as `frame.0.jpg` … `frame.N.jpg`. The op resolves `<in.dcm>` relative to the class/repo location (`/opt/class_dicom/src/`), not the caller-supplied path. **ffmpeg argv not captured.** Observed facts only: all 8 frames were produced, the `ffmpeg` shim was present and first on `PATH`, `ffmpeg` was never invoked, and the op returned `[ok]`. The cause is undetermined without reading the legacy source (off-limits). This reads as a v1 behavior that silently degrades on the current DCMTK — the same family of issue as the `jpg_to_dcm` SOPInstanceUID problem (works only against an older toolkit's defaults). (Suspected, unconfirmed: a mismatch between the `frame.N.jpg` names `dcmj2pnm` writes and the input pattern the ffmpeg step expects.) The ffmpeg argv could not be surfaced by driving the public API; deferred to when the v2 multiframe path is built. **cwd footgun:** this op `chdir`'d into its temp dir (`video_temp`) and never restored the process cwd — the leaked cwd shows up in later operations (see `echoscu`/`send_dcm`, logged with `PWD=/tmp/v1cap/video_temp`). A v2 library method must not mutate global process cwd. |
| `dicom_net::echoscu` | `echoscu` | `-ta 5 -td 5 -to 5 -aet <my_ae> -aec <remote_ae> <host> <port>` | C-ECHO. Harness values: AE `CAP_AE`/`CAP_AE`, `127.0.0.1 11112`; v1 default AE is `DEANO`. ACSE/DIMSE/connection timeouts of 5s. |
| `dicom_net::send_dcm` | `dcmdump`, then `storescu` | `dcmdump -M +L +Qn <in.dcm>` then `storescu -ta 10 -td 10 -to 10 -aet <my_ae> -aec <remote_ae> <host> <port> <in.dcm>` | Probes the file with `dcmdump` first, then C-STORE via `storescu`. Harness values as above; 10s timeouts. |
| `dicom_net::store_server` | `storescp` (not captured) | — | Not captured (Phase 5). Per the README this is a long-running C-STORE SCP: `storescp` + a storage directory + a post-receive handler script + a config file. |
