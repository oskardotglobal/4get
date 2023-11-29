<?php

// todo:
// aliexpress tracking links
// enhanced msx notice
// detect "sorry" page

class google{
	
	private const is_class = ".";
	private const is_id = "#";
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		$this->backend = new backend("google");
	}
	
	public function getfilters($page){
		
		$base = [
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
			]
		];
		
		switch($page){
			
			case "web":
				return array_merge(
					$base,
					[
						"newer" => [ // &sort=review-date:r:20090301:20090430
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
						]
					]
				);
				break;
			
			case "images":
				return array_merge(
					$base,
					[
						"time" => [ // tbs=qrd:<size>
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"d" => "Past 24 hours",
								"w" => "Past week",
								"m" => "Past month",
								"y" => "Past year"
							]
						],
						"size" => [
							"display" => "Size",
							"option" => [
								// tbs=isz:<size>
								"any" => "Any size",
								"l" => "Large",
								"m" => "Medium",
								"i" => "Icon",
								// from here
								// tbz:lt,islt:<size>
								"qsvga" => "Larger than 400x300",
								"vga" => "Larger than 640x480",
								"qsvga" => "Larger than 800x600",
								"xga" => "Larger than 1024x768",
								"2mp" => "Larger than 2MP",
								"4mp" => "Larger than 4MP",
								"6mp" => "Larger than 6MP",
								"8mp" => "Larger than 8MP",
								"10mp" => "Larger than 10MP",
								"12mp" => "Larger than 12MP",
								"15mp" => "Larger than 15MP",
								"20mp" => "Larger than 20MP",
								"40mp" => "Larger than 40MP",
								"70mp" => "Larger than 70MP"
							]
						],
						"ratio" => [ // tbs=iar:<size>
							"display" => "Aspect ratio",
							"option" => [
								"any" => "Any ratio",
								"t" => "Tall",
								"s" => "Square",
								"w" => "Wide",
								"xw" => "Panoramic"
							]
						],
						"color" => [ // tbs=ic:<color>
							"display" => "Color",
							"option" => [
								"any" => "Any color",
								"color" => "Full color",
								"gray" => "Black & white",
								"trans" => "Transparent",
								// from there, its ic:specific,isc:<color>
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
								"face" => "Faces",
								"clipart" => "Clip Art",
								"lineart" => "Line Drawing",
								"stock" => "Stock",
								"animated" => "Animated"
							]
						],
						"format" => [ // tbs=ift:<format>
							"display" => "Format",
							"option" => [
								"any" => "Any format",
								"jpg" => "JPG",
								"gif" => "GIF",
								"png" => "PNG",
								"bmp" => "BMP",
								"svg" => "SVG",
								"webp" => "WEBP",
								"ico" => "ICO",
								"craw" => "RAW"
							]
						],
						"rights" => [ // tbs=il:<rights>
							"display" => "Usage rights",
							"option" => [
								"any" => "Any license",
								"cl" => "Creative Commons licenses",
								"ol" => "Commercial & other licenses"
							]
						]
					]
				);
				break;
			
			case "videos":
				return array_merge(
					$base,
					[
						"time" => [
							"display" => "Time posted",
							"option" => [ // tbs=qdr
								"any" => "Any time",
								"h" => "Past hour",
								"d" => "Past 24 hours",
								"w" => "Past week",
								"m" => "Past month",
								"y" => "Past year"
							]
						],
						"duration" => [
							"display" => "Duration",
							"option" => [
								"any" => "Any duration",
								"s" => "Short (0-4min)", // tbs=dur:s
								"m" => "Medium (4-20min)", // tbs=dur:m
								"l" => "Long (20+ min)" // tbs=dur:l
							]
						],
						"quality" => [
							"display" => "Quality",
							"option" => [
								"any" => "Any quality",
								"h" => "High quality" // tbs=hq:h
							]
						],
						"captions" => [
							"display" => "Captions",
							"option" => [
								"any" => "No preference",
								"yes" => "Closed captioned" // tbs=cc:1
							]
						]
					]
				);
				break;
			
			case "news":
				return array_merge(
					$base,
					[
						"time" => [
							"display" => "Time posted",
							"option" => [ // tbs=qdr
								"any" => "Any time",
								"h" => "Past hour",
								"d" => "Past 24 hours",
								"w" => "Past week",
								"m" => "Past month",
								"y" => "Past year",
								"a" => "Archives" // tbs=ar:1
							]
						],
						"sort" => [
							"display" => "Sort",
							"option" => [
								"relevance" => "Relevance", 
								"date" => "Date" // sbd:1
							]
						]
					]
				);
				break;
		}
	}
	
	private function get($proxy, $url, $get = []){
		
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

		$this->backend->assign_proxy($curlproc, $proxy);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	
	
	public function web($get){
		
		if($get["npt"]){
			
			[$req, $ip] = $this->backend->get($get["npt"], "web");
			parse_str(
				parse_url($req, PHP_URL_QUERY),
				$search
			);
			
			if(isset($search["q"])){
				
				$search = $search["q"];
			}else{
				
				$search = "a"; // lol
			}
			
			try{
				$html =
					$this->get(
						$ip,
						"https://www.google.com" . $req,
						[]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$lang = $get["lang"];
			$older = $get["older"];
			$newer = $get["newer"];
			$ip = $this->backend->get_ip();
			
			$params = [
				"q" => $search,
				"hl" => "en",
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
			
			try{
				$html =
					$this->get(
						$ip,
						"https://www.google.com/search",
						$params
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
		}
		
		return $this->parsepage($html, "web", $search, $ip);
	}
	
	
	
	public function video($get){
		
		if($get["npt"]){
			
			[$req, $ip] = $this->backend->get($get["npt"], "videos");
			parse_str(
				parse_url($req, PHP_URL_QUERY),
				$search
			);
			
			if(isset($search["q"])){
				
				$search = $search["q"];
			}else{
				
				$search = "a"; // lol
			}
			
			try{
				
				$html =
					$this->get(
						$ip,
						"https://www.google.com" . $req,
						[]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
			
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$lang = $get["lang"];
			$time = $get["time"];
			$duration = $get["duration"];
			$quality = $get["quality"];
			$captions = $get["captions"];
			$ip = $this->backend->get_ip();
			
			$params = [
				"q" => $search,
				"tbm" => "vid",
				"hl" => "en",
				"num" => "20"
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
			
			$tbs = [];
				
			// time
			if($time != "any"){
				
				$tbs[] = "qdr:" . $time;
			}
			
			// duration
			if($duration != "any"){
				
				$tbs[] = "dur:" . $duration;
			}
			
			// quality
			if($quality != "any"){
				
				$tbs[] = "hq:" . $quality;
			}
			
			// captions
			if($captions != "any"){
				
				$tbs[] = "cc:" . $captions;
			}
			
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] =
					implode(",", $tbs);
			}
			
			try{
				$html =
					$this->get(
						$ip,
						"https://www.google.com/search",
						$params
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
		}
		
		$json = $this->parsepage($html, "videos", $search, $ip);
		$out = [
			"status" => "ok",
			"npt" => $json["npt"],
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		foreach($json["web"] as $item){
			
			$out["video"][] = [
				"title" => $item["title"],
				"description" => $item["description"],
				"author" => [
					"name" => null,
					"url" => null,
					"avatar" => null
				],
				"date" => isset($item["table"]["Posted"]) ? strtotime($item["table"]["Posted"]) : null,
				"duration" => isset($item["table"]["Duration"]) ? $this->hms2int($item["table"]["Duration"]) : null,
				"views" => null,
				"thumb" =>
					$item["thumb"]["url"] === null ?
					[
						"url" => null,
						"ratio" => null
					] :
					[
						"url" => $item["thumb"]["url"],
						"ratio" => "16:9"
					],
				"url" => $item["url"]
			];
		}
		
		return $out;
	}
	
	
	
	public function news($get){
		
		if($get["npt"]){
			
			[$req, $ip] = $this->backend->get($get["npt"], "news");
			parse_str(
				parse_url($req, PHP_URL_QUERY),
				$search
			);
			
			if(isset($search["q"])){
				
				$search = $search["q"];
			}else{
				
				$search = "a"; // lol
			}
			
			try{
				
				$html =
					$this->get(
						$ip,
						"https://www.google.com" . $req,
						[]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
			
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$lang = $get["lang"];
			$time = $get["time"];
			$sort = $get["sort"];
			$ip = $this->backend->get_ip();
			
			$params = [
				"q" => $search,
				"tbm" => "nws",
				"hl" => "en",
				"num" => "20"
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
			
			$tbs = [];
				
			// time
			if($time != "any"){
				
				if($time == "a"){
					
					$tbs[] = "ar:1";
				}else{
					
					$tbs[] = "qdr:" . $time;
				}
			}
			
			// relevance
			if($sort == "date"){
				
				$tbs[] = "sbd:1";
			}
					
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] =
					implode(",", $tbs);
			}
			
			$html =
				$this->get(
					$ip,
					"https://www.google.com/search",
					$params
				);
		}
		
		$json = $this->parsepage($html, "news", $search, $ip);
		$out = [
			"status" => "ok",
			"npt" => $json["npt"],
			"news" => []
		];
		
		foreach($json["web"] as $item){
			
			$description = array_key_first($item["table"]);
			
			if($description !== null){
				
				$date = $item["table"][$description];
			}else{
				
				$date = null;
			}
			
			$out["news"][] = [
				"title" => $item["title"],
				"author" => $item["author"],
				"description" => $description,
				"date" => strtotime($date),
				"thumb" =>
					$item["thumb"]["url"] === null ?
					[
						"url" => null,
						"ratio" => null
					] :
					[
						"url" => $item["thumb"]["url"],
						"ratio" => "16:9"
					],
				"url" => $item["url"]
			];
		}
		
		return $out;
	}
	
	
	
	private function parsepage($html, $pagetype, $search, $ip){
		/*
		$handle = fopen("scraper/google.html", "r");
		$html = fread($handle, filesize("scraper/google.html"));
		fclose($handle);
		*/
		
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
		
		$this->parsejavascript($html);
		
		//
		// parse accdef's
		//
		$has_appended_accdef = false;
		
		preg_match_all(
			'/window\.jsl\.dh\(\'(accdef_[0-9]+)\',\'(.*)\'\);/',
			$html,
			$accdefs_regex
		);
		
		$accdefs = [];
		for($i=0; $i<count($accdefs_regex[0]); $i++){
			
			// decode UTF-16 string
			$answer =
				$this->fuckhtml
				->parseJsString(
					$accdefs_regex[2][$i]
				);
			
			$this->fuckhtml->load($answer);
			
			// get description
			$description =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"padding" => "12px 16px 12px",
						],
						self::is_class
					),
					"div"
				)[1];
			
			// get date (rare)
			$date =
				$this->fuckhtml
				->getElementsByTagName("sub");
			
			if(count($date) !== 0){
				
				$description =
					str_replace(
						$date[0]["outerHTML"],
						"",
						$description["innerHTML"]
					);
				
				$date =
					strtotime(
						$this->fuckhtml
						->getTextContent(
							$date[0]
						)
					);
			}else{
				
				$date = null;
			}
			
			// get information table
			$table = [];
			
			$tbody =
				$this->fuckhtml
				->getElementsByTagName("tbody");
			
			if(count($tbody) !== 0){
				
				$this->fuckhtml->load($tbody[0]);
				
				$trs =
					$this->fuckhtml
					->getElementsByTagName("tr");
				
				foreach($trs as $tr){
					
					$this->fuckhtml->load($tr);
					
					$tds =
						$this->fuckhtml
						->getElementsByTagName("td");
					
					if(count($tds) === 2){
						
						$table[
							$this->fuckhtml
							->getTextContent(
								$tds[0]
							)
						] =
							$this->fuckhtml
							->getTextContent(
								$tds[1]
							);
					}
				}
				
				// load back what we had
				$this->fuckhtml->load($answer);
			}
			
			// get title & link
			$a =
				$this->fuckhtml
				->getElementsByTagName("a")[0];
			
			$this->fuckhtml->load($a);
			
			$title =
				$this->fuckhtml
				->getElementsByTagName("span");
			
			if(count($title) === 0){
				
				continue;
			}
			
			$accdefs[] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$title[0]
						)
					),
				"description" =>
					$this->fuckhtml
					->getTextContent(
						$description
					),
				"url" =>
					$this->unshiturl(
						$a["attributes"]["href"]
					),
				"date" => $date,
				"type" => "web",
				"thumb" => [
					"url" => null,
					"ratio" => null
				],
				"sublink" => [],
				"table" => $table
			];
		}
		
		$this->fuckhtml->load($html);
		
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
			
			// detect spelling
			$spelling =
				$this->fuckhtml
				->getElementsByClassName(
					$this->findstyles(
						[
							"font-size" => "20px",
							"line-height" => "26px",
							"padding-top" => "2px",
							"margin-bottom" => "1px"
						],
						self::is_class
					),
					"div"
				);
			
			if(count($spelling) !== 0){
				
				$a =
					$this->fuckhtml
					->getElementsByTagName("a");
				
				if(count($a) !== 0){
					
					$scripts =
						$this->fuckhtml
						->getElementsByTagName("script");
					
					foreach($scripts as $script){
						
						$container["innerHTML"] =
							str_replace(
								$script["outerHTML"],
								"",
								$container["innerHTML"]
							);
					}
					
					$container["innerHTML"] =
						$this->fuckhtml
						->getTextContent(
							str_replace(
								$a[0]["outerHTML"],
								"",
								$container["innerHTML"]
							)
						);
					
					if(
						preg_match(
							'/^did you mean/i',
							$container["innerHTML"]
						)
					){
						
						$out["spelling"] = [
							"type" => "not_many",
							"using" => $search,
							"correction" =>
								$this->fuckhtml
								->getTextContent(
									$a[0]
								)
						];
					}
					
					elseif(
						preg_match(
							'/^showing results for/i',
							$container["innerHTML"]
						)
					){
						
						$out["spelling"] = [
							"type" => "including",
							"using" =>
								$this->fuckhtml
								->getTextContent(
									$a[0]
								),
							"correction" => $search
						];
					}
				}
				
				continue;
			}
			
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
			
			if(count($title) !== 0){
				
				//
				//	Container is a web link
				//
				$web = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$title[0]
							)
						),
					"description" => null,
					"url" => null,
					"date" => null,
					"type" => "web",
					"thumb" => [
						"url" => null,
						"ratio" => null
					],
					"sublink" => [],
					"table" => []
				];
				
				// get link
				$web["url"] =
					$this->unshiturl(
						$this->fuckhtml
						->getElementsByTagName("a")
						[0]
						["attributes"]
						["href"]
					);
				
				//
				// check if link contains a carousel
				//
				$carousels = $this->parsecarousels();
				if(count($carousels) !== 0){
					
					$first = true;
					foreach($carousels as $carousel_cat){
						
						foreach($carousel_cat as $carousel){
							
							if($first === true){
								
								$first = false;
							}elseif($carousel["image"] !== null){
								
								$out["image"][] = [
									"title" => $carousel["title"],
									"source" => [
										[
											"url" => $carousel["image"],
											"width" => null,
											"height" => null
										]
									],
									"url" => $carousel["url"]
								];
							}
							
							$web["sublink"][] = [
								"title" => $carousel["title"],
								"date" => $carousel["date"],
								"description" => $carousel["description"],
								"url" => $carousel["url"]
							];
						}
					}
					
					if($carousels[0][0]["image"] !== null){
						$web["thumb"] = [
							"url" => $carousels[0][0]["image"],
							"ratio" => "16:9"
						];
					}
					
					$out["web"][] = $web;
					continue;
				}
				
				//
				// no carousel entries, parse as normal link
				//
				$this->fuckhtml->load($container);
				
				// parse URL
				$web["url"] =
					$this->unshiturl(
						$this->fuckhtml
						->getElementsByTagName("a")
						[0]
						["attributes"]
						["href"]
					);
				
				$container = $container["innerHTML"];
				
				$line_detect =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"height" => "1px",
								"background-color" => "#dadce0",
								"margin" => "0 16px"
							],
							self::is_class
						),
						"div"
					);
				
				if(count($line_detect) !== 0){
					
					// we found a line, this means we're dealing with a
					// "featured snippet"
					$featured = true;
					
					$description_container =
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
						)[1];
										
					// get date node for it
					$date =
						$this->fuckhtml
						->getElementsByTagName("sub");
					
					if(count($date) !== 0){
						$web["date"] =
							strtotime(
								$this->fuckhtml
								->getTextContent(
									$date[0]
								)
							);
					}
				}else{
					
					// we're dealing with a normal link
					$featured = false;
					
					$description_container =
						$this->fuckhtml
						->getElementsByClassName(
							$this->findstyles(
								[
									"padding" => "12px 16px 12px"
								],
								self::is_class
							),
							"div"
						)[1];
				}
				
				//
				// Get author if we're parsing news
				//
				if($pagetype == "news"){
					
					$author =
						$this->fuckhtml
						->getElementsByClassName(
							$this->findstyles(
								[
									"position" => "absolute",
									"width" => "100%",
									"top" => "0",
									"left" => "0",
									"padding-top" => "1px",
									"margin-bottom" => "-1px"
								],
								self::is_class
							),
							"div"
						);
					
					if(count($author) !== 0){
						
						$web["author"] =
							$this->fuckhtml
							->getTextContent(
								$author[0]
							);
					}else{
						
						$web["author"] = null;
					}
				}
				
				$description =
					$description_container["innerHTML"];
				
				$this->fuckhtml->load($description);
				
				//
				// get thumbnail before we call loadhtml again
				//
				$img =
					$this->fuckhtml
					->getElementsByTagName("img");
				
				if(count($img) !== 0){
					
					$skip = true;
					
					if(
						isset($img[0]["attributes"]["alt"]) &&
						stripos($img[0]["attributes"]["alt"], "Video for") !== false
					){
						
						// is a video thumbnail
						$web["thumb"]["ratio"] = "16:9";
					}else{
						
						// is a google thumbnail
						$web["thumb"]["ratio"] = "1:1";
					}
					
					$web["thumb"]["url"] =
						$this->getimage(
							$img[0]["attributes"]["id"]
						);
				}else{
					
					$skip = false;
				}
				
				//
				// get sublinks
				//
				$links =
					$this->fuckhtml
					->getElementsByTagName("a");
				
				foreach($links as $link){
					
					if($skip === true){
						
						$skip = false;
						continue;
					}
					
					$description =
						str_replace(
							$link["outerHTML"],
							"",
							$description
						);
					
					$sublink = [
						"title" => null,
						"description" => null,
						"url" => null,
						"date" => null
					];
					
					$sublink["title"] =
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$link
							)
						);
					
					$sublink["url"] =
						$this->unshiturl(
							$link
							["attributes"]
							["href"]
						);
					
					if(parse_url($sublink["url"], PHP_URL_HOST) !== null){
						
						$web["sublink"][] = $sublink;
					}
				}
				
				//
				// Parse spans in description
				//
				$this->fuckhtml->load($description);
				
				if($featured === false){
					
					$levels =
						$this->fuckhtml
						->getElementsByClassName(
							$this->findstyles(
								[
									"padding-bottom" => "8px"
								],
								self::is_class
							),
							"div"
						);
					
					// oh my god yes, fucking great, sometimes there are NO levels
					// hahahahahhahahahahahahahahahhahaa
					if(count($levels) === 0){
						
						$levels = [$description];
					}
					
					foreach($levels as $level){
						
						$this->fuckhtml->load($level);
						
						$spans =
							$this->fuckhtml
							->getElementsByTagName(
								"span"
							);
						
						$is_rating = -1;
						
						foreach($spans as $span){
							
							$innertext =
								trim(
									$this->fuckhtml
									->getTextContent(
										$span
									),
									" ·."
								);
							
							if($innertext == ""){ continue; }
							
							if(
								strtolower($innertext)
								== "rating"
							){
								
								$is_rating = 0;
								
								// clean up before we go
								$description =
									str_replace(
										$span["outerHTML"],
										"",
										$description
									);
								continue;
							}
							
							//
							//	Parse rating object
							//
							if($is_rating >= 0){
								
								// clean up description
								$description =
									str_replace(
										$span["outerHTML"],
										"",
										$description
									);
								
								if($span["level"] !== 1){ continue; }
								$is_rating++;
								
								// 10/10 (123)
								if($is_rating === 1){
									
									$innertext = explode(" ", $innertext, 2);
									
									$web["table"]["Rating"] = $innertext[0];
									
									if(count($innertext) === 2){
										$web["table"]["Hits"] =
											trim(
												str_replace(
													[
														"(",
														")"
													],
													"",
													$innertext[1]
												)
											);
										
										if($web["table"]["Hits"] == ""){
											
											unset($web["table"]["Hits"]);
										}
									}
									continue;
								}
								
								// US$4.99
								// MYR 50.00
								// $38.34
								// JP¥6,480
								// Reviewed by your mom
								if($is_rating === 2){
									
									if(
										preg_match(
											'/^Review by (.+)/',
											$innertext,
											$match
										)
									){
										
										$web["table"]["Author"] = $match[1];
										continue;
									}
									
									$web["table"]["Price"] = $innertext;
									continue;
								}
								
								// Android / In stock
								if($is_rating === 3){
									
									$web["table"]["Support"] = $innertext;
									continue;
								}
								
								// ignore the rest
								continue;
							}
							
							//
							//	Parse standalone text
							//
							
							// If we reach this point:
							// 1. Ratings have been parsed
							// 2. We're parsing a WEB link, not some shitty piece of shit
							
							// check for date
							// if span has no text before it, assume it's a date
							$desc_split =
								explode(
									$span["outerHTML"],
									$description,
									2
								);
							
							if(
								$this->fuckhtml
								->getTextContent(
									$desc_split[0]
								) == ""
							){
								
								// has no text before
								$date = strtotime($innertext);
								if($date){
									
									$web["date"] = $date;
								}
								
								// cleanup
								$description =
									str_replace(
										$span["outerHTML"],
										"",
										$description
									);
								
								continue;
							}
							
							// Ready to parse table
							if(count($desc_split) === 2){
								$this->fuckhtml->load($desc_split[1]);
								
								$web["table"][
									$this->fuckhtml
									->getTextContent(
										trim($desc_split[0], ": ")
									)
								] = $innertext;
								
								// cleanup
								$description =
									str_replace(
										$desc_split[0] . $span["outerHTML"],
										"",
										$description
									);
							}
						}
					}
				}
				
				$web["description"] =
					trim(
						$this->fuckhtml
						->getTextContent(
							$description
						),
						" ·."
					);
				
				if($web["description"] == ""){
					
					$web["description"] = null;
				}
				
				$out["web"][] = $web;
				
				continue;
			}
			
			//
			// Detect wikipedia shit
			//
			$wiki_title =
				$this->fuckhtml
				->getElementsByTagName("h3");
			
			if(count($wiki_title) !== 0){
				
				$description_after = [];
				$description = [];
				$table = [];
				$sublink = [];
				
				$as =
					$this->fuckhtml
					->getElementsByTagName("a");
				
				foreach($as as $a){
					
					if(
						isset($a["attributes"]["href"]) &&
						parse_url($a["attributes"]["href"], PHP_URL_HOST) == "maps.google.com"
					){
						
						// detected maps embed, ignore
						continue 2;
					}
				}
				
				// get carousels and remove them from container for image grepper
				$carousels = $this->parsecarousels($container["innerHTML"]);
				$this->fuckhtml->load($container);
				
				// add images to image tab, if applicable
				for($i=0; $i<count($carousels); $i++){
					
					foreach($carousels[$i] as $item){
						
						if(
							$item["url"] !== null &&
							$item["ref"] !== null &&
							$item["image"] !== null &&
							$item["title"] !== null
						){
							
							$out["image"][] = [
								"title" => $item["title"],
								"source" => [
									[
										"url" => $item["url"],
										"width" => $item["image_width"],
										"height" => $item["image_height"]
									],
									[
										"url" => $item["image"],
										"width" => $item["thumb_width"],
										"height" => $item["thumb_height"]
									]
								],
								"url" => $item["ref"]
							];
							
							unset($carousels[$i]);
						}
					}
				}
				
				$carousels = array_values($carousels);
				
				// interpret remaining carousels as title + carousel
				$titles =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"font-weight" => "700",
								"letter-spacing" => "0.75px",
								"text-transform" => "uppercase"
							],
							self::is_class
						)
					);
				
				for($i=0; $i<count($titles); $i++){
					
					if(!isset($carousels[$i])){
						
						break;
					}
					
					$description_after[] = [
						"type" => "title",
						"value" =>
							$this->fuckhtml
							->getTextContent(
								$titles[$i]
							)
					];
					
					foreach($carousels[$i] as $carousel){
						
						$description_after[] = [
							"type" => "link",
							"url" => "web?s=" . urlencode($carousel["description"]) . "&scraper=google",
							"value" => $carousel["description"]
						];
						
						if($carousel["subtext"] !== null){
							
							$description_after[] = [
								"type" => "quote",
								"value" => $carousel["subtext"]
							];
						}
						
						$description_after[] = [
							"type" => "image",
							"url" => $carousel["image"]
						];
					}
				}
				
				$categories =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"padding" => "12px 16px 12px"
							],
							self::is_class
						)
					);
				
				$image =
					$this->fuckhtml
					->getElementsByTagName("img");
				
				if(count($image) !== 0){
					
					$image = $this->getimage($image[0]["attributes"]["id"]);
				}else{
					
					$image = null;
				}
				
				$url = null;
				
				for($i=0; $i<count($categories); $i++){
					
					$this->fuckhtml->load($categories[$i]);
					
					if($i === 0){
						// first node. this should be the header with the small
						// information snippet
						
						$url =
							$this->fuckhtml
							->getElementsByTagName("a");
						
						if(count($url) !== 0){
							
							$url =
								$this->unshiturl(
									$url[0]["attributes"]["href"]
								);
							
							if(parse_url($url, PHP_URL_HOST) == "encrypted-tbn0.gstatic.com"){
								
								$image = $url;
								$url = null;
							}
						}else{
							
							$url = null;
						}
						
						$categories[$i]["innerHTML"] =
							str_replace(
								$wiki_title[0]["outerHTML"],
								"",
								$categories[$i]["innerHTML"]
							);
						
						$subtext =
							$this->fuckhtml
							->getTextContent(
								$categories[$i]["innerHTML"]
							);
						
						if(strlen($subtext) !== 0){
							
							$description[] = [
								"type" => "quote",
								"value" =>
									$this->fuckhtml
									->getTextContent(
										$categories[$i]["innerHTML"]
									)
							];
						}
						
						// detect audio file
						$audio =
							$this->fuckhtml
							->getElementsByTagName("audio");
						
						if(count($audio) !== 0){
							
							$description[] = [
								"type" => "audio",
								"url" =>
									$this->fuckhtml
									->getTextContent(
										$audio[0]["attributes"]["src"]
									)
							];
						}
					}else{
						
						// check for separator elements IN THERE
						$separators =
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
						
						// detect container type
						foreach($separators as $separator){
							
							$this->fuckhtml->load($separator);
							
							// ignore wrong levels
							if($separator["level"] !== 2){
								
								continue;
							}
								
							//
							// Detect word definition
							//
							$wordwraps =
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
							
							if(count($wordwraps) !== 0){
								
								foreach($wordwraps as $word){
									
									$this->fuckhtml->load($word);
									
									// detect title
									$span =
										$this->fuckhtml
										->getElementsByTagName(
											"span"
										);
									
									if(
										count($span) === 1 &&
										$this->fuckhtml
										->getTextContent(
											str_replace(
												$span[0]["outerHTML"],
												"",
												$word["innerHTML"]
											)
										) == ""
									){
										
										$description[] = [
											"type" => "title",
											"value" =>
												$this->fuckhtml
												->getTextContent(
													$span[0]
												)
										];
										continue;
									}
									
									// detect list element
									$lists =
										$this->fuckhtml
										->getElementsByTagName("ol");
									
									if(count($lists) !== 0){
										foreach($lists as $list){
											
											$this->fuckhtml->load($list);
											
											$items =
												$this->fuckhtml
												->getElementsByTagName("li");
											
											$w = 0;
											foreach($items as $item){
												
												$w++;
												$this->fuckhtml->load($item);
												
												// get subnodes
												$subnodes =
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
												
												foreach($subnodes as $subnode){
													
													$this->fuckhtml->load($subnode);
													
													$spans =
														$this->fuckhtml
														->getElementsByTagName("span");
													
													if(count($spans) !== 0){
														
														// append quote
														$description[] = [
															"type" => "quote",
															"value" =>
																$this->fuckhtml
																->getTextContent(
																	$subnode
																)
														];
													}else{
														
														// append text
														$description[] = [
															"type" => "text",
															"value" =>
																$w . ". " .
																$this->fuckhtml
																->getTextContent(
																	$subnode
																)
														];
													}
												}
											}
										}
									}else{
										
										// parse without list
										// get subnodes
										$subnodes =
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
										
										foreach($subnodes as $subnode){
											
											$this->fuckhtml->load($subnode);
											
											$spans =
												$this->fuckhtml
												->getElementsByTagName("span");
											
											if(count($spans) !== 0){
												
												// append quote
												$description[] = [
													"type" => "quote",
													"value" =>
														$this->fuckhtml
														->getTextContent(
															$subnode
														)
												];
											}else{
												
												// append text
												$description[] = [
													"type" => "text",
													"value" =>
														$this->fuckhtml
														->getTextContent(
															$subnode
														)
												];
											}
										}
									}
								}
							}else{
								
								//
								// Parse table
								//
								$spans =
									$this->fuckhtml
									->getElementsByTagName("span");
								
								foreach($spans as $span){
									
									if(!isset($span["attributes"]["class"])){
										
										// found table
										$row =
											explode(
												":",	
												$this->fuckhtml
												->getTextContent(
													$separator
												),
												2
											);
										
										if(count($row) === 2){
											
											$table[rtrim($row[0])] =
												ltrim($row[1]);
											
										}
										continue 2;
									}
								}
								
								//
								// Parse normal description
								//
								$links_rem =
									$this->fuckhtml
									->getElementsByTagName("a");
								
								foreach($links_rem as $rem){
									
									$separator["innerHTML"] =
										str_replace(
											$rem["outerHTML"],
											"",
											$separator["innerHTML"]
										);
								}
								
								$description[] = [
									"type" => "text",
									"value" =>
										rtrim(
											$this->fuckhtml
											->getTextContent(
												$separator
											),
											" .,"
										)
								];
							}
						}
					}
							
					// detect huge buttons
					$buttons =
						$this->fuckhtml
						->getElementsByClassName(
							$this->findstyles(
								[
									"display" => "table-cell",
									"vertical-align" => "middle",
									"height" => "52px",
									"text-align" => "center"
								],
								self::is_class
							),
							"a"
						);
					
					if(count($buttons) !== 0){
								
						foreach($buttons as $button){
							
							if(isset($button["attributes"]["href"])){
								
								$sublink[
									$this->fuckhtml
									->getTextContent(
										$button
									)
								] =
									$this->unshiturl(
										$button["attributes"]["href"]
									);
							}
						}
					}
				}
				
				// append description_after (contains carousel info)
				$description = array_merge(
					$description,
					$description_after
				);
				
				$out["answer"][] = [
					"title" =>
						$this->fuckhtml
						->getTextContent(
							$wiki_title[0]
						),
					"description" => $description,
					"url" => $url,
					"thumb" => $image,
					"table" => $table,
					"sublink" => $sublink
				];
				
				continue;
			}
			
			//
			// Detect related searches containers
			//
			$container_title =
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
			
			if(count($container_title) !== 0){
				
				// get carousel entries
				$carousels = $this->parsecarousels($container["innerHTML"]);
				$this->fuckhtml->load($container);
				
				foreach($carousels as $carousel){
					
					foreach($carousel as $item){
						
						if($item["url"] !== null){
							
							$out["related"][] = $item["url"];
						}
					}
				}
				
				$container_title =
					strtolower(
						$this->fuckhtml
						->getTextContent(
							$container_title[0]
						)
					);
				
				switch($container_title){
					
					case "related searches":
					case "people also search for":
						//
						//	Parse related searches
						//
						$as =
							$this->fuckhtml
							->getElementsByTagName("a");
						
						foreach($as as $a){
							
							$out["related"][] =
								$this->fuckhtml
								->getTextContent($a);
						}
						break;
					
					case "people also ask":
						// get related queries
						$divs =
							$this->fuckhtml
							->getElementsByTagName("div");
						
						foreach($divs as $div){
							
							// add accdef's here
							if($has_appended_accdef === false){
								
								$out["web"] = array_merge($out["web"], $accdefs);
								$has_appended_accdef = true;
							}
							
							// add accdef's questions
							if(isset($div["attributes"]["role"])){
								
								$out["related"][] =
									$this->fuckhtml
									->getTextContent($div);
								
								continue;
							}
						}
						break;
				}
				
				continue;
			}
			
			//
			// Parse news
			//
			$title =
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
			
			if(count($title) !== 0){
				
				$carousels = $this->parsecarousels();
				$this->fuckhtml->load($container);
				
				if(count($carousels) === 0){
					
					// no carousels found
					continue;
				}
				
				$title =
					strtolower(
						$this->fuckhtml
						->getTextContent(
							$title[0]
						)
					);
				
				if(
					preg_match(
						'/^latest from|^top stories/',
						$title
					)
				){
					
					// Found news article
					foreach($carousels[0] as $carousel){
						
						if($carousel["image"] !== null){
							
							$thumb = [
								"url" => $carousel["image"],
								"ratio" => "16:9"
							];
						}else{
							
							$thumb = [
								"url" => null,
								"ratio" => null
							];
						}
						
						$out["news"][] = [
							"title" => $carousel["title"],
							"description" => $carousel["description"],
							"date" => $carousel["date"],
							"thumb" => $thumb,
							"url" => $carousel["url"]
						];
					}
				}
				
				elseif(
					$title == "images"
				){
					
					foreach($carousels as $carousel){
						
						foreach($carousel as $item){
							
							$out["image"][] = [
								"title" => $item["title"],
								"source" => [
									[
										"url" => $item["url"],
										"width" => $item["image_width"],
										"height" => $item["image_height"]
									],
									[
										"url" => $item["image"],
										"width" => $item["thumb_width"],
										"height" => $item["thumb_height"]
									]
								],
								"url" => $item["ref"]
							];
						}
					}
				}
				
				continue;
			}
			
			//
			// Detect nodes with only text + links
			//
			
			// ignore elements with <style> tags
			$style =
				$this->fuckhtml
				->getElementsByTagName("style");
			
			if(count($style) !== 0){
				
				continue;
			}
			
			$as =
				$this->fuckhtml
				->getElementsByTagName("a");
			
			$description = [];
			
			foreach($as as $a){
				
				//
				// Detect next page
				//
				if(
					isset($a["attributes"]["aria-label"]) &&
					strtolower($a["attributes"]["aria-label"]) == "next page"
				){
					
					$out["npt"] =
						$this->backend->store(
							$this->fuckhtml
							->getTextContent(
								$a["attributes"]["href"]
							),
							$pagetype,
							$ip
						);
						continue 2;
				}
				
				//
				// Parse as text node
				//
				$container["innerHTML"] =
					explode(
						$a["outerHTML"],
						$container["innerHTML"],
						2
					);
				
				$before =
					$this->fuckhtml
					->getTextContent(
						$container["innerHTML"][0],
						false,
						false
					);
				
				// set after
				if(count($container["innerHTML"]) === 2){
					
					$container["innerHTML"] =
						$container["innerHTML"][1];
				}else{
					
					$container["innerHTML"] = "";
				}
				
				if($before != ""){
					
					$description[] = [
						"type" => "text",
						"value" => $before
					];
				}
				
				// add link
				$description[] = [
					"type" => "link",
					"url" =>
						$this->unshiturl(
							$a["attributes"]
							["href"]
						),
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$a
						)
				];
			}
			
			if($container["innerHTML"] != ""){
				
				$description[] = [
					"type" => "text",
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$container["innerHTML"]
						)
				];
			}
			
			$out["answer"][] = [
				"title" => "Notice",
				"description" => $description,
				"url" => null,
				"thumb" => null,
				"table" => [],
				"sublink" => []
			];
		}
		
		//
		// remove duplicate web links cause instant answers
		// sometimes contains duplicates
		//
		$c = count($out["web"]);
		$links = [];
		
		for($i=0; $i<$c; $i++){
			
			foreach($links as $link){
				
				if($out["web"][$i]["url"] == $link){
					
					unset($out["web"][$i]);
					continue 2;
				}
			}
			
			$links[] = $out["web"][$i]["url"];
		}
		
		$out["web"] = array_values($out["web"]);
		
		return $out;
	}
	
	
	
	
	public function image($get){
		
		// generate parameters
		if($get["npt"]){
			
			[$params, $proxy] =
				$this->backend->get(
					$get["npt"],
					"images"
				);
			
			$params = json_decode($params, true);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
			
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$lang = $get["lang"];
			$time = $get["time"];
			$size = $get["size"];
			$ratio = $get["ratio"];
			$color = $get["color"];
			$type = $get["type"];
			$format = $get["format"];
			$rights = $get["rights"];
			
			$params = [
				"q" => $search,
				"tbm" => "isch"
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
			
			$tbs = [];
			
			// time
			if($time != "any"){
				
				$tbs[] = "qrd:" . $time;
			}
			
			// size
			if($size != "any"){
				
				if(
					in_array(
						$size,
						["l", "s", "i"]
					)
				){
					
					$tbs[] = "isz:" . $size;
				}else{
					
					$tbs[] = "tbz:lt";
					$tbs[] = "islt:" . $size;
				}
			}
			
			// ratio
			if($ratio != "any"){
				
				$tbs[] = "iar:" . $ratio;
			}
			
			// color
			if($color != "any"){
				
				if(
					in_array(
						$color,
						["color", "gray", "trans"]
					)
				){
					
					$tbs[] = "ic:" . $color;
				}else{
					
					$tbs[] = "ic:specific";
					$tbs[] = "isc:" . $color;
				}
			}
			
			// type
			if($type != "any"){
				
				$tbs[] = "itp:" . $type;
			}
			
			// format
			if($format != "any"){
				
				$tbs[] = "ift:" . $format;
			}
			
			// rights
			if($rights != "any"){
				
				$tbs[] = "il:" . $rights;
			}
			
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] =
					implode(",", $tbs);
			}
		}
		
		/*
		$handle = fopen("scraper/google-img.html", "r");
		$html = fread($handle, filesize("scraper/google-img.html"));
		fclose($handle);*/
		
		// scrape images
		try{
			$html = 
				$this->get(
					$proxy,
					"https://www.google.com/search",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get search page");
		}
		
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
		
		// get next page
		// https://www.google.com/search
		// ?q=higurashi
		// &tbm=isch
		// &async=_id%3Aislrg_c%2C_fmt%3Ahtml
		// &asearch=ichunklite
		// &ved=0ahUKEwidjYXJqJSAAxWrElkFHZ07CDwQtDIIQygA
		
		if(count($out["image"]) !== 100){
			
			// no more results
			return $out;
		}
		
		if($get["npt"]){
			
			// update nextpage information
			$params["start"] = (int)$params["start"] + count($out["image"]);
			$params["ijn"] = (int)$params["ijn"] + 1;
			
			$out["npt"] =
				$this->backend->store(
					json_encode($params),
					"images",
					$proxy
				);
		}else{
			
			// scrape nextpage information
			$this->fuckhtml->load($html);
			
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
				
				if(isset($imgvl[1])){
					$imgvl = $imgvl[1];
					
					$params["async"] = "_id:islrg_c,_fmt:html";
					$params["asearch"] = "ichunklite";
					$params["ved"] = $ved;
					$params["vet"] = "1" . $ved . "..i";
					$params["start"] = 100;
					$params["ijn"] = 1;
					$params["imgvl"] = $imgvl;
					
					$out["npt"] =
						$this->backend->store(
							json_encode($params),
							"images",
							$proxy
						);
				}
			}
		}
		
		return $out;
	}
	
	private function hms2int($time){
		
		$parts = explode(":", $time, 3);
		$time = 0;
		
		if(count($parts) === 3){
			
			// hours
			$time = $time + ((int)$parts[0] * 3600);
			array_shift($parts);
		}
		
		if(count($parts) === 2){
			
			// minutes
			$time = $time + ((int)$parts[0] * 60);
			array_shift($parts);
		}
		
		// seconds
		$time = $time + (int)$parts[0];
		
		return $time;
	}
	
	private function parsejavascript($html){
		
		$this->fuckhtml->load($html);
		
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
				'/var s=\'(data:image[^\']+)\';var i=\[(\'[^\;]*\')];/',
				$script["innerHTML"],
				$image_grep
			);
			
			if(count($image_grep[0]) !== 0){
				
				$items = explode(",", $image_grep[2][0]);
				$value =
					$this->fuckhtml
					->getTextContent(
						$image_grep[1][0]
					);
				
				foreach($items as $item){
					
					$this->js_image[trim($item, "' ")] = $value;
				}
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
					$this->fuckhtml->parseJsString(
						$ask_grep[2][$i]
					);
			}
		}
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
		
		if(isset($this->js_image[$id])){
			
			$return = $this->fuckhtml->parseJsString($this->js_image[$id]);
			
			if(
				$return != "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABAUlEQVR4AWMYesChoYElLjkzPj4lY3d8csZjIL4MxPNjUzPcSTYsISFLAqj5NBD/h+LPQPwbiT87NCuLh2gDgRr2QzXuT0jNMoBYksARn5zuHJ+UcR0kB6RXE2VYXHJGOlTDZmzyIJcB5e+D1CSkZDgQNBAaZv+jU1JkcKpJygiGeZ0I76a/Byq8jU9NZFqaCNTA48SE33/iDcw8TIyBt0GKQTFN0Msp6f2EIyUpo57YSIlLSrMhIg0WCIBcCfXSdlzJBsheTHQ6jEnOUgEFOLaEDbMIlhZBOYrorAdJk+nroVnvPsSgdGdoOF7HZyhZ2XPoGQoqjbCpIbt0AiejIQMArVLI7k/DXFkAAAAASUVORK5CYII=" &&
				$return != "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAA6ElEQVR4Ae2UvQ7BYBSGW4uFxlVICLsYDA0D14NEunRxHSJ+BkYG9ibiHtgkuvpZWOod3uFESqpOF/ElT/q958h5OtQx/iexY/evY9ACJjBewUtkXHEPyBYUNQQuCETuggNrF2DHF3A4kfUMmLB+BoUYAg4nIX0TTNnbfCjg8HDBGuR4z4Ij+813giAC8rcrkXusjdQEpMpcYt5rCzrMaea7tqD9JLhpCyrMZeadpmApssPaUOszXQALGHz67De0/2gpMGPP014VFpizfgJ5zWXnAF8MryW1rj3x5l8LJANQF1lZQH5f8AAWpNcUs6HAEAAAAABJRU5ErkJggg=="
			){
				
				if(
					preg_match(
						'/^\/\//',
						$return
					)
				){
					
					return 'https:' . $return;
				}
				
				return $return;
			}
			
			return null;
		}
	}
	
	private function parsecarousels(&$item_to_remove = false){
		
		$carousels =
			$this->fuckhtml
			->getElementsByClassName(
				$this->findstyles(
					[
						"padding" => "16px",
						"position" => "relative"
					],
					self::is_class
				)
			);
		
		$return = [];
		
		for($i=0; $i<count($carousels); $i++){
			
			if(!isset($carousels[$i]["outerHTML"])){
				
				continue;
			}
			
			$this->fuckhtml->load($carousels[$i]);
			
			if($item_to_remove !== false){
				
				$item_to_remove =
					str_replace(
						$carousels[$i]["outerHTML"],
						"",
						$item_to_remove
					);
			}
			
			$pcitems =
				$this->fuckhtml
				->getElementsByClassName(
					"pcitem",
					"div"
				);
			
			foreach($pcitems as $pcitem){
				
				$this->fuckhtml->load($pcitem);
				
				$out = [
					"url" => null,
					"ref" => null,
					"image" => null,
					"thumb_width" => null,
					"thumb_height" => null,
					"image_width" => null,
					"image_height" => null,
					"title" => null,
					"description" => null,
					"subtext" => null,
					"date" => null
				];
				
				$url =
					$this->unshiturl(
						$this->fuckhtml
						->getElementsByTagName("a")
						[0]
						["attributes"]
						["href"],
						true
					);
				
				// set ref
				$out["ref"] = $url["ref"];
				
				// set url
				$out["url"] = $url["url"];
				
				// set sizes
				$out["thumb_width"] = $url["thumb_width"];
				$out["thumb_height"] = $url["thumb_height"];
				$out["image_width"] = $url["image_width"];
				$out["image_height"] = $url["image_height"];
				
				// get image
				$out["image"] =
					$this->fuckhtml
					->getElementsByTagName(
						"img"
					);
				
				if(count($out["image"]) !== 0){
					
					// get title from image
					if(isset($out["image"][0]["attributes"]["alt"])){
						
						$out["title"] =
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$out["image"][0]["attributes"]["alt"]
								)
							);
					}
					
					// get image url
					if(isset($out["image"][0]["attributes"]["id"])){
						
						$out["image"] = $this->getimage($out["image"][0]["attributes"]["id"]);
					}
					
					elseif(isset($out["image"][0]["attributes"]["data-ll"])){
						
						$out["image"] =
							$this->fuckhtml
							->getTextContent(
								$out["image"][0]["attributes"]["data-ll"]
							);
					}else{
						
						// failed to get image information
						$out["image"] = null;
					}
					
					if($out["image"] == 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYAgMAAACdGdVrAAAADFBMVEVMaXFChfRChfRChfT0tCPZAAAAA3RSTlMAgFJEkGxNAAAAL0lEQVR4AWPADxgdwBT3BTDF9AUiuhdC6WNK/v///y+UggrClSA07EWVglmEFwAA5eYSExeCwigAAAAASUVORK5CYII='){
						
						// found arrow image base64, skip entry
						continue;
					}
				}else{
					
					// Could not find any image in node
					$out["image"] = null;
				}
				
				// get title from spans
				$title =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"color" => "#1967d2"
							],
							self::is_class
						),
						"span"
					);
				
				if(count($title) !== 0){
					
					$out["title"] =
						$this->fuckhtml
						->getTextContent(
							$title[0]
						);
				}
				
				// get textnodes
				$textnodes =
					$this->fuckhtml
					->getElementsByClassName(
						$this->findstyles(
							[
								"white-space" => "pre-line",
								"word-wrap" => "break-word"
							],
							self::is_class
						)
					);
				
				$subtext = null;
				
				if(count($textnodes) !== 0){
					
					// get date
					$date =
						$this->fuckhtml
						->getTextContent(
							$textnodes[count($textnodes) - 1],
							true
						);
					
					if(str_replace("\n", " ", $date) == $title){
						
						$date = null;
					}else{
						
						if(strpos($date, "\n") !== false){
							
							$date = explode("\n", $date);
							$date = $date[count($date) - 1];
						}
						elseif(strpos($date, "•") !== false){
							
							$date = explode("•", $date);
							$date = ltrim($date[count($date) - 1]);
						}else{
							
							$date = null;
						}
					}
					
					if($date !== null){
						
						$date = strtotime($date);
					}
					
					// get description
					$description =
						$this->fuckhtml
						->getTextContent(
							$textnodes[0]
						);
					
					if($out["title"] === null){
						
						if($date === null){
							
							$out["title"] = $description;
							$description = null;
						}else{
							
							$out["title"] = parse_url($out["url"], PHP_URL_HOST);
						}
					}
					
					if(isset($textnodes[1])){
						
						$out["subtext"] =
							$this->fuckhtml
							->getTextContent(
								$textnodes[1]
							);
					}
					
				}else{
					
					$date = null;
					$description = null;
				}
				
				$out["date"] = $date;
				$out["description"] = $this->titledots($description);
				
				if($out["url"] === null){
					
					$out["url"] = $out["title"];
				}
				
				if($out["title"] == $out["description"]){
					
					$out["description"] = null;
				}
				
				$return[$i][] = $out;
			}
		}
		
		return $return;
	}
	
	private function unshiturl($url, $return_size = false){
		
		// get parameters from URL
		$url =
			$this->fuckhtml
			->getTextContent($url);
		
		$newurl = parse_url($url, PHP_URL_QUERY);
		
		if($newurl == ""){
			
			// probably telephone number
			return $url;
		}
		
		$url = $newurl;
		unset($newurl);
		
		parse_str($url, $query);
		
		if(isset($query["imgurl"])){
			
			$url = $query["imgurl"];
		}
		elseif(isset($query["q"])){
			
			$url = $query["q"];
		}
		
		// rewrite URLs to remove extra tracking parameters
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
		
		elseif(
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
		
		elseif(
			preg_match(
				'/play\.google\.[^.]+$/',
				$domain
			)
		){
			
			// remove referrers from play.google.com
			$oldquery = parse_url($url, PHP_URL_QUERY);
			if($oldquery !== null){
				
				parse_str($oldquery, $query);
				if(isset($query["referrer"])){ unset($query["referrer"]); }
				if(isset($query["hl"])){ unset($query["hl"]); }
				if(isset($query["gl"])){ unset($query["gl"]); }
				
				$query = http_build_query($query);
				
				$url =
					str_replace(
						$oldquery,
						$query,
						$url
					);
			}
		}
		
		elseif(
			preg_match(
				'/twitter\.com$/',
				$domain
			)
		){
			
			// remove more referrers from twitter.com
			$oldquery = parse_url($url, PHP_URL_QUERY);
			if($oldquery !== null){
				
				parse_str($oldquery, $query);
				if(isset($query["ref_src"])){ unset($query["ref_src"]); }
				
				$query = http_build_query($query);
				
				if($query != ""){
					
					$query .= "?" . $query;
				}
				
				$url =
					str_replace(
						'?' . $oldquery,
						$query,
						$url
					);
			}
		}
		
		elseif(
			preg_match(
				'/maps\.google\.[^.]+/',
				$domain
			)
		){
			
			if(stripos($url, "maps?") !== false){
				
				//https://maps.google.com/maps?daddr=Johnny,+603+Rue+St+Georges,+Saint-J%C3%A9r%C3%B4me,+Quebec+J7Z+5B7
				$query = parse_url($url, PHP_URL_QUERY);

				if($query !== null){
					
					parse_str($query, $query);
					
					if(isset($query["daddr"])){
						
						$url =
							"https://maps.google.com/maps?daddr=" .
							urlencode($query["daddr"]);
					}
				}
			}
		}
		
		if($return_size){
			
			return [
				"url" => $url,
				"ref" => isset($query["imgrefurl"]) ? $query["imgrefurl"] : null,
				"thumb_width" => isset($query["tbnw"]) ? (int)$query["tbnw"] : null,
				"thumb_height" => isset($query["tbnh"]) ? (int)$query["tbnh"] : null,
				"image_width" => isset($query["w"]) ? (int)$query["w"] : null,
				"image_height" => isset($query["h"]) ? (int)$query["h"] : null
			];
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
		
		return rtrim($title, ". \t\n\r\0\x0B");
	}
}
