<?php

include "data/config.php";
include "lib/frontend.php";
$frontend = new frontend();

$images = glob("banner/*");

echo $frontend->load(
	"home.html",
	[
		"server_short_description" => htmlspecialchars(config::SERVER_SHORT_DESCRIPTION),
		"banner" => $images[rand(0, count($images) - 1)]
	]
);
