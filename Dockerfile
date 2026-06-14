# --- Stage 1: build frontend assets ---
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build:client 2>/dev/null || npx vite build

# --- Stage 2: PHP app ---
FROM php:8.4-cli AS app

# System deps + PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libicu-dev libsqlite3-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_sqlite zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP deps first (better layer caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --optimize-autoloader

# Copy app source
COPY . .

# Copy built frontend assets from stage 1
COPY --from=frontend /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database

EXPOSE 10000

CMD php artisan migrate --force \
    && php artisan config:cache \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
