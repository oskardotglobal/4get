<?php

header("Content-Type: application/json");

chdir("../../");

include "lib/frontend.php";
$frontend = new frontend();

/*
	Captcha
*/
include "lib/captcha_gen.php";
new captcha($frontend, false);

[$scraper, $filters] = $frontend->getscraperfilters(
	"web",
	isset($_GET["scraper"]) ? $_GET["scraper"] : null
);

$get = $frontend->parsegetfilters($_GET, $filters);

if(!isset($_GET["extendedsearch"])){
	
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
