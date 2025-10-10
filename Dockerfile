# ==============================
# 🐘 Backend (Laravel + PHP)
# ==============================
FROM php:8.4-fpm-bullseye AS backend

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files first (cache)
COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-interaction --prefer-dist

# Copy the rest of the app
COPY . .

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 9000

# ==============================
# 🎨 Frontend (Vite + Vue 3)
# ==============================
FROM node:20-alpine AS frontend

WORKDIR /app

# Copy package files first (cache)
COPY package.json package-lock.json* ./

RUN npm install --legacy-peer-deps

# Copy frontend files
COPY resources ./resources
COPY vite.config.js ./
COPY tsconfig.json* ./
COPY tailwind.config.js* ./
COPY postcss.config.js* ./
COPY .env ./

EXPOSE 5173

CMD ["npm", "run", "dev"]
