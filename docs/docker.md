#### Install guide for Docker

When using docker container any environment variables prefixed with `FOURGET_` will be added to the generated config located at `/var/www/html/4get/data/config.php`

When lists of data is expected in [data/config.php](../data/config.php), such as `INSTANCES`, you can pass in a comma separated string via environment variable. 

Example:
`FOURGET_INSTANCES="https://4get.ca,https://domain.tld"`

#### Special environment variables

| Name              | value                          | Example                              |
| -                 | -                              | -                                    |
| FOURGET_PROTO     | "http" or "https"              | "https"                              |


#### Important directories

| Mountpoint                      | Description               |
| -                               | -                         |
| /etc/4get/certs                 | SSL certificate directory |
| /var/www/html/4get/banner       | Custom Banners directory  |
| /var/www/html/4get/data/captcha | Captcha dataset           |


the certificate directory `/etc/4get/certs` expects files named `fullchain.pem` and `privkey.pem`

The captcha dataset should have a subdirectory for each category. In each category, images should be named from 1.png to X.png, and be 100x100 in size.

example directory structure:

```
captcha/
  birds/
    1.png
    2.png
    3.png
 anime/
    1.png
    2.png
```

For more information on configuration view [data/config.php](../data/config.php)

#### Usage

You can start 4get with

```
docker run -d -p 80:80 -e FOURGET_SERVER_NAME="4get.ca" -e FOURGET_PROTO="http" luuul/4get:latest
```

...Or with SSL:

```
docker run -d -p 443:443 -e FOURGET_SERVER_NAME="4get.ca" -e FOURGET_PROTO="https" -v /etc/letsencrypt/live/domain.tld:/etc/4get/certs  luuul/4get:latest
```


#### With Docker Compose

Replace relevant values and start with `docker compose up -d`

##### HTTP

```
# docker-compose.yaml
version: "3.7"

services:
  fourget:
    image: luuul/4get:latest
    restart: unless-stopped
    environment:
      - FOURGET_PROTO=http
      - FOURGET_SERVER_NAME=4get.ca

    ports:
      - "80:80"
```

##### HTTPS

```
# docker-compose.yaml
version: "3.7"

services:
  fourget:
    image: luuul/4get:latest
    restart: unless-stopped
    environment:
      - FOURGET_PROTO=https
      - FOURGET_SERVER_NAME=4get.ca

    ports:
      - "80:80"
      - "443:443"
      
    volumes:
      - /etc/letsencrypt/live/domain.tld:/etc/4get/certs
```

##### Captcha Enabled

Set `FOURGET_BOT_PROTECTION=1` and mount a directory containing captcha files to `/var/www/html/4get/data/captcha`


```
# docker-compose.yaml
version: "3.7"

services:
  fourget:
    image: luuul/4get:latest
    restart: unless-stopped
    environment:
      - FOURGET_PROTO=http
      - FOURGET_SERVER_NAME=4get.ca
      - FOURGET_BOT_PROTECTION=1

    ports:
      - "80:80"
      
    volumes:
      - ./captcha:/var/www/html/4get/data/captcha
```

##### Custom Banners

```
# docker-compose.yaml
version: "3.7"

services:
  fourget:
    image: luuul/4get:latest
    restart: unless-stopped
    environment:
      - FOURGET_PROTO=http
      - FOURGET_SERVER_NAME=4get.ca

    ports:
      - "80:80"
      
    volumes:
      - ./banners:/var/www/html/4get/banner
```

##### Tor

You can route incoming and outgoing requests through tor by following [docker tor documentation](./docker_tor.md)
