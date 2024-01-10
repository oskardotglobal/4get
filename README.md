[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/W7W2OZK5H)

# 4get
4get is a metasearch engine that doesn't suck (they live in our walls!)

# About 4get
https://4get.ca/about

# Try it out
https://4get.ca

# Totally unbiased comparison between alternatives

|                            | 4get                    | searx(ng) | librex      | araa     |
|----------------------------|-------------------------|-----------|-------------|----------|
| RAM usage                  | 200-400mb~              | 2GB~      | 200-400mb~  | 2GB~     |
| Does it suck               | no (debunked by snopes) | yes       | yes         | a little |
| Does it work               | ye                      | no        | no          | ye       |
| Did the dev commit suicide | not until my 30s        | idk       | yes         | no       |

## Supported websites
1. Web
	- DuckDuckGo
	- Brave
	- Yandex
	- Google
	- Mojeek
	- Marginalia
	- wiby

2. Images
	- DuckDuckGo
	- Yandex
	- Google
	- Brave
	- Yep
	- Imgur
	- FindThatMeme

3. Videos
	- YouTube
	- DuckDuckgo
	- Brave
	- Yandex
	- Google

4. News
	- DuckDuckGo
	- Brave
	- Google
	- Mojeek

5. Music
	- SoundCloud

6. Autocompleter
	- Brave
	- DuckDuckGo
	- Yandex
	- Google
	- Qwant
	- Yep
	- Marginalia
	- YouTube
	- SoundCloud

More scrapers are coming soon. I currently want to add HackerNews (durr orange site!!), Qwant, Yep and other garbage. A shopping, files, tab and more music scrapers are also on my todo list.

# Installation
This section is still to-do. You will need to figure shit out for some of the apache2 and nginx stuff. Everything else should be OK.

## Install on Apache

Login as root.

```sh
apt install php-mbstring apache2 certbot php-imagick imagemagick php-curl curl php-apcu git libapache2-mod-php python3-certbot-apache
service apache2 start
a2enmod rewrite
```

For all of the files in `/etc/apache2/sites-enabled/`, you must apply the following changes:
- Uncomment `ServerName` directive, put your domain name there
- Change `ServerAdmin` to your email
- Change `DocumentRoot` to `/var/www/html/4get`
- Change `ErrorLog` and `CustomLog` directives to log stuff out to `/dev/null/`

Now open `/etc/apache2/apache2.conf` and change `ErrorLog` and `CustomLog` directives to have `/dev/null/` as a value

This *should* disable logging completely, but I'm not 100% sure since I sort of had to troubleshoot alot of shit while writing this. So after we're done check if `/var/log/apache2/*` contains any personal info, and if it does, call me retarded trough email exchange.

Blindly run the following shit

```sh
cd /var/www/html
git clone https://git.lolcat.ca/lolcat/4get
cd 4get
mkdir icons
chmod 777 -R icons/
```

Restart the service for good measure... `service apache2 restart`

## Install on NGINX

Login as root.

Create a file in `/etc/nginx/sites-avaliable/` called `4get.conf` or any name you want and put this into the file:

```
server {
    # DO YOU REALLY NEED TO LOG SEARCHES?
    access_log /dev/null;
    error_log /dev/null;
    # Change this if you have 4get in other folder.
    root /var/www/4get;
    # Change yourdomain by your domain lol
    server_name www.yourdomain.com yourdomain.com;

    location @php {
        try_files $uri.php $uri/index.php =404;
                # Change the unix socket address if it's different for you.
        fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
        fastcgi_index index.php;
                # Change this to `fastcgi_params` if you use a debian based distro.
        include fastcgi.conf;
        fastcgi_intercept_errors on;
    }

    location / {
        try_files $uri @php;
    }

    location ~* ^(.*)\.php$ {
        return 301 $1;
    }

        listen 80;
}
```

That is a very basic config so you will need to adapt it to your needs in case you have a more complicated nginx configuration. Anyways, you can see a real world example [here](https://git.zzls.xyz/Fijxu/etc-configs/src/branch/selfhost/nginx/sites-available/4get.zzls.xyz.conf)

After you save the file you will need to do a symlink of the `4get.conf` file to `/etc/nignx/sites-enabled/`, you can do it with this command: 

```sh
ln -s /etc/nginx/sites-available/4get.conf /etc/nginx/sites-available/4get.conf
```

Now test the nginx config with `nginx -t`, if it says that everything is good, restart nginx using `systemctl restart nginx`

## Install using Docker (lol u lazy fuck)

```
docker run -d -p 80:80 -e FOURGET_SERVER_NAME="4get.ca" -e FOURGET_SERVER_ADMIN_EMAIL="you@example.com" luuul/4get:latest
```

...Or with SSL:
```
docker run -d -p 443:443 -e FOURGET_SERVER_NAME="4get.ca" -e FOURGET_SERVER_ADMIN_EMAIL="you@example.com" -v /etc/letsencrypt/live/domain.tld:/etc/4get/certs luuul/4get:latest
```

replace enviroment variables FOURGET_SERVER_NAME and FOURGET_SERVER_ADMIN_EMAIL with relevant values

if the certificate files are not mounted to /etc/4get/certs the service listens to port 80

the certificate directory expects files named `cert.pem`, `chain.pem`, `privkey.pem`


## Install using Docker Compose 

copy `docker-compose.yaml`

to serve custom banners create a directory named `banners` for example with images and mount to `/var/www/html/4get/banner`

to serve captcha images create a directory named `captchas` for example containing subfolders with images and mount to `/var/www/html/4get/data/captcha`

any environment variables prefixed with `FOURGET_` will be added to the generated config

the entrypoint will automatically set the `CAPTCHA_DATASET` value for you based on directory names and number of files in each


```
version: "3.7"

services:
  fourget:
    image: luuul/4get:latest
    restart: always
    environment:
      - FOURGET_SERVER_NAME=4get.ca
      - FOURGET_SERVER_ADMIN_EMAIL="you@example.com"

    ports:
      - "80:80"
      - "443:443"

    volumes:
      - /etc/letsencrypt/live/domain.tld:/etc/4get/certs
      - ./banners:/var/www/html/4get/banner
      - ./captchas:/var/www/html/4get/data/captcha
```

Replace relevant values and start with `docker compose up -d`

## Install on Caddy

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

Now since this file is located in `/etc/apache2/sites-enabled/`, you must change all of the logging shit as to make it not log anything, like we did earlier.

Restart again
```sh
service apache2 restart
```

## Encryption setup on NGINX

Generate a certificate for the domain using:

```sh
certbot --nginx --key-type ecdsa -d www.yourdomain.com -d yourdomain.com
```
(Remember to install the nginx certbot plugin!!!)

After doing that certbot should deploy the certificate automatically into your 4get nginx config file. It should be ready to use at that point.

# Jesse it is time to configure the server the fucking bots are back

Wohoo the awful piece of shit setup and fiddling with 3 gazillion files is GONE. All you need to do to configure your shit is to go in `data/config.php` and edit the self-documenting configuration file. You can also specify proxies in `data/proxies/whatever.txt` and captcha images in `data/captcha/category/1.png`... I further explain how to deal with that garbage in the config file I mentionned.

# (Optional) Tor setup

1. Install `tor`.
2. Open `/etc/tor/torrc`
3. Go to the line that contains `HiddenServiceDir` and `HiddenServicePort`
4. Uncomment those 2 lines and set them like this: 
	```
	HiddenServiceDir /var/lib/tor/4get
	HiddenServicePort 80 127.0.0.1:80
	```
5. Start the tor service using `systemctl start tor`
6. Wait some seconds...
7. Login as root and execute this command: `cat /var/lib/tor/4get/hostname`
8. That is your onion address.

After you get your onion address you will need to configure your Apache or Nginx config or you will get 404 errors.

I don't know to configure this shit on Apache so here is the NGINX one.

## Tor setup on NGINX

Open your current 4get NGINX config (that is under `/etc/nginx/sites-available/`) and append this to the end of the file:

```
server {
	access_log /dev/null;
	error_log /dev/null;

    listen 80;
    server_name <youronionaddress>;
    root /var/www/4get;

    location @php {
        try_files $uri.php $uri/index.php =404;
        # Change the unix socket address if it's different for you.
        fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
        fastcgi_index index.php;
        # Change this to `fastcgi_params` if you use a debian based distro.
        include fastcgi.conf;
        fastcgi_intercept_errors on;
    }

    location / {
        try_files $uri @php;
    }

    location ~* ^(.*)\.php$ {
        return 301 $1;
    }
}
```

Obviously replace `<youronionaddress>` by the onion address of `/var/lib/tor/4get/hostname` and then check if the nginx config is valid with `nginx -t` if yes, then restart the nginx service and try opening the onion address into the Tor Browser. You can see a real world example [here](https://git.zzls.xyz/Fijxu/etc-configs/src/branch/selfhost/nginx/sites-available/4get.zzls.xyz.conf)

# Contact
shit breaks all the time but I repair it all the time too. Email me here: will<at>lolcat(dot)ca
