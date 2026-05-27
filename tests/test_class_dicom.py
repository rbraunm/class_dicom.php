#!/usr/bin/env python3
"""Integration tests for class_dicom.php.

Exercises every public method against real DICOM files, using pydicom for
independent validation and pynetdicom as a test SCP for network operations.
Image outputs are validated with Pillow.

Requirements:
    - php-cli, dcmtk (apt)
    - pydicom, pynetdicom, Pillow (pip)
    - DCMTK binaries reachable at TOOLKIT_DIR (default /usr/local/bin)
"""
import subprocess, os, sys, time, signal, shutil, json
from pathlib import Path

import pydicom
from PIL import Image
import numpy as np

REPO_DIR = Path(__file__).resolve().parent.parent
CLASS_FILE = REPO_DIR / "class_dicom.php"
EXAMPLES_DIR = REPO_DIR / "examples"
TEST_DCM = EXAMPLES_DIR / "dean.dcm"
WORK_DIR = REPO_DIR / "tests" / "_work"
SCP_DIR = WORK_DIR / "received"
SCP_PORT = 11113
SCP_PROC = None

# Ground truth — loaded once, used by every test that needs to cross-validate
SRC_DS = None

PASS = 0
FAIL = 0

JPEG_MAGIC = b"\xff\xd8\xff"

UNCOMPRESSED_TS = {
    "1.2.840.10008.1.2",      # Implicit VR Little Endian
    "1.2.840.10008.1.2.1",    # Explicit VR Little Endian
    "1.2.840.10008.1.2.2",    # Explicit VR Big Endian
}

JPEG_TS_PREFIX = "1.2.840.10008.1.2.4."  # All JPEG transfer syntaxes


def php(code: str) -> subprocess.CompletedProcess:
    """Run a PHP snippet that auto-requires the class file."""
    wrapped = f'require_once("{CLASS_FILE}"); {code}'
    return subprocess.run(
        ["php", "-r", wrapped],
        capture_output=True, text=True, cwd=str(REPO_DIR), timeout=30,
    )


def result(name: str, passed: bool, detail: str = ""):
    global PASS, FAIL
    tag = "PASS" if passed else "FAIL"
    if passed:
        PASS += 1
    else:
        FAIL += 1
    msg = f"  [{tag}] {name}"
    if detail and not passed:
        msg += f" — {detail}"
    print(msg)


# ── Setup ────────────────────────────────────────────────────────────────

def setup():
    global SRC_DS
    if WORK_DIR.exists():
        shutil.rmtree(WORK_DIR)
    WORK_DIR.mkdir(parents=True)
    SCP_DIR.mkdir(parents=True)
    shutil.copy(TEST_DCM, WORK_DIR / "test_input.dcm")
    SRC_DS = pydicom.dcmread(str(TEST_DCM))


def teardown():
    global SCP_PROC
    if SCP_PROC:
        SCP_PROC.terminate()
        SCP_PROC.wait(timeout=5)
        SCP_PROC = None


# ── SCP management ───────────────────────────────────────────────────────

def start_scp():
    global SCP_PROC
    scp_script = REPO_DIR / "tests" / "dicom_scp.py"
    SCP_PROC = subprocess.Popen(
        ["python3", str(scp_script), str(SCP_PORT), str(SCP_DIR)],
        stdout=subprocess.PIPE, stderr=subprocess.PIPE,
    )
    ready = SCP_DIR / ".scp_ready"
    for _ in range(50):
        if ready.exists():
            return True
        time.sleep(0.1)
    return False


# ── Tests: is_dcm ────────────────────────────────────────────────────────

def test_is_dcm():
    print("\nis_dcm()")

    r = php(f'echo is_dcm("{TEST_DCM}");')
    result("valid DICOM returns 1", r.stdout.strip() == "1", r.stderr)

    fake = WORK_DIR / "not_dicom.txt"
    fake.write_text("this is not a dicom file")
    r = php(f'echo is_dcm("{fake}");')
    result("non-DICOM returns 0", r.stdout.strip() == "0", r.stderr)

    # Edge case: file containing the word "error" in its content should
    # not trick is_dcm — but a non-DICOM file should still return 0
    # regardless of content
    tricky = WORK_DIR / "tricky.bin"
    tricky.write_bytes(b"\x00" * 128 + b"DICM" + b"error in processing")
    r = php(f'echo is_dcm("{tricky}");')
    result("partial DICOM preamble without valid tags returns 0",
           r.stdout.strip() == "0", r.stderr)


# ── Tests: dicom_tag ─────────────────────────────────────────────────────

def test_dicom_tag():
    print("\ndicom_tag")

    r = php(f'''
        $d = new dicom_tag("{TEST_DCM}");
        echo json_encode([
            "name"       => $d->get_tag("0010", "0010"),
            "modality"   => $d->get_tag("0008", "0060"),
            "study_date" => $d->get_tag("0008", "0020"),
            "sop_uid"    => $d->get_tag("0008", "0018"),
            "missing"    => $d->get_tag("9999", "9999"),
            "count"      => count($d->tags),
        ]);
    ''')
    try:
        data = json.loads(r.stdout)
    except json.JSONDecodeError:
        result("load_tags + get_tag", False, f"bad JSON: {r.stdout} {r.stderr}")
        return

    result("patient name matches pydicom",
           data["name"] == str(SRC_DS.PatientName),
           f'php="{data["name"]}" pydicom="{SRC_DS.PatientName}"')
    result("modality matches pydicom",
           data["modality"] == SRC_DS.Modality,
           f'php="{data["modality"]}" pydicom="{SRC_DS.Modality}"')
    result("study date matches pydicom",
           data["study_date"] == SRC_DS.StudyDate,
           f'php="{data["study_date"]}" pydicom="{SRC_DS.StudyDate}"')
    result("SOP Instance UID matches pydicom",
           data["sop_uid"] == SRC_DS.SOPInstanceUID,
           f'php="{data["sop_uid"]}" pydicom="{SRC_DS.SOPInstanceUID}"')
    result("missing tag returns empty string",
           data["missing"] == "", f'got "{data["missing"]}"')
    result("tag count > 0", data["count"] > 0, f'count={data["count"]}')


def test_write_tags():
    print("\ndicom_tag::write_tags")

    work_file = WORK_DIR / "test_input.dcm"
    new_name = "TEST^WRITE"
    new_institution = "INTEGRATION_TEST_HOSPITAL"

    r = php(f'''
        $d = new dicom_tag("{work_file}");
        $d->write_tags([
            "0010,0010" => "{new_name}",
            "0008,0080" => "{new_institution}",
        ]);
        $d2 = new dicom_tag("{work_file}");
        echo json_encode([
            "name" => $d2->get_tag("0010", "0010"),
            "institution" => $d2->get_tag("0008", "0080"),
        ]);
    ''')
    try:
        data = json.loads(r.stdout)
    except json.JSONDecodeError:
        result("write_tags", False, f"bad JSON: {r.stdout} {r.stderr}")
        return

    result("PHP reads back written patient name",
           data["name"] == new_name, f'got "{data["name"]}"')
    result("PHP reads back written institution",
           data["institution"] == new_institution, f'got "{data["institution"]}"')

    # Cross-validate both tags with pydicom
    ds = pydicom.dcmread(str(work_file))
    result("pydicom confirms patient name",
           str(ds.PatientName) == new_name, f'pydicom="{ds.PatientName}"')
    result("pydicom confirms institution",
           str(ds.InstitutionName) == new_institution,
           f'pydicom="{ds.InstitutionName}"')

    # Verify write didn't clobber unrelated tags
    result("SOP Instance UID unchanged after write",
           ds.SOPInstanceUID == SRC_DS.SOPInstanceUID,
           f'now="{ds.SOPInstanceUID}" was="{SRC_DS.SOPInstanceUID}"')
    result("modality unchanged after write",
           ds.Modality == SRC_DS.Modality,
           f'now="{ds.Modality}" was="{SRC_DS.Modality}"')


# ── Tests: dicom_convert ─────────────────────────────────────────────────

def test_dcm_to_jpg():
    print("\ndicom_convert::dcm_to_jpg")

    jpg_path = WORK_DIR / "convert_test.jpg"
    r = php(f'''
        $c = new dicom_convert("{TEST_DCM}");
        $c->jpg_file = "";
        $jpg = $c->dcm_to_jpg();
        if(file_exists($jpg)) {{
            copy($jpg, "{jpg_path}");
            unlink($jpg);
        }}
        echo $jpg;
    ''')

    if not jpg_path.exists():
        result("JPEG file created", False, f"no output; php: {r.stdout} {r.stderr}")
        return
    result("JPEG file created", True)

    # Validate JPEG magic bytes
    with open(jpg_path, "rb") as f:
        header = f.read(3)
    result("file starts with JPEG magic bytes (FF D8 FF)",
           header == JPEG_MAGIC, f'got {header.hex()}')

    # Load with Pillow — confirms it's a decodable image, not just bytes
    try:
        img = Image.open(jpg_path)
        img.load()  # Force full decode
        result("Pillow can fully decode the JPEG", True)
    except Exception as e:
        result("Pillow can fully decode the JPEG", False, str(e))
        return

    # Verify dimensions are plausible against DICOM metadata
    dcm_rows = int(SRC_DS.Rows)
    dcm_cols = int(SRC_DS.Columns)
    result(f"image dimensions match DICOM ({dcm_cols}x{dcm_rows})",
           img.size == (dcm_cols, dcm_rows),
           f'JPEG={img.size[0]}x{img.size[1]}')


def test_dcm_to_tn():
    print("\ndicom_convert::dcm_to_tn")

    tn_path = WORK_DIR / "thumbnail_test.jpg"
    tn_size = 125  # default in the class
    r = php(f'''
        $c = new dicom_convert("{TEST_DCM}");
        $tn = $c->dcm_to_tn();
        if(file_exists($tn)) {{
            copy($tn, "{tn_path}");
            unlink($tn);
        }}
        echo $tn;
    ''')

    if not tn_path.exists():
        result("thumbnail file created", False, f"no output; php: {r.stdout} {r.stderr}")
        return
    result("thumbnail file created", True)

    with open(tn_path, "rb") as f:
        header = f.read(3)
    result("file starts with JPEG magic bytes",
           header == JPEG_MAGIC, f'got {header.hex()}')

    try:
        img = Image.open(tn_path)
        img.load()
        result("Pillow can fully decode the thumbnail", True)
    except Exception as e:
        result("Pillow can fully decode the thumbnail", False, str(e))
        return

    # dcm_to_tn uses +Sxv which scales by width
    result(f"thumbnail width matches configured tn_size ({tn_size})",
           img.size[0] == tn_size,
           f'got width={img.size[0]}')
    result("thumbnail smaller than full image",
           img.size[0] < int(SRC_DS.Columns) and img.size[1] < int(SRC_DS.Rows),
           f'tn={img.size}, full={SRC_DS.Columns}x{SRC_DS.Rows}')


def test_uncompress():
    print("\ndicom_convert::uncompress")

    src = WORK_DIR / "test_input.dcm"
    out = WORK_DIR / "uncompressed.dcm"

    # Read the file's current state as ground truth for this test
    src_ds = pydicom.dcmread(str(src))
    src_ts = str(src_ds.file_meta.TransferSyntaxUID)

    # Confirm source is actually compressed, otherwise the test is vacuous
    if src_ts in UNCOMPRESSED_TS:
        result("SKIP: source file already uncompressed, test is vacuous", False,
               f'src ts={src_ts}')
        return

    r = php(f'''
        $c = new dicom_convert("{src}");
        $c->uncompress("{out}");
    ''')

    if not out.exists():
        result("uncompressed file created", False, r.stderr)
        return
    result("uncompressed file created", True)

    ds = pydicom.dcmread(str(out))
    out_ts = str(ds.file_meta.TransferSyntaxUID)

    result("transfer syntax changed from compressed to uncompressed",
           out_ts in UNCOMPRESSED_TS and src_ts != out_ts,
           f'src={src_ts} out={out_ts}')

    # Verify patient demographics survived — compare against the file's
    # current state, not the original SRC_DS (earlier tests may have
    # modified the working copy)
    result("patient name preserved",
           str(ds.PatientName) == str(src_ds.PatientName),
           f'got="{ds.PatientName}" expected="{src_ds.PatientName}"')
    result("SOP Instance UID preserved",
           ds.SOPInstanceUID == src_ds.SOPInstanceUID,
           f'got="{ds.SOPInstanceUID}"')
    result("modality preserved",
           ds.Modality == src_ds.Modality,
           f'got="{ds.Modality}"')

    # Verify pixel data is readable (pydicom can decode it)
    try:
        pixels = ds.pixel_array
        result("pixel data is readable by pydicom", True)
        result(f"pixel dimensions match DICOM metadata ({ds.Columns}x{ds.Rows})",
               pixels.shape == (int(ds.Rows), int(ds.Columns)),
               f'pixel_array.shape={pixels.shape}')
    except Exception as e:
        result("pixel data is readable by pydicom", False, str(e))


def test_compress():
    print("\ndicom_convert::compress")

    src = WORK_DIR / "test_input.dcm"
    uncompressed = WORK_DIR / "for_compress.dcm"
    compressed = WORK_DIR / "recompressed.dcm"

    # Uncompress first so we have a known-uncompressed source
    php(f'''
        $c = new dicom_convert("{src}");
        $c->uncompress("{uncompressed}");
    ''')
    if not uncompressed.exists():
        result("compress (needs uncompressed input)", False, "uncompress step failed")
        return

    uncomp_ds = pydicom.dcmread(str(uncompressed))
    uncomp_ts = str(uncomp_ds.file_meta.TransferSyntaxUID)

    r = php(f'''
        $c = new dicom_convert("{uncompressed}");
        $c->compress("{compressed}");
    ''')

    if not compressed.exists():
        result("compressed file created", False, f'{r.stdout} {r.stderr}')
        return
    result("compressed file created", True)

    comp_ds = pydicom.dcmread(str(compressed))
    comp_ts = str(comp_ds.file_meta.TransferSyntaxUID)

    result("transfer syntax changed to JPEG",
           comp_ts.startswith(JPEG_TS_PREFIX) and comp_ts != uncomp_ts,
           f'src={uncomp_ts} out={comp_ts}')

    result("compressed file smaller than uncompressed",
           compressed.stat().st_size < uncompressed.stat().st_size,
           f'{compressed.stat().st_size} vs {uncompressed.stat().st_size}')

    # Verify demographics survived compression
    result("patient name preserved through compress",
           str(comp_ds.PatientName) == str(uncomp_ds.PatientName),
           f'got="{comp_ds.PatientName}"')
    result("SOP Instance UID preserved through compress",
           comp_ds.SOPInstanceUID == uncomp_ds.SOPInstanceUID,
           f'got="{comp_ds.SOPInstanceUID}"')
    result("modality preserved through compress",
           comp_ds.Modality == uncomp_ds.Modality,
           f'got="{comp_ds.Modality}"')


# ── Tests: dicom_net ─────────────────────────────────────────────────────

def test_echoscu():
    print("\ndicom_net::echoscu")

    echo_marker = SCP_DIR / ".echo_received"
    if echo_marker.exists():
        echo_marker.unlink()

    r = php(f'''
        $n = new dicom_net;
        $out = $n->echoscu("127.0.0.1", {SCP_PORT}, "TEST_SCU", "TEST_SCP");
        echo $out;
    ''')
    result("PHP echoscu returned without error",
           r.returncode == 0, f'rc={r.returncode} {r.stderr}')

    # Confirm the SCP actually received and processed the echo
    time.sleep(0.5)
    result("SCP recorded a C-ECHO event",
           echo_marker.exists() and echo_marker.read_text().strip() == "1",
           "no .echo_received marker from SCP")


def test_send_dcm():
    print("\ndicom_net::send_dcm")

    for f in SCP_DIR.glob("*.dcm"):
        f.unlink()

    # Uncompress — storescu needs a transfer syntax the SCP will accept
    src = WORK_DIR / "test_input.dcm"
    send_file = WORK_DIR / "send_uncompressed.dcm"
    php(f'''
        $c = new dicom_convert("{src}");
        $c->uncompress("{send_file}");
    ''')
    if not send_file.exists():
        result("send_dcm (uncompress prep)", False, "could not uncompress test file")
        return

    sent_ds = pydicom.dcmread(str(send_file))

    r = php(f'''
        $n = new dicom_net;
        $n->file = "{send_file}";
        $out = $n->send_dcm("127.0.0.1", {SCP_PORT}, "TEST_SCU", "TEST_SCP");
        echo $out;
    ''')

    time.sleep(1)

    received = list(SCP_DIR.glob("*.dcm"))
    result("SCP received exactly 1 file", len(received) == 1,
           f'got {len(received)} files; php: {r.stdout} {r.stderr}')

    if not received:
        return

    recv_ds = pydicom.dcmread(str(received[0]))

    result("SOP Instance UID preserved",
           recv_ds.SOPInstanceUID == sent_ds.SOPInstanceUID,
           f'sent="{sent_ds.SOPInstanceUID}" recv="{recv_ds.SOPInstanceUID}"')
    result("patient name preserved",
           str(recv_ds.PatientName) == str(sent_ds.PatientName),
           f'sent="{sent_ds.PatientName}" recv="{recv_ds.PatientName}"')
    result("modality preserved",
           recv_ds.Modality == sent_ds.Modality,
           f'sent="{sent_ds.Modality}" recv="{recv_ds.Modality}"')
    result("study date preserved",
           recv_ds.StudyDate == sent_ds.StudyDate,
           f'sent="{sent_ds.StudyDate}" recv="{recv_ds.StudyDate}"')

    # Verify pixel data survived the network trip
    try:
        sent_pixels = sent_ds.pixel_array
        recv_pixels = recv_ds.pixel_array
        result("pixel data survived network transfer (arrays match)",
               np.array_equal(sent_pixels, recv_pixels),
               f'sent shape={sent_pixels.shape} recv shape={recv_pixels.shape}')
    except Exception as e:
        result("pixel data readable after network transfer", False, str(e))


# ── Main ─────────────────────────────────────────────────────────────────

def main():
    setup()

    print("=" * 60)
    print("class_dicom.php integration tests")
    print(f"  source: {TEST_DCM.name}")
    print(f"  patient: {SRC_DS.PatientName}  modality: {SRC_DS.Modality}")
    print(f"  {SRC_DS.Columns}x{SRC_DS.Rows}  TS: {SRC_DS.file_meta.TransferSyntaxUID}")
    print("=" * 60)

    test_is_dcm()
    test_dicom_tag()
    test_write_tags()
    test_dcm_to_jpg()
    test_dcm_to_tn()
    test_uncompress()
    test_compress()

    print("\n— Starting DICOM SCP —")
    if start_scp():
        print(f"  SCP ready on port {SCP_PORT}")
        test_echoscu()
        test_send_dcm()
    else:
        print("  SCP failed to start, skipping network tests")

    teardown()

    print(f"\n{'=' * 60}")
    print(f"Results: {PASS} passed, {FAIL} failed")
    print("=" * 60)
    return 1 if FAIL > 0 else 0


if __name__ == "__main__":
    sys.exit(main())
