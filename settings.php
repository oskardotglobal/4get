<?php

include "data/config.php";

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
				"options" => []
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
				"description" => "Autocomplete<br><i>Picking <span class=\"code-inline\">Auto</span> changes the source dynamically depending of the page's scraper<br><b>Warning:</b> If you edit this field, you will need to re-add the search engine so that the new autocomplete settings are applied!</i>",
				"parameter" => "scraper_ac",
				"options" => [
					[
						"value" => "disabled",
						"text" => "Disabled"
					],
					[
						"value" => "auto",
						"text" => "Auto"
					],
					[
						"value" => "brave",
						"text" => "Brave"
					],
					[
						"value" => "ddg",
						"text" => "DuckDuckGo"
					],
					[
						"value" => "yandex",
						"text" => "Yandex"
					],
					[
						"value" => "google",
						"text" => "Google"
					],
					[
						"value" => "startpage",
						"text" => "Startpage"
					],
					[
						"value" => "kagi",
						"text" => "Kagi"
					],
					[
						"value" => "qwant",
						"text" => "Qwant"
					],
					[
						"value" => "ghostery",
						"text" => "Ghostery"
					],
					[
						"value" => "yep",
						"text" => "Yep"
					],
					[
						"value" => "marginalia",
						"text" => "Marginalia"
					],
					[
						"value" => "yt",
						"text" => "YouTube"
					],
					[
						"value" => "sc",
						"text" => "SoundCloud"
					]
				]
			],
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
					[
						"value" => "google",
						"text" => "Google"
					],
					[
						"value" => "google_cse",
						"text" => "Google CSE"
					],
					[
						"value" => "startpage",
						"text" => "Startpage"
					],
					[
						"value" => "qwant",
						"text" => "Qwant"
					],
					[
						"value" => "ghostery",
						"text" => "Ghostery"
					],
					[
						"value" => "yep",
						"text" => "Yep"
					],
					[
						"value" => "greppr",
						"text" => "Greppr"
					],
					[
						"value" => "crowdview",
						"text" => "Crowdview"
					],
					[
						"value" => "mwmbl",
						"text" => "Mwmbl"
					],
					[
						"value" => "mojeek",
						"text" => "Mojeek"
					],
					[
						"value" => "solofield",
						"text" => "Solofield"
					],
					[
						"value" => "marginalia",
						"text" => "Marginalia"
					],
					[
						"value" => "wiby",
						"text" => "wiby"
					],
					[
						"value" => "curlie",
						"text" => "Curlie"
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
					],
					[
						"value" => "google_cse",
						"text" => "Google CSE"
					],
					[
						"value" => "startpage",
						"text" => "Startpage"
					],
					[
						"value" => "qwant",
						"text" => "Qwant"
					],
					[
						"value" => "yep",
						"text" => "Yep"
					],
					[
						"value" => "solofield",
						"text" => "Solofield"
					],
					/*[
						"value" => "pinterest",
						"text" => "Pinterest"
					],*/
					[
						"value" => "imgur",
						"text" => "Imgur"
					],
					[
						"value" => "ftm",
						"text" => "FindThatMeme"
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
					],
					[
						"value" => "google",
						"text" => "Google"
					],
					[
						"value" => "startpage",
						"text" => "Startpage"
					],
					[
						"value" => "qwant",
						"text" => "Qwant"
					],
					[
						"value" => "solofield",
						"text" => "Solofield"
					]
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
					[
						"value" => "google",
						"text" => "Google"
					],
					[
						"value" => "startpage",
						"text" => "Startpage"
					],
					[
						"value" => "qwant",
						"text" => "Qwant"
					],
					[
						"value" => "yep",
						"text" => "Yep"
					],
					[
						"value" => "mojeek",
						"text" => "Mojeek"
					]
				]
			],
			[
				"description" => "Music",
				"parameter" => "scraper_music",
				"options" => [
					[
						"value" => "sc",
						"text" => "SoundCloud"
					]//,
					//[
					//	"value" => "spotify",
					//	"text" => "Spotify"
					//]
				]
			]
		]
	]
];

/*
	Set theme collection
*/
$themes = glob("static/themes/*");

$settings[0]["settings"][1]["options"][] = [
	"value" => "Dark",
	"text" => "Dark"
];

foreach($themes as $theme){
	
	$theme = explode(".", basename($theme))[0];
	
	$settings[0]["settings"][1]["options"][] = [
		"value" => $theme,
		"text" => $theme
	];
}

/*
	Set cookies
*/
if($_POST){

	$loop = &$_POST;
}elseif(count($_GET) !== 0){
	
	// redirect user to front page
	$loop = &$_GET;
	header("Location: /");
	
}else{
	// refresh cookie dates
	$loop = &$_COOKIE;
}

foreach($loop as $key => $value){
	
	if($key == "theme"){
		
		if($value == config::DEFAULT_THEME){
			
			unset($_COOKIE[$key]);
			
			setcookie(
				"theme",
				"",
				[
					"expires" => -1, // removes cookie
					"samesite" => "Lax",
					"path" => "/"
				]
			);
			continue;
		}
	}else{
		
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
							"samesite" => "Lax",
							"path" => "/"
						]
					);
					
					continue 3;
				}
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
			"samesite" => "Lax",
			"path" => "/"
		]
	);
}

include "lib/frontend.php";
$frontend = new frontend();

echo
	$frontend->load(
		"header_nofilters.html",
		[
			"title" => "Settings",
			"class" => ""
		]
	);

$left =
	'<h1>Settings</h1>' .
	'<form method="post" autocomplete="off">' .
		'By clicking <div class="code-inline">Update settings!</div>, a plaintext <div class="code-inline">key=value</div> cookie will be stored on your browser. When selecting a default setting, the parameter is removed from your cookies.';

$c = count($_COOKIE);
$code = "";

if($c !== 0){
	
	$left .=
		'<br><br>Your current cookie looks like this:' .
		'<div class="code">';
	
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
		
		if($setting["parameter"] == "theme"){
			
			if(!isset($_COOKIE["theme"])){
				
				$_COOKIE["theme"] = config::DEFAULT_THEME;
			}
		}
		
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
		'<a href="../">&lt; Go back</a>' .
	'</div>' .
	'</form>';

if(count($_GET) === 0){
	
	$code = [];
	foreach($_COOKIE as $key => $value){
		
		$code[] = rawurlencode($key) . "=" . rawurlencode($value);
	}
	
	$code = implode("&", $code);
	
	if($code != ""){
		
		$code = "?" . $code;
	}
	
	echo
		$frontend->load(
			"search.html",
			[
				"timetaken" => null,
				"class" => "",
				"right-left" =>			
					'<div class="infobox"><h2>Preference link</h2>Following this link will re-apply all cookies configured here and will redirect you to the front page. Useful if your browser clears out cookies after a browsing session.<br><br>' .
					'<a href="settings' . $code . '">Bookmark me!</a>' .
					'</div>',
				"right-right" => "",
				"left" => $left
			]
		);
}
