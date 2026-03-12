# Use official PHP 8.2 image (Railway can pull this; avoids FrankenPHP)
FROM php:8.2-cli-bookworm

# Install system deps + PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy app files
COPY . .

# Install PHP deps (no dev for production)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node for Vite build, then build assets
RUN apt-get update && apt-get install -y nodejs npm \
    && npm ci && npm run build \
    && apt-get purge -y nodejs npm && apt-get autoremove -y && apt-get clean

# Writable dirs for Laravel
RUN chmod -R 775 storage bootstrap/cache

# Prepare Laravel (no .env in image; set at runtime)
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Run on PORT (Railway sets this); run migrations then start server
EXPOSE 8000
CMD sh -c 'php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}'
