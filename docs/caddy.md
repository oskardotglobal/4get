# Install guide for Caddy webserver

1. Install dependencies:

`sudo apt install caddy php8.2-dom php8.2-imagick imagemagick php8.2-curl curl php8.2-apcu git`

2. Clone this repository where you want to host this from:

`cd /var/www && sudo git clone https://git.konakona.moe/diowo/4get`

3. Set permission on the `icons` directory inside `4get`

`cd /var/www/4get/ && sudo chmod 777 -R icons/`

4. Add an entry for 4get on your Caddyfile at `/etc/caddy/Caddyfile`

```sh
4get.konakona.moe {
    root * /var/www/4get
    file_server
    encode gzip
    php_fastcgi unix//var/run/php/php8.2-fpm.sock {
        index index.php
    }
    redir /{path}.php{query} 301
    try_files {path} {path}.php
}
```

Caddy deals with SSL certificates automatically so you don't have to mess with anything. Also if needed, a sample of my Caddyfile can be found [here](https://git.konakona.moe/diowo/misc/src/branch/master/etc/caddy/Caddyfile).

5. Restart Caddy

`sudo systemctl restart caddy`

# Encryption setup
I'm schizoid (as you should) so I'm gonna setup 4096bit key encryption. To complete this step, you need a domain or subdomain in your possession. Make sure that the DNS shit for your domain has propagated properly before continuing, because certbot is a piece of shit that will error out the ass once you reach 5 attempts under an hour.

## Encryption setup on Apache

```sh
certbot --apache --rsa-key-size 4096 -d www.yourdomain.com -d yourdomain.com
```
When it asks to choose a vhost, choose the option with "HTTPS" listed. Don't setup HTTPS for tor, we don't need it (it doesn't even work anyways with let's encrypt)

Edit `000-default-le-ssl.conf`

Add this at the end:
```xml
<Directory /var/www/html/4get>
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME}.php -f
	RewriteRule (.*) $1.php [L]
	Options Indexes FollowSymLinks
	AllowOverride All
	Require all granted
</Directory>
```
