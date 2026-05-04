FROM php:8.2-cli

# System dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    libsqlite3-dev libzip-dev libonig-dev libxml2-dev unzip curl git \
    && docker-php-ext-install pdo pdo_sqlite mbstring xml zip bcmath fileinfo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Install dependencies & build frontend
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
RUN npm install && npm run build

# Permissions
RUN chmod -R 775 storage bootstrap/cache && chmod +x start.sh

EXPOSE 8080

CMD ["/bin/bash", "start.sh"]
