<?php

class ddg{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("ddg");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	/*
		curl functions
	*/
	private const req_web = 0;
	private const req_xhr = 1;
	
	private function get($proxy, $url, $get = [], $reqtype = self::req_web){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		switch($reqtype){
			case self::req_web:
				$headers =
					["User-Agent: " . config::USER_AGENT,
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
					"Accept-Encoding: gzip",
					"Accept-Language: en-US,en;q=0.5",
					"DNT: 1",
					"Connection: keep-alive",
					"Upgrade-Insecure-Requests: 1",
					"Sec-Fetch-Dest: document",
					"Sec-Fetch-Mode: navigate",
					"Sec-Fetch-Site: cross-site",
					"Upgrade-Insecure-Requests: 1"];
				break;
			
			case self::req_xhr:
				$headers =
					["User-Agent: " . config::USER_AGENT,
					"Accept: */*",
					"Accept-Encoding: gzip",
					"Accept-Language: en-US,en;q=0.5",
					"Connection: keep-alive",
					"Referer: https://duckduckgo.com/",
					"X-Requested-With: XMLHttpRequest",
					"DNT: 1",
					"Sec-Fetch-Dest: script",
					"Sec-Fetch-Mode: no-cors",
					"Sec-Fetch-Site: same-site"];
				break;
		}
		
		$this->backend->assign_proxy($curlproc, $proxy);
		
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
	
	public function getfilters($pagetype){
		
		switch($pagetype){
			
			case "web":
				return
				[
					"country" => [
						"display" => "Country",
						"option" => [
							"any" => "All Regions",
							"ar-es" => "Argentina",
							"au-en" => "Australia",
							"at-de" => "Austria",
							"be-fr" => "Belgium (fr)",
							"be-nl" => "Belgium (nl)",
							"br-pt" => "Brazil",
							"bg-bg" => "Bulgaria",
							"ca-en" => "Canada (en)",
							"ca-fr" => "Canada (fr)",
							"ct-ca" => "Catalonia",
							"cl-es" => "Chile",
							"cn-zh" => "China",
							"co-es" => "Colombia",
							"hr-hr" => "Croatia",
							"cz-cs" => "Czech Republic",
							"dk-da" => "Denmark",
							"ee-et" => "Estonia",
							"fi-fi" => "Finland",
							"fr-fr" => "France",
							"de-de" => "Germany",
							"gr-el" => "Greece",
							"hk-tzh" => "Hong Kong",
							"hu-hu" => "Hungary",
							"in-en" => "India (en)",
							"id-en" => "Indonesia (en)",
							"ie-en" => "Ireland",
							"il-en" => "Israel (en)",
							"it-it" => "Italy",
							"jp-jp" => "Japan",
							"kr-kr" => "Korea",
							"lv-lv" => "Latvia",
							"lt-lt" => "Lithuania",
							"my-en" => "Malaysia (en)",
							"mx-es" => "Mexico",
							"nl-nl" => "Netherlands",
							"nz-en" => "New Zealand",
							"no-no" => "Norway",
							"pk-en" => "Pakistan (en)",
							"pe-es" => "Peru",
							"ph-en" => "Philippines (en)",
							"pl-pl" => "Poland",
							"pt-pt" => "Portugal",
							"ro-ro" => "Romania",
							"ru-ru" => "Russia",
							"xa-ar" => "Saudi Arabia",
							"sg-en" => "Singapore",
							"sk-sk" => "Slovakia",
							"sl-sl" => "Slovenia",
							"za-en" => "South Africa",
							"es-ca" => "Spain (ca)",
							"es-es" => "Spain (es)",
							"se-sv" => "Sweden",
							"ch-de" => "Switzerland (de)",
							"ch-fr" => "Switzerland (fr)",
							"tw-tzh" => "Taiwan",
							"th-en" => "Thailand (en)",
							"tr-tr" => "Turkey",
							"us-en" => "US (English)",
							"us-es" => "US (Spanish)",
							"ua-uk" => "Ukraine",
							"uk-en" => "United Kingdom",
							"vn-en" => "Vietnam (en)"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes",
							"maybe" => "Maybe",
							"no" => "No"
						]
					],
					"newer" => [
						"display" => "Newer than",
						"option" => "_DATE"
					],
					"older" => [
						"display" => "Older than",
						"option" => "_DATE"
					],
					"extendedsearch" => [
						// undefined display, so it wont show in frontend
						"option" => [
							"yes" => "Yes",
							"no" => "No"
						]
					]
				];
				break;
			
			case "images":
				return
				[
					"country" => [
						"display" => "Country",
						"option" => [
							"us-en" => "US (English)",
							"ar-es" => "Argentina",
							"au-en" => "Australia",
							"at-de" => "Austria",
							"be-fr" => "Belgium (fr)",
							"be-nl" => "Belgium (nl)",
							"br-pt" => "Brazil",
							"bg-bg" => "Bulgaria",
							"ca-en" => "Canada (en)",
							"ca-fr" => "Canada (fr)",
							"ct-ca" => "Catalonia",
							"cl-es" => "Chile",
							"cn-zh" => "China",
							"co-es" => "Colombia",
							"hr-hr" => "Croatia",
							"cz-cs" => "Czech Republic",
							"dk-da" => "Denmark",
							"ee-et" => "Estonia",
							"fi-fi" => "Finland",
							"fr-fr" => "France",
							"de-de" => "Germany",
							"gr-el" => "Greece",
							"hk-tzh" => "Hong Kong",
							"hu-hu" => "Hungary",
							"in-en" => "India (en)",
							"id-en" => "Indonesia (en)",
							"ie-en" => "Ireland",
							"il-en" => "Israel (en)",
							"it-it" => "Italy",
							"jp-jp" => "Japan",
							"kr-kr" => "Korea",
							"lv-lv" => "Latvia",
							"lt-lt" => "Lithuania",
							"my-en" => "Malaysia (en)",
							"mx-es" => "Mexico",
							"nl-nl" => "Netherlands",
							"nz-en" => "New Zealand",
							"no-no" => "Norway",
							"pk-en" => "Pakistan (en)",
							"pe-es" => "Peru",
							"ph-en" => "Philippines (en)",
							"pl-pl" => "Poland",
							"pt-pt" => "Portugal",
							"ro-ro" => "Romania",
							"ru-ru" => "Russia",
							"xa-ar" => "Saudi Arabia",
							"sg-en" => "Singapore",
							"sk-sk" => "Slovakia",
							"sl-sl" => "Slovenia",
							"za-en" => "South Africa",
							"es-ca" => "Spain (ca)",
							"es-es" => "Spain (es)",
							"se-sv" => "Sweden",
							"ch-de" => "Switzerland (de)",
							"ch-fr" => "Switzerland (fr)",
							"tw-tzh" => "Taiwan",
							"th-en" => "Thailand (en)",
							"tr-tr" => "Turkey",
							"us-es" => "US (Spanish)",
							"ua-uk" => "Ukraine",
							"uk-en" => "United Kingdom",
							"vn-en" => "Vietnam (en)"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes",
							"no" => "No"
						]
					],
					"date" => [
						"display" => "Time posted",
						"option" => [
							"any" => "Any time",
							"Day" => "Past day",
							"Week" => "Past week",
							"Month" => "Past month"
						]
					],
					"size" => [
						"display" => "Size",
						"option" => [
							"any" => "Any size",
							"Small" => "Small",
							"Medium" => "Medium",
							"Large" => "Large",
							"Wallpaper" => "Wallpaper"
						]
					],
					"color" => [
						"display" => "Colors",
						"option" => [
							"any" => "All colors",
							"Monochrome" => "Black and white",
							"Red" => "Red",
							"Orange" => "Orange",
							"Yellow" => "Yellow",
							"Green" => "Green",
							"Blue" => "Blue",
							"Purple" => "Purple",
							"Pink" => "Pink",
							"Brown" => "Brown",
							"Black" => "Black",
							"Gray" => "Gray",
							"Teal" => "Teal",
							"White" => "White"
						]
					],
					"type" => [
						"display" => "Type",
						"option" => [
							"any" => "All types",
							"photo" => "Photograph",
							"clipart" => "Clipart",
							"gif" => "Animated GIF",
							"transparent" => "Transparent"
						]
					],
					"layout" => [
						"display" => "Layout",
						"option" => [
							"any" => "All layouts",
							"Square" => "Square",
							"Tall" => "Tall",
							"Wide" => "Wide"
						]
					],
					"license" => [
						"display" => "License",
						"option" => [
							"any" => "All licenses", // blame ddg for this
							"Any" => "All Creative Commons",
							"Public" => "Public domain",
							"Share" => "Free to Share and Use",
							"ShareCommercially" => "Free to Share and Use Commercially",
							"Modify" => "Free to Modify, Share, and Use",
							"ModifyCommercially" => "Free to Modify, Share, and Use Commercially"
						]
					]
				];
				break;
			
			case "videos":
				return
				[
					"country" => [
						"display" => "Country",
						"option" => [
							"us-en" => "US (English)",
							"ar-es" => "Argentina",
							"au-en" => "Australia",
							"at-de" => "Austria",
							"be-fr" => "Belgium (fr)",
							"be-nl" => "Belgium (nl)",
							"br-pt" => "Brazil",
							"bg-bg" => "Bulgaria",
							"ca-en" => "Canada (en)",
							"ca-fr" => "Canada (fr)",
							"ct-ca" => "Catalonia",
							"cl-es" => "Chile",
							"cn-zh" => "China",
							"co-es" => "Colombia",
							"hr-hr" => "Croatia",
							"cz-cs" => "Czech Republic",
							"dk-da" => "Denmark",
							"ee-et" => "Estonia",
							"fi-fi" => "Finland",
							"fr-fr" => "France",
							"de-de" => "Germany",
							"gr-el" => "Greece",
							"hk-tzh" => "Hong Kong",
							"hu-hu" => "Hungary",
							"in-en" => "India (en)",
							"id-en" => "Indonesia (en)",
							"ie-en" => "Ireland",
							"il-en" => "Israel (en)",
							"it-it" => "Italy",
							"jp-jp" => "Japan",
							"kr-kr" => "Korea",
							"lv-lv" => "Latvia",
							"lt-lt" => "Lithuania",
							"my-en" => "Malaysia (en)",
							"mx-es" => "Mexico",
							"nl-nl" => "Netherlands",
							"nz-en" => "New Zealand",
							"no-no" => "Norway",
							"pk-en" => "Pakistan (en)",
							"pe-es" => "Peru",
							"ph-en" => "Philippines (en)",
							"pl-pl" => "Poland",
							"pt-pt" => "Portugal",
							"ro-ro" => "Romania",
							"ru-ru" => "Russia",
							"xa-ar" => "Saudi Arabia",
							"sg-en" => "Singapore",
							"sk-sk" => "Slovakia",
							"sl-sl" => "Slovenia",
							"za-en" => "South Africa",
							"es-ca" => "Spain (ca)",
							"es-es" => "Spain (es)",
							"se-sv" => "Sweden",
							"ch-de" => "Switzerland (de)",
							"ch-fr" => "Switzerland (fr)",
							"tw-tzh" => "Taiwan",
							"th-en" => "Thailand (en)",
							"tr-tr" => "Turkey",
							"us-en" => "US (English)",
							"us-es" => "US (Spanish)",
							"ua-uk" => "Ukraine",
							"uk-en" => "United Kingdom",
							"vn-en" => "Vietnam (en)"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes",
							"no" => "No"
						]
					],
					"date" => [
						"display" => "Time fetched",
						"option" => [
							"any" => "Any time",
							"d" => "Past day",
							"w" => "Past week",
							"m" => "Past month"
						]
					],
					"resolution" => [ //videoDefinition
						"display" => "Resolution",
						"option" => [
							"any" => "Any resolution",
							"high" => "High definition",
							"standard" => "Standard definition"
						]
					],
					"duration" => [ // videoDuration
						"display" => "Duration",
						"option" => [
							"any" => "Any duration",
							"short" => "Short (>5min)",
							"medium" => "Medium (5-20min)",
							"long" => "Long (<20min)"
						]
					],
					"license" => [
						"display" => "License",
						"option" => [
							"any" => "Any license",
							"creativeCommon" => "Creative Commons",
							"youtube" => "YouTube Standard"
						]
					]
				];
				break;
				
			case "news":
				return
				[
					"country" => [
						"display" => "Country",
						"option" => [
							"us-en" => "US (English)",
							"ar-es" => "Argentina",
							"au-en" => "Australia",
							"at-de" => "Austria",
							"be-fr" => "Belgium (fr)",
							"be-nl" => "Belgium (nl)",
							"br-pt" => "Brazil",
							"bg-bg" => "Bulgaria",
							"ca-en" => "Canada (en)",
							"ca-fr" => "Canada (fr)",
							"ct-ca" => "Catalonia",
							"cl-es" => "Chile",
							"cn-zh" => "China",
							"co-es" => "Colombia",
							"hr-hr" => "Croatia",
							"cz-cs" => "Czech Republic",
							"dk-da" => "Denmark",
							"ee-et" => "Estonia",
							"fi-fi" => "Finland",
							"fr-fr" => "France",
							"de-de" => "Germany",
							"gr-el" => "Greece",
							"hk-tzh" => "Hong Kong",
							"hu-hu" => "Hungary",
							"in-en" => "India (en)",
							"id-en" => "Indonesia (en)",
							"ie-en" => "Ireland",
							"il-en" => "Israel (en)",
							"it-it" => "Italy",
							"jp-jp" => "Japan",
							"kr-kr" => "Korea",
							"lv-lv" => "Latvia",
							"lt-lt" => "Lithuania",
							"my-en" => "Malaysia (en)",
							"mx-es" => "Mexico",
							"nl-nl" => "Netherlands",
							"nz-en" => "New Zealand",
							"no-no" => "Norway",
							"pk-en" => "Pakistan (en)",
							"pe-es" => "Peru",
							"ph-en" => "Philippines (en)",
							"pl-pl" => "Poland",
							"pt-pt" => "Portugal",
							"ro-ro" => "Romania",
							"ru-ru" => "Russia",
							"xa-ar" => "Saudi Arabia",
							"sg-en" => "Singapore",
							"sk-sk" => "Slovakia",
							"sl-sl" => "Slovenia",
							"za-en" => "South Africa",
							"es-ca" => "Spain (ca)",
							"es-es" => "Spain (es)",
							"se-sv" => "Sweden",
							"ch-de" => "Switzerland (de)",
							"ch-fr" => "Switzerland (fr)",
							"tw-tzh" => "Taiwan",
							"th-en" => "Thailand (en)",
							"tr-tr" => "Turkey",
							"us-en" => "US (English)",
							"us-es" => "US (Spanish)",
							"ua-uk" => "Ukraine",
							"uk-en" => "United Kingdom",
							"vn-en" => "Vietnam (en)"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes",
							"maybe" => "Maybe",
							"no" => "No"
						]
					],
					"date" => [
						"display" => "Time posted",
						"option" => [
							"any" => "Any time",
							"d" => "Past day",
							"w" => "Past week",
							"m" => "Past month"
						]
					]
				];
				break;
			
			default:
				return [];
				break;
		}
	}
	
	public function web($get){
		
		if($get["npt"]){
			
			[$jsgrep, $proxy] = $this->backend->get($get["npt"], "web");
						
			$extendedsearch = false;
			$inithtml = "";
			
		}else{
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$older = $get["older"];
			$newer = $get["newer"];
			$extendedsearch = $get["extendedsearch"] == "yes" ? true : false;
			
			// generate filters
			$get_filters = [
				"q" => $search,
				"kz" => "1" // force instant answers
			];
			
			if($country == "any"){
				
				$get_filters["kl"] = "wt-wt";
			}else{
				
				$get_filters["kl"] = $country;
			}
			
			switch($nsfw){
				
				case "yes": $get_filters["kp"] = "-2"; break;
				case "maybe": $get_filters["kp"] = "-1"; break;
				case "no": $get_filters["kp"] = "1"; break;
			}
			
			$df = true;
			
			if($newer === false){
				
				if($older !== false){
					
					$start = 36000;
					$end = $older;
				}else{
					
					$df = false;
				}
			}else{
				
				$start = $newer;
				
				if($older !== false){
					
					$end = $older;
				}else{
					
					$end = time();
				}
			}
			
			if($df === true){
				$get_filters["df"] = date("Y-m-d", $start) . ".." . date("Y-m-d", $end);
			}
			
			/*
				Get html
			*/
			try{
				$inithtml = $this->get(
					$proxy,
					"https://duckduckgo.com/",
					$get_filters
				);
			}catch(Exception $e){
				
				throw new Exception("Failed to get html");
			}
			
			preg_match(
				'/DDG\.deep\.initialize\(\'(.*)\',/U',
				$inithtml,
				$jsgrep
			);
			
			if(!isset($jsgrep[1])){
				
				throw new Exception("Failed to get d.js URL");
			}
			
			$jsgrep = $jsgrep[1];
		}
		
		// get javascript
		try{
			
			$js = $this->get(
				$proxy,
				"https://links.duckduckgo.com" . $jsgrep,
				[],
				ddg::req_xhr
			);
		}catch(Exception $e){
			
			throw new Exception("Failed to fetch d.js");
		}
		
		// initialize api response array
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
		
		/*
			Additional requests
		*/
		
		if($extendedsearch){
			
			/*
				Check for worknik results
			*/
			preg_match(
				'/nrj\(\'\/js\/spice\/dictionary\/definition\/([^\'\)]+)/',
				$js,
				$wordnik
			);
			
			if(isset($wordnik[1])){
				
				try{
				
					$wordnik = $wordnik[1];
					
					// get definition
					$wordnikjs = $this->get(
						$proxy,
						"https://duckduckgo.com/js/spice/dictionary/definition/" . $wordnik,
						[],
						ddg::req_xhr
					);
					
					preg_match(
						'/ddg_spice_dictionary_definition\(\n?(\[{[\S\s]*}])/',
						$wordnikjs,
						$wordnikjson
					);
					
					if(isset($wordnikjson[1])){
						
						$wordnikjson = json_decode($wordnikjson[1], true);
						
						$out["answer"][0] = [
							"title" => urldecode($wordnik),
							"description" => [],
							"url" => "https://www.wordnik.com/words/" . $wordnik,
							"thumb" => null,
							"table" => [],
							"sublink" => []
						];
						
						$partofspeech = false;
						$wastext = false;
						$textindent = 1;
						
						// get audio
						
						$wordnikaudio_json =
							json_decode(
								$this->get(
									$proxy,
									"https://duckduckgo.com/js/spice/dictionary/audio/" . $wordnik,
									[],
									ddg::req_xhr
								),
								true
							);
						
						if(isset($wordnikaudio_json[0]["id"])){
							
							usort($wordnikaudio_json, function($a, $b){
								
								return $a["id"] < $b["id"];
							});
							
							$out["answer"][0]["description"][] = [
								"type" => "audio",
								"url" => $wordnikaudio_json[0]["fileUrl"]
							];
						}
						
						$collection = [];
						$e[] = [];
						
						foreach($wordnikjson as $data){
							
							if(!isset($data["partOfSpeech"])){
								
								continue;
							}
							
							if(isset($data["text"])){
								
								if(!isset($collection[$data["partOfSpeech"]])){
									
									$collection[$data["partOfSpeech"]] = [];
									$c = 0;
								}else{
									$c = count($collection[$data["partOfSpeech"]]);
								}
								
								if(!isset($e[$data["partOfSpeech"]])){
									
									$e[$data["partOfSpeech"]] = 0;
								}
								
								$e[$data["partOfSpeech"]]++;
								$text = $e[$data["partOfSpeech"]] . ". " . $this->unescapehtml(strip_tags($data["text"]));
								
								$syn = false;
								if(
									isset($data["relatedWords"]) &&
									count($data["relatedWords"]) !== 0
								){
									
									$syn = " (";
									
									$u = 0;
									foreach($data["relatedWords"] as $related){
										
										$syn .= ucfirst($related["relationshipType"]) . ": ";
										
										$c = count($related["words"]);
										$b = 0;
										foreach($related["words"] as $word){
											
											$syn .= trim($this->unescapehtml(strip_tags($word)));
											
											$b++;
											if($b !== $c){
												
												$syn .= ", ";
											}
										}
										
										$u++;
										if($u !== count($data["relatedWords"])){
											
											$syn .= ". ";
										}
									}
									
									$syn .= ")";
								}
								
								if(
									$c !== 0 &&
									$collection[$data["partOfSpeech"]][$c - 1]["type"] == "text"
								){
									$collection[$data["partOfSpeech"]][$c - 1]["value"] .=
										"\n" . $text;
									
								}else{
									
									if(
										$c !== 0 &&
										(
											$collection[$data["partOfSpeech"]][$c - 1]["type"] == "text" ||
											$collection[$data["partOfSpeech"]][$c - 1]["type"] == "italic"
										)
									){
										
										$text = "\n" . $text;
									}
									
									$collection[$data["partOfSpeech"]][] =
										[
											"type" => "text",
											"value" => $text
										];
								}
								
								if($syn){
									
									$collection[$data["partOfSpeech"]][] = [
										"type" => "italic",
										"value" => $syn
									];
								}
								
								if(isset($data["exampleUses"])){
									
									foreach($data["exampleUses"] as $use){
										
										$collection[$data["partOfSpeech"]][] = [
											"type" => "quote",
											"value" => $this->unescapehtml(strip_tags($use["text"]))
										];
									}
								}
								
								if(isset($data["citations"])){
									
									foreach($data["citations"] as $citation){
										
										if(!isset($citation["cite"])){
											
											continue;
										}
										
										$value = $this->unescapehtml(strip_tags($citation["cite"]));
										
										if(
											isset($citation["source"]) &&
											trim($citation["source"]) != ""
										){
											$value .= " - " . $this->unescapehtml(strip_tags($citation["source"]));
										}
										
										$collection[$data["partOfSpeech"]][] = [
											"type" => "quote",
											"value" => $value
										];
									}
								}
							}
						}
						
						foreach($collection as $key => $items){
							
							$out["answer"][0]["description"][] =
								[
									"type" => "title",
									"value" => $key
								];
							
							$out["answer"][0]["description"] =
								array_merge($out["answer"][0]["description"], $items);
						}
					}
					
				}catch(Exception $e){
					
					// do nothing
				}
			}
			
			unset($wordnik);
			
			/*
				Check for stackoverflow answers
			*/
			
			// /a.js?p=1&src_id=stack_overflow&from=nlp_qa&id=3390396,2559318&q=how%20can%20i%20check%20for%20undefined%20in%20javascript&s=stackoverflow.com&tl=How%20can%20I%20check%20for%20%22undefined%22%20in%20JavaScript%3F%20%2D%20Stack%20Overflow
			// /a.js?p=1&src_id=arqade&from=nlp_qa&id=370293,375682&q=what%20is%20the%20difference%20between%20at%20and%20positioned%20in%20execute&s=gaming.stackexchange.com&tl=minecraft%20java%20edition%20minecraft%20commands%20%2D%20What%20is%20the%20difference
			// /a.js?p=1&src_id=unix&from=nlp_qa&id=312754&q=how%20to%20strip%20metadata%20from%20image%20files&s=unix.stackexchange.com&tl=How%20to%20strip%20metadata%20from%20image%20files%20%2D%20Unix%20%26%20Linux%20Stack%20Exchange
			preg_match(
				'/nrj\(\'(\/a\.js\?.*from=nlp_qa.*)\'\)/U',
				$js,
				$stack
			);
			
			if(isset($stack[1])){
				
				$stack = $stack[1];
				
				try{
					$stackjs = $this->get(
						$proxy,
						"https://duckduckgo.com" . $stack,
						[],
						ddg::req_xhr
					);
					
					if(
						!preg_match(
							'/^DDG\.duckbar\.failed/',
							$stackjs
						)
					){
					
						preg_match(
							'/DDG\.duckbar\.add_array\((\[\{[\S\s]*}])\)/U',
							$stackjs,
							$stackjson
						);
						
						$stackjson = json_decode($stackjson[1], true)[0]["data"][0];
						
						$out["answer"][] = [
							"title" => $stackjson["Heading"],
							"description" => $this->stackoverflow_parse($stackjson["Abstract"]),
							"url" => str_replace(["http://", "ddg"], ["https://", ""], $stackjson["AbstractURL"]),
							"thumb" => null,
							"table" => [],
							"sublink" => []
						];
					}
					
				}catch(Exception $e){
					
					// do nothing
				}
			}
			
			/*
				Check for musicmatch (lyrics)
			*/
			preg_match(
				'/nrj\(\'(\/a\.js\?.*&s=lyrics.*)\'\)/U',
				$js,
				$lyrics
			);
			
			if(isset($lyrics[1])){
				
				$lyrics = $lyrics[1];
				
				try{
					$lyricsjs = $this->get(
						$proxy,
						"https://duckduckgo.com" . $lyrics,
						[],
						ddg::req_xhr
					);
					
					if(
						!preg_match(
							'/^DDG\.duckbar\.failed/',
							$lyricsjs
						)
					){
					
						preg_match(
							'/DDG\.duckbar\.add_array\((\[\{[\S\s]*}])\)/U',
							$lyricsjs,
							$lyricsjson
						);
						
						$lyricsjson = json_decode($lyricsjson[1], true)[0]["data"][0];
						
						$title = null;
						
						if(isset($lyricsjson["Heading"])){
							
							$title = $lyricsjson["Heading"];
						}elseif(isset($lyricsjson["data"][1]["urlTitle"])){
							
							$title = $lyricsjson["data"][1]["urlTitle"];
						}else{
							
							$title = $lyricsjson["data"][0]["song_title"];
						}
						
						$description = [
							[
								"type" => "text",
								"value" => null
							]
						];
						$parts =
							explode(
								"<br>",
								str_ireplace(
									["<br>", "</br>", "<br/>"],
									"<br>",
									$lyricsjson["Abstract"]
								),
							);
						
						for($i=0; $i<count($parts); $i++){
							
							$description[0]["value"] .= trim($parts[$i]) . "\n";
						}
						
						$description[0]["value"] = trim($description[0]["value"]);
						
						$description[] =
						[
							"type" => "quote",
							"value" =>
								"Written by " . implode(", ", $lyricsjson["data"][0]["writers"]) .
								"\nFrom the album " . $lyricsjson["data"][0]["albums"][0]["title"] .
								"\nReleased on the " . date("jS \of F Y", strtotime($lyricsjson["data"][0]["albums"][0]["release_date"]))
						];

						$out["answer"][] = [
							"title" => $title,
							"description" => $description,
							"url" => $lyricsjson["AbstractURL"],
							"thumb" => null,
							"table" => [],
							"sublink" => []
						];
					}
					
				}catch(Exception $e){
					
					// do nothing
				}
			}
		}
		
		/*
			Get related searches
		*/
		preg_match(
			'/DDG\.duckbar\.loadModule\(\'related_searches\', ?{[\s\S]*"results":(\[{[\s\S]*}]),"vqd"/U',
			$js,
			$related
		);
		
		if(isset($related[1])){
			
			try{
				$related = json_decode($related[1], true);
				
				for($i=0; $i<count($related); $i++){
					
					if(isset($related[$i]["text"])){
						
						array_push($out["related"], $related[$i]["text"]);
					}
				}
				
			}catch(Exception $e){
				
				// do nothing
			}
		}
		
		unset($related);
		
		/*
			Get answers
		*/
		$answer_count = preg_match_all(
			'/DDG\.duckbar\.add\(({.*[\S\s]*})(?:\);|,null,"index"\))/U',
			$js . $inithtml,
			$answers
		);
		
		try{
			
			if(isset($answers[1])){
				
				$answers = $answers[1];
				
				for($i=0; $i<$answer_count; $i++){
					
					$answers[$i] = json_decode($answers[$i], true);
					
					// remove dupes
					for($k=0; $k<count($out["answer"]); $k++){
						
						if(
							!isset($answers[$i]["data"]["AbstractURL"]) ||
							str_replace("_", "%20", $out["answer"][$k]["url"]) == str_replace("_", "%20", $this->sanitizeurl($answers[$i]["data"]["AbstractURL"]))
						){
							
							continue 2;
						}
					}
					
					// get more related queries
					if(
						isset($answers[$i]["data"]["RelatedTopics"]) &&
						$answers[$i]["data"]["RelatedTopics"] != 0
					){
						
						for($k=0; $k<count($answers[$i]["data"]["RelatedTopics"]); $k++){
							
							if(isset($answers[$i]["data"]["RelatedTopics"][$k]["Result"])){
								
								preg_match(
									'/">(.*)<\//',
									$answers[$i]["data"]["RelatedTopics"][$k]["Result"],
									$label
								);
								
								array_push($out["related"], htmlspecialchars_decode(strip_tags($label[1])));
							}
						}
					}
					
					$image = null;
					
					// get image
					if(
						isset($answers[$i]["data"]["Image"]) &&
						!empty($answers[$i]["data"]["Image"]) &&
						$answers[$i]["data"]["Image"] != "https://duckduckgo.com/i/"
					){
						if(strpos($answers[$i]["data"]["Image"], "https://duckduckgo.com/i/") === true){
							
							$image = $answers[$i]["data"]["Image"];
						}else{
							
							if(
								strlen($answers[$i]["data"]["Image"]) > 0 &&
								$answers[$i]["data"]["Image"][0] == "/"
							){
								
								$answers[$i]["data"]["Image"] = substr($answers[$i]["data"]["Image"], 1);
							}
							
							$image = "https://duckduckgo.com/" . $answers[$i]["data"]["Image"];
						}
					}
					
					$count = count($out["answer"]);
					
					if(isset($answers[$i]["data"]["AbstractText"]) && !empty($answers[$i]["data"]["AbstractText"])){
						
						$description = $this->stackoverflow_parse($answers[$i]["data"]["AbstractText"]);
					}elseif(isset($answers[$i]["data"]["Abstract"]) && !empty($answers[$i]["data"]["Abstract"])){
						
						$description = $this->stackoverflow_parse($answers[$i]["data"]["Abstract"]);
					}elseif(isset($answers[$i]["data"]["Answer"]) && !empty($answers[$i]["data"]["Answer"])){
						
						$description = $this->stackoverflow_parse($answers[$i]["data"]["Answer"]);
					}else{
						
						$description = [];
					}
					
					if(isset($answers[$i]["data"]["Heading"]) && !empty($answers[$i]["data"]["Heading"])){
						
						$title = $this->unescapehtml($answers[$i]["data"]["Heading"]);
					}else{
						
						// no title, ignore bs
						continue;
						//$title = null;
					}
					
					if(isset($answers[$i]["data"]["AbstractURL"]) && !empty($answers[$i]["data"]["AbstractURL"])){
						
						$url = $answers[$i]["data"]["AbstractURL"];
					}else{
						
						$url = null;
					}
					
					$out["answer"][$count] = [
						"title" => $title,
						"description" => $description,
						"url" => $this->sanitizeurl($url),
						"thumb" => $image,
						"table" => [],
						"sublink" => []
					];
					
					if(isset($answers[$i]["data"]["Infobox"]["content"])){
						
						for($k=0; $k<count($answers[$i]["data"]["Infobox"]["content"]); $k++){
							
							// populate table
							if($answers[$i]["data"]["Infobox"]["content"][$k]["data_type"] == "string"){
								
								$out["answer"][$count]["table"][$answers[$i]["data"]["Infobox"]["content"][$k]["label"]] =
									$answers[$i]["data"]["Infobox"]["content"][$k]["value"];
									continue;
							}
							
							$url = "";
							$type = "Website";
												
							switch($answers[$i]["data"]["Infobox"]["content"][$k]["data_type"]){
								case "official_site":
								case "official_website":
									$type = "Website";
									break;
								
								case "wikipedia": $type = "Wikipedia"; break;
								case "itunes": $type = "iTunes"; break;
								case "amazon": $type = "Amazon"; break;
								
								case "imdb_title_id":
								case "imdb_id":
								case "imdb_name_id":
									$type = "IMDb";
									$delim = substr($answers[$i]["data"]["Infobox"]["content"][$k]["value"], 0, 2);
									
									if($delim == "nm"){
										
										$url = "https://www.imdb.com/name/";
									}elseif($delim == "tt"){
										
										$url = "https://www.imdb.com/title/";
									}elseif($delim == "co"){
										
										$url = "https://www.imdb.com/search/title/?companies=";
									}else{
										
										$url = "https://www.imdb.com/title/";
									}
									break;

								case "imdb_name_id": $url = "https://www.imdb.com/name/"; $type = "IMDb"; break;
								case "twitter_profile": $url = "https://twitter.com/"; $type = "Twitter"; break;
								case "instagram_profile": $url = "https://instagram.com/"; $type = "Instagram"; break;
								case "facebook_profile": $url = "https://facebook.com/"; $type = "Facebook"; break;
								case "spotify_artist_id": $url = "https://open.spotify.com/artist/"; $type = "Spotify"; break;
								case "rotten_tomatoes": $url = "https://rottentomatoes.com/"; $type = "Rotten Tomatoes"; break;
								case "youtube_channel": $url = "https://youtube.com/channel/"; $type = "YouTube"; break;
								case "soundcloud_id": $url = "https://soundcloud.com/"; $type = "SoundCloud"; break;
								
								default:
									continue 2;
							}
							
							// populate sublinks
							$out["answer"][$count]["sublink"][$type] =
								$url . $answers[$i]["data"]["Infobox"]["content"][$k]["value"];
						}	
					}
				}
			}
		
		}catch(Exception $e){
			
			// do nothing
		}
		
		/*
			Get shitcoin conversions
		*/
		if($extendedsearch){
			if(
				preg_match(
					'/"https?:\/\/(?:www\.coinbase\.com\/converter\/([a-z0-9]+)\/([a-z0-9]+)|changelly\.com\/exchange\/([a-z0-9]+)\/([a-z0-9]+)|coinmarketcap\.com\/currencies\/[a-z0-9]+\/([a-z0-9]+)\/([a-z0-9]+))\/?"/',
					$js,
					$shitcoins
				)
			){
				
				$shitcoins = array_values(array_filter($shitcoins));
				
				preg_match(
					'/(?:[\s,.]*[0-9]+)+/',
					$search,
					$amount
				);
				
				if(count($amount) === 1){
					
					$amount = (float)str_replace([" ", ","], ["", "."], $amount[0]);
				}else{
					
					$amount = 1;
				}
				
				try{
					
					$description = [];
						
					$shitcoinjs = $this->get(
						$proxy,
						"https://duckduckgo.com/js/spice/cryptocurrency/{$shitcoins[1]}/{$shitcoins[2]}/1",
						[],
						ddg::req_xhr
					);
					
					preg_match(
						'/ddg_spice_cryptocurrency\(\s*({[\S\s]*})\s*\);/',
						$shitcoinjs,
						$shitcoinjson
					);
					
					$shitcoinjson = json_decode($shitcoinjson[1], true);
					
					if(
						!isset($shitcoinjson["error"]) &&
						$shitcoinjson["status"]["error_code"] == 0
					){
						
						$shitcoinjson = $shitcoinjson["data"];
						$array_values = array_values($shitcoinjson["quote"])[0];
						
						if($amount != 1){
							
							// show conversion
							$description[] = [
								"type" => "title",
								"value" => "Conversion"
							];
							
							$description[] = [
								"type" => "text",
								"value" =>
									"{$amount} {$shitcoinjson["name"]} ({$shitcoinjson["symbol"]}) = " . $this->number_format($array_values["price"] * $amount) . " " . strtoupper($shitcoins[2]) . "\n" .
									"{$amount} " . strtoupper($shitcoins[2]) . " = " . $this->number_format((1 / $array_values["price"]) * $amount) . " {$shitcoinjson["symbol"]}"
							];
						}
						
						$description[] = [
							"type" => "title",
							"value" => "Current rates"
						];
						
						// rates
						$description[] = [
							"type" => "text",
							"value" =>
								"1 {$shitcoinjson["name"]} ({$shitcoinjson["symbol"]}) = " . $this->number_format($array_values["price"]) . " " . strtoupper($shitcoins[2]) . "\n" .
								"1 " . strtoupper($shitcoins[2]) . " = " . $this->number_format(1 / $array_values["price"]) . " {$shitcoinjson["symbol"]}"
						];
						
						$description[] = [
							"type" => "quote",
							"value" => "Last fetched: " . date("jS \of F Y @ g:ia", strtotime($shitcoinjson["last_updated"]))
						];
						
						$out["answer"][] = [
							"title" => $shitcoinjson["name"] . " (" . strtoupper($shitcoins[1]) . ") & " . strtoupper($shitcoins[2]) . " market",
							"description" => $description,
							"url" => "https://coinmarketcap.com/converter/" . strtoupper($shitcoins[1]) . "/" . strtoupper($shitcoins[2]) . "/?amt={$amount}",
							"thumb" => null,
							"table" => [],
							"sublink" => []
						];
					}
					
				}catch(Exception $e){
					
					// do nothing
				}
			}else{
				
				/*
					Get currency conversion
				*/
				if(
					preg_match(
						'/"https:\/\/www\.xe\.com\/currencyconverter\/convert\/\?From=([A-Z0-9]+)&To=([A-Z0-9]+)"/',
						$js,
						$currencies
					)
				){
					
					preg_match(
						'/(?:[\s,.]*[0-9]+)+/',
						$search,
						$amount
					);
					
					if(count($amount) === 1){
						
						$amount = (float)str_replace([" ", ","], ["", "."], $amount[0]);
					}else{
						
						$amount = 1;
					}
					
					try{
						$currencyjs = $this->get(
							$proxy,
							"https://duckduckgo.com/js/spice/currency/{$amount}/" . strtolower($currencies[1]) . "/" . strtolower($currencies[2]),
							[],
							ddg::req_xhr
						);
						
						preg_match(
							'/ddg_spice_currency\(\s*({[\S\s]*})\s*\);/',
							$currencyjs,
							$currencyjson
						);
						
						$currencyjson = json_decode($currencyjson[1], true);
						
						if(empty($currencyjson["headers"]["description"])){
							
							$currencyjson = $currencyjson["conversion"];
							$description = [];
							
							if($amount != 1){
								
								$description[] =
									[
										"type" => "title",
										"value" => "Conversion"
									];
								
								$description[] =
									[
										"type" => "text",
										"value" =>
											$this->number_format($currencyjson["from-amount"]) . " {$currencyjson["from-currency-symbol"]} = " .
											$this->number_format($currencyjson["converted-amount"]) . " {$currencyjson["to-currency-symbol"]}"
									];
							}
							
							$description[] =
								[
									"type" => "title",
									"value" => "Current rates"
								];
								
							$description[] =
								[
									"type" => "text",
									"value" =>
										"{$currencyjson["conversion-rate"]}\n" .
										"{$currencyjson["conversion-inverse"]}"
								];
							
							$description[] =
								[
									"type" => "quote",
									"value" => "Last fetched: " . date("jS \of F Y @ g:ia", strtotime($currencyjson["rate-utc-timestamp"]))
								];
							
							$out["answer"][] = [
								"title" =>
									"{$currencyjson["from-currency-name"]} ({$currencyjson["from-currency-symbol"]}) to " .
									"{$currencyjson["to-currency-name"]} ({$currencyjson["to-currency-symbol"]})",
								"description" => $description,
								"url" => "https://www.xe.com/currencyconverter/convert/?Amount={$amount}&From={$currencies[1]}&To={$currencies[2]}",
								"thumb" => null,
								"table" => [],
								"sublink" => []
							];
						}
						
					}catch(Exception $e){
						
						// do nothing
					}
				}
			}
		}
		
		/*
			Get small answer
		*/
		preg_match(
			'/DDG\.ready\(function ?\(\) ?{DDH\.add\(({[\S\s]+}),"index"\)}\)/U',
			$inithtml,
			$smallanswer
		);
		
		if(isset($smallanswer[1])){
			
			$smallanswer = json_decode($smallanswer[1], true);
			
			if(
				!isset($smallanswer["require"]) &&
				isset($smallanswer["data"]["title"])
			){
				
				if(isset($smallanswer["data"]["url"])){
					
					$url = $this->unescapehtml($smallanswer["data"]["url"]);
				}elseif(isset($smallanswer["meta"]["sourceUrl"])){
					
					$url = $this->unescapehtml($smallanswer["meta"]["sourceUrl"]);
				}else{
					
					$url = null;
				}
				
				$out["answer"] = [
					[
						"title" => $this->unescapehtml($smallanswer["data"]["title"]),
						"description" => [],
						"url" => $this->sanitizeurl($url),
						"thumb" => null,
						"table" => [],
						"sublink" => []
					],
					...$out["answer"]
				];
				
				if(isset($smallanswer["data"]["subtitle"])){
					
					$out["answer"][0]["description"][] =
						[
							"type" => "text",
							"value" => isset($smallanswer["data"]["subtitle"]) ? $this->unescapehtml($smallanswer["data"]["subtitle"]) : null
						];
				}
			}
		}
		
		unset($inithtml);
		unset($answers);
		unset($answer_count);
		
		/*
			Get spelling autocorrect
		*/
		
		preg_match(
			'/DDG\.page\.showMessage\(\'spelling\',({[\S\s]+})\)/U',
			$js,
			$spelling
		);
		
		if(isset($spelling[1])){
			
			$spelling = json_decode($spelling[1], true);
			
			switch((int)$spelling["qc"]){
				
				case 1:
				case 3:
				case 5:
					$type = "including";
					break;
				
				default:
					$type = "not_many";
					break;
			}
			
			$out["spelling"] = [
				"type" => $type,
				"using" => $this->unescapehtml(strip_tags($spelling["suggestion"])),
				"correction" => $this->unescapehtml(strip_tags($spelling["recourseText"]))
			];
		}
		
		unset($spelling);
		
		/*
			Get web results
		*/
		preg_match(
			'/DDG\.pageLayout\.load\(\'d\', ?(\[{"[\S\s]*"}])\)/U',
			$js,
			$web
		);
		
		if(isset($web[1])){
			
			try{
				$web = json_decode($web[1], true);
				
				for($i=0; $i<count($web); $i++){
					
					// ignore google placeholder + fake next page
					if(
						isset($web[$i]["t"]) &&
						(
							$web[$i]["t"] == "EOP" ||
							$web[$i]["t"] == "EOF"
						) &&
						strpos($web[$i]["c"], "://www.google.") !== false
					){
						
						break;
					}
					
					// store next page token
					if(isset($web[$i]["n"])){
						
						$out["npt"] = $this->backend->store($web[$i]["n"] . "&biaexp=b&eslexp=a&litexp=c&msvrtexp=b&wrap=1", "web", $proxy);
						continue;
					}
					
					// ignore malformed data
					if(!isset($web[$i]["t"])){
						
						continue;
					}
					
					$sublinks = [];
					
					if(isset($web[$i]["l"])){
						
						for($k=0; $k<count($web[$i]["l"]); $k++){
							
							if(
								!isset($web[$i]["l"][$k]["targetUrl"]) ||
								!isset($web[$i]["l"][$k]["text"])
							){
								
								continue;
							}
							
							array_push(
								$sublinks,
								[
									"title" => $this->titledots($this->unescapehtml($web[$i]["l"][$k]["text"])),
									"date" => null,
									"description" => isset($web[$i]["l"][$k]["snippet"]) ? $this->titledots($this->unescapehtml($web[$i]["l"][$k]["snippet"])) : null,
									"url" => $this->sanitizeurl($web[$i]["l"][$k]["targetUrl"])
								]
							);
						}
					}
					
					if(
						preg_match(
							'/^<span class="result__type">PDF<\/span>/',
							$web[$i]["t"]
						)
					){
						
						$type = "pdf";
						$web[$i]["t"] =
							str_replace(
								'<span class="result__type">PDF</span>',
								"",
								$web[$i]["t"]
							);
					}else{
						
						$type = "web";
					}
					
					if(isset($web[$i]["e"])){
						
						$date = strtotime($web[$i]["e"]);
					}else{
						
						$date = null;
					}
					
					array_push(
						$out["web"],
						[
							"title" => $this->titledots($this->unescapehtml(strip_tags($web[$i]["t"]))),
							"description" => $this->titledots($this->unescapehtml(strip_tags($web[$i]["a"]))),
							"url" => isset($web[$i]["u"]) ? $this->sanitizeurl($web[$i]["u"]) : $this->sanitizeurl($web[$i]["c"]),
							"date" => $date,
							"type" => $type,
							"thumb" =>
								[
									"url" => null,
									"ratio" => null
								],
							"sublink" => $sublinks,
							"table" => []
						]
					);
				}
				
			}catch(Exception $e){
				
				// do nothing
			}
		}
		
		unset($web);
		
		/*
			Get images
		*/
		preg_match(
			'/DDG\.duckbar\.load\(\'images\', ?{[\s\S]*"results":(\[{"[\s\S]*}]),"vqd"/U',
			$js,
			$images
		);
		
		if(isset($images[1])){
			
			try{
				$images = json_decode($images[1], true);
				
				for($i=0; $i<count($images); $i++){
					
					if(
						!isset($images[$i]["title"]) ||
						!isset($images[$i]["image"]) ||
						!isset($images[$i]["thumbnail"]) ||
						!isset($images[$i]["width"]) ||
						!isset($images[$i]["height"])
					){
						
						continue;
					}
					
					$ratio =
						$this->bingratio(
							(int)$images[$i]["width"],
							(int)$images[$i]["height"]
						);
					
					array_push(
						$out["image"],
						[
							"title" => $this->titledots($this->unescapehtml($images[$i]["title"])),
							"source" => [
								[
									"url" => $images[$i]["image"],
									"width" => (int)$images[$i]["width"],
									"height" => (int)$images[$i]["height"]
								],
								[
									"url" => $this->bingimg($images[$i]["thumbnail"]),
									"width" => $ratio[0],
									"height" => $ratio[1]
								]
							],
							"url" => $this->sanitizeurl($images[$i]["url"])
						]
					);
				}
				
			}catch(Exception $e){
				
				// do nothing
			}
		}
		
		unset($images);
		
		/*
			Get videos
		*/
		preg_match(
			'/DDG\.duckbar\.load\(\'videos\', ?{[\s\S]*"results":(\[{"[\s\S]*}]),"vqd"/U',
			$js,
			$videos
		);
		
		if(isset($videos[1])){
			try{
				$videos = json_decode($videos[1], true);
				
				for($i=0; $i<count($videos); $i++){
					
					$cachekey = false;
					
					foreach(["large", "medium", "small"] as &$key){
						
						if(isset($videos[$i]["images"][$key])){
							
							$cachekey = $key;
							break;
						}
					}
					
					if(
						!isset($videos[$i]["title"]) ||
						!isset($videos[$i]["description"]) ||
						$cachekey === false ||
						!isset($videos[$i]["content"])
					){
						
						continue;
					}
					
					array_push(
						$out["video"],
						[
							"title" => $this->titledots($this->unescapehtml($videos[$i]["title"])),
							"description" => $videos[$i]["description"] == "" ? null : $this->titledots($this->unescapehtml($videos[$i]["description"])),
							"date" => $videos[$i]["published"] == "" ? null : strtotime($videos[$i]["published"]),
							"duration" => $videos[$i]["duration"] == 0 ? null : $this->hmstoseconds($videos[$i]["duration"]),
							"views" => $videos[$i]["statistics"]["viewCount"] == 0 ? null : $videos[$i]["statistics"]["viewCount"],
							"thumb" =>
								[
									"url" => $this->bingimg($videos[$i]["images"][$cachekey]),
									"ratio" => "16:9"
								],
							"url" => $this->sanitizeurl($videos[$i]["content"])
						]
					);
				}
				
			}catch(Exception $e){
				
				// do nothing
			}
		}
		
		unset($videos);
		
		/*
			Get news
		*/
		preg_match(
			'/DDG\.duckbar\.load\(\'news\', ?{[\s\S]*"results":(\[{"[\s\S]*}]),"vqd"/U',
			$js,
			$news
		);
		
		if(isset($news[1])){
			try{
				$news = json_decode($news[1], true);
				
				for($i=0; $i<count($news); $i++){
					
					if(
						!isset($news[$i]["title"]) ||
						!isset($news[$i]["excerpt"]) ||
						!isset($news[$i]["url"])
					){
						
						continue;
					}
					
					array_push(
						$out["news"],
						[
							"title" => $this->titledots($this->unescapehtml($news[$i]["title"])),
							"description" => $this->titledots($this->unescapehtml(strip_tags($news[$i]["excerpt"]))),
							"date" => isset($news[$i]["date"]) ? (int)$news[$i]["date"] : null,
							"thumb" =>
								[
									"url" => isset($news[$i]["image"]) ? $news[$i]["image"] : null,
									"ratio" => "16:9"
								],
							"url" => $this->sanitizeurl($news[$i]["url"])
						]
					);
				}
				
			}catch(Exception $e){
				
				// do nothing
			}
		}
		
		return $out;
	}
	
	public function image($get){
		
		if($get["npt"]){
			
			[$npt, $proxy] = $this->backend->get($get["npt"], "images");
			
			try{
				$json = json_decode($this->get(
					$proxy,
					"https://duckduckgo.com/i.js?" . $npt,
					[],
					ddg::req_xhr
				), true);
				
			}catch(Exception $err){
				
				throw new Exception("Failed to get i.js");
			}
			
		}else{
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$date = $get["date"];
			$size = $get["size"];
			$color = $get["color"];
			$type = $get["type"];
			$layout = $get["layout"];
			$license = $get["license"];
			
			$filter = [];
			$get_filters = [
				"q" => $search,
				"iax" => "images",
				"ia" => "images"
			];
			
			if($date != "any"){ $filter[] = "time:$date"; }
			if($size != "any"){ $filter[] = "size:$size"; }
			if($color != "any"){ $filter[] = "color:$color"; }
			if($type != "any"){ $filter[] = "type:$type"; }
			if($layout != "any"){ $filter[] = "layout:$layout"; }
			if($license != "any"){ $filter[] = "license:$license"; }
			
			$filter = implode(",", $filter);
			
			if($filter != ""){
				
				$get_filters["iaf"] = $filter;
			}
			
			switch($nsfw){
				
				case "yes": $get_filters["kp"] = "-2"; break;
				case "no": $get_filters["kp"] = "-1"; break;
			}
			
			try{
				
				$html = $this->get(
					$proxy,
					"https://duckduckgo.com",
					$get_filters,
					ddg::req_web
				);
			}catch(Exception $err){
				
				throw new Exception("Failed to get html");
			}
			
			preg_match(
				'/vqd=([0-9-]+)/',
				$html,
				$vqd
			);
			
			if(!isset($vqd[1])){
				
				throw new Exception("Failed to get vqd token");
			}
			
			$vqd = $vqd[1];
				
			// @TODO: s param = image offset
			$js_params = [
				"l" => $country,
				"o" => "json",
				"q" => $search,
				"vqd" => $vqd
			];
			
			switch($nsfw){
				
				case "yes": $js_params["p"] = "-1"; break;
				case "no": $js_params["p"] = "1"; break;
			}
			
			if(empty($filter)){
				
				$js_params["f"] = "1";
			}else{
				
				$js_params["f"] = $filter;
			}
			
			try{
				$json = json_decode($this->get(
					$proxy,
					"https://duckduckgo.com/i.js",
					$js_params,
					ddg::req_xhr
				), true);
				
			}catch(Exception $err){
				
				throw new Exception("Failed to get i.js");
			}
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		if(isset($json["next"])){
			
			if(!isset($vqd)){
				
				$vqd = array_values($json["vqd"])[0];
			}
			
			$out["npt"] =
				$this->backend->store(
					explode("?", $json["next"])[1] . "&vqd=" .
					$vqd,
					"images",
					$proxy
				);
		}
		
		for($i=0; $i<count($json["results"]); $i++){
			
			$bingimg = $this->bingimg($json["results"][$i]["thumbnail"]);
			$ratio =
				$this->bingratio(
					(int)$json["results"][$i]["width"],
					(int)$json["results"][$i]["height"]
				);
			
			$out["image"][] = [
				"title" => $this->titledots($this->unescapehtml($json["results"][$i]["title"])),
				"source" => [
					[
						"url" => $json["results"][$i]["image"],
						"width" => (int)$json["results"][$i]["width"],
						"height" => (int)$json["results"][$i]["height"]
					],
					[
						"url" => $bingimg,
						"width" => $ratio[0],
						"height" => $ratio[1],
					]
				],
				"url" => $this->sanitizeurl($json["results"][$i]["url"])
			];
		}
		
		return $out;
	}
	
	public function video($get){
		
		if($get["npt"]){
			
			[$npt, $proxy] = $this->backend->get($get["npt"], "videos");
			
			try{
				$json = json_decode($this->get(
					$proxy,
					"https://duckduckgo.com/v.js?" .
					$npt,
					[],
					ddg::req_xhr
				), true);
				
			}catch(Exception $err){
				
				throw new Exception("Failed to get v.js");
			}
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$date = $get["date"];
			$resolution = $get["resolution"];
			$duration = $get["duration"];
			$license = $get["license"];
			
			$filter = [];
			
			$get_filters = [
				"q" => $search,
				"iax" => "videos",
				"ia" => "videos"
			];
			
			switch($nsfw){
				
				case "yes": $get_filters["kp"] = "-2"; break;
				case "no": $get_filters["kp"] = "-1"; break;
			}
			
			if($date != "any"){ $filter[] = "publishedAfter:{$date}"; }
			if($resolution != "any"){ $filter[] = "videoDefinition:{$resolution}"; }
			if($duration != "any"){ $filter[] = "videoDuration:{$duration}"; }
			if($license != "any"){ $filter[] = "videoLicense:{$license}"; }
			
			$filter = implode(",", $filter);
			
			try{
				
				$html = $this->get(
					$proxy,
					"https://duckduckgo.com",
					$get_filters,
					ddg::req_web
				);
			}catch(Exception $err){
				
				throw new Exception("Failed to get html");
			}
			
			preg_match(
				'/vqd=([0-9-]+)/',
				$html,
				$vqd
			);
			
			if(!isset($vqd[1])){
				
				throw new Exception("Failed to get vqd token");
			}
			
			$vqd = $vqd[1];
			
			try{
				$json = json_decode($this->get(
					$proxy,
					"https://duckduckgo.com/v.js",
					[
						"l" => "us-en",
						"o" => "json",
						"sr" => 1,
						"q" => $search,
						"vqd" => $vqd,
						"f" => $filter,
						"p" => $get_filters["kp"]
					],
					ddg::req_xhr
				), true);
				
			}catch(Exception $err){
				
				throw new Exception("Failed to get v.js");
			}
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		if(isset($json["next"])){
			
			$out["npt"] =
				$this->backend->store(
					explode("?", $json["next"])[1],
					"videos",
					$proxy
				);
		}
		
		for($i=0; $i<count($json["results"]); $i++){
			
			$cachekey = false;
			
			foreach(["large", "medium", "small"] as &$key){
				
				if(isset($json["results"][$i]["images"][$key])){
					
					$cachekey = $key;
					break;
				}
			}
			
			if(
				!isset($json["results"][$i]["title"]) ||
				!isset($json["results"][$i]["description"]) ||
				$cachekey === false ||
				!isset($json["results"][$i]["content"])
			){
				
				continue;
			}
			
			array_push(
				$out["video"],
				[
					"title" => $this->titledots($this->unescapehtml($json["results"][$i]["title"])),
					"description" => $json["results"][$i]["description"] == "" ? null : $this->titledots($this->unescapehtml($json["results"][$i]["description"])),
					"author" => [
						"name" => empty($json["results"][$i]["uploader"]) ? null : $this->unescapehtml($json["results"][$i]["uploader"]),
						"url" => null,
						"avatar" => null
					],
					"date" => $json["results"][$i]["published"] == "" ? null : strtotime($json["results"][$i]["published"]),
					"duration" => $json["results"][$i]["duration"] == 0 ? null : $this->hmstoseconds($json["results"][$i]["duration"]),
					"views" => $json["results"][$i]["statistics"]["viewCount"] == 0 ? null : $json["results"][$i]["statistics"]["viewCount"],
					"thumb" => [
						"url" => $this->bingimg($json["results"][$i]["images"][$cachekey]),
						"ratio" => "16:9"
					],
					"url" => $this->sanitizeurl($json["results"][$i]["content"])
				]
			);
		}
		
		return $out;
	}
	
	public function news($get){
		
		if($get["npt"]){
			
			[$req, $proxy] = $this->backend->get($get["npt"], "news");
			
			try{
				
				$json = json_decode($this->get(
					$proxy,
					"https://duckduckgo.com/news.js?" .
					$req,
					[],
					ddg::req_xhr
				), true);
				
			}catch(Exception $err){
				
				throw new Exception("Failed to get news.js");
			}
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$date = $get["date"];
			
			$get_params = [
				"q" => $search,
				"iar" => "news",
				"ia" => "news"
			];
			
			switch($nsfw){
				
				case "yes": $get_filters["kp"] = "-2"; break;
				case "maybe": $get_filters["kp"] = "-1"; break;
				case "no": $get_filters["kp"] = "1"; break;
			}
			
			if($date != "any"){
				
				$get_params["df"] = $date;
			}
			
			try{
				
				$html = $this->get(
					$proxy,
					"https://duckduckgo.com",
					$get_params,
					ddg::req_web
				);
			}catch(Exception $err){
				
				throw new Exception("Failed to get html");
			}
			
			preg_match(
				'/vqd=([0-9-]+)/',
				$html,
				$vqd
			);
			
			if(!isset($vqd[1])){
				
				throw new Exception("Failed to get vqd token");
			}
			
			$vqd = $vqd[1];
			
			try{
				
				$js_params = [
					"l" => $country,
					"o" => "json",
					"noamp" => "1",
					"q" => $search,
					"vqd" => $vqd,
					"p" => $get_filters["kp"]
				];
				
				if($date != "any"){
					
					$js_params["df"] = $date;
				}else{
					
					$js_params["df"] = "";
				}
				
				$json = json_decode($this->get(
					$proxy,
					"https://duckduckgo.com/news.js",
					$js_params,
					ddg::req_xhr
				), true);
				
			}catch(Exception $err){
				
				throw new Exception("Failed to get news.js");
			}
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		if(isset($json["next"])){
			
			$out["npt"] =
				$this->backend->store(
					explode("?", $json["next"])[1],
					"news",
					$proxy
				);
		}
		
		for($i=0; $i<count($json["results"]); $i++){
			
			$out["news"][] = [
				"title" => $this->titledots($this->unescapehtml($json["results"][$i]["title"])),
				"author" => $this->unescapehtml($json["results"][$i]["source"]),
				"description" => $this->titledots($this->unescapehtml(strip_tags($json["results"][$i]["excerpt"]))),
				"date" => $json["results"][$i]["date"],
				"thumb" =>
					[
						"url" => isset($json["results"][$i]["image"]) ? $json["results"][$i]["image"] : null,
						"ratio" => "16:9"
					],
				"url" => $this->sanitizeurl($json["results"][$i]["url"])
			];
		}
		
		return $out;
	}
	
	private function hmstoseconds($time){
		
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
	
	private function titledots($title){
		
		$substr = substr($title, -3);
		
		if(
			$substr == "..." ||
			$substr == "…"
		){
						
			return trim(substr($title, 0, -3));
		}
		
		return trim($title);
	}
	
	private function unescapehtml($str){
		
		return html_entity_decode(
			str_replace(
				[
					"<br>",
					"<br/>",
					"</br>",
					"<BR>",
					"<BR/>",
					"</BR>",
				],
				"\n",
				$str
			),
			ENT_QUOTES | ENT_XML1, 'UTF-8'
		);
	}
	
	private function bingimg($url){
		
		$parse = parse_url($url);
		parse_str($parse["query"], $parts);
		
		return "https://" . $parse["host"] . "/th?id=" . urlencode($parts["id"]);
	}
	
	private function appendtext($payload, &$text, &$index){
		
		if(trim($payload) == ""){
			
			return;
		}
		
		if(
			$index !== 0 &&
			$text[$index - 1]["type"] == "text"
		){
			
			$text[$index - 1]["value"] .= preg_replace('/  $/', " ", $payload);
		}else{
			
			$text[] = [
				"type" => "text",
				"value" => preg_replace('/  $/', " ", $payload)
			];
			$index++;
		}
	}
	
	private function stackoverflow_parse($html){
		
		$i = 0;
		$answer = [];
		
		$this->fuckhtml->load($html);
		
		$tags = $this->fuckhtml->getElementsByTagName("*");
		
		if(count($tags) === 0){
			
			return [
				[
					"type" => "text",
					"value" => htmlspecialchars_decode($html)
				]
			];
		}
		
		foreach($tags as $snippet){
			
			switch($snippet["tagName"]){
				
				case "p":
					$this->fuckhtml->load($snippet["innerHTML"]);
					
					$codetags =
						$this->fuckhtml
						->getElementsByTagName("*");
					
					$tmphtml = $snippet["innerHTML"];
					
					foreach($codetags as $tag){
						
						if(!isset($tag["outerHTML"])){
							
							continue;
						}
						
						$tmphtml =
							explode(
								$tag["outerHTML"],
								$tmphtml,
								2
							);
						
						$value = $this->fuckhtml->getTextContent($tmphtml[0], false, false);
						$this->appendtext($value, $answer, $i);
						
						$type = null;
						switch($tag["tagName"]){
							
							case "code": $type = "inline_code"; break;
							case "em": $type = "italic"; break;
							case "blockquote": $type = "quote"; break;
							default: $type = "text";
						}
						
						if($type !== null){
							$value = $this->fuckhtml->getTextContent($tag, false, false);
							
							if(trim($value) != ""){
								
								$answer[] = [
									"type" => $type,
									"value" => rtrim($value)
								];
								$i++;
							}
						}
						
						if(count($tmphtml) === 2){
							
							$tmphtml = $tmphtml[1] . "\n";
						}else{
							
							break;
						}
					}
					
					if(is_array($tmphtml)){
						
						$tmphtml = $tmphtml[0];
					}
					
					if(strlen($tmphtml) !== 0){
						
						$value = $this->fuckhtml->getTextContent($tmphtml, true, false);
						$this->appendtext($value, $answer, $i);
					}
					break;
				
				case "img":
					$answer[] = [
						"type" => "image",
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$tag["attributes"]["src"]
							)
					];
					$i++;
					break;
				
				case "pre":
					switch($answer[$i - 1]["type"]){
						
						case "text":
						case "italic":
							$answer[$i - 1]["value"] = rtrim($answer[$i - 1]["value"]);
							break;
					}
					
					$answer[] =
						[
							"type" => "code",
							"value" =>
								rtrim(
									$this->fuckhtml
									->getTextContent(
										$snippet,
										true,
										false
									)
								)
						];
					$i++;
					
					break;
				
				case "ol":
					$o = 0;
					
					$this->fuckhtml->load($snippet);
					$li =
						$this->fuckhtml
						->getElementsByTagName("li");
					
					foreach($li as $elem){
						$o++;
						
						$this->appendtext(
							$o . ". " .
							$this->fuckhtml
							->getTextContent(
								$elem
							),
							$answer,
							$i
						);
					}
					break;
			}
		}
		
		if(
			$i !== 0 &&
			$answer[$i - 1]["type"] == "text"
		){
			
			$answer[$i - 1]["value"] = rtrim($answer[$i - 1]["value"]);
		}
		
		return $answer;
	}
	
	private function bstoutf8($bs){
		
		return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $bs);
	}
	
	private function limitnewlines($text){
		
		preg_replace(
			'/(?:[\n\r] *){2,}/m',
			"\n\n",
			$text
		);
		
		return $text;
	}
	
	private function sanitizeurl($url){
		
		// check for domains w/out first short subdomain (ex: www.)
		
		$domain = parse_url($url, PHP_URL_HOST);
		
		$subdomain = preg_replace(
			'/^[A-z0-9]{1,3}\./',
			"",
			$domain
		);
		
		switch($subdomain){
			case "ebay.com.au":
			case "ebay.at":
			case "ebay.ca":
			case "ebay.fr":
			case "ebay.de":
			case "ebay.com.hk":
			case "ebay.ie":
			case "ebay.it":
			case "ebay.com.my":
			case "ebay.nl":
			case "ebay.ph":
			case "ebay.pl":
			case "ebay.com.sg":
			case "ebay.es":
			case "ebay.ch":
			case "ebay.co.uk":
			case "cafr.ebay.ca":
			case "ebay.com":
			case "community.ebay.com":
			case "pages.ebay.com":
				
				// remove ebay tracking elements
				$old_params = parse_url($url, PHP_URL_QUERY);
				parse_str($old_params, $params);
				
				if(isset($params["mkevt"])){ unset($params["mkevt"]); }
				if(isset($params["mkcid"])){ unset($params["mkcid"]); }
				if(isset($params["mkrid"])){ unset($params["mkrid"]); }
				if(isset($params["campid"])){ unset($params["campid"]); }
				if(isset($params["customid"])){ unset($params["customid"]); }
				if(isset($params["toolid"])){ unset($params["toolid"]); }
				if(isset($params["_sop"])){ unset($params["_sop"]); }
				if(isset($params["_dcat"])){ unset($params["_dcat"]); }
				if(isset($params["epid"])){ unset($params["epid"]); }
				if(isset($params["epid"])){ unset($params["oid"]); }
				
				$params = http_build_query($params);
				
				if(strlen($params) === 0){
					$replace = "\?";
				}else{
					$replace = "";
				}
				
				$url = preg_replace(
					"/" . $replace . preg_quote($old_params, "/") . "$/",
					$params,
					$url
				);
				break;
		}
		
		return $url;
	}
	
	private function number_format($number){
		
		$number = explode(".", sprintf('%f', $number));
		
		if(count($number) === 1){
			
			return number_format((float)$number[0], 0, ",", ".");
		}
		
		return number_format((float)$number[0], 0, ",", "") . "." . (string)$number[1];
	}
	
	private function bingratio($width, $height){
		
		$ratio = [
			474 / $width,
			474 / $height
		];
		
		if($ratio[0] < $ratio[1]){
			
			$ratio = $ratio[0];
		}else{
			
			$ratio = $ratio[1];
		}
		
		return [
			floor($width * $ratio),
			floor($height * $ratio)
		];
	}
}
