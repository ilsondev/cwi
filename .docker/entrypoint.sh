#!/usr/bin/env bash
set -euo pipefail
#!/usr/bin/env bash
set -euo pipefail

echo "Generating .env from environment variables..."
truncate -s 0 .env || true

append() { echo "$1" >> .env; }

append "APP_NAME=${APP_NAME:-Laravel}"
append "APP_ENV=${APP_ENV:-local}"
append "APP_KEY=${APP_KEY:-}"
append "APP_DEBUG=${APP_DEBUG:-true}"
append "APP_URL=${APP_URL:-http://localhost:8000}"
append "LOG_CHANNEL=${LOG_CHANNEL:-stack}"
append "LOG_LEVEL=${LOG_LEVEL:-debug}"

append "DB_CONNECTION=${DB_CONNECTION:-mysql}"
append "DB_HOST=${DB_HOST:-mysql}"
append "DB_PORT=${DB_PORT:-3306}"
append "DB_DATABASE=${DB_DATABASE:-app}"
append "DB_USERNAME=${DB_USERNAME:-app}"
append "DB_PASSWORD=${DB_PASSWORD:-secret}"

append "REDIS_CLIENT=${REDIS_CLIENT:-phpredis}"
append "REDIS_HOST=${REDIS_HOST:-redis}"
append "REDIS_PORT=${REDIS_PORT:-6379}"
append "CACHE_DRIVER=${CACHE_DRIVER:-file}"
append "CACHE_STORE=${CACHE_STORE:-file}"
append "QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}"
append "SESSION_DRIVER=${SESSION_DRIVER:-file}"

append "VITE_APP_NAME=${VITE_APP_NAME:-${APP_NAME:-Laravel}}"

if grep -qE '^APP_KEY=$|^APP_KEY=""$' .env; then
  php artisan key:generate --force
fi

exec php artisan serve --host=0.0.0.0 --port=8000

