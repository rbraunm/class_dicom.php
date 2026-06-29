#!/usr/bin/env python3
"""Generate Part 10 DICOM fixtures with known transfer syntaxes for Phase 1
detection tests. Detection reads only the File Meta group (0002), so these
carry a valid preamble + DICM + File Meta declaring the transfer syntax;
pixel data is not required to exercise is_dcm / transfer-syntax detection.

pydicom is the oracle here: it writes the known-good files our native reader
must parse. Re-run to regenerate; output is deterministic except for UIDs,
which are not asserted on.
"""
import pathlib

from pydicom import dcmwrite
from pydicom.dataset import Dataset, FileMetaDataset
from pydicom.uid import (
    ImplicitVRLittleEndian,
    ExplicitVRLittleEndian,
    ExplicitVRBigEndian,
    JPEGBaseline8Bit,
    JPEGLosslessSV1,
    generate_uid,
)

FIXTURES = pathlib.Path(__file__).parent / "fixtures"
SC_SOP_CLASS = "1.2.840.10008.5.1.4.1.1.7"  # Secondary Capture Image Storage

CASES = {
    "implicit_vr_le.dcm": ImplicitVRLittleEndian,
    "explicit_vr_le.dcm": ExplicitVRLittleEndian,
    "explicit_vr_be.dcm": ExplicitVRBigEndian,
    "jpeg_baseline.dcm": JPEGBaseline8Bit,
    "jpeg_lossless.dcm": JPEGLosslessSV1,
}


def build(transfer_syntax):
    sop_instance = generate_uid()
    fm = FileMetaDataset()
    fm.MediaStorageSOPClassUID = SC_SOP_CLASS
    fm.MediaStorageSOPInstanceUID = sop_instance
    fm.TransferSyntaxUID = transfer_syntax
    fm.ImplementationClassUID = generate_uid()

    ds = Dataset()
    ds.file_meta = fm
    ds.PatientName = "Phase1^Detection"
    ds.PatientID = "PH1"
    ds.SOPClassUID = SC_SOP_CLASS
    ds.SOPInstanceUID = sop_instance
    return ds


def build_tags_sample():
    """A dataset exercising the Phase 2 tag-read parse paths: a bracketed string
    (PatientName), a multi-valued string (ImageType -> [ORIGINAL\\PRIMARY]), a
    bare numeric (Rows), an empty type-2 value (AccessionNumber), and a 16 KB
    binary (ICCProfile) that exceeds the default +R 4 limit and so is reported as
    "(not loaded)"."""
    sop_instance = generate_uid()
    fm = FileMetaDataset()
    fm.MediaStorageSOPClassUID = SC_SOP_CLASS
    fm.MediaStorageSOPInstanceUID = sop_instance
    fm.TransferSyntaxUID = ExplicitVRLittleEndian
    fm.ImplementationClassUID = generate_uid()

    ds = Dataset()
    ds.file_meta = fm
    ds.SOPClassUID = SC_SOP_CLASS
    ds.SOPInstanceUID = sop_instance
    ds.PatientName = "DOE^JANE"
    ds.PatientID = "TAG1"
    ds.AccessionNumber = ""
    ds.ImageType = ["ORIGINAL", "PRIMARY"]
    ds.Rows = 512
    ds.Columns = 512
    ds.BitsAllocated = 8
    ds.ICCProfile = b"\x00" * 16384
    return ds


def build_pixels_nowindow():
    """A small uncompressed MONOCHROME2 image carrying pixel data but no VOI window.
    dcmj2pnm's --use-window 1 fails on it ("0 window(s) in file"), so it exercises
    the compat dcm_to_jpg/dcm_to_tn min-max fallback. Being uncompressed, it also
    serves as the source for the compress() shim test."""
    sop_instance = generate_uid()
    fm = FileMetaDataset()
    fm.MediaStorageSOPClassUID = SC_SOP_CLASS
    fm.MediaStorageSOPInstanceUID = sop_instance
    fm.TransferSyntaxUID = ExplicitVRLittleEndian
    fm.ImplementationClassUID = generate_uid()

    ds = Dataset()
    ds.file_meta = fm
    ds.SOPClassUID = SC_SOP_CLASS
    ds.SOPInstanceUID = sop_instance
    ds.PatientName = "Pixels^NoWindow"
    ds.PatientID = "PIX1"
    ds.Modality = "OT"
    ds.Rows = 64
    ds.Columns = 64
    ds.SamplesPerPixel = 1
    ds.PhotometricInterpretation = "MONOCHROME2"
    ds.BitsAllocated = 8
    ds.BitsStored = 8
    ds.HighBit = 7
    ds.PixelRepresentation = 0
    # Horizontal gradient; deliberately no WindowCenter/WindowWidth.
    ds.PixelData = bytes((column * 4) & 0xFF for _ in range(64) for column in range(64))
    return ds


def build_multiframe():
    """An 8-frame uncompressed MONOCHROME2 image with a VOI window, the source for
    the Convert::toVideo and compat multiframe_to_video tests. Each frame is a
    horizontal gradient brightened by its index, so the frames differ visibly. The
    WindowCenter/WindowWidth let --use-window 1 (toJpegFrames' default) succeed."""
    frames = 8
    sop_instance = generate_uid()
    fm = FileMetaDataset()
    fm.MediaStorageSOPClassUID = SC_SOP_CLASS
    fm.MediaStorageSOPInstanceUID = sop_instance
    fm.TransferSyntaxUID = ExplicitVRLittleEndian
    fm.ImplementationClassUID = generate_uid()

    ds = Dataset()
    ds.file_meta = fm
    ds.SOPClassUID = SC_SOP_CLASS
    ds.SOPInstanceUID = sop_instance
    ds.PatientName = "Multi^Frame"
    ds.PatientID = "MFV1"
    ds.Modality = "OT"
    ds.NumberOfFrames = frames
    ds.Rows = 64
    ds.Columns = 64
    ds.SamplesPerPixel = 1
    ds.PhotometricInterpretation = "MONOCHROME2"
    ds.BitsAllocated = 8
    ds.BitsStored = 8
    ds.HighBit = 7
    ds.PixelRepresentation = 0
    ds.WindowCenter = 128
    ds.WindowWidth = 255
    pixels = bytearray()
    for frame in range(frames):
        base = frame * 24
        for _ in range(64):
            for column in range(64):
                pixels.append((base + column * 3) & 0xFF)
    ds.PixelData = bytes(pixels)
    return ds


def main():
    FIXTURES.mkdir(exist_ok=True)
    for name, ts in CASES.items():
        ds = build(ts)
        dcmwrite(FIXTURES / name, ds, enforce_file_format=True)
        print(f"wrote {name}  ->  {ts} ({ts.name})")

    dcmwrite(FIXTURES / "tags_sample.dcm", build_tags_sample(), enforce_file_format=True)
    print("wrote tags_sample.dcm")

    dcmwrite(FIXTURES / "pixels_nowindow.dcm", build_pixels_nowindow(), enforce_file_format=True)
    print("wrote pixels_nowindow.dcm")

    dcmwrite(FIXTURES / "multiframe.dcm", build_multiframe(), enforce_file_format=True)
    print("wrote multiframe.dcm")

    # A deliberately non-DICOM file (no preamble/DICM) for the false/throw paths.
    (FIXTURES / "not_dicom.bin").write_bytes(b"this is not a DICOM file\n" * 8)
    print("wrote not_dicom.bin")
    # A too-short file (fewer than 132 bytes) for the short-read path.
    (FIXTURES / "too_short.bin").write_bytes(b"DICM")
    print("wrote too_short.bin")


if __name__ == "__main__":
    main()
