#!/bin/bash

# MagicCMS Deploy Script
# Usage: ./deploy.sh

set -e

echo "Starting deployment..."

# Pull latest changes
echo "Pulling latest changes..."
git pull origin main

# Install composer dependencies
echo "Installing composer dependencies..."
composer install --no-dev --optimize-autoloader

# Install npm dependencies and build assets
echo "Installing npm dependencies..."
npm ci

echo "Building assets..."
npm run build

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Clear and cache config
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear old cache
php artisan cache:clear

# Restart queue workers
echo "Restarting queue workers..."
php artisan queue:restart

# Set permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Deployment completed successfully!"
