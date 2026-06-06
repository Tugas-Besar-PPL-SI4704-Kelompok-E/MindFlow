# ── Stage 1: Build frontend assets ──
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ── Stage 2: PHP application ──
FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the application
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=frontend /app/public/build public/build

# Run composer post-install scripts
RUN composer run-script post-autoload-dump

# Set permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Cache config & routes for performance
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose port (Render uses $PORT env variable)
EXPOSE 8000

# Start the application
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
