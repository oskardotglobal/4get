# Install on NGINX

>I do NOT recommend following this guide, only follow this if you *really* need to use nginx. I recommend you use the apache2 steps instead.

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

# Encryption setup

Generate a certificate for the domain using:

```sh
certbot --nginx --key-type ecdsa -d www.yourdomain.com -d yourdomain.com
```
(Remember to install the nginx certbot plugin!!!)

After doing that certbot should deploy the certificate automatically into your 4get nginx config file. It should be ready to use at that point.

# Tor setup on NGINX

Important Note: Tor onion addresses are significantly longer than traditional domain names. Before proceeding with Nginx configuration, ensure you increase the `server_names_hash_bucket_size` value in your `nginx.conf` file. This setting in your Nginx configuration controls the internal data structure used to manage multiple server names (hostnames) associated with your web server. Each hostname requires a certain amount of memory within this structure. If the size is insufficient, Nginx will encounter errors.

1. Open your `nginx.conf` file (that is under `/etc/nginx/nginx.conf`).
2. Find the line containing `# server_names_hash_bucket_size 64;`.
3. Uncomment the line and adjust the value. Start with 64, but if you encounter issues, incrementally increase it (e.g., 128, 256) until it accommodates your configuration.

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

Once you did the above, refer to <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/tor.md">this tor guide</a> to setup your onionsite.
