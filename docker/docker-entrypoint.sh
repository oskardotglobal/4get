#!/bin/sh
set -e
if [ ! -f /etc/4get/certs/fullchain.pem ] || [ ! -f /etc/4get/certs/privkey.pem ]; then
        echo "Using http configuration"
        cp /etc/apache2/http.conf /etc/apache2/httpd.conf
else
        echo "Using https configuration"
        cp /etc/apache2/https.conf /etc/apache2/httpd.conf
fi

php82 ./docker/gen_config.php


echo "4get is running"
exec httpd -DFOREGROUND

