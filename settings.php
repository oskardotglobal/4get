<?php

/*
	Define settings
*/
$settings = [
	[
		"name" => "General",
		"settings" => [
			[
				"description" => "Allow NSFW content",
				"parameter" => "nsfw",
				"options" => [
					[
						"value" => "yes",
						"text" => "Yes"
					],
					[
						"value" => "maybe",
						"text" => "Maybe"
					],
					[
						"value" => "no",
						"text" => "No"
					]
				]
			],
			[
				"description" => "Theme",
				"parameter" => "theme",
				"options" => [
					[
						"value" => "dark",
						"text" => "Gruvbox dark"
					],
					[
						"value" => "cream",
						"text" => "Gruvbox cream"
					]
				]
			],
			[
				"description" => "Prevent clicking background elements when image viewer is open",
				"parameter" => "bg_noclick",
				"options" => [
					[
						"value" => "no",
						"text" => "No"
					],
					[
						"value" => "yes",
						"text" => "Yes"
					]
				]
			]
		]
	],
	[
		"name" => "Scrapers to use",
		"settings" => [
			[
				"description" => "Web",
				"parameter" => "scraper_web",
				"options" => [
					[
						"value" => "ddg",
						"text" => "DuckDuckGo"
					],
					[
						"value" => "brave",
						"text" => "Brave"
					],
					[
						"value" => "yandex",
						"text" => "Yandex"
					],
					/*[
						"value" => "google",
						"text" => "Google"
					],*/
					[
						"value" => "mojeek",
						"text" => "Mojeek"
					],
					[
						"value" => "marginalia",
						"text" => "Marginalia"
					],
					[
						"value" => "wiby",
						"text" => "wiby"
					]
				]
			],
			[
				"description" => "Images",
				"parameter" => "scraper_images",
				"options" => [
					[
						"value" => "ddg",
						"text" => "DuckDuckGo"
					],
					[
						"value" => "yandex",
						"text" => "Yandex"
					],
					[
						"value" => "brave",
						"text" => "Brave"
					],
					[
						"value" => "google",
						"text" => "Google"
					]
				]
			],
			[
				"description" => "Videos",
				"parameter" => "scraper_videos",
				"options" => [
					[
						"value" => "yt",
						"text" => "YouTube"
					],
					[
						"value" => "ddg",
						"text" => "DuckDuckGo"
					],
					[
						"value" => "brave",
						"text" => "Brave"
					],
					[
						"value" => "yandex",
						"text" => "Yandex"
					]/*,
					[
						"value" => "google",
						"text" => "Google"
					]*/
				]
			],
			[
				"description" => "News",
				"parameter" => "scraper_news",
				"options" => [
					[
						"value" => "ddg",
						"text" => "DuckDuckGo"
					],
					[
						"value" => "brave",
						"text" => "Brave"
					],
					/*[
						"value" => "google",
						"text" => "Google"
					],*/
					[
						"value" => "mojeek",
						"text" => "Mojeek"
					]
				]
			]
		]
	]
];

/*
	Set cookies
*/

if($_POST){

	$loop = &$_POST;
}else{
	
	// refresh cookie dates
	$loop = &$_COOKIE;
}
	
foreach($loop as $key => $value){
	
	foreach($settings as $title){
		
		foreach($title["settings"] as $list){
			
			if(
				$list["parameter"] == $key &&
				$list["options"][0]["value"] == $value
			){
				
				unset($_COOKIE[$key]);
				
				setcookie(
					$key,
					"",
					[
						"expires" => -1, // removes cookie
						"samesite" => "Strict"
					]
				);
				
				continue 3;
			}
		}
	}
	
	if(!is_string($value)){
		
		continue;
	}
	
	$key = trim($key);
	$value = trim($value);
	
	$_COOKIE[$key] = $value;
	
	setcookie(
		$key,
		$value,
		[
			"expires" => strtotime("+400 days"), // maximal cookie ttl in chrome
			"samesite" => "Strict"
		]
	);
}

include "lib/frontend.php";
$frontend = new frontend();

echo
	'<!DOCTYPE html>' .
	'<html lang="en">' .
		'<head>' .
			'<meta http-equiv="Content-Type" content="text/html;charset=utf-8">' .
			'<title>Settings</title>' .
			'<link rel="stylesheet" href="/static/style.css">' .
			'<meta name="viewport" content="width=device-width,initial-scale=1">' .
			'<meta name="robots" content="index,follow">' .
			'<link rel="icon" type="image/x-icon" href="/favicon.ico">' .
			'<meta name="description" content="4get.ca: Settings">' .
			'<link rel="search" type="application/opensearchdescription+xml" title="4get" href="/opensearch.xml">' .
		'</head>' .
		'<body' . $frontend->getthemeclass() . '>';

$left =
	'<h1>Settings</h1>' .
	'<form method="post" autocomplete="off">' .
		'By clicking <div class="code-inline">Update settings!</div>, a plaintext <div class="code-inline">key=value</div> cookie will be stored on your browser. When selecting a default setting, the parameter is removed from your cookies.';

$c = count($_COOKIE);
if($c !== 0){
	
	$left .=
		'<br><br>Your current cookie looks like this:' .
		'<div class="code">';
	
	$code = "";
	
	$ca = 0;
	foreach($_COOKIE as $key => $value){
		
		$code .= $key . "=" . $value;
		
		$ca++;
		if($ca !== $c){
			
			$code .= "; ";
		}
	}
	
	$left .= $frontend->highlightcode($code);
	
	$left .= '</div>';
}else{
	
	$left .=
		'<br><br>You currently don\'t have any cookies set.';
}
		
$left .=
	'<div class="settings">';

foreach($settings as $title){
	
	$left .= '<h2>' . $title["name"] . '</h2>';
	
	foreach($title["settings"] as $setting){
		
		$left .=
			'<div class="setting">' .
				'<div class="title">' . $setting["description"] . '</div>' .
				'<select name="' . $setting["parameter"] . '">';
		
		foreach($setting["options"] as $option){
			
			$left .=
				'<option value="' . $option["value"] . '"';
			
			if(
				isset($_COOKIE[$setting["parameter"]]) &&
				$_COOKIE[$setting["parameter"]] == $option["value"]
			){
				$left .= ' selected';
			}
			
			$left .= '>' . $option["text"] . '</option>';
		}
		
		$left .= '</select></div>';
	}
}

$left .=
	'</div>' .
	'<div class="settings-submit">' .
		'<input type="submit" value="Update settings!">' .
		'<a href="../">&lt; Return to main page</a>' .
	'</div>' .
	'</form>';

echo
	$frontend->load(
		"search.html",
		[
			"class" => "",
			"right-left" => "",
			"right-right" => "",
			"left" => $left
		]
	);
