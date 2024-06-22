FROM caddy:2-alpine
WORKDIR /srv

COPY Caddyfile /etc/caddy/Caddyfile
COPY . .

EXPOSE 80
