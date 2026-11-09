#!/usr/bin/env sh
set -eu
composer install
[ -f .env ] || cp .env.example .env
[ -f database/database.sqlite ] || touch database/database.sqlite
if ! grep -q '^APP_KEY=base64:' .env; then php artisan key:generate; fi
php artisan migrate --seed
[ -e public/storage ] || php artisan storage:link
printf 'Ready. Run: php artisan serve\n'
