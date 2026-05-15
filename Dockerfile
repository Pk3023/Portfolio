FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libgmp-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring xml bcmath intl gmp

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
RUN cp .env.example .env
RUN touch database/database.sqlite
RUN php artisan key:generate --force
RUN php artisan storage:link
RUN php artisan migrate --force
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 9000
CMD ["php-fpm"]
