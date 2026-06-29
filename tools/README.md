# tools/

Project tooling that is **not** part of the shipped library. Everything here is
development, test, and CI support and is excluded from the Packagist distribution
via `.gitattributes` `export-ignore` (so it never lands in a consumer's `vendor/`).

Organized by use case.

## `devenv/` -- development, test, and CI environment

A single toolchain definition (PHP 8.5 + DCMTK + Python with pydicom/pynetdicom +
Composer) shared by every context that runs the test suite or the Phase 0.5
research harness. The point is that local development, CI, and research all run the
**same pinned DCMTK**: drift between environments is dangerous for a DCMTK wrapper,
where behavior and the CVE surface vary by version, so the dependency set lives in
exactly one place.

- `provision.sh` -- the shared, idempotent install steps (the toolchain itself).
  Both the LXC and the Docker image call this, so the dependency set is defined once.
- `lxc/provision_lxc.py` -- **home consumption.** A Python provisioner (paramiko) that drives a
  Proxmox node over SSH (`--host root@labradorite --name <gemstone>`), creates an unprivileged
  LXC, clones the repo, runs `provision.sh` from the clone, runs `composer install`, and enables a
  key-based login. The ed25519 keypair is generated into `lxc/keys/` (git-ignored); only the public
  half is installed in the container. Needs `paramiko` where you run it (`pip install paramiko`).
- `lxc/ct_exec.py` -- run a single command on a provisioned container over SSH using the
  generated key (no password). Reads the address/user from the login file `provision_lxc.py`
  leaves in `lxc/keys/` (`<name>-ssh.txt`), so `python tools/devenv/lxc/ct_exec.py -- nproc`
  just works once a container exists. Combined output streams live; it exits with the remote
  command's status, so it composes in scripts.
- `docker/` -- **CI consumption.** A Dockerfile that runs `provision.sh`, published
  to GHCR so GitHub Actions pulls the prebuilt image instead of reinstalling per run.

## `research/` -- DCMTK blackbox helpers

Tooling for observing what DCMTK actually does, used while building and verifying the wrappers.
Run in the dev container (via `devenv/lxc/ct_exec.py`).

- `makeToolShims.sh` -- installs logging wrappers in `/usr/local/bin`
  for every DCMTK binary (`dpkg -L dcmtk`) plus `ffmpeg`; each records `tool + argv` to a log, then
  exec's the real tool, so you can see which tool each operation actually calls.
- `makeMultiframeFixture.py` -- synthesizes a small multi-frame DICOM (pydicom only) so
  `multiframe_to_video` can be exercised far enough to capture its DCMTK + `ffmpeg` invocation.

## Key handling

Any SSH key the LXC provisioner generates is written to a `keys/` directory that is
git-ignored by default (see the repo `.gitignore`). The private key never enters the
repo; only the public key is installed into the container's `authorized_keys`.
