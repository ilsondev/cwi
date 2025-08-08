#!/usr/bin/env bash
set -euo pipefail

# Wait for MySQL
if [ -n "${DB_HOST:-}" ]; then
  echo "Waiting for MySQL at ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
  until mysqladmin ping -h"${DB_HOST:-mysql}" -P"${DB_PORT:-3306}" -u"${DB_USERNAME:-root}" -p"${DB_PASSWORD:-root}" --silent; do
    sleep 1
  done
fi

# Copy default .env if missing
if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    echo "Creating .env from .env.example"
    cp .env.example .env || true
  else
    echo "Creating minimal .env"
    cat > .env <<'EOF'
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

REDIS_CLIENT=phpredis
REDIS_HOST=${REDIS_HOST}
REDIS_PORT=${REDIS_PORT}

CACHE_DRIVER=${CACHE_DRIVER}
CACHE_STORE=${CACHE_STORE}
QUEUE_CONNECTION=${QUEUE_CONNECTION}
SESSION_DRIVER=${SESSION_DRIVER}
EOF
  fi
fi

# Ensure app key
if ! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env; then
  php artisan key:generate --force
fi

# Run migrations (best-effort for POC)
php artisan migrate --force || true

# Storage link for local
php artisan storage:link || true

# Start Laravel dev server
exec php artisan serve --host=0.0.0.0 --port=8000
