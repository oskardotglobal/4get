<?php

// @TODO check for consent.google.com page, if need be

class google{
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		$this->backend = new backend("google");
	}
	
	public function getfilters($page){
		
		$base = [
			"country" => [ // gl=<country> (image: cr=countryAF)
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
						"newer" => [ // tbs
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
						],
						"spellcheck" => [
							"display" => "Spellcheck",
							"option" => [
								"yes" => "Yes",
								"no" => "No"
							]
						]
					]
				);
				break;
			
			case "images":
				return array_merge(
					$base,
					[
						"time" => [ // tbs=qdr:<time>
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"d" => "Past 24 hours",
								"w" => "Past week",
								"m" => "Past month",
								"y" => "Past year"
							]
						],
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
						"ratio" => [ // imgar
							"display" => "Aspect ratio",
							"option" => [
								"any" => "Any ratio",
								"t|xt" => "Tall",
								"s" => "Square",
								"w" => "Wide",
								"xw" => "Panoramic"
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
						"type" => [ // tbs=itp:<type>
							"display" => "Type",
							"option" => [
								"any" => "Any type",
								"clipart" => "Clip Art",
								"lineart" => "Line Drawing",
								"animated" => "Animated"
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
						],
						"rights" => [ // tbs=sur:<rights>
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
						"newer" => [ // tbs
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
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
						"newer" => [ // tbs
							"display" => "Newer than",
							"option" => "_DATE"
						],
						"older" => [
							"display" => "Older than",
							"option" => "_DATE"
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
			"User-Agent: " . config::USER_AGENT,
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"DNT: 1",
			//"Cookie: SOCS=CAESNQgCEitib3FfaWRlbnRpdHlmcm9udGVuZHVpc2VydmVyXzIwMjQwMzE3LjA4X3AwGgJlbiAEGgYIgM7orwY",
			"Connection: keep-alive",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: none",
			"Sec-Fetch-User: ?1",
			"Priority: u=1",
			"TE: trailers"
		];
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER, $headers);
		
		// use http2
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		// follow redirects
		curl_setopt($curlproc, CURLOPT_FOLLOWLOCATION, true);

		$this->backend->assign_proxy($curlproc, $proxy);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	
	
	
	private function parsepage($html, $pagetype, $search, $proxy, $params){
		
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
		
		$this->fuckhtml->load($html);
		
		$this->detect_sorry();
		
		// parse all <style> tags
		$this->parsestyles();
		
		// get javascript images
		$this->scrape_dimg($html);
		
		// get html blobs
		preg_match_all(
			'/function\(\){window\.jsl\.dh\(\'([^\']+?)\',\'(.+?[^\'])\'\);/',
			$html,
			$blobs
		);
		
		$this->blobs = [];
		if(isset($blobs[1])){
			
			for($i=0; $i<count($blobs[1]); $i++){
				
				$this->blobs[$blobs[1][$i]] =
					$this->fuckhtml
					->parseJsString(
						$blobs[2][$i]
					);
			}
		}
		
		$this->scrape_imagearr($html);
		
		//
		// load result column
		//
		$result_div =
			$this->fuckhtml
			->getElementById(
				"center_col",
				"div"
			);
		
		if($result_div === false){
			
			throw new Exception("Failed to grep result div");
		}
		
		$this->fuckhtml->load($result_div);
		
		//
		// Get word corrections
		//
		$correction =
			$this->fuckhtml
			->getElementById(
				"fprs",
				"p"
			);
		
		if($correction){
			
			$this->fuckhtml->load($correction);
			
			$a =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
					
			$using =
				$this->fuckhtml
				->getElementById(
					"fprsl",
					$a
				);
			
			if($using){
				
				$using =
					$this->fuckhtml
					->getTextContent(
						$using
					);
				
				$spans =
					$this->fuckhtml
					->getElementsByTagName(
						"span"
					);
				
				$type_span =
					$this->fuckhtml
					->getTextContent(
						$spans[0]
					);
				
				$type = "not_many";
				
				if(
					stripos(
						$type_span,
						"Showing results for"
					) !== false
				){
					
					$type = "including";
				}
				
				$correction =
					$this->fuckhtml
					->getTextContent(
						$a[count($a) - 1]
					);
				
				$out["spelling"] = [
					"type" => $type,
					"using" => $using,
					"correction" => $correction
				];
			}
			
			// reset
			$this->fuckhtml->load($result_div);
		}else{
			
			// get the "Did you mean?" prompt
			$taw =
				$this->fuckhtml
				->getElementById(
					"taw"
				);
			
			if($taw){
				
				$this->fuckhtml->load($taw);
				
				$as =
					$this->fuckhtml
					->getElementsByTagName(
						"a"
					);
				
				if(count($as) !== 0){
					
					$text = 
						$this->fuckhtml
						->getTextContent(
							$as[0]
						);
					
					// @TODO implement did_you_mean
					$out["spelling"] = [
						"type" => "including",
						"using" => $search,
						"correction" => $text
					];
				}
			}
			
			$this->fuckhtml->load($result_div);
		}
		
		//
		// get notices
		//
		$botstuff =
			$this->fuckhtml
			->getElementById(
				"botstuff"
			);
		
		// important for later
		$last_page = false;
		
		if($botstuff){
			
			$this->fuckhtml->load($botstuff);
			
			$cards =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"line-height" => "normal"
						]
					),
					"div"
				);
			
			foreach($cards as $card){
				
				$this->fuckhtml->load($card);
				
				$h2 =
					$this->fuckhtml
					->getElementsByTagName(
						"h2"
					);
				
				if(count($h2) !== 0){
					
					$title =
						$this->fuckhtml
						->getTextContent(
							$h2[0]
						);
					
					$card["innerHTML"] =
						str_replace(
							$h2[0]["outerHTML"],
							"",
							$card["innerHTML"]
						);
				}else{
					
					$title = "Notice";
				}
				
				$div =
					$this->fuckhtml
					->getElementsByTagName(
						"div"
					);
				
				// probe for related searches div, if found, ignore it cause its shit
				$probe =
					$this->fuckhtml
					->getElementsByAttributeValue(
						"role",
						"list",
						$div
					);
				
				// also probe for children
				if(count($probe) === 0){
					
					$probe =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle(
								[
									"flex-shrink" => "0",
									"-moz-box-flex" => "0",
									"flex-grow" => "0",
									"overflow" => "hidden"
								]
							),
							$div
						);
				}
				
				if(count($probe) === 0){
					
					$description = [];
					
					$as =
						$this->fuckhtml
						->getElementsByTagName(
							"a"
						);
					
					if(count($as) !== 0){
						
						$first = true;
						
						foreach($as as $a){
							
							$text_link =
								$this->fuckhtml
								->getTextContent(
									$a
								);
							
							if(stripos($text_link, "repeat the search") !== false){
								
								$last_page = true;
								break 2;
							}
							
							$parts =
								explode(
									$a["outerHTML"],
									$card["innerHTML"],
									2
								);
							
							$card["innerHTML"] = $parts[1];
							
							$value =
								preg_replace(
									'/ +/',
									" ",
									$this->fuckhtml
									->getTextContent(
										$parts[0],
										false,
										false
									)
								);
							
							if(strlen(trim($value)) !== 0){
															
								$description[] = [
									"type" => "text",
									"value" => $value
								];
								
								if($first){
									
									$description[0]["value"] =
										ltrim($description[0]["value"]);
								}
							}
							
							$first = false;
							
							$description[] = [
								"type" => "link",
								"url" =>
									$this->fuckhtml
									->getTextContent(
										$a["attributes"]
										["href"]
									),
								"value" => $text_link
							];
						}
						
						$text =
							$this->fuckhtml
							->getTextContent(
								$card["innerHTML"],
								false,
								false
							);
						
						if(strlen(trim($text)) !== 0){
							
							$description[] = [
								"type" => "text",
								"value" =>
									rtrim(
										$text
									)
							];
						}
					}
					
					if(count($description) !== 0){
						
						$out["answer"][] = [
							"title" => $title,
							"description" => $description,
							"url" => null,
							"thumb" => null,
							"table" => [],
							"sublink" => []
						];
					}
				}
			}
			
			// reset
			$this->fuckhtml->load($html);
		}
		
		//
		// get "Related Searches" and "People also search for"
		//
		$relateds =
			$this->fuckhtml
			->getElementsByClassName(
				"wyccme",
				"div"
			);
		
		foreach($relateds as $related){
			
			$text =
				$this->fuckhtml
				->getTextContent(
					$related
				);
			
			if($text == "More results"){ continue; }
			
			$out["related"][] = $text;
		}
		
		//
		// Get text results
		//
		$results =
			$this->fuckhtml
			->getElementsByClassName(
				"g",
				"div"
			);
		
		$this->skip_next = false;
		
		foreach($results as $result){
			
			if($this->skip_next){
				
				$this->skip_next = false;
				continue;
			}
			
			$this->fuckhtml->load($result);
			
			$web = [
				"title" => null,
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
			
			// Detect presence of sublinks
			$g =
				$this->fuckhtml
				->getElementsByClassName(
					"g",
					"div"
				);
			
			$sublinks = [];
			if(count($g) > 0){
				
				$table =
					$this->fuckhtml
					->getElementsByTagName(
						"table"
					);
				
				if(count($table) !== 0){
					
					// found some sublinks!
					
					$this->fuckhtml->load($table[0]);
					
					$tds =
						$this->fuckhtml
						->getElementsByTagName(
							"td"
						);
					
					foreach($tds as $td){
						
						$this->fuckhtml->load($td);
						
						$a =
							$this->fuckhtml
							->getElementsByTagName(
								"a"
							);
						
						if(
							count($a) === 0 ||
							(
								isset($a[0]["attributes"]["class"]) &&
								$a[0]["attributes"]["class"] == "fl"
							)
						){
							
							continue;
						}
						
						$td["innerHTML"] =
							str_replace(
								$a[0]["outerHTML"],
								"",
								$td["innerHTML"]
							);
						
						$web["sublink"][] = [
							"title" =>
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$a[0]
									)
								),
							"description" =>
								html_entity_decode(
									$this->titledots(
										$this->fuckhtml
										->getTextContent(
											$td
										)
									)
								),
							"url" =>
								$this->unshiturl(
									$a[0]
									["attributes"]
									["href"]
								),
							"date" => null
						];
					}
					
					// reset
					$this->fuckhtml->load($result);
				}
								
				// skip on next iteration
				$this->skip_next = true;
			}
			
			// get title
			$h3 =
				$this->fuckhtml
				->getElementsByTagName(
					"h3"
				);
			
			if(count($h3) === 0){
				
				continue;
			}
			
			$web["title"] =
				$this->titledots(
					$this->fuckhtml
					->getTextContent(
						$h3[0]
					)
				);
			
			// get url
			$as =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			$web["url"] =
				$this->unshiturl(
					$as[0]
					["attributes"]
					["href"]
				);
			
			if(
				!preg_match(
					'/^http/',
					$web["url"]
				)
			){
				
				// skip if invalid url is found
				continue;
			}
			
			//
			// probe for twitter carousel
			//
			$carousel =
				$this->fuckhtml
				->getElementsByTagName(
					"g-scrolling-carousel"
				);
			
			if(count($carousel) !== 0){
				
				$this->fuckhtml->load($carousel[0]);
				
				$items =
					$this->fuckhtml
					->getElementsByTagName(
						"g-inner-card"
					);
				
				$has_thumbnail = false;
				
				foreach($items as $item){
					
					$this->fuckhtml->load($item);
					
					if($has_thumbnail === false){
						
						// get thumbnail
						$thumb =
							$this->fuckhtml
							->getElementsByTagName(
								"img"
							);
						
						if(
							count($thumb) !== 0 &&
							isset($thumb[0]["attributes"]["id"])
						){
							
							$web["thumb"] = [
								"url" =>
									$this->getdimg(
										$thumb[0]["attributes"]["id"]
									),
								"ratio" => "16:9"
							];
							
							$has_thumbnail = true;
						}
						
						// or else, try getting a thumbnail from next container
					}
					
					// cache div
					$div =
						$this->fuckhtml
						->getElementsByTagName(
							"div"
						);
					
					// get link
					$links =
						$this->fuckhtml
						->getElementsByTagName(
							"a"
						);
					
					// get description of carousel sublink
					$description =
						$this->fuckhtml
						->getElementsByAttributeValue(
							"role",
							"heading",
							$div
						);
					
					if(count($description) !== 0){
						
						$description =
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$description[0]
								)
							);
					}else{
						
						$description = null;
					}
					
					$bottom =
						$this->fuckhtml
						->getElementsByAttributeValue(
							"style",
							"z-index:2",
							$div
						);
					
					$title = null;
					$date = null;
					if(count($bottom) !== 0){
						
						$this->fuckhtml->load($bottom[0]);
						
						$spans =
							$this->fuckhtml
							->getElementsByTagName(
								"span"
							);
						
						$title =
							$this->fuckhtml
							->getTextContent(
								$spans[0]
							);
						
						$date =
							strtotime(
								$this->fuckhtml
								->getTextContent(
									$spans[count($spans) - 1]
								)
							);
					}
					
					$web["sublink"][] = [
						"title" => $title,
						"description" => $description,
						"url" =>
							$this->unshiturl(
								$links[0]
								["attributes"]
								["href"]
							),
						"date" => $date
					];
				}
				
				$out["web"][] = $web;
				continue;
			}
			
			//
			// get viewcount, time posted and follower count from <cite> tag
			//
			$cite =
				$this->fuckhtml
				->getElementsByTagName(
					"cite"
				);
			
			if(count($cite) !== 0){
				
				$this->fuckhtml->load($cite[0]);
				
				$spans =
					$this->fuckhtml
					->getElementsByTagName("span");
				
				if(count($spans) === 0){
					
					$cites =
						explode(
							"·",
							$this->fuckhtml
							->getTextContent(
								$cite[0]
							)
						);
					
					foreach($cites as $cite){
						
						$cite = trim($cite);
						
						if(
							preg_match(
								'/(.+) (views|followers|likes)$/',
								$cite,
								$match
							)
						){
							
							$web["table"][ucfirst($match[2])] =
								$match[1];
						}elseif(
							preg_match(
								'/ago$/',
								$cite
							)
						){
							
							$web["date"] =
								strtotime($cite);
						}
					}
				}
				
				// reset
				$this->fuckhtml->load($result);
			}
			
			//
			// attempt to fetch description cleanly
			//
			$description =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"style",
					"-webkit-line-clamp:2"
				);
			
			if(count($description) !== 0){
				
				$web["description"] =
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$description[0]
						)
					);
			}else{
				
				// use ANOTHER method where the description is a header of the result
				$description =
					$this->fuckhtml
					->getElementsByAttributeValue(
						"data-attrid",
						"wa:/description"
					);
				
				if(count($description) !== 0){
					
					// get date off that shit
					$date =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle(
								[
									"font-size" => "12px",
									"line-height" => "1.34",
									"display" => "inline-block",
									"font-family" => "google sans,arial,sans-serif",
									"padding-right" => "0",
									"white-space" => "nowrap"
								]
							),
							"span"
						);
					
					if(count($date) !== 0){
						
						$description[0]["innerHTML"] =
							str_replace(
								$date[0]["outerHTML"],
								"",
								$description[0]["innerHTML"]
							);
						
						$web["date"] =
							strtotime(
								$this->fuckhtml
								->getTextContent(
									$date[0]
								)
							);
					}
					
					$web["description"] =
						$this->fuckhtml
						->getTextContent(
							$description[0]
						);
				}else{
					
					// Yes.. You guessed it, use ANOTHER method to get descriptions
					// off youtube containers
					$description =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle(
								[
									"-webkit-box-orient" => "vertical",
									"display" => "-webkit-box",
									"font-size" => "14px",
									"-webkit-line-clamp" => "2",
									"line-height" => "22px",
									"overflow" => "hidden",
									"word-break" => "break-word",
									"color" => "#4d5156"
								]
							),
							"div"
						);
					
					if(count($description) !== 0){
						
						// check for video duration
						$duration =
							$this->fuckhtml
							->getElementsByClassName(
								$this->getstyle(
									[
										"background-color" => "rgba(0,0,0,0.6)",
										"color" => "#fff",
										"fill" => "#fff"
									]
								),
								"div"
							);
						
						if(count($duration) !== 0){
							
							$web["table"]["Duration"] =
								$this->fuckhtml
								->getTextContent(
									$duration[0]
								);
						}
						
						$web["description"] =
							$this->titledots(
								html_entity_decode(
									$this->fuckhtml
									->getTextContent(
										$description[0]
									)
								)
							);
						
						// get author + time posted
						$info =
							$this->fuckhtml
							->getElementsByClassName(
								$this->getstyle(
									[
										"color" => "var(" . $this->getcolorvar("#70757a") . ")",
										"font-size" => "14px",
										"line-height" => "20px",
										"margin-top" => "12px"
									]
								),
								"div"
							);
						
						if(count($info) !== 0){
							
							$info =
								explode(
									"·",
									$this->fuckhtml
									->getTextContent(
										$info[0]
									)
								);
							
							switch(count($info)){
								
								case 3:
									$web["table"]["Author"] = trim($info[1]);
									$web["date"] = strtotime(trim($info[2]));
									break;
								
								case 2:
									$web["date"] = strtotime(trim($info[1]));
									break;
							}
						}
					}
				}
			}
			
			//
			// get categories of content within the search result
			//
			$cats =
				$this->fuckhtml
				->getElementsByAttributeName(
					"data-sncf",
					"div"
				);
			
			foreach($cats as $cat){
				
				$this->fuckhtml->load($cat);
				
				// detect image category
				$images =
					$this->fuckhtml
					->getElementsByTagName(
						"img"
					);
				
				if(count($images) !== 0){
					
					foreach($images as $image){
						
						if(isset($image["attributes"]["id"])){
							// we found an image
							
							if(isset($image["attributes"]["width"])){
								
								$width = (int)$image["attributes"]["width"];
								
								if($width == 110){
									
									$ratio = "1:1";
								}elseif($width > 110){
									
									$ratio = "16:9";
								}else{
									
									$ratio = "9:16";
								}
							}else{
								
								$ratio = "1:1";
							}
							
							$web["thumb"] = [
								"url" => $this->getdimg($image["attributes"]["id"]),
								"ratio" => $ratio
							];
							
							continue 2;
						}
					}
				}
				
				// Detect rating
				$spans_unfiltered =
					$this->fuckhtml
					->getElementsByTagName(
						"span"
					);
				
				$spans =
					$this->fuckhtml
					->getElementsByAttributeName(
						"aria-label",
						$spans_unfiltered
					);
				
				foreach($spans as $span){
					
					if(
						preg_match(
							'/^Rated/',
							$span["attributes"]["aria-label"]
						)
					){
						
						// found rating
						// scrape rating
						preg_match(
							'/([0-9.]+).*([0-9.]+)/',
							$span["attributes"]["aria-label"],
							$rating
						);
						
						if(isset($rating[1])){
							
							$web["table"]["Rating"] =
								$rating[1] . "/" . $rating[2];
						}
						
						$has_seen_reviews = 0;
						foreach($spans_unfiltered as $span_unfiltered){
							
							if(
								preg_match(
									'/([0-9,.]+) +([A-z]+)$/',
									$this->fuckhtml
									->getTextContent(
										$span_unfiltered
									),
									$votes
								)
							){
								
								$has_seen_reviews++;
								$web["table"][ucfirst($votes[2])] = $votes[1];
								continue;
							}
							
							$text =
								$this->fuckhtml
								->getTextContent(
									$span_unfiltered
								);
							
							if(
								$text == "&nbsp;&nbsp;&nbsp;" ||
								$text == ""
							){
								
								break;
							}
							
							switch($has_seen_reviews){
								
								case 1:
									// scrape price
									$web["table"]["Price"] = $text;
									$has_seen_reviews++;
									break;
								
								case 2:
									// scrape platform
									$web["table"]["Platform"] = $text;
									$has_seen_reviews++;
									break;
								
								case 3:
									// Scrape type
									$web["table"]["Medium"] = $text;
									break;
							}
						}
						
						continue 2;
					}
				}
				
				// check if its a table of small sublinks
				$table =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle(
							[
								"display" => "table",
								"white-space" => "nowrap",
								"margin" => "5px 0",
								"line-height" => "1.58",
								"color" => "var(" . $this->getcolorvar("#70757a") . ")"
							]
						),
						"div"
					);
				
				if(count($table) !== 0){
					
					$this->fuckhtml->load($table[0]);
					
					$rows =
						$this->fuckhtml
						->getElementsByClassName(
							$this->getstyle(
								[
									"display" => "flex",
									"white-space" => "normal"
								]
							),
							"div"
						);
					
					foreach($rows as $row){
						
						$this->fuckhtml->load($row);
						
						$sublink = [
							"title" => null,
							"description" => null,
							"url" => null,
							"date" => null
						];
						
						$link =
							$this->fuckhtml
							->getElementsByTagName(
								"a"
							)[0];
						
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
						
						$row["innerHTML"] =
							str_replace(
								$link["outerHTML"],
								"",
								$row["innerHTML"]
							);
						
						$this->fuckhtml->load($row);
						
						$spans =
							$this->fuckhtml
							->getElementsByTagName(
								"span"
							);
						
						foreach($spans as $span){
							
							$text =
								$this->fuckhtml
								->getTextContent(
									$span
								);
							
							if(
								preg_match(
									'/answers?$/',
									$text
								)
							){
								
								$sublink["description"] =
									$text;
								
								continue;
							}
							
							$time = strtotime($text);
							
							if($time !== false){
								
								$sublink["date"] = $time;
							}
						}
						
						$web["sublink"][] = $sublink;
					}
					
					// reset
					$this->fuckhtml->load($cat);
					continue;
				}
				
				// check if its an answer header
				$answer_header =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle(
							[
								"overflow" => "hidden",
								"text-overflow" => "ellipsis"
							]
						),
						"span"
					);
				
				if(count($answer_header) !== 0){
					
					$link =
						$this->fuckhtml
						->getElementsByTagName(
							"a"
						);
					
					$cat["innerHTML"] =
						str_replace(
							$link[0]["outerHTML"],
							"",
							$cat["innerHTML"]
						);
					
					$web["sublink"][] = [
						"title" =>
							$this->fuckhtml
							->getTextContent(
								$link[0]
							),
						"description" =>
							$this->titledots(
								trim(
									str_replace(
										"\xc2\xa0",
										" ",
										html_entity_decode(
											$this->fuckhtml
											->getTextContent(
												$cat
											)
										)
									),
									" ·"
								)
							),
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$link[0]
								["attributes"]
								["href"]
							),
						"date" => null
					];
					
					continue;
				}
				
				// check if its list of small sublinks
				$urls =
					$this->fuckhtml
					->getElementsByTagName(
						"a"
					);
				
				if(count($urls) !== 0){
					
					// found small links
					foreach($urls as $url){
						
						$target =
							$this->fuckhtml
							->getTextContent(
								$url
								["attributes"]
								["href"]
							);
						
						if(
							!preg_match(
								'/^http/',
								$target
							)
						){
							
							continue;
						}
						
						$web["sublink"][] = [
							"title" =>
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$url
									)
								),
							"description" => null,
							"url" => $target,
							"date" => null
						];
					}
					
					continue;
				}
				
				// we probed everything, assume this is the description
				// if we didn't find one cleanly previously
				if($web["description"] === null){
					$web["description"] =
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$cat
							)
						);
				}
			}
			
			// check if description contains date
			$description = explode("—", $web["description"], 2);
			
			if(
				count($description) === 2 &&
				strlen($description[0]) <= 20
			){
				
				$date = strtotime($description[0]);
				
				if($date !== false){
					
					$web["date"] = $date;
					$web["description"] = ltrim($description[1]);
				}
			}
			
			// fetch youtube thumbnail
			$thumbnail =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"border-radius" => "8px",
							"height" => "fit-content",
							"justify-content" => "center",
							"margin-right" => "20px",
							"margin-top" => "4px",
							"position" => "relative",
							"width" => "fit-content"
						]
					),
					"div"
				);
			
			if(count($thumbnail) !== 0){
				
				// load thumbnail container
				$this->fuckhtml->load($thumbnail[0]);
				
				$image =
					$this->fuckhtml
					->getElementsByTagName(
						"img"
					);
				
				if(
					count($image) !== 0 &&
					isset($image[0]["attributes"]["id"])
				){
					
					$web["thumb"] =	[
						"url" =>
							$this->unshit_thumb(
								$this->getdimg(
									$image[0]["attributes"]["id"]
								)
							),
						"ratio" => "16:9"
					];
				}
				
				// reset
				$this->fuckhtml->load($result);
			}
			
			$out["web"][] = $web;
		}
		
		// reset
		$this->fuckhtml->load($result_div);
		
		//
		// Get instant answers
		//
		$answer_containers =
			$this->fuckhtml
			->getElementsByClassName(
				$this->getstyle(
					[
						"padding-left" => "0px",
						"padding-right" => "0px"
					]
				),
				"div"
			);
		
		$date_class =
			$this->getstyle(
				[
					"font-size" => "12px",
					"line-height" => "1.34",
					"display" => "inline-block",
					"font-family" => "google sans,arial,sans-serif",
					"padding-right" => "0",
					"white-space" => "nowrap"
				]
			);
		
		foreach($answer_containers as $container){
			
			$this->fuckhtml->load($container);
			
			$web = [
				"title" => null,
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
			
			$answers =
				$this->fuckhtml
				->getElementsByAttributeName(
					"aria-controls",
					"div"
				);
			
			$item_insert_pos = 1;
			foreach($answers as $answer){
				
				$out["related"][] =
					$this->fuckhtml
					->getTextContent(
						$answer
					);
				
				if(
					isset(
						$this->blobs[
							$answer
							["attributes"]
							["aria-controls"]
						]
					)
				){
					
					$this->fuckhtml->load(
						$this->blobs[
							$answer
							["attributes"]
							["aria-controls"]
						]
					);
					
					$divs =
						$this->fuckhtml
						->getElementsByAttributeName(
							"id",
							"div"
						);
					
					foreach($divs as $div){
						
						if(
							!isset(
								$this->blobs[
									$div
									["attributes"]
									["id"]
								]
							)
						){
							
							continue;
						}
						
						$this->fuckhtml->load(
							$this->blobs[
								$div
								["attributes"]
								["id"]
							]
						);
						
						// get url
						$as =
							$this->fuckhtml
							->getElementsByTagName(
								"a"
							);
						
						if(count($as) !== 0){
							
							$web["url"] =
								$this->unshiturl(
									$as[0]["attributes"]["href"]
								);
							
							// skip entries that redirect to a search
							if(
								!preg_match(
									'/^http/',
									$web["url"]
								)
							){
								
								continue 3;
							}
						}
						
						// get title
						$h3 =
							$this->fuckhtml
							->getElementsByTagName(
								"h3"
							);
						
						if(count($h3) !== 0){
							
							$web["title"] =
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$h3[0]
									)
								);
						}
						
						$description =
							$this->fuckhtml
							->getElementsByAttributeValue(
								"data-attrid",
								"wa:/description",
								"div"
							);
						
						if(count($description) !== 0){
							
							// check for date
							$this->fuckhtml->load($description[0]);
							
							$date =
								$this->fuckhtml
								->getElementsByClassName(
									$date_class,
									"span"
								);
							
							if(count($date) !== 0){
								
								$description[0]["innerHTML"] =
									str_replace(
										$date[0]["outerHTML"],
										"",
										$description[0]["innerHTML"]
									);
								
								$web["date"] =
									strtotime(
										$this->fuckhtml
										->getTextContent(
											$date[0]
										)
									);
							}
							
							$web["description"] =
								ltrim(
									$this->fuckhtml
									->getTextContent(
										$description[0]
									),
									": "
								);
						}
					}
					
					foreach($out["web"] as $item){
						
						if($item["url"] == $web["url"]){
							
							continue 2;
						}
					}
					
					array_splice($out["web"], $item_insert_pos, 0, [$web]);
					$item_insert_pos++;
				}
			}
		}
		
		// reset
		$this->fuckhtml->load($result_div);
		
		//
		// Scrape word definition
		//
		$definition_container =
			$this->fuckhtml
			->getElementsByClassName(
				"lr_container",
				"div"
			);
		
		if(count($definition_container) !== 0){
			
			$this->fuckhtml->load($definition_container[0]);
			
			// get header
			$header =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"data-attrid",
					"EntryHeader",
					"div"
				);
			
			if(count($header) !== 0){
				
				$description = [];
				
				$this->fuckhtml->load($header[0]);
				
				$title_div =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle(
							[
								"font-family" => "google sans,arial,sans-serif",
								"font-size" => "28px",
								"line-height" => "36px"
							]
						)
					);
				
				if(count($title_div) !== 0){
					
					$title =
						$this->fuckhtml
						->getTextContent(
							$title_div[0]
						);
				}else{
					
					$title = "Word definition";
				}
				
				$subtext_div =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle(
							[
								"font-family" => "arial,sans-serif",
								"font-size" => "14px",
								"line-height" => "22px"
							]
						),
						"span"
					);
				
				if(count($subtext_div) !== 0){
					
					$description[] = [
						"type" => "quote",
						"value" =>
							$this->fuckhtml
							->getTextContent(
								$subtext_div[0]
							)
					];
				}
				
				// get audio
				$audio =
					$this->fuckhtml
					->getElementsByTagName(
						"audio"
					);
				
				if(count($audio) !== 0){
					
					$this->fuckhtml->load($audio[0]);
					
					$source =
						$this->fuckhtml
						->getElementsByTagName(
							"source"
						);
					
					if(count($source) !== 0){
						
						$description[] = [
							"type" => "audio",
							"url" =>
								preg_replace(
									'/^\/\//',
									"https://",
									$this->fuckhtml
									->getTextContent(
										$source[0]
										["attributes"]
										["src"]
									)
								)
						];
					}
					
				}
				
				// remove header to avoid confusion
				$definition_container[0]["innerHTML"] =
					str_replace(
						$header[0]["outerHTML"],
						"",
						$definition_container[0]["innerHTML"]
					);
				
				// reset
				$this->fuckhtml->load($definition_container[0]);
				
				$vmods =
					$this->fuckhtml
					->getElementsByClassName(
						"vmod",
						"div"
					);
				
				foreach($vmods as $category){
					
					if(
						!isset(
							$category
							["attributes"]
							["data-topic"]
						) ||
						$category
						["attributes"]
						["class"] != "vmod"
					){
						
						continue;
					}
					
					$this->fuckhtml->load($category);
					
					// get category type
					$type =
						$this->fuckhtml
						->getElementsByTagName(
							"i"
						);
					
					if(count($type) !== 0){
						
						$description[] = [
							"type" => "title",
							"value" =>
								$this->fuckhtml
								->getTextContent(
									$type[0]
								)
						];
					}
					
					// get heading text
					$headings =
						$this->fuckhtml
						->getElementsByClassName(
							"xpdxpnd",
							"div"
						);
					
					foreach($headings as $heading){
						
						$description[] = [
							"type" => "quote",
							"value" =>
								$this->fuckhtml
								->getTextContent(
									$heading
								)
						];
					}
					
					$definitions =
						$this->fuckhtml
						->getElementsByAttributeValue(
							"data-attrid",
							"SenseDefinition",
							"div"
						);
					
					$i = 1;
					$text = [];
					
					foreach($definitions as $definition){
						
						$text[] =
							$i . ". " .
							$this->fuckhtml
							->getTextContent(
								$definition
							);
						
						$i++;
					}
					
					if(count($text) !== 0){
						
						$description[] = [
							"type" => "text",
							"value" =>
								implode("\n", $text)
						];
					}
				}
				
				$out["answer"][] = [
					"title" => $title,
					"description" => $description,
					"url" => null,
					"thumb" => null,
					"table" => [],
					"sublink" => []
				];
			}
			
			// reset
			$this->fuckhtml->load($result_div);
		}
		
		//
		// scrape elements with a g-section-with-header
		// includes: images, news carousels
		//
		
		$g_sections =
			$this->fuckhtml
			->getElementsByTagName(
				"g-section-with-header"
			);
		
		if(count($g_sections) !== 0){
			foreach($g_sections as $g_section){
				
				// parse elements with a g-section-with-header
				$this->fuckhtml->load($g_section);
				
				$div_title =
					$this->fuckhtml
					->getElementsByClassName(
						"a-no-hover-decoration",
						"a"
					);
				
				if(count($div_title) !== 0){
					
					// title detected, skip
					continue;
				}
					
				// no title detected: detect news container
				$news =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle(
							[
								"outline-offset" => "-1px",
								"outline-width" => "1px",
								"display" => "flex",
								"flex-direction" => "column",
								"flex-grow" => "1"
							]
						)
					);
				
				foreach($news as $new){
					
					$this->fuckhtml->load($new);
					
					$image =
						$this->fuckhtml
						->getElementsByAttributeName(
							"id",
							"img"
						);
					
					if(
						count($image) !== 0 &&
						!(
							isset($image[0]["attributes"]["style"]) &&
							strpos(
								$image[0]["attributes"]["style"],
								"height:18px"
							) !== false
						)
					){
						
						$thumb = [
							"url" =>
								$this->getdimg(
									$image[0]
									["attributes"]
									["id"]
								),
							"ratio" => "1:1"
						];
					}
					
					$title =
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$this->fuckhtml
								->getElementsByAttributeValue(
									"role",
									"heading",
									"div"
								)[0]
							)
						);
					
					$date_div =
						$this->fuckhtml
						->getElementsByAttributeName(
							"style",
							"div"
						);
					
					if(count($date_div) !== 0){
						
						foreach($date_div as $div){
							
							if(
								strpos(
									$div["attributes"]["style"],
									"bottom:"
								) !== false
							){
								$date =
									strtotime(
										$this->fuckhtml
										->getTextContent(
											$div
										)
									);
								
								break;
							}
						}
					}else{
						
						$date = null;
					}
					
					$out["news"][] = [
						"title" => $title,
						"description" => null,
						"date" => $date,
						"thumb" => $thumb,
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$new
								["attributes"]
								["href"]
							)
					];
				}
			}
			
			// reset
			$this->fuckhtml->load($result_div);
		}
		
		//
		// Parse images (carousel, left hand-side)
		//
		$image_carousels =
			$this->fuckhtml
			->getElementsByAttributeValue(
				"id",
				"media_result_group",
				"div"
			);
		
		if(count($image_carousels) !== 0){
			
			foreach($image_carousels as $image_carousel){
				
				$this->fuckhtml->load($image_carousel);
				
				// get related searches in image carousel
				$relateds =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle(
							[
								"display" => "inline-block",
								"margin-right" => "6px",
								"outline" => "none",
								"padding" => "6px 0"
							],
							"a"
						)
					);
				
				foreach($relateds as $related){
					
					if(!isset($related["innerHTML"])){
						
						// found an image
						continue;
					}
					
					$text =
						$this->fuckhtml
						->getTextContent(
							$related
						);
					
					if($text != ""){
						
						$out["related"][] = $text;
					}
				}
				
				$div =
					$this->fuckhtml
					->getElementsByTagName(
						"div"
					);
				
				// get loaded images
				$images =
					$this->fuckhtml
					->getElementsByClassName(
						"ivg-i",
						$div
					);
				
				foreach($images as $image){
					
					$this->fuckhtml->load($image);
					
					$img_tags =
						$this->fuckhtml
						->getElementsByTagName(
							"img"
						);
					
					if(
						!isset($image["attributes"]["data-docid"]) ||
						!isset($this->image_arr[$image["attributes"]["data-docid"]])
					){
						
						continue;
					}
					
					// search for the right image tag
					$image_tag = false;
					foreach($img_tags as $img){
						
						if(
							isset(
								$img
								["attributes"]
								["alt"]
							) &&
							trim(
								$img
								["attributes"]
								["alt"]
							) != ""
						){
							
							$image_tag = $img;
							break;
						}
					}
					
					if($image_tag === false){
						
						continue;
					}
					
					$out["image"][] = [
						"title" =>
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$image_tag
									["attributes"]
									["alt"]
								)
							),
						"source" =>
							$this->image_arr[
								$image
								["attributes"]
								["data-docid"]
							],
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$image
								["attributes"]
								["data-lpage"]
							)
					];
				}
				
				// get unloaded javascript images
				$images_js_sel =
					$this->fuckhtml
					->getElementsByAttributeName(
						"id",
						$div
					);
				
				$loaded = [];
				
				foreach($images_js_sel as $sel){
					
					if(
						!isset($this->blobs[$sel["attributes"]["id"]]) ||
						in_array((string)$sel["attributes"]["id"], $loaded, true)
					){
						
						// not an unloaded javascript image
						continue;
					}
					
					$loaded[] = $sel["attributes"]["id"];
					
					// get yet another javascript component
					$this->fuckhtml->load($this->blobs[$sel["attributes"]["id"]]);
					
					// get js node: contains title & url
					$js_node =
						$this->fuckhtml
						->getElementsByTagName(
							"div"
						)[0];
					
					if(!isset($this->blobs[$js_node["attributes"]["id"]])){
						
						// did not find refer id
						continue;
					}
					
					// load second javascript component
					$this->fuckhtml->load($this->blobs[$js_node["attributes"]["id"]]);
					
					// get title from image alt text.
					// data-src from this image is cropped, ignore it..
					$img =
						$this->fuckhtml
						->getElementsByTagName(
							"img"
						)[0];
					
					$out["image"][] = [
						"title" =>
							$this->fuckhtml
							->getTextContent(
								$img["attributes"]["alt"]
							),
						"source" =>
							$this->image_arr[
								$js_node["attributes"]["data-docid"]
							],
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$js_node["attributes"]["data-lpage"]
							)
					];
				}
			}
			
			// reset
			$this->fuckhtml->load($result_div);
		}
		
		//
		// Parse videos
		//
		$this->fuckhtml->load($result_div);
		
		$videos =
			$this->fuckhtml
			->getElementsByAttributeName(
				"data-vid",
				"div"
			);
		
		foreach($videos as $video){
			
			$this->fuckhtml->load($video);
			
			// get url
			$url =
				$this->fuckhtml
				->getTextContent(
					$video
					["attributes"]
					["data-surl"]
				);
			
			foreach($out["web"] as $link){
				
				if($link["url"] == $url){
					
					// ignore if we already have the video in $out["web"]
					continue 2;
				}
			}
			
			// get heading element
			$heading =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"role",
					"heading",
					"div"
				);
			
			if(count($heading) === 0){
				
				// no heading, fuck this.
				continue;
			}
			
			// get thumbnail before loading heading object
			$image =
				$this->fuckhtml
				->getElementsByAttributeName(
					"id",
					"img"
				);
			
			if(count($image) !== 0){
				
				$thumb = [
					"url" => $this->getdimg($image[0]["attributes"]["id"]),
					"ratio" => "16:9"
				];
			}else{
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}
			
			// get duration
			$duration_div =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"border-radius" => "10px",
							"font-family" => "arial,sans-serif-medium,sans-serif",
							"font-size" => "12px",
							"line-height" => "16px",
							"padding-block" => "2px",
							"padding-inline" => "8px"
						]
					),
					"div"
				);
			
			if(count($duration_div) !== 0){
				
				$duration =
					$this->hms2int(
						$this->fuckhtml
						->getTextContent(
							$duration_div[0]
						)
					);
			}else{
				
				// check if its a livestream
				$duration =
					$this->fuckhtml
					->getElementsByClassName(
						$this->getstyle(
							[
								"background-color" => "#d93025",
								"border-radius" => "10px",
								"color" => "#fff",
								"font-family" => "arial,sans-serif-medium,sans-serif",
								"font-size" => "12px",
								"line-height" => "16px",
								"padding-block" => "2px",
								"padding-inline" => "8px"
							]
						),
						"span"
					);
				
				if(count($duration) !== 0){
					
					$duration = "_LIVE";
				}else{
					
					$duration = null;
				}
			}
			
			// load heading
			$this->fuckhtml->load($heading[0]);
			
			// get title
			$title =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"font-family" => "arial,sans-serif",
							"font-size" => "16px",
							"font-weight" => "400",
							"line-height" => "24px"
						]
					),
					"div"
				);
			
			if(count($title) === 0){
				
				// ?? no title
				continue;
			}
			
			$title =
				$this->titledots(
					$this->fuckhtml
					->getTextContent(
						$title[0]
					)
				);
			
			// get date
			$date_div =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"color" => "var(" . $this->getcolorvar("#70757a") . ")",
							"font-size" => "14px"
						]
					),
					"div"
				);
			
			if(count($date_div) !== 0){
				
				$date = strtotime(
					$this->fuckhtml
					->getTextContent(
						$date_div[0]
					)
				);
				
				if($date === false){
					
					// failed to parse date
					$date = null;
				}
			}else{
				
				$date = null;
			}
			
			$out["video"][] = [
				"title" => $title,
				"description" => null,
				"date" => $date,
				"duration" => $duration,
				"views" => null,
				"thumb" => $thumb,
				"url" => $url
			];
		}
		
		//
		// Parse featured results (which contain images, fuck the rest desu)
		//
		$this->fuckhtml->load($html);
		$top =
			$this->fuckhtml
			->getElementsByAttributeValue(
				"aria-label",
				"Featured results",
				"div"
			);
		
		if(count($top) !== 0){
			
			$this->fuckhtml->load($top[0]);
			
			// get images
			$grid =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"border-radius" => "20px",
							"display" => "grid",
							"grid-gap" => "2px",
							"grid-template-rows" => "repeat(2,minmax(0,1fr))",
							"overflow" => "hidden",
							"bottom" => "0",
							"left" => "0",
							"right" => "0",
							"top" => "0",
							"position" => "absolute",
						]
					),
					"div"
				);
			
			if(count($grid) !== 0){
				
				// we found image grid
				$this->fuckhtml->load($grid[0]);
				
				$images_div =
					$this->fuckhtml
					->getElementsByAttributeName(
						"data-attrid",
						"div"
					);
				
				foreach($images_div as $image_div){
					
					$this->fuckhtml->load($image_div);
					
					$image =
						$this->fuckhtml
						->getElementsByTagName(
							"img"
						);
					
					if(
						count($image) === 0 ||
						!isset($image_div["attributes"]["data-docid"]) ||
						!isset($this->image_arr[$image_div["attributes"]["data-docid"]])
					){
						
						// ?? no image, continue
						continue;
					}
					
					$out["image"][] = [
						"title" =>
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$image[0]["attributes"]["alt"]
								)
							),
						"source" =>
							$this->image_arr[
								$image_div["attributes"]["data-docid"]
							],
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$image_div["attributes"]["data-lpage"]
							)
					];
				}
			}
		}
		
		
		//
		// craft $npt token
		//
		if(
			$last_page === false &&
			count($out["web"]) !== 0
		){
			if(!isset($params["start"])){
				
				$params["start"] = 20;
			}else{
				
				$params["start"] += 20;
			}
			
			$out["npt"] =
				$this->backend
				->store(
					json_encode($params),
					$pagetype,
					$proxy
				);
		}
		
		
		//
		// Parse right handside
		//
		$this->fuckhtml->load($html);
		
		$rhs =
			$this->fuckhtml
			->getElementById(
				"rhs"
			);
		
		if($rhs === null){
			
			return $out;
		}
		
		$this->fuckhtml->load($rhs);
		
		// get images gallery
		$image_gallery =
			$this->fuckhtml
			->getElementsByAttributeValue(
				"data-rc",
				"ivg-i",
				"div"
			);
		
		if(count($image_gallery) !== 0){
			
			$this->fuckhtml->load($image_gallery[0]);
			
			// get images
			$images_div =
				$this->fuckhtml
				->getElementsByClassName(
					"ivg-i",
					"div"
				);
			
			foreach($images_div as $image_div){
				
				$this->fuckhtml->load($image_div);
				
				$image =
					$this->fuckhtml
					->getElementsByTagName(
						"img"
					);
				
				if(
					count($image) === 0 ||
					!isset(
						$this->image_arr[
							$image_div
							["attributes"]
							["data-docid"]
						]
					)
				){
					
					continue;
				}
				
				foreach($out["image"] as $existing_image){
					
					// might already exist
					if(
						$existing_image["source"][1]["url"] ==
						$this->image_arr[
							$image_div
							["attributes"]
							["data-docid"]
						][1]["url"]
					){
						
						continue 2;
					}
				}
				
				$out["image"][] = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$image[0]
								["attributes"]
								["alt"]
							)
						),
					"source" =>
						$this->image_arr[
							$image_div
							["attributes"]
							["data-docid"]
						],
					"url" =>
						$this->fuckhtml
						->getTextContent(
							$image_div
							["attributes"]
							["data-lpage"]
						)
				];
			}
			
			// reset
			$this->fuckhtml->load($rhs);
		}
		
		// get header container
		$header =
			$this->fuckhtml
			->getElementsByClassName(
				$this->getstyle(
					[
						"padding" => "0 0 16px 20px",
						"display" => "flex"
					]
				),
				"div"
			);
		
		// stop parsing wikipedia heads if there isn't a header
		$description = [];
		$title = "About";
		
		if(count($header) !== 0){
			
			$this->fuckhtml->load($header[0]);
			
			// g-snackbar-action present: we found a button instead
			if(
				count(
					$this->fuckhtml
					->getElementsByTagName(
						"g-snackbar-action"
					)
				) !== 0
			){
				
				$title_tag =
					$this->fuckhtml
					->getElementsByAttributeValue(
						"data-attrid",
						"title",
						"div"
					);
				
				if(count($title_tag) !== 0){
					$title =
						$this->fuckhtml
						->getTextContent(
							$title_tag[0]
						);
					
					$header[0]["innerHTML"] =
						str_replace(
							$title_tag[0]["outerHTML"],
							"",
							$header[0]["innerHTML"]
						);
					
					// if header still contains text, add it as a subtitle in description
					$subtitle =
						$this->fuckhtml
						->getTextContent(
							$header[0]
						);
					
					if(strlen($subtitle) !== 0){
						
						$description[] = [
							"type" => "quote",
							"value" => $subtitle
						];
					}
				}
			}
			
			// reset
			$this->fuckhtml->load($rhs);
		}
		
		// get description elements
		$url = null;
		
		$text =
			$this->fuckhtml
			->getElementsByAttributeValue(
				"data-attrid",
				"description",
				"div"
			);
		
		if(count($text) !== 0){
			
			$this->fuckhtml->load($text[0]);
			
			$a =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($a) !== 0){
				// get link and remove it from description
				
				$a = $a[count($a) - 1];
				
				$text[0]["innerHTML"] =
					str_replace(
						$a["outerHTML"],
						"",
						$text[0]["innerHTML"]
					);
				
				$url =
					$this->fuckhtml
					->getTextContent(
						$a
						["attributes"]
						["href"]
					);
			}
			
			$description[] = [
				"type" => "text",
				"value" =>
					html_entity_decode(
						preg_replace(
							'/^Description/',
							"",
							$this->fuckhtml
							->getTextContent(
								$text[0]
							)
						)
					)
			];
			
			// reset
			$this->fuckhtml->load($rhs);
		}
		
		// get reviews (google play, steam, etc)
		$review_container =
			$this->fuckhtml
			->getElementsByClassName(
				$this->getstyle(
					[
						"align-items" => "start",
						"display" => "flex"
					]
				),
				"div"
			);
		
		if(count($review_container) !== 0){
			
			$this->fuckhtml->load($review_container[0]);
			
			$as =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($as) !== 0){
				
				$description[] = [
					"type" => "title",
					"value" => "Ratings"
				];
				
				foreach($as as $a){
					
					$this->fuckhtml->load($a);
					
					$spans =
						$this->fuckhtml
						->getElementsByTagName(
							"span"
						);
					
					if(count($spans) >= 2){
						
						$value =
							trim(
								$this->fuckhtml
								->getTextContent(
									$spans[1]
								),
								"· "
							);
						
						if(
							$value == "" &&
							isset($spans[2])
						){
							
							$value =
								$this->fuckhtml
								->getTextContent(
									$spans[2]
								);
						}
						
						$description[] = [
							"type" => "link",
							"url" =>
								$this->fuckhtml
								->getTextContent(
									$a["attributes"]
									["href"]
								),
							"value" => $value
						];
						
						$description[] = [
							"type" => "text",
							"value" =>
								": " .
								$this->fuckhtml
								->getTextContent(
									$spans[0]
								) . "\n"
						];
					}
				}
			}
			
			// reset
			$this->fuckhtml->load($rhs);
		}
		
		// initialize sublinks
		$sublinks = [];
		
		// get description from business
		if(count($description) === 0){
			
			$data_attrid =
				$this->fuckhtml
				->getElementsByAttributeName(
					"data-attrid"
				);
			
			$summary =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"data-attrid",
					"kc:/local:one line summary",
					$data_attrid
				);
			
			if(count($summary) !== 0){
				
				$description[] = [
					"type" => "quote",
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$summary[0]
						)
				];
				
				// remove summary so it doesnt get parsed as a table
				$rhs["innerHTML"] =
					str_replace(
						$summary[0]["outerHTML"],
						"",
						$rhs["innerHTML"]
					);
				
				$this->fuckhtml->load($rhs);
			}
			
			$address =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"data-attrid",
					"kc:/location/location:address",
					$data_attrid
				);
			
			if(count($address) !== 0){
				
				$description[] = [
					"type" => "text",
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$address[0]
						)
				];
			}
			
			// get title
			$title_div =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"data-attrid",
					"title",
					$data_attrid
				);
			
			if(count($title_div) !== 0){
				
				$title =
					$this->fuckhtml
					->getTextContent(
						$title_div[0]
					);
			}
				
			// get phone number
			$phone =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"data-attrid",
					"kc:/local:alt phone",
					$data_attrid
				);
			
			if(count($phone) !== 0){
				
				$this->fuckhtml->load($phone[0]);
				
				$sublinks["Call"] =
					"tel:" .
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByAttributeName(
							"aria-label",
							"span"
						)[0]
					);
				
				$this->fuckhtml->load($rhs);
			}
		}
		
		if(count($description) === 0){
			
			// still no description? abort
			return $out;
		}
		
		// get table elements
		$table = [];
		$table_elems =
			$this->fuckhtml
			->getElementsByClassName(
				$this->getstyle(
					[
						"margin-top" => "7px"
					]
				),
				"div"
			);
		
		foreach($table_elems as $elem){
			
			$this->fuckhtml->load($elem);
			
			$spans =
				$this->fuckhtml
				->getElementsByTagName(
					"span"
				);
			
			if(count($spans) === 0){
				
				// ?? invalid
				continue;
			}
			
			$elem["innerHTML"] =
				str_replace(
					$spans[0]["outerHTML"],
					"",
					$elem["innerHTML"]
				);
			
			$key =
				rtrim(
					$this->fuckhtml
					->getTextContent(
						$spans[0]
					),
					": "
				);
			
			if(
				$key == "" ||
				$key == "Phone"
			){
				
				continue;
			}
			
			if($key == "Hours"){
				
				$hours = [];
				
				$this->fuckhtml->load($elem);
				
				$trs =
					$this->fuckhtml
					->getElementsByTagName(
						"tr"
					);
				
				foreach($trs as $tr){
					
					$this->fuckhtml->load($tr);
					
					$tds =
						$this->fuckhtml
						->getElementsByTagName(
							"td"
						);
					
					if(count($tds) === 2){
						
						$hours[] =
							$this->fuckhtml
							->getTextContent(
								$tds[0]
							) . ": " .
							$this->fuckhtml
							->getTextContent(
								$tds[1]
							);
					}
				}
				
				if(count($hours) !== 0){
					
					$hours = implode("\n", $hours);
					$table["Hours"] = $hours;
				}
				
				continue;
			}
			
			$table[$key] =
				preg_replace(
					'/ +/',
					" ",
					$this->fuckhtml
					->getTextContent(
						$elem
					)
				);
		}
		
		// reset
		$this->fuckhtml->load($rhs);
		
		// get the website div
		$as =
			$this->fuckhtml
			->getElementsByAttributeValue(
				"data-attrid",
				"visit_official_site",
				"a"
			);
		
		if(count($as) !== 0){
			
			$sublinks["Website"] =
				str_replace(
					"http://",
					"https://",
					$this->fuckhtml
					->getTextContent(
						$as[0]
						["attributes"]
						["href"]
					)
				);
		}else{
			
			// get website through button
			$button =
				$this->fuckhtml
				->getElementsByClassName(
					"ab_button",
					"a"
				);
			
			if(count($button) !== 0){
				
				$sublinks["Website"] =
					$this->unshiturl(
						$this->fuckhtml
						->getTextContent(
							$button[0]
							["attributes"]
							["href"]
						)
					);
			}
		}
		
		// get social media links
		$as =
			$this->fuckhtml
			->getElementsByTagName(
				"g-link"
			);
		
		foreach($as as $a){
			
			$this->fuckhtml->load($a);
			
			$link =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($link) === 0){
				
				continue;
			}
			
			$sublink_title =
				$this->fuckhtml
				->getTextContent(
					$a
				);
			
			if($sublink_title == "X (Twitter)"){
				
				$sublink_title = "Twitter";
			}
			
			$sublinks[$sublink_title] =
				$this->fuckhtml
				->getTextContent(
					$link[0]
					["attributes"]
					["href"]
				);
		}
		
		// reset
		$this->fuckhtml->load($rhs);
		
		// get those round containers
		$containers =
			$this->fuckhtml
			->getElementsByClassName(
				"tpa-ci"
			);
		
		foreach($containers as $container){
			
			$this->fuckhtml->load($container);
			
			$as =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($as) === 0){
				
				continue;
			}
			
			$sublinks[
				$this->fuckhtml
				->getTextContent(
					$as[0]
				)
			] =
				$this->fuckhtml
				->getTextContent(
					$as[0]
					["attributes"]
					["href"]
				);
		}
		
		$out["answer"][] = [
			"title" => $title,
			"description" => $description,
			"url" => $url,
			"thumb" => null,
			"table" => $table,
			"sublink" => $sublinks
		];
		
		return $out;
	}
	
	
	private function scrape_dimg($html){
		
		// get images loaded through javascript
		$this->dimg = [];
		
		preg_match_all(
			'/function\(\){google\.ldi=({.*?});/',
			$html,
			$dimg
		);
		
		if(isset($dimg[1])){
			
			foreach($dimg[1] as $i){
				
				$tmp = json_decode($i, true);
				foreach($tmp as $key => $value){
					
					$this->dimg[$key] =
						$this->unshit_thumb(
							$value
						);
				}
			}
		}
		
		// get additional javascript base64 images
		preg_match_all(
			'/var s=\'(data:image\/[^\']+)\';var ii=\[((?:\'[^\']+\',?)+)\];/',
			$html,
			$dimg
		);
		
		if(isset($dimg[1])){
			
			for($i=0; $i<count($dimg[1]); $i++){
				
				$delims = explode(",", $dimg[2][$i]);
				$string =
					$this->fuckhtml
					->parseJsString(
						$dimg[1][$i]
					);
				
				foreach($delims as $delim){
					
					$this->dimg[trim($delim, "'")] = $string;
				}
			}
		}
	}
	
	
	private function scrape_imagearr($html){
		// get image links arrays
		preg_match_all(
			'/\[0,"([^"]+)",\["([^"]+)\",([0-9]+),([0-9]+)\],\["([^"]+)",([0-9]+),([0-9]+)\]/',
			$html,
			$image_arr
		);
		
		$this->image_arr = [];
		if(isset($image_arr[1])){
			
			for($i=0; $i<count($image_arr[1]); $i++){
				
				$this->image_arr[$image_arr[1][$i]] =
					[
						[
							"url" =>
								$this->fuckhtml
								->parseJsString(
									$image_arr[5][$i]
								),
							"width" => (int)$image_arr[7][$i],
							"height" => (int)$image_arr[6][$i]
						],
						[
							"url" =>
								$this->unshit_thumb(
									$this->fuckhtml
									->parseJsString(
										$image_arr[2][$i]
									)
								),
							"width" => (int)$image_arr[4][$i],
							"height" => (int)$image_arr[3][$i]
						]
					];
			}
		}
	}
	
	
	private function getdimg($dimg){
		
		return isset($this->dimg[$dimg]) ? $this->dimg[$dimg] : null;
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
	
	
	private function parsestyles(){
		
		$styles = [];

		$style_div =
			$this->fuckhtml
			->getElementsByTagName(
				"style"
			);
		
		$raw_styles = "";
		
		foreach($style_div as $style){
			
			$raw_styles .= $style["innerHTML"];
		}
		
		// filter out media/keyframe queries
		$raw_styles =
			preg_replace(
				'/@\s*(?!font-face)[^{]+\s*{[\S\s]+?}\s*}/',
				"",
				$raw_styles
			);
		
		// get styles
		preg_match_all(
			'/(.+?){([\S\s]*?)}/',
			$raw_styles,
			$matches
		);
		
		for($i=0; $i<count($matches[1]); $i++){
			
			// get style values
			preg_match_all(
				'/([^:;]+):([^;]*?(?:\([^)]+\)[^;]*?)?)(?:;|$)/',
				$matches[2][$i],
				$values_regex
			);
			
			$values = [];
			for($k=0; $k<count($values_regex[1]); $k++){
				
				$values[trim($values_regex[1][$k])] =
					strtolower(trim($values_regex[2][$k]));
			}
			
			$names = explode(",", $matches[1][$i]);
			
			// h1,h2,h3 will each get their own array index
			foreach($names as $name){
				
				$name = trim($name, "}\t\n\r\0\x0B");
				
				foreach($values as $key => $value){
					
					$styles[$name][$key] = $value;
				}
			}
		}
		
		foreach($styles as $key => $values){
			
			$styles[$key]["_c"] = count($values);
		}
		
		$this->styles = $styles;
		
		// get CSS colors
		$this->css_colors = [];
		
		if(isset($this->styles[":root"])){
			
			foreach($this->styles[":root"] as $key => $value){
				
				$this->css_colors[$value] = strtolower($key);
			}
		}
	}
	
	
	
	private function getstyle($styles){
		
		$styles["_c"] = count($styles);
		
		foreach($this->styles as $style_key => $style_values){
			
			if(count(array_intersect_assoc($style_values, $styles)) === $styles["_c"] + 1){
				
				$style_key =
					explode(" ", $style_key);
				
				$style_key = $style_key[count($style_key) - 1];
				
				return
					ltrim(
						str_replace(
							[".", "#"],
							" ",
							$style_key
						)
					);
			}
		}
		
		return false;
	}
	
	
	
	private function getcolorvar($color){
		
		if(isset($this->css_colors[$color])){
			
			return $this->css_colors[$color];
		}
		
		return null;
	}
	
	
	
	public function web($get){
		
		if($get["npt"]){
			
			[$params, $proxy] = $this->backend->get($get["npt"], "web");
			$params = json_decode($params, true);
			
			$search = $params["q"];
			
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$lang = $get["lang"];
			$older = $get["older"];
			$newer = $get["newer"];
			$spellcheck = $get["spellcheck"];
			$proxy = $this->backend->get_ip();
			
			$offset = 0;
			
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
			
			// generate tbs
			$tbs = [];
			
			// get date
			$older = $older === false ? null : date("m/d/Y", $older);
			$newer = $newer === false ? null : date("m/d/Y", $newer);
			
			if(
				$older !== null ||
				$newer !== null
			){
				
				$tbs["cdr"] = "1";
				$tbs["cd_min"] = $newer;
				$tbs["cd_max"] = $older;
			}
			
			// spellcheck filter
			if($spellcheck == "no"){
				
				$params["nfpr"] = "1";
			}
			
			if(count($tbs) !== 0){
				
				$params["tbs"] = "";
				
				foreach($tbs as $key => $value){
					
					$params["tbs"] .= $key . ":" . $value . ",";
				}
				
				$params["tbs"] = rtrim($params["tbs"], ",");
			}
		}
		
		try{
			$html =
				$this->get(
					$proxy,
					"https://www.google.com/search",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get HTML");
		}
		
		//$html = file_get_contents("scraper/google.html");
		
		return $this->parsepage($html, "web", $search, $proxy, $params);
	}
	
	
	
	public function video($get){
		
		if($get["npt"]){
			
			[$params, $proxy] = $this->backend->get($get["npt"], "video");
			$params = json_decode($params, true);
			
			$search = $params["q"];
			
		}else{
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$older = $get["older"];
			$newer = $get["newer"];
			$duration = $get["duration"];
			$quality = $get["quality"];
			$captions = $get["captions"];
			$proxy = $this->backend->get_ip();
			
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
			
			$tbs = [];
			
			// get date
			$older = $older === false ? null : date("m/d/Y", $older);
			$newer = $newer === false ? null : date("m/d/Y", $newer);
			
			if(
				$older !== null ||
				$newer !== null
			){
				
				$tbs["cdr"] = "1";
				$tbs["cd_min"] = $newer;
				$tbs["cd_max"] = $older;
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
		}
		
		try{
			$html =
				$this->get(
					$proxy,
					"https://www.google.com/search",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get HTML");
		}
		
		//$html = file_get_contents("scraper/google.html");
		
		$response = $this->parsepage($html, "videos", $search, $proxy, $params);
		$out = [
			"status" => "ok",
			"npt" => $response["npt"],
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		foreach($response["web"] as $result){
			
			$out["video"][] = [
				"title" => $result["title"],
				"description" => $result["description"],
				"author" => [
					"name" => isset($result["table"]["Author"]) ? $result["table"]["Author"] : null,
					"url" => null,
					"avatar" => null
				],
				"date" => $result["date"],
				"duration" => isset($result["table"]["Duration"]) ? $this->hms2int($result["table"]["Duration"]) : null,
				"views" => null,
				"thumb" => $result["thumb"],
				"url" => $result["url"]
			];
		}
		
		return $out;
	}
	
	
	
	public function news($get){
		
		if($get["npt"]){
			
			[$req, $proxy] = $this->backend->get($get["npt"], "news");
			/*parse_str(
				parse_url($req, PHP_URL_QUERY),
				$search
			);*/
			
			try{
				
				$html =
					$this->get(
						$proxy,
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
			$older = $get["older"];
			$newer = $get["newer"];
			$sort = $get["sort"];
			$proxy = $this->backend->get_ip();
			
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
			
			$tbs = [];
			
			// get date
			$older = $older === false ? null : date("m/d/Y", $older);
			$newer = $newer === false ? null : date("m/d/Y", $newer);
			
			if(
				$older !== null ||
				$newer !== null
			){
				
				$tbs["cdr"] = "1";
				$tbs["cd_min"] = $newer;
				$tbs["cd_max"] = $older;
			}
			
			// relevance
			if($sort == "date"){
				
				$tbs["sbd"] = "1";
			}
					
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] = "";
				
				foreach($tbs as $key => $value){
					
					$params["tbs"] .= $key . ":" . $value . ",";
				}
				
				$params["tbs"] = rtrim($params["tbs"], ",");
			}
			
			//$html = file_get_contents("scraper/google-news.html");
			
			$html =
				$this->get(
					$proxy,
					"https://www.google.com/search",
					$params
				);
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		$this->fuckhtml->load($html);
		
		$this->detect_sorry();
		
		// get images
		$this->scrape_dimg($html);
		
		// parse styles
		$this->parsestyles();
		
		$center_col =
			$this->fuckhtml
			->getElementById(
				"center_col",
				"div"
			);
		
		if($center_col === null){
			
			throw new Exception("Could not grep result div");
		}
		
		$this->fuckhtml->load($center_col);
		
		// get next page
		$npt =
			$this->fuckhtml
			->getElementById(
				"pnnext",
				"a"
			);
		
		if($npt !== false){
			
			$out["npt"] =
				$this->backend->store(
					$this->fuckhtml
					->getTextContent(
						$npt["attributes"]
						["href"]
					),
					"news",
					$proxy
				);
		}
		
		$as =
			$this->fuckhtml
			->getElementsByAttributeName(
				"jsname",
				"a"
			);
		
		foreach($as as $a){
			
			$this->fuckhtml->load($a);
			
			// get title
			$title =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"role",
					"heading",
					"div"
				);
			
			if(count($title) === 0){
				
				continue;
			}
			
			$title =
				$this->titledots(
					$this->fuckhtml
					->getTextContent(
						$title[0]
					)
				);
			
			// get thumbnail
			$image =
				$this->fuckhtml
				->getElementsByAttributeName(
					"id",
					"img"
				);
			
			// check for padded title node, if found, we're inside a carousel
			$probe =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"padding" => "16px 16px 40px 16px"
						]
					),
					"div"
				);
			
			if(count($probe) !== 0){
				
				$probe = true;
			}else{
				
				$probe = false;
			}
			
			if(
				count($image) !== 0 &&
				!isset($image[0]["attributes"]["width"])
			){
				
				$thumb = [
					"url" =>
						$this->getdimg(
							$image[0]["attributes"]["id"]
						),
					"ratio" => $probe === true ? "16:9" : "1:1"
				];
			}else{
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}
			
			$description = null;
			
			if($probe === false){
				
				$desc_divs =
					$this->fuckhtml
					->getElementsByAttributeName(
						"style",
						"div"
					);
				
				foreach($desc_divs as $desc){
					
					if(
						strpos(
							$desc["attributes"]["style"],
							"margin-top:"
						) !== false
					){
						
						$description =
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$desc
								)
							);
						break;
					}
				}
			}
			
			// get author
			$author =
				$this->fuckhtml
				->getElementsByClassName(
					$this->getstyle(
						[
							"overflow" => "hidden",
							"text-align" => "left",
							"text-overflow" => "ellipsis",
							"white-space" => "nowrap",
							"margin-bottom" => "8px"
						]
					),
					"div"
				);
			
			if(count($author) !== 0){
				
				$author =
					$this->fuckhtml
					->getTextContent(
						$author[0]
					);
			}else{
				
				$author = null;
			}
			
			// get date
			$date = null;
			
			$date_div =
				$this->fuckhtml
				->getElementsByAttributeName(
					"style",
					"div"
				);
			
			foreach($date_div as $d){
				
				$this->fuckhtml->load($d);
				
				$span =
					$this->fuckhtml
					->getElementsByTagName(
						"span"
					);
				
				if(
					strpos(
						$d["attributes"]["style"],
						"bottom:"
					) !== false
				){
					
					$date =
						strtotime(
							$this->fuckhtml
							->getTextContent(
								$span[count($span) - 1]
							)
						);
					break;
				}
			}
			
			$out["news"][] = [
				"title" => $title,
				"author" => $author,
				"description" => $description,
				"date" => $date,
				"thumb" => $thumb,
				"url" =>
					$this->unshiturl(
						$a["attributes"]
						["href"]
					)
			];
		}
		
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
			$time = $get["time"];
			$size = $get["size"];
			$ratio = $get["ratio"];
			$color = $get["color"];
			$type = $get["type"];
			$format = $get["format"];
			$rights = $get["rights"];
			
			$params = [
				"q" => $search,
				"udm" => "2" // get images
			];
			
			// country (image search uses cr instead of gl)
			if($country != "any"){
				
				$params["cr"] = "country" . strtoupper($country);
			}
			
			// nsfw
			$params["safe"] = $nsfw == "yes" ? "off" : "active";
			
			// generate tbs
			$tbs = [];
			
			// time
			if($time != "any"){
				
				$tbs["qdr"] = $time;
			}
			
			// size
			if($size != "any"){
				
				$params["imgsz"] = $size;
			}
			
			// ratio
			if($ratio != "any"){
				
				$params["imgar"] = $ratio;
			}
			
			// color
			if($color != "any"){
				
				if(
					$color == "color" ||
					$color == "trans"
				){
					
					$params["imgc"] = $color;
				}elseif($color == "bnw"){
					
					$params["imgc"] = "gray";
				}else{
					
					$tbs["ic"] = "specific";
					$tbs["isc"] = $color;
				}
			}
			
			// type
			if($type != "any"){
				
				$tbs["itp"] = $type;
			}
			
			// format
			if($format != "any"){
				
				$params["as_filetype"] = $format;
			}
			
			// rights (tbs)
			if($rights != "any"){
				
				$tbs["sur"] = $rights;
			}
			
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] = "";
				
				foreach($tbs as $key => $value){
					
					$params["tbs"] .= $key . ":" . $value . ",";
				}
				
				$params["tbs"] = rtrim($params["tbs"], ",");
			}
		}
		/*
		$handle = fopen("scraper/google-img.html", "r");
		$html = fread($handle, filesize("scraper/google-img.html"));
		fclose($handle);*/
		
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
		
		$this->detect_sorry();
		
		// get javascript images
		$this->scrape_imagearr($html);
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		$images =
			$this->fuckhtml
			->getElementsByClassName(
				"ivg-i",
				"div"
			);
		
		foreach($images as $div){
			
			$this->fuckhtml->load($div);
			
			$image =
				$this->fuckhtml
				->getElementsByTagName("img")[0];
			
			$out["image"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$image["attributes"]["alt"]
						)
					),
				"source" =>
					$this->image_arr[
						$div["attributes"]["data-docid"]
					],
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$div["attributes"]["data-lpage"]
					)
			];
		}
		
		// as usual, no way to check if there is a next page reliably
		if(count($out["image"]) > 50){
			
			if(!isset($params["start"])){
				
				$params["start"] = 10;
			}else{
				
				$params["start"] += 10;
			}
			
			$out["npt"] =
				$this->backend
				->store(
					json_encode($params),
					"image",
					$proxy
				);
		}
		
		return $out;
	}
	
	private function unshiturl($url, $return_size = false){
		
		// decode
		$url =
			$this->fuckhtml
			->getTextContent($url);
		
		$url_parts = parse_url($url);
		
		if(
			!isset(
				$url_parts["host"]
			)
		){
			
			// no host, we have a tracking url
			parse_str($url_parts["query"], $query);
			
			if(isset($query["imgurl"])){
				
				$url = $query["imgurl"];
			}
			elseif(isset($query["q"])){
				
				$url = $query["q"];
			}
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
		
		return trim($title, " .\t\n\r\0\x0B…");
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
	
	private function detect_sorry(){
		
		$recaptcha =
			$this->fuckhtml
			->getElementById(
				"recaptcha",
				"div"
			);
		
		if($recaptcha !== false){
			
			throw new Exception("Google returned a captcha");
		}
	}
}
