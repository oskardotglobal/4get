<?php

class mojeek{
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		$this->backend = new backend("mojeek");
	}
	
	public function getfilters($page){
		
		switch($page){
			
			case "web":
				return [
					"focus" => [
						"display" => "Focus",
						"option" => [
							"any" => "No focus",
							"blogs" => "Blogs",
							"Dictionary" => "Dictionary",
							"Recipes" => "Recipes",
							"Time" => "Time",
							"Weather" => "Weather"
						]
					],
					"lang" => [
						"display" => "Language",
						"option" => [
							"any" => "Any language",
							"af" => "Afrikaans",
							"sq" => "Albanian",
							"an" => "Aragonese",
							"ay" => "Aymara",
							"bi" => "Bislama",
							"br" => "Breton",
							"ca" => "Catalan",
							"kw" => "Cornish",
							"co" => "Corsican",
							"hr" => "Croatian",
							"da" => "Danish",
							"nl" => "Dutch",
							"dz" => "Dzongkha",
							"en" => "English",
							"fj" => "Fijian",
							"fi" => "Finnish",
							"fr" => "French",
							"gd" => "Gaelic",
							"gl" => "Galician",
							"de" => "German",
							"ht" => "Haitian",
							"io" => "Ido",
							"id" => "Indonesian",
							"ia" => "Interlingua",
							"ie" => "Interlingue",
							"ga" => "Irish",
							"it" => "Italian",
							"rw" => "Kinyarwanda",
							"la" => "Latin",
							"li" => "Limburgish",
							"lb" => "Luxembourgish",
							"no" => "Norwegian",
							"nb" => "Norwegian Bokmål",
							"nn" => "Norwegian Nynorsk",
							"oc" => "Occitan (post 1500)",
							"pl" => "Polish",
							"pt" => "Portuguese",
							"rm" => "Romansh",
							"rn" => "Rundi",
							"sg" => "Sango",
							"so" => "Somali",
							"es" => "Spanish",
							"sw" => "Swahili",
							"ss" => "Swati",
							"sv" => "Swedish",
							"ty" => "Tahitian",
							"to" => "Tonga (Tonga Islands)",
							"ts" => "Tsonga",
							"vo" => "Volapük",
							"wa" => "Walloon",
							"cy" => "Welsh",
							"xh" => "Xhosa",
							"zu" => "Zulu"
						]
					],
					"country" => [
						"display" => "Country",
						"option" => [
							"any" => "No location bias",
							"af" => "Afghanistan",
							"ax" => "Åland Islands",
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
							"bo" => "Bolivia (Plurinational State of)",
							"bq" => "Bonaire, Sint Eustatius and Saba",
							"ba" => "Bosnia and Herzegovina",
							"bw" => "Botswana",
							"bv" => "Bouvet Island",
							"br" => "Brazil",
							"io" => "British Indian Ocean Territory",
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
							"cx" => "Christmas Island",
							"cc" => "Cocos (Keeling) Islands",
							"co" => "Colombia",
							"km" => "Comoros",
							"cg" => "Congo",
							"cd" => "Congo (Democratic Republic of the)",
							"ck" => "Cook Islands",
							"cr" => "Costa Rica",
							"ci" => "Côte d'Ivoire",
							"hr" => "Croatia",
							"cu" => "Cuba",
							"cw" => "Curaçao",
							"cy" => "Cyprus",
							"cz" => "Czechia",
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
							"gg" => "Guernsey",
							"gn" => "Guinea",
							"gw" => "Guinea-Bissau",
							"gy" => "Guyana",
							"ht" => "Haiti",
							"hm" => "Heard Island and McDonald Islands",
							"va" => "Holy See",
							"hn" => "Honduras",
							"hk" => "Hong Kong",
							"hu" => "Hungary",
							"is" => "Iceland",
							"in" => "India",
							"id" => "Indonesia",
							"ir" => "Iran (Islamic Republic of)",
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
							"kp" => "Korea (Democratic People's Republic of)",
							"kr" => "Korea (Republic of)",
							"kw" => "Kuwait",
							"kg" => "Kyrgyzstan",
							"la" => "Lao People's Democratic Republic",
							"lv" => "Latvia",
							"lb" => "Lebanon",
							"ls" => "Lesotho",
							"lr" => "Liberia",
							"ly" => "Libya",
							"li" => "Liechtenstein",
							"lt" => "Lithuania",
							"lu" => "Luxembourg",
							"mo" => "Macao",
							"mk" => "Macedonia (the former Yugoslav Republic of)",
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
							"fm" => "Micronesia (Federated States of)",
							"md" => "Moldova (Republic of)",
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
							"nf" => "Norfolk Island",
							"mp" => "Northern Mariana Islands",
							"no" => "Norway",
							"om" => "Oman",
							"pk" => "Pakistan",
							"pw" => "Palau",
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
							"re" => "Réunion",
							"ro" => "Romania",
							"ru" => "Russian Federation",
							"rw" => "Rwanda",
							"bl" => "Saint Barthélemy",
							"sh" => "Saint Helena, Ascension and Tristan da Cunha",
							"kn" => "Saint Kitts and Nevis",
							"lc" => "Saint Lucia",
							"mf" => "Saint Martin (French part)",
							"pm" => "Saint Pierre and Miquelon",
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
							"sx" => "Sint Maarten (Dutch part)",
							"sk" => "Slovakia",
							"si" => "Slovenia",
							"sb" => "Solomon Islands",
							"so" => "Somalia",
							"za" => "South Africa",
							"gs" => "South Georgia and South Sandwich Islands",
							"ss" => "South Sudan",
							"es" => "Spain",
							"lk" => "Sri Lanka",
							"sd" => "Sudan",
							"sr" => "Suriname",
							"sj" => "Svalbard and Jan Mayen",
							"sz" => "Swaziland",
							"se" => "Sweden",
							"ch" => "Switzerland",
							"sy" => "Syrian Arab Republic",
							"tw" => "Taiwan",
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
							"gb" => "United Kingdom",
							"us" => "United States of America",
							"um" => "United States Minor Outlying Islands",
							"uy" => "Uruguay",
							"uz" => "Uzbekistan",
							"vu" => "Vanuatu",
							"ve" => "Venezuela (Bolivarian Republic of)",
							"vn" => "Viet Nam",
							"vg" => "Virgin Islands (British)",
							"vi" => "Virgin Islands (U.S.)",
							"wf" => "Wallis and Futuna",
							"eh" => "Western Sahara",
							"ye" => "Yemen",
							"zm" => "Zambia",
							"zw" => "Zimbabwe"
						]
					],
					"region" => [
						"display" => "Region",
						"option" => [
							"any" => "Any region",
							"eu" => "European Union",
							"de" => "Germany",
							"fr" => "France",
							"uk" => "United Kingdom"
						]
					],
					"domain" => [
						"display" => "Results per domain",
						"option" => [
							"1" => "1 result",
							"2" => "2 results",
							"3" => "3 results",
							"4" => "4 results",
							"5" => "5 results",
							"10" => "10 results",
							"0" => "Unlimited",
						]
					]
				];
				break;
			
			case "news":
				return [];
		}
	}
	
	private function get($proxy, $url, $get = []){
		
		$headers = [
			"User-Agent: " . config::USER_AGENT,
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
			
			[$token, $proxy] = $this->backend->get($get["npt"], "web");
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://www.mojeek.com" . $token,
						[]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$lang = $get["lang"];
			$country = $get["country"];
			$region = $get["region"];
			$domain = $get["domain"];
			$focus = $get["focus"];
			
			$params = [
				"q" => $search,
				"t" => 20, // number of results/page
				"tn" => 7, // number of news results/page
				"date" => 1, // show date
				"tlen" => 128, // max length of title
				"dlen" => 511, // max length of description
				"arc" => ($country == "any" ? "none" : $country) // location. don't use autodetect!
			];
			
			switch($focus){
				
				case "any": break;
				
				case "blogs":
					$params["fmt"] = "sst";
					$params["sst"] = "1";
					break;
				
				default:
					$params["foc_t"] = $focus;
					break;
			}
			
			if($lang != "any"){
				
				$params["lb"] = $lang;
			}
			
			if($region != "any"){
				
				$params["reg"] = $region;
			}
			
			if($domain != "1"){
				
				$params["si"] = $domain;
			}
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://www.mojeek.com/search",
						$params
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get HTML");
			}
			/*
			$handle = fopen("scraper/mojeek.html", "r");
			$html = fread($handle, filesize("scraper/mojeek.html"));
			fclose($handle);*/
			
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
		
		$this->fuckhtml->load($html);
		
		$results =
			$this->fuckhtml
			->getElementsByClassName("results-standard", "ul");
		
		if(count($results) === 0){
			
			return $out;
		}
		
		/*
			Get all search result divs
		*/
		foreach($results as $container){
			
			$this->fuckhtml->load($container);
			$results =
				$this->fuckhtml
				->getElementsByTagName("li");
			
			foreach($results as $result){
				
				$data = [
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
				
				$this->fuckhtml->load($result);
				
				$title =
					$this->fuckhtml
					->getElementsByClassName("title", "a")[0];
				
				$data["title"] =
					html_entity_decode(
						$this->fuckhtml
						->getTextContent(
							$title["innerHTML"]
						)
					);
				
				$data["url"] =
					html_entity_decode(
						$this->fuckhtml
						->getTextContent(
							$title["attributes"]["href"]
						)
					);
				
				$description =
					$this->fuckhtml
					->getElementsByClassName(
						"s", "p"
					);
				
				if(count($description) !== 0){
					
					$data["description"] =
						$this->titledots(
							html_entity_decode(
								$this->fuckhtml
								->getTextContent(
									$description[0]
								)
							)
						);
				}
				
				$date =
					$this->fuckhtml
					->getElementsByClassName(
						"mdate",
						"span"
					);
				
				if(count($date) !== 0){
										
					$data["date"] =
						strtotime(
							$this->fuckhtml
							->getTextContent(
								$date[0]
							)
						);
				}
				
				$out["web"][] = $data;
			}
		}
		
		/*
			Get instant answers
		*/
		$this->fuckhtml->load($html);
		
		$infoboxes =
			$this->fuckhtml
			->getElementsByClassName(
				"infobox infobox-top",
				"div"
			);
		
		foreach($infoboxes as $infobox){
			
			$answer = [
				"title" => null,
				"description" => [],
				"url" => null,
				"thumb" => null,
				"table" => [],
				"sublink" => []
			];
			
			// load first part with title + short definition
			$infobox_html =
				explode(
					"<hr>",
					$infobox["innerHTML"]
				);
			
			$this->fuckhtml->load($infobox_html[0]);
			
			// title
			$answer["title"] =
				$this->fuckhtml
				->getTextContent(
					$this->fuckhtml
					->getElementsByTagName("h1")[0]
				);
			
			// short definition
			$definition =
				$this->fuckhtml
				->getElementsByTagName(
					"p"
				);
			
			if(count($definition) !== 0){
				
				$answer["description"][] = [
					"type" => "quote",
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$definition[0]
						)
				];
			}

			// get thumbnail, if it exists
			$this->fuckhtml->load($infobox_html[1]);
			
			$thumb =
				$this->fuckhtml
				->getElementsByClassName("float-right", "img");
			
			if(count($thumb) !== 0){
				
				preg_match(
					'/\/image\?img=([^&]+)/i',
					$thumb[0]["attributes"]["src"],
					$thumb
				);
				
				if(count($thumb) === 2){
					
					$answer["thumb"] =
						$this->fuckhtml
						->getTextContent(
							$thumb[1]
						);
				}
			}
			
			// get description
			$ps =
				$this->fuckhtml
				->getElementsByTagName("p");
			
			$first_tag = true;
			foreach($ps as $p){
				
				$this->fuckhtml->load($p);
				
				if(
					preg_match(
						'/^\s*<strong>/i',
						$p["innerHTML"]
					)
				){
					
					/*
						Parse table
					*/
					
					$strong =
						$this->fuckhtml
						->getElementsByTagName("strong")[0];
					
					$p["innerHTML"] =
						str_replace($strong["innerHTML"], "", $p["innerHTML"]);
					
					$strong =
						preg_replace(
							'/:$/',
							"",
							ucfirst(
								$this->fuckhtml
								->getTextContent(
									$strong
								)
							)
						);
					
					$answer["table"][trim($strong)] =
						trim(
							$this->fuckhtml
							->getTextContent(
								$p
							)
						);
					
					continue;
				}
				
				$as =
					$this->fuckhtml
					->getElementsByClassName("svg-icon");
				
				if(count($as) !== 0){
					
					/*
						Parse websites
					*/
					foreach($as as $a){
						
						$answer["sublink"][
							ucfirst(explode(" ", $a["attributes"]["class"], 2)[1])
						] =
							$this->fuckhtml
							->getTextContent(
								$a["attributes"]["href"]
							);
					}
					
					continue; 
				}
				
				/*
					Parse text content
				*/
				$tags =
					$this->fuckhtml
					->getElementsByTagName("*");
				
				$i = 0;
				foreach($tags as $tag){
					
					$c = count($answer["description"]);
					
					// remove tag from innerHTML
					$p["innerHTML"] =
						explode($tag["outerHTML"], $p["innerHTML"], 2);
					
					if(count($p["innerHTML"]) === 2){
						
						if(
							$i === 0 &&
							$c !== 0 &&
							$answer["description"][$c - 1]["type"] == "link"
						){
							
							$append = "\n\n";
						}else{
							
							$append = "";
						}
						
						if($p["innerHTML"][0] != ""){
							$answer["description"][] = [
								"type" => "text",
								"value" => $append . trim($p["innerHTML"][0])
							];
						}
						
						$p["innerHTML"] = $p["innerHTML"][1];
					}else{
						
						$p["innerHTML"] = $p["innerHTML"][0];
					}
					
					switch($tag["tagName"]){
						
						case "a":
							
							$value =
								$this->fuckhtml
								->getTextContent(
									$tag
								);
							
							if(strtolower($value) == "wikipedia"){
								
								if($c !== 0){
									$answer["description"][$c - 1]["value"] =
										rtrim($answer["description"][$c - 1]["value"]);
								}
								break;
							}
							
							$answer["description"][] = [
								"type" => "link",
								"url" =>
									$this->fuckhtml
									->getTextContent(
										$tag["attributes"]["href"]
									),
								"value" =>
									$this->fuckhtml
									->getTextContent(
										$tag
									)
							];
							break;
					}
					
					$i++;
				}
			}
			
			// get URL
			$this->fuckhtml->load($infobox_html[2]);
			
			$answer["url"] =
				$this->fuckhtml
				->getTextContent(
					$this->fuckhtml
					->getElementsByTagName(
						"a"
					)[0]
					["attributes"]
					["href"]
				);
			
			// append answer
			$out["answer"][] = $answer;
		}
		
		/*
			Get news
		*/
		$this->fuckhtml->load($html);
		
		$news =
			$this->fuckhtml
			->getElementsByClassName(
				"results news-results",
				"div"
			);
		
		if(count($news) !== 0){
			
			$this->fuckhtml->load($news[0]);
			
			$lis =
				$this->fuckhtml
				->getElementsByTagName("li");
			
			foreach($lis as $li){
				
				$this->fuckhtml->load($li);
				
				$a =
					$this->fuckhtml
					->getElementsByClassName(
						"ob",
						"a"
					);
				
				if(count($a) === 0){
					
					continue;
				}
				
				$a = $a[0];
				
				$date =
					explode(
						" - ",
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByTagName(
								"span"
							)[0]
						)
					);
				
				$date =
					strtotime(
						$date[count($date) - 1]
					);
				
				$out["news"][] = [
					"title" =>
						html_entity_decode(
							$this->fuckhtml
							->getTextContent(
								$a
							)
						),
					"description" => null,
					"date" => $date,
					"thumb" => [
						"url" => null,
						"ratio" => null
					],
					"url" =>
						$this->fuckhtml
						->getTextContent(
							$a["attributes"]["href"]
						)
				];
			}
		}
		
		/*
			Get next page
		*/
		$this->fuckhtml->load($html);
		
		$pagination =
			$this->fuckhtml
			->getElementsByClassName("pagination");
		
		if(count($pagination) !== false){
			
			$this->fuckhtml->load($pagination[0]);
			$as =
				$this->fuckhtml
				->getElementsByTagName("a");
			
			foreach($as as $a){
				
				if($a["innerHTML"] == "Next"){
					
					$out["npt"] = $this->backend->store(
						$this->fuckhtml
						->getTextContent(
							$a["attributes"]["href"]
						),
						"web",
						$proxy
					);
				}
			}
		}
		
		return $out;
	}
	
	public function news($get){
		
		$search = $get["s"];
		
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		try{
			$html =
				$this->get(
					$this->backend->get_ip(),
					"https://www.mojeek.com/search",
					[
						"q" => $search,
						"fmt" => "news"
					]
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get HTML");
		}
		/*
		$handle = fopen("scraper/mojeek.html", "r");
		$html = fread($handle, filesize("scraper/mojeek.html"));
		fclose($handle);
		*/
		
		$this->fuckhtml->load($html);
		
		$articles =
			$this->fuckhtml->getElementsByTagName("article");
		
		foreach($articles as $article){
			
			$this->fuckhtml->load($article);
			
			$data = [
				"title" => null,
				"author" => null,
				"description" => null,
				"date" => null,
				"thumb" =>
					[
						"url" => null,
						"ratio" => null
					],
				"url" => null
			];
			
			$a = $this->fuckhtml->getElementsByTagName("a")[0];
			
			$data["title"] =
				$this->fuckhtml
				->getTextContent(
					$a["attributes"]["title"]
				);
			
			$data["url"] =
				$this->fuckhtml
				->getTextContent(
					$a["attributes"]["href"]
				);
			
			$p = $this->fuckhtml->getElementsByTagName("p");
			
			$data["description"] =
				$this->titledots(
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByClassName(
							"s",
							$p
						)[0]
					)
				);
			
			if($data["description"] == ""){
				
				$data["description"] = null;
			}
			
			// get date from big node
			$date =
				$this->fuckhtml
				->getElementsByClassName(
					"date",
					$p
				);
			
			if(count($date) !== 0){
				
				$data["date"] =
					strtotime(
						$this->fuckhtml
						->getTextContent(
							$date[0]
						)
					);
			}
			
			// grep date + author
			$s =
				$this->fuckhtml
				->getElementsByClassName(
					"i",
					$p
				)[0];
			
			$this->fuckhtml->load($s);
			
			$a =
				$this->fuckhtml
				->getElementsByTagName("a");
			
			if(count($a) !== 0){
				
				// parse big node information
				$data["author"] =
					htmlspecialchars_decode(
						$this->fuckhtml
						->getTextContent(
							$a[0]["innerHTML"]
						)
					);
			}else{
				
				// parse smaller nodes
				$replace =
					$this->fuckhtml
					->getElementsByTagName("time")[0];
				
				$data["date"] =
					strtotime(
						$this->fuckhtml
						->getTextContent(
							$replace
						)
					);
				
				$s["innerHTML"] =
					str_replace(
						$replace["outerHTML"],
						"",
						$s["innerHTML"]
					);
				
				$data["author"] =
					preg_replace(
						'/ &bull; $/',
						"",
						$s["innerHTML"]
					);
			}
			
			$out["news"][] = $data;
		}
		
		return $out;
	}
	
	private function titledots($title){
		
		return trim($title, ". \t\n\r\0\x0B");
	}
}
	
