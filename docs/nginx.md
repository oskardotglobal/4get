<h1 align=center>Installation of 4get in NGINX</h1>

<div align=right>

> NOTE: As the previous version stated, it is better to follow the <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/apache2.md">Apache2 guide</a> instead of the Nginx one.

> NOTE: This is going to guess that you're using either a <abbr title="(Arch Linux, Artix Linux, Endeavouros, etc...) ">Arch-based system</abbr> or a <abbr title="(Debian, Ubuntu, Devuan, etc...)">Debian-based system</abbr>, although you can still follow it with minor issues.

</div>

1. Login as root.
2. Upgrade your system:
   * On Arch-based, run `pacman -Syu`.
   * On Debian-based, run `apt update`, then `apt upgrade`.
3. Install the following dependencies:
   * `git`: So you can clone <a href="https://git.lolcat.ca/lolcat/4get">this</a> repository.
   * `nginx`: So you can run Nginx.
   * `php-fpm`: This is what allows Nginx to run *(and show)* PHP files.
   * `php-imagick`, `imagemagick`: Image manipulation.
   * `php-apcu`: Caching module.
   * `php-curl`, `curl`:  Transferring data with URLs.
   * `php-mbstring`: String utils.
   * `certbot`, `certbot-nginx`: ACME client. Used to create SSL certificates.
     * In Arch-based distributions:
       * `pacman -S nginx certbot php-imagick certbot-nginx imagemagick curl php-apcu git`
     * In Debian-based distributions:
       * `apt install php-mbstring nginx certbot-nginx certbot php-imagick imagemagick php-curl curl php-apcu git`

<div align=right>

> IMPORTANT: `php-curl`, `php-mbstring` might be a Debian-only package, but this needs further fact checking.

> IMPORTANT: If having issues with `php-apcu` or `libsodium`, go to [^1].

</div>

4. `cd` to `/etc/nginx` and make the `conf.d/` directory if it doesn't exist:
   * Again, this guesses you're logged in as root.
   ```sh
   cd /etc/nginx
   ls -l conf.d/ # If ls shows conf.d, then it means it exists.
   # If it does not, run:
   mkdir conf.d
   ```
5. Make a file inside `conf.d/` called `4get.conf` and place the following content:
   * First run `touch conf.d/4get.conf` then `nano conf.d/4get.conf` to open the nano editor: *(Install it if it is not, or use another editor.)*
    ```sh
    server {
        access_log /dev/null; # Search log file. Do you really need to?
        error_log /dev/null;  # Error log file.

        # Change this if you have 4get in another folder.
        root /var/www/4get;
        # Change 'yourdomain' to your domain.
        server_name www.yourdomain.com yourdomain.com;
        # Port to listen to.
        listen 80;

        location @php {
            try_files $uri.php $uri/index.php =404;
            # Change the unix socket address if it's different for you.
            fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
            fastcgi_index index.php;
            # Change this to `fastcgi_params` if you use a debian based distribution.
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
    * The above is a very basic configuration and thus will need tweaking to your personal needs. It should still work as-is, though. A 'real world' example is present in [^2].
    * After saving the file, check that the `nginx.conf` file inside the main directory includes files inside `conf.d/`:
      * It should be inside the the http block: *(The following is an example! Don't just Copy and Paste it!)*
      ```sh
      http {
        include       mime.types;
        include       conf.d/*.conf; 
        types_hash_max_size 4096;
        # ...
      }
      ```
    * Now, test your configuration with `nginx -t`, if it says that everything is good, restart *(or start)* the Nginx daemon:
      * This depends on the init manager, most distributions use `systemd`, but it's better practice to include most.
      ```sh
      # systemd
      systemctl stop nginx
      systemctl start nginxt
      # or
      systemctl restart nginx

      # openrc
      rc-service nginx stop
      rc-service nginx start
      # or
      rc-service nginx restart

      # runit
      sv down nginx
      sv up nginx
      # or
      sv restart nginx

      # s6
      s6-rc -d change nginx
      s6-rc -u change nginx
      # or
      s6-svc -r /run/service/nginx

      # dinit
      dinitctl stop nginx
      dinitctl start nginx
      # or
      dinitctl restart nginx
      ```
6. Clone the repository to `/var/www`:
   * `git clone --depth 1 https://git.lolcat.ca/lolcat/4get 4get` - It clones the repository with the depth of one commit *(so it takes less time to download)* and saves the cloned repository as '4get'.
7. That should be it! There are some extra steps you can take, but it really just depends on you.

<h2 align=center>Encryption setup</h2>

1. Generate a certificate for the domain you're using with:
   * Note that `certbot-nginx` is needed.
    ```sh
    certbot --nginx --key-type ecdsa -d www.yourdomain.com -d yourdomain.com
    ```
2. After that, certbot will deploy the certificate automatically to your 4get conf file; It should be ready to use from there.

<h2 align=center>Tor Setup</h2>

<div align=right>

> IMPORTANT: Tor onion addresses are very long compared to traditional domains, so, Before doing anything, edit `nginx.conf` and increase <abbr title="This setting in your Nginx configuration controls the internal data structure used to manage multiple server names (hostnames) associated with your web server. Each hostname requires a certain amount of memory within this structure. If the size is insufficient, Nginx will encounter errors."><code>server_names_hash_bucket_size</code></abbr> to your needs.

</div>

1. `cd` to `/etc/nginx` *(if you haven't)* and open your `nginx.conf` file.
2. Find the line containing `# server_names_hash_bucket_size 64;` inside said file.
3. Uncomment the line and adjust the value; start with 64, but if you encounter issues, incrementally increase it *(e.g., 128, 256)* until it accommodates your configuration.
4. Open *(or duplicate the configuration)* and edit it:
   * Example configuration, again:
    ```sh
    server {
        access_log /dev/null; # Search log file. Do you really need to?
        error_log /dev/null;  # Error log file.

        # Change this if you have 4get in another folder.
        root /var/www/4get;
        # Change 'onionadress.onion' to your onion link.
        server_name onionadress.onion;
        # Port to listen to.
        listen 80;

        location @php {
            try_files $uri.php $uri/index.php =404;
            # Change the unix socket address if it's different for you.
            fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
            fastcgi_index index.php;
            # Change this to `fastcgi_params` if you use a debian based distribution.
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
    A real world example is present in [^2].
5. Once done, check the configuration with `nginx -t`. If everything's fine and dandy, refer to <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/tor.md">the Tor guide</a> to setup your onion site.

<h2 align=center>Other important things</h2>

1. <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/configure.md">Configuration guide</a>: Things to do after setup.
2. <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/apache2.md">Apache2 guide</a>: Fallback to this if you couldn't get something to work, or you don't know something.

<h2 align=center>Known issues</h2>

1. https://git.lolcat.ca/lolcat/4get/issues

[^1]: lolcat/4get#40, If having issues with `libsodium`, or `php-apcu`.
[^2]: <a href="https://git.nadeko.net/Fijxu/etc-configs/src/branch/selfhost/nginx/conf.d/4get.conf">git.nadeko.net</a> nadeko.net's 4get instance configuration.