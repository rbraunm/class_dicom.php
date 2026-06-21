#!/usr/bin/env bash
# Provision the class_dicom.php development/test/CI toolchain on Debian.
#
# Installs PHP 8.5 (from packages.sury.org), Debian's packaged DCMTK, a Python
# venv with pydicom/pynetdicom (the test oracle), and Composer. Idempotent: safe
# to re-run. Runs as root inside a fresh Debian container -- the same script backs
# both the LXC (tools/devenv/lxc) and the CI image (tools/devenv/docker), so the
# toolchain is defined in exactly one place.
set -euo pipefail

PHP_VERSION="8.5"
PHP_BIN="php${PHP_VERSION}"
VENV_DIR="/opt/dicom-oracle"
COMPOSER_BIN="/usr/local/bin/composer"

log() { printf '== %s\n' "$*"; }

require_root() {
  [ "$(id -u)" -eq 0 ] || { echo "provision.sh must run as root" >&2; exit 1; }
}

require_debian() {
  grep -qi debian /etc/os-release || { echo "provision.sh targets Debian" >&2; exit 1; }
}

install_base() {
  log "base packages"
  export DEBIAN_FRONTEND=noninteractive
  apt-get update
  apt-get install -y --no-install-recommends \
    ca-certificates curl gnupg lsb-release apt-transport-https git unzip
}

install_php() {
  log "PHP ${PHP_VERSION} from packages.sury.org"
  local codename keyring listfile
  codename="$(lsb_release -sc)"
  keyring="/etc/apt/keyrings/sury-php.gpg"
  listfile="/etc/apt/sources.list.d/sury-php.list"
  install -d -m 0755 /etc/apt/keyrings
  curl -fsSL https://packages.sury.org/php/apt.gpg | gpg --dearmor -o "${keyring}"
  echo "deb [signed-by=${keyring}] https://packages.sury.org/php/ ${codename} main" > "${listfile}"
  apt-get update
  apt-get install -y --no-install-recommends \
    "${PHP_BIN}-cli" "${PHP_BIN}-mbstring" "${PHP_BIN}-xml" "${PHP_BIN}-curl" "${PHP_BIN}-zip"
}

install_dcmtk() {
  log "DCMTK (Debian package)"
  apt-get install -y --no-install-recommends dcmtk
}

install_python_oracle() {
  log "Python venv with pydicom/pynetdicom at ${VENV_DIR}"
  apt-get install -y --no-install-recommends python3 python3-venv
  [ -x "${VENV_DIR}/bin/python" ] || python3 -m venv "${VENV_DIR}"
  "${VENV_DIR}/bin/pip" install --upgrade pip
  "${VENV_DIR}/bin/pip" install pydicom pynetdicom
}

install_composer() {
  log "Composer"
  local installer expected actual
  installer="$(mktemp)"
  curl -fsSL https://getcomposer.org/installer -o "${installer}"
  expected="$(curl -fsSL https://composer.github.io/installer.sig)"
  actual="$("${PHP_BIN}" -r "echo hash_file('sha384', '${installer}');")"
  if [ "${expected}" != "${actual}" ]; then
    rm -f "${installer}"
    echo "Composer installer checksum mismatch -- refusing to run it" >&2
    exit 1
  fi
  "${PHP_BIN}" "${installer}" --install-dir=/usr/local/bin --filename=composer --quiet
  rm -f "${installer}"
}

verify() {
  log "installed versions"
  "${PHP_BIN}" -v | head -1
  dcmdump --version | head -1
  "${COMPOSER_BIN}" --version
  "${VENV_DIR}/bin/python" -c "import pydicom, pynetdicom; print('pydicom', pydicom.__version__, 'pynetdicom', pynetdicom.__version__)"
}

main() {
  require_root
  require_debian
  install_base
  install_php
  install_dcmtk
  install_python_oracle
  install_composer
  verify
  log "provisioning complete"
}

main "$@"
