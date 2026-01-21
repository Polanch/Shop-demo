#!/bin/bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
npm install
npm run build

# Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations with seeding
php artisan migrate --force --seed

echo "Build complete!"
