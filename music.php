<?php

/*
	Initialize random shit
*/
include "data/config.php";

include "lib/frontend.php";
$frontend = new frontend();

[$scraper, $filters] = $frontend->getscraperfilters("music");

$get = $frontend->parsegetfilters($_GET, $filters);

/*
	Captcha
*/
include "lib/bot_protection.php";
new bot_protection($frontend, $get, $filters, "music", true);

$payload = [
	"timetaken" => microtime(true),
	"class" => "",
	"right-left" => "",
	"right-right" => "",
	"left" => ""
];

try{
	$results = $scraper->music($get);
	
}catch(Exception $error){
	
	$frontend->drawscrapererror($error->getMessage(), $get, "music", $payload["timetaken"]);
}

$categories = [
	"song" => "",
	"author" => "",
	"playlist" => "",
	"album" => "",
	"podcast" => "",
	"user" => ""
];

/*
	Set the main container
*/
$main = null;

if(count($results["song"]) !== 0){
	
	$main = "song";
	
}elseif(count($results["album"]) !== 0){
	
	$main = "album";
	
}elseif(count($results["playlist"]) !== 0){
	
	$main = "playlist";
	
}elseif(count($results["podcast"]) !== 0){
	
	$main = "podcast";

}elseif(count($results["author"]) !== 0){
	
	$main = "author";
		
}elseif(count($results["user"]) !== 0){
	
	$main = "user";
	
}else{
	
	// No results found!
	echo
		$frontend->drawerror(
			"Nobody here but us chickens!",
			'Have you tried:' .
				'<ul>' .
					'<li>Using a different scraper</li>' .
					'<li>Using fewer keywords</li>' .
					'<li>Defining broader filters (Is NSFW turned off?)</li>' .
				'</ul>' .
			'</div>'
		);
	die();
}

/*
	Generate list of songs
*/
foreach($categories as $name => $data){
	
	foreach($results[$name] as $item){
		
		$greentext = [];
		
		if(
			isset($item["date"]) &&
			$item["date"] !== null
		){
			
			$greentext[] = date("jS M y @ g:ia", $item["date"]);
		}
		
		if(
			isset($item["views"]) &&
			$item["views"] !== null
		){
			
			$views = number_format($item["views"]) . " views";
			$greentext[] = $views;
		}
		
		if(
			isset($item["followers"]) &&
			$item["followers"] !== null
		){
			
			$greentext[] = number_format($item["followers"]) . " followers";
		}
		
		if(
			isset($item["author"]["name"]) &&
			$item["author"]["name"] !== null
		){
			
			$greentext[] = $item["author"]["name"];
		}
		
		$greentext = implode(" • ", $greentext);
		
		if(
			isset($item["duration"]) &&
			$item["duration"] !== null
		){
			
			$duration = $frontend->s_to_timestamp($item["duration"]);
		}else{
			
			$duration = null;
		}
		
		$tabindex = $name == $main ? true : false;
		
		$customhtml = null;
		
		if(
			(
				$name == "song" ||
				$name == "podcast"
			) &&
			$item["stream"]["endpoint"] !== null
		){
			
			$customhtml =
				'<audio src="/audio/' . $item["stream"]["endpoint"] . '?s=' . urlencode($item["stream"]["url"]) . '" controls autostart="false" preload="none">';
		}
		
		$categories[$name] .= $frontend->drawtextresult($item, $greentext, $duration, $get["s"], $tabindex, $customhtml);
	}
}

$payload["left"] = $categories[$main];

// dont re-draw the category
unset($categories[$main]);

/*
	Populate right handside
*/

$i = 1;
foreach($categories as $name => $value){
	
	if($value == ""){
		
		continue;
	}
	
	if($i % 2 === 1){
		
		$write = "right-left";
	}else{
		
		$write = "right-right";
	}
	
	$payload[$write] .=
		'<div class="answer-wrapper">' .
		'<input id="answer' . $i . '" class="spoiler" type="checkbox">' .
		'<div class="answer">' .
			'<div class="answer-title">' .
				'<a class="answer-title" href="?s=' . urlencode($get["s"]);
	
	$payload[$write] .=
		'&type=' . $name . '"><h2>' . ucfirst($name) . 's</h2></a>';
	
	$payload[$write] .=
			'</div>' .
			$categories[$name] .
		'</div>' .
		'<label class="spoiler-button" for="answer' . $i . '"></label></div>';
	
	$i++;
}

if($i !== 1){
	
	$payload["class"] = " has-answer";
}

if($results["npt"] !== null){
	
	$payload["left"] .=
		'<a href="' . $frontend->htmlnextpage($get, $results["npt"], "music") . '" class="nextpage">Next page &gt;</a>';
}

echo $frontend->load("search.html", $payload);
