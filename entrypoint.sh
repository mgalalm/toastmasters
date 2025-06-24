#!/bin/sh
set -e

# php artisan key:generate

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force


exec "$@"
