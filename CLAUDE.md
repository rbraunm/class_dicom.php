# CLAUDE.md

Guidance for AI agents working in this repository. **Read `CONTRIBUTING.md` first** --
it is the canonical guide for conventions, the dev/test environment, and CI. The
points below are the ones that must not be missed.

## Where things live

- Conventions, testing standards, dev/test environment, CI: `CONTRIBUTING.md`.
- Tooling reference (provision, `ct_exec`, research harness): `tools/README.md`.
- Roadmap: `ROADMAP.md`.

## Working norms

- **Dead code vs. interface surface.** "No dead code" targets unreachable or
  speculative-within-project paths, not public API lacking an in-repo caller -- the
  library's deliverable is its interface, so intended methods, parameters, exceptions,
  and return shapes are legitimate with no internal caller. Detail in `CONTRIBUTING.md`
  (Coding conventions).
- Work on a branch; reach `main` only by pull request. One commit per logical checkpoint.
- Run the suite in the pinned toolchain: `composer install && vendor/bin/phpunit`.

## Toolchain setup in a sandboxed agent environment

Setup for an LLM agent working in a sandbox -- e.g. Claude's code-execution
sandbox: Ubuntu, no container runtime, allowlisted egress. This is independent of
the human-developer paths in `CONTRIBUTING.md` (the CI image and the Proxmox LXC):
an agent has no container runtime, so it installs the toolchain directly. Egress
hosts to whitelist are in `CONTRIBUTING.md` (Agent sandbox).

The target is PHP 8.5 and the
stable DCMTK the distribution ships -- in this sandbox that is Ubuntu's `dcmtk`,
which can differ from the pinned CI image. CI stays the authority for a green
suite; the sandbox is for development iteration.

Run as root on Ubuntu:

```bash
# 0. Sandbox image quirk: a stray nodesource apt source ships in the base image
#    and is not on the egress allowlist, so `apt-get update` fails closed with a
#    403 before it reaches our repos. Disable it if present (idempotent).
if [ -f /etc/apt/sources.list.d/nodesource.sources ]; then
  mv /etc/apt/sources.list.d/nodesource.sources /etc/apt/sources.list.d/nodesource.sources.disabled
fi

# 1. PHP 8.5 + extensions -- signing key fetched over HTTPS from the keyserver
KEYID=14AA40EC0831756756D7F66C4F4EA0AAE5267A6C
install -d -m 0755 /usr/share/keyrings
curl -fsSL "https://keyserver.ubuntu.com/pks/lookup?op=get&options=mr&search=0x${KEYID}" \
  | gpg --dearmor -o /usr/share/keyrings/ondrejPHP.gpg
. /etc/os-release   # provides VERSION_CODENAME (e.g. noble)
echo "deb [signed-by=/usr/share/keyrings/ondrejPHP.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu ${VERSION_CODENAME} main" \
  > /etc/apt/sources.list.d/ondrejPHP.list
apt-get update
apt-get install -y --no-install-recommends \
  php8.5-cli php8.5-mbstring php8.5-xml php8.5-curl php8.5-zip

# 2. DCMTK + base tools (Ubuntu archive)
apt-get install -y --no-install-recommends \
  dcmtk ca-certificates curl gnupg unzip git python3 python3-venv

# 3. Python test oracle (pydicom/pynetdicom)
python3 -m venv /opt/dicom-oracle
/opt/dicom-oracle/bin/pip install --upgrade pip
/opt/dicom-oracle/bin/pip install pydicom pynetdicom

# 4. Composer -- HTTPS installer, sha384-verified against the published signature
php8.5 -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');"
EXPECTED=$(curl -fsSL https://composer.github.io/installer.sig)
ACTUAL=$(php8.5 -r "echo hash_file('sha384', '/tmp/composer-setup.php');")
[ "$EXPECTED" = "$ACTUAL" ] || { echo "Composer installer checksum mismatch" >&2; exit 1; }
php8.5 /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer --quiet
rm -f /tmp/composer-setup.php
```

Then run the suite: `composer install && vendor/bin/phpunit`.
