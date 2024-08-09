# Sample Apache2 configuration
This is the apache2 configuration file used on the 4get.ca official instance, in hopes that it's useful to you!

Looking for the apache2 guide? <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/apache2.md">go here.</a>.

```xml
<VirtualHost *:443>
	ServerName www.4get.ca
	
	SSLEngine On
	SSLCertificateFile /etc/letsencrypt/live/4get.ca/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/4get.ca/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/4get.ca/chain.pem
	
	RedirectMatch 301 ^(.*)$ https://4get.ca$1
</VirtualHost>

<VirtualHost *:443>
	ServerName 4get.ca

	ServerAdmin will@lolcat.ca
	DocumentRoot /var/www/4get
	
	SSLEngine On
	SSLOptions +StdEnvVars
	
	#ErrorLog ${APACHE_LOG_DIR}/error.log
	
	AddOutputFilterByType DEFLATE application/json
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/css
	
	SSLCertificateFile /etc/letsencrypt/live/4get.ca/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/4get.ca/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/4get.ca/chain.pem
	
	<Directory /var/www/4get>
		Options -MultiViews
		AllowOverride All
		Require all granted
		
		RewriteEngine On
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^([^\.]+)$ $1.php [NC,L]
	</Directory>

	# deny access to private resources
	<Directory /var/www/4get/data/>
		Order Deny,allow
		Deny from all
	</Directory>
</VirtualHost>

<VirtualHost *:443>
	ServerName www.lolcat.ca
	
	SSLEngine On
	SSLCertificateFile /etc/letsencrypt/live/4get.ca/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/4get.ca/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/4get.ca/chain.pem
	
	RedirectMatch 301 ^(.*)$ https://lolcat.ca$1
</VirtualHost>

<VirtualHost *:443>
	ServerName lolcat.ca

	ServerAdmin will@lolcat.ca
	DocumentRoot /var/www/lolcat
	
	SSLEngine On
	SSLOptions +StdEnvVars	
	
	#ErrorLog ${APACHE_LOG_DIR}/error.log
	
	AddOutputFilterByType DEFLATE application/json
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/css

	SSLCertificateFile /etc/letsencrypt/live/4get.ca/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/4get.ca/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/4get.ca/chain.pem

	<Directory /var/www/lolcat>
		Options -MultiViews
		AllowOverride All
		Require all granted
		
		RewriteEngine On
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^([^\.]+)$ $1.php [NC,L]
	</Directory>
</VirtualHost>

<VirtualHost *:443>
	ServerName www.nyym.co
	
	SSLEngine On
	SSLCertificateFile /etc/letsencrypt/live/nyym.co/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/nyym.co/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/nyym.co/chain.pem
	
	RedirectMatch 301 ^(.*)$ https://nyym.co$1
</VirtualHost>

<VirtualHost *:443>
	ServerName nyym.co

	ServerAdmin will@lolcat.ca
	DocumentRoot /var/www/nyym
	
	SSLEngine On
	SSLOptions +StdEnvVars	
	
	#ErrorLog ${APACHE_LOG_DIR}/error.log
	
	AddOutputFilterByType DEFLATE application/json
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/css

	SSLCertificateFile /etc/letsencrypt/live/nyym.co/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/nyym.co/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/nyym.co/chain.pem
	
	<Directory /var/www/nyym>
		Options -MultiViews
		AllowOverride All
		Require all granted
		
		RewriteEngine On
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^([^\.]+)$ $1.php [NC,L]
	</Directory>
</VirtualHost>

<VirtualHost *:443>
	ServerName git.lolcat.ca

	SSLEngine On
	SSLOptions +StdEnvVars	
	
	#ErrorLog ${APACHE_LOG_DIR}/error.log
	
	AddOutputFilterByType DEFLATE application/json
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/css

	SSLCertificateFile /etc/letsencrypt/live/4get.ca/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/4get.ca/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/4get.ca/chain.pem

	ProxyPreserveHost On
	ProxyRequests off
	AllowEncodedSlashes NoDecode
	ProxyPass / http://localhost:3000/ nocanon
</VirtualHost>

<VirtualHost *:443>
	ServerName live.lolcat.ca

	ServerAdmin will@lolcat.ca
	DocumentRoot /var/www/live
	
	SSLEngine On
	SSLOptions +StdEnvVars	
	
	#ErrorLog ${APACHE_LOG_DIR}/error.log
	
	AddOutputFilterByType DEFLATE application/json
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/css

	SSLCertificateFile /etc/letsencrypt/live/4get.ca/fullchain.pem
	SSLCertificateKeyFile /etc/letsencrypt/live/4get.ca/privkey.pem
	SSLCertificateChainFile /etc/letsencrypt/live/4get.ca/chain.pem
</VirtualHost>
```
