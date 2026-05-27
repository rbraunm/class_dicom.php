"""Lightweight DICOM SCP for integration testing.

Handles C-ECHO and C-STORE. Received files are written to a configurable
directory so the test runner can inspect them with pydicom after the PHP
code sends them.

Usage:
    python3 dicom_scp.py [port] [output_dir]
    # defaults: port=11112, output_dir=./received
"""
import sys, os, signal, threading
from pathlib import Path
from pynetdicom import AE, evt, StoragePresentationContexts, VerificationPresentationContexts

DEFAULT_PORT = 11112
DEFAULT_DIR = "./received"

received_files = []


def handle_store(event, output_dir):
    """Handle a C-STORE request."""
    ds = event.dataset
    ds.file_meta = event.file_meta
    fname = f"{ds.SOPInstanceUID}.dcm"
    out_path = Path(output_dir) / fname
    ds.save_as(out_path, write_like_original=False)
    received_files.append(str(out_path))
    return 0x0000  # Success


def handle_echo(event, output_dir):
    """Handle a C-ECHO request. Write a marker so tests can confirm it happened."""
    marker = Path(output_dir) / ".echo_received"
    count = int(marker.read_text()) + 1 if marker.exists() else 1
    marker.write_text(str(count))
    return 0x0000


def run(port=DEFAULT_PORT, output_dir=DEFAULT_DIR):
    Path(output_dir).mkdir(parents=True, exist_ok=True)

    ae = AE(ae_title="TEST_SCP")
    ae.supported_contexts = StoragePresentationContexts + VerificationPresentationContexts

    handlers = [
        (evt.EVT_C_STORE, handle_store, [output_dir]),
        (evt.EVT_C_ECHO, handle_echo, [output_dir]),
    ]

    server = ae.start_server(("127.0.0.1", port), evt_handlers=handlers, block=False)
    print(f"SCP listening on 127.0.0.1:{port}, storing to {output_dir}", flush=True)

    # Write a ready marker so the test runner knows we're up
    Path(output_dir).joinpath(".scp_ready").write_text(str(os.getpid()))

    try:
        server.serve_forever()
    except (KeyboardInterrupt, SystemExit):
        pass
    finally:
        server.shutdown()
        print("SCP shut down.")


if __name__ == "__main__":
    port = int(sys.argv[1]) if len(sys.argv) > 1 else DEFAULT_PORT
    output_dir = sys.argv[2] if len(sys.argv) > 2 else DEFAULT_DIR
    run(port, output_dir)
