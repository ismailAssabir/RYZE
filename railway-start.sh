#!/usr/bin/env sh
set -eu

cd "$(dirname "$0")"

# Ensure .env exists (Railway provides env vars; Laravel still expects the file)
if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    cp .env.example .env
  else
    # Create a minimal .env to satisfy Laravel bootstrap
    cat > .env <<'EOF'
APP_NAME=RYZE
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost
APP_KEY=
LOG_CHANNEL=stack
EOF
  fi
fi

# Generate APP_KEY if missing
if [ -z "${APP_KEY:-}" ]; then
  # If APP_KEY is empty inside environment, try to generate from Laravel.
  php artisan key:generate --force --ansi || true
fi

# Prepare storage directories
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Ensure storage symlink exists (non-fatal)
php artisan storage:link || true

# Warm caches if desired (non-fatal)
php artisan config:clear || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start web server
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"

