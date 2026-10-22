#!/bin/sh
set -e

echo "=== EAGT GOLANI MULTI-CHURCH APPLICATION INITIALIZING ==="

# 1. Hakikisha APP_KEY ni halali ya base64
if [ -z "$APP_KEY" ] || ! echo "$APP_KEY" | grep -q "^base64:"; then
    echo "Setting valid Laravel APP_KEY..."
    export APP_KEY="base64:z6UD+5SymhkfLyrMqyBfQKN3dO6miSpuL78Tn9Jmk9c="
fi

# 2. Hakikisha storage directories zipo na zina permissions sahihi
mkdir -p /var/www/storage/framework/cache/data \
         /var/www/storage/framework/sessions \
         /var/www/storage/framework/views \
         /var/www/storage/logs \
         /var/www/bootstrap/cache

chmod -R 777 /var/www/storage /var/www/bootstrap/cache || true
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache || true

# 3. Safisha cache za zamani ili zisilete mgongano wa mazingira
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# 4. Subiri Database iwe tayari (hadi sekunde 60)
echo "Checking database connectivity..."
DB_READY=false
for i in $(seq 1 30); do
    if php artisan migrate:status >/dev/null 2>&1; then
        echo "Database connection verified and ready!"
        DB_READY=true
        break
    fi
    echo "Database provisioning or starting up... waiting ($i/30)"
    sleep 2
done

# 5. Endesha Migrations na Seeders
if [ "$DB_READY" = "true" ]; then
    echo "Executing database migrations..."
    php artisan migrate --force || echo "Notice: Migrations finished with warnings."

    echo "Checking if church database needs initial seeding..."
    php artisan db:seed --force || echo "Notice: Seeding completed or skipped."
else
    echo "Warning: Database not reachable after 60s. Application will attempt to start regardless."
fi

# 6. Unganisha storage link
php artisan storage:link || true

# 7. Washa Web Server kwenye PORT ya Render
TARGET_PORT="${PORT:-10000}"
echo "====================================================="
echo "Application ready! Listening on 0.0.0.0:$TARGET_PORT"
echo "====================================================="

exec php artisan serve --host=0.0.0.0 --port="$TARGET_PORT"
