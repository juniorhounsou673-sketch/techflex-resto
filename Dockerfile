# ---------- Étape 1 : compilation des assets (Vite 7 demande Node 20+) ----------
FROM node:20-alpine AS frontend

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---------- Étape 2 : application PHP ----------
FROM php:8.2-cli

# Extensions nécessaires : pdo_sqlite pour la base embarquée, pdo_mysql si tu
# branches une base MySQL plus tard.
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev libzip-dev libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .
COPY --from=frontend /app/public/build /app/public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p database storage/framework/sessions storage/framework/views \
               storage/framework/cache/data storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache database

ENV PORT=8080
EXPOSE 8080

# Au démarrage : base SQLite locale, migrations, données de démo (une seule fois)
# puis serveur HTTP sur le port fourni par Render.
CMD touch database/database.sqlite && \
    php artisan migrate --force && \
    (php artisan db:seed --force || true) && \
    (php artisan storage:link || true) && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
