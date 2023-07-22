<?php

class google{
	
	private const is_class = ".";
	private const is_id = "#";
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("google");
	}
	
	public function getfilters($page){
		
		switch($page){
			
			case "web": return [];/*
				return [
					"country" => [
						"display" => "Country",
						"option" => [
							"zz" => "Instance region",
							"af" => "Afghanistan",
							"al" => "Albania",
							"dz" => "Algeria",
							"as" => "American Samoa",
							"ad" => "Andorra",
							"ao" => "Angola",
							"ag" => "Antigua & Barbuda",
							"ar" => "Argentina",
							"am" => "Armenia",
							"au" => "Australia",
							"at" => "Austria",
							"az" => "Azerbaijan",
							"bs" => "Bahamas",
							"bh" => "Bahrain",
							"bd" => "Bangladesh",
							"by" => "Belarus",
							"be" => "Belgium",
							"bz" => "Belize",
							"bj" => "Benin",
							"bt" => "Bhutan",
							"bo" => "Bolivia",
							"ba" => "Bosnia & Herzegovina",
							"bw" => "Botswana",
							"br" => "Brazil",
							"bn" => "Brunei",
							"bg" => "Bulgaria",
							"bf" => "Burkina Faso",
							"bi" => "Burundi",
							"kh" => "Cambodia",
							"cm" => "Cameroon",
							"ca" => "Canada",
							"cv" => "Cape Verde",
							"cf" => "Central African Republic",
							"td" => "Chad",
							"cl" => "Chile",
							"co" => "Colombia",
							"cg" => "Congo - Brazzaville",
							"cd" => "Congo - Kinshasa",
							"ck" => "Cook Islands",
							"cr" => "Costa Rica",
							"ci" => "Côte d’Ivoire",
							"hr" => "Croatia",
							"cu" => "Cuba",
							"cy" => "Cyprus",
							"cz" => "Czechia",
							"dk" => "Denmark",
							"dj" => "Djibouti",
							"dm" => "Dominica",
							"do" => "Dominican Republic",
							"ec" => "Ecuador",
							"eg" => "Egypt",
							"sv" => "El Salvador",
							"ee" => "Estonia",
							"et" => "Ethiopia",
							"fj" => "Fiji",
							"fi" => "Finland",
							"fr" => "France",
							"ga" => "Gabon",
							"gm" => "Gambia",
							"ge" => "Georgia",
							"de" => "Germany",
							"gh" => "Ghana",
							"gi" => "Gibraltar",
							"gr" => "Greece",
							"gl" => "Greenland",
							"gt" => "Guatemala",
							"gg" => "Guernsey",
							"gy" => "Guyana",
							"ht" => "Haiti",
							"hn" => "Honduras",
							"hk" => "Hong Kong",
							"hu" => "Hungary",
							"is" => "Iceland",
							"in" => "India",
							"id" => "Indonesia",
							"iq" => "Iraq",
							"ie" => "Ireland",
							"im" => "Isle of Man",
							"il" => "Israel",
							"it" => "Italy",
							"jm" => "Jamaica",
							"jp" => "Japan",
							"je" => "Jersey",
							"jo" => "Jordan",
							"kz" => "Kazakhstan",
							"ke" => "Kenya",
							"ki" => "Kiribati",
							"kw" => "Kuwait",
							"kg" => "Kyrgyzstan",
							"la" => "Laos",
							"lv" => "Latvia",
							"lb" => "Lebanon",
							"ls" => "Lesotho",
							"ly" => "Libya",
							"li" => "Liechtenstein",
							"lt" => "Lithuania",
							"lu" => "Luxembourg",
							"mg" => "Madagascar",
							"mw" => "Malawi",
							"my" => "Malaysia",
							"mv" => "Maldives",
							"ml" => "Mali",
							"mt" => "Malta",
							"mu" => "Mauritius",
							"mx" => "Mexico",
							"fm" => "Micronesia",
							"md" => "Moldova",
							"mn" => "Mongolia",
							"me" => "Montenegro",
							"ma" => "Morocco",
							"mz" => "Mozambique",
							"mm" => "Myanmar (Burma)",
							"na" => "Namibia",
							"nr" => "Nauru",
							"np" => "Nepal",
							"nl" => "Netherlands",
							"nz" => "New Zealand",
							"ni" => "Nicaragua",
							"ne" => "Niger",
							"ng" => "Nigeria",
							"nu" => "Niue",
							"mk" => "North Macedonia",
							"no" => "Norway",
							"om" => "Oman",
							"pk" => "Pakistan",
							"ps" => "Palestine",
							"pa" => "Panama",
							"pg" => "Papua New Guinea",
							"py" => "Paraguay",
							"pe" => "Peru",
							"ph" => "Philippines",
							"pn" => "Pitcairn Islands",
							"pl" => "Poland",
							"pt" => "Portugal",
							"pr" => "Puerto Rico",
							"qa" => "Qatar",
							"ro" => "Romania",
							"ru" => "Russia",
							"rw" => "Rwanda",
							"ws" => "Samoa",
							"sm" => "San Marino",
							"st" => "São Tomé & Príncipe",
							"sa" => "Saudi Arabia",
							"sn" => "Senegal",
							"rs" => "Serbia",
							"sc" => "Seychelles",
							"sl" => "Sierra Leone",
							"sg" => "Singapore",
							"sk" => "Slovakia",
							"si" => "Slovenia",
							"sb" => "Solomon Islands",
							"so" => "Somalia",
							"za" => "South Africa",
							"kr" => "South Korea",
							"es" => "Spain",
							"lk" => "Sri Lanka",
							"sh" => "St. Helena",
							"vc" => "St. Vincent & Grenadines",
							"sr" => "Suriname",
							"se" => "Sweden",
							"ch" => "Switzerland",
							"tw" => "Taiwan",
							"tj" => "Tajikistan",
							"tz" => "Tanzania",
							"th" => "Thailand",
							"tl" => "Timor-Leste",
							"tg" => "Togo",
							"to" => "Tonga",
							"tt" => "Trinidad & Tobago",
							"tn" => "Tunisia",
							"tr" => "Türkiye",
							"tm" => "Turkmenistan",
							"vi" => "U.S. Virgin Islands",
							"ug" => "Uganda",
							"ua" => "Ukraine",
							"ae" => "United Arab Emirates",
							"gb" => "United Kingdom",
							"us" => "United States",
							"uy" => "Uruguay",
							"uz" => "Uzbekistan",
							"vu" => "Vanuatu",
							"ve" => "Venezuela",
							"vn" => "Vietnam",
							"zm" => "Zambia",
							"zw" => "Zimbabwe"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes",
							"no" => "No"
						]
					],
					"lang" => [ // prefix with lang_
						"display" => "Language",
						"option" => [
							"any" => "Any language",
							"af" => "Afrikaans",
							"ca" => "català",
							"cs" => "čeština",
							"da" => "dansk",
							"de" => "Deutsch",
							"et" => "eesti",
							"en" => "English",
							"es" => "español",
							"eo" => "esperanto",
							"tl" => "Filipino",
							"fr" => "français",
							"hr" => "hrvatski",
							"id" => "Indonesia",
							"is" => "íslenska",
							"it" => "italiano",
							"sw" => "Kiswahili",
							"lv" => "latviešu",
							"lt" => "lietuvių",
							"hu" => "magyar",
							"nl" => "Nederlands",
							"no" => "norsk",
							"pl" => "polski",
							"pt" => "português",
							"ro" => "română",
							"sk" => "slovenčina",
							"sl" => "slovenščina",
							"fi" => "suomi",
							"sv" => "svenska",
							"vi" => "Tiếng Việt",
							"tr" => "Türkçe",
							"el" => "Ελληνικά",
							"be" => "беларуская",
							"bg" => "български",
							"ru" => "русский",
							"sr" => "српски",
							"uk" => "українська",
							"hy" => "հայերեն",
							"iw" => "עברית",
							"ar" => "العربية",
							"fa" => "فارسی",
							"hi" => "हिन्दी",
							"th" => "ไทย",
							"ko" => "한국어",
							"zh-CN" => "中文 (简体)",
							"zh-TW" => "中文 (繁體)",
							"ja" => "日本語"
						]
					],
					"time" => [
						"display" => "Time posted",
						"option" => [
							"any" => "Any time",
							"h" => "Last hour",
							"d" => "Last 24 hours",
							"w" => "Last week",
							"m" => "Last month",
							"y" => "Last year"
						]
					],
					"verbatim" => [
						"display" => "Verbatim",
						"option" => [
							"no" => "No",
							"yes" => "Yes"
						]
					]
				];*/
				break;
			
			case "images":
				return [
					"country" => [ // gl=<country>
						"display" => "Country",
						"option" => [
							"any" => "Instance's country",
							"af" => "Afghanistan",
							"al" => "Albania",
							"dz" => "Algeria",
							"as" => "American Samoa",
							"ad" => "Andorra",
							"ao" => "Angola",
							"ai" => "Anguilla",
							"aq" => "Antarctica",
							"ag" => "Antigua and Barbuda",
							"ar" => "Argentina",
							"am" => "Armenia",
							"aw" => "Aruba",
							"au" => "Australia",
							"at" => "Austria",
							"az" => "Azerbaijan",
							"bs" => "Bahamas",
							"bh" => "Bahrain",
							"bd" => "Bangladesh",
							"bb" => "Barbados",
							"by" => "Belarus",
							"be" => "Belgium",
							"bz" => "Belize",
							"bj" => "Benin",
							"bm" => "Bermuda",
							"bt" => "Bhutan",
							"bo" => "Bolivia",
							"ba" => "Bosnia and Herzegovina",
							"bw" => "Botswana",
							"bv" => "Bouvet Island",
							"br" => "Brazil",
							"io" => "British Indian Ocean Territory",
							"bn" => "Brunei Darussalam",
							"bg" => "Bulgaria",
							"bf" => "Burkina Faso",
							"bi" => "Burundi",
							"kh" => "Cambodia",
							"cm" => "Cameroon",
							"ca" => "Canada",
							"cv" => "Cape Verde",
							"ky" => "Cayman Islands",
							"cf" => "Central African Republic",
							"td" => "Chad",
							"cl" => "Chile",
							"cn" => "China",
							"cx" => "Christmas Island",
							"cc" => "Cocos (Keeling) Islands",
							"co" => "Colombia",
							"km" => "Comoros",
							"cg" => "Congo",
							"cd" => "Congo, the Democratic Republic of the",
							"ck" => "Cook Islands",
							"cr" => "Costa Rica",
							"ci" => "Cote D'ivoire",
							"hr" => "Croatia",
							"cu" => "Cuba",
							"cy" => "Cyprus",
							"cz" => "Czech Republic",
							"dk" => "Denmark",
							"dj" => "Djibouti",
							"dm" => "Dominica",
							"do" => "Dominican Republic",
							"ec" => "Ecuador",
							"eg" => "Egypt",
							"sv" => "El Salvador",
							"gq" => "Equatorial Guinea",
							"er" => "Eritrea",
							"ee" => "Estonia",
							"et" => "Ethiopia",
							"fk" => "Falkland Islands (Malvinas)",
							"fo" => "Faroe Islands",
							"fj" => "Fiji",
							"fi" => "Finland",
							"fr" => "France",
							"gf" => "French Guiana",
							"pf" => "French Polynesia",
							"tf" => "French Southern Territories",
							"ga" => "Gabon",
							"gm" => "Gambia",
							"ge" => "Georgia",
							"de" => "Germany",
							"gh" => "Ghana",
							"gi" => "Gibraltar",
							"gr" => "Greece",
							"gl" => "Greenland",
							"gd" => "Grenada",
							"gp" => "Guadeloupe",
							"gu" => "Guam",
							"gt" => "Guatemala",
							"gn" => "Guinea",
							"gw" => "Guinea-Bissau",
							"gy" => "Guyana",
							"ht" => "Haiti",
							"hm" => "Heard Island and Mcdonald Islands",
							"va" => "Holy See (Vatican City State)",
							"hn" => "Honduras",
							"hk" => "Hong Kong",
							"hu" => "Hungary",
							"is" => "Iceland",
							"in" => "India",
							"id" => "Indonesia",
							"ir" => "Iran, Islamic Republic of",
							"iq" => "Iraq",
							"ie" => "Ireland",
							"il" => "Israel",
							"it" => "Italy",
							"jm" => "Jamaica",
							"jp" => "Japan",
							"jo" => "Jordan",
							"kz" => "Kazakhstan",
							"ke" => "Kenya",
							"ki" => "Kiribati",
							"kp" => "Korea, Democratic People's Republic of",
							"kr" => "Korea, Republic of",
							"kw" => "Kuwait",
							"kg" => "Kyrgyzstan",
							"la" => "Lao People's Democratic Republic",
							"lv" => "Latvia",
							"lb" => "Lebanon",
							"ls" => "Lesotho",
							"lr" => "Liberia",
							"ly" => "Libyan Arab Jamahiriya",
							"li" => "Liechtenstein",
							"lt" => "Lithuania",
							"lu" => "Luxembourg",
							"mo" => "Macao",
							"mk" => "Macedonia, the Former Yugosalv Republic of",
							"mg" => "Madagascar",
							"mw" => "Malawi",
							"my" => "Malaysia",
							"mv" => "Maldives",
							"ml" => "Mali",
							"mt" => "Malta",
							"mh" => "Marshall Islands",
							"mq" => "Martinique",
							"mr" => "Mauritania",
							"mu" => "Mauritius",
							"yt" => "Mayotte",
							"mx" => "Mexico",
							"fm" => "Micronesia, Federated States of",
							"md" => "Moldova, Republic of",
							"mc" => "Monaco",
							"mn" => "Mongolia",
							"ms" => "Montserrat",
							"ma" => "Morocco",
							"mz" => "Mozambique",
							"mm" => "Myanmar",
							"na" => "Namibia",
							"nr" => "Nauru",
							"np" => "Nepal",
							"nl" => "Netherlands",
							"an" => "Netherlands Antilles",
							"nc" => "New Caledonia",
							"nz" => "New Zealand",
							"ni" => "Nicaragua",
							"ne" => "Niger",
							"ng" => "Nigeria",
							"nu" => "Niue",
							"nf" => "Norfolk Island",
							"mp" => "Northern Mariana Islands",
							"no" => "Norway",
							"om" => "Oman",
							"pk" => "Pakistan",
							"pw" => "Palau",
							"ps" => "Palestinian Territory, Occupied",
							"pa" => "Panama",
							"pg" => "Papua New Guinea",
							"py" => "Paraguay",
							"pe" => "Peru",
							"ph" => "Philippines",
							"pn" => "Pitcairn",
							"pl" => "Poland",
							"pt" => "Portugal",
							"pr" => "Puerto Rico",
							"qa" => "Qatar",
							"re" => "Reunion",
							"ro" => "Romania",
							"ru" => "Russian Federation",
							"rw" => "Rwanda",
							"sh" => "Saint Helena",
							"kn" => "Saint Kitts and Nevis",
							"lc" => "Saint Lucia",
							"pm" => "Saint Pierre and Miquelon",
							"vc" => "Saint Vincent and the Grenadines",
							"ws" => "Samoa",
							"sm" => "San Marino",
							"st" => "Sao Tome and Principe",
							"sa" => "Saudi Arabia",
							"sn" => "Senegal",
							"cs" => "Serbia and Montenegro",
							"sc" => "Seychelles",
							"sl" => "Sierra Leone",
							"sg" => "Singapore",
							"sk" => "Slovakia",
							"si" => "Slovenia",
							"sb" => "Solomon Islands",
							"so" => "Somalia",
							"za" => "South Africa",
							"gs" => "South Georgia and the South Sandwich Islands",
							"es" => "Spain",
							"lk" => "Sri Lanka",
							"sd" => "Sudan",
							"sr" => "Suriname",
							"sj" => "Svalbard and Jan Mayen",
							"sz" => "Swaziland",
							"se" => "Sweden",
							"ch" => "Switzerland",
							"sy" => "Syrian Arab Republic",
							"tw" => "Taiwan, Province of China",
							"tj" => "Tajikistan",
							"tz" => "Tanzania, United Republic of",
							"th" => "Thailand",
							"tl" => "Timor-Leste",
							"tg" => "Togo",
							"tk" => "Tokelau",
							"to" => "Tonga",
							"tt" => "Trinidad and Tobago",
							"tn" => "Tunisia",
							"tr" => "Turkey",
							"tm" => "Turkmenistan",
							"tc" => "Turks and Caicos Islands",
							"tv" => "Tuvalu",
							"ug" => "Uganda",
							"ua" => "Ukraine",
							"ae" => "United Arab Emirates",
							"uk" => "United Kingdom",
							"us" => "United States",
							"um" => "United States Minor Outlying Islands",
							"uy" => "Uruguay",
							"uz" => "Uzbekistan",
							"vu" => "Vanuatu",
							"ve" => "Venezuela",
							"vn" => "Viet Nam",
							"vg" => "Virgin Islands, British",
							"vi" => "Virgin Islands, U.S.",
							"wf" => "Wallis and Futuna",
							"eh" => "Western Sahara",
							"ye" => "Yemen",
							"zm" => "Zambia",
							"zw" => "Zimbabwe"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes", // safe=active
							"no" => "No" // safe=off
						]
					],
					"lang" => [ // lr=<lang> (prefix lang with "lang_")
						"display" => "Language",
						"option" => [
							"any" => "Any language",
							"ar" => "Arabic",
							"bg" => "Bulgarian",
							"ca" => "Catalan",
							"cs" => "Czech",
							"da" => "Danish",
							"de" => "German",
							"el" => "Greek",
							"en" => "English",
							"es" => "Spanish",
							"et" => "Estonian",
							"fi" => "Finnish",
							"fr" => "French",
							"hr" => "Croatian",
							"hu" => "Hungarian",
							"id" => "Indonesian",
							"is" => "Icelandic",
							"it" => "Italian",
							"iw" => "Hebrew",
							"ja" => "Japanese",
							"ko" => "Korean",
							"lt" => "Lithuanian",
							"lv" => "Latvian",
							"nl" => "Dutch",
							"no" => "Norwegian",
							"pl" => "Polish",
							"pt" => "Portuguese",
							"ro" => "Romanian",
							"ru" => "Russian",
							"sk" => "Slovak",
							"sl" => "Slovenian",
							"sr" => "Serbian",
							"sv" => "Swedish",
							"tr" => "Turkish",
							"zh-CN" => "Chinese (Simplified)",
							"zh-TW" => "Chinese (Traditional)"
						]
					],
					"newer" => [ // &sort=review-date:r:20090301:20090430
						"display" => "Newer than",
						"option" => "_DATE"
					],
					"older" => [
						"display" => "Older than",
						"option" => "_DATE"
					],
					"size" => [ // tbs=isz:<size>
						"display" => "Size",
						"option" => [
							"any" => "Any size",
							"l" => "Large",
							"m" => "Medium",
							"i" => "Icon"
						]
					],
					"color" => [ // tbs=ic:<color>
						"display" => "Color",
						"option" => [
							"any" => "Any color",
							"gray" => "Black and white",
							"trans" => "Transparent",
							// from here, format is
							// tbs=specific,isc:<color>
							"red" => "Red",
							"orange" => "Orange",
							"yellow" => "Yellow",
							"green" => "Green",
							"teal" => "Teal",
							"blue" => "Blue",
							"purple" => "Purple",
							"pink" => "Pink",
							"white" => "White",
							"gray" => "Gray",
							"black" => "Black",
							"brown" => "Brown"
						]
					],
					"type" => [ // tbs=itp:<type>
						"display" => "Type",
						"option" => [
							"any" => "Any type",
							"clipart" => "Clip Art",
							"lineart" => "Line Drawing",
							"animated" => "GIF"
						]
					],
					"rights" => [ // tbs=il:<rights>
						"display" => "Usage rights",
						"option" => [
							"any" => "No license",
							"cl" => "Creative Commons licenses",
							"ol" => "Commercial & other licenses"
						]
					]
				];
				break;
		}
	}
	
	private function get($url, $get = []){
		
		$headers = [
			"User-Agent: Mozilla/5.0 (Linux; U; Android 2.3.3; pt-pt; LG-P500h-parrot Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 MMS/LG-Android-MMS-V1.0/1.2",
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"DNT: 1",
			"Connection: keep-alive",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: none",
			"Sec-Fetch-User: ?1"
		];
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function web($get){
		
		$handle = fopen("scraper/google.html", "r");
		$html = fread($handle, filesize("scraper/google.html"));
		fclose($handle);
		
		$this->fuckhtml->load($html);
		
		$out = [
			"status" => "ok",
			"spelling" => [
				"type" => "no_correction",
				"using" => null,
				"correction" => null
			],
			"npt" => null,
			"answer" => [],
			"web" => [],
			"image" => [],
			"video" => [],
			"news" => [],
			"related" => []
		];
		
		$styles =
			$this->fuckhtml
			->getElementsByTagName("style");
		
		$this->computedstyle = [];
		
		foreach($styles as $style){
			
			$this->computedstyle =
				array_merge(
					$this->computedstyle,
					$this->parsestyles($style["innerHTML"])
				);	
		}
		
		// get images in javascript var
		preg_match(
			'/google\.ldi=({[^}]+})/',
			$html,
			$js_image
		);
		
		if(count($js_image) !== 0){
			
			$js_image = json_decode($js_image[1], true);
		}else{
			
			$js_image = [];
		}
		
		// get nodes
		// fuck you google!!!!!!!!!!!!!!
		
		$containers =
			$this->fuckhtml
			->getElementsByClassName(
				$this->findstyles(
					[
						"background-color" => "#fff",
						"margin-bottom" => "10px",
						"-webkit-box-shadow" => "0 1px 6px rgba(32,33,36,0.28)",
						"border-radius" => "8px"
					],
					self::is_class
				),
				"div"
			);
		
		foreach($containers as $container){
			
			$this->fuckhtml->load($container);
			
			// get link at the top
			$link =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($link) !== 0){
				
				$link =
					$this->decodeurl(
						$link
						[0]
						["attributes"]
						["href"]
					);
			}
			
			/*
				Check for carousel presence
			*/
			$carousel =
				$this->fuckhtml
				->getElementsByClassName(
					"pcitem",
					"div"
				);
			
			$title =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"color" => "#1967d2",
							"font-size" => "20px",
							"line-height" => "26px"
						],
						self::is_class
					),
					"div"
				);
			
			$carousel_title =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"font-size" => "16px",
							"line-height" => "20px",
							"font-weight" => "400"
						],
						self::is_class
					),
					"div"
				);
			
			if(count($carousel) !== 0){
				
				$sublink = []; // twitter carousel sublinks
				foreach($carousel as $item){
					
					$this->fuckhtml->load($item);
					
					$url =
						$this->decodeurl(
							$this->fuckhtml
							->getElementsByTagName(
								"a"
							)[0]
							["attributes"]
							["href"]
						);
					
					// detect if its a twitter carousel or
					// a list of news articles
					
					$grey_node =
						$this->fuckhtml
						->getElementsByClassName(
							$this->findstyles(
								[
									"white-space" => "pre-line",
									"word-wrap" => "break-word"
								],
								self::is_class
							),
							"div"
						);
					
					if(count($carousel_title) !== 0){
						
						if(
							$this->fuckhtml
							->getTextContent(
								$carousel_title[0]
							)
							== "Top stories"
						){
							
							$img =
								$this->fuckhtml
								->getElementsByTagName("img");
							
							if(
								count($img) !== 0 &&
								isset($img[0]["attributes"]["id"]) &&
								isset($js_image[$img[0]["attributes"]["id"]])
							){
								
								$img = [
									"url" => $js_image[$img[0]["attributes"]["id"]],
									"ratio" => "16:9"
								];
							}else{
								
								$img = [
									"url" => null,
									"ratio" => null
								];
							}
							
							/*
								Is a news node
							*/
							$out["news"][] = [
								"title" =>
									$this->fuckhtml
									->getTextContent(
										$grey_node[0]
									),
								"description" => null,
								"date" =>
									strtotime(
										explode(
											"\n",
											$grey_node[1]["innerHTML"]
										)[1]
									),
								"thumb" => $img,
								"url" => $url
							];
						}
					}else{
						
						/*
							Is a web node (twitter-like)
							create a link -> sublink structure and
							ignore images
						*/
						
						switch(count($grey_node)){
							
							case 0:
								continue 2;
							
							case 1:
								$sublink_title = $grey_node[0];
								$sublink_description = null;
								break;
							
							case 2:
								$sublink_title = $grey_node[1];
								$sublink_description =
									$this->titledots(
										$this->fuckhtml
										->getTextContent(
											$grey_node[0]
										)
									);
								break;
						}
						
						$sublink_url =
							$this->decodeurl(
								$this->fuckhtml
								->getTextContent(
									$this->fuckhtml
									->getElementsByTagName(
										"a"
									)[0]
									["attributes"]
									["href"]
								)
							);
						
						if($link == $sublink_url){
						
							continue;
						}
						
						$sublink_title =
							explode(
								" • ",
								$this->fuckhtml
								->getTextContent(
									$sublink_title["innerHTML"]
								)
							);
						
						if(count($sublink_title) !== 1){
							
							$date = strtotime($sublink_title[1]);
						}else{
							
							$date = null;
						}
						
						$sublink_title = $this->titledots($sublink_title[0]);
						
						$sublink[] = [
							"title" => $sublink_title,
							"date" => $date,
							"description" => $sublink_description,
							"url" => $sublink_url
						];
					}
				}
				
				// if it was a web node
				if(count($sublink) !== 0){
					
					$out["web"][] = [
						"title" =>
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$title[0]
								)
							),
						"description" => null,
						"url" => $url,
						"date" => null,
						"type" => "web",
						"thumb" => [
							"url" => null,
							"ratio" => null
						],
						"sublink" => $sublink,
						"table" => []
					];
				}
				
				continue;
			}
			
			if(count($title) !== 0){
				
				/*
					Get WEB search results
				*/
				
				$thumb =
					$this->fuckhtml
					->getElementsByTagName("img");
				
				if(
					count($thumb) !== 0 &&
					isset($js_image[$thumb[0]["attributes"]["id"]])
				){
					
					$thumb = [
						"url" =>
							$js_image[$thumb[0]["attributes"]["id"]],
						"ratio" => "1:1"
					];
				}else{
					
					$thumb = [
						"url" => null,
						"ratio" => null
					];
				}
				
				// this contains description, sublinks
				$inner_category =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"white-space" => "pre-line",
								"word-wrap" => "break-word"
							],
							self::is_class
						),
						"div"
					);
				
				// set empty values
				$description = null;
				$table = [];
				$sublinks = [];
				$date = null;
				
				foreach($inner_category as $category){
					
					if($category["level"] !== 6){
						
						// enterring protocol 6
						// and u dont seem to understaaaaandddddd
						continue;
					}
					
					$this->fuckhtml->load($category);
					
					// check if its a table
					preg_match(
						'/^[A-z0-9 ]+: <span/',
						$category["innerHTML"],
						$tablematch
					);
					
					if(count($tablematch) !== 0){
						
						$categories = explode("<br>", $category["innerHTML"]);
						
						foreach($categories as $cat){
							
							$cat = explode(":", $cat, 2);
							
							$table[
								$this->fuckhtml
								->getTextContent(
									$cat[0]
								)
							] =
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$cat[1]
									)
								);
						}
						continue;
					}
					
					$spans =
						$this->fuckhtml
						->getElementsByTagName("span");
					
					foreach($spans as $span){
						
						// replace element with nothing
						if(empty($description)){
							$category["innerHTML"] =
								str_replace(
									$span["outerHTML"],
									"",
									$category["innerHTML"]
								);
						}
						
						// get rating
						if(isset($span["attributes"]["aria-hidden"])){
							
							$table["Rating"] = $span["innerHTML"];
							continue;
						}
					}
					
					if(empty($description)){
						
						$description =
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$category
								)
							);
					}
				}
				
				// check if traversed div is the description
				/*
				if(
					count(
						$this->fuckhtml
						->getElementsByTagName("*")
					) === 0
				){
					
					$description =
						$this->fuckhtml
						->getTextContent($inner_category);
				}else{
					
					$this->
					
					// we need to traverse description struct
					foreach($inner_category as $category){
						
						// detect description
						$this->fuckhtml->load($category);
						
						$spans =
							$this->fuckhtml
							->getElementsByTagName("span");
						
						$is_desc = false;
						$is_first_span = true;
						
						foreach($spans as $span){
							
							// get rating
							if(isset($span["attributes"]["aria-hidden"])){
								
								$table["Rating"] = $span["innerHTML"] . "/5";
								continue;
							}
							
							// get date posted
							if(
								$is_first_span &&
								$date_tmp = strtotime($span["innerHTML"])
							){
								
								$date = $date_tmp;
								continue;
							}
							
							$is_first_span = false;
						}
					}
				}*/
				
				// get sublinks
				$this->fuckhtml->load($container["innerHTML"]);
				
				$as =
					$this->fuckhtml->getElementsByTagName("a");
				
				foreach($as as $a){
					
					$this->fuckhtml->load($a);
					
					$detect =
						$this->fuckhtml
						->getElementsByClassName(
							$this->findstyles(
								[
									"color" => "#1967d2",
									"font-size" => "14px",
									"line-height" => "20px"
								],
								self::is_class
							),
							"span"
						);
					
					if(count($detect) !== 0){
						
						$sublinks[] = [
							"title" =>
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$a
									)
								),
							"date" => null,
							"description" => null,
							"url" =>
								$this->decodeurl(
									$a["attributes"]["href"]
								)
						];
					}
				}
				
				$data = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$title[0]
							)
						),
					"description" => $description,
					"url" => $link,
					"date" => $date,
					"type" => "web",
					"thumb" => $thumb,
					"sublink" => $sublinks,
					"table" => $table
				];
				
				$out["web"][] = $data;
				
				continue;
			}
			
			/*
				Check related searches node
			*/
			$relateds =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"display" => "block",
							"position" => "relative",
							"width" => "100%"
						],
						self::is_class
					),
					"a"
				);
			
			if(count($relateds) !== 0){
				
				foreach($relateds as $related){
					
					$out["related"][] =
						$this->fuckhtml
						->getTextContent(
							$related
						);
				}
			}
			
			/*
				Get next page
			*/
			$nextpage =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"-webkit-box-flex" => "1",
							"display" => "block"
						],
						self::is_class
					),
					"a"
				);
			
			if(count($nextpage) !== 0){
				
				$out["npt"] =
					explode(
						"?",
						$this->fuckhtml
						->getTextContent(
							$nextpage[0]
							["attributes"]
							["href"]
						)
					)[1];
			}
		}
		
		return $out;
	}
	
	public function image($get){
		
		$handle = fopen("scraper/google-img.html", "r");
		$html = fread($handle, filesize("scraper/google-img.html"));
		fclose($handle);
		
		$this->fuckhtml->load($html);
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		$images =
			$this->fuckhtml
			->getElementsByClassName(
				"islrtb isv-r",
				"div"
			);
		
		// get next page
		// https://www.google.com/search
		// ?q=higurashi
		// &tbm=isch
		// &async=_id%3Aislrg_c%2C_fmt%3Ahtml
		// &asearch=ichunklite
		// &ved=0ahUKEwidjYXJqJSAAxWrElkFHZ07CDwQtDIIQygA
		$ved =
			$this->fuckhtml
			->getElementById("islrg", "div");
		
		if($ved){
			
			$ved =
				$this->fuckhtml
				->getTextContent(
					$ved["attributes"]["data-ved"]
				);
			
			// &vet=1{$ved}..i (10ahUKEwidjYXJqJSAAxWrElkFHZ07CDwQtDIIQygA..i)
			
			/*
				These 2 are handled by us
				start = start + number of results
				ijn = current page number
			*/
			// &start=100
			// &ijn=1
			
			// &imgvl=CAEY7gQgBSj3Aji8VTjXVUC4AUC3AUgAYNdV
			preg_match(
				'/var e=\'([A-z0-9]+)\';/',
				$html,
				$imgvl
			);
			
			$imgvl = $imgvl[1];
			
			$out["npt"] = [
				"q" => $get["s"],
				"tbm" => "isch",
				"async" => "_id:islrg_c,_fmt:html",
				"asearch" => "ichunklite",
				"ved" => $ved,
				"vet" => "1" . $ved . "..i",
				"start" => 100,
				"ijn" => 1,
				"imgvl" => $imgvl
			];
		}
		
		foreach($images as $image){
			
			$this->fuckhtml->load($image);
			$img =
				$this->fuckhtml
				->getElementsByTagName("img")[0];
			
			$og_width = (int)$image["attributes"]["data-ow"];
			$og_height = (int)$image["attributes"]["data-oh"];
			$thumb_width = (int)$image["attributes"]["data-tw"];
			
			$ratio = $og_width / $og_height;
			
			if(isset($img["attributes"]["data-src"])){
				
				$src = &$img["attributes"]["data-src"];
			}else{
				
				$src = &$img["attributes"]["src"];
			}
			
			$thumb_height = floor($thumb_width / $ratio);
			
			$out["image"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$image["attributes"]["data-pt"]
						)
					),
				"source" => [
					[
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$image["attributes"]["data-ou"]
							),
						"width" => $og_width,
						"height" => $og_height
					],
					[
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$src
							),
						"width" => $thumb_width,
						"height" => $thumb_height
					]
				],
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$image["attributes"]["data-ru"]
					)
			];
		}
		
		return $out;
	}
	
	private function findstyles($rules, $is){
		
		ksort($rules);
		
		foreach($this->computedstyle as $stylename => $styles){
			
			if($styles == $rules){
				
				preg_match(
					'/\\' . $is . '([^ .]+)/',
					$stylename,
					$out
				);
				
				if(count($out) === 2){
					
					return $out[1];
				}
				
				return false;
			}
		}
		
		return false;
	}
	
	private function parsestyles($style){
		
		// get style tags
		preg_match_all(
			'/([^{]+){([^}]+)}/',
			$style,
			$tags_regex
		);
		
		$tags = [];
		
		for($i=0; $i<count($tags_regex[0]); $i++){
			
			$tagnames = explode(",", trim($tags_regex[1][$i]));
			
			foreach($tagnames as $tagname){
				
				$tagname = trim($tagname);
				
				if(!isset($tags[$tagname])){
					$tags[$tagname] = [];
				}
				
				$values = explode(";", $tags_regex[2][$i]);
				
				foreach($values as $value){
					
					$value = explode(":", $value, 2);
					
					if(count($value) !== 2){
						
						continue;
					}
					
					$tags[$tagname][trim($value[0])] =
						trim($value[1]);
				}
			}
		}
		
		foreach($tags as &$value){
			
			ksort($value);
		}
		
		return $tags;
	}
	
	private function decodeurl($url){
		
		preg_match(
			'/^\/url\?q=([^&]+)|^\/interstitial\?url=([^&]+)/',
			$this->fuckhtml
			->getTextContent($url),
			$match
		);
		
		if(count($match) !== 0){
			
			if(!empty($match[1])){
				
				return urldecode($match[1]);
			}
			
			if(!empty($match[2])){
					
				return urldecode($match[2]);
			}
		}
		
		return null;
	}
	
	private function titledots($title){
		
		return rtrim($title, ".… \t\n\r\0\x0B");
	}
}
	
