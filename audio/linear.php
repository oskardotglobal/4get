<?php

if(!isset($_GET["s"])){
	
	http_response_code(404);
	header("X-Error: No SOUND(s) provided!");
	die();
}

include "../data/config.php";
include "../lib/curlproxy.php";
$proxy = new proxy();

try{
	
	$proxy->stream_linear_audio($_GET["s"]);
}catch(Exception $error){
	
	header("X-Error: " . $error->getMessage());
}
