<?php

include "data/config.php";
include "lib/frontend.php";
$frontend = new frontend();

echo
	$frontend->load(
		"header_nofilters.html",
		[
			"title" => "Donate to the project",
			"class" => " class=\"about\""
		]
	);

$left =
	explode(
		"\n",
		file_get_contents("template/donate.html")
	);

$out = "";

foreach($left as $line){
	
	$out .= trim($line);
}

echo
	$frontend->load(
		"search.html",
		[
			"timetaken" => null,
			"class" => "",
			"right-left" => "",
			"right-right" => "",
			"left" => $out
		]
	);
