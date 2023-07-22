<?php

include "lib/frontend.php";
$frontend = new frontend();

$images = glob("banner/*");

echo $frontend->load(
	"home.html",
	[
		"body_class" => $frontend->getthemeclass(false),
		"banner" => $images[rand(0, count($images) - 1)]
	]
);
