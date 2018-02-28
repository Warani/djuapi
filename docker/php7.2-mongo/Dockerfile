FROM php:7.2-fpm-alpine3.7

RUN apk update && apk add autoconf && \
apk add gcc make libc-dev curl php7-opcache php7-apcu

RUN pecl install mongodb && \
echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer --version

RUN apk del gcc make libc-dev curl

RUN cp /etc/php7/conf.d/00_opcache.ini /usr/local/etc/php/conf.d/
