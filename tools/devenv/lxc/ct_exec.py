#!/usr/bin/env python3
# SPDX-License-Identifier: Apache-2.0
# Copyright (c) 2026 Randy Braunm

"""Run a command on a provision_lxc.py container over SSH, using the generated key.

Reuses what provision_lxc.py wrote into ./keys -- the private key (<name>_ed25519) and the login
file (<name>-ssh.txt, for the address and user) -- so there is no password and no per-command
boilerplate. Point it at a container (by --name, or auto-detected when only one has been
provisioned) and a command; the command's combined output streams live and this exits with the
remote command's status, so it composes in scripts and fails loud.

    python tools/devenv/lxc/ct_exec.py -- nproc
    python tools/devenv/lxc/ct_exec.py --name dicomphp -- dcmdump --version
    python tools/devenv/lxc/ct_exec.py -- "cd /opt/class_dicom/src && vendor/bin/phpunit"
    python tools/devenv/lxc/ct_exec.py --host 10.0.0.5 --user dicom -- uptime

Put the command after `--` (so argparse does not eat its dashes) or pass it as one quoted string.
Address/user come from the login file unless --host/--user override them; the key defaults to
keys/<name>_ed25519 unless --key overrides it.
"""
from __future__ import annotations

import argparse
import glob
import os
import sys

try:
    import paramiko
except ImportError:
    sys.exit(
        "ct_exec needs paramiko (the pure-Python SSH client).\n"
        "Install it from an admin prompt: pip install paramiko"
    )

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
KEY_DIR = os.path.join(SCRIPT_DIR, "keys")
SUFFIX = "-ssh.txt"


def resolve_name(name: str) -> str:
    """Use --name if given; otherwise auto-detect the sole provisioned container from its login
    file in keys/. Fail loud on zero or several -- never guess which container was meant."""
    if name:
        return name
    creds = sorted(glob.glob(os.path.join(KEY_DIR, "*" + SUFFIX)))
    if len(creds) == 1:
        return os.path.basename(creds[0])[: -len(SUFFIX)]
    if not creds:
        sys.exit(f"no provisioned containers in {KEY_DIR} -- run provision_lxc.py, or pass --name.")
    names = [os.path.basename(c)[: -len(SUFFIX)] for c in creds]
    sys.exit(f"several containers provisioned ({names}); pass --name to pick one.")


def read_credentials(name: str) -> dict:
    """Parse the 'key: value' login file provision_lxc wrote, or {} if it is absent."""
    path = os.path.join(KEY_DIR, name + SUFFIX)
    creds: dict = {}
    if not os.path.exists(path):
        return creds
    with open(path) as f:
        for line in f:
            line = line.strip()
            if line.startswith("#") or ":" not in line:
                continue
            key, _, value = line.partition(":")
            creds[key.strip()] = value.strip()
    return creds


def resolve_target(args, name: str) -> tuple[str, str, str]:
    """Resolve (host, user, key_path) from --flags, falling back to the login file. Fails loud
    rather than guessing when a required value is missing or unusable."""
    creds = read_credentials(name)
    host = args.host or creds.get("address", "")
    user = args.user or creds.get("user", "")
    key_path = args.key or os.path.join(KEY_DIR, creds.get("key", f"{name}_ed25519"))
    if not host or host.startswith("("):   # "(unknown -- ...)" sentinel from provisioning
        sys.exit(f"no usable address for {name!r} (login file says {host!r}); pass --host.")
    if not user:
        sys.exit(f"no user for {name!r}; pass --user.")
    if not os.path.exists(key_path):
        sys.exit(f"private key not found: {key_path} (run provision_lxc.py, or pass --key).")
    return host, user, key_path


def exec_stream(client: "paramiko.SSHClient", command: str) -> int:
    """Run command, stream combined stdout+stderr live, return its exit status."""
    chan = client.get_transport().open_session()
    chan.set_combine_stderr(True)
    chan.exec_command(command)
    stdout = chan.makefile("r")
    for line in iter(stdout.readline, ""):
        sys.stdout.write(line)
        sys.stdout.flush()
    return chan.recv_exit_status()


def main() -> None:
    parser = argparse.ArgumentParser(
        description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter
    )
    parser.add_argument("--name", default="",
                        help="container to target (default: the sole provisioned one in keys/)")
    parser.add_argument("--host", default="", help="override the address from the login file")
    parser.add_argument("--user", default="", help="override the login from the login file")
    parser.add_argument("--key", default="", help="override the private key path")
    parser.add_argument("--timeout", type=float, default=15.0, help="connect timeout seconds")
    parser.add_argument("command", nargs="*",
                        help="the command to run (put it after -- or quote it)")
    args = parser.parse_args()

    command = " ".join(args.command).strip()
    if not command:
        sys.exit("no command given. Example: python tools/devenv/lxc/ct_exec.py -- nproc")

    name = resolve_name(args.name)
    host, user, key_path = resolve_target(args, name)
    key = paramiko.Ed25519Key.from_private_key_file(key_path)
    client = paramiko.SSHClient()
    client.load_system_host_keys()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        client.connect(host, username=user, pkey=key, look_for_keys=False,
                       allow_agent=False, timeout=args.timeout)
    except paramiko.AuthenticationException:
        sys.exit(f"key auth failed for {user}@{host} with {key_path}.")
    except (paramiko.SSHException, OSError) as e:
        sys.exit(f"cannot reach {user}@{host}: {e}")
    try:
        rc = exec_stream(client, command)
    finally:
        client.close()
    sys.exit(rc)


if __name__ == "__main__":
    main()
