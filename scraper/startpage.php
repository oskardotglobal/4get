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
						"display" => "Time fetched",
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
		
		if(
			preg_match(
				'/React\.createElement\(UIStartpage\.AppSerpWeb, ?(.+)\),$/m',
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
				
				$out["npt"] =
					$this->backend->store(
						http_build_query(
							[
								"lui" => "english",
								"language" => "english",
								"query" => $str["q"],
								"cat" => "web",
								"sc" => $str["sc"],
								"t" => "device",
								"segment" => "startpage.udog",
								"page" => $str["page"]
							]
						),
						"web",
						$proxy
					);
				
				break;
			}
		}
		
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
							$this->fuckhtml
							->getTextContent(
								$description[0]
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
			
			return $query["piurl"];
		}
		
		return $url;
	}
	
	private function titledots($title){
		
		return trim($title, " .\t\n\r\0\x0B…");
	}
}
