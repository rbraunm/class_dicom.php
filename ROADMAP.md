# Roadmap

The line beyond the current release grows the wrapper to cover more of the DCMTK
toolset, focused on the operations that matter in a PHP web application receiving,
routing, and serving DICOM images. The goal is not full pydicom/pynetdicom parity.
Each item is another DCMTK tool wrapped under the same discipline as the current
release.

## DICOM networking

- **C-FIND (query).** Query a remote PACS for studies, series, or instances by
  patient name, date range, modality, accession number, or study UID (`findscu`).
  The single most-requested DICOM network feature for web applications.
- **C-MOVE / C-GET (retrieve).** Trigger a PACS to send images to a specified AE
  title, or pull them directly (`movescu` / `getscu`).
- **Association negotiation control.** Expose transfer-syntax and abstract-syntax
  negotiation so callers can control what gets proposed and accepted.
- **TLS support.** DICOM TLS for C-STORE and C-FIND, since many hospital networks
  now require encrypted DICOM traffic.

## Image handling

- **Pixel-data access.** Decode pixel data into a PHP array or GD/Imagick resource
  for server-side processing without converting to JPEG first, including windowing
  and level adjustment.
- **JPEG 2000 support.** JPEG 2000 lossless and lossy (transfer syntaxes
  1.2.840.10008.1.2.4.90 and .91), where the DCMTK build provides it.
- **Multi-frame handling.** Extract individual frames as images without converting
  the whole stack to video. Frame-level access is essential for ultrasound and
  fluoroscopy workflows.

## Metadata and conformance

- **DICOMDIR support.** Read and write DICOMDIR files for media interchange
  (CD/DVD, portable media).
- **Structured report reading.** Parse SR documents (radiologist reports, CAD
  results) into a traversable PHP structure.
- **UID generation.** Generate conformant DICOM UIDs with a registered root, so
  files the library creates are traceable and do not collide.
- **Conformance statement.** Document which SOP classes, transfer syntaxes, and
  DIMSE services the library supports, in the format PACS administrators expect.
