# 4get configuation options

Welcome! This guide assumes that you have a working 4get instance. This will help you configure your instance to the best it can be!

## Files location
1. The main configuration file is located at `data/config.php`
2. The proxies are located in `data/proxies/*.txt`
3. The captcha imagesets are located in `data/captcha/your_image_set/*.png`
4. The captcha font is located in `data/fonts/captcha.ttf`

## Server listing
To be listed on https://4get.ca/instances , you must contact *any* of the people in the server list and ask them to add you to their list of instances in their configuration. The instance list is distributed, and I don't have control over it.

If you see spammy entries in your instances list, simply remove the instance from your list that pushes the offending entries.

## Proxies
4get supports rotating proxies for scrapers! Configuring one is really easy.

1. Head over to the **proxies** folder. Give it any name you want, like `myproxy`, but make sure it has the `txt` extension.
2. Add your proxies to the file. Examples:
	```conf
	# format -> <protocol>:<address>:<port>:<username>:<password>
	# protocol list:
	# raw_ip, http, https, socks4, socks5, socks4a, socks5_hostname
	socks5:1.1.1.1:juicy:cloaca00
	http:1.3.3.7::
	raw_ip::::
	```
3. Go to the **main configuration file**. Then, find which website you want to setup a proxy for.
4. Modify the value `false` with `"myproxy"`, with quotes included and the semicolon at the end.

Done! The scraper you chose should now be using the rotating proxies. When asking for the next page of results, it will use the same proxy to avoid detection!

### Important!
If you ever test out a `socks5` proxy locally on your machine and find out it works but doesn't on your server, try supplying the `socks5_hostname` protocol instead.
