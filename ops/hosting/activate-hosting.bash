#!/usr/bin/env bash
set -euo pipefail
[ "$(id -u)" = 0 ] || exit 2
ops=${1:?reviewed ops path required}
phase=${2:?bootstrap or public required}
case "$phase" in bootstrap) name=nginx-bootstrap.conf;; public) name=nginx-public.conf;; *) exit 3;; esac
[ -s /etc/letsencrypt/live/togoo-pricing/fullchain.pem ] || exit 4
if [ "$phase" = public ]; then [ -s /etc/letsencrypt/live/togoo-pro/fullchain.pem ] || exit 4; fi
site=/etc/nginx/sites-available/zz-togoo-pricing-pro
backup=$(mktemp /etc/togoo-pricing/nginx-previous.XXXXXX)
if [ -f "$site" ]; then cp -p "$site" "$backup"; else : > "$backup"; fi
install -m 0644 "$ops/$name" "$site"
if [ ! -L /etc/nginx/sites-enabled/zz-togoo-pricing-pro ]; then ln -s "$site" /etc/nginx/sites-enabled/zz-togoo-pricing-pro; fi
if ! nginx -t; then
 if [ -s "$backup" ]; then cp -p "$backup" "$site"; else unlink /etc/nginx/sites-enabled/zz-togoo-pricing-pro; fi
 exit 5
fi
systemctl reload nginx
