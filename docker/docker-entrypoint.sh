#!/bin/sh
set -e
sed -i "s/ServerName.*/ServerName ${FOURGET_SERVER_NAME}/g" /etc/apache2/httpd.conf
sed -i "s/ServerAdmin.*/ServerAdmin ${FOURGET_SERVER_ADMIN_EMAIL}/g" /etc/apache2/httpd.conf

if [ ! -f /etc/4get/certs/cert.pem ] || [ ! -f /etc/4get/certs/chain.pem ] || [ ! -f /etc/4get/certs/privkey.pem ]; then
        # remove SSL VirtualHost
        echo "No certificate files detected. Listening on port 80"
        sed -i '/<VirtualHost \*:443>/,/<\/VirtualHost>/d' /etc/apache2/httpd.conf

        # prepend Listen 80 to /apache2/httpd.conf
        echo "Listen 80" > /etc/apache2/httpd.conf_temp
        cat /etc/apache2/httpd.conf >> /etc/apache2/httpd.conf_temp
        mv /etc/apache2/httpd.conf_temp /etc/apache2/httpd.conf
fi


php82 ./docker/gen_config.php


echo "4get is running"
exec httpd -DFOREGROUND

