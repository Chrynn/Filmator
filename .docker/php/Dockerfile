FROM php:8.1.1-fpm-alpine3.15

USER root

# Setup user docker
RUN adduser -S docker

# Sudo
RUN apk add sudo

# Install Git
RUN apk update && apk upgrade && \
	apk add git

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install Database (MySql)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install dependencies for GD and install GD with support for jpeg, png webp and freetype
# Info about installing GD in PHP https://www.php.net/manual/en/image.installation.php
RUN apk add --no-cache \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev

# Install gd
RUN apk add zlib-dev libzip libpng libjpeg-turbo libwebp freetype libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev # since PHP 7.4 don't need to add --with-png
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install gd

# Install PHP Intl
RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

WORKDIR /srv/

USER docker
