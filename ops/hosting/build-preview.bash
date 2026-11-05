#!/usr/bin/env bash
set -euo pipefail
[ "$(id -u)" = 0 ] || exit 2
ops=${1:?reviewed ops path required}
cd /var/www/togoo-pricing/current
runuser -u togoo-pricing -- env HOME=/var/www/togoo-pricing/shared COMPOSER_HOME=/var/www/togoo-pricing/shared/composer /usr/bin/php8.5 /usr/local/bin/composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
runuser -u togoo-pricing -- /usr/bin/php8.5 /usr/local/bin/composer check-platform-reqs --no-dev
# Source public/build assets are preserved byte-for-byte. No dependency update.
runuser -u togoo-pricing -- /usr/bin/php8.5 artisan config:cache
runuser -u togoo-pricing -- /usr/bin/php8.5 artisan view:cache
/usr/sbin/php-fpm8.5 --test --fpm-config /etc/togoo-pricing/fpm.conf
systemctl daemon-reload
systemctl enable --now togoo-pricing-php.service
install -m 0644 "$ops/nginx-preview.conf" /etc/nginx/sites-available/zz-togoo-pricing-preview
ln -s /etc/nginx/sites-available/zz-togoo-pricing-preview /etc/nginx/sites-enabled/zz-togoo-pricing-preview
nginx -t
systemctl reload nginx
curl -fsS --max-time 20 -o /dev/null -w 'pricing_preview=%{http_code}\n' -H 'Host: pricing.rodud.com' http://127.0.0.1:8093/
curl -fsS --max-time 20 -o /dev/null -w 'pro_preview=%{http_code}\n' -H 'Host: pro.togoo.sa' http://127.0.0.1:8094/
