# Contributing

This is a clean-room, Apache-2.0 v2 rewrite of a PHP DICOM library that wraps the
DCMTK command-line tools. This document is the working guide for everyone (human
or agent) touching the code: how to source an implementation, the conventions, how
to run the suite, and how CI gates changes.

## Clean-room rule (v2)

The legacy `class_dicom.php` is not opened, read, or referenced while writing v2
code. Implement only from the DICOM standard (NEMA PS3), the DCMTK documentation,
and the published v1 surface (README and `examples/`). The standard is the source
of truth. Interface facts (names, signatures, observable behavior) are reusable;
expression (bodies, structure, comments) is not. Reflection and black-box
behavioral observation are permitted; reading the legacy source is not. See
`docs/v2-rewrite-plan.md` and the frozen `docs/v1-surface.json`.

## Source file headers

Every PHP source file under `src/` begins with this header:

```php
<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);
```

`declare(strict_types=1)` is mandatory: type juggling is a silent-failure source,
and this library fails loud.

## Coding conventions

- **PHP 8.5**, PSR-4 autoloading (`composer.json` maps the `DICOM\`, `PACS\`, and
  `DCMTK\` namespaces under `src/`).
- **Indentation.** 4-space, PSR-12.
- **ASCII only** in code and comments. No em-dashes, curly quotes, or other
  non-ASCII characters.
- **Fail loud, no silent fallbacks.** Do not add speculative fallback paths or
  defensive branches that mask a failure. If the primary approach fails, surface
  the error. (Error handling and retries for known transient failures are expected;
  a second strategy that silently takes over is not.) Validate invalid state at the
  earliest boundary -- ideally at construction, not at use.
- **No dead code.** Refactor fully and delete superseded paths; do not comment them
  out or keep them "just in case." There are no external consumers to preserve
  backward compatibility for until v2 ships.
- **Derive, don't duplicate.** Compute values from the canonical data at the call
  site rather than storing or transmitting derived state.

## Testing

- Tests exercise the **real** code path. Do not monkeypatch the unit under test.
  Doubling an infrastructure boundary (network, filesystem) is fine; replacing the
  logic you are verifying is not.
- Behavior is validated **independently** of the implementation. `pydicom` /
  `pynetdicom` act as the oracle for DICOM round-trips -- the test confirms the
  wrapper agrees with an independent reader, not with itself.
- Assertions are specific (exact values and structure, not `>= 0`-style checks),
  test names match what they assert, and there are no empty or stub tests that
  inflate the pass count.
- Run the suite: `composer install && vendor/bin/phpunit`.

## Development and test environment

A DCMTK wrapper is sensitive to the DCMTK version (behavior and CVE surface vary by
release), so local development, CI, and research all run the **same pinned
toolchain**, defined once in `tools/devenv/provision.sh` (PHP 8.5 + DCMTK + a
Python venv with `pydicom`/`pynetdicom` + Composer). Two ways to get a
suite-running environment:

- **Container image (what CI uses).** The devenv image is `provision.sh` baked onto
  Debian, published to GHCR by `publishDevenvImage.yaml`. Pull it and run the suite
  inside it.
- **Local LXC.** `tools/devenv/lxc/provision_lxc.py` provisions an unprivileged
  Proxmox LXC from the same script. Run a single command inside a provisioned
  container over SSH (key-based, no password) with:

  ```
  python tools/devenv/lxc/ct_exec.py --name <container> -- "<command>"
  ```

  e.g. `python tools/devenv/lxc/ct_exec.py --name <container> -- "cd <repo> && composer install && vendor/bin/phpunit"`.
  `ct_exec.py` streams combined output and exits with the remote command's status,
  so it composes in scripts.

See `tools/README.md` for the full tooling reference.

## Continuous integration

Two path-filtered GitHub Actions workflows, each also runnable on demand
(`workflow_dispatch`):

- **`publishDevenvImage.yaml`** triggers on toolchain changes (`provision.sh`, the
  Dockerfile, the workflow). It builds and pushes the devenv image to GHCR, then
  runs the full suite against the freshly built image, so a toolchain change is
  validated rather than trusted blind.
- **`validateAndLint.yaml`** triggers on code changes (`src/`, `tests/`,
  `composer.json`/`composer.lock`, `phpunit.xml`, the workflow). It pulls the
  published image and runs `composer validate`, `php -l`, and `phpunit`. This is the
  per-change gate.

The devenv image is public, so pulls are anonymous; pushing it stays authenticated
and authorized. Steady state is automatic: a code push tests against the published
toolchain, and a toolchain push rebuilds and re-tests.

## Branch workflow

Development happens on a working branch (agent sessions use `claude`); changes reach
`main` by pull request only. Never push directly to `main`. One commit per logical
checkpoint, not per file edit.
