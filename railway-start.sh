#!/usr/bin/env sh
set -eu

cd "$(dirname "$0")"

# Railway/Nixpacks sometimes start the process outside of the project root.
# Force cd to the directory containing artisan to avoid broken bootstrap.
cd "$(pwd)" && [ -f artisan ] || exit 1

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

# Prepare storage directories
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# IMPORTANT:
# Warm caches removed during Railway boot because if Laravel bootstrap is not stable yet,
# commands like config:cache/route:cache can crash and cause Railway "Application failed to respond".

# Ensure storage symlink exists (non-fatal)
php artisan storage:link || true

# Generate APP_KEY if missing
if [ -z "${APP_KEY:-}" ]; then
  # If APP_KEY is empty inside environment, try to generate from Laravel.
  php artisan key:generate --force --ansi || true
fi


# Start web server
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"

