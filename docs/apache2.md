# Install guide for Apache2 webserver
Welcome to the new and revamped 4get install manual for apache2. Even if you already have services running on an existing installation of apache2, you should still be able to adapt this guide to your needs.

For starters, login as `root`.

Then, install the following dependencies:
```sh
apt update
apt upgrade
apt install php-mbstring apache2 certbot php-imagick imagemagick php-curl curl php-apcu git libapache2-mod-php
```

Enable the required modules:
```sh
a2enmod ssl
a2enmod rewrite
```

And enable these optional ones, which might be useful to you later on. The `proxy` module is useful for setting up reverse proxies to services like gitea, and `headers` is useful to tweak global header values:
```sh
a2enmod proxy
a2enmod headers
```

Now, restart apache2:
```sh
service apache2 restart
```

Just for good measure, please check if your webserver is running. Access it through HTTP, not HTTPS. You should see the apache2 default landing page.

## 000-default.conf
Now, edit the following file: `/etc/apache2/sites-available/000-default.conf`, remove everything and carefully add each rule specified here, while making sure to replace my domains with your own:

1. The `VirtualHost` here instructs apache2 to redirect all **HTTP** traffic that specify an unknown `Host` header be redirected to a specific domain of your choice. Configuring this is not required but highly recommended.
```xml
<VirtualHost *:80>
	# no domain = go to 4get.ca
	RedirectMatch 301 ^(.*)$ https://4get.ca$1
</VirtualHost>
```

2. This instruction tells apache2 to redirect all HTTP traffic on `Host` lolcat.ca to the HTTPS version of the site. You should add a rule like this for all of your services explicitly.
```xml
<VirtualHost *:80>
	ServerName lolcat.ca
	RedirectMatch 301 ^(.*)$ https://lolcat.ca$1
</VirtualHost>
```

3. Subdomains won't be matched by the above rule, so I recommend you also add them to be more explicit:
```xml
<VirtualHost *:80>
	ServerName www.lolcat.ca
	RedirectMatch 301 ^(.*)$ https://lolcat.ca$1
</VirtualHost>
```

... Etc, for every service you own.

4. And finally, append this configuration if you wish to host a tor or i2p access point. This configuration should not be binded to SSL(443) as Let's Encrypt does not let you create certificates for onion sites:
```xml
<VirtualHost *:80>
	# tor site
	ServerName 4getwebfrq5zr4sxugk6htxvawqehxtdgjrbcn2oslllcol2vepa23yd.onion

	# compress
	AddOutputFilterByType DEFLATE application/json
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/css

	DocumentRoot /var/www/4get

	Options +MultiViews
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule ^([^\.]+)$ $1.php [NC,L]

	# deny access to private resources
	<Directory /var/www/4get/data/>
		Order Deny,allow
		Deny from all
	</Directory>
</VirtualHost>
```
To make the above snippet work, please refer to our <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/tor.md">tor site guide</a>.

## default-ssl.conf
Now, edit the file `/etc/apache2/sites-available/default-ssl.conf`, remove everything and, again, add each rule while modifying the relevant fields:

This ruleset will redirect all clients that specify an unknown `Host` to the domain of our choice. I recommend you uncomment the `ErrorLog` directive while setting things up in case a problem occurs with PHP. Don't worry about the invalid SSL paths, we will generate our certificates later; Just make sure you specify the right domains in there:
```xml
<VirtualHost *:443>
	RedirectMatch 301 ^(.*)$ https://4get.ca$1
	ServerAdmin will@lolcat.ca

	#ErrorLog ${APACHE_LOG_DIR}/error.log

	SSLEngine on

	<FilesMatch "\.(?:cgi|shtml|phtml|php)$">
		SSLOptions +StdEnvVars
	</FilesMatch>
	<Directory /usr/lib/cgi-bin>
		SSLOptions +StdEnvVars
	</Directory>

	AddOutputFilterByType DEFLATE application/json
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/css

	SSLCertificateFile /etc/letsencrypt/live/4get.ca/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/4get.ca/privkey.pem
</VirtualHost>
```

This ruleset tells apache2 where 4get is located (`/var/www/4get`), ensures that `4get.ca/settings` resolves to `4get.ca/settings.php` internally and that we deny access to `/data/*`, which may contain files you might want to keep private.
```xml
<VirtualHost *:443>
	ServerName 4get.ca

	DocumentRoot /var/www/4get

	Options +MultiViews
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule ^([^\.]+)$ $1.php [NC,L]

	# deny access to private resources
	<Directory /var/www/4get/data/>
		Order Deny,allow
		Deny from all
	</Directory>
</VirtualHost>
```

Don't forget to specify your other services here! Here's an example of a ruleset I use for `lolcat.ca`:
```xml
<VirtualHost *:443>
	ServerName lolcat.ca

	DocumentRoot /var/www/lolcat

	Options +MultiViews
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule ^([^\.]+)$ $1.php [NC,L]
</VirtualHost>
```

... Alongside with it's redirect rules.
```xml
<VirtualHost *:443>
	ServerName www.lolcat.ca
	RedirectMatch 301 ^(.*)$ https://lolcat.ca$1
</VirtualHost>
```

## security.conf
If you enabled the `headers` module, you can head over to `/etc/apache2/conf-enabled/security.conf` and edit:
```sh
ServerTokens Prod # instead off Full
```
and
```sh
ServerSignature Off #instead of On
```
This will ensure that the `Server` header apache2 returns is minimal and doesn't leak information like your host system's OS or apache2 version.

You can also uncomment `Header set X-Content-Type-Options: "nosniff"` and `Header set Content-Security-Policy "frame-ancestors 'self';"` respectively.

## charset.conf
Head over to `/etc/apache2/conf-enabled/charset.conf` and uncomment `AddDefaultCharset UTF-8`.

## other-vhost-access-log.conf
Since none of our configuration files contains any `CustomLog` directives, all we need to do to disable logging entirely is comment out the `CustomLog` directive located in `/etc/apache2/conf-enabled/other-vhost-access-log.conf`. Only error logs will remain if you configured them.

# Setup SSL
Great, now we've configured the webserver, but we still don't have our security certificate. Let's generate one!

First, stop `apache2`. 
```sh
service apache2 stop
```

Now, run `certbot`, and specify all of your domains by prepending `-d` every time. Make sure the first domain you specify is your main domain, and the same domain you specified in the configuration above! We use ECDSA encryption here as it's better than RSA.
```sh
certbot certonly --standalone --key-type ecdsa -d 4get.ca -d www.4get.ca -d lolcat.ca -d www.lolcat.ca
```

Certbot should ask you a few questions, just play along. At the end of the setup, certbot should tell you about the location of the certificates. Double check to make sure they correspond to the paths we specified in `default-ssl.conf`. Your certificates should now update every 2-3 months automatically.

After this is complete, create a directory in `/var/www/4get`.

Now, start `apache2`.
```sh
service apache2 start
```

Congratulations! You now have a... 404 error on your webserver, if everything went well. Now's the time to make sure all of our redirect rules work!

# Import the fun junk
Run these commands:
```
cd /var/www/4get
git clone https://git.lolcat.ca/lolcat/4get
chmod 777 -R icons/
```

... And try accessing your webserver. You should now have a working 4get instance!

Please make sure to check out how to further <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/configure.md">configure 4get</a> to your liking!
