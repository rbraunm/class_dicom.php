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
- `docker/` -- **CI consumption.** A Dockerfile that runs `provision.sh`, published
  to GHCR so GitHub Actions pulls the prebuilt image instead of reinstalling per run.

## Key handling

Any SSH key the LXC provisioner generates is written to a `keys/` directory that is
git-ignored by default (see the repo `.gitignore`). The private key never enters the
repo; only the public key is installed into the container's `authorized_keys`.
