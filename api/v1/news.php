<?php

chdir("../../");
header("Content-Type: application/json");

include "data/config.php";
if(config::API_ENABLED === false){
	
	echo json_encode(["status" => "The server administrator disabled the API!"]);
	return;
}

include "lib/frontend.php";
$frontend = new frontend();

/*
	Captcha
*/
include "lib/bot_protection.php";
$null = null;
new bot_protection($null, $null, $null, "news", false);

[$scraper, $filters] = $frontend->getscraperfilters(
	"news",
	isset($_GET["scraper"]) ? $_GET["scraper"] : null
);

$get = $frontend->parsegetfilters($_GET, $filters);

try{
	echo json_encode(
		$scraper->news($get),
		JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE
	);
	
}catch(Exception $e){
	
	echo json_encode(["status" => $e->getMessage()]);
}
