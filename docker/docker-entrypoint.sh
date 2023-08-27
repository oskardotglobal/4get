#!/bin/sh
set -e
sed -i "s/ServerName.*/ServerName ${FOURGET_SERVER_NAME}/g" /etc/apache2/httpd.conf
sed -i "s/ServerAdmin.*/ServerAdmin ${FOURGET_SERVER_ADMIN_EMAIL}/g" /etc/apache2/httpd.conf
exec httpd -DFOREGROUND
