# Contributing

This is an Apache-2.0 PHP DICOM library that wraps the DCMTK command-line tools.
This document is the working guide for everyone (human or agent) touching the
code: the conventions, how to run the suite, and how CI gates changes.

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
- **No dead code -- but the interface is the deliverable.** Dead code means a path
  that can never execute, or one added speculatively within the project; refactor
  those out fully rather than commenting them or keeping them "just in case." It does
  *not* mean public interface surface with no in-repo caller. This library's product
  is the interface consuming applications link against, so intended public methods,
  parameters, exceptions, and return shapes are legitimate even when nothing internal
  calls them yet -- that surface is settled in the talk-first design pass, which makes
  it intended rather than speculative. Reserve deletion for unreachable or
  speculative-within-project paths. (No external consumers exist to preserve backward
  compatibility for until v2 ships, so superseded *internal* paths still go
  immediately.)
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

### Agent sandbox (allowlisted egress)

An LLM agent without a container runtime installs the toolchain directly rather
than using the image or LXC above -- see `CLAUDE.md`, "Toolchain setup in a
sandboxed agent environment". If the sandbox restricts outbound traffic to an
allowlist, every host that setup and the test run touch must be whitelisted, or
the install fails closed (`host_not_allowed`):

| Host | Used for |
|------|----------|
| `keyserver.ubuntu.com` | PHP signing key (HTTPS) |
| `ppa.launchpadcontent.net` | PHP 8.5 + extensions (ondrej PPA) |
| `archive.ubuntu.com`, `security.ubuntu.com` | DCMTK, Python, base packages |
| `pypi.org`, `files.pythonhosted.org` | pydicom / pynetdicom (pip) |
| `getcomposer.org` | Composer installer |
| `composer.github.io` | Composer installer signature |
| `repo.packagist.org`, `packagist.org` | `composer install` (PHPUnit, psr/log) |
| `github.com`, `codeload.github.com`, `api.github.com` | Composer dist downloads, git |

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

## Logging and PHI

DICOM file paths and tool output can contain PHI, so the library is deliberate
about what it emits:

- The optional PSR-3 logger (injected into `Toolkit`) records each completed
  invocation at debug level with only the tool, exit code, and duration -- never
  the arguments, which are file paths.
- The library logs nothing on its own; logging is opt-in via that logger.

Exception messages are the one place this does not hold: to stay useful for
debugging, they include the file path and, in some cases, the underlying tool's
stderr. The library never logs these itself, but a consumer that does
`log($exception)` will write whatever the message contains. If you handle PHI,
account for that in your own logging -- scrub, or log exception types and codes
rather than raw messages.

(When the README is rewritten for v2, this note belongs there too, for consumers.)

## Branch workflow

Development happens on a working branch (agent sessions use `claude`); changes reach
`main` by pull request only. Never push directly to `main`. One commit per logical
checkpoint, not per file edit.
