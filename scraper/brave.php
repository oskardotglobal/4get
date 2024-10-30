<?php

class brave{
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		$this->backend = new backend("brave");
	}
	
	public function getfilters($page){
		
		switch($page){
			
			case "web":
				return [
					"country" => [
						"display" => "Country",
						"option" => [
							"all" => "All Regions",
							"ar" => "Argentina",
							"au" => "Australia",
							"at" => "Austria",
							"be" => "Belgium",
							"br" => "Brazil",
							"ca" => "Canada",
							"cl" => "Chile",
							"cn" => "China",
							"dk" => "Denmark",
							"fi" => "Finland",
							"fr" => "France",
							"de" => "Germany",
							"hk" => "Hong Kong",
							"in" => "India",
							"id" => "Indonesia",
							"it" => "Italy",
							"jp" => "Japan",
							"kr" => "Korea",
							"my" => "Malaysia",
							"mx" => "Mexico",
							"nl" => "Netherlands",
							"nz" => "New Zealand",
							"no" => "Norway",
							"pl" => "Poland",
							"pt" => "Portugal",
							"ph" => "Philippines",
							"ru" => "Russia",
							"sa" => "Saudi Arabia",
							"za" => "South Africa",
							"es" => "Spain",
							"se" => "Sweden",
							"ch" => "Switzerland",
							"tw" => "Taiwan",
							"tr" => "Turkey",
							"gb" => "United Kingdom",
							"us" => "United States"
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
					"spellcheck" => [
						"display" => "Spellcheck",
						"option" => [
							"yes" => "Yes",
							"no" => "No"
						]
					]
				];
				break;
			
			case "images":
			case "videos":
			case "news":
				return [
					"country" => [
						"display" => "Country",
						"option" => [
							"all" => "All regions",
							"ar" => "Argentina",
							"au" => "Australia",
							"at" => "Austria",
							"be" => "Belgium",
							"br" => "Brazil",
							"ca" => "Canada",
							"cl" => "Chile",
							"cn" => "China",
							"dk" => "Denmark",
							"fi" => "Finland",
							"fr" => "France",
							"de" => "Germany",
							"hk" => "Hong Kong",
							"in" => "India",
							"id" => "Indonesia",
							"it" => "Italy",
							"jp" => "Japan",
							"kr" => "Korea",
							"my" => "Malaysia",
							"mx" => "Mexico",
							"nl" => "Netherlands",
							"nz" => "New Zealand",
							"no" => "Norway",
							"pl" => "Poland",
							"pt" => "Portugal",
							"ph" => "Philippines",
							"ru" => "Russia",
							"sa" => "Saudi Arabia",
							"za" => "South Africa",
							"es" => "Spain",
							"se" => "Sweden",
							"ch" => "Switzerland",
							"tw" => "Taiwan",
							"tr" => "Turkey",
							"gb" => "United Kingdom",
							"us" => "United States"
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
					"spellcheck" => [
						"display" => "Spellcheck",
						"option" => [
							"yes" => "Yes",
							"no" => "No"
						]
					]
				];
				break;
		}
	}
	
	private function get($proxy, $url, $get = [], $nsfw, $country){
		
		switch($nsfw){
			
			case "yes": $nsfw = "off"; break;
			case "maybe": $nsfw = "moderate"; break;
			case "no": $nsfw = "strict"; break;
		}
		
		if($country == "any"){
			
			$country = "all";
		}
		
		$headers = [
			"User-Agent: " . config::USER_AGENT,
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"Cookie: safesearch={$nsfw}; country={$country}; useLocation=0; summarizer=0",
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
			
			// get next page data
			[$q, $proxy] = $this->backend->get($get["npt"], "web");
			
			$q = json_decode($q, true);
			
			$search = $q["q"];
			$q["spellcheck"] = "0";
			
			$nsfw = $q["nsfw"];
			unset($q["nsfw"]);
			
			$country = $q["country"];
			unset($q["country"]);
			
		}else{
			
			// get _GET data instead
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			if(strlen($search) > 2048){
				
				throw new Exception("Search term is too long!");
			}
			
			$proxy = $this->backend->get_ip();
			$nsfw = $get["nsfw"];
			$country = $get["country"];
			$older = $get["older"];
			$newer = $get["newer"];
			$spellcheck = $get["spellcheck"];
			
			$q = [
				"q" => $search
			];
			
			/*
				Pass older/newer filters to brave
			*/
			if($newer !== false){
				
				$newer = date("Y-m-d", $newer);
				
				if($older === false){
					
					$older = date("Y-m-d", time());
				}
			}
			
			if(
				is_string($older) === false &&
				$older !== false
			){
				
				$older = date("Y-m-d", $older);
				
				if($newer === false){
					
					$newer = "1970-01-02";
				}
			}
			
			if($older !== false){
				
				$q["tf"] = "{$newer}to{$older}";
			}
			
			// spellcheck
			if($spellcheck == "no"){
				
				$q["spellcheck"] = "0";
			}
		}
		/*
		$handle = fopen("scraper/brave.html", "r");
		$html = fread($handle, filesize("scraper/brave.html"));
		fclose($handle);*/
		
		
		try{
			$html =
				$this->get(
					$proxy,
					"https://search.brave.com/search",
					$q,
					$nsfw,
					$country
				);
			
		}catch(Exception $error){
			
			throw new Exception("Could not fetch search page");
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
		
		// load html
		$this->fuckhtml->load($html);
		
		/*
			Get next page "token"
		*/
		$nextpage =
			$this->fuckhtml
			->getElementById(
				"pagination",
				"div"
			);
		
		if($nextpage){
			
			$this->fuckhtml->load($nextpage);
			
			$nextpage =
				$this->fuckhtml
				->getElementsByClassName("btn", "a");
			
			if(count($nextpage) !== 0){
				
				$nextpage =
					$nextpage[count($nextpage) - 1];
				
				if(
					strtolower(
						$this->fuckhtml
						->getTextContent(
							$nextpage
						)
					) == "next"
				){
					
					preg_match(
						'/offset=([0-9]+)/',
						$this->fuckhtml->getTextContent($nextpage["attributes"]["href"]),
						$nextpage
					);
						
					$q["offset"] = (int)$nextpage[1];
					$q["nsfw"] = $nsfw;
					$q["country"] = $country;
					
					$out["npt"] =
						$this->backend->store(
							json_encode($q),
							"web",
							$proxy
						);
				}
			}
		}
		
		$this->fuckhtml->load($html);
		
		$script_disc =
			$this->fuckhtml
			->getElementsByTagName(
				"script"
			);
		
		$grep = [];
		foreach($script_disc as $discs){
			
			preg_match(
				'/const data ?= ?(\[{.*}]);/',
				$discs["innerHTML"],
				$grep
			);
			
			if(isset($grep[1])){
				
				break;
			}
		}
		
		if(!isset($grep[1])){
			
			throw new Exception("Could not grep JavaScript object");
		}
		
		$data =
			rtrim(
				preg_replace(
					'/\(Array\(0\)\)\).*$/',
					"",
					$grep[1]
				),
				" ]"
			) . "]";
		
		$data =
			$this->fuckhtml
			->parseJsObject(
				$data
			);
		unset($grep);
		
		if($data === null){
			
			throw new Exception("Failed to decode JavaScript object");
		}
		
		if(
			isset($data[2]["data"]["title"]) &&
			stripos($data[2]["data"]["title"], "PoW Captcha") !== false
		){
			
			throw new Exception("Brave returned a PoW captcha");
		}
		
		if(!isset($data[1]["data"]["body"]["response"])){
			
			throw new Exception("Brave did not return a result object");
		}
		
		$data = $data[1]["data"]["body"]["response"];
		
		/*
			Get web results
		*/
		if(!isset($data["web"]["results"])){
			
			return $out;
		}
		
		foreach($data["web"]["results"] as $result){
			
			if(
				isset($result["thumbnail"]) &&
				is_array($result["thumbnail"])
			){
				
				$thumb = [
					"ratio" => $result["thumbnail"]["logo"] == "false" ? "16:9" : "1:1",
					"url" => $result["thumbnail"]["original"]
				];
			}else{
				
				$thumb = [
					"ratio" => null,
					"url" => null
				];
			}
			
			// get sublinks
			$sublink = [];
			if(
				isset($result["cluster"]) &&
				is_array($result["cluster"])
			){
				
				foreach($result["cluster"] as $cluster){
					
					$sublink[] = [
						"title" => $this->titledots($cluster["title"]),
						"description" =>
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$cluster["description"]
								)
							),
						"url" => $cluster["url"],
						"date" => null
					];
				}
			}
			
			// more sublinks
			if(
				isset($result["deep_results"]) &&
				is_array($result["deep_results"])
			){
				
				foreach($result["deep_results"]["buttons"] as $r){
					
					$sublink[] = [
						"title" => $this->titledots($r["title"]),
						"description" => null,
						"url" => $r["url"],
						"date" => null
					];
				}
			}
			
			// parse table elements
			$table = [];
			
			/*
			[locations] => void 0			Done
			[video] => void 0				Done
			[movie] => void 0				Done
			[faq] => void 0
			[recipe] => void 0
			[qa] => void 0					Not needed
			[book] => void 0
			[rating] => void 0
			[article] => void 0
			[product] => void 0				Done
			[product_cluster] => void 0
			[cluster_type] => void 0
			[cluster] => void 0				Done
			[creative_work] => void 0		Done
			[music_recording] => void 0
			[review] => void 0				Done
			[software] => void 0			Done
			[content_type] => void 0
			[descriptionLength] => 271
			*/
			
			// product
			// creative_work
			$ref = null;
			
			if(isset($result["product"])){
				
				$ref = &$result["product"];
			}elseif(isset($result["creative_work"])){
				
				$ref = &$result["creative_work"];
			}
			
			if($ref !== null){
				
				if(isset($ref["offers"])){
					
					foreach($ref["offers"] as $offer){
						
						$price = null;
						
						if(isset($offer["price"])){
							
							if((float)$offer["price"] == 0){
								
								$price = "Free";
							}else{
								
								$price = $offer["price"];
							}
						}
						
						if($price !== "Free"){
							if(isset($offer["priceCurrency"])){
								
								$price .= " " . $offer["priceCurrency"];
							}
						}
						
						if($price !== null){
							
							$table["Price"] = trim($price);
						}
					}
				}
				
				if(isset($ref["rating"])){
					
					$rating = null;
					if(isset($ref["rating"]["ratingValue"])){
						
						$rating = $ref["rating"]["ratingValue"];
						
						if(isset($ref["rating"]["bestRating"])){
							
							$rating .= "/" . $ref["rating"]["bestRating"];
						}
					}
					
					if(isset($ref["rating"]["reviewCount"])){
						
						$isnull = $rating === null ? false : true;
						
						if($isnull){
							
							$rating .= " (";
						}
						
						$rating .= number_format($ref["rating"]["reviewCount"]) . " hits";
						
						if($isnull){
							
							$rating .= ")";
						}
					}
					
					if($rating !== null){
						
						$table["Rating"] = $rating;
					}
				}
			}
			
			// review
			if(
				isset($result["review"]) &&
				is_array($result["review"])
			){
				
				if(isset($result["review"]["rating"]["ratingValue"])){
					
					$table["Rating"] =
						$result["review"]["rating"]["ratingValue"] . "/" .
						$result["review"]["rating"]["bestRating"];
				}
			}
			
			// software
			if(
				isset($result["software"]) &&
				is_array($result["software"])
			){
				
				if(isset($result["software"]["author"])){
					$table["Author"] = $result["software"]["author"];
				}
				
				if(isset($result["software"]["stars"])){
					$table["Stars"] = number_format($result["software"]["stars"]);
				}
				
				if(isset($result["software"]["forks"])){
					$table["Forks"] = number_format($result["software"]["forks"]);
				}
				
				if(
					isset($result["software"]["programmingLanguage"]) &&
					$result["software"]["programmingLanguage"] != ""
				){
					$table["Programming languages"] = $result["software"]["programmingLanguage"];
				}
			}
			
			// location
			if(
				isset($result["location"]) &&
				is_array($result["location"])
			){
				
				if(isset($result["location"]["postal_address"]["displayAddress"])){
					
					$table["Address"] = $result["location"]["postal_address"]["displayAddress"];
				}
				
				if(isset($result["location"]["rating"])){
					
					$table["Rating"] =
						$result["location"]["rating"]["ratingValue"] . "/" .
						$result["location"]["rating"]["bestRating"] . " (" .
						number_format($result["location"]["rating"]["reviewCount"]) . " votes)";
				}
				
				if(isset($result["location"]["contact"]["telephone"])){
					
					$table["Phone number"] =
						$result["location"]["contact"]["telephone"];
				}
				
				if(isset($result["location"]["price_range"])){
					
					$table["Price"] =
						$result["location"]["price_range"];
				}
			}
			
			// video
			if(
				isset($result["video"]) &&
				is_array($result["video"])
			){
				
				foreach($result["video"] as $key => $value){
					
					if(is_string($result["video"][$key]) === false){
						
						continue;
					}
					
					$table[ucfirst($key)] = $value;
				}
			}
			
			// movie
			if(
				isset($result["video"]) &&
				is_array($result["movie"])
			){
				
				if(isset($result["movie"]["release"])){
					
					$table["Release date"] = $result["movie"]["release"];
				}
				
				if(isset($result["movie"]["directors"])){
					
					$directors = [];
					
					foreach($result["movie"]["directors"] as $director){
						
						$directors[] = $director["name"];
					}
					
					if(count($directors) !== 0){
						
						$table["Directors"] = implode(", ", $directors);
					}
				}
				
				if(isset($result["movie"]["actors"])){
					
					$actors = [];
					
					foreach($result["movie"]["actors"] as $actor){
						
						$actors[] = $actor["name"];
					}
					
					if(count($actors) !== 0){
						$table["Actors"] = implode(", ", $actors);
					}
				}
				
				if(isset($result["movie"]["rating"])){
					
					$table["Rating"] =
						$result["movie"]["rating"]["ratingValue"] . "/" .
						$result["movie"]["rating"]["bestRating"] . " (" .
						number_format($result["movie"]["rating"]["reviewCount"]) . " votes)";
				}
				
				if(isset($result["movie"]["duration"])){
					
					$table["Duration"] =
						$result["movie"]["duration"];
				}
				
				if(isset($result["movie"]["genre"])){
					
					$genres = [];
					
					foreach($result["movie"]["genre"] as $genre){
						
						$genres[] = $genre;
					}
					
					if(count($genres) !== 0){
						$table["Genre"] = implode(", ", $genres);
					}
				}
			}
			
			if(
				isset($result["age"]) &&
				$result["age"] != "void 0" &&
				$result["age"] != ""
			){
				
				$date = strtotime($result["age"]);
			}else{
				
				$date = null;
			}
			
			$out["web"][] = [
				"title" =>
					$this->titledots(
						$result["title"]
					),
				"description" =>
					isset($result["review"]["description"]) ?
					$this->limitstrlen(
						strip_tags(
							$result["review"]["description"]
						)
					) :
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$result["description"]
						)
					),
				"url" => $result["url"],
				"date" => $date,
				"type" => "web",
				"thumb" => $thumb,
				"sublink" => $sublink,
				"table" => $table
			];
		}
		
		/*
			Get spelling autocorrect
		*/
		if(
			isset($data["query"]["bo_altered_diff"][0][0]) &&
			$data["query"]["bo_altered_diff"][0][0] == "true"
		){
			$using = [];
			
			foreach($data["query"]["bo_altered_diff"] as $diff){
				
				$using[] = $diff[1];
			}
			
			$out["spelling"] = [
				"type" => "including",
				"using" => implode(" ", $using),
				"correction" => $get["s"]
			];
		}
		
		/*
			Get wikipedia heads
		*/
		if(isset($data["infobox"]["results"][0])){
			
			foreach($data["infobox"]["results"] as $info){
				
				if($info["subtype"] == "code"){
					
					$description =
						$this->stackoverflow_parse($info["data"]["answer"]["text"]);
					
					if(isset($info["data"]["answer"]["author"])){
						
						$description[] = [
							"type" => "quote",
							"value" => "Answer from " . $info["data"]["answer"]["author"]
						];
					}
				}else{
					
					$description = [];
					
					if(
						isset($info["description"]) &&
						$info["description"] != ""
					){
						$description[] = [
							"type" => "quote",
							"value" => $info["description"]
						];
					}
					
					if(
						isset($info["long_desc"]) &&
						$info["long_desc"] != ""
					){
						$description[] = [
							"type" => "text",
							"value" => $this->titledots($info["long_desc"])
						];
					}
					
					// parse ratings
					if(
						isset($info["ratings"]) &&
						$info["ratings"] != "void 0" &&
						is_array($info["ratings"]) &&
						count($info["ratings"]) !== 0
					){
						
						$description[] = [
							"type" => "title",
							"value" => "Ratings"
						];
						
						foreach($info["ratings"] as $rating){
							
							$description[] = [
								"type" => "link",
								"url" => $rating["profile"]["url"],
								"value" => $rating["profile"]["name"]
							];
							
							$description[] = [
								"type" => "text",
								"value" => ": " . $rating["ratingValue"] . "/" . $rating["bestRating"] . "\n"
							];
						}
					}
				}
				
				$table = [];
				if(isset($info["attributes"])){
					
					foreach($info["attributes"] as $row){
						
						if(
							$row[1] == "null" &&
							count($table) !== 0
						){
							
							break;
						}
						
						if($row[1] == "null"){
							
							continue;
						}
						
						$table[
							$this->fuckhtml->getTextContent($row[0])
						] =
							$this->fuckhtml->getTextContent($row[1]);
					}
				}
				
				$sublink = [];
				if(isset($info["profiles"])){
					
					foreach($info["profiles"] as $row){
						
						$name = $this->fuckhtml->getTextContent($row["name"]);
						
						if(strtolower($name) == "steampowered"){
							
							$name = "Steam";
						}
						
						$sublink[
							$this->fuckhtml->getTextContent($name)
						] =
							$this->fuckhtml->getTextContent($row["url"]);
					}
				}
				
				$out["answer"][] = [
					"title" => $this->fuckhtml->getTextContent($info["title"]),
					"description" => $description,
					"url" => $info["url"],
					"thumb" => isset($info["images"][0]["original"]) ? $info["images"][0]["original"] : null,
					"table" => $table,
					"sublink" => $sublink
				];
				
				break; // only iterate once, we get garbage most of the time
			}
		}
		
		/*
			Get videos
		*/
		if(isset($data["videos"]["results"])){
			
			foreach($data["videos"]["results"] as $video){
				
				$out["video"][] = [
					"title" => $this->titledots($video["title"]),
					"description" => $this->titledots($video["description"]),
					"date" => isset($video["age"]) && $video["age"] != "void 0" ? strtotime($video["age"]) : null,
					"duration" => isset($video["video"]["duration"]) && $video["video"]["duration"] != "void 0" ? $this->hms2int($video["video"]["duration"]) : null,
					"views" => isset($video["video"]["views"]) && $video["video"]["views"] != "void 0" ? (int)$video["video"]["views"] : null,
					"thumb" =>
						isset($video["thumbnail"]["src"]) ?
						[
							"ratio" => "16:9",
							"url" => $this->unshiturl($video["thumbnail"]["src"])
						] :
						[
							"ratio" => null,
							"url" => null
						],
					"url" => $video["url"]
				];
			}
		}
		
		/*
			Get news
		*/
		if(isset($data["news"]["results"])){
			
			foreach($data["news"]["results"] as $news){
				
				$out["news"][] = [
					"title" => $this->titledots($news["title"]),
					"description" => $this->titledots($news["description"]),
					"date" => isset($news["age"]) ? strtotime($news["age"]) : null,
					"thumb" =>
						isset($video["thumbnail"]["src"]) ?
						[
							"ratio" => "16:9",
							"url" => $this->unshiturl($video["thumbnail"]["src"])
						] :
						[
							"ratio" => null,
							"url" => null
						],
					"url" => $news["url"]
				];
			}
		}
		
		/*
			Get discussions
		*/
		$disc_out = [];
		
		if(isset($data["discussions"]["results"])){
			
			foreach($data["discussions"]["results"] as $disc){
				
				$table = [];
				
				if(isset($disc["data"]["num_votes"])){
					
					$table["Votes"] = number_format($disc["data"]["num_votes"]);
				}
				
				if(isset($disc["data"]["num_answers"])){
					
					$table["Comments"] = number_format($disc["data"]["num_answers"]);
				}
				
				$disc_out[] = [
					"title" =>
						$this->titledots(
							$disc["title"]
						),
					"description" =>
						$this->limitstrlen(
							$this->titledots(
								$this->fuckhtml
								->getTextContent(
									$disc["description"]
								)
							)
						),
					"url" => $disc["url"],
					"date" => isset($disc["age"]) ? strtotime($disc["age"]) : null,
					"type" => "web",
					"thumb" => [
						"ratio" => null,
						"url" => null
					],
					"sublink" => [],
					"table" => $table
				];
			}
		}
		
		// append discussions at position 2
		array_splice($out["web"], 1, 0, $disc_out);
		
		return $out;
	}
	
	public function news($get){
		
		if($get["npt"]){
			
			[$req, $proxy] = $this->backend->get($get["npt"], "news");
			
			$req = json_decode($req, true);
			
			$search = $req["q"];
			$country = $req["country"];
			$nsfw = $req["nsfw"];
			$offset = $req["offset"];
			$spellcheck = $req["spellcheck"];
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://search.brave.com/news",
						[
							"q" => $search,
							"offset" => $offset,
							"spellcheck" => $spellcheck
						],
						$nsfw,
						$country
					);
				
			}catch(Exception $error){
				
				throw new Exception("Could not fetch search page");
			}
			
		}else{
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			if(strlen($search) > 2048){
				
				throw new Exception("Search term is too long!");
			}
			
			$proxy = $this->backend->get_ip();
			$nsfw = $get["nsfw"];
			$country = $get["country"];
			$spellcheck = $get["spellcheck"] == "yes" ? "1" : "0";
			
			/*
			$handle = fopen("scraper/brave-news.html", "r");
			$html = fread($handle, filesize("scraper/brave-news.html"));
			fclose($handle);*/
			try{
				$html =
					$this->get(
						$proxy,
						"https://search.brave.com/news",
						[
							"q" => $search,
							"spellcheck" => $spellcheck
						],
						$nsfw,
						$country
					);
				
			}catch(Exception $error){
				
				throw new Exception("Could not fetch search page");
			}
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		// load html
		$this->fuckhtml->load($html);
		
		// get npt
		$out["npt"] =
			$this->generatenextpagetoken(
				$search,
				$nsfw,
				$country,
				$spellcheck,
				"news",
				$proxy
			);
		
		preg_match(
			'/const data ?= ?(\[{.*}]);/',
			$html,
			$json
		);
		
		if(!isset($json[1])){
			
			throw new Exception("Failed to grep javascript object");
		}
		
		$json = $this->fuckhtml->parseJsObject($json[1], true);
		
		if($json === null){
			
			throw new Exception("Failed to parse javascript object");
		}
		
		foreach(
			$json[1]["data"]["body"]["response"]["news"]["results"]
			as $news
		){
			
			if(
				!isset($news["thumbnail"]["src"]) ||
				$news["thumbnail"]["src"] == "void 0"
			){
								
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}else{
								
				$thumb = [
					"url" => $this->unshiturl($news["thumbnail"]["src"]),
					"ratio" => "16:9"
				];
			}
			
			$out["news"][] = [
				"title" => $news["title"],
				"author" => null,
				"description" => $news["description"],
				"date" => !isset($news["age"]) || $news["age"] == "void 0" || $news["age"] == "null" ? null : strtotime($news["age"]),
				"thumb" => $thumb,
				"url" => $news["url"]
			];
		}
		
		return $out;
	}
	
	public function image($get){
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
		if(strlen($search) > 2048){
			
			throw new Exception("Search term is too long!");
		}
		
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		$spellcheck = $get["spellcheck"] == "yes" ? "1" : "0";
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		try{
			$html =
				$this->get(
					$this->backend->get_ip(), // no nextpage right now, pass proxy directly
					"https://search.brave.com/images",
					[
						"q" => $search,
						"spellcheck" => $spellcheck
					],
					$nsfw,
					$country
				);
			
		}catch(Exception $error){
			
			throw new Exception("Could not fetch search page");
		}
		/*
		$handle = fopen("scraper/brave-image.html", "r");
		$html = fread($handle, filesize("scraper/brave-image.html"));
		fclose($handle);*/
		
		preg_match(
			'/const data = (\[{.*}\]);/',
			$html,
			$json
		);
		
		if(!isset($json[1])){
			
			throw new Exception("Failed to get data object");
		}
		
		$json =
			$this->fuckhtml
			->parseJsObject(
				$json[1]
			);
		
		foreach(
			$json[1]
			["data"]
			["body"]
			["response"]
			["results"]
			as $result
		){
			
			$out["image"][] = [
				"title" => $result["title"],
				"source" => [
					[
						"url" => $result["properties"]["url"],
						"width" => null,
						"height" => null
					],
					[
						"url" => $result["thumbnail"]["src"],
						"width" => null,
						"height" => null
					]
				],
				"url" => $result["url"]
			];
		}
		
		return $out;
	}
	
	public function video($get){
		
		if($get["npt"]){
			
			[$npt, $proxy] = $this->backend->get($get["npt"], "videos");
			
			$npt = json_decode($npt, true);
			$search = $npt["q"];
			$offset = $npt["offset"];
			$spellcheck = $npt["spellcheck"];
			$country = $npt["country"];
			$nsfw = $npt["nsfw"];
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://search.brave.com/videos",
						[
							"q" => $search,
							"offset" => $offset,
							"spellcheck" => $spellcheck
						],
						$nsfw,
						$country
					);
				
			}catch(Exception $error){
				
				throw new Exception("Could not fetch search page");
			}
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			if(strlen($search) > 2048){
				
				throw new Exception("Search term is too long!");
			}
			
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$spellcheck = $get["spellcheck"] == "yes" ? "1" : "0";
			
			$proxy = $this->backend->get_ip();
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://search.brave.com/videos",
						[
							"q" => $search,
							"spellcheck" => $spellcheck
						],
						$nsfw,
						$country
					);
				
			}catch(Exception $error){
				
				throw new Exception("Could not fetch search page");
			}
		}
		
		$this->fuckhtml->load($html);
		
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
		$out["npt"] =
			$this->generatenextpagetoken(
				$search,
				$nsfw,
				$country,
				$spellcheck,
				"videos",
				$proxy
			);
		
		/*
		$handle = fopen("scraper/brave-video.html", "r");
		$html = fread($handle, filesize("scraper/brave-video.html"));
		fclose($handle);*/
		
		preg_match(
			'/const data = (\[{.*}\]);/',
			$html,
			$json
		);
		
		if(!isset($json[1])){
			
			throw new Exception("Failed to get data object");
		}
		
		$json =
			$this->fuckhtml
			->parseJsObject(
				$json[1]
			);
		
		foreach(
			$json
			[1]
			["data"]
			["body"]
			["response"]
			["results"]
			as $result
		){
			
			if($result["video"]["author"] != "null"){
				
				$author = [
					"name" => $result["video"]["author"]["name"] == "null" ? null : $result["video"]["author"]["name"],
					"url" => $result["video"]["author"]["url"] == "null" ? null : $result["video"]["author"]["url"],
					"avatar" => $result["video"]["author"]["img"] == "null" ? null : $result["video"]["author"]["img"]
				];
			}else{
				
				$author = [
					"name" => null,
					"url" => null,
					"avatar" => null
				];
			}
			
			if($result["thumbnail"] != "null"){
				
				$thumb = [
					"url" => $result["thumbnail"]["original"],
					"ratio" => "16:9"
				];
			}else{
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}
			
			$out["video"][] = [
				"title" => $result["title"],
				"description" => $result["description"] == "null" ? null : $this->titledots($result["description"]),
				"author" => $author,
				"date" => ($result["age"] == "null" || $result["age"] == "void 0") ? null : strtotime($result["age"]),
				"duration" => $result["video"]["duration"] == "null" ? null : $this->hms2int($result["video"]["duration"]),
				"views" => $result["video"]["views"] == "null" ? null : (int)$result["video"]["views"],
				"thumb" => $thumb,
				"url" => $result["url"]
			];
		}

		return $out;
	}
	
	private function stackoverflow_parse($html){
		
		$i = 0;
		$answer = [];
		
		$this->fuckhtml->load($html);
		
		foreach(
			$this->fuckhtml->getElementsByTagName("*")
			as $snippet
		){
			
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
							$value = $this->fuckhtml->getTextContent($tag, false, true);
							
							if(trim($value) != ""){
								
								if(
									$i !== 0 &&
									$type == "title"
								){
									
									$answer[$i - 1]["value"] = rtrim($answer[$i - 1]["value"]);
								}
								
								$answer[] = [
									"type" => $type,
									"value" => $value
								];
								$i++;
							}
						}
						
						if(count($tmphtml) === 2){
							
							$tmphtml = $tmphtml[1];
						}else{
							
							break;
						}
					}
					
					if(is_array($tmphtml)){
						
						$tmphtml = $tmphtml[0];
					}
					
					if(strlen($tmphtml) !== 0){
						
						$value = $this->fuckhtml->getTextContent($tmphtml, false, false);
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
	
	private function appendtext($payload, &$text, &$index){
		
		if(trim($payload) == ""){
			
			return;
		}
		
		if(
			$index !== 0 &&
			$text[$index - 1]["type"] == "text"
		){
			
			$text[$index - 1]["value"] .= "\n\n" . preg_replace('/  $/', " ", $payload);
		}else{
			
			$text[] = [
				"type" => "text",
				"value" => preg_replace('/  $/', " ", $payload)
			];
			$index++;
		}
	}
	
	private function tablesublink($html_collection, &$data){
		
		foreach($html_collection as $html){
			
			$html["innerHTML"] = preg_replace(
				'/<style>[\S\s]*<\/style>/i',
				"",
				$html["innerHTML"]
			);
			
			$html =
				explode(
					":",
					$this->fuckhtml->getTextContent($html),
					2
				);
			
			if(count($html) === 1){
				
				$html = ["Rating", $html[0]];
			}
			
			$data["table"][trim($html[0])] = trim($html[1]);
		}
	}
	/*
	private function getimagelinkfromstyle($thumb){
		
		$thumb =
			$this->fuckhtml
			->getElementsByClassName(
				$thumb,
				"div"
			);
		
		if(count($thumb) === 0){
			
			return [
				"url" => null,
				"ratio" => null
			];
		}
		
		$thumb = $thumb[0]["attributes"]["style"];
		
		preg_match(
			'/background-image: ?url\((\'[^\']+\'|"[^"]+"|[^\)]+)\)/',
			$thumb,
			$thumb
		);
		
		$url = $this->fuckhtml->getTextContent($this->unshiturl(trim($thumb[1], '"\' ')));
		
		if(parse_url($url, PHP_URL_HOST) == "cdn.search.brave.com"){
			
			return [
				"url" => null,
				"ratio" => null
			];
		}
		
		return [
			"url" => $url,
			"ratio" => "16:9"
		];
	}*/
	
	private function limitstrlen($text){
		
		return explode("\n", wordwrap($text, 300, "\n"))[0];
	}
	/*
	private function limitwhitespace($text){
		
		return
			preg_replace(
				'/[\s]+/',
				" ",
				$text
			);
	}*/
	
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
	
	private function generatenextpagetoken($q, $nsfw, $country, $spellcheck, $page, $proxy){
		
		$nextpage =
			$this->fuckhtml
			->getElementsByClassName("btn", "a");
		
		if(count($nextpage) !== 0){
			
			$nextpage =
				$nextpage[count($nextpage) - 1];
			
			if(
				strtolower(
					$this->fuckhtml
					->getTextContent(
						$nextpage
					)
				) == "next"
			){
				
				preg_match(
					'/offset=([0-9]+)/',
					$this->fuckhtml->getTextContent($nextpage["attributes"]["href"]),
					$nextpage
				);
				
				return
					$this->backend->store(
						json_encode(
							[
								"q" => $q,
								"offset" => (int)$nextpage[1],
								"nsfw" => $nsfw,
								"country" => $country,
								"spellcheck" => $spellcheck
							]
						),
						$page,
						$proxy
					);
			}
		}
		
		return null;
	}
	
	private function unshiturl($url){
		
		// https://imgs.search.brave.com/XFnbR8Sl7ge82MBDEH7ju0UHImRovMVmQ2qnDvgNTuA/rs:fit:844:225:1/g:ce/aHR0cHM6Ly90c2U0/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC54/UWotQXU5N2ozVndT/RDJnNG9BNVhnSGFF/SyZwaWQ9QXBp.jpeg
		
		$tmp = explode("aHR0", $url);
		
		if(count($tmp) !== 2){
			
			// nothing to do
			return $url;
		}
		
		return
			base64_decode(
				"aHR0" .
				str_replace(["/", "_"], ["", "/"],
					explode(
						".",
						$tmp[1]
					)[0]
				)
			);
	}
}
