FROM php:8.1-fpm as php

RUN apt-get update && apt-get install -y \
    git \
    libc6-dev \
    libsasl2-dev \
    libsasl2-modules \
    libssl-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

ENTRYPOINT [ "docker/entrypoint.sh" ]
