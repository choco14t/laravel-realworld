FROM php:7.4-fpm-alpine

RUN apk update && \
    apk add --no-cache autoconf build-base && \
    docker-php-ext-install pdo_mysql && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod 777 /usr/local/bin/composer

WORKDIR /var/www/html
