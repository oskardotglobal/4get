# 4get
4get is a metasearch engine that doesn't suck (they live in our walls!)

## About 4get
https://4get.ca/about

## Try it out
https://4get.ca

## Supported websites
1. Web
	- DuckDuckGo
	- Brave
	- Google
	- Mojeek
	- Marginalia
	- wiby

2. Images
	- DuckDuckGo
	- Yandex
	- Google
	- Brave

3. Videos
	- YouTube
	- Facebook videos
	- DuckDuckgo
	- Brave
	- Google

4. News
	- DuckDuckGo
	- Brave
	- Google
	- Mojeek

More scrapers are coming soon. I currently want to add Hackernews, Qwant and find a way to scrape Yandex web without those fucking captchas. A shopping, music and files tab is also in my todo list.

# Setup
This section is still to-do. You will need to figure shit out for some of the apache2 stuff. Everything else should be OK.

Login as root.

```sh
apt install apache2 certbot php-dom php-imagick imagemagick php-curl curl php-apcu git libapache2-mod-php python3-certbot-apache
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

## Setup encryption
I'm schizoid (as you should) so I'm gonna setup 4096bit key encryption. To complete this step, you need a domain or subdomain in your possession. Make sure that the DNS shit for your domain has propagated properly before continuing, because certbot is a piece of shit that will error out the ass once you reach 5 attempts under an hour.

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

You'll probably want to setup a tor address at this point, but I'm too lazy to put instructions here.

Ok bye!!!



## Docker Install

```
git clone https://git.lolcat.ca/lolcat/4get
cd 4get
docker build -t 4get .
docker run -d -p 80:80 -p 443:443 -e FOURGET_SERVER_NAME="4get.ca" -e FOURGET_SERVER_ADMIN_EMAIL="you@example.com" -v /etc/letsencrypt/live/domain.tld:/etc/4get/certs 4get
```

replace enviroment variables FOURGET_SERVER_NAME and FOURGET_SERVER_ADMIN_EMAIL with relevant values

the certs directory expects files named `cert.pem`, `chain.pem`, `privkey.pem`


