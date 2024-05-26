<?php

header("Content-Type: application/xml");
include "data/config.php";

$domain =
	htmlspecialchars(
		(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "https" : "http") .
		'://' . $_SERVER["HTTP_HOST"]
	);

if(
	preg_match(
		'/\.onion$/',
		$domain
	)
){
	
	$onion = true;
}else{
	
	$onion = false;
}

echo
	'<?xml version="1.0" encoding="UTF-8"?>' .
	'<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">' .
		'<ShortName>' . htmlspecialchars(config::SERVER_NAME) . ($onion ? " (onion)" : "") . '</ShortName>' .
		'<InputEncoding>UTF-8</InputEncoding>' .
		'<Image width="16" height="16">' . $domain . '/favicon.ico</Image>' .
		'<Url type="text/html" method="GET" template="' . $domain . '/web?s={searchTerms}"/>';

if(
	isset($_GET["ac"]) &&
	is_string($_GET["ac"]) &&
	$_GET["ac"] != "disabled"
){
	
	echo '<Url rel="suggestions" type="application/x-suggestions+json" template="' . $domain . '/api/v1/ac?s={searchTerms}&amp;scraper=' . htmlspecialchars($_GET["ac"]) . '"/>';
}

echo '</OpenSearchDescription>';
