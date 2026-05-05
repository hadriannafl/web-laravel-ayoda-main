#!/bin/bash
set -e

# Buat direktori storage yang diperlukan Laravel
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Tulis .env menggunakan printf (hindari masalah CRLF heredoc)
printf "APP_NAME=\"CRM-ISS\"\n" > .env
printf "APP_ENV=%s\n" "${APP_ENV:-production}" >> .env
printf "APP_KEY=%s\n" "${APP_KEY}" >> .env
printf "APP_DEBUG=%s\n" "${APP_DEBUG:-false}" >> .env
printf "APP_URL=%s\n" "${APP_URL:-http://localhost}" >> .env
printf "\n" >> .env
printf "LOG_CHANNEL=stderr\n" >> .env
printf "LOG_LEVEL=error\n" >> .env
printf "\n" >> .env
printf "DB_CONNECTION=sqlite\n" >> .env
printf "\n" >> .env
printf "BROADCAST_DRIVER=log\n" >> .env
printf "CACHE_DRIVER=file\n" >> .env
printf "FILESYSTEM_DISK=local\n" >> .env
printf "QUEUE_CONNECTION=sync\n" >> .env
printf "SESSION_DRIVER=file\n" >> .env
printf "SESSION_LIFETIME=120\n" >> .env

# Generate APP_KEY jika belum di-set
if [ -z "${APP_KEY}" ]; then
    php artisan key:generate --force
fi

# Jalankan post-install scripts yang di-skip saat build
php artisan package:discover --ansi 2>/dev/null || true

# Buat SQLite database fresh
touch database/database.sqlite

# Migrasi fresh (drop & recreate) + seed — idempotent saat restart
php artisan migrate:fresh --force --no-interaction --seed

# Cache untuk performa
php artisan config:cache
php artisan view:cache

echo "App siap di port ${PORT:-8080}"

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
