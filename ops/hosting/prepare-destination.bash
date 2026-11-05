#!/usr/bin/env bash
set -euo pipefail
[ "$(id -u)" = 0 ] || exit 2
[ ! -e /var/www/togoo-pricing ] && [ ! -e /var/www/togoo-pro ] || { echo ALREADY_EXISTS; exit 3; }
ops=${1:?reviewed ops path required}
if ! id togoo-pricing >/dev/null 2>&1; then useradd --system --user-group --home-dir /var/www/togoo-pricing --shell /usr/sbin/nologin togoo-pricing; fi
install -d -m 0700 /var/lib/togoo-pricing/incoming
install -d -m 0755 /var/lib/togoo-pricing/acme/.well-known/acme-challenge /etc/togoo-pricing
install -d -o root -g togoo-pricing -m 0751 /var/www/togoo-pricing /var/www/togoo-pricing/releases /var/www/togoo-pricing/shared
install -d -m 0755 /var/www/togoo-pro /var/www/togoo-pro/releases
install -d -o togoo-pricing -g togoo-pricing -m 0750 /var/log/togoo-pricing
for name in fpm.conf fpm-pool.conf pricing-common.conf pro-common.conf acme.conf; do install -m 0644 "$ops/$name" "/etc/togoo-pricing/$name"; done
install -m 0644 "$ops/pricing-php.service" /etc/systemd/system/togoo-pricing-php.service
printf 'DESTINATION_READY_FOR_STREAMS\n'
