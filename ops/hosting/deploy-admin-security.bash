#!/usr/bin/env bash
set -euo pipefail
[ "$(id -u)" = 0 ] || exit 2
patch_dir=${1:?reviewed patch directory required}
pricing_base=/var/www/togoo-pricing
previous_release=$(readlink -e "$pricing_base/current")
case "$previous_release" in "$pricing_base/releases/"*) ;; *) echo "Unexpected pricing release path" >&2; exit 3;; esac
deployment_id=$(date -u +%Y%m%dT%H%M%SZ)-admin-access
next_release="$pricing_base/releases/$deployment_id"
test ! -e "$next_release"
test -d "$patch_dir"
test "$(sha256sum "$previous_release/composer.lock" | cut -d ' ' -f 1)" = "7697acc4585c9eff835abe2243e18c1d413aaca22a2593f2cfcc2b1d0bc6aa62"
backup_dir="/var/lib/togoo-pricing/admin-access/$deployment_id"
install -d -m 0700 "$backup_dir"
umask 077
mariadb-dump --single-transaction --skip-lock-tables website_pricing > "$backup_dir/database-before.sql"
printf '%s\n' "$previous_release" > "$backup_dir/previous-release"
cp -a -- "$previous_release" "$next_release"
files=(
 app/Models/User.php
 app/Providers/AppServiceProvider.php
 app/Http/Requests/Auth/LoginRequest.php
 app/Console/Commands/ProvisionPricingAdmin.php
 routes/auth.php
 routes/web.php
 database/migrations/2026_11_05_090000_add_is_admin_to_users_table.php
)
for file in "${files[@]}"; do
 test -f "$patch_dir/$file"
 install -d -m 0755 "$(dirname "$next_release/$file")"
 install -m 0644 "$patch_dir/$file" "$next_release/$file"
 /usr/bin/php8.5 -l "$next_release/$file" > /dev/null
done
chown -hR togoo-pricing:togoo-pricing "$next_release"
pricing_artisan() {
 runuser -u togoo-pricing -- /usr/bin/php8.5 "$next_release/artisan" "$@"
}
pricing_artisan config:clear
pricing_artisan route:clear
pricing_artisan migrate --force
pricing_artisan config:cache
pricing_artisan route:cache
pricing_artisan view:cache
pricing_artisan list --raw | grep '^pricing:admin ' > /dev/null
ln -s "$next_release" "$pricing_base/current.$deployment_id"
mv -Tf "$pricing_base/current.$deployment_id" "$pricing_base/current"
# Only the dedicated pricing PHP process is reloaded. Never reload Nginx here.
systemctl reload togoo-pricing-php.service
for path in /up /login /pricing-data /register /admin /quotes /quotes.csv; do
 expected=200
 case "$path" in /register) expected=404;; /admin|/quotes|/quotes.csv) expected=302;; esac
 code=$(curl --noproxy '*' -sS --connect-timeout 3 --max-time 15 --resolve pricing.rodud.com:443:127.0.0.1 -o /dev/null -w '%{http_code}' "https://pricing.rodud.com$path")
 printf '%s status=%s expected=%s\n' "$path" "$code" "$expected"
 if [ "$code" != "$expected" ]; then
  echo "Pricing acceptance failed; previous code retained at $previous_release. No shared service has been changed." >&2
  exit 4
 fi
done
printf 'PRICING_ADMIN_ACCESS_RELEASE=%s\n' "$deployment_id"
