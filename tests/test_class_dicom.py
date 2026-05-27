#!/usr/bin/env python3
"""Integration tests for class_dicom.php.

Exercises every public method against real DICOM files, using pydicom for
independent validation and pynetdicom as a test SCP for network operations.

Requirements:
    - php-cli, dcmtk (apt)
    - pydicom, pynetdicom (pip)
    - DCMTK binaries reachable at TOOLKIT_DIR (default /usr/local/bin)
"""
import subprocess, os, sys, time, signal, shutil, json
from pathlib import Path

import pydicom

REPO_DIR = Path(__file__).resolve().parent.parent
CLASS_FILE = REPO_DIR / "class_dicom.php"
EXAMPLES_DIR = REPO_DIR / "examples"
TEST_DCM = EXAMPLES_DIR / "dean.dcm"
WORK_DIR = REPO_DIR / "tests" / "_work"
SCP_DIR = WORK_DIR / "received"
SCP_PORT = 11113
SCP_PROC = None

PASS = 0
FAIL = 0


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
    if WORK_DIR.exists():
        shutil.rmtree(WORK_DIR)
    WORK_DIR.mkdir(parents=True)
    SCP_DIR.mkdir(parents=True)
    # Copy test file to work dir so write tests don't touch the original
    shutil.copy(TEST_DCM, WORK_DIR / "test_input.dcm")


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
    # Wait for ready marker
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


# ── Tests: dicom_tag ─────────────────────────────────────────────────────

def test_dicom_tag():
    print("\ndicom_tag")

    # Cross-validate with pydicom
    ds = pydicom.dcmread(str(TEST_DCM))

    r = php(f'''
        $d = new dicom_tag("{TEST_DCM}");
        echo json_encode([
            "name" => $d->get_tag("0010", "0010"),
            "modality" => $d->get_tag("0008", "0060"),
            "count" => count($d->tags),
        ]);
    ''')
    try:
        data = json.loads(r.stdout)
    except json.JSONDecodeError:
        result("load_tags + get_tag", False, f"bad JSON: {r.stdout} {r.stderr}")
        return

    result("patient name matches pydicom",
           data["name"] == str(ds.PatientName), f'{data["name"]} vs {ds.PatientName}')
    result("modality matches pydicom",
           data["modality"] == ds.Modality, f'{data["modality"]} vs {ds.Modality}')
    result("tag count > 0", data["count"] > 0, f'count={data["count"]}')


def test_write_tags():
    print("\ndicom_tag::write_tags")

    work_file = WORK_DIR / "test_input.dcm"
    new_name = "TEST^WRITE"

    r = php(f'''
        $d = new dicom_tag("{work_file}");
        $d->write_tags(["0010,0010" => "{new_name}"]);
        $d2 = new dicom_tag("{work_file}");
        echo $d2->get_tag("0010", "0010");
    ''')
    result("write_tags changes patient name",
           r.stdout.strip() == new_name, f'got "{r.stdout.strip()}" {r.stderr}')

    # Cross-validate with pydicom
    ds = pydicom.dcmread(str(work_file))
    result("pydicom confirms written tag",
           str(ds.PatientName) == new_name, f'pydicom says "{ds.PatientName}"')


# ── Tests: dicom_convert ─────────────────────────────────────────────────

def test_dcm_to_jpg():
    print("\ndicom_convert::dcm_to_jpg")

    r = php(f'''
        $c = new dicom_convert("{TEST_DCM}");
        $jpg = $c->dcm_to_jpg();
        echo json_encode([
            "jpg" => $jpg,
            "exists" => file_exists($jpg) ? 1 : 0,
            "size" => file_exists($jpg) ? filesize($jpg) : 0,
        ]);
    ''')
    try:
        data = json.loads(r.stdout)
    except json.JSONDecodeError:
        result("dcm_to_jpg", False, f"bad JSON: {r.stdout} {r.stderr}")
        return

    result("JPEG created", data["exists"] == 1, r.stderr)
    result("JPEG has content", data["size"] > 100, f'size={data["size"]}')

    # Cleanup
    jpg_path = Path(data["jpg"])
    if jpg_path.exists():
        jpg_path.unlink()


def test_dcm_to_tn():
    print("\ndicom_convert::dcm_to_tn")

    r = php(f'''
        $c = new dicom_convert("{TEST_DCM}");
        $tn = $c->dcm_to_tn();
        echo json_encode([
            "tn" => $tn,
            "exists" => file_exists($tn) ? 1 : 0,
            "size" => file_exists($tn) ? filesize($tn) : 0,
        ]);
    ''')
    try:
        data = json.loads(r.stdout)
    except json.JSONDecodeError:
        result("dcm_to_tn", False, f"bad JSON: {r.stdout} {r.stderr}")
        return

    result("thumbnail created", data["exists"] == 1, r.stderr)
    result("thumbnail has content", data["size"] > 100, f'size={data["size"]}')

    tn_path = Path(data["tn"])
    if tn_path.exists():
        tn_path.unlink()


def test_uncompress():
    print("\ndicom_convert::uncompress")

    src = WORK_DIR / "test_input.dcm"
    out = WORK_DIR / "uncompressed.dcm"

    r = php(f'''
        $c = new dicom_convert("{src}");
        $result = $c->uncompress("{out}");
        echo json_encode([
            "file" => $result,
            "exists" => file_exists("{out}") ? 1 : 0,
            "size" => file_exists("{out}") ? filesize("{out}") : 0,
        ]);
    ''')
    try:
        data = json.loads(r.stdout)
    except json.JSONDecodeError:
        result("uncompress", False, f"bad JSON: {r.stdout} {r.stderr}")
        return

    result("uncompressed file created", data["exists"] == 1, r.stderr)

    if out.exists():
        ds = pydicom.dcmread(str(out))
        ts = str(ds.file_meta.TransferSyntaxUID)
        uncompressed_uids = {
            "1.2.840.10008.1.2",      # Implicit VR Little Endian
            "1.2.840.10008.1.2.1",    # Explicit VR Little Endian
            "1.2.840.10008.1.2.2",    # Explicit VR Big Endian
        }
        result("transfer syntax is uncompressed",
               ts in uncompressed_uids, f'ts={ts}')


def test_compress():
    print("\ndicom_convert::compress")

    # First uncompress, then re-compress
    src = WORK_DIR / "test_input.dcm"
    uncompressed = WORK_DIR / "for_compress.dcm"
    compressed = WORK_DIR / "recompressed.dcm"

    # Uncompress first so we have an uncompressed source
    php(f'''
        $c = new dicom_convert("{src}");
        $c->uncompress("{uncompressed}");
    ''')

    if not uncompressed.exists():
        result("compress (needs uncompressed input)", False, "uncompress step failed")
        return

    r = php(f'''
        $c = new dicom_convert("{uncompressed}");
        $result = $c->compress("{compressed}");
        echo json_encode([
            "file" => $result,
            "exists" => file_exists("{compressed}") ? 1 : 0,
            "size" => file_exists("{compressed}") ? filesize("{compressed}") : 0,
        ]);
    ''')
    try:
        data = json.loads(r.stdout)
    except json.JSONDecodeError:
        result("compress", False, f"bad JSON: {r.stdout} {r.stderr}")
        return

    result("compressed file created", data["exists"] == 1, f'{r.stdout} {r.stderr}')
    if data["exists"] == 1:
        result("compressed file smaller than uncompressed",
               data["size"] < uncompressed.stat().st_size,
               f'{data["size"]} vs {uncompressed.stat().st_size}')


# ── Tests: dicom_net ─────────────────────────────────────────────────────

def test_echoscu():
    print("\ndicom_net::echoscu")

    r = php(f'''
        $n = new dicom_net;
        $out = $n->echoscu("127.0.0.1", {SCP_PORT}, "TEST_SCU", "TEST_SCP");
        echo $out;
    ''')
    # echoscu returns 0 on success (no output), non-zero on failure
    # The PHP wrapper returns the output string or 0
    passed = r.returncode == 0
    result("C-ECHO against pynetdicom SCP", passed, r.stderr)


def test_send_dcm():
    print("\ndicom_net::send_dcm")

    # Clear received dir
    for f in SCP_DIR.glob("*.dcm"):
        f.unlink()

    # Uncompress first — storescu needs to negotiate a transfer syntax
    # the SCP supports, and the default presentation contexts use
    # uncompressed syntaxes
    src = WORK_DIR / "test_input.dcm"
    send_file = WORK_DIR / "send_uncompressed.dcm"
    php(f'''
        $c = new dicom_convert("{src}");
        $c->uncompress("{send_file}");
    ''')
    if not send_file.exists():
        result("send_dcm (uncompress prep)", False, "could not uncompress test file")
        return

    r = php(f'''
        $n = new dicom_net;
        $n->file = "{send_file}";
        $out = $n->send_dcm("127.0.0.1", {SCP_PORT}, "TEST_SCU", "TEST_SCP");
        echo $out;
    ''')

    time.sleep(1)  # Give SCP a moment to write

    received = list(SCP_DIR.glob("*.dcm"))
    result("file received by SCP", len(received) > 0,
           f'{len(received)} files; php: {r.stdout} {r.stderr}')

    if received:
        ds_sent = pydicom.dcmread(str(send_file))
        ds_recv = pydicom.dcmread(str(received[0]))
        result("SOP Instance UID preserved",
               ds_sent.SOPInstanceUID == ds_recv.SOPInstanceUID)


# ── Main ─────────────────────────────────────────────────────────────────

def main():
    setup()

    print("=" * 60)
    print("class_dicom.php integration tests")
    print("=" * 60)

    # Non-network tests
    test_is_dcm()
    test_dicom_tag()
    test_write_tags()
    test_dcm_to_jpg()
    test_dcm_to_tn()
    test_uncompress()
    test_compress()

    # Network tests
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
