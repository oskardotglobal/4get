#### Overview

This guide will walk you through using 4get in docker with tor running in
another container. This guide covers how to make outgoing and incoming traffic
go through tor.


##### Starting tor

This guide will use `luuul/tor` which is a simple image that installs and starts
tor in an alpine container SocksPort set to 0.0.0.0:9050 

For additional configuration you can mount your own `torrc` file to `/etc/tor/torrc` 
Remember to set `SocksPort 0.0.0.0:9050` otherwise communication between containers won't work.

You will see this warning `Other people on the Internet might find your computer and use it as an open proxy. Please don't allow this unless you have a good reason.`

This setting is in the torrc of this `luuul/tor` image. If you mount your own torrc then that will be read instead.

If you use `SocksPort 0.0.0.0:9050` anywhere make sure it is inaccessible to outside world.
As long as you don't publish this port (-p or --publish) it shouldn't be accessible to outside world.


Tor always starts a socks5 proxy on port 9050 by default.


##### Route outgoing requests over tor

create a folder named `proxies` and create a file in that folder named `onion.txt`
this folder will be mounted to `/var/www/html/4get/data/proxies/`

directory structure

```
proxies/
  onion.txt
```

put the following content into `onion.txt`
More information about this file available in [proxy documentation](./configure.md#Proxies).

```
# proxies/onion.txt
# Note: "tor" is the service name of luuul/tor in docker-compose.yaml
socks5:tor:9050::
```

create a file named `docker-compose.yaml` with the following content
This docker compose file will run `luuul/tor` and `luuul/4get` and configure 4get to load `proxies/onion.txt` for outgoing requests.

If you mount your own torrc make sure you include `SocksPort 0.0.0.0:9050`
Read the warning in [starting tor](./docker_tor.md#Starting-tor)!

```
# docker-compose.yaml
version: "3.7"

services:
  tor:
    image: luuul/tor:latest
    restart: unless-stopped
    # Warning: Do not publish port 9050
    
  fourget:
    image: luuul/4get:latest
    restart: unless-stopped
    environment:
      - FOURGET_PROTO=http
      - FOURGET_SERVER_NAME=4get.ca
      # loads proxies/onion.txt
      - FOURGET_PROXY_DDG="onion" 
      - FOURGET_PROXY_BRAVE="onion"
      - FOURGET_PROXY_FB="onion"
      - FOURGET_PROXY_GOOGLE="onion"
      - FOURGET_PROXY_QWANT="onion"
      - FOURGET_PROXY_MARGINALIA="onion"
      - FOURGET_PROXY_MOJEEK="onion"
      - FOURGET_PROXY_SC="onion"
      - FOURGET_PROXY_SPOTIFY="onion"
      - FOURGET_PROXY_WIBY="onion"
      - FOURGET_PROXY_CURLIE="onion"
      - FOURGET_PROXY_YT="onion"
      - FOURGET_PROXY_YEP="onion"
      - FOURGET_PROXY_PINTEREST="onion"
      - FOURGET_PROXY_SEZNAM="onion"
      - FOURGET_PROXY_NAVER="onion"
      - FOURGET_PROXY_GREPPR="onion"
      - FOURGET_PROXY_CROWDVIEW="onion"
      - FOURGET_PROXY_MWMBL="onion"
      - FOURGET_PROXY_FTM="onion"
      - FOURGET_PROXY_IMGUR="onion"
      - FOURGET_PROXY_YANDEX_W="onion"
      - FOURGET_PROXY_YANDEX_I="onion"
      - FOURGET_PROXY_YANDEX_V="onion"

    ports:
      - "80:80"
      
    depends_on:
     - tor
     
    volumes:
      - ./proxies/:/var/www/html/4get/data/proxies/
```

You can now start both containers with `docker compose up -d`


#### Route incoming requests over tor

This will create a hidden service that will be accessible via an onion link.

1. create a file named `torrc` with the following content

```
# torrc
User root

HiddenServiceDir /var/lib/tor/4get/
HiddenServicePort 80 fourget:80

```

2. create a folder named "4get" which will contain your hidden service keys.

Make sure it has permission `600` otherwise you will get an error

> Permissions on directory /var/lib/tor/4get/ are too permissive.

you can change permissions with 

```
chmod 600 4get
```

3. Create a folder named "data" that will contain your DataDirectory


4. create a `docker-compose.yaml` with the following content

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

    depends_on:
     - tor
     
  tor:
    image: luuul/tor:latest
    restart: unless-stopped
    
    volumes:
      - ./torrc:/etc/tor/torrc
      - ./4get:/var/lib/tor/4get
      - ./data:/root/.tor
```

5. You can now start both with `docker compose up -d`

6. print onion hostname with 

```
docker exec `docker ps -qf ancestor=luuul/tor:latest` sh -c "cat /var/lib/tor/4get/hostname"
```

or `cat ./4get/hostname`
