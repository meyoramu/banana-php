#!/bin/bash

# BANANA-PHP Test Script
set -e

echo "🧪 Running tests..."

# Run PHPUnit tests
./vendor/bin/phpunit --testdox

# Run static analysis
./vendor/bin/phpstan analyse

# Run code style checks
./vendor/bin/phpcs --standard=PSR12 app/ tests/

echo "✅ All tests passed successfully!"