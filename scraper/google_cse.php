<?php

class google_cse{
	
	public const req_html = 0;
	public const req_js = 1;
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("google_cse");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		$base = [
			"country" => [ // gl=<country> (image: cr=countryAF)
				"display" => "Country",
				"option" => [
					"any" => "Any country",
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
			"spellcheck" => [
				// display undefined
				"option" => [
					"yes" => "Yes",
					"no" => "No"
				]
			]
		];
		
		switch($page){
			
			case "web":
				return array_merge(
					$base,
					[
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
						"sort" => [
							"display" => "Sort by",
							"option" => [
								"relevance" => "Relevance",
								"date" => "Date"
							]
						],
						"redundant" => [
							"display" => "Remove redundant",
							"option" => [
								"yes" => "Yes",
								"no" => "No",
							]
						]
					]
				);
				break;
			
			case "images":
				return array_merge(
					$base,
					[
						"size" => [ // imgsz
							"display" => "Size",
							"option" => [
								"any" => "Any size",
								"l" => "Large",
								"m" => "Medium",
								"i" => "Icon",
								"qsvga" => "Larger than 400x300",
								"vga" => "Larger than 640x480",
								"svga" => "Larger than 800x600",
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
						"color" => [ // imgc
							"display" => "Color",
							"option" => [
								"any" => "Any color",
								"color" => "Full color",
								"bnw" => "Black & white",
								"trans" => "Transparent",
								// from here, imgcolor
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
						"format" => [ // as_filetype
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
						]
					]
				);
				break;
		}
	}
	
	private function get($proxy, $url, $get = [], $reqtype = self::req_js){
		
		$curlproc = curl_init();
			
		if($get !== []){
			
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		// http2 bypass
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
		if($reqtype === self::req_js){
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: */*",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"DNT: 1",
				"Sec-GPC: 1",
				"Alt-Used: cse.google.com",
				"Connection: keep-alive",
				"Referer: https://cse.google.com/cse?cx=" . config::GOOGLE_CX_ENDPOINT,
				"Sec-Fetch-Dest: script",
				"Sec-Fetch-Mode: no-cors",
				"Sec-Fetch-Site: same-origin",
				"TE: trailers"]
			);
		}else{
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/png,image/svg+xml,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"DNT: 1",
				"Sec-GPC: 1",
				"Connection: keep-alive",
				"Upgrade-Insecure-Requests: 1",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: none",
				"Sec-Fetch-User: ?1",
				"Priority: u=0, i"]
			);
		}
		
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
		
		// page 1
		// https://cse.google.com/cse/element/v1?rsz=filtered_cse&num=10&hl=en&source=gcsc&cselibv=8fa85d58e016b414&cx=d4e68b99b876541f0&q=asmr&safe=active&cse_tok=AB-tC_6RPUTmB4XK0lE9e1AFFC5r%3A1729563832926&lr=&cr=&gl=&filter=0&sort=&as_oq=&as_sitesearch=&exp=cc%2Capo&oq=asmr&gs_l=partner-web.3..0i512i433j0i512i433i131l2j0i512i433j0i512i433i131j0i512i433j0i512i433i131l2j0i512l2.10902.266627.5.267157.11.10.0.0.0.0.188.1108.2j7.9.0.csems%2Cnrl%3D10...0....1.34.partner-web..42.14.1500.WJQvMvfXkx4&cseclient=hosted-page-client&callback=google.search.cse.api8223&rurl=https%3A%2F%2Fcse.google.com%2Fcse%3Fcx%3Dd4e68b99b876541f0%23gsc.tab%3D0%26gsc.q%3Dtest%26gsc.sort%3D
		
		// page 2
		// https://cse.google.com/cse/element/v1?rsz=filtered_cse&num=10&hl=en&source=gcsc&start=10&cselibv=8fa85d58e016b414&cx=d4e68b99b876541f0&q=asmr&safe=active&cse_tok=AB-tC_6RPUTmB4XK0lE9e1AFFC5r%3A1729563832926&lr=&cr=&gl=&filter=0&sort=&as_oq=&as_sitesearch=&exp=cc%2Capo&callback=google.search.cse.api3595&rurl=https%3A%2F%2Fcse.google.com%2Fcse%3Fcx%3Dd4e68b99b876541f0%23gsc.tab%3D0%26gsc.q%3Dtest%26gsc.sort%3D
		
		if($get["npt"]){
			
			[$req_params, $proxy] =
				$this->backend->get(
					$get["npt"],
					"web"
				);
			
			$req_params =
				json_decode(
					$req_params,
					true
				);
			
			$json =
				$this->get(
					$proxy,
					"https://cse.google.com/cse/element/v1",
					$req_params,
					self::req_js
				);
			
		}else{
			
			$proxy = $this->backend->get_ip();
			$params = $this->generate_token($proxy);
			
			//$json = file_get_contents("scraper/google_cse.txt");
			$req_params = [
				"rsz" => "filtered_cse",
				"num" => 20,
				"hl" => "en",
				"source" => "gcsc",
				"cselibv" => $params["lib"],
				"cx" => config::GOOGLE_CX_ENDPOINT,
				"q" => $get["s"],
				"safe" => $get["nsfw"] == "yes" ? "off" : "active",
				"cse_tok" => $params["token"],
				"lr" => $get["lang"] == "any" ? "" : "lang_" . $get["lang"],
				"cr" => $get["country"] == "any" ? "" : "country" . strtoupper($get["country"]),
				"gl" => "",
				"filter" => $get["redundant"] == "yes" ? "1" : "0",
				"sort" => $get["sort"] == "relevance" ? "" : "date",
				"as_oq" => "",
				"as_sitesearch" => "",
				"exp" => "cc,apo",
				"oq" => $get["s"],
				"gs_l" => "partner-web.3...33294.34225.3.34597.26.11.0.0.0.0.201.1132.6j4j1.11.0.csems,nrl=10...0....1.34.partner-web..34.19.1897.FKEeG5yh2iw",
				"cseclient" => "hosted-page-client",
				"callback" => "google.search.cse.api" . random_int(4000, 99999),
				"rurl" => "https://cse.google.com/cse?cx=" . config::GOOGLE_CX_ENDPOINT . "#gsc.tab=0&gsc.q=" . $get["s"] . "&gsc.sort="
			];
			
			if($get["spellcheck"] == "no"){
				
				$req_params["nfpr"] = "1";
			}
			
			$json =
				$this->get(
					$proxy,
					"https://cse.google.com/cse/element/v1",
					$req_params,
					self::req_js
				);
			
			unset($req_params["gs_l"]);
			$req_params["start"] = 0;
		}
		
		$req_params["start"] += 20;
		
		if(
			!preg_match(
				'/google\.search\.cse\.[A-Za-z0-9]+\(([\S\s]*)\);/i',
				$json,
				$json
			)
		){
			
			throw new Exception("Failed to grep JSON");
		}
		
		$json = json_decode($json[1], true);
		
		if(isset($json["error"])){
			
			if(isset($json["error"]["errors"][0]["message"])){
				
				throw new Exception("Google returned an error: " . $json["error"]["errors"][0]["message"]);
			}
			
			if(isset($json["error"]["message"])){
				
				throw new Exception("Google returned an error: " . $json["error"]["message"]);
			}
			
			throw new Exception("Google returned an error object");
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
		
		// detect word correction
		if(isset($json["spelling"]["type"])){
			
			switch($json["spelling"]["type"]){
				
				case "DYM": // did you mean? @TODO fix wording
					$type = "including";
					break;
				
				case "SPELL_CORRECTED_RESULTS": // not many results for
					$type = "not_many";
					break;
				
				default:
					$type = "not_many";
			}
			
			if(isset($json["spelling"]["originalQuery"])){
				
				$using = $json["spelling"]["originalQuery"];
			}
			elseif(isset($json["spelling"]["anchor"])){
				
				$using = html_entity_decode(strip_tags($json["spelling"]["anchor"]));
			}elseif(isset($json["spelling"]["originalAnchor"])){
				
				$using = html_entity_decode(strip_tags($json["spelling"]["originalAnchor"]));
			}
			
			$out["spelling"] = [
				"type" => $type,
				"using" => $using,
				"correction" => $json["spelling"]["correctedQuery"]
			];
		}
		
		if(!isset($json["results"])){
			
			return $out;
		}
		
		foreach($json["results"] as $result){
			
			// get date from description
			$description =
				explode(
					"...",
					trim($result["contentNoFormatting"], " ."),
					2
				);
			
			if(count($description) === 2){
				
				if($date = strtotime($description[0])){
					
					$description = ltrim($description[1]);
				}else{
					
					$date = null;
					$description = implode("...", $description);
				}
			}else{
				
				$description = implode("...", $description);
				$date = null;
			}
			
			$description = trim($description, " .");
			
			// get thumbnails
			if(isset($result["richSnippet"]["cseThumbnail"]["src"])){
				
				$thumb = [
					"url" => $this->unshit_thumb($result["richSnippet"]["cseThumbnail"]["src"]),
					"ratio" => "1:1"
				];
			}
			elseif(isset($result["richSnippet"]["cseImage"]["src"])){
				
				$thumb = [
					"url" => $result["richSnippet"]["cseImage"]["src"],
					"ratio" => "1:1"
				];
			}else{
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}
			
			if($thumb["url"] !== null){
				
				$found_size = false;
				
				// find correct ratio
				
				if(
					isset($result["richSnippet"]["cseThumbnail"]["width"]) &&
					isset($result["richSnippet"]["cseThumbnail"]["height"])
				){
					$found_size = true;
					$width = (int)$result["richSnippet"]["cseThumbnail"]["width"];
					$height = (int)$result["richSnippet"]["cseThumbnail"]["height"];
				}
				elseif(
					isset($result["richSnippet"]["metatags"]["ogImageWidth"]) &&
					isset($result["richSnippet"]["metatags"]["ogImageHeight"])
				){
					$found_size = true;
					$width = (int)$result["richSnippet"]["metatags"]["ogImageWidth"];
					$height = (int)$result["richSnippet"]["metatags"]["ogImageHeight"];
				}
				
				// calculate rounded ratio
				if($found_size){
					
					$aspect_ratio = $width / $height;
					
					if($aspect_ratio >= 1.5){
						
						$thumb["ratio"] = "16:9";
					}
					elseif($aspect_ratio >= 0.8){
						
						$thumb["ratio"] = "1:1";
					}else{
						
						$thumb["ratio"] = "9:16";
					}
				}
			}
			
			$out["web"][] = [
				"title" => rtrim($result["titleNoFormatting"], " ."),
				"description" => $description,
				"url" => $result["unescapedUrl"],
				"date" => $date,
				"type" => "web",
				"thumb" => $thumb,
				"sublink" => [],
				"table" => []
			];
		}
		
		// detect next page
		if(
			isset($json["cursor"]["isExactTotalResults"]) || // detects last page
			!isset($json["cursor"]["pages"]) // detects no results on page
		){
			
			return $out;
		}
		
		// get next page
		$out["npt"] =			
			$this->backend->store(
				json_encode(
					$req_params
				),
				"web",
				$proxy
			);
		
		return $out;
	}
	
	public function image($get){
		
		if($get["npt"]){
			
			[$req_params, $proxy] =
				$this->backend->get(
					$get["npt"],
					"images"
				);
			
			$req_params =
				json_decode(
					$req_params,
					true
				);
			
			$json =
				$this->get(
					$proxy,
					"https://cse.google.com/cse/element/v1",
					$req_params,
					self::req_js
				);
			
		}else{
			
			$proxy = $this->backend->get_ip();
			$params = $this->generate_token($proxy);
			
			//$json = file_get_contents("scraper/google_cse.txt");
			$req_params = [
				"rsz" => "filtered_cse",
				"num" => 20,
				"hl" => "en",
				"source" => "gcsc",
				"cselibv" => $params["lib"],
				"searchtype" => "image",
				"cx" => config::GOOGLE_CX_ENDPOINT,
				"q" => $get["s"],
				"safe" => $get["nsfw"] == "yes" ? "off" : "active",
				"cse_tok" => $params["token"],
				"exp" => "cc,apo",
				"cseclient" => "hosted-page-client",
				"callback" => "google.search.cse.api" . random_int(4000, 99999),
				"rurl" => "https://cse.google.com/cse?cx=" . config::GOOGLE_CX_ENDPOINT . "#gsc.tab=1&gsc.q=" . $get["s"] . "&gsc.sort="
			];
			
			// add additional hidden filters
			
			// country (image search uses cr instead of gl)
			if($get["country"] != "any"){
				
				$req_params["cr"] = "country" . strtoupper($get["country"]);
			}
			
			// nsfw
			$req_params["safe"] = $get["nsfw"] == "yes" ? "off" : "active";
			
			// size
			if($get["size"] != "any"){
				
				$req_params["imgsz"] = $get["size"];
			}
			
			// format
			if($get["format"] != "any"){
				
				$req_params["as_filetype"] = $get["format"];
			}
			
			// color
			if($get["color"] != "any"){
				
				if(
					$get["color"] == "color" ||
					$get["color"] == "trans"
				){
					
					$req_params["imgc"] = $get["color"];
				}elseif($get["color"] == "bnw"){
					
					$req_params["imgc"] = "gray";
				}else{
					
					$req_params["imgcolor"] = $get["color"];
				}
			}
			
			$json =
				$this->get(
					$proxy,
					"https://cse.google.com/cse/element/v1",
					$req_params,
					self::req_js
				);
			
			$req_params["start"] = 0;
		}
		
		$req_params["start"] += 20;
		
		if(
			!preg_match(
				'/google\.search\.cse\.[A-Za-z0-9]+\(([\S\s]*)\);/i',
				$json,
				$json
			)
		){
			
			throw new Exception("Failed to grep JSON");
		}
		
		$json = json_decode($json[1], true);
		
		if(isset($json["error"])){
			
			if(isset($json["error"]["errors"][0]["message"])){
				
				throw new Exception("Google returned an error: " . $json["error"]["errors"][0]["message"]);
			}
			
			if(isset($json["error"]["message"])){
				
				throw new Exception("Google returned an error: " . $json["error"]["message"]);
			}
			
			throw new Exception("Google returned an error object");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		// detect next page
		if(
			isset($json["cursor"]["isExactTotalResults"]) || // detects last page
			!isset($json["cursor"]["pages"]) // detects no results on page
		){
			
			return $out;
		}
		
		foreach($json["results"] as $result){
			
			$out["image"][] = [
				"title" => rtrim($result["titleNoFormatting"], " ."),
				"source" => [
					[
						"url" => $result["unescapedUrl"],
						"width" => (int)$result["width"],
						"height" => (int)$result["height"]
					],
					[
						"url" => $result["tbLargeUrl"],
						"width" => (int)$result["tbLargeWidth"],
						"height" => (int)$result["tbLargeHeight"]
					]
				],
				"url" => $result["originalContextUrl"]
			];
		}
		
		// get next page
		$out["npt"] =			
			$this->backend->store(
				json_encode(
					$req_params
				),
				"images",
				$proxy
			);
		
		return $out;
	}
	
	private function generate_token($proxy){
		
		$html =
			$this->get(
				$proxy,
				"https://cse.google.com/cse",
				[
					"cx" => config::GOOGLE_CX_ENDPOINT
				],
				self::req_html
			);
		
		// detect captcha
		$this->fuckhtml->load($html);
		
		$title =
			$this->fuckhtml
			->getElementsByTagName(
				"title"
			);
		
		if(
			count($title) !== 0 &&
			$title[0]["innerHTML"] == "302 Moved"
		){
			
			throw new Exception("Google returned a captcha");
		}
		
		// get token
		preg_match(
			'/relativeUrl=\'([^\']+)\';/i',
			$html,
			$js_uri
		);
		
		if(!isset($js_uri[1])){
			
			throw new Exception("Failed to grep search token");
		}
		
		$js_uri =
			$this->fuckhtml
			->parseJsString(
				$js_uri[1]
			);
		
		// get parameters
		$js =
			$this->get(
				$proxy,
				"https://cse.google.com" . $js_uri,
				[],
				self::req_js
			);
		
		preg_match(
			'/}\)\(({[\S\s]+})\);/',
			$js,
			$json
		);
		
		if(!isset($json[1])){
			
			throw new Exception("Failed to grep JSON parameters");
		}
		
		$json = json_decode($json[1], true);
		
		return [
			"token" => $json["cse_token"],
			"lib" => $json["cselibVersion"]
		];
	}
	
	private function unshit_thumb($url){
		// https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQINE2vbnNLHXqoZr3RVsaEJFyOsj1_BiBnJch-e1nyz3oia7Aj5xVj
		// https://i.ytimg.com/vi/PZVIyA5ER3Y/mqdefault.jpg?sqp=-oaymwEFCJQBEFM&rs=AMzJL3nXeaCpdIar-ltNwl82Y82cIJfphA
		
		$parts = parse_url($url);
		
		if(
			isset($parts["host"]) &&
			preg_match(
				'/tbn.*\.gstatic\.com/',
				$parts["host"]
			)
		){
			
			parse_str($parts["query"], $params);
			
			if(isset($params["q"])){
				
				return "https://" . $parts["host"] . "/images?q=" . $params["q"];
			}
		}
		
		return $url;
	}
}
