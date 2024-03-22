#!/bin/sh
set -e

# remove quotes from variable if present
FOURGET_PROTO="${FOURGET_PROTO%\"}"
FOURGET_PROTO="${FOURGET_PROTO#\"}"

if [ "$FOURGET_PROTO" = "https" ] || [ -f /etc/4get/certs/fullchain.pem ] || [ -f /etc/4get/certs/privkey.pem ]; then
        echo "Using https configuration"
        cp /etc/apache2/https.conf /etc/apache2/httpd.conf
else
        echo "Using http configuration"
        cp /etc/apache2/http.conf /etc/apache2/httpd.conf
fi

php ./docker/gen_config.php


echo "4get is running"
exec httpd -DFOREGROUND

