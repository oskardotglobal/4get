<?php

/*
	Initialize random shit
*/
include "data/config.php";

include "lib/frontend.php";
$frontend = new frontend();

[$scraper, $filters] = $frontend->getscraperfilters("web");

$get = $frontend->parsegetfilters($_GET, $filters);

/*
	Captcha
*/
include "lib/bot_protection.php";
new bot_protection($frontend, $get, $filters, "web", true);

$payload = [
	"timetaken" => microtime(true),
	"class" => "",
	"right-left" => "",
	"right-right" => "",
	"left" => ""
];

try{
	$results = $scraper->web($get);
	
}catch(Exception $error){
	
	$frontend->drawscrapererror($error->getMessage(), $get, "web", $payload["timetaken"]);
}

/*
	Prepend Oracle output, if applicable
*/
include("oracles/encoder.php");
include("oracles/calc.php");
include("oracles/time.php");
include("oracles/numerics.php");
$oracles = [new calculator(), new encoder(), new time(), new numerics()];
$fortune = "";
foreach ($oracles as $oracle) {
	if ($oracle->check_query($_GET["s"])) {
		$resp = $oracle->generate_response($_GET["s"]);
		if ($resp != "") {
			$fortune .= "<div class=\"infobox\">";
			foreach ($resp as $title => $r) {
				if ($title) {
					$fortune .= "<h3>".htmlspecialchars($title)."</h3><div class=\"code\">".htmlspecialchars($r)."</div>";
				}
				else {
					$fortune .= "<i>".$r."</i><br>";
				}
			}
			$fortune .= "<small>Answer provided by oracle: ".$oracle->info["name"]."</small></div>";
		}
		break;
	}
}
$payload["left"] = $fortune;

$answerlen = 0;

/*
	Spelling checker
*/
if($results["spelling"]["type"] != "no_correction"){
	
	switch($results["spelling"]["type"]){
		
		case "including":
			$type = "Including results for";
			break;
		
		case "not_many":
			$type = "Not many results contains";
			break;
	}
	
	$payload["left"] .=
		'<div class="infobox">' .
			$type . ' <b>' . htmlspecialchars($results["spelling"]["using"]) . '</b>.<br>' .
			'Did you mean <a href="?s=' .
			urlencode($results["spelling"]["correction"]) .
			'&' .
			$frontend->buildquery($get, true) .
			'&spellcheck=no">' .
			$results["spelling"]["correction"] .
			'</a>?' .
		'</div>';
}

/*
	Populate links
*/
if(count($results["web"]) === 0){
	
	$payload["left"] .=
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

foreach($results["web"] as $site){
	
	$n = null;
	
	if($site["date"] !== null){
		
		$date = date("jS M y @ g:ia", $site["date"]);
	}else{
		
		$date = null;
	}
	
	$payload["left"] .= $frontend->drawtextresult($site, $date, $n, $get["s"]);
}

$right = [];

/*
	Generate images
*/
if(count($results["image"]) !== 0){
	
	$answerlen++;
	$right["image"] =
		'<div class="answer-wrapper">' .
			'<input id="answer' . $answerlen . '" class="spoiler" type="checkbox">' .
			'<div class="answer">' .
				'<div class="answer-title">' .
					'<a class="answer-title" href="/images?s=' . urlencode($get["s"]) . '"><h2>Images</h2></a>' .
				'</div>' .
				'<div class="images">';
	
	foreach($results["image"] as $image){
		
		$right["image"] .=
			'<a class="image" href="' . htmlspecialchars($image["url"]) . '" rel="noreferrer nofollow" title="' . htmlspecialchars($image["title"]) . '" data-json="' . htmlspecialchars(json_encode($image["source"])) . '" tabindex="-1">' .
				'<img src="' . $frontend->htmlimage($image["source"][count($image["source"]) - 1]["url"], "square") . '" alt="thumb">';
		
		if(
			$image["source"][0]["width"] !== null &&
			$image["source"][0]["height"] !== null
		){
			
			$right["image"] .= '<div class="duration">' . $image["source"][0]["width"] . 'x' . $image["source"][0]["height"] . '</div>';
		}
		
		$right["image"] .= '</a>';
	}
	
	$right["image"] .=
		'</div></div>' .
		'<label class="spoiler-button" for="answer' . $answerlen . '"></label></div>';
}

/*
	Generate videos
*/
if(count($results["video"]) !== 0){
	
	$answerlen++;
	$right["video"] =
		'<div class="answer-wrapper">' .
			'<input id="answer' . $answerlen . '" class="spoiler" type="checkbox">' .
			'<div class="answer">' .
				'<div class="answer-title">' .
					'<a class="answer-title" href="/videos?s=' . urlencode($get["s"]) . '"><h2>Videos</h2></a>' .
				'</div>';
	
	foreach($results["video"] as $video){
		
		if($video["views"] !== null){
			
			$greentext = number_format($video["views"]) . " views";
		}else{
			
			$greentext = null;
		}
		
		if($video["date"] !== null){
			
			if($greentext !== null){
				
				$greentext .= " • ";
			}
			
			$greentext .= date("jS M y @ g:ia", $video["date"]);
		}
		
		if($video["duration"] !== null){
			
			if($video["duration"] == "_LIVE"){
				
				$duration = 'LIVE';
			}else{
			
				$duration = $frontend->s_to_timestamp($video["duration"]);
			}
		}else{
			
			$duration = null;
		}
		
		$right["video"] .= $frontend->drawtextresult($video, $greentext, $duration, $get["s"], false);
	}
	
	$right["video"] .=
		'</div>' .
		'<label class="spoiler-button" for="answer' . $answerlen . '"></label></div>';
}

/*
	Generate news
*/
if(count($results["news"]) !== 0){
	
	$answerlen++;
	$right["news"] =
		'<div class="answer-wrapper">' .
			'<input id="answer' . $answerlen . '" class="spoiler" type="checkbox">' .
			'<div class="answer">' .
				'<div class="answer-title">' .
					'<a class="answer-title" href="/news?s=' . urlencode($get["s"]) . '"><h2>News</h2></a>' .
				'</div>';
	
	foreach($results["news"] as $news){
		
		if($news["date"] !== null){
			
			$greentext = date("jS M y @ g:ia", $news["date"]);
		}else{
			
			$greentext = null;
		}
		
		$right["news"] .= $frontend->drawtextresult($news, $greentext, null, $get["s"], false);
	}
	
	$right["news"] .=
		'</div>' .
		'<label class="spoiler-button" for="answer' . $answerlen . '"></label></div>';
}

/*
	Generate answers
*/
if(count($results["answer"]) !== 0){
	
	$right["answer"] = "";
	
	foreach($results["answer"] as $answer){
		
		$answerlen++;
		$right["answer"] .=
			'<div class="answer-wrapper">' .
				'<input id="answer' . $answerlen . '" class="spoiler" type="checkbox">' .
				'<div class="answer"><div class="wiki-head">';
		
		if(!empty($answer["title"])){
			
			$right["answer"] .=
			'<div class="answer-title">';
			
			if(!empty($answer["url"])){
				
				$right["answer"] .= '<a class="answer-title" href="' . htmlspecialchars($answer["url"]) . '" rel="noreferrer nofollow">';
			}
			
			$right["answer"] .= '<h1>' . htmlspecialchars($answer["title"]) . '</h1>';
			
			if(!empty($answer["url"])){
				
				$right["answer"] .= '</a>';
			}
			
			
			$right["answer"] .= '</div>';
		}
		
		if(!empty($answer["url"])){
			
			$right["answer"] .=
				$frontend->drawlink($answer["url"]);
		}
		
		$right["answer"] .= '<div class="description">';
		
		if(!empty($answer["thumb"])){
			
			$right["answer"] .=
				'<a href="' . htmlspecialchars($answer["thumb"]) . '" rel="noreferrer nofollow" class="photo">' .
					'<img src="' . $frontend->htmlimage($answer["thumb"], "cover") . '" alt="thumb" class="openimg">' .
				'</a>';
		}
		
		foreach($answer["description"] as $description){
			
			switch($description["type"]){
				
				case "text":
					$right["answer"] .= $frontend->highlighttext($get["s"], $description["value"]);
					break;
				
				case "title":
					$right["answer"] .=
						'<h2>' .
							htmlspecialchars($description["value"]) .
						'</h2>';
					break;
				
				case "italic":
					$right["answer"] .=
						'<i>' .
							$frontend->highlighttext($get["s"], $description["value"]) .
						'</i>';
					break;
				
				case "quote":
					$right["answer"] .=
						'<div class="quote">' .
							$frontend->highlighttext($get["s"], $description["value"]) .
						'</div>';
					break;
				
				case "code":
					$right["answer"] .=
						'<div class="code" tabindex="-1">' .
							$frontend->highlightcode($description["value"], true) .
						'</div>';
					break;
				
				case "inline_code":
					$right["answer"] .=
						'<div class="code-inline">' .
							htmlspecialchars($description["value"]) .
						'</div>';
					break;
				
				case "link":
					$right["answer"] .=
						'<a href="' . htmlspecialchars($description["url"]) . '" rel="noreferrer nofollow" class="underline" tabindex="-1">' . htmlspecialchars($description["value"]) . '</a>';
					break;
				
				case "image":
					$right["answer"] .=
						'<a href="' . htmlspecialchars($description["url"]) . '" rel="noreferrer nofollow" tabindex="-1"><img src="' . $frontend->htmlimage($description["url"], "thumb") . '" alt="image" class="fullimg openimg"></a>';
					break;
				
				case "audio":
					$right["answer"] .=
						'<audio src="/audio/linear?s=' . urlencode($description["url"]) . '" controls><a href="/audio/linear?s=' . urlencode($description["url"]) . '">Listen to the pronunciation audio</a></audio>';
					break;
			}
		}
		
		$right["answer"] .= '</div>';
		
		if(count($answer["table"]) !== 0){
			
			$right["answer"] .= '<table>';
			
			foreach($answer["table"] as $info => $value){
				
				$right["answer"] .=
					'<tr>' . 
						'<td>' . $info . '</td>' .
						'<td>' . $value . '</td>' .
					'</tr>';
			}
			
			$right["answer"] .= '</table>';
		}
		
		if(count($answer["sublink"]) !== 0){
			
			$right["answer"] .= '<div class="socials">';
			$icons = glob("static/icon/*");
			
			foreach($answer["sublink"] as $website => $url){
				
				$flag = false;
				$icon = str_replace(" ", "", strtolower($website));
				
				foreach($icons as $path){
					
					if(pathinfo($path, PATHINFO_FILENAME) == $icon){
						
						$flag = true;
						break;
					}
				}
				
				if($flag === false){
					
					$icon = "website";
				}
				
				$right["answer"] .=
					'<a href="' . htmlspecialchars($url) . '" rel="noreferrer nofollow" tabindex="-1">' .
						'<div class="center">' .
							'<img src="/static/icon/' . $icon . '.png" alt="icon">' .
							'<div class="title">' . $website . '</div>' .
						'</div>' .
					'</a>';
			}
			
			$right["answer"] .= '</div>';
		}
		
		$right["answer"] .=
			'</div></div>' .
			'<label class="spoiler-button" for="answer' . $answerlen . '"></label></div>';
	}
}

/*
	Add right containers
*/
if(isset($right["answer"])){
	
	if(count($right) >= 2){
		
		$payload["right-right"] = $right["answer"];
		unset($right["answer"]);
	}
}

$c = 0;
foreach($right as $snippet){
	
	if($c % 2 === 0){
		
		$payload["right-left"] .= $snippet;
	}else{
		
		$payload["right-right"] .= $snippet;
	}
	
	$c++;
}

if($c !== 0){
	
	$payload["class"] = " has-answer";
}

/*
	Generate related searches
*/
$c = count($results["related"]);

if($c !== 0){
	$payload["left"] .= '<h3>Related searches</h3><table class="related">';

	$opentr = false;
		
	for($i=0; $i<$c; $i++){
		
		if(($i % 2) === 0){
			
			$opentr = true;
			$payload["left"] .= '<tr>';
		}else{
			
			$opentr = false;
		}
		
		$payload["left"] .=
			'<td>' .
				'<a href="/web?s=' .
					urlencode($results["related"][$i]) . "&" .
					$frontend->buildquery($get, true) .
					'">' .
					htmlspecialchars($results["related"][$i]) .
				'</a>';
		
		$payload["left"] .= '</td>';
		
		if($opentr === false){
			
			$payload["left"] .= '</tr>';
		}
	}
	
	if($opentr === true){
		
		$payload["left"] .= '<td></td></tr>';
	}
	
	$payload["left"] .= '</table>';
}

/*
	Load next page
*/
if($results["npt"] !== null){
	
	$payload["left"] .=
		'<a href="' . $frontend->htmlnextpage($get, $results["npt"], "web") . '" class="nextpage">Next page &gt;</a>';
}

echo $frontend->load("search.html", $payload);
