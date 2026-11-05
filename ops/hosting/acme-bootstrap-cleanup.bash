#!/usr/bin/env bash
set -euo pipefail
case "$CERTBOT_DOMAIN" in pricing.rodud.com|www.pricing.rodud.com) ;; *) exit 2;; esac
rm -f "/var/lib/togoo-pricing/acme-ack-$CERTBOT_TOKEN"
