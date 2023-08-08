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
			
			case "web":
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
							"cd" => "Congo, the Democratic Republic",
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
							"ir" => "Iran, Islamic Republic",
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
							"kp" => "Korea, Democratic People's Republic",
							"kr" => "Korea, Republic",
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
							"mk" => "Macedonia, the Former Yugosalv Republic",
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
							"fm" => "Micronesia, Federated States",
							"md" => "Moldova, Republic",
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
							"tz" => "Tanzania, United Republic",
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
					]
				];
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
							"cd" => "Congo, the Democratic Republic",
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
							"ir" => "Iran, Islamic Republic",
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
							"kp" => "Korea, Democratic People's Republic",
							"kr" => "Korea, Republic",
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
							"mk" => "Macedonia, the Former Yugosalv Republic",
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
							"fm" => "Micronesia, Federated States",
							"md" => "Moldova, Republic",
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
							"tz" => "Tanzania, United Republic",
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
					"colortype" => [ // imgColorType=<color>
						"display" => "Color type",
						"option" => [
							"any" => "Any color type",
							"color" => "Colored",
							"gray" => "Gray",
							"mono" => "Black & white",
							"trans" => "Transparent"
						]
					],
					"color" => [ // imgDominantColor=<color>
						"display" => "Color",
						"option" => [
							"any" => "Any color",
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
					"type" => [ // imgType=<type>
						"display" => "Type",
						"option" => [
							"any" => "Any type",
							"face" => "Faces",
							"clipart" => "Clip Art",
							"lineart" => "Line Drawing",
							"stock" => "Stock",
							"animated" => "Animated"
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
		
		$search = $get["s"];
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		$lang = $get["lang"];
		$older = $get["older"];
		$newer = $get["newer"];
		
		$params = [
			"num" => 20 // get 20 results
		];
		
		// country
		if($country != "any"){
			
			$params["gl"] = $country;
		}
		
		// nsfw
		$params["safe"] = $nsfw == "yes" ? "off" : "active";
		
		// language
		if($lang != "any"){
			
			$params["lr"] = "lang_" . $lang;
		}
		
		// &sort=review-date:r:20090301:20090430
		$older = $older === false ? false : date("Ymd", $older);
		$newer = $newer === false ? false : date("Ymd", $newer);
		
		if(
			$older !== false &&
			$newer === false
		){
			
			$newer = date("Ymd", time());
		}
		
		if(
			$older !== false ||
			$newer !== false
		){
			
			$params["sort"] = "review-date:r:" . $older . ":" . $newer;
		}
		
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
		$this->ask = [];
		
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
			$this->js_image
		);
		
		if(count($this->js_image) !== 0){
			
			$this->js_image = json_decode($this->js_image[1], true);
		}else{
			
			$this->js_image = [];
		}
		
		// additional js_images present in <script> tags
		// ugh i fucking hate you
		$scripts =
			$this->fuckhtml
			->getElementsByTagName("script");
		
		foreach($scripts as $script){
			
			if(!isset($script["innerHTML"])){
				
				continue;
			}
			
			preg_match_all(
				'/var s=\'(data:image[^\']+)\';var i=\[\'([^\']+)\'];/',
				$script["innerHTML"],
				$image_grep
			);
			
			if(count($image_grep[0]) !== 0){
				
				$this->js_image[trim($image_grep[2][0])] =
					$this->fuckhtml
					->getTextContent(
						$image_grep[1][0]
					);
			}
			
			// even more javascript crap
			// "People also ask" node is loaded trough javascript
			preg_match_all(
				'/window\.jsl\.dh\(\'([^\']+)\',\'(.+)\'\);/',
				$script["innerHTML"],
				$ask_grep
			);
			
			for($i=0; $i<count($ask_grep[0]); $i++){
				
				$this->ask[trim($ask_grep[1][$i])] =
					stripcslashes(
						$ask_grep[2][$i]
					);
			}
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
			
			if(count($carousel) !== 0){
				
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
						
						switch(
							strtolower(
								$this->fuckhtml
								->getTextContent(
									$carousel_title[0]
								)
							)
						){
							
							case "top stories":
								$img =
									$this->fuckhtml
									->getElementsByTagName("img");
								
								if(
									count($img) !== 0 &&
									isset($img[0]["attributes"]["id"]) &&
									isset($this->js_image[$img[0]["attributes"]["id"]])
								){
									
									$img = [
										"url" => $this->getimage($img[0]["attributes"]["id"]),
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
								break;
							
							case "images":
								
								/*
									We found an image
								*/
								$imagedata =
									$this->fuckhtml
									->getElementsByClassName(
										$this->findstyles(
											[
												"display" => "block",
												"background-color" => "#fff",
												"border-radius" => "8px",
												"-webkit-box-shadow" => "0 1px 6px rgba(32, 33, 36, 0.28)",
												"overflow" => "hidden"
											],
											self::is_class
										),
										"a"
									);
								
								if(count($imagedata) === 0){
									
									break;
								}
								
								$imagedata = $imagedata[0];
								
								// https://www.google.com/imgres?imgurl=https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Joe_Biden_presidential_portrait_%2528cropped%2529.jpg/220px-Joe_Biden_presidential_portrait_%2528cropped%2529.jpg&imgrefurl=https://en.wikipedia.org/wiki/President_of_the_United_States&h=293&w=220&tbnid=kkQHBIAMuTitdM&q=who+is+the+president+of+the+united+states&tbnh=115&tbnw=86&usg=AI4_-kQVKi-K2zTGmVkS75_Fo6VldpPxsg&vet=1&docid=d2vgvyYSkU0hiM&sa=X&ved=2ahUKEwjKrMT17KyAAxV1j4kEHRAVCoYQ9QF6BAgFEAQ
								parse_str(
									parse_url(
										$this->fuckhtml
										->getTextContent(
											$imagedata["attributes"]["href"]
										),
										PHP_URL_QUERY	
									),
									$params
								);
								
								$image =
									$this->fuckhtml
									->getElementsByTagName("img")[0];
								
								if(isset($this->js_image[$image["attributes"]["id"]])){
									
									$thumbimg = $this->getimage($image["attributes"]["id"]);
								}else{
									
									$thumbimg =
										$this->fuckhtml
										->getTextContent(
											$image["attributes"]["src"]
										);
								}
								
								$out["image"][] = [
									"title" =>
										$this->titledots(
											$this->fuckhtml
											->getTextContent(
												$image["attributes"]["alt"]
											)
										),
									"source" => [
										[
											"url" => $params["imgurl"],
											"width" => (int)$params["w"],
											"height" => (int)$params["h"]
										],
										[
											"url" => $thumbimg,
											"width" => (int)$params["tbnw"],
											"height" => (int)$params["tbnh"]
										]
									],
									"url" => $params["imgrefurl"]
								];
								break;
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
			
			$people_title =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"font-weight" => "bold",
							"font-size" => "16px",
							"color" => "#000",
							"margin" => "0",
							"padding" => "12px 16px 0 16px"
						],
						self::is_class
					),
					"div"
				);
			
			if(
				count($people_title) !== 0 &&
				strtolower(
					$this->fuckhtml
					->getTextContent(
						$people_title[0]
					)
				) == "people also ask"
			){
				/*
					Parse "people also ask" node
				*/
				
				$div =
					$this->fuckhtml
					->getElementsByTagName("div");
				
				// add suggestions
				$suggestions =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"display" => "inline-block",
								"padding-right" => "26px"
							],
							self::is_class
						),
						$div
					);
				
				foreach($suggestions as $suggestion){
					
					$out["related"][] =
						$this->fuckhtml
						->getTextContent($suggestion);
				}
				
				// parse websites
				foreach($div as $d){
					
					if(
						isset($d["attributes"]["id"]) &&
						strpos(
							$d["attributes"]["id"],
							"accdef_"
						) !== false
					){
						
						$this->fuckhtml->load(
							$this->ask[
								$d["attributes"]["id"]
							]
						);
						
						$description =
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
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
									)[0]
								)
							);
						
						$a =
							$this->fuckhtml
							->getElementsByTagName("a")
							[0];
						
						$this->fuckhtml->load($a);
						
						$out["web"][] = [
							"title" =>
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$this->fuckhtml
										->getElementsByTagName("span")[0]
									)
								),
							"description" => $description,
							"url" =>
								$this->decodeurl(
									$this->fuckhtml
									->getTextContent(
										$a
										["attributes"]
										["href"]
									)
								),
							"date" => null,
							"type" => "web",
							"thumb" => [
								"url" => null,
								"ratio" => null
							],
							"sublink" => [],
							"table" => []
						];
					}
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
					isset($this->js_image[$thumb[0]["attributes"]["id"]])
				){
					
					$thumb = [
						"url" => $this->getimage($thumb[0]["attributes"]["id"]),
						"ratio" => "1:1"
					];
					
					if(parse_url($thumb["url"], PHP_URL_HOST) == "i.ytimg.com"){
						
						$thumb = [
							"url" =>
								str_replace(
									"default.jpg",
									"maxresdefault.jpg",
									$thumb["url"]
								),
							"ratio" => "16:9"
						];
					}
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
							
							$container["innerHTML"] = str_replace($cat, "", $container["innerHTML"]);
							
							$cat = explode(":", $cat, 2);
							
							$name =
								$this->fuckhtml
								->getTextContent(
									$cat[0]
								);
							
							if(strtolower($name) != "posted"){
								
								$table[$name] =
									$this->titledots(
										$this->fuckhtml
										->getTextContent(
											$cat[1]
										)
									);
							}else{
								
								$date =
									strtotime(
										$this->titledots(
											$this->fuckhtml
											->getTextContent(
												$cat[1]
											)
										)
									);
							}
						}
						continue;
					}
					
					$spans =
						$this->fuckhtml
						->getElementsByTagName("span");
					
					$encounter_rating = false;
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
						
						if($encounter_rating !== false){
							
							switch($encounter_rating){
								
								case 3:
									$table["Votes"] =
										number_format(
											str_replace(
												[
													"(",
													")",
													","
												],
												"",
												$this->fuckhtml
												->getTextContent(
													$span["innerHTML"]
												)
											)
										);
									break;
								
								case 6:
									$table["Price"] =
										$this->fuckhtml
										->getTextContent(
											$span["innerHTML"]
										);
									break;
								
								case 8:
									$table["Support"] =
										$this->fuckhtml
										->getTextContent(
											$span["innerHTML"]
										);
									break;
							}
							
							$encounter_rating++;
						}
						
						// get rating
						if(isset($span["attributes"]["aria-hidden"])){
							
							$table["Rating"] = $span["innerHTML"];
							$encounter_rating = 0;
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
				
				continue;
			}
			
			/*
				Check for spelling autocorrect
			*/
			$spelling =
				$this->fuckhtml
				->getElementById(
					"scl"
				);
			
			if($spelling){
				
				$out["spelling"] = [
					"type" => "including",
					"using" =>
						$this->fuckhtml
						->getTextContent(
							$spelling
						),
					"correction" => $search
				];
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
					$this->nextpage
					->store(
						explode(
							"?",
							$this->fuckhtml
							->getTextContent(
								$nextpage[0]
								["attributes"]
								["href"]
							)
						)[1],
						"web"
					);
				
				continue;
			}
			
			/*
				Check for DMCA complaint div
			*/
			$dmca_table = false;
			
			$text =
				$this->fuckhtml
				->getTextContent($container);
			
			if(
				stripos(
					$text,
					"In response to a complaint we received under the US Digital Millennium Copyright Act, we have removed"
				) !== false
				||
				stripos(
					$text,
					"In response to multiple complaints we received under the US Digital Millennium Copyright Act, we have removed"
				) !== false
			){
				
				$as =
					$this->fuckhtml
					->getElementsByTagName("a");
				
				array_shift($as);
				
				$dmca_table = [
					"title" => "Removed results",
					"description" => [
						[
							"type" => "text",
							"value" => "Google removed results due to DMCA complaints. You can view the removed links by visiting these:\n\n"
						]
					],
					"url" => "https://support.google.com/legal/answer/1120734?visit_id=638260070062978894-2242290953",
					"thumb" => null,
					"table" => [],
					"sublink" => []
				];
				
				$i = 0;
				$c = count($as);
				
				foreach($as as $a){
					
					$i++;
					$u =
						$this->decodeurl(
							$a["attributes"]["href"]
						);
					
					$dmca_table["description"][] = [
						"type" => "link",
						"url" => $u,
						"value" => $u
					];
					
					if($i !== $c){
						
						$dmca_table["description"][] = [
							"type" => "text",
							"value" => "\n"
						];
					}
				}
				
				continue;
			}
			
			/*
				Parse instant answers with parts
			*/
			$parts =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"padding" => "12px 16px 12px"
						],
						self::is_class
					),
					"div"
				);
			
			if(count($parts) !== 0){
			
				$table = [
					"title" => null,
					"description" => [],
					"url" => null,
					"thumb" => null,
					"table" => [],
					"sublink" => []
				];
				
				// get thumb
				$thumb =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"float" => "right",
								"padding-left" => "16px"
							],
							self::is_class
						),
						"div"
					);
					
				if(count($thumb) !== 0){
					
					$this->fuckhtml->load($thumb[0]);
					
					$img =
						$this->fuckhtml
						->getElementsByTagName("img");
					
					if(count($img) !== 0){
						
						$table["thumb"] =
							$this->getimage(
								$img[0]["attributes"]["id"]
							);
					}
					
					$this->fuckhtml->load($container);
				}
				
				$h =
					$this->fuckhtml
					->getElementsByTagName("h3");
				
				if(count($h) === 0){
					
					$h =
						$this->fuckhtml
						->getElementsByTagName("h2");
				}
				
				if(count($h) !== 0){
					// set title + subtext for when a word definition
					// appears
					$h = $h[0];
					
					$table["title"] =
						$this->fuckhtml
						->getTextContent(
							$h
						);
					
					$parts[0]["innerHTML"] =
						str_replace(
							$h["outerHTML"],
							"",
							$parts[0]["innerHTML"]
						);
					
					$table["description"][] =
						[
							"type" => "quote",
							"value" =>
								$this->fuckhtml
								->getTextContent(
									$parts[0]
								)
						];
				}else{
					
					// parse it as a wikipedia header
					
				}
				
				// get table elements
				$tables =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"display" => "table",
								"width" => "100%",
								"padding-right" => "16px",
								"-webkit-box-sizing" => "border-box"
							],
							self::is_class
						),
						"div"
					);
				
				foreach($tables as $tbl){
					
					$this->fuckhtml->load($tbl);
					
					$images =
						$this->fuckhtml
						->getElementsByTagName("img");
					
					if(count($images) !== 0){
						
						$image = $this->getimage($images[0]["attributes"]["id"]);
						
						$text =
							$this->fuckhtml
							->getTextContent(
								$tbl
							);
						
						$table["description"][] = [
							"type" => "link",
							"value" => $text,
							"url" => "?s=" . urlencode($text) . "&scraper=google"
						];
						
						$table["description"][] = [
							"type" => "image",
							"url" => $image
						];
					}
					
				}
				
				$audio =
					$this->fuckhtml
					->getElementsByTagName("audio");
				
				if(count($audio) !== 0){
					
					$table["description"][] = [
						"type" => "audio",
						"url" =>
							str_replace(
								"http://",
								"https://",
								$this->fuckhtml
								->getTextContent(
									$audio[0]["attributes"]["src"]
								)
							)
					];
				}
				
				if(count($parts) >= 2){
					
					$this->fuckhtml->load($parts[1]);
					
					$parts =
						$this->fuckhtml
						->getElementsByClassName(
							$this->findstyles(
								[
									"padding-bottom" => "12px"
								],
								self::is_class
							),
							"div"
						);
					
					foreach($parts as $part){
						
						$this->fuckhtml->load($part);
						
						$lists =
							$this->fuckhtml
							->getElementsByTagName("ol");
						
						if(count($lists) !== 0){
							
							foreach($lists as $list){
								
								$this->fuckhtml->load($list);
								
								$list_items =
									$this->fuckhtml
									->getElementsByTagName("li");
								
								$index = 0;
								
								if(count($list_items) !== 0){
									
									foreach($list_items as $list_item){
										
										$index++;
										
										$this->fuckhtml->load($list_item);
										
										$list_subitems =
											$this->fuckhtml
											->getElementsByTagName("div");
										
										foreach($list_subitems as $subitem){
											
											if($subitem["level"] !== 1){ continue; }
											
											$this->fuckhtml->load($subitem);
											
											$spans =
												$this->fuckhtml
												->getElementsByTagName("span");
											
											if(count($spans) !== 0){
												
												$type = "quote";
											}else{
												
												$type = "text";
											}
											
											$value =
												$this->fuckhtml
												->getTextContent(
													$subitem
												);
											
											if($type == "text"){
												
												$value = $index . ". " . $value;
											}
											
											$table["description"][] = [
												"type" => $type,
												"value" => $value
											];
										}
									}
								}
							}
							
							continue;
						}
						
						// get title
						$spans =
							$this->fuckhtml
							->getElementsByTagName("span");
						
						if(count($spans) !== 0){
							
							foreach($spans as $span){
								
								$part["innerHTML"] =
									str_replace(
										$span["outerHTML"],
										"",
										$part["innerHTML"]
									);
							}
							
							if(
								$this->fuckhtml
								->getTextContent(
									$part
								)
								== ""
							){
								
								$table["description"][] = [
									"type" => "title",
									"value" =>
										$this->fuckhtml
										->getTextContent(
											$spans[0]
										)
								];
								
								continue;
							}
						}
						
						// fallback to getting non-numbered list
						$nlist =
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
						
						if(count($nlist) !== 0){
							
							foreach($nlist as $nlist_item){
								
								$text =
									$this->fuckhtml
									->getTextContent($nlist_item);
								
								if($text == ""){
									
									continue;
								}
								
								$this->fuckhtml->load($nlist_item);
								
								$spans =
									$this->fuckhtml
									->getElementsByTagName("span");
								
								if(count($spans) !== 0){
									
									// is a quote node
									$type = "quote";
								}else{
									
									$type = "text";
								}
								
								$table["description"][] = [
									"type" => $type,
									"value" => $text
								];
							}
						}
					}
				}
				
				$out["answer"][] = $table;
			}
		}
		
		if($dmca_table){
			
			$out["answer"][] = $dmca_table;
		}
		
		return $out;
	}
	
	public function image($get){
		
		$search = $get["s"];
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		$lang = $get["lang"];
		$size = $get["size"];
		$colortype = $get["colortype"];
		$color = $get["color"];
		$type = $get["type"];
		$rights = $get["rights"];
		$older = $get["older"];
		$newer = $get["newer"];
		
		$params = [];
		
		// country
		if($country != "any"){
			
			$params["gl"] = $country;
		}
		
		// nsfw
		$params["safe"] = $nsfw == "yes" ? "off" : "active";
		
		// language
		if($lang != "any"){
			
			$params["lr"] = "lang_" . $lang;
		}
		
		// &sort=review-date:r:20090301:20090430
		$older = $older === false ? false : date("Ymd", $older);
		$newer = $newer === false ? false : date("Ymd", $newer);
		
		if(
			$older !== false &&
			$newer === false
		){
			
			$newer = date("Ymd", time());
		}
		
		if(
			$older !== false ||
			$newer !== false
		){
			
			$params["sort"] = "review-date:r:" . $older . ":" . $newer;
		}
		
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
			
			$out["npt"] =
				$this->nextpage->store(
					json_encode(
						[
							"q" => $get["s"],
							"tbm" => "isch",
							"async" => "_id:islrg_c,_fmt:html",
							"asearch" => "ichunklite",
							"ved" => $ved,
							"vet" => "1" . $ved . "..i",
							"start" => 100,
							"ijn" => 1,
							"imgvl" => $imgvl
						]
					),
					"images"
				);
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
	
	private function getimage($id){
		
		if(
			isset($this->js_image[$id]) &&
			$this->js_image[$id] != "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABAUlEQVR4AWMYesChoYElLjkzPj4lY3d8csZjIL4MxPNjUzPcSTYsISFLAqj5NBD/h+LPQPwbiT87NCuLh2gDgRr2QzXuT0jNMoBYksARn5zuHJ+UcR0kB6RXE2VYXHJGOlTDZmzyIJcB5e+D1CSkZDgQNBAaZv+jU1JkcKpJygiGeZ0I76a/Byq8jU9NZFqaCNTA48SE33/iDcw8TIyBt0GKQTFN0Msp6f2EIyUpo57YSIlLSrMhIg0WCIBcCfXSdlzJBsheTHQ6jEnOUgEFOLaEDbMIlhZBOYrorAdJk+nroVnvPsSgdGdoOF7HZyhZ2XPoGQoqjbCpIbt0AiejIQMArVLI7k/DXFkAAAAASUVORK5CYII="
		){
			
			if(stripos($this->js_image[$id], "data:image") !== false){
				
				return
					explode(
						"\\x3d",
						$this->js_image[$id],
						2
					)[0];
			}
			
			return $this->js_image[$id];
		}
		
		return null;
	}
	
	private function decodeurl($url){
		
		preg_match(
			'/^\/url\?q=([^&]+)|^\/interstitial\?url=([^&]+)/',
			$this->fuckhtml
			->getTextContent($url),
			$match
		);
		
		if(count($match) === 0){
			
			return null;
		}
		
		$url = empty($match[1]) ? urldecode($match[2]) : urldecode($match[1]);
		
		$domain = parse_url($url, PHP_URL_HOST);
		
		if(
			preg_match(
				'/wikipedia.org$/',
				$domain
			)
		){
			
			// rewrite wikipedia mobile URLs to desktop
			$url =
				$this->replacedomain(
					$url,
					preg_replace(
						'/([a-z0-9]+)(\.m\.)/',
						'$1.',
						$domain
					)
				);
		}
		
		if(
			preg_match(
				'/imdb\.com$|youtube\.[^.]+$/',
				$domain
			)
		){
			
			// rewrite imdb and youtube mobile URLs too
			$url =
				$this->replacedomain(
					$url,
					preg_replace(
						'/^m\./',
						"",
						$domain
					)
				);
			
		}
		
		return $url;
	}
	
	private function replacedomain($url, $domain){
		
		return
			preg_replace(
				'/(https?:\/\/)([^\/]+)/',
				'$1' . $domain,
				$url
			);
	}
	
	private function titledots($title){
		
		return rtrim($title, ".… \t\n\r\0\x0B");
	}
}
