FROM alpine:latest
WORKDIR /var/www/html/4get

RUN apk update && apk upgrade
RUN apk add php apache2-ssl php83-fileinfo php83-openssl php83-iconv php83-common php83-dom php83-sodium php83-curl curl php83-pecl-apcu php83-apache2 imagemagick php83-pecl-imagick php-mbstring imagemagick-webp imagemagick-jpeg

COPY ./docker/apache/ /etc/apache2/
COPY . .

RUN chmod 777 /var/www/html/4get/icons

EXPOSE 80
EXPOSE 443

ENV FOURGET_PROTO=http

CMD  ["./docker/docker-entrypoint.sh"]
