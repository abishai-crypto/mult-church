FROM php:8.2-fpm-alpine

# Install system dependencies and build libraries for MySQL, PostgreSQL, and SQLite
RUN apk update && apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    postgresql-dev \
    sqlite-dev \
    bash

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy all project files
COPY . .

# Install production PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Prepare permissions and make entrypoint executable
RUN chmod +x /var/www/docker-entrypoint.sh \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Default port for Render is 10000
ENV PORT=10000
EXPOSE 10000 80 8000

# Start with entrypoint script
ENTRYPOINT ["/var/www/docker-entrypoint.sh"]
