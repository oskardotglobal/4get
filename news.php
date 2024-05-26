<?php

/*
	Initialize random shit
*/
include "data/config.php";

include "lib/frontend.php";
$frontend = new frontend();

[$scraper, $filters] = $frontend->getscraperfilters("news");

$get = $frontend->parsegetfilters($_GET, $filters);

/*
	Captcha
*/
include "lib/bot_protection.php";
new bot_protection($frontend, $get, $filters, "news", true);

$payload = [
	"timetaken" => microtime(true),
	"class" => "",
	"right-left" => "",
	"right-right" => "",
	"left" => ""
];

try{
	$results = $scraper->news($get);
	
}catch(Exception $error){
	
	$frontend->drawscrapererror($error->getMessage(), $get, "news", $payload["timetaken"]);
}

/*
	Populate links
*/
if(count($results["news"]) === 0){
	
	$payload["left"] =
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

foreach($results["news"] as $news){
	
	$greentext = [];
	
	if($news["date"] !== null){
		
		$greentext[] = date("jS M y @ g:ia", $news["date"]);
	}
	
	if($news["author"] !== null){
		
		$greentext[] = htmlspecialchars($news["author"]);
	}
	
	if(count($greentext) !== 0){
		
		$greentext = implode(" • ", $greentext);
	}else{
		
		$greentext = null;
	}
	
	$n = null;
	$payload["left"] .= $frontend->drawtextresult($news, $greentext, $n, $get["s"]);
}

if($results["npt"] !== null){
	
	$payload["left"] .=
		'<a href="' . $frontend->htmlnextpage($get, $results["npt"], "news") . '" class="nextpage">Next page &gt;</a>';
}

echo $frontend->load("search.html", $payload);
