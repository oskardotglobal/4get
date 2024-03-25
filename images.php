<?php

/*
	Initialize random shit
*/
include "data/config.php";

include "lib/frontend.php";
$frontend = new frontend();

[$scraper, $filters] = $frontend->getscraperfilters("images");

$get = $frontend->parsegetfilters($_GET, $filters);

/*
	Captcha
*/
include "lib/bot_protection.php";
new bot_protection($frontend, $get, $filters, "images", true);

$payload = [
	"timetaken" => microtime(true),
	"images" => "",
	"nextpage" => ""
];

try{
	$results = $scraper->image($get);
	
}catch(Exception $error){
	
	$frontend->drawscrapererror($error->getMessage(), $get, "images", $payload["timetaken"]);
}

if(count($results["image"]) === 0){
	
	$payload["images"] =
		'<div class="infobox">' .
			"<h1>Nobody here but us chickens!</h1>" .
			'Have you tried:' .
			'<ul>' .
				'<li>Using a different scraper</li>' .
				'<li>Using fewer keywords</li>' .
				'<li>Defining broader filters (Is NSFW turned off?)</li>' .
			'</ul>' .
		'</div>';
}
	
foreach($results["image"] as $image){
	
	$payload["images"] .=
		'<div class="image-wrapper" title="' . htmlspecialchars($image["title"]) .'" data-json="' . htmlspecialchars(json_encode($image["source"])) . '">' .
			'<div class="image">' .
				'<a href="' . htmlspecialchars($image["source"][0]["url"]) . '" rel="noreferrer nofollow" class="thumb">' .
					'<img src="' . $frontend->htmlimage($image["source"][count($image["source"]) - 1]["url"], "thumb") . '" alt="thumbnail">';
				
				if($image["source"][0]["width"] !== null){
					$payload["images"] .= '<div class="duration">' . $image["source"][0]["width"] . 'x' . $image["source"][0]["height"] . '</div>';
				}
				
			$payload["images"] .=
				'</a>' .
				'<a href="' . htmlspecialchars($image["url"]) . '" rel="noreferrer nofollow">' .
					'<div class="title">' . htmlspecialchars(parse_url($image["url"], PHP_URL_HOST)) . '</div>' .
					'<div class="description">' . $frontend->highlighttext($get["s"], $image["title"]) . '</div>' .
				'</a>' .
			'</div>' .
		'</div>';
}

if($results["npt"] !== null){
	
	$payload["nextpage"] =
		'<a href="' . $frontend->htmlnextpage($get, $results["npt"], "images") . '" class="nextpage img">Next page &gt;</a>';
}

echo $frontend->load("images.html", $payload);
