#!/bin/bash
set -e

echo "Starting deployment..."

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Laravel optimization
php artisan down --message="Upgrading. Back in 1 minute." --retry=60
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan migrate --force

# Restart services
php artisan up
php artisan queue:restart

echo "Deployment complete!"
