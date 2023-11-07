<?php

header("Content-Type: application/xml");
include "data/config.php";

$domain =
	htmlspecialchars(
		(strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false ? 'http' : 'https') .
		'://' . $_SERVER["HTTP_HOST"]
	);

echo
	'<?xml version="1.0" encoding="UTF-8"?>' .
	'<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">' .
		'<ShortName>' . htmlspecialchars(config::SERVER_NAME) . '</ShortName>' .
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
