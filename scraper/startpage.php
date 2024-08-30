<?php

class startpage{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("startpage");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		switch($page){
			case "web":
				return [
					"country" => [
						"display" => "Country",
						"option" => [
							"any" => "All Regions",
							"es_AR" => "Argentina",
							"en_AU" => "Australia",
							"de_AT" => "Austria",
							"ru_BY" => "Belarus",
							"fr_BE" => "Belgium (FR)",
							"nl_BE" => "Belgium (NL)",
							"bg_BG" => "Bulgaria",
							"en_CA" => "Canada (EN)",
							"fr_CA" => "Canada (FR)",
							"es_CL" => "Chile",
							"es_CO" => "Colombia",
							"cs_CZ" => "Czech Republic",
							"da_DK" => "Denmark",
							"ar_EG" => "Egypt",
							"et_EE" => "Estonia",
							"fi_FI" => "Finland",
							"fr_FR" => "France",
							"de_DE" => "Germany",
							"el_GR" => "Greece",
							"hu_HU" => "Hungary",
							"hi_IN" => "India (HI)",
							"en_IN" => "India (EN)",
							"id_ID" => "Indonesia (ID)",
							"en_ID" => "Indonesia (EN)",
							"en_IE" => "Ireland",
							"it_IT" => "Italy",
							"ja_JP" => "Japan",
							"ko_KR" => "Korea",
							"ms_MY" => "Malaysia (MS)",
							"en_MY" => "Malaysia (EN)",
							"es_MX" => "Mexico",
							"nl_NL" => "Netherlands",
							"en_NZ" => "New Zealand",
							"no_NO" => "Norway",
							"es_PE" => "Peru",
							"fil_PH" => "Philippines (FIL)",
							"en_PH" => "Philippines (EN)",
							"pl_PL" => "Poland",
							"pt_PT" => "Portugal",
							"ro_RO" => "Romania",
							"ru_RU" => "Russia",
							"ms_SG" => "Singapore (MS)",
							"en_SG" => "Singapore (EN)",
							"es_ES" => "Spain (ES)",
							"ca_ES" => "Spain (CA)",
							"sv_SE" => "Sweden",
							"de_CH" => "Switzerland (DE)",
							"fr_CH" => "Switzerland (FR)",
							"it_CH" => "Switzerland (IT)",
							"tr_TR" => "Turkey",
							"uk_UA" => "Ukraine",
							"en_US" => "US (EN)",
							"es_US" => "US (ES)",
							"es_UY" => "Uruguay",
							"es_VE" => "Venezuela",
							"vi_VN" => "Vietnam (VI)",
							"en_VN" => "Vietnam (EN)",
							"en_ZA" => "South Africa"
						]
					],
					"nsfw" => [ // qadf
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes", // qadf=none
							"no" => "No" // qadf=heavy
						]
					],
					"time" => [ // with_date
						"display" => "Time posted",
						"option" => [
							"any" => "Any time",
							"d" => "Past 24 hours",
							"w" => "Past week",
							"m" => "Past month",
							"y" => "Past year",
						]
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
				return [
					"nsfw" => [ // qadf
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes", // qadf=none
							"no" => "No" // qadf=heavy
						]
					],
					"size" => [ // flimgsize
						"display" => "Size",
						"option" => [
							"any" => "Any size",
							"Small" => "Small",
							"Medium" => "Medium",
							"Large" => "Large",
							"Wallpaper" => "Wallpaper",
							// from here, image-size-select, var prefix = isz:lt,islt:
							"qsvgs" => "Larger than 400x300",
							"vga" => "Larger than 640x480",
							"svga" => "Larger than 800x600",
							"xga" => "Larger than 1024x768",
							"qsvgs" => "Larger than 400x300",
							"2mp" => "Larger than 2 MP (1600x1200)",
							"4mp" => "Larger than 4 MP (2272x1704)",
							"6mp" => "Larger than 6 MP (2816x2112)",
							"8mp" => "Larger than 8 MP (3264x2448)",
							"10mp" => "Larger than 10 MP (3648x2736)",
							"12mp" => "Larger than 12 MP (4096x3072)",
							"15mp" => "Larger than 15 MP (4480x3360)",
							"20mp" => "Larger than 20 MP (5120x3840)",
							"40mp" => "Larger than 40 MP (7216x5412)",
							"70mp" => "Larger than 70 MP (9600x7200)"
						]
					],
					"color" => [ // flimgcolor
						"display" => "Color",
						"option" => [
							"any" => "Any color",
							// from here, var prefix = ic:
							"color" => "Color only",
							"bnw" => "Black & white", // set to "gray"
							// from here, var prefix = ic:specific,isc:
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
					"type" => [ // flimgtype
						"display" => "Type",
						"option" => [
							"any" => "Any type",
							"AnimatedGif" => "Animated GIF",
							"Clipart" => "Clip Art",
							"Line" => "Line Drawing",
							"Photo" => "Photograph",
							"Transparent" => "Transparent Background"
						]
					],
					"license" => [ // flimglicense
						"display" => "License",
						"option" => [
							"any" => "Any license",
							"p" => "Public domain",
							"s" => "Free to share",
							"sc" => "Free to share commercially",
							"m" => "Free to modify",
							"mc" => "Free to modify commercially"
						]
					]
				];
				break;
			
			case "videos":
				return [
					"nsfw" => [ // qadf
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes", // qadf=none
							"no" => "No" // qadf=heavy
						]
					],
					"sort" => [
						"display" => "Sort by",
						"option" => [
							"relevance" => "Most relevant",
							"popular" => "Most popular",
							"recent" => "Most recent"
						]
					],
					"duration" => [ // with_duration
						"display" => "Duration",
						"option" => [
							"any" => "Any duration",
							"short" => "Short",
							"medium" => "Medium",
							"long" => "Long"
						]
					]
				];
				break;
			
			case "news":
				return [
					"nsfw" => [ // qadf
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes", // qadf=none
							"no" => "No" // qadf=heavy
						]
					],
					"time" => [ // with_date
						"display" => "Time posted",
						"option" => [
							"any" => "Any time",
							"d" => "Past 24 hours",
							"w" => "Past week",
							"m" => "Past month"
						]
					]
				];
				break;
				
				//preferences=date_timeEEEworldN1Ndisable_family_filterEEE1N1Ndisable_open_in_new_windowEEE0N1Nenable_post_methodEEE1N1Nenable_proxy_safety_suggestEEE0N1Nenable_stay_controlEEE0N1Ninstant_answersEEE1N1Nlang_homepageEEEs%2Fdevice%2FenN1NlanguageEEEazerbaijaniN1Nlanguage_uiEEEenglishN1Nnum_of_resultsEEE20N1Nsearch_results_regionEEEallN1NsuggestionsEEE1N1Nwt_unitEEEcelsius; Domain=startpage.com; Expires=Mon, 28 Oct 2024 20:21:58 GMT; Secure; Path=/
				//preferences=date_timeEEEworldN1Ndisable_family_filterEEE1N1Ndisable_open_in_new_windowEEE0N1Nenable_post_methodEEE1N1Nenable_proxy_safety_suggestEEE0N1Nenable_stay_controlEEE0N1Ninstant_answersEEE1N1Nlang_homepageEEEs%2Fdevice%2FenN1NlanguageEEEenglishN1Nlanguage_uiEEEenglishN1Nnum_of_resultsEEE20N1Nsearch_results_regionEEEallN1NsuggestionsEEE1N1Nwt_unitEEEcelsius; Domain=startpage.com; Expires=Mon, 28 Oct 2024 20:22:52 GMT; Secure; Path=/
		}
	}
	
	private function get($proxy, $url, $get = [], $post = false, $is_xhr = false){
		
		$curlproc = curl_init();
		
		if($post === true){
			
			curl_setopt($curlproc, CURLOPT_POST, true);
			curl_setopt($curlproc, CURLOPT_POSTFIELDS, $get);
			
		}elseif($get !== []){
			
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		// http2 bypass
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
		if($is_xhr === true){
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: application/json",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"Referer: https://www.startpage.com/",
				"Content-Type: application/json",
				"Content-Length: " . strlen($get),
				"Origin: https://www.startpage.com/",
				"DNT: 1",
				"Connection: keep-alive",
				"Cookie: preferences=date_timeEEEworldN1Ndisable_family_filterEEE1N1Ndisable_open_in_new_windowEEE0N1Nenable_post_methodEEE1N1Nenable_proxy_safety_suggestEEE0N1Nenable_stay_controlEEE0N1Ninstant_answersEEE1N1Nlang_homepageEEEs%2Fdevice%2FenN1NlanguageEEEenglishN1Nlanguage_uiEEEenglishN1Nnum_of_resultsEEE20N1Nsearch_results_regionEEEallN1NsuggestionsEEE1N1Nwt_unitEEEcelsius",
				"Sec-Fetch-Dest: empty",
				"Sec-Fetch-Mode: cors",
				"Sec-Fetch-Site: same-origin",
				"TE: trailers"]
			);
			
		}elseif($post === true){
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"Referer: https://www.startpage.com/",
				"Content-Type: application/x-www-form-urlencoded",
				"Content-Length: " . strlen($get),
				"DNT: 1",
				"Connection: keep-alive",
				"Cookie: preferences=date_timeEEEworldN1Ndisable_family_filterEEE1N1Ndisable_open_in_new_windowEEE0N1Nenable_post_methodEEE1N1Nenable_proxy_safety_suggestEEE0N1Nenable_stay_controlEEE0N1Ninstant_answersEEE1N1Nlang_homepageEEEs%2Fdevice%2FenN1NlanguageEEEenglishN1Nlanguage_uiEEEenglishN1Nnum_of_resultsEEE20N1Nsearch_results_regionEEEallN1NsuggestionsEEE1N1Nwt_unitEEEcelsius",
				"Upgrade-Insecure-Requests: 1",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: none",
				"Sec-Fetch-User: ?1",
				"Priority: u=0, i",
				"TE: trailers"]
			);
		}else{
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"DNT: 1",
				"Connection: keep-alive",
				"Cookie: preferences=date_timeEEEworldN1Ndisable_family_filterEEE1N1Ndisable_open_in_new_windowEEE0N1Nenable_post_methodEEE1N1Nenable_proxy_safety_suggestEEE0N1Nenable_stay_controlEEE0N1Ninstant_answersEEE1N1Nlang_homepageEEEs%2Fdevice%2FenN1NlanguageEEEenglishN1Nlanguage_uiEEEenglishN1Nnum_of_resultsEEE20N1Nsearch_results_regionEEEallN1NsuggestionsEEE1N1Nwt_unitEEEcelsius",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: none",
				"Sec-Fetch-User: ?1",
				"Priority: u=0, i",
				"TE: trailers"]
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
		
		if($get["npt"]){
			
			[$post, $proxy] = $this->backend->get($get["npt"], "web");
			
			try{
				$html = $this->get(
					$proxy,
					"https://www.startpage.com/sp/search",
					$post,
					true
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
			$get_instant_answer = false;
			
		}else{
			
			$proxy = $this->backend->get_ip();
			
			$params = [
				"query" => $get["s"],
				"cat" => "web",
				"pl" => "opensearch"
			];
			
			if($get["nsfw"] == "no"){
				
				$params["qadf"] = "heavy";
				$get_instant_answer = false;
			}else{
				
				$get_instant_answer = true;
			}
			
			if($get["country"] !== "any"){
				
				$params["qsr"] = $get["country"];
			}
			
			if($get["time"] !== "any"){
				
				$params["with_date"] = $get["time"];
			}
			
			try{
				$html = $this->get(
					$proxy,
					"https://www.startpage.com/sp/search",
					$params
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
			//$html = file_get_contents("scraper/startpage.html");
		}
		
		$this->detect_captcha($html);
		
		if(
			preg_match(
				'/React\.createElement\(UIStartpage\.AppSerpWeb, ?(.+)\),?$/m',
				$html,
				$matches
			) === 0
		){
			
			throw new Exception("Failed to grep JSON object");
		}
		
		$json = json_decode($matches[1], true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		//print_r($json);
		
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
		
		// get npt
		$out["npt"] = $this->parse_npt($json, "web", $proxy);
		
		foreach($json["render"]["presenter"]["regions"]["mainline"] as $category){
			
			if(!isset($category["display_type"])){
				
				continue;
			}
			
			switch($category["display_type"]){
				
				case "web-google":
					foreach($category["results"] as $result){
						
						$sublinks = [];
						
						foreach($result["siteLinks"] as $sublink){
							
							$sublinks[] = [
								"title" => $sublink["title"],
								"description" => null,
								"url" => $sublink["clickUrl"]
							];
						}
						
						$description =
							explode(
								"...",
								$this->titledots(
									html_entity_decode(
										$this->fuckhtml
										->getTextContent(
											$result["description"]
										)
									)
								),
								2
							);
						
						$date = strtotime(trim($description[0]));
						
						if(
							$date === false ||
							count($description) !== 2 ||
							strlen($description[0]) > 14
						){
							
							// no date found
							$description =
								implode(
									" ... ",
									$description
								);
							
							$date = null;
						}else{
							
							// date found
							$description = ltrim($description[1]);
						}
						
						$out["web"][] = [
							"title" =>
								$this->titledots(
									html_entity_decode(
										$this->fuckhtml
										->getTextContent(
											$result["title"]
										)
									)
								),
							"description" => $description,
							"url" => $result["clickUrl"],
							"date" => $date,
							"type" => "web",
							"thumb" => [
								"url" => null,
								"ratio" => null
							],
							"sublink" => $sublinks,
							"table" => []
						];
					}
					break;
				
				case "images-qi-top":
					foreach($category["results"] as $result){
						
						$out["image"][] = [
							"title" =>
								$this->titledots(
									html_entity_decode(
										$this->fuckhtml
										->getTextContent(
											$result["title"]
										)
									)
								),
							"source" => [
								[
									"url" => $result["rawImageUrl"],
									"width" => (int)$result["width"],	
									"height" => (int)$result["height"]
								],
								[
									"url" => $this->unshitimage($result["mdThumbnailUrl"]),
									"width" => (int)$result["mdThumbnailWidth"],
									"height" => (int)$result["mdThumbnailHeight"]
								]
							],
							"url" =>
								$result["altClickUrl"]
						];
					}
					break;
				
				case "spellsuggest-google":
					$out["spelling"] =
						[
							"type" => "including",
							"using" => $json["render"]["query"],
							"correction" => $category["results"][0]["query"]
						];
					break;
				
				case "dictionary-qi":
					foreach($category["results"] as $result){
						
						$answer = [
							"title" => $result["word"],
							"description" => [],
							"url" => null,
							"thumb" => null,
							"table" => [],
							"sublink" => []
						];
						
						foreach($result["lexical_categories"] as $lexic_type => $definitions){
							
							$answer["description"][] = [
								"type" => "title",
								"value" => $lexic_type
							];
							
							$i = 0;
							
							foreach($definitions as $definition){
								
								$text_definition = trim($definition["definition"]);
								$text_example = trim($definition["example"]);
								$text_synonyms = implode(", ", $definition["synonyms"]);
								
								if($text_definition != ""){
									
									$i++;
									
									$c = count($answer["description"]) - 1;
									if(
										$c !== 0 &&
										$answer["description"][$c]["type"] == "text"
									){
										
										$answer["description"][$c]["value"] .=
											"\n\n" . $i . ". " . $text_definition;
										
									}else{
										
										$answer["description"][] = [
											"type" => "text",
											"value" => $i . ". " . $text_definition
										];
									}
								}
								
								if($text_example != ""){
									
									$answer["description"][] = [
										"type" => "quote",
										"value" => $text_example
									];
								}
								
								if($text_synonyms != ""){
									
									$answer["description"][] = [
										"type" => "text",
										"value" => "Synonyms: " . $text_synonyms
									];
								}
							}
						}
						
						$out["answer"][] = $answer;
					}
					break;
			}
		}
		
		// parse instant answers
		if(
			$get["extendedsearch"] == "yes" &&
			$get_instant_answer === true
		){
			
			// https://www.startpage.com/sp/qi?qimsn=ex&sxap=%2Fv1%2Fquery&sc=BqZ3inqrAgF701&sr=1
			try{
				$post = [
					"se" => "n0vze2y9dqwy",
					"q" => $json["render"]["query"],
					"results" => [], // populate
					"enableKnowledgePanel" => true,
					"enableMediaThumbBar" => false,
					"enableSearchSuggestions" => false,
					"enableTripadvisorProperties" => [],
					"enableTripadvisorPlaces" => [],
					"enableTripadvisorPlacesForLocations" => [],
					"enableWebProducts" => false,
					"tripadvisorPartnerId" => null,
					"tripadvisorMapColorMode" => "light",
					"tripadvisorDisablesKnowledgePanel" => false,
					"instantAnswers" => [
						"smartAnswers",
						"youtube",
						"tripadvisor"
					],
					"iaType" => null,
					"forceEnhancedKnowledgePanel" => false,
					"shoppingOnly" => false,
					"allowAdultProducts" => true,
					"lang" => "en",
					"browserLang" => "en-US",
					"browserTimezone" => "America/New_York",
					"market" => null,
					"userLocation" => null,
					"userDate" => date("Y-m-d"),
					"userAgentType" => "unknown"
				];
				
				foreach($out["web"] as $result){
					
					$post["results"][] = [
						"url" => $result["url"],
						"title" => $result["title"]
					];
				}
				
				$post = json_encode($post, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);
				
				$additional_data =
					$this->get(
						$proxy,
						"https://www.startpage.com/sp/qi?qimsn=ex&sxap=%2Fv1%2Fquery&sc=" . $json["render"]["callback_sc"] . "&sr=1",
						$post,
						true,
						true
					);
				
				$additional_data = json_decode($additional_data, true);
				
				if($additional_data === null){
					
					throw new Exception("Failed to decode JSON"); // just break out, dont fail completely
				}
				
				if(!isset($additional_data["knowledgePanel"])){
					
					throw new Exception("Response has missing data (knowledgePanel)");
				}
				
				$additional_data = $additional_data["knowledgePanel"];
				
				$answer = [
					"title" => $additional_data["meta"]["title"],
					"description" => [
						[
							"type" => "quote",
							"value" => $additional_data["meta"]["description"]
						]
					],
					"url" => $additional_data["meta"]["origWikiUrl"],
					"thumb" => $additional_data["meta"]["image"],
					"table" => [],
					"sublink" => []
				];
				
				// parse html for instant answer
				$this->fuckhtml->load($additional_data["html"]);
				
				$div =
					$this->fuckhtml
					->getElementsByTagName(
						"div"
					);
				
				// get description
				$description =
					$this->fuckhtml
					->getElementsByClassName(
						"sx-kp-short-extract sx-kp-short-extract-complete",
						$div
					);
				
				if(count($description) !== 0){
					
					$answer["description"][] = [
						"type" => "text",
						"value" =>
							html_entity_decode(
								$this->fuckhtml
								->getTextContent(
									$description[0]
								)
							)
					];
				}
				
				// get socials
				$socials =
					$this->fuckhtml
					->getElementsByClassName(
						"sx-wiki-social-link",
						"a"
					);
				
				foreach($socials as $social){
					
					$title =
						$this->fuckhtml
						->getTextContent(
							$social["attributes"]["title"]
						);
					
					$url =
						$this->fuckhtml
						->getTextContent(
							$social["attributes"]["href"]
						);
					
					switch($title){
						
						case "Official Website":
							$title = "Website";
							break;
					}
					
					$answer["sublink"][$title] = $url;
				}
				
				// get videos
				$videos =
					$this->fuckhtml
					->getElementsByClassName(
						"sx-kp-video-grid-item",
						$div
					);
				
				foreach($videos as $video){
					
					$this->fuckhtml->load($video);
					
					$as =
						$this->fuckhtml
						->getElementsByTagName(
							"a"
						);
					
					if(count($as) === 0){
						
						// ?? invalid
						continue;
					}
					
					$image =
						$this->fuckhtml
						->getElementsByAttributeName(
							"data-sx-src",
							"img"
						);
					
					if(count($image) !== 0){
						
						$thumb = [
							"ratio" => "16:9",
							"url" =>
								$this->fuckhtml
								->getTextContent(
									$image[0]["attributes"]["data-sx-src"]
								)
						];
					}else{

						$thumb = [
							"ratio" => null,
							"url" => null
						];
					}
					
					$out["video"][] = [
						"title" =>
							$this->fuckhtml
							->getTextContent(
								$as[0]["attributes"]["title"]
							),
						"description" => null,
						"date" => null,
						"duration" => null,
						"views" => null,
						"thumb" => $thumb,
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$as[0]["attributes"]["href"]
							)
					];
				}
				
				// reset
				$this->fuckhtml->load($additional_data["html"]);
				
				// get table elements
				$table =
					$this->fuckhtml
					->getElementsByClassName(
						"sx-infobox",
						"table"
					);
				
				if(count($table) !== 0){
					
					$trs =
						$this->fuckhtml
						->getElementsByTagName(
							"tr"
						);
					
					foreach($trs as $tr){
						
						$this->fuckhtml->load($tr);
						
						// ok so startpage devs cant fucking code a table
						// td = content
						// th (AAAHH) = title
						$tds =
							$this->fuckhtml
							->getElementsByTagName(
								"td"	
							);
						
						$ths =
							$this->fuckhtml
							->getElementsByTagName(
								"th"
							);
						
						if(
							count($ths) === 1 &&
							count($tds) === 1
						){
							
							$title =
								$this->fuckhtml
								->getTextContent(
									$ths[0]
								);
							
							$description = [];
							
							$this->fuckhtml->load($tds[0]);
							
							$lis =
								$this->fuckhtml
								->getElementsByTagName(
									"li"
								);
							
							if(count($lis) !== 0){
								
								foreach($lis as $li){
									
									$description[] =
										$this->fuckhtml
										->getTextContent(
											$li
										);
								}
								
								$description = implode(", ", $description);
							}else{
								
								$description =
									$this->fuckhtml
									->getTextContent(
										$tds[0]
									);
							}
							
							$answer["table"][$title] = $description;
						}
					}
				}
				
				$out["answer"][] = $answer;
				
			}catch(Exception $error){
				
				// do nothing
				//echo "error!";
			}
		}
		
		return $out;
	}
	
	public function image($get){
		
		if($get["npt"]){
			
			[$post, $proxy] = $this->backend->get($get["npt"], "images");
			
			try{
				$html = $this->get(
					$proxy,
					"https://www.startpage.com/sp/search",
					$post,
					true
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			try{
				
				$proxy = $this->backend->get_ip();
				
				$params = [
					"query" => $get["s"],
					"cat" => "images",
					"pl" => "opensearch"
				];
				
				if($get["nsfw"] == "no"){
					
					$params["qadf"] = "heavy";
				}
				
				if($get["size"] != "any"){
					
					if(
						$get["size"] == "Small" ||
						$get["size"] == "Medium" ||
						$get["size"] == "Large" ||
						$get["size"] == "Wallpaper"
					){
						
						$params["flimgsize"] = $get["size"];
					}else{
						
						$params["image-size-select"] = "isz:lt,islt:" . $get["size"];
					}
				}
				
				if($get["color"] != "any"){
					
					if($get["color"] == "color"){
						
						$params["flimgcolor"] = "ic:color";
					}elseif($get["color"] == "bnw"){
						
						$params["flimgcolor"] = "ic:gray";
					}else{
						
						$params["flimgcolor"] = "ic:specific,isc:" . $get["color"];
					}
				}
				
				if($get["type"] != "any"){
					
					$params["flimgtype"] = $get["type"];
				}
				
				if($get["license"] != "any"){
					
					$params["flimglicense"] = $get["license"];
				}
				
				try{
					$html = $this->get(
						$proxy,
						"https://www.startpage.com/sp/search",
						$params
					);
				}catch(Exception $error){
					
					throw new Exception("Failed to fetch search page");
				}
				//$html = file_get_contents("scraper/startpage.html");
				
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
		}
		
		$this->detect_captcha($html);
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		if(
			preg_match(
				'/React\.createElement\(UIStartpage\.AppSerpImages, ?(.+)\),?$/m',
				$html,
				$matches
			) === 0
		){
			
			throw new Exception("Failed to grep JSON object");
		}
		
		$json = json_decode($matches[1], true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON object");
		}
		
		// get npt
		$out["npt"] = $this->parse_npt($json, "images", $proxy);
		
		// get images
		foreach($json["render"]["presenter"]["regions"]["mainline"] as $category){
			
			if($category["display_type"] != "images-bing"){
				
				// ignore ads and !! suggestions !! @todo
				continue;
			}
			
			foreach($category["results"] as $image){
				
				$out["image"][] = [
					"title" => $this->titledots($image["title"]),
					"source" => [
						[
							"url" => $this->unshitimage($image["clickUrl"]),
							"width" => (int)$image["width"],
							"height" => (int)$image["height"]
						],
						[
							"url" => $this->unshitimage($image["thumbnailUrl"]),
							"width" => (int)$image["thumbnailWidth"],
							"height" => (int)$image["thumbnailHeight"]
						]
					],
					"url" => $image["altClickUrl"]
				];
			}
		}
		
		return $out;
	}
	
	public function video($get){
		
		if($get["npt"]){
			
			[$post, $proxy] = $this->backend->get($get["npt"], "videos");
			
			try{
				$html = $this->get(
					$proxy,
					"https://www.startpage.com/sp/search",
					$post,
					true
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			try{
				
				$proxy = $this->backend->get_ip();
				
				$params = [
					"query" => $get["s"],
					"cat" => "video",
					"pl" => "opensearch"
				];
				
				if($get["nsfw"] == "no"){
					
					$params["qadf"] = "heavy";
				}
				
				if($get["sort"] != "relevance"){
					
					$params["sort_by"] = $get["sort"];
				}
				
				if($get["duration"] != "any"){
					
					$params["with_duration"] = $get["duration"];
				}
				
				try{
					$html = $this->get(
						$proxy,
						"https://www.startpage.com/sp/search",
						$params
					);
				}catch(Exception $error){
					
					throw new Exception("Failed to fetch search page");
				}
				//$html = file_get_contents("scraper/startpage.html");
				
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
		}
		
		$this->detect_captcha($html);
		
		if(
			preg_match(
				'/React\.createElement\(UIStartpage\.AppSerpVideos, ?(.+)\),?$/m',
				$html,
				$matches
			) === 0
		){
			
			throw new Exception("Failed to get JSON object");
		}
		
		$json = json_decode($matches[1], true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON object");
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
		
		// get npt
		$out["npt"] = $this->parse_npt($json, "video", $proxy);
		
		// get results
		foreach($json["render"]["presenter"]["regions"]["mainline"] as $category){
			
			if($category["display_type"] == "video-youtube"){
				
				foreach($category["results"] as $video){
					
					if(
						isset($video["thumbnailUrl"]) &&
						$video["thumbnailUrl"] !== null
					){
						
						$thumb = [
							"ratio" => "16:9",
							"url" => $this->unshitimage($video["thumbnailUrl"])
						];
					}else{
						
						$thumb = [
							"ratio" => null,
							"url" => null
						];
					}
					
					$out["video"][] = [
						"title" => $video["title"],
						"description" => $this->limitstrlen($video["description"]),
						"author" => [
							"name" => $video["channelTitle"],
							"url" => null,
							"avatar" => null
						],
						"date" => strtotime($video["publishDate"]),
						"duration" => $this->hms2int($video["duration"]),
						"views" => (int)$video["viewCount"],
						"thumb" => $thumb,
						"url" => $video["clickUrl"]
					];
				}
			}
		}
		
		return $out;
	}
	
	public function news($get){
		
		if($get["npt"]){
			
			[$post, $proxy] = $this->backend->get($get["npt"], "news");
			
			try{
				$html = $this->get(
					$proxy,
					"https://www.startpage.com/sp/search",
					$post,
					true
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			try{
				
				$proxy = $this->backend->get_ip();
				
				$params = [
					"query" => $get["s"],
					"cat" => "news",
					"pl" => "opensearch"
				];
								
				if($get["nsfw"] == "no"){
					
					$params["qadf"] = "heavy";
				}
				
				if($get["time"] != "any"){
					
					$params["with_date"] = $get["time"];
				}
				
				try{
					$html = $this->get(
						$proxy,
						"https://www.startpage.com/sp/search",
						$params
					);
				}catch(Exception $error){
					
					throw new Exception("Failed to fetch search page");
				}
				//$html = file_get_contents("scraper/startpage.html");
				
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
		}
		
		$this->detect_captcha($html);
		
		if(
			preg_match(
				'/React\.createElement\(UIStartpage\.AppSerpNews, ?(.+)\),?$/m',
				$html,
				$matches
			) === 0
		){
			
			throw new Exception("Failed to get JSON object");
		}
		
		$json = json_decode($matches[1], true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON object");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		// get npt
		$out["npt"] = $this->parse_npt($json, "news", $proxy);
		
		foreach($json["render"]["presenter"]["regions"]["mainline"] as $category){
			
			if($category["display_type"] != "news-bing"){
				
				// unsupported category
				continue;
			}
			
			foreach($category["results"] as $news){
				
				if(
					isset($news["thumbnailUrl"]) &&
					$news["thumbnailUrl"] !== null
				){
					
					$thumb = [
						"ratio" => "16:9",
						"url" => $this->unshitimage($news["thumbnailUrl"])
					];
				}else{
					
					$thumb = [
						"ratio" => null,
						"url" => null
					];
				}
				
				$out["news"][] = [
					"title" => $this->titledots($this->remove_penguins($news["title"])),
					"author" => $news["source"],
					"description" => $this->titledots($this->remove_penguins($news["description"])),
					"date" => (int)substr((string)$news["date"], 0, -3),
					"thumb" => $thumb,
					"url" => $news["clickUrl"]
				];
			}
		}
		
		return $out;
	}
	
	private function parse_npt($json, $pagetype, $proxy){
		
		foreach($json["render"]["presenter"]["pagination"]["pages"] as $page){
			
			if($page["name"] == "Next"){
				
				parse_str(
					explode(
						"?",
						$page["url"],
						2
					)[1],
					$str
				);
				
				return
					$this->backend->store(
						http_build_query(
							[
								"lui" => "english",
								"language" => "english",
								"query" => $str["q"],
								"cat" => $pagetype,
								"sc" => $str["sc"],
								"t" => "device",
								"segment" => "startpage.udog",
								"page" => $str["page"]
							]
						),
						$pagetype,
						$proxy
					);
				
				break;
			}
		}
		
		return null;
	}
	
	private function unshitimage($url){
		
		$query = parse_url($url, PHP_URL_QUERY);
		parse_str($query, $query);
		
		if(isset($query["piurl"])){
			
			if(strpos($query["piurl"], "gstatic.com/")){
				
				return
					explode(
						"&",
						$query["piurl"],
						2
					)[0];
			}
			
			if(
				strpos($query["piurl"], "bing.net/") ||
				strpos($query["piurl"], "bing.com/")
			){
				
				return
					explode(
						"&",
						$query["piurl"],
						2
					)[0];
			}
			
			return $query["piurl"];
		}
		
		return $url;
	}
	
	private function limitstrlen($text){
		
		return
			explode(
				"\n",
				wordwrap(
					str_replace(
						["\n\r", "\r\n", "\n", "\r"],
						" ",
						$text
					),
					300,
					"\n"
				),
				2
			)[0];
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
	
	private function remove_penguins($text){
		
		return str_replace(
			["", ""],
			"",
			$text
		);
	}
	
	private function detect_captcha($html){
		
		$this->fuckhtml->load($html);
		
		$title =
			$this->fuckhtml
			->getElementsByTagName(
				"title"
			);
		
		if(
			count($title) !== 0 &&
			$title[0]["innerHTML"] == "Redirecting..."
		){
			
			// check if it's a captcha
			$as =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			foreach($as as $a){
				
				if(
					strpos(
						$this->fuckhtml
						->getTextContent(
							$a["innerHTML"]
						),
						"https://www.startpage.com/sp/captcha"
					) !== false
				){
					
					throw new Exception("Startpage returned a captcha");
				}
			}
			
			throw new Exception("Startpage redirected the scraper to an unhandled page");
		}
	}
}
