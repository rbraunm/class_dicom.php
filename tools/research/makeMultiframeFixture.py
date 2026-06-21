#!/usr/bin/env python3
# SPDX-License-Identifier: Apache-2.0
# Copyright (c) 2026 Randy Braunm
"""Phase 0.5 -- synthesize a small multi-frame DICOM so multiframe_to_video can be exercised.

Writes an 8-frame 64x64 MONOCHROME2 Secondary Capture (zero pixels) using pydicom only -- no numpy,
so it runs in the oracle venv as-provisioned. Run with that interpreter, e.g.:

    /opt/dicom-oracle/bin/python makeMultiframeFixture.py /tmp/v1cap/multiframe.dcm
"""
import sys

from pydicom.dataset import Dataset
from pydicom.uid import (
    ExplicitVRLittleEndian,
    SecondaryCaptureImageStorage,
    generate_uid,
)

FRAMES, ROWS, COLS = 8, 64, 64


def main() -> None:
    out = sys.argv[1] if len(sys.argv) > 1 else "multiframe.dcm"

    ds = Dataset()
    ds.file_meta = Dataset()
    ds.file_meta.MediaStorageSOPClassUID = SecondaryCaptureImageStorage
    ds.file_meta.MediaStorageSOPInstanceUID = generate_uid()
    ds.file_meta.TransferSyntaxUID = ExplicitVRLittleEndian

    ds.SOPClassUID = SecondaryCaptureImageStorage
    ds.SOPInstanceUID = ds.file_meta.MediaStorageSOPInstanceUID
    ds.StudyInstanceUID = generate_uid()
    ds.SeriesInstanceUID = generate_uid()
    ds.PatientName = "MULTI^FRAME"
    ds.PatientID = "MF001"
    ds.Modality = "OT"
    ds.NumberOfFrames = FRAMES
    ds.Rows = ROWS
    ds.Columns = COLS
    ds.SamplesPerPixel = 1
    ds.PhotometricInterpretation = "MONOCHROME2"
    ds.BitsAllocated = 8
    ds.BitsStored = 8
    ds.HighBit = 7
    ds.PixelRepresentation = 0
    ds.PixelData = bytes(FRAMES * ROWS * COLS)

    ds.save_as(out, enforce_file_format=True)
    print(f"wrote {out} ({FRAMES} frames, {ROWS}x{COLS})")


if __name__ == "__main__":
    main()
