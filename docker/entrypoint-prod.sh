#!/bin/bash
set -e

cd /var/www/html

if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
    else
        touch .env
    fi
fi

for var in APP_KEY APP_NAME APP_ENV APP_DEBUG APP_URL DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD MAIL_MAILER MAIL_HOST MAIL_PORT MAIL_USERNAME MAIL_PASSWORD MAIL_ENCRYPTION MAIL_FROM_ADDRESS MAIL_FROM_NAME ADMIN_USERNAME ADMIN_PASSWORD ADMIN_NAME; do
    val=$(printenv $var 2>/dev/null)
    if [ -n "$val" ]; then
        if grep -q "^${var}=" .env 2>/dev/null; then
            sed -i "s|^${var}=.*|${var}=${val}|" .env
        else
            echo "${var}=${val}" >> .env
        fi
    fi
done

composer install --no-interaction --no-dev --optimize-autoloader --no-progress 2>/dev/null || true

php artisan key:generate --force 2>/dev/null || true

echo "Waiting for database at ${DB_HOST:-db}:${DB_PORT:-5432}..."
for i in $(seq 1 30); do
    if php -r "if(@fsockopen('${DB_HOST:-db}',${DB_PORT:-5432}))exit(0);exit(1);" 2>/dev/null; then
        echo "Database is ready!"
        break
    fi
    echo "Attempt $i/30 - waiting 2s..."
    sleep 2
done

php artisan migrate --force 2>/dev/null || true

ADMIN_USERNAME=${ADMIN_USERNAME:-admin} ADMIN_PASSWORD=${ADMIN_PASSWORD:-admin123} ADMIN_NAME=${ADMIN_NAME:-Administrador} \
php artisan tinker --execute="
    \$u = \App\Models\User::updateOrCreate(
        ['username' => getenv('ADMIN_USERNAME')],
        ['name' => getenv('ADMIN_NAME'), 'password' => \Illuminate\Support\Facades\Hash::make(getenv('ADMIN_PASSWORD'))]
    );
    echo 'Admin user: ' . \$u->username . PHP_EOL;
" 2>/dev/null || true
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
