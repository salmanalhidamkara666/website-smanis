FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite sqlite3 mbstring exif pcntl bcmath intl sockets xml zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
RUN composer install --prefer-dist --no-interaction --optimize-autoloader
RUN mkdir -p storage bootstrap/cache database
RUN chmod -R 0777 storage bootstrap/cache database || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port $PORT
