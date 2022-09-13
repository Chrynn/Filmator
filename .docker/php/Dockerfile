FROM php:8.1.1-fpm-alpine3.15

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

# As of PHP 7.4 we don't need to add --with-png
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd

# Install PHP Intl
RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

WORKDIR /srv/
