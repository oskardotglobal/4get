[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/W7W2OZK5H)

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
	- Yandex
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
	- DuckDuckgo
	- Brave
	- Yandex

4. News
	- DuckDuckGo
	- Brave
	- Google
	- Mojeek

5. Music
	- SoundCloud

More scrapers are coming soon. I currently want to add Google web/video/news search, HackerNews (durr orange site!!) and Qwant. A shopping and files tab is also in my todo list.

# Setup
This section is still to-do. You will need to figure shit out for some of the apache2 and nginx stuff. Everything else should be OK.

## Apache

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

## NGINX

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

## Setup encryption
I'm schizoid (as you should) so I'm gonna setup 4096bit key encryption. To complete this step, you need a domain or subdomain in your possession. Make sure that the DNS shit for your domain has propagated properly before continuing, because certbot is a piece of shit that will error out the ass once you reach 5 attempts under an hour.

### Apache

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

### NGINX

Generate a certificate for the domain using:

```sh
certbot --nginx --key-type ecdsa -d www.yourdomain.com -d yourdomain.com
```
(Remember to install the nginx certbot plugin!!!)

After doing that certbot should deploy the certificate automatically into your 4get nginx config file. It should be ready to use at that point.

Ok bye!!!

## Tor Setup

1. Install tor.
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

### NGINX

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

## Docker Install

```
docker run -d -p 80:80 -p 443:443 -e FOURGET_SERVER_NAME="4get.ca" -e FOURGET_SERVER_ADMIN_EMAIL="you@example.com" -v /etc/letsencrypt/live/domain.tld:/etc/4get/certs luuul/4get:1.0.0
```

replace enviroment variables FOURGET_SERVER_NAME and FOURGET_SERVER_ADMIN_EMAIL with relevant values

the certs directory expects files named `cert.pem`, `chain.pem`, `privkey.pem`

## Docker compose 

copy `docker-compose.yaml`

create a directory with images named `banners` for example and mount to `/var/www/html/4get/banner`
to serve custom banners

```
version: "3.7"

services:
  fourget:
    image: luuul/4get:1.0.0
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
```

Replace relevant values and start with `docker-compose up -d`

