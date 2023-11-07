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
include "lib/captcha_gen.php";
$null = null;
new captcha($null, $null, $null, "images", false);

[$scraper, $filters] = $frontend->getscraperfilters(
	"images",
	isset($_GET["scraper"]) ? $_GET["scraper"] : null
);

$get = $frontend->parsegetfilters($_GET, $filters);

try{
	echo json_encode(
		$scraper->image($get),
		JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
	);
	
}catch(Exception $e){
	
	echo json_encode(["status" => $e->getMessage()]);
}
