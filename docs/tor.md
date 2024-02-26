# Tor setup
This guide assumes that there is already a configured webserver sitting on port 80 waiting for localhost connections. The <a href="https://git.lolcat.ca/lolcat/4get/src/branch/master/docs/apache2.md">apache2 guide</a> guides you through this.

1. Login as `root`.
2. Install `tor`.
3. Edit `/etc/tor/torrc`
4. Go to the line that contains `HiddenServiceDir` and `HiddenServicePort`, uncomment those 2 lines and set them like this: 
	```
	HiddenServiceDir /var/lib/tor/4get
	HiddenServicePort 80 127.0.0.1:80
	```
5. Restart the tor service using `service tor restart`
6. Wait for a while...
7. Run `cat /var/lib/tor/4get/hostname`. That is your onion address!

# Specify your own tor address
