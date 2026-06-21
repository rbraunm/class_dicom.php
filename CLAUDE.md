# CLAUDE.md

Guidance for AI agents working in this repository. **Read `CONTRIBUTING.md` first** --
it is the canonical guide for conventions, the dev/test environment, and CI. The
points below are the ones that must not be missed.

## Critical: clean-room rule

This is a clean-room, Apache-2.0 v2 rewrite. Never open, read, or reference the
legacy `class_dicom.php` source. Implement only from the DICOM standard (NEMA PS3),
the DCMTK documentation, and the published v1 surface (README, `examples/`,
`docs/v1-surface.json`). Reflection and black-box behavioral observation are
allowed; reading the legacy source is not.

## Where things live

- Conventions, testing standards, dev/test environment, CI: `CONTRIBUTING.md`.
- Tooling reference (provision, `ct_exec`, research harness): `tools/README.md`.
- Plan and phase status: `docs/v2-rewrite-plan.md`, `ROADMAP.md`.

## Working norms

- **Dead code vs. interface surface.** "No dead code" targets unreachable or
  speculative-within-project paths, not public API lacking an in-repo caller -- the
  library's deliverable is its interface, so intended methods, parameters, exceptions,
  and return shapes are legitimate with no internal caller. Detail in `CONTRIBUTING.md`
  (Coding conventions).
- Work on a branch; reach `main` only by pull request. One commit per logical checkpoint.
- Run the suite in the pinned toolchain: `composer install && vendor/bin/phpunit`.
