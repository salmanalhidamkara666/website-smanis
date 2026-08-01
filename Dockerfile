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
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath intl sockets xml zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
RUN php -r 'if (!file_exists(".env")) copy(".env.example", ".env");'
RUN php -r '$env = file_get_contents(".env"); $env = preg_replace("/^APP_URL=.*/m", "APP_URL=https://website-smanis.onrender.com", $env); $env = preg_replace("/^DB_CONNECTION=.*/m", "DB_CONNECTION=sqlite", $env); $env = preg_replace("/^DB_DATABASE=.*/m", "DB_DATABASE=/var/www/html/database/database.sqlite", $env); file_put_contents(".env", $env);'
RUN mkdir -p database && touch database/database.sqlite
RUN composer install --prefer-dist --no-interaction --optimize-autoloader
# Do not run artisan commands that require DB during image build.
# Migrations and key generation will be executed during the Render build/start phases.

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port $PORT
