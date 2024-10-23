<?php
class config{
	// Welcome to the 4get configuration file
	// When updating your instance, please make sure this file isn't missing
	// any parameters.
	
	// 4get version. Please keep this updated
	const VERSION = 8;
	
	// Will be shown pretty much everywhere.
	const SERVER_NAME = "4get";
	
	// Will be shown in <meta> tag on home page
	const SERVER_SHORT_DESCRIPTION = "4get is a proxy search engine that doesn't suck.";
	
	// Will be shown in server list ping (null for no description)
	const SERVER_LONG_DESCRIPTION = null;
	
	// Add your own themes in "static/themes". Set to "Dark" for default theme.
	// Eg. To use "static/themes/Cream.css", specify "Cream".
	const DEFAULT_THEME = "Dark";
	
	// Enable the API?
	const API_ENABLED = true;
	
	//
	// BOT PROTECTION
	//
	
	// 0 = disabled, 1 = ask for image captcha, @TODO: 2 = invite only (users needs a pass)
	// VERY useful against a targetted attack
	const BOT_PROTECTION = 0;
	
	// if BOT_PROTECTION is set to 1, specify the available datasets here
	// images should be named from 1.png to X.png, and be 100x100 in size
	// Eg. data/captcha/birds/1.png up to 2263.png
	const CAPTCHA_DATASET = [
		// example:
		//["birds", 2263],
		//["fumo_plushies", 1006],
		//["minecraft", 848]
	];
	
	// If this regex expression matches on the user agent, it blocks the request
	// Not useful at all against a targetted attack
	const HEADER_REGEX = '/bot|wget|curl|python-requests|scrapy|go-http-client|ruby|yahoo|spider|qwant/i';
	
	// Block clients who present any of the following headers in their request (SPECIFY IN !!lowercase!!)
	// Eg: ["x-forwarded-for", "x-via", "forwarded-for", "via"];
	// Useful for blocking *some* proxies used for botting
	const FILTERED_HEADER_KEYS = [
		//"x-forwarded-for",
		//"x-cluster-client-ip",
		//"x-client-ip",
		//"x-real-ip",
		//"client-ip",
		//"real-ip",
		//"forwarded-for",
		//"forwarded-for-ip",
		//"forwarded",
		//"proxy-connection",
		//"remote-addr",
		//"via"
	];
	
	// Block SSL ciphers used by CLI tools used for botting
	// Basically a primitive version of Cloudflare's browser integrity check
	// ** If curl can still access the site (with spoofed headers), please make sure you use the new apache2 config **
	// https://git.lolcat.ca/lolcat/4get/docs/apache2.md
	const DISALLOWED_SSL = [
		// "TLS_AES_256_GCM_SHA384" // used by WGET and CURL
	];
	
	// Maximal number of searches per captcha key/pass issued. Counter gets
	// reset on every APCU cache clear (should happen once a day).
	// Only useful when BOT_PROTECTION is NOT set to 0
	const MAX_SEARCHES = 100;
	
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
		"https://4get.konakona.moe",
		"https://4get.lvkaszus.pl",
		"https://4g.ggtyler.dev",
		"https://4get.perennialte.ch",
		"https://4get.sijh.net",
		"https://4get.hbubli.cc",
		"https://4get.plunked.party",
		"https://4get.seitan-ayoub.lol",
		"https://4get.etenie.pl",
		"https://4get.lunar.icu",
		"https://4get.dcs0.hu",
		"https://4get.kizuki.lol",
		"https://4get.psily.garden",
		"https://search.milivojevic.in.rs",
		"https://4get.snine.nl",
		"https://4get.datura.network",
		"https://4get.neco.lol",
		"https://4get.lol",
		"https://4get.ch",
		"https://4get.edmateo.site",
		"https://4get.sudovanilla.org",
		"https://search.mint.lgbt"
	];
	
	// Default user agent to use for scraper requests. Sometimes ignored to get specific webpages
	// Changing this might break things.
	const USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:131.0) Gecko/20100101 Firefox/131.0";
	
	// Proxy pool assignments for each scraper
	// false = Use server's raw IP
	// string = will load a proxy list from data/proxies
	// Eg. "onion" will load data/proxies/onion.txt
	const PROXY_DDG = false; // duckduckgo
	const PROXY_BRAVE = false;
	const PROXY_FB = false; // facebook
	const PROXY_GOOGLE = false;
	const PROXY_GOOGLE_CSE = false;
	const PROXY_STARTPAGE = false;
	const PROXY_QWANT = false;
	const PROXY_GHOSTERY = false;
	const PROXY_MARGINALIA = false;
	const PROXY_MOJEEK = false;
	const PROXY_SC = false; // soundcloud
	const PROXY_SPOTIFY = false;
	const PROXY_SOLOFIELD = false;
	const PROXY_WIBY = false;
	const PROXY_CURLIE = false;
	const PROXY_YT = false; // youtube
	const PROXY_YEP = false;
	const PROXY_PINTEREST = false;
	const PROXY_SEZNAM = false;
	const PROXY_NAVER = false;
	const PROXY_GREPPR = false;
	const PROXY_CROWDVIEW = false;
	const PROXY_MWMBL = false;
	const PROXY_FTM = false; // findthatmeme
	const PROXY_IMGUR = false;
	const PROXY_YANDEX_W = false; // yandex web
	const PROXY_YANDEX_I = false; // yandex images
	const PROXY_YANDEX_V = false; // yandex videos
	
	//
	// Scraper-specific parameters
	//
	
	// GOOGLE CSE
	const GOOGLE_CX_ENDPOINT = "d4e68b99b876541f0";
	
	// MARGINALIA
	// Use "null" to default out to HTML scraping OR specify a string to
	// use the API (Eg: "public"). API has less filters.
	const MARGINALIA_API_KEY = null;
}
