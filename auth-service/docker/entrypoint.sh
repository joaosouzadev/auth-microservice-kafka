#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

php artisan migrate
php artisan key:generate
php artisan optimize:clear

php-fpm &
php artisan queue:work

exec docker-php-entrypoint "$@"
