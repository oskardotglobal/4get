FROM alpine:latest
WORKDIR /var/www/html/4get

RUN apk update && apk upgrade
RUN apk add php apache2-ssl php82-fileinfo php82-openssl php82-iconv php82-common php82-dom php82-curl curl php82-pecl-apcu php82-apache2 imagemagick php82-pecl-imagick php-mbstring imagemagick-webp imagemagick-jpeg

COPY ./apache/httpd.conf /etc/apache2/httpd.conf
COPY ./apache/conf.d/ssl.conf /etc/apache2/conf.d/ssl.conf
COPY . .

RUN chmod 777 /var/www/html/4get/icons

EXPOSE 80
EXPOSE 443

CMD  ["./docker/docker-entrypoint.sh"]
