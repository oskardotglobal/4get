<?php

include "lib/frontend.php";
$frontend = new frontend();

include "data/config.php";

$params = "";
$first = true;
foreach($_GET as $key => $value){
	
	if(
		!is_string($value) ||
		$key == "target"
	){
		
		continue;
	}
	
	if($first === true){
		
		$first = false;
		$params = "?";
	}else{
		
		$params .= "&";
	}
	
	$params .= urlencode($key) . "=" . urlencode($value);
}

if(
	!isset($_GET["target"]) ||
	!is_string($_GET["target"])
){
	
	$target = "";
}else{
	
	$target = "/" . urlencode($_GET["target"]);
}

$instances = "";
foreach(config::INSTANCES as $instance){
	
	$instances .= '<tr><td class="expand"><a href="' . htmlspecialchars($instance) . $target . $params . '" target="_BLANK" rel="noreferer">' . htmlspecialchars($instance) . '</a></td></tr>';
}

echo
	$frontend->load(
		"instances.html",
		[
			"instances_html" => $instances
		]
	);
