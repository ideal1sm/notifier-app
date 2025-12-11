FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zlib1g-dev librabbitmq-dev \
    && docker-php-ext-install intl opcache zip pdo_pgsql

RUN pecl install amqp \
    && docker-php-ext-enable amqp

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --prefer-dist --no-scripts
