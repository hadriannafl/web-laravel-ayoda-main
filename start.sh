#!/bin/bash
set -e

# Tulis .env dari environment variables Railway
cat > .env << EOF
APP_NAME="${APP_NAME:-CRM-ISS}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY}"
APP_DEBUG="${APP_DEBUG:-false}"
APP_URL="${APP_URL:-http://localhost}"

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

# Generate APP_KEY jika belum di-set
if [ -z "${APP_KEY}" ]; then
    php artisan key:generate --force
fi

# Buat SQLite database fresh
touch database/database.sqlite

# Migrasi & seed (selalu fresh karena filesystem Railway ephemeral)
php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction

# Cache untuk performa
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✓ App siap di port ${PORT:-8080}"

# Jalankan server
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
