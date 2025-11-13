#!/bin/bash

# Build script for Railway deployment
echo "🚀 Starting build process..."

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Generate application key
php artisan key:generate --force

# Run migrations
php artisan migrate --force

echo "✅ Build completed!"
