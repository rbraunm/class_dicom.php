# class_dicom.php development/test/CI toolchain image.
#
# The toolchain is defined once in tools/devenv/provision.sh (shared with the LXC
# provisioner). This image is just that script baked onto Debian so CI pulls a
# ready toolchain instead of reinstalling it on every push. The build context is
# tools/devenv so provision.sh is reachable:
#   docker build -f tools/devenv/docker/Dockerfile tools/devenv
FROM debian:13

COPY provision.sh /tmp/provision.sh
RUN bash /tmp/provision.sh && rm -f /tmp/provision.sh
