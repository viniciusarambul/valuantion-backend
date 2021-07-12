FROM php:7.4.0RC3-fpm-alpine3.10

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apk add --no-cache --update --virtual buildDeps gcc g++ make autoconf \
    && pecl install xdebug \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable xdebug \
    && apk del buildDeps

RUN set -ex \
  && apk --no-cache add \
    mysql-dev

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install mysql pdo pdo_mysql

RUN composer global require fzaninotto/faker:^1.4 mockery/mockery:^1.0 phpunit/phpunit:^8 squizlabs/php_codesniffer:^3.5.3 

WORKDIR /code