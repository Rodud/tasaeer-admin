#!/usr/bin/env bash
# Temporary bridge for issuing TLS before switching the old origin DNS.
set -euo pipefail
case "$CERTBOT_DOMAIN" in pricing.rodud.com|www.pricing.rodud.com) ;; *) exit 2;; esac
python3 - <<'PY'
import os,json,re
from pathlib import Path
v={k:os.environ['CERTBOT_'+k] for k in ['DOMAIN','TOKEN','VALIDATION']}
assert re.fullmatch('[A-Za-z0-9_-]+',v['TOKEN'])
Path('/var/lib/togoo-pricing/acme-request.json').write_text(json.dumps(v))
PY
for attempt in $(seq 1 300); do
 [ ! -e "/var/lib/togoo-pricing/acme-ack-$CERTBOT_TOKEN" ] || exit 0
 sleep 1
done
exit 3
