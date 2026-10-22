#!/bin/sh
set -e

echo "=== EAGT GOLANI MULTI-CHURCH APPLICATION INITIALIZING ==="

# Wait briefly if database connection parameters are provided
if [ -n "$DB_HOST" ]; then
    echo "Checking database connection to $DB_HOST:$DB_PORT..."
fi

# Ensure storage directories exist and have proper permissions
mkdir -p /var/www/storage/framework/cache/data \
         /var/www/storage/framework/sessions \
         /var/www/storage/framework/views \
         /var/www/storage/logs \
         /var/www/bootstrap/cache

chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache || true

# Run database migrations in production
if [ "$SKIP_MIGRATIONS" != "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Warning: Migration failed or database not ready yet."
fi

# Run seeders if requested or first run
if [ "$SEED_DATABASE" = "true" ]; then
    echo "Seeding initial church data..."
    php artisan db:seed --force || echo "Warning: Database seeding skipped or already seeded."
fi

# Optimize Laravel for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Determine port (Render assigns $PORT, default to 10000 or 80)
TARGET_PORT="${PORT:-10000}"
echo "Starting Application on port $TARGET_PORT..."

exec php artisan serve --host=0.0.0.0 --port="$TARGET_PORT"
