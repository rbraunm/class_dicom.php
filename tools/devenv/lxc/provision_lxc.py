#!/usr/bin/env python3
# SPDX-License-Identifier: Apache-2.0
# Copyright (c) 2026 Randy Braunm

"""Provision a Proxmox LXC with the class_dicom.php dev/test/CI toolchain.

Run this from anywhere; it drives a Proxmox node over SSH (--host root@<node>, required) and
never runs against a local node. SSH is spoken by a pure-Python client (paramiko), not by
shelling out to ssh(1): the node password is prompted once via getpass and held only in memory
for the handshake -- it never reaches a command line, file, or log. One authenticated
connection is opened and reused for every command.

Host-key trust is deliberately permissive: an unknown node key is auto-accepted (and cached in
the local known_hosts) rather than rejected. This is a trusted-LAN provisioning tool, so the
convenience is worth the narrow first-connect MITM window; on a hostile network, pre-seed the
node's key in known_hosts before running.

It creates an unprivileged Debian LXC, clones the repo, runs the shared toolchain installer
(tools/devenv/provision.sh: PHP 8.5, Debian's DCMTK, a python venv with pydicom/pynetdicom, and
Composer), runs composer install, and enables key-based SSH for a dedicated login. The toolchain
lives in provision.sh so the same definition backs this LXC and the CI image.

An ed25519 keypair is generated locally into ./keys (git-ignored) and only the public half is
installed into the container. The toolchain installer is run from the clone, so the container is
also a checkout you can run the test suite and the call-map harness in.

    python tools/devenv/lxc/provision_lxc.py --host root@labradorite --name <gemstone>

Re-running on an existing CTID refuses unless --recreate is given (no silent clobber).
"""
from __future__ import annotations

import argparse
import getpass
import os
import re
import shlex
import sys
from collections import namedtuple

try:
    import paramiko
    # cryptography is paramiko's own dependency, so it's present whenever paramiko imported;
    # it generates the ed25519 access key in pure Python (no ssh-keygen on PATH).
    from cryptography.hazmat.primitives import serialization
    from cryptography.hazmat.primitives.asymmetric import ed25519
except ImportError:
    sys.exit(
        "provision_lxc needs paramiko (the pure-Python SSH client).\n"
        "Install it from an admin prompt: pip install paramiko"
    )

DEFAULT_REPO = "https://github.com/rbraunm/class_dicom.php.git"
DEFAULT_BRANCH = "main"   # public default; pass --branch claude for unmerged dev work
DEFAULT_TEMPLATE = "debian-13-standard"   # appliance prefix; the exact dist file is resolved from `pveam available`
BASE = "/opt/class_dicom"   # in-container install root

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
KEY_DIR = os.path.join(SCRIPT_DIR, "keys")

# A single DNS label: what avahi can advertise as <name>.local, and all the mDNS step's
# sed/grep can treat as a literal. Reject anything else up front instead of letting a stray
# '/' or '.' break the sed or fool the grep -x verify.
HOSTNAME_LABEL = re.compile(r"^[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?$")

SSH_TARGET = ""    # the user@host spec, kept for display in messages
_CLIENT = None     # the single authenticated paramiko connection, opened in connect()

Result = namedtuple("Result", "returncode stdout stderr")


def connect(host_spec: str) -> "paramiko.SSHClient":
    """Open the one SSH connection every command reuses. Password is prompted here and held
    only in memory for the handshake -- never echoed, written, or logged."""
    user, sep, hostpart = host_spec.partition("@")
    if not sep or not hostpart:
        sys.exit(f"--host must be user@host (e.g. root@labradorite), got {host_spec!r}.")
    host, _, port_s = hostpart.partition(":")
    try:
        port = int(port_s) if port_s else 22
    except ValueError:
        sys.exit(f"bad port in --host {host_spec!r}.")
    password = getpass.getpass(f"Password for {host_spec}: ")
    client = paramiko.SSHClient()
    client.load_system_host_keys()
    # Trusted-LAN tool: auto-accept an unknown node key rather than reject it (see module docstring).
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        client.connect(host, port=port, username=user, password=password,
                       look_for_keys=False, allow_agent=False)
    except paramiko.AuthenticationException:
        sys.exit(f"authentication failed for {host_spec} (wrong password?).")
    except (paramiko.SSHException, OSError) as e:
        sys.exit(f"cannot reach {host_spec} over SSH: {e}")
    finally:
        del password
    return client


def run(cmd: str) -> None:
    """Run a Proxmox-host command over the shared connection, streaming output live; exit on
    nonzero status (no silent fallbacks)."""
    print(f"$ {cmd}")
    chan = _CLIENT.get_transport().open_session()
    chan.set_combine_stderr(True)
    chan.exec_command(cmd)
    stdout = chan.makefile("r")
    for line in iter(stdout.readline, ""):
        sys.stdout.write(line)
        sys.stdout.flush()
    rc = chan.recv_exit_status()
    if rc != 0:
        sys.exit(f"command failed (exit {rc}) on {SSH_TARGET}: {cmd}")


def capture(cmd: str) -> Result:
    """Run a command over the shared connection and return its full output, no echo."""
    chan = _CLIENT.get_transport().open_session()
    chan.exec_command(cmd)
    out = chan.makefile("rb").read().decode(errors="replace")
    err = chan.makefile_stderr("rb").read().decode(errors="replace")
    rc = chan.recv_exit_status()
    return Result(rc, out, err)


def container_exists(ctid: int) -> bool:
    return capture(f"pct status {ctid}").returncode == 0


def exec_in(ctid: int, script: str) -> None:
    """Run a bash script inside the container, fail-loud (set -euo pipefail)."""
    body = "set -euo pipefail\n" + script
    run(f"pct exec {ctid} -- bash -lc {shlex.quote(body)}")


def preflight() -> None:
    # connect() already proved we can authenticate; confirm we landed as root on a Proxmox node.
    if capture("id -u").stdout.strip() != "0":
        sys.exit(f"remote user on {SSH_TARGET} is not root (pct/pveam need root).")
    if capture("command -v pct pveam").returncode != 0:
        sys.exit(f"{SSH_TARGET} is missing pct/pveam -- is it a Proxmox node?")


def _template_files(listing: str) -> list:
    # Pull the *.tar.* dist filenames out of `pveam list` or `pveam available` output,
    # stripping any `storage:vztmpl/` path so both formats normalize to a bare filename.
    files = []
    for line in listing.splitlines():
        for field in line.split():
            if field.endswith((".tar.zst", ".tar.gz", ".tar.xz")):
                files.append(field.split("/")[-1])
    return files


def _resolve_template(files: list, wanted: str, where: str) -> str:
    # An exact filename wins; otherwise treat `wanted` as a release prefix and require it
    # to match exactly one dist file. Zero matches -> "" (caller decides). More than one ->
    # fail loud rather than guess which version is newest.
    if wanted in files:
        return wanted
    matches = sorted(f for f in files if f.startswith(wanted))
    if len(matches) == 1:
        return matches[0]
    if not matches:
        return ""
    sys.exit(f"Template '{wanted}' is ambiguous {where} -- matches {matches}. Pass an exact --template.")


def ensure_template(template: str, template_storage: str) -> str:
    print(f"[1/7] Ensuring a '{template}' template is cached on {template_storage}...")
    cached = _resolve_template(
        _template_files(capture(f"pveam list {template_storage}").stdout),
        template, f"in {template_storage}",
    )
    if cached:
        print(f"  already cached: {cached}")
        return cached
    run("pveam update")
    available = _template_files(capture("pveam available --section system").stdout)
    chosen = _resolve_template(available, template, "in the pveam index")
    if not chosen:
        debian = [f for f in available if "debian" in f]
        sys.exit(
            f"No template matching '{template}' in the pveam index. "
            f"Available debian system templates: {debian or '(none)'}."
        )
    run(f"pveam download {template_storage} {chosen}")
    return chosen


def create_container(args) -> None:
    print(f"[2/7] Creating LXC {args.ctid} ({args.name})...")
    if container_exists(args.ctid):
        if not args.recreate:
            sys.exit(
                f"Container {args.ctid} already exists. Pass --recreate to destroy and rebuild "
                f"it, or choose another --ctid."
            )
        print(f"  --recreate: stopping and destroying existing {args.ctid}...")
        if "status: running" in capture(f"pct status {args.ctid}").stdout:
            run(f"pct stop {args.ctid}")
        run(f"pct destroy {args.ctid}")

    if args.ip != "dhcp" and not args.gateway:
        sys.exit("A static --ip needs --gateway (the container would have no default route).")
    rootfs = f"{args.rootfs_storage}:{args.rootfs_size}"
    net = f"name=eth0,bridge={args.bridge},ip={args.ip}"
    if args.ip != "dhcp":
        net += f",gw={args.gateway}"
    if args.vlan:
        net += f",tag={args.vlan}"
    dns = ""
    if args.nameserver:
        dns += f" --nameserver {shlex.quote(args.nameserver)}"
    if args.searchdomain:
        dns += f" --searchdomain {shlex.quote(args.searchdomain)}"
    run(
        f"pct create {args.ctid} {args.template_storage}:vztmpl/{args.template} "
        f"--hostname {shlex.quote(args.name)} "
        f"--cores {args.cores} --memory {args.memory} --swap {args.swap} "
        f"--rootfs {rootfs} --net0 {shlex.quote(net)}{dns} "
        f"--unprivileged 1 --features nesting=1 --onboot 0 --tags {shlex.quote(args.tags)} --start 1"
    )


def wait_for_network(ctid: int) -> None:
    print("[3/7] Waiting for container network...")
    exec_in(ctid, 'for i in $(seq 1 30); do '
                  'getent hosts github.com >/dev/null 2>&1 && exit 0; sleep 2; done; '
                  'echo "no network in container after 60s" >&2; exit 1')


def install_toolchain(ctid: int, args) -> None:
    print(f"[4/7] Cloning {args.repo} ({args.branch}) and running the toolchain installer...")
    exec_in(ctid,
            "export DEBIAN_FRONTEND=noninteractive LANG=C.UTF-8\n"
            "apt-get update -qq\n"
            "apt-get install -y -qq git ca-certificates\n"
            f"rm -rf {BASE}\n"
            f"git clone --depth 1 --branch {shlex.quote(args.branch)} "
            f"{shlex.quote(args.repo)} {BASE}/src\n"
            f"bash {BASE}/src/tools/devenv/provision.sh\n"
            "export COMPOSER_ALLOW_SUPERUSER=1\n"
            f"cd {BASE}/src && composer install --no-interaction --no-progress")
    verify_install(ctid)


def verify_install(ctid: int) -> None:
    """Assert step 4's postcondition rather than trusting the install's exit alone: the toolchain
    is present and composer produced a runnable PHPUnit."""
    print("  verifying the install (toolchain present + composer deps installed)...")
    exec_in(ctid,
            "command -v dcmdump composer >/dev/null\n"
            f"test -d {BASE}/src/vendor\n"
            f"{BASE}/src/vendor/bin/phpunit --version\n"
            "echo 'install verified: dcmtk, composer, and phpunit are present'")


def ensure_local_key(args) -> str:
    """Generate the ed25519 access keypair locally into KEY_DIR (git-ignored) if absent; return
    the private-key path. Pure-Python via cryptography (paramiko's own dependency) -- no ssh-keygen
    on PATH -- so the keygen matches the connection: both are paramiko's stack, not ssh(1)'s. Only
    the public half is ever sent to the container."""
    os.makedirs(KEY_DIR, exist_ok=True)
    key = os.path.join(KEY_DIR, f"{args.name}_ed25519")
    if not os.path.exists(key):
        private = ed25519.Ed25519PrivateKey.generate()
        priv_pem = private.private_bytes(
            encoding=serialization.Encoding.PEM,
            format=serialization.PrivateFormat.OpenSSH,
            encryption_algorithm=serialization.NoEncryption(),
        )
        pub_line = private.public_key().public_bytes(
            encoding=serialization.Encoding.OpenSSH,
            format=serialization.PublicFormat.OpenSSH,
        ) + f" class-dicom@{args.name}\n".encode()
        # Create the private key 0600 from the start (O_CREAT mode) so the secret is never briefly
        # world-readable -- the window ssh-keygen also closes.
        fd = os.open(key, os.O_WRONLY | os.O_CREAT | os.O_EXCL, 0o600)
        with os.fdopen(fd, "wb") as f:
            f.write(priv_pem)
        with open(key + ".pub", "wb") as f:
            f.write(pub_line)
    return key


def setup_ssh(ctid: int, args, key: str) -> None:
    print(f"[5/7] Enabling sshd and the key-based {args.ssh_user!r} login...")
    user = shlex.quote(args.ssh_user)
    home = f"/home/{args.ssh_user}"
    with open(key + ".pub") as f:
        pub = f.read().strip()
    exec_in(ctid,
            "export DEBIAN_FRONTEND=noninteractive LANG=C.UTF-8\n"
            "apt-get install -y -qq openssh-server sudo\n"
            f"id -u {user} >/dev/null 2>&1 || useradd --create-home --shell /bin/bash {user}\n"
            f"chown -R {user}:{user} {BASE}\n"   # the login owns its tools: run, pull, write caches
            f"install -d -m 0700 -o {user} -g {user} {home}/.ssh\n"
            f"printf '%s\\n' {shlex.quote(pub)} > {home}/.ssh/authorized_keys\n"
            f"chown {user}:{user} {home}/.ssh/authorized_keys\n"
            f"chmod 600 {home}/.ssh/authorized_keys\n"
            # Passwordless sudo for the dev login: this is a disposable dev/test box, and ct_exec
            # logs in as this unprivileged user, which still needs root for apt and /usr/local/bin.
            "install -d -m 0755 /etc/sudoers.d\n"
            f"printf '%s ALL=(ALL) NOPASSWD:ALL\\n' {user} > /etc/sudoers.d/10-devuser\n"
            "chmod 0440 /etc/sudoers.d/10-devuser\n"
            "visudo -cf /etc/sudoers.d/10-devuser\n"   # reject a malformed drop-in loudly
            "install -d -m 0755 /etc/ssh/sshd_config.d\n"
            "printf 'PubkeyAuthentication yes\\nPasswordAuthentication no\\n'"
            " > /etc/ssh/sshd_config.d/10-class-dicom.conf\n"
            "systemctl enable --now ssh\n"
            "systemctl restart ssh\n"
            # assert the postcondition: the unit is active and key auth is effective
            "systemctl is-active --quiet ssh\n"
            "sshd -T 2>/dev/null | grep -i '^pubkeyauthentication yes'\n"
            f"runuser -u {user} -- sudo -n true\n"   # assert NOPASSWD sudo is effective
            "echo 'verified: sshd active with key auth, dev user has passwordless sudo'\n")


def setup_mdns(ctid: int, mdns_name: str) -> None:
    print(f"[6/7] Advertising {mdns_name}.local over mDNS (Avahi)...")
    exec_in(ctid,
            "export DEBIAN_FRONTEND=noninteractive LANG=C.UTF-8\n"
            "apt-get install -y -qq avahi-daemon libnss-mdns\n"
            f"sed -ri 's/^#?host-name=.*/host-name={mdns_name}/' /etc/avahi/avahi-daemon.conf\n"
            "systemctl enable --now avahi-daemon\n"
            "systemctl restart avahi-daemon\n"
            "systemctl is-active --quiet avahi-daemon\n"
            f"grep -x 'host-name={mdns_name}' /etc/avahi/avahi-daemon.conf\n"
            "echo 'verified: avahi-daemon is active and advertising the host-name above'\n")


def container_ip(ctid: int) -> str:
    parts = capture(f"pct exec {ctid} -- hostname -I").stdout.strip().split()
    return parts[0] if parts else ""


def write_credentials(args, ip: str, key: str, mdns_name: str) -> str:
    """Leave a 'key: value' login file beside the keypair so ct_exec.py can reach the container
    with no flags. Address prefers the IP and falls back to the mDNS name. No secret lives here --
    the private key stays in its own 0600 file; this only records where and who to log in as."""
    address = ip or (f"{mdns_name}.local" if mdns_name else "")
    path = os.path.join(KEY_DIR, f"{args.name}-ssh.txt")
    body = "\n".join((
        f"name: {args.name}",
        f"ctid: {args.ctid}",
        f"node: {SSH_TARGET}",
        f"address: {address or '(unknown -- pass --host to ct_exec.py)'}",
        f"user: {args.ssh_user}",
        f"key: {os.path.basename(key)}",
    )) + "\n"
    with open(path, "w") as f:
        f.write(body)
    return path


def report(args, ip: str, key: str, mdns_name: str, creds: str) -> None:
    target = ip or (f"{mdns_name}.local" if mdns_name else "<container-ip>")
    print("\n[7/7] Done.")
    print(f"  CT {args.ctid} ({args.name}) is up{(' at ' + ip) if ip else ''} on {SSH_TARGET}.")
    print(f"  Repo at {BASE}/src; toolchain installed via tools/devenv/provision.sh.")
    print(f"  Key-based login '{args.ssh_user}' enabled; private key (git-ignored):")
    print(f"    {key}")
    if mdns_name:
        print(f"  Advertised over mDNS as {mdns_name}.local (link-local; needs an mDNS reflector to cross VLANs).")
    print(f"\n  Connect:  ssh -i {key} {args.ssh_user}@{target}")
    print(f"  Run a command:  python {os.path.join('tools', 'devenv', 'lxc', 'ct_exec.py')} --name {args.name} -- dcmdump --version")
    print(f"  Run the suite:  cd {BASE}/src && vendor/bin/phpunit")
    print(f"  Update later:   git -C {BASE}/src pull")
    print(f"  (login file for ct_exec.py: {creds})")


def main() -> None:
    parser = argparse.ArgumentParser(
        description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter
    )
    parser.add_argument("--host", required=True,
                        help="Proxmox node to drive over SSH (e.g. root@labradorite)")
    parser.add_argument("--name", required=True, help="container hostname (e.g. a gemstone)")
    parser.add_argument("--ctid", type=int, default=210, help="container ID (default 210)")
    parser.add_argument("--rootfs-storage", default="local-lvm",
                        help="storage pool for the container rootfs (default local-lvm)")
    parser.add_argument("--rootfs-size", type=int, default=16, help="rootfs size in GiB (default 16)")
    parser.add_argument("--cores", type=int, default=2, help="vCPUs (default 2)")
    parser.add_argument("--memory", type=int, default=4096, help="RAM in MiB (default 4096)")
    parser.add_argument("--swap", type=int, default=512, help="swap in MiB (default 512)")
    parser.add_argument("--template-storage", default="local", help="template storage")
    parser.add_argument("--template", default=DEFAULT_TEMPLATE,
                        help=f"appliance prefix (e.g. {DEFAULT_TEMPLATE}) or an exact dist filename")
    parser.add_argument("--bridge", default="vmbr0", help="network bridge (default vmbr0)")
    parser.add_argument("--ip", default="dhcp",
                        help="container IPv4: 'dhcp' or CIDR like 10.0.0.5/24 (default dhcp)")
    parser.add_argument("--gateway", default="", help="default gateway (required with a static --ip)")
    parser.add_argument("--vlan", type=int, default=0, help="VLAN tag for the NIC (0 = untagged)")
    parser.add_argument("--nameserver", default="", help="DNS server(s) (default: from DHCP)")
    parser.add_argument("--searchdomain", default="", help="DNS search domain (default: from DHCP)")
    parser.add_argument("--tags", default="class-dicom;devenv",
                        help="Proxmox tags (semicolon-separated)")
    parser.add_argument("--ssh-user", default="dicom",
                        help="container login created with key-based sshd (default dicom)")
    parser.add_argument("--mdns-hostname", default="",
                        help="hostname advertised over mDNS as <name>.local (default: --name)")
    parser.add_argument("--no-mdns", action="store_true", help="skip the mDNS step")
    parser.add_argument("--recreate", action="store_true",
                        help="destroy and rebuild if the CTID already exists")
    parser.add_argument("--repo", default=DEFAULT_REPO, help="git URL to clone")
    parser.add_argument("--branch", default=DEFAULT_BRANCH, help=f"repo branch (default {DEFAULT_BRANCH})")
    args = parser.parse_args()

    global SSH_TARGET, _CLIENT
    SSH_TARGET = args.host
    _CLIENT = connect(args.host)
    try:
        preflight()
        args.template = ensure_template(args.template, args.template_storage)
        create_container(args)
        wait_for_network(args.ctid)
        install_toolchain(args.ctid, args)
        key = ensure_local_key(args)
        setup_ssh(args.ctid, args, key)
        mdns_name = args.mdns_hostname or args.name
        if not args.no_mdns:
            if not HOSTNAME_LABEL.match(mdns_name):
                sys.exit(
                    f"mDNS hostname {mdns_name!r} is not a valid DNS label (letters, digits, and "
                    f"hyphens; <=63 chars). Fix --name/--mdns-hostname, or pass --no-mdns."
                )
            setup_mdns(args.ctid, mdns_name)
        ip = container_ip(args.ctid)
        creds = write_credentials(args, ip, key, mdns_name if not args.no_mdns else "")
        report(args, ip, key, mdns_name if not args.no_mdns else "", creds)
    finally:
        _CLIENT.close()


if __name__ == "__main__":
    main()
