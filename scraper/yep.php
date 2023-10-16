<?php

class yep{
	
	public function __construct(){
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("yep");
	}
	
	public function getfilters($page){
		
		return [
			"country" => [
				"display" => "Country",
				"option" => [
					"all" => "All regions",
					"af" => "Afghanistan",
					"al" => "Albania",
					"dz" => "Algeria",
					"as" => "American Samoa",
					"ad" => "Andorra",
					"ao" => "Angola",
					"ai" => "Anguilla",
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
					"bt" => "Bhutan",
					"bo" => "Bolivia",
					"ba" => "Bosnia and Herzegovina",
					"bw" => "Botswana",
					"br" => "Brazil",
					"bn" => "Brunei Darussalam",
					"bg" => "Bulgaria",
					"bf" => "Burkina Faso",
					"bi" => "Burundi",
					"cv" => "Cabo Verde",
					"kh" => "Cambodia",
					"cm" => "Cameroon",
					"ca" => "Canada",
					"ky" => "Cayman Islands",
					"cf" => "Central African Republic",
					"td" => "Chad",
					"cl" => "Chile",
					"cn" => "China",
					"co" => "Colombia",
					"cg" => "Congo",
					"cd" => "Congo, Democratic Republic",
					"ck" => "Cook Islands",
					"cr" => "Costa Rica",
					"hr" => "Croatia",
					"cu" => "Cuba",
					"cy" => "Cyprus",
					"cz" => "Czechia",
					"ci" => "Côte d'Ivoire",
					"dk" => "Denmark",
					"dj" => "Djibouti",
					"dm" => "Dominica",
					"do" => "Dominican Republic",
					"ec" => "Ecuador",
					"eg" => "Egypt",
					"sv" => "El Salvador",
					"gq" => "Equatorial Guinea",
					"ee" => "Estonia",
					"et" => "Ethiopia",
					"fo" => "Faroe Islands",
					"fj" => "Fiji",
					"fi" => "Finland",
					"fr" => "France",
					"gf" => "French Guiana",
					"pf" => "French Polynesia",
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
					"gg" => "Guernsey",
					"gn" => "Guinea",
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
					"la" => "Lao People's Democratic Republic",
					"lv" => "Latvia",
					"lb" => "Lebanon",
					"ls" => "Lesotho",
					"ly" => "Libya",
					"li" => "Liechtenstein",
					"lt" => "Lithuania",
					"lu" => "Luxembourg",
					"mk" => "Macedonia",
					"mg" => "Madagascar",
					"mw" => "Malawi",
					"my" => "Malaysia",
					"mv" => "Maldives",
					"ml" => "Mali",
					"mt" => "Malta",
					"mq" => "Martinique",
					"mr" => "Mauritania",
					"mu" => "Mauritius",
					"yt" => "Mayotte",
					"mx" => "Mexico",
					"fm" => "Micronesia, Federated States of",
					"md" => "Moldova",
					"mc" => "Monaco",
					"mn" => "Mongolia",
					"me" => "Montenegro",
					"ms" => "Montserrat",
					"ma" => "Morocco",
					"mz" => "Mozambique",
					"mm" => "Myanmar",
					"na" => "Namibia",
					"nr" => "Nauru",
					"np" => "Nepal",
					"nl" => "Netherlands",
					"nc" => "New Caledonia",
					"nz" => "New Zealand",
					"ni" => "Nicaragua",
					"ne" => "Niger",
					"ng" => "Nigeria",
					"nu" => "Niue",
					"no" => "Norway",
					"om" => "Oman",
					"pk" => "Pakistan",
					"ps" => "Palestine, State of",
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
					"ro" => "Romania",
					"ru" => "Russian Federation",
					"rw" => "Rwanda",
					"re" => "Réunion",
					"sh" => "Saint Helena",
					"kn" => "Saint Kitts and Nevis",
					"lc" => "Saint Lucia",
					"vc" => "Saint Vincent and the Grenadines",
					"ws" => "Samoa",
					"sm" => "San Marino",
					"st" => "Sao Tome and Principe",
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
					"kr" => "Sourth Korea",
					"za" => "South Africa",
					"es" => "Spain",
					"lk" => "Sri Lanka",
					"sr" => "Suriname",
					"se" => "Sweden",
					"ch" => "Switzerland",
					"tw" => "Taiwan",
					"tj" => "Tajikistan",
					"tz" => "Tanzania",
					"th" => "Thailand",
					"tl" => "Timor-Leste",
					"tg" => "Togo",
					"tk" => "Tokelau",
					"to" => "Tonga",
					"tt" => "Trinidad and Tobago",
					"tn" => "Tunisia",
					"tr" => "Turkey",
					"tm" => "Turkmenistan",
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
					"vg" => "Virgin Islands, British",
					"vi" => "Virgin Islands, U.S.",
					"ye" => "Yemen",
					"zm" => "Zambia",
					"zw" => "Zimbabwe"
				]
			],
			"nsfw" => [
				"display" => "NSFW",
				"option" => [
					"yes" => "Yes",
					"maybe" => "Maybe",
					"no" => "No"
				]
			]
		];
	}
	
	private function get($url, $get = []){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:107.0) Gecko/20100101 Firefox/110.0",
			"Accept: */*",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"DNT: 1",
			"Origin: https://yep.com",
			"Referer: https://yep.com/",
			"Connection: keep-alive",
			"Sec-Fetch-Dest: empty",
			"Sec-Fetch-Mode: cors",
			"Sec-Fetch-Site: same-site"]
		);
		
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
	
	public function image($get){
		
		$search = $get["s"];
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		
		switch($nsfw){
			
			case "yes": $nsfw = "off"; break;
			case "maybe": $nsfw = "moderate"; break;
			case "no": $nsfw = "strict"; break;
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		try{
			
			$json =
				json_decode(
					$this->get(
						"https://api.yep.com/fs/2/search",
						[
							"client" => "web",
							"gl" => $country == "all" ? $country : strtoupper($country),
							"no_correct" => "false",
							"q" => $search,
							"safeSearch" => $nsfw,
							"type" => "images"
						]
					),
					true
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		foreach($json[1]["results"] as $item){
			
			if(
				$item["width"] !== 0 &&
				$item["height"] !== 0
			){
				
				$thumb_width = $item["width"] >= 260 ? 260 : $item["width"];
				$thumb_height = ceil($item["height"] * ($thumb_width / $item["width"]));
				
				$width = $item["width"];
				$height = $item["height"];
			}else{
				
				$thumb_width = null;
				$thumb_height = null;
				$width = null;
				$height = null;
			}
			
			$out["image"][] = [
				"title" => $item["title"],
				"source" => [
					[
						"url" => $item["image_id"],
						"width" => $width,
						"height" => $height
					],
					[
						"url" => $item["src"],
						"width" => $thumb_width,
						"height" => $thumb_height
					]
				],
				"url" => $item["host_page"]
			];
		}
		
		return $out;
	}
}
