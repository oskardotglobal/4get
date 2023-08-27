<?php

class brave{
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("brave");
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
					]
				];
				break;
		}
	}
	
	private function get($url, $get = [], $nsfw, $country){
		
		switch($nsfw){
			
			case "yes": $nsfw = "off"; break;
			case "maybe": $nsfw = "moderate"; break;
			case "no": $nsfw = "strict"; break;
		}
		
		if($country == "any"){
			
			$country = "all";
		}
		
		$headers = [
			"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:107.0) Gecko/20100101 Firefox/110.0",
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
			$q = json_decode($this->nextpage->get($get["npt"], "web"), true);
			
			$search = $q["q"];
			$q["spellcheck"] = 0;
			
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
				
				throw new Exception("Search query is too long!");
			}
			
			$nsfw = $get["nsfw"];
			$country = $get["country"];
			$older = $get["older"];
			$newer = $get["newer"];
			
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
		}
		/*
		$handle = fopen("scraper/brave.html", "r");
		$html = fread($handle, filesize("scraper/brave.html"));
		fclose($handle);
		*/
		try{
			$html =
				$this->get(
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
			->getElementsByClassName(
				"btn ml-15",
				"a"
			);
		
		if(count($nextpage) !== 0){
			
			preg_match(
				'/offset=([0-9]+)/',
				$this->fuckhtml->getTextContent($nextpage[0]["attributes"]["href"]),
				$nextpage
			);
				
			$q["offset"] = (int)$nextpage[1];
			$q["nsfw"] = $nsfw;
			$q["country"] = $country;
			
			$out["npt"] =	
				$this->nextpage->store(
					json_encode($q),
					"web"
				);
		}
		
		/*
			Get discussions (and append them to web results)
		*/
		
		// they're loaded using javascript!!
		$discussion =
			$this->fuckhtml
			->getElementById(
				"js-discussions",
				"script"
			);
		
		if(
			$discussion &&
			isset($discussion["attributes"]["data"])
		){
			
			$discussion =
				json_decode(
					$this->fuckhtml
					->getTextContent(
						$discussion["attributes"]["data"]
					),
					true
				);
			
			foreach($discussion["results"] as $result){
				
				$data = [
					"title" => $this->titledots($result["title"]),
					"description" => null,
					"url" => $result["url"],
					"date" => null,
					"type" => "web",
					"thumb" => [
						"url" => null,
						"ratio" => null
					],
					"sublink" => [],
					"table" => []
				];
				
				// description
				$data["description"] =
					$this->limitstrlen(
						$this->limitwhitespace(
							$this->titledots(
								$this->fuckhtml->getTextContent(
									$result["description"]
								)
							)
						)
					);
				
				if($result["age"] != ""){
					$data["date"] = strtotime($result["age"]);
				}
				
				// populate table
				
				if($result["data"]["num_answers"] != ""){
					$data["table"]["Replies"] = (int)$result["data"]["num_answers"];
				}
				
				if($result["data"]["score"] != ""){
					
					$score = explode("|", $result["data"]["score"]);
					
					if(count($score) === 2){
						
						$score = ((int)$score[1]) . " (" . trim($score[0]) . ")";
					}else{
						
						$score = (int)$score[0];
					}
					
					$data["table"]["Votes"] = $score;
				}
				
				if($result["thumbnail"] != ""){
					
					$data["thumb"]["url"] = $result["thumbnail"];
					$data["thumb"]["ratio"] = "16:9";
				}
				
				$out["web"][] = $data;
			}
		}
		
		/*
			Get related searches
		*/
		$faq =
			$this->fuckhtml
			->getElementById("js-faq", "script");
		
		if(
			$faq &&
			isset($faq["attributes"]["data"])
		){
			
			$faq =
				json_decode(
					$this->fuckhtml
					->getTextContent(
						$faq["attributes"]["data"]
					),
					true
				);
			
			foreach($faq["items"] as $related){
				
				$out["related"][] = $related["question"];
			}
		}
		
		/*
			Get spelling autocorrect
		*/
		$altered =
			$this->fuckhtml
			->getElementById("altered-query", "div");
		
		if($altered){
			
			$this->fuckhtml->load($altered);
			
			$altered =
				$this->fuckhtml
				->getElementsByTagName("a");
			
			if(count($altered) === 2){
				
				$out["spelling"] = [
					"type" => "including",
					"using" =>
						$this->fuckhtml
						->getTextContent($altered[0]),
					"correction" =>
						$this->fuckhtml
						->getTextContent($altered[1])
				];
			}
			
			$this->fuckhtml->load($html);
		}
		
		/*
			Get web results
		*/
		$resulthtml =
			$this->fuckhtml
			->getElementById(
				"results",
				"div"
			);
		
		$this->fuckhtml->load($resulthtml);
		$items = 0;
		foreach(
			$this->fuckhtml
			->getElementsByClassName("snippet fdb")
			as $result
		){
			
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
			
			if(
				isset($result["attributes"]["data-type"]) &&
				$result["attributes"]["data-type"] == "ad"
			){
				
				// is an ad, skip
				continue;
			}
			
			$this->fuckhtml->load($result);
			
			/*
				Get title
			*/
			$title =
				$this->fuckhtml
				->getElementsByClassName(
					"snippet-title",
					"span"
				);
			
			if(count($title) === 0){
				
				// encountered AI summarizer
				// or misspelling indicator @TODO
				continue;
			}
			
			if(isset($title[0]["attributes"]["title"])){
				
				$data["title"] =
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$title[0]["attributes"]["title"]
						)
					);
			}else{
				
				$data["title"] =
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$title[0]
						)
					);
			}
			
			/*
				Get description
			*/
			$description =
				$this->fuckhtml
				->getElementsByClassName(
					"snippet-description",
					"p"
				);
			
			if(count($description) !== 0){
				$data["description"] =
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$description[0]
						)
					);
				
				// also check for thumbnail in here
				$img =
					$this->fuckhtml
					->getElementsByClassName(
						"thumb",
						"img"
					);
				
				if(count($img) !== 0){
					
					$data["thumb"] = [
						"url" => $this->unshiturl($img[0]["attributes"]["src"]),
						"ratio" => "16:9"
					];
				}else{
					
					// might be a video thumbnail wrapper?
					$wrapper =
						$this->fuckhtml
						->getElementsByClassName(
							"video-thumb",
							"a"
						);
					
					if(count($wrapper) !== 0){
						
						// we found a video
						$this->fuckhtml->load($wrapper[0]);
						
						$img =
							$this->fuckhtml
							->getElementsByTagName("img");
						
						$data["thumb"] = [
							"url" => $this->unshiturl($img[0]["attributes"]["src"]),
							"ratio" => "16:9"
						];
						
						// get the video length, if its there
						$duration =
							$this->fuckhtml
							->getElementsByClassName(
								"duration",
								"div"
							);
						
						if(count($duration) !== 0){
							
							$data["table"]["Duration"] = $duration[0]["innerHTML"];
						}
						
						// reset html load
						$this->fuckhtml->load($result);
					}
				}
				
			}else{
				
				// is a steam/shop listing
				$description_alt =
					$this->fuckhtml
					->getElementsByClassName(
						"text-sm",
						"div"
					);
				
				if(count($description_alt) !== 0){
					
					switch($description_alt[0]["attributes"]["class"]){
						
						case "text-sm text-gray":
						case "description text-sm":
							
							$data["description"] =
								$this->titledots(
									$this->fuckhtml
									->getTextContent(
										$description_alt[0]
									)
								);
							break;
					}
					
					// get table sublink
					$sublink =
						$this->fuckhtml
						->getElementsByClassName(
							"r-attr text-sm",
							"div"
						);
					
					if(count($sublink) !== 0){
						
						$this->tablesublink($sublink, $data);
					}
					
					// check for thumb element
					$data["thumb"] = $this->getimagelinkfromstyle("thumb");
				}else{
					
					// ok... finally...
					// maybe its the instant answer thingy
					$answer =
						$this->fuckhtml
						->getElementsByClassName("answer");
					
					if(count($answer) !== 0){
						
						$data["description"] =
							$this->titledots(
								$this->fuckhtml
								->getTextContent($answer[0])
							);
					}
				}
			}
			
			// finally, fix brave's date format sucking balls
			$data["description"] = explode(" - ", $data["description"], 2);
			
			if(count($data["description"]) === 0){
				
				// nothing to do
				$data["description"] = $data["description"][0];
			}else{
				
				// attempt to parse
				$time = strtotime($data["description"][0]);
				
				if($time !== false){
					
					// got response
					$data["date"] = $time;
					
					array_shift($data["description"]);
				}
								
				// merge back
				$data["description"] =
					implode(" - ", $data["description"]);
			}
			
			/*
				Check content type
			*/
			$content_type =
				$this->fuckhtml
				->getElementsByClassName(
					"content-type",
					"span"
				);
			
			if(count($content_type) !== 0){
				
				$data["type"] =
					strtolower($this->fuckhtml->getTextContent($content_type[0]));
			}
			
			/*
				Check subtext table thingy
			*/
			$table_items =
				array_merge(
					$this->fuckhtml
					->getElementsByClassName(
						"item-attributes",
						"div"
					),
					$this->fuckhtml
					->getElementsByClassName(
						"r",
						"div"
					)
				);
			
			/*
				DIV: item-attributes
			*/
			if(count($table_items) !== 0){
				
				foreach($table_items as $table){
					
					$this->fuckhtml->load($table);
					
					$span =
						$this->fuckhtml
						->getElementsByClassName(
							"text-sm",
							"*"
						);
					
					foreach($span as $item){
						
						$item =
							explode(
								":",
								$this->fuckhtml->getTextContent(preg_replace('/\n/', " ", $item["innerHTML"])),
								2
							);
						
						if(count($item) === 2){
							
							$data["table"][trim($item[0])] = trim($this->limitwhitespace($item[1]));
						}
					}
				}
				
				$this->fuckhtml->load($result);
			}
			
			// get video sublinks
			$table_items =
				$this->fuckhtml
				->getElementsByClassName(
					"snippet-description published-time",
					"p"
				);
			
			if(count($table_items) !== 0){
				
				$table_items =
					explode(
						'<span class="mr-15"></span>',
						$table_items[0]["innerHTML"],
						2
					);
				if(count($table_items) === 2){
					
					$item2 = [];
					
					$item2[] = explode(":", $this->fuckhtml->getTextContent($table_items[0]));
					
					if(trim($table_items[1]) != ""){
						$item2[] = explode(":", $this->fuckhtml->getTextContent($table_items[1]));
					}
					
					foreach($item2 as $it){
						
						$data["table"][trim($it[0])] = trim($it[1]);
					}
				}
			}
			
			/*
				Get URL
			*/
			$data["url"] =
				$this->fuckhtml->getTextContent(
					$this->fuckhtml
					->getElementsByTagName("a")
					[0]
					["attributes"]
					["href"]
				);
			
			/*
				Get sublinks
			*/
			$sublinks_elems =
				$this->fuckhtml
				->getElementsByClassName(
					"snippet",
					"div"
				);
			
			$sublinks = [];
			
			foreach($sublinks_elems as $sublink){
				
				$this->fuckhtml->load($sublink);
				
				$a =
					$this->fuckhtml
					->getElementsByTagName("a")[0];
				
				$title =
					$this->fuckhtml
					->getTextContent($a);
				
				$url = $a["attributes"]["href"];
				
				$description =
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByTagName("p")[0]
						)
					);
				
				$sublinks[] = [
					"title" => $title,
					"date" => null,
					"description" => $description,
					"url" => $url
				];
			}
			
			/*
				Get smaller sublinks
			*/
			$sublinks_elems =
				$this->fuckhtml
				->getElementsByClassName(
					"deep-link",
					"a"
				);
			
			foreach($sublinks_elems as $sublink){
				
				$sublinks[] = [
					"title" => $this->fuckhtml->getTextContent($sublink),
					"date" => null,
					"description" => null,
					"url" => $sublink["attributes"]["href"]
				];
			}
			
			// append sublinks to $data !!
			$data["sublink"] = $sublinks;
			
			// append first result to start of $out["web"]
			// other results are after
			if($items === 0){
				
				$out["web"] = [$data, ...$out["web"]];
			}else{
				
				$out["web"][] = $data;
			}
			$items++;
		}
		
		/*
			Get news
		*/
		$this->fuckhtml->load($resulthtml);
		$news_carousel = $this->fuckhtml->getElementById("news-carousel");
		
		$this->fuckhtml->load($news_carousel);
		
		if($news_carousel){
			
			$a =
				$this->fuckhtml
				->getElementsByClassName(
					"card fdb",
					"a"
				);
			
			foreach($a as $news){
				
				$this->fuckhtml->load($news);
				
				$out["news"][] = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$this->fuckhtml
								->getElementsByClassName(
									"title",
									"div"
								)[0]
							)
						),
					"description" => null,
					"date" =>
						strtotime(
							$this->fuckhtml
							->getTextContent(
								$this->fuckhtml
								->getElementsByClassName(
									"card-footer__timestamp",
									"span"
								)[0]
							)
						),
					"thumb" => $this->getimagelinkfromstyle("img-bg"),
					"url" => $this->fuckhtml->getTextContent($news["attributes"]["href"])
				];
			}
		}
		
		
		
		/*
			Get videos
		*/
		$this->fuckhtml->load($resulthtml);
		$news_carousel = $this->fuckhtml->getElementById("video-carousel");
		
		$this->fuckhtml->load($news_carousel);
		
		if($news_carousel){
			
			$a =
				$this->fuckhtml
				->getElementsByClassName(
					"card fdb",
					"a"
				);
			
			foreach($a as $video){
				
				$this->fuckhtml->load($video);
				
				$date = null;
				
				$date_o =
					$this->fuckhtml
					->getElementsByClassName(
						"text-gray text-xs",
						"span"
					);
				
				if(count($date_o) !== 0){
					
					$date =
						strtotime(
							$this->fuckhtml
							->getTextContent(
								$date_o[0]
							)
						);
				}
				
				$out["video"][] = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$this->fuckhtml
								->getElementsByClassName(
									"title",
									"div"
								)[0]
							)
						),
					"description" => null,
					"date" => $date,
					"duration" => null,
					"views" => null,
					"thumb" => $this->getimagelinkfromstyle("img-bg"),
					"url" => $this->fuckhtml->getTextContent($video["attributes"]["href"])
				];
			}
		}
		
		
		/*
			Get DEFINITION snippet
		*/
		$this->fuckhtml->load($html);
		$infobox = $this->fuckhtml->getElementById("rh-definitions", "div");
		
		if($infobox !== false){
			
			$answer = [
				"title" => null,
				"description" => [],
				"url" => null,
				"thumb" => null,
				"table" => [],
				"sublink" => []
			];
			
			$this->fuckhtml->load($infobox);
			
			$answer["title"] =
				$this->fuckhtml
				->getTextContent(
					$this->fuckhtml
					->getElementsByClassName(
						"header",
						"h5"
					)[0]
				);
			
			$sections =
				$this->fuckhtml
				->getElementsByTagName("section");
			
			$i = -1;
			foreach($sections as $section){
				
				$this->fuckhtml->load($section);
				$items =
					$this->fuckhtml
					->getElementsByTagName("*");
				
				$li = 1;
				$pronounce = false;
				foreach($items as $item){
					
					switch($item["tagName"]){
						
						case "h6":
							
							if(
								isset($item["attributes"]["class"]) &&
								$item["attributes"]["class"] == "h6 pronunciation"
							){
								
								if($pronounce){
									
									break;
								}
								
								$answer["description"][] = [
									"type" => "quote",
									"value" =>
										$this->fuckhtml
										->getTextContent(
											$item
										)
								];
								
								$answer["description"][] =
									[
										"type" => "audio",
										"url" => "https://search.brave.com/api/rhfetch?rhtype=definitions&word={$answer["title"]}&source=ahd-5"
									];
								
								$pronounce = true;
								$i = $i + 2;
								break;
							}
							
							$answer["description"][] = [
								"type" => "title",
								"value" =>
									$this->fuckhtml
									->getTextContent(
										$item
									)
							];
							$i++;
							break;
						
						case "li":
							
							if(
								$i !== -1 &&
								$answer["description"][$i]["type"] == "text"
							){
								
								$answer["description"][$i]["value"] .=
									"\n" . $li . ". " .
									$this->fuckhtml
									->getTextContent(
										$item
									);
								
							}else{
								$answer["description"][] = [
									"type" => "text",
									"value" =>
										$li . ". " .
										$this->fuckhtml
										->getTextContent(
											$item
										)
								];
								$i++;
							}
							$li++;
							break;
						
						case "a":
							$answer["url"] =
								$this->fuckhtml
								->getTextContent(
									$item["attributes"]["href"]
								);
							break;
					}
				}
			}
			
			$out["answer"][] = $answer;
		}
		
		
		/*
			Get instant answer
		*/
		$this->fuckhtml->load($html);
		$infobox = $this->fuckhtml->getElementById("infobox", "div");
		
		if($infobox !== false){
			
			$answer = [
				"title" => null,
				"description" => [],
				"url" => null,
				"thumb" => null,
				"table" => [],
				"sublink" => []
			];
			
			$this->fuckhtml->load($infobox);
			$div = $this->fuckhtml->getElementsByTagName("div");
			
			/*
				Get small description
			*/
			$small_desc =
				$this->fuckhtml
				->getElementsByClassName(
					"infobox-description",
					$div
				);
			
			if(count($small_desc) !== 0){
				
				$answer["description"][] = [
					"type" => "quote",
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$small_desc[0]
						)
				];
			}
			
			/*
				Get title + url
			*/
			$title =
				$this->fuckhtml
				->getElementsByClassName("infobox-title", "a");
			
			if(count($title) !== 0){
				
				$answer["title"] =
					$this->fuckhtml
					->getTextContent(
						$title[0]
					);
				
				$answer["url"] =
					$this->fuckhtml
					->getTextContent(
						$title[0]["attributes"]["href"]
					);
			}
			
			/*
				Get thumbnail
			*/
			$thumb = $this->getimagelinkfromstyle("thumb");
			
			if($thumb["url"] !== null){
				
				$answer["thumb"] = $thumb["url"];
			}
			
			/*
				Get table
			*/
			$title =
				$this->fuckhtml
				->getElementsByClassName(
					"infobox-attr-header",
					"div"
				);
			
			$rowhtml = $infobox;
			
			if(count($title) >= 2){
				
				$rowhtml =
					explode(
						$title[1]["outerHTML"],
						$infobox["innerHTML"],
						2
					)[0];
			}
			
			$this->fuckhtml->load($rowhtml);
			
			$rows =
				$this->fuckhtml
				->getElementsByClassName("infobox-attr", "div");
			
			foreach($rows as $row){
				
				if(!isset($row["innerHTML"])){
					
					continue;
				}
				
				$this->fuckhtml->load($row);
				$span =
					$this->fuckhtml
					->getElementsByTagName("span");
				
				if(count($span) === 2){
					
					$answer["table"][
						$this->fuckhtml->getTextContent($span[0])
					] = str_replace("\n", ", ", $this->fuckhtml->getTextContent($span[1], true));
				}
			}
			
			$this->fuckhtml->load($infobox);
			
			/*
				Parse stackoverflow answers
			*/
			$code =
				$this->fuckhtml
				->getElementById("codebox-answer", $div);
			
			if($code){
				
				// this might be standalone text with no paragraphs, check for that
				$author =
					$this->fuckhtml
					->getElementById("author");
				
				$desc_tmp =
					str_replace(
						$author["outerHTML"],
						"",
						$code["innerHTML"]
					);
				
				$this->fuckhtml->load($desc_tmp);
				$code =
					$this->fuckhtml
					->getElementsByTagName("*");
				
				if(count($code) === 0){
					
					$answer["description"][] = [
						"type" => "text",
						"value" =>
							$this->fuckhtml
							->getTextContent(
								$desc_tmp
							)
					];
					
					$answer["description"][] = [
						"type" => "quote",
						"value" =>
							$this->fuckhtml
							->getTextContent(
								$author
							)
					];
				}else{
					
					$i = 0;
					
					foreach($code as $snippet){
						
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
									$this->appendtext($value, $answer["description"], $i);
									
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
												
												$answer["description"][$i - 1]["value"] = rtrim($answer["description"][$i - 1]["value"]);
											}
											
											$answer["description"][] = [
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
									$this->appendtext($value, $answer["description"], $i);
								}
								break;
							
							case "pre":
								
								switch($answer["description"][$i - 1]["type"]){
									
									case "text":
									case "italic":
										$answer["description"][$i - 1]["value"] = rtrim($answer["description"][$i - 1]["value"]);
										break;
								}
								
								$answer["description"][] =
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
										$answer["description"],
										$i
									);
								}
								break;
						}
					}
					
					if(
						$i !== 0 &&
						$answer["description"][$i - 1]["type"] == "text"
					){
						
						$answer["description"][$i - 1]["value"] = rtrim($answer["description"][$i - 1]["value"]);
					}
					
					if($author){
						
						$answer["description"][] = [
							"type" => "quote",
							"value" => $this->fuckhtml->getTextContent($author)
						];
					}
				}
			}else{
				
				/*
					Get normal description
				*/
				$description =
					$this->fuckhtml
					->getElementsByClassName(
						"mb-6",
						"div"
					);
				
				if(count($description) !== 0){
					
					$answer["description"][] =
						[
							"type" => "text",
							"value" =>
								$this->titledots(
									preg_replace(
										'/ Wikipedia$/',
										"",
										$this->fuckhtml
										->getTextContent(
											$description[0]
										)
									)
								)
						];
					
					$ratings =
						$this->fuckhtml
						->getElementById("ratings");
					
					if($ratings){
						
						$this->fuckhtml->load($ratings);
						
						$ratings =
							$this->fuckhtml
							->getElementsByClassName(
								"flex-hcenter mb-10",
								"div"
							);
						
						$answer["description"][] = [
							"type" => "title",
							"value" => "Ratings"
						];
						
						foreach($ratings as $rating){
							
							$this->fuckhtml->load($rating);
							
							$num =
								$this->fuckhtml
								->getTextContent(
									$this->fuckhtml
									->getElementsByClassName(
										"r-num",
										"div"
									)[0]
								);
							
							$href =
								$this->fuckhtml
								->getElementsByClassName(
									"mr-10",
									"a"
								)[0];
							
							$votes =
								$this->fuckhtml
								->getTextContent(
									$this->fuckhtml
									->getElementsByClassName(
										"text-sm",
										"span"
									)[0]
								);
							
							$c = count($answer["description"]) - 1;
							
							if(
								$c !== -1 &&
								$answer["description"][$c]["type"] == "text"
							){
								
								$answer["description"][$c]["value"] .= $num . " ";
							}else{
								
								$answer["description"][] = [
									"type" => "text",
									"value" => $num . " "
								];
							}
							
							$answer["description"][] = [
								"type" => "link",
								"value" => $this->fuckhtml->getTextContent($href),
								"url" => $this->fuckhtml->getTextContent($href["attributes"]["href"])
							];
							
							$answer["description"][] = [
								"type" => "text",
								"value" => " (" . $votes . ")\n"
							];
						}
					}
				}
			}
			
			/*
				Get sublinks
			*/
			$this->fuckhtml->load($infobox);
			
			$profiles =
				$this->fuckhtml
				->getElementById("profiles");
			
			if($profiles){
				$profiles =
					$this->fuckhtml
					->getElementsByClassName(
						"chip",
						"a"
					);
				
				foreach($profiles as $profile){
					
					$name = $this->fuckhtml->getTextContent($profile["attributes"]["title"]);
					
					if(strtolower($name) == "steampowered"){
						
						$name = "Steam";
					}
					
					$answer["sublink"][$name] =
						$this->fuckhtml->getTextContent($profile["attributes"]["href"]);
				}
			}
			
			$actors =
				$this->fuckhtml
				->getElementById("panel-movie-cast");
			
			if($actors){
				
				$this->fuckhtml->load($actors);
				
				$actors =
					$this->fuckhtml
					->getElementsByClassName("card");
				
				$answer["description"][] = [
					"type" => "title",
					"value" => "Cast"
				];
				
				foreach($actors as $actor){
					
					$this->fuckhtml->load($actor);
					
					$answer["description"][] = [
						"type" => "text",
						"value" =>
							$this->fuckhtml
							->getTextContent(
								$this->fuckhtml
								->getElementsByClassName("card-body")
								[0]
							)
					];
					
					$answer["description"][] = [
						"type" => "image",
						"url" => $this->getimagelinkfromstyle("person-thumb")["url"]
					];
				}
			}
			
			$out["answer"][] = $answer;
		}
		
		/*
			Get actor standalone thingy
		*/
		$this->fuckhtml->load($resulthtml);
		$actors =
			$this->fuckhtml
			->getElementById("predicate-entity");
		
		if($actors){
			
			$this->fuckhtml->load($actors);
			
			$cards =
				$this->fuckhtml
				->getElementsByClassName("card");
			
			$url =
				$this->fuckhtml
				->getElementsByClassName(
					"disclaimer",
					"div"
				)[0];
			
			$this->fuckhtml->load($url);
			
			$url =
				$this->fuckhtml
				->getTextContent(
					$this->fuckhtml
					->getElementsByTagName("a")
					[0]
					["attributes"]
					["href"]
				);
			
			$this->fuckhtml->load($actors);
			
			$answer = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByClassName(
							"entity",
							"span"
						)[0]
					) . " (Cast)",
				"description" => [],
				"url" => $url,
				"sublink" => [],
				"thumb" => null,
				"table" => []
			];
			
			foreach($cards as $card){
				
				$this->fuckhtml->load($card);
				
				$answer["description"][] = [
					"type" => "title",
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByClassName(
								"title"
							)[0]
						)
				];
				
				$answer["description"][] = [
					"type" => "text",
					"value" =>
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByClassName(
								"text-xs desc"
							)[0]
						)
				];
				
				$answer["description"][] = [
					"type" => "image",
					"url" => $this->getimagelinkfromstyle("img-bg")["url"]
				];
			}
			
			$out["answer"][] = $answer;
		}
		
		return $out;
	}
	
	public function news($get){
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
		$nsfw = $get["nsfw"];
		$country = $get["country"];
		
		if(strlen($search) > 2048){
			
			throw new Exception("Search query is too long!");
		}
		/*
		$handle = fopen("scraper/brave-news.html", "r");
		$html = fread($handle, filesize("scraper/brave-news.html"));
		fclose($handle);*/
		try{
			$html =
				$this->get(
					"https://search.brave.com/news",
					[
						"q" => $search
					],
					$nsfw,
					$country
				);
			
		}catch(Exception $error){
			
			throw new Exception("Could not fetch search page");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		// load html
		$this->fuckhtml->load($html);
		
		$news =
			$this->fuckhtml
			->getElementsByClassName(
				"snippet inline gap-standard",
				"div"
			);
		
		foreach($news as $article){
			
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
			
			$this->fuckhtml->load($article);
			$elems =
				$this->fuckhtml
				->getElementsByTagName("*");
			
			// get title
			$data["title"] =
				$this->fuckhtml
				->getTextContent(
					$this->fuckhtml
					->getElementsByClassName(
						"snippet-title",
						$elems
					)
					[0]
					["innerHTML"]
				);
			
			// get description
			$data["description"] =
				$this->titledots(
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByClassName(
							"snippet-description",
							$elems
						)
						[0]
						["innerHTML"]
					)
				);
			
			// get date
			$date =
				explode(
					"•",
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByClassName(
							"snippet-url",
							$elems
						)[0]
					)
				);
			
			if(
				count($date) !== 1 &&
				trim($date[1]) != ""
			){
				
				$data["date"] =
					strtotime(
						$date[1]
					);
			}
			
			// get URL
			$data["url"] =
				$this->fuckhtml->getTextContent(
					$this->unshiturl(
						$this->fuckhtml
						->getElementsByClassName(
							"result-header",
							$elems
						)
						[0]
						["attributes"]
						["href"]
					)
				);
			
			// get thumbnail
			$thumb =
				$this->fuckhtml
				->getElementsByTagName(
					"img"
				);
			
			if(
				count($thumb) === 2 &&
				trim(
					$thumb[1]
					["attributes"]
					["src"]
				) != ""
			){
				
				$data["thumb"] = [
					"url" =>
						$this->fuckhtml->getTextContent(
							$this->unshiturl(
								$thumb[1]
								["attributes"]
								["src"]
							)
						),
					"ratio" => "16:9"
				];
			}
			
			$out["news"][] = $data;
		}
		
		return $out;
	}
	
	public function image($get){
		
		$search = $get["s"];
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		try{
			$html =
				$this->get(
					"https://search.brave.com/images",
					[
						"q" => $search
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
		
		$search = $get["s"];
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		try{
			$html =
				$this->get(
					"https://search.brave.com/videos",
					[
						"q" => $search
					],
					$nsfw,
					$country
				);
			
		}catch(Exception $error){
			
			throw new Exception("Could not fetch search page");
		}
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
				"date" => $result["age"] == "null" ? null : strtotime($result["age"]),
				"duration" => $result["video"]["duration"] == "null" ? null : $this->hms2int($result["video"]["duration"]),
				"views" => $result["video"]["views"] == "null" ? null : (int)$result["video"]["views"],
				"thumb" => $thumb,
				"url" => $result["url"]
			];
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
	}
	
	private function limitstrlen($text){
		
		return explode("\n", wordwrap($text, 300, "\n"))[0];
	}
	
	private function limitwhitespace($text){
		
		return
			preg_replace(
				'/[\s]+/',
				" ",
				$text
			);
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
