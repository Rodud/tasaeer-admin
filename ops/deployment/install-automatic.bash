#!/usr/bin/env bash
# One-time pricing-only bootstrap. No Nginx reload or global PHP configuration.
set -euo pipefail
[ "$(id -u)" = 0 ] || exit 2
reviewed=${1:?reviewed deployment directory required}
base=/var/www/togoo-pricing
state=/var/lib/togoo-pricing-deploy
control=/etc/togoo-pricing-deploy
test -f "$reviewed/worker.py" && test -f "$reviewed/pdo_sqlite.so"
test -L "$base/current" && test -f "$base/shared/.env"
test -x /opt/togoo/toolchain/bin/node && test -x /opt/togoo/toolchain/bin/npm
id togoo-pricing-deploy >/dev/null 2>&1 || useradd --system --no-create-home --home-dir "$state" --shell /usr/sbin/nologin --gid togoo-pricing togoo-pricing-deploy
install -d -o togoo-pricing-deploy -g togoo-pricing -m 0710 "$state"
for directory in jobs backups logs results composer npm-cache; do
 install -d -o togoo-pricing-deploy -g togoo-pricing -m 0700 "$state/$directory"
done
install -d -o root -g root -m 0755 "$control"
for file in worker.py archive_guard.py reload-broker.py health-probe.php backup-database.php pdo_sqlite.so; do
 install -m 0644 "$reviewed/$file" "$control/$file"
done
# Database tests load the matching packaged extension in their CLI process only.
/usr/bin/php8.5 -d "extension=$control/pdo_sqlite.so" -r 'exit(in_array("sqlite", PDO::getAvailableDrivers(), true) ? 0 : 1);'
chown togoo-pricing-deploy:togoo-pricing "$base" "$base/releases"
chmod 0755 "$base" "$base/releases"
chmod -R g+rwX "$base/shared/storage"
# Earlier operator-built releases may have 0600 generated caches. The isolated
# deploy account needs group read access to check/restore the current release.
find "$base/current/bootstrap/cache" -maxdepth 1 -type f -name '*.php' -exec chgrp togoo-pricing {} + -exec chmod g+r {} +
for unit in togoo-pricing-deploy.service togoo-pricing-deploy.timer togoo-pricing-reload.service togoo-pricing-reload.path; do
 install -m 0644 "$reviewed/$unit" "/etc/systemd/system/$unit"
done
systemd-analyze verify /etc/systemd/system/togoo-pricing-deploy.service /etc/systemd/system/togoo-pricing-deploy.timer /etc/systemd/system/togoo-pricing-reload.service /etc/systemd/system/togoo-pricing-reload.path
systemctl daemon-reload
systemctl enable --now togoo-pricing-reload.path
# Enable the timer separately after production is populated with the reviewed main.
echo PRICING_DEPLOYMENT_INSTALLED_TIMER_NOT_STARTED
