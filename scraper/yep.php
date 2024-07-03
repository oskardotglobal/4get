<?php

class yep{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("yep");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
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
	
	private function get($proxy, $url, $get = []){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		// use http2
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
		// set ciphers
		curl_setopt(
			$curlproc,
			CURLOPT_SSL_CIPHER_LIST,
			"aes_128_gcm_sha_256,chacha20_poly1305_sha_256,aes_256_gcm_sha_384,ecdhe_ecdsa_aes_128_gcm_sha_256,ecdhe_rsa_aes_128_gcm_sha_256,ecdhe_ecdsa_chacha20_poly1305_sha_256,ecdhe_rsa_chacha20_poly1305_sha_256,ecdhe_ecdsa_aes_256_gcm_sha_384,ecdhe_rsa_aes_256_gcm_sha_384,ecdhe_ecdsa_aes_256_sha,ecdhe_ecdsa_aes_128_sha,ecdhe_rsa_aes_128_sha,ecdhe_rsa_aes_256_sha,rsa_aes_128_gcm_sha_256,rsa_aes_256_gcm_sha_384,rsa_aes_128_sha,rsa_aes_256_sha"
		);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: " . config::USER_AGENT,
			"Accept: */*",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip, deflate, br, zstd",
			"Referer: https://yep.com/",
			"Origin: https://yep.com",
			"DNT: 1",
			"Connection: keep-alive",
			"Sec-Fetch-Dest: empty",
			"Sec-Fetch-Mode: cors",
			"Sec-Fetch-Site: same-site",
			"Priority: u=4",
			"TE: trailers"]
		);
		
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
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		
		switch($nsfw){
			
			case "yes": $nsfw = "off"; break;
			case "maybe": $nsfw = "moderate"; break;
			case "no": $nsfw = "strict"; break;
		}
		
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
		
		try{
			
			// https://api.yep.com/fs/2/search?client=web&gl=CA&no_correct=false&q=undefined+variable+javascript&safeSearch=off&type=web
			$json =
				$this->get(
					$this->backend->get_ip(),
					"https://api.yep.com/fs/2/search",
					[
						"client" => "web",
						"gl" => $country == "all" ? $country : strtoupper($country),
						"limit" => "99999",
						"no_correct" => "false",
						"q" => $search,
						"safeSearch" => $nsfw,
						"type" => "web"
					]
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		$this->detect_cf($json);
		
		$json = json_decode($json, true);
		//$json = json_decode(file_get_contents("scraper/yep.json"), true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		if(isset($json[1]["correction"])){
			
			$out["spelling"] = [
				"type" => "not_many",
				"using" => $search,
				"correction" => $json[1]["correction"][1]
			];
		}
		
		if(isset($json[1]["results"])){
			foreach($json[1]["results"] as $item){
				
				switch(strtolower($item["type"])){
					
					case "organic":
						$sublinks = [];
						
						if(isset($item["sitelinks"]["full"])){
							
							foreach($item["sitelinks"]["full"] as $link){
								
								$sublinks[] = [
									"title" => $link["title"],
									"date" => null,
									"description" =>
										$this->titledots(
											strip_tags(
												html_entity_decode(
													$link["snippet"]
												)
											)
										),
									"url" => $link["url"]
								];
							}
						}
						
						$out["web"][] = [
							"title" => $item["title"],
							"description" =>
								$this->titledots(
									strip_tags(
										html_entity_decode(
											$item["snippet"]
										)
									)
								),
							"url" => $item["url"],
							"date" => strtotime($item["first_seen"]),
							"type" => "web",
							"thumb" => [
								"url" => null,
								"ratio" => null
							],
							"sublink" => $sublinks,
							"table" => []
						];
						break;
				}
			}
		}
		
		if(isset($json[1]["featured_news"])){
			
			foreach($json[1]["featured_news"] as $news){
				
				$out["news"][] = [
					"title" => $news["title"],
					"description" =>
						$this->titledots(
							strip_tags(
								html_entity_decode(
									$news["snippet"]
								)
							)
						),
					"date" => strtotime($news["first_seen"]),
					"thumb" =>
						isset($news["img"]) ?
						[
							"url" => $this->unshiturl($news["img"]),
							"ratio" => "16:9"
						] :
						[
							"url" => null,
							"ratio" => null
						],
					"url" => $news["url"]
				];
			}
		}
		
		if(isset($json[1]["featured_images"])){
			
			foreach($json[1]["featured_images"] as $image){
				
				if(
					$image["width"] !== 0 &&
					$image["height"] !== 0
				){
					
					$thumb_width = $image["width"] >= 260 ? 260 : $image["width"];
					$thumb_height = ceil($image["height"] * ($thumb_width / $image["width"]));
					
					$width = $image["width"];
					$height = $image["height"];
				}else{
					
					$thumb_width = null;
					$thumb_height = null;
					$width = null;
					$height = null;
				}
				
				$out["image"][] = [
					"title" => $image["title"],
					"source" => [
						[
							"url" => $image["image_id"],
							"width" => $width,
							"height" => $height
						],
						[
							"url" => $image["src"],
							"width" => $thumb_width,
							"height" => $thumb_height
						]
					],
					"url" => $image["host_page"]
				];
			}
		}
		
		return $out;
	}
	
	
	
	public function image($get){
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
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
				$this->get(
					$this->backend->get_ip(), // no nextpage!
					"https://api.yep.com/fs/2/search",
					[
						"client" => "web",
						"gl" => $country == "all" ? $country : strtoupper($country),
						"no_correct" => "false",
						"q" => $search,
						"safeSearch" => $nsfw,
						"type" => "images"
					]
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		$this->detect_cf($json);
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		if(isset($json[1]["results"])){
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
		}
		
		return $out;
	}
	
	
	public function news($get){
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
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
			"news" => []
		];
		
		try{
			
			// https://api.yep.com/fs/2/search?client=web&gl=CA&no_correct=false&q=undefined+variable+javascript&safeSearch=off&type=web
			$json =
				$this->get(
					$this->backend->get_ip(),
					"https://api.yep.com/fs/2/search",
					[
						"client" => "web",
						"gl" => $country == "all" ? $country : strtoupper($country),
						"limit" => "99999",
						"no_correct" => "false",
						"q" => $search,
						"safeSearch" => $nsfw,
						"type" => "news"
					]
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		$this->detect_cf($json);
		
		$json = json_decode($json, true);
		//$json = json_decode(file_get_contents("scraper/yep.json"), true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		if(isset($json[1]["results"])){
			foreach($json[1]["results"] as $item){
				
				$out["news"][] = [
					"title" => $item["title"],
					"author" => null,
					"description" =>
						$this->titledots(
							strip_tags(
								html_entity_decode(
									$item["snippet"]
								)
							)
						),
					"date" => strtotime($item["first_seen"]),
					"thumb" =>
						isset($item["img"]) ?
						[
							"url" => $this->unshiturl($item["img"]),
							"ratio" => "16:9"
						] :
						[
							"url" => null,
							"ratio" => null
						],
					"url" => $item["url"]
				];
			}
		}
		
		return $out;
	}
	
	
	private function detect_cf($payload){
		
		// detect cloudflare page
		$this->fuckhtml->load($payload);
		
		if(
			count(
				$this->fuckhtml
				->getElementsByClassName(
					"cf-wrapper",
					"div"
				)
			) !== 0
		){
			
			throw new Exception("Blocked by Cloudflare. Please follow curl-impersonate installation instructions");
		}
	}
	
	
	private function titledots($title){
		
		$substr = substr($title, -4);
		
		if(
			strpos($substr, "...") !== false ||
			strpos($substr, "…") !== false
		){
						
			return trim(substr($title, 0, -4));
		}
		
		return trim($title);
	}
	
	private function unshiturl($url){
		
		$newurl = parse_url($url, PHP_URL_QUERY);
		parse_str($newurl, $newurl);
		
		if(isset($newurl["url"])){
			
			return $newurl["url"];
		}
		
		return $url;
	}
}
