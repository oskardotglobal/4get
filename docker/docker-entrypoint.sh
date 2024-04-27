#!/bin/sh
set -e

# remove quotes from variable if present
FOURGET_PROTO="${FOURGET_PROTO%\"}"
FOURGET_PROTO="${FOURGET_PROTO#\"}"

# make lowercase
FOURGET_PROTO=`echo $FOURGET_PROTO | awk '{print tolower($0)}'`


if [ "$FOURGET_PROTO" = "https" ]; then
        echo "Using https configuration"
        cp /etc/apache2/https.conf /etc/apache2/httpd.conf
else
        echo "Using http configuration"
        cp /etc/apache2/http.conf /etc/apache2/httpd.conf
fi

php ./docker/gen_config.php


echo "4get is running"
exec httpd -DFOREGROUND

