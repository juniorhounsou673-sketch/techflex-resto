FROM php:8.2-cli

# Dépendances système + extensions PHP nécessaires pour Laravel + MySQL
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copier tout le code
COPY . .

# Installer les dépendances PHP (production)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Installer les dépendances JS et builder les assets (Vite/Tailwind)
RUN npm install && npm run build

# Permissions Laravel (storage / cache)
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Au démarrage : migrer la base puis lancer le serveur
CMD php artisan config:clear && \
    echo "Config nettoyée" && \
    sleep 10 && \
    echo "Tentative de connexion a la base..." && \
    php artisan migrate --force && \
    echo "Migration terminée" && \
    echo "Démarrage du serveur sur le port $PORT" && \
    php artisan serve --host=0.0.0.0 --port=$PORT
