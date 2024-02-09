FROM alpine:latest
WORKDIR /var/www/html/4get

RUN apk update && apk upgrade
RUN apk add php apache2-ssl php82-fileinfo php82-openssl php82-iconv php82-common php82-dom php82-curl curl php82-pecl-apcu php82-apache2 imagemagick php82-pecl-imagick php-mbstring imagemagick-webp imagemagick-jpeg

COPY ./docker/apache/ /etc/apache2/
COPY . .

RUN chmod 777 /var/www/html/4get/icons

EXPOSE 80
EXPOSE 443

CMD  ["./docker/docker-entrypoint.sh"]
