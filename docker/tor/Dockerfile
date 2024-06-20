FROM alpine:edge

RUN apk add --no-cache curl tor 

EXPOSE 9050

HEALTHCHECK --interval=60s --timeout=15s --start-period=20s \
    CMD curl -x socks5h://127.0.0.1:9050 'https://check.torproject.org/api/ip' | grep -qm1 -E '"IsTor"\s*:\s*true'


# default owner is tor, but running as root to avoid docker volume mount issue
RUN chown -R root:root /var/lib/tor

VOLUME ["/var/lib/tor/4get"]

COPY ./torrc /etc/tor/torrc

ENTRYPOINT ["/usr/bin/tor"]
