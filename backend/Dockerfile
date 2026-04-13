FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl

RUN docker-php-ext-install pdo pdo_mysql mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app