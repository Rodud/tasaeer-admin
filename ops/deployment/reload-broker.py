#!/usr/bin/env python3
"""Root-owned fixed action. No arbitrary commands, paths, arguments or services."""
import os, stat, json, re, pwd, subprocess, tempfile
from pathlib import Path

REQUEST = Path('/var/lib/togoo-pricing-deploy/reload.request')
OUTPUT = Path('/run/togoo-pricing-deploy/reload-result.json')

def main():
    descriptor = os.open(REQUEST, os.O_RDONLY | os.O_NOFOLLOW)
    with os.fdopen(descriptor) as request:
        metadata = os.fstat(request.fileno())
        if not stat.S_ISREG(metadata.st_mode) or metadata.st_uid != pwd.getpwnam('togoo-pricing-deploy').pw_uid or metadata.st_size > 512:
            raise RuntimeError('invalid_reload_request')
        payload = json.load(request)
    nonce = payload.get('nonce', '')
    if not isinstance(nonce, str) or not re.fullmatch(r'[0-9a-f]{64}', nonce): raise RuntimeError('invalid_reload_nonce')
    if OUTPUT.is_file():
        previous = json.loads(OUTPUT.read_text())
        if previous.get('nonce') == nonce and previous.get('success'):
            return
    # Root identity is provided by this fixed systemd unit, never inherited by the worker.
    status = subprocess.run(['/usr/bin/systemctl', 'reload', 'togoo-pricing-php.service'], stdin=subprocess.DEVNULL, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL, timeout=30).returncode
    with tempfile.NamedTemporaryFile(mode='w', dir=OUTPUT.parent, prefix='.reload-', delete=False) as output:
        json.dump({'nonce': nonce, 'success': status == 0}, output)
        temporary = Path(output.name)
    temporary.chmod(0o644)
    temporary.replace(OUTPUT)
    if status: raise RuntimeError('pricing_php_reload_failed')

if __name__ == '__main__': main()
