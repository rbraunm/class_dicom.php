#!/usr/bin/env bash
# SPDX-License-Identifier: Apache-2.0
# Copyright (c) 2026 Randy Braunm
#
# Phase 0.5 -- install logging shims for the external tools the v1 API may invoke, so that driving
# the public API records which tool each operation calls and with what argv. Each shim appends a
# tab-separated record (ISO time, cwd, tool, argc, argv) to $V1_SHIM_LOG, then exec's the real tool
# unchanged -- behavior is identical, the call is just observed.
#
# Shims are written to /usr/local/bin, which is v1's default TOOLKIT_DIR (per the README) and sits
# ahead of /usr/bin on PATH, so both absolute (TOOLKIT_DIR/tool) and bare-name calls are caught while
# the real binaries stay in /usr/bin. The DCMTK tool list comes from `dpkg -L dcmtk` (no guessing);
# ffmpeg is added when present (for multiframe_to_video).
#
# Usage:  V1_SHIM_LOG=/tmp/v1cap/shim.log bash makeToolShims.sh [realDir] [shimDir]
set -euo pipefail

realDir="${1:-/usr/bin}"
shimDir="${2:-/usr/local/bin}"
log="${V1_SHIM_LOG:?set V1_SHIM_LOG to the capture-log path}"

install -d "$shimDir"
install -d "$(dirname "$log")"
: > "$log"
chmod 0666 "$log"   # the harness runs as the non-root dev user and appends OP markers

mapfile -t tools < <(dpkg -L dcmtk | sed -n 's#^/usr/bin/##p' | sort -u)
if command -v ffmpeg >/dev/null 2>&1; then
  tools+=("ffmpeg")
fi
if [ "${#tools[@]}" -eq 0 ]; then
  echo "no tools to shim -- is dcmtk installed?" >&2
  exit 1
fi

count=0
for tool in "${tools[@]}"; do
  real="$realDir/$tool"
  if [ ! -x "$real" ]; then
    continue
  fi
  cat > "$shimDir/$tool" <<SHIM
#!/bin/sh
# Phase 0.5 logging shim -- record the call, then run the real $tool.
log="\${V1_SHIM_LOG:-$log}"
printf '%s\t%s\t%s\t%d\t%s\n' "\$(date -Is)" "\$PWD" "$tool" "\$#" "\$*" >> "\$log"
exec "$real" "\$@"
SHIM
  chmod +x "$shimDir/$tool"
  count=$((count + 1))
done

echo "installed $count shims in $shimDir (delegating to $realDir); log: $log"
