#!/bin/bash
set -e

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction --prefer-dist

echo "Cleaning vendor directory..."
# Remove all test directories
find vendor -type d -name "test" -o -name "tests" -o -name "Test" -o -name "Tests" | xargs rm -rf 2>/dev/null || true

# Remove all doc directories
find vendor -type d -name "doc" -o -name "docs" -o -name "documentation" | xargs rm -rf 2>/dev/null || true

# Remove all example directories
find vendor -type d -name "example" -o -name "examples" | xargs rm -rf 2>/dev/null || true

# Remove unnecessary files
find vendor -type f \( -name "*.md" -o -name "LICENSE*" -o -name "CHANGELOG*" -o -name "composer.json" -o -name "composer.lock" -o -name "phpunit.xml*" -o -name ".travis.yml" -o -name ".gitignore" -o -name ".editorconfig" \) -delete 2>/dev/null || true

# Remove .git directories
find vendor -type d -name ".git" | xargs rm -rf 2>/dev/null || true

echo "Installing npm dependencies..."
npm ci --production

echo "Building assets with Vite..."
npm run vercel-build

echo "Cleaning node_modules..."
rm -rf node_modules

echo "Generating optimized autoloader..."
composer dump-autoload --optimize --classmap-authoritative --no-dev

echo "Build completed successfully!"