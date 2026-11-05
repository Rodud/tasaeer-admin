#!/usr/bin/env bash
set -euo pipefail
case "${RENEWED_LINEAGE:-}" in
 /etc/letsencrypt/live/togoo-pricing|/etc/letsencrypt/live/togoo-pro) /usr/sbin/nginx -t; /usr/bin/systemctl reload nginx;;
esac
