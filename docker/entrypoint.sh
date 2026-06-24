#!/bin/bash
set -e

composer install --no-interaction --no-dev --optimize-autoloader --no-progress 2>/dev/null || true

if ! grep -q "^APP_KEY=" .env 2>/dev/null || [ -z "$(grep '^APP_KEY=' .env | cut -d'=' -f2)" ]; then
    php artisan key:generate --force
fi

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

exec php-fpm
