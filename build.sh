#!/bin/bash

# Build script for Railway deployment
echo "🚀 Starting build process..."

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Create necessary directories
mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache
chmod -R a+rw storage

# Cache optimization (commands that don't require DB)
php artisan route:cache
php artisan view:cache

echo "✅ Build completed!"
