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
new captcha($null, $null, $null, "web", false);

[$scraper, $filters] = $frontend->getscraperfilters(
	"web",
	isset($_GET["scraper"]) ? $_GET["scraper"] : null
);

$get = $frontend->parsegetfilters($_GET, $filters);

if(
	isset($_GET["extendedsearch"]) &&
	$_GET["extendedsearch"] == "yes"
){
	
	$get["extendedsearch"] = "yes";
}else{
	
	$get["extendedsearch"] = "no";
}

try{
	echo json_encode(
		$scraper->web($get),
		JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
	);
	
}catch(Exception $e){
	
	echo json_encode(["status" => $e->getMessage()]);
}
