FROM php:8.2-fpm-alpine
WORKDIR /srv

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions apcu imagick opcache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY . .
RUN chown -R "$(whoami)" /srv
RUN chmod -R 777 /srv/icons

ENV FOURGET_PROTO=http
