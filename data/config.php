<?php
class config{
	// Welcome to the 4get configuration file
	// When updating your instance, please make sure this file isn't missing
	// any parameters.
	
	// 4get version. Please keep this updated
	const VERSION = 6;
	
	// Will be shown pretty much everywhere.
	const SERVER_NAME = "4get";
	
	// Will be shown in <meta> tag on home page
	const SERVER_SHORT_DESCRIPTION = "They live in our walls!";
	
	// Will be shown in server list ping (null for no description)
	const SERVER_LONG_DESCRIPTION = null;
	
	// Add your own themes in "static/themes". Set to "Dark" for default theme.
	// Eg. To use "static/themes/Cream.css", specify "Cream".
	const DEFAULT_THEME = "Dark";
	
	// Enable the API?
	const API_ENABLED = true;
	
	// Bot protection
	// 4get.ca has been hit with 250k bot reqs every single day for months
	// you probably want to enable this if your instance is public...
	// 0 = disabled
	// 1 = ask for image captcha (requires image dataset & imagick 6.9.11-60)
	// @TODO: 2 = invite only (users needs a pass)
	const BOT_PROTECTION = 0;
	
	// Maximal number of searches per captcha key/pass issued. Counter gets
	// reset on every APCU cache clear (should happen once a day)
	const MAX_SEARCHES = 100;
	
	// if BOT_PROTECTION is set to 1, specify the available datasets here
	// images should be named from 1.png to X.png, and be 100x100 in size
	// Eg. data/captcha/birds/1.png up to 2263.png
	const CAPTCHA_DATASET = [
		// example:
		// ["birds", 2263],
		// ["fumo_plushies", 1006],
		// ["minecraft", 848]
	];
	
	// List of domains that point to your servers. Include your tor/i2p
	// addresses here! Must be a valid URL. Won't affect links placed on
	// the homepage.
	const ALT_ADDRESSES = [
		//"https://4get.alt-tld",
		//"http://4getwebfrq5zr4sxugk6htxvawqehxtdgjrbcn2oslllcol2vepa23yd.onion"
	];
	
	// Known 4get instances. MUST use the https protocol if your instance uses
	// it. Is used to generate a distributed list of instances.
	// To appear in the list of an instance, contact the host and if everyone added
	// eachother your serber should appear everywhere.
	const INSTANCES = [
		"https://4get.ca",
		"https://4get.zzls.xyz",
		"https://4getus.zzls.xyz",
		"https://4get.silly.computer",
		"https://4g.opnxng.com",
		"https://4get.konakona.moe",
		"https://4get.lvkaszus.pl",
		"https://4g.ggtyler.dev",
		"https://4get.perennialte.ch",
		"https://4get.sihj.net",
		"https://4get.hbubli.cc",
		"https://4get.plunked.party",
		"https://4get.seitan-ayoub.lol"
	];
	
	// Default user agent to use for scraper requests. Sometimes ignored to get specific webpages
	// Changing this might break things.
	const USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/120.0";
	
	// Proxy pool assignments for each scraper
	// false = Use server's raw IP
	// string = will load a proxy list from data/proxies
	// Eg. "onion" will load data/proxies/onion.txt
	const PROXY_DDG = false; // duckduckgo
	const PROXY_BRAVE = false;
	const PROXY_FB = false; // facebook
	const PROXY_GOOGLE = false;
	const PROXY_MARGINALIA = false;
	const PROXY_MOJEEK = false;
	const PROXY_SC = false; // soundcloud
	const PROXY_SPOTIFY = false;
	const PROXY_WIBY = false;
	const PROXY_CURLIE = false;
	const PROXY_YT = false; // youtube
	const PROXY_YEP = false;
	const PROXY_PINTEREST = false;
	const PROXY_FTM = false; // findthatmeme
	const PROXY_IMGUR = false;
	const PROXY_YANDEX_W = false; // yandex web
	const PROXY_YANDEX_I = false; // yandex images
	const PROXY_YANDEX_V = false; // yandex videos
	
	//
	// Scraper-specific parameters
	//
	
	// SOUNDCLOUD
	// Get these parameters by making a search on soundcloud with network
	// tab open, then filter URLs using "search?q=". (No need to login)
	const SC_USER_ID = "361066-632137-891392-693457";
	const SC_CLIENT_TOKEN = "nUB9ZvnjRiqKF43CkKf3iu69D8bboyKY";
	
	// MARGINALIA
	// Get an API key by contacting the Marginalia.nu maintainer. The "public" key
	// works but is almost always rate-limited.
	const MARGINALIA_API_KEY = "public";
}
