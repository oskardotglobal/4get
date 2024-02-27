# Install guide for Docker

```
docker run -d -p 80:80 -e FOURGET_SERVER_NAME="4get.ca" luuul/4get:latest
```

...Or with SSL:
```
docker run -d -p 443:443 -v /etc/letsencrypt/live/domain.tld:/etc/4get/certs -e FOURGET_SERVER_NAME="4get.ca" luuul/4get:latest
```

if the certificate files are not mounted to /etc/4get/certs the service listens to port 80

the certificate directory expects files named `fullchain.pem` and `privkey.pem`

# Install using Docker Compose 

copy `docker-compose.yaml`

to serve custom banners create a directory named `banners` for example with images and mount to `/var/www/html/4get/banner`

to serve captcha images create a directory named `captchas` for example containing subfolders with images and mount to `/var/www/html/4get/data/captcha`

any environment variables prefixed with `FOURGET_` will be added to the generated config

the entrypoint will automatically set the `CAPTCHA_DATASET` value for you based on directory names and number of files in each

to set `INSTANCES` pass a comma separated string of urls (FOURGET_INSTANCES = "https://4get.ca,https://domain.tld")

```
version: "3.7"

services:
  fourget:
    image: luuul/4get:latest
    restart: always
    environment:
      - FOURGET_SERVER_NAME=4get.ca

    ports:
      - "80:80"
      - "443:443"

    volumes:
      - /etc/letsencrypt/live/domain.tld:/etc/4get/certs
      - ./banners:/var/www/html/4get/banner
      - ./captchas:/var/www/html/4get/data/captcha
```

Replace relevant values and start with `docker compose up -d`
