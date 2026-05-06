#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
APP_DIR="${ROOT_DIR}/laravel-app"
OVERRIDES_DIR="${ROOT_DIR}/overrides"
BACKUP_SUFFIX="$(date +%Y%m%d_%H%M%S)"

if ! command -v composer >/dev/null 2>&1; then
  echo "Composer is required. Install PHP + Composer first."
  exit 1
fi

NEEDS_LARAVEL_BOOTSTRAP=0
if [ ! -f "${APP_DIR}/composer.json" ] || [ ! -f "${APP_DIR}/artisan" ]; then
  NEEDS_LARAVEL_BOOTSTRAP=1
fi

if [ -d "${APP_DIR}" ] && [ "${NEEDS_LARAVEL_BOOTSTRAP}" -eq 0 ]; then
  echo "Found existing Laravel app in ${APP_DIR}."
else
  if [ -d "${APP_DIR}" ]; then
    echo "Existing ${APP_DIR} looks incomplete. Backing it up..."
    mv "${APP_DIR}" "${APP_DIR}-broken-${BACKUP_SUFFIX}"
  fi
  mkdir -p "${APP_DIR}"
  echo "Creating Laravel app in ${APP_DIR}..."
  composer create-project laravel/laravel "${APP_DIR}"
fi

echo "Copying overrides into laravel-app..."
if command -v rsync >/dev/null 2>&1; then
  # Do NOT delete Laravel scaffold files (artisan, composer.json, etc.)
  rsync -a "${OVERRIDES_DIR}/" "${APP_DIR}/"
else
  # Fallback: overwrite files by copying
  cp -a "${OVERRIDES_DIR}/." "${APP_DIR}/"
fi

echo "Done."
echo ""
echo "Next:"
echo "  cd laravel-app"
echo "  cp .env.example .env"
echo "  # set DB_* in .env"
echo "  composer install"
echo "  php artisan key:generate"
echo "  php artisan migrate --seed"
echo "  php artisan storage:link"
echo "  php artisan serve"

