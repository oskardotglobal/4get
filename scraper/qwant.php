<?php

class qwant{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("qwant");
	}
	
	public function getfilters($page){
		
		$base = [
			"nsfw" => [
				"display" => "NSFW",
				"option" => [
					"yes" => "Yes",
					"maybe" => "Maybe",
					"no" => "No"
				]
			],
			"country" => [
				"display" => "Country",
				"option" => [
					"en_US" => "United States",
					"fr_FR" => "France",
					"en_GB" => "Great Britain",
					"de_DE" => "Germany",
					"it_IT" => "Italy",
					"es_AR" => "Argentina",
					"en_AU" => "Australia",
					"es_ES" => "Spain (es)",
					"ca_ES" => "Spain (ca)",
					"cs_CZ" => "Czech Republic",
					"ro_RO" => "Romania",
					"el_GR" => "Greece",
					"zh_CN" => "China",
					"zh_HK" => "Hong Kong",
					"en_NZ" => "New Zealand",
					"fr_FR" => "France",
					"th_TH" => "Thailand",
					"ko_KR" => "South Korea",
					"sv_SE" => "Sweden",
					"nb_NO" => "Norway",
					"da_DK" => "Denmark",
					"hu_HU" => "Hungary",
					"et_EE" => "Estonia",
					"es_MX" => "Mexico",
					"es_CL" => "Chile",
					"en_CA" => "Canada (en)",
					"fr_CA" => "Canada (fr)",
					"en_MY" => "Malaysia",
					"bg_BG" => "Bulgaria",
					"fi_FI" => "Finland",
					"pl_PL" => "Poland",
					"nl_NL" => "Netherlands",
					"pt_PT" => "Portugal",
					"de_CH" => "Switzerland (de)",
					"fr_CH" => "Switzerland (fr)",
					"it_CH" => "Switzerland (it)",
					"de_AT" => "Austria",
					"fr_BE" => "Belgium (fr)",
					"nl_BE" => "Belgium (nl)",
					"en_IE" => "Ireland",
					"he_IL" => "Israel"
				]
			]
		];
		
		switch($page){
			
			case "web":
				$base = array_merge(
					$base,
					[
						"time" => [
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"day" => "Past 24 hours",
								"week" => "Past week",
								"month" => "Past month"
							]
						],
						"extendedsearch" => [
							// no display, wont show in interface
							"option" => [
								"yes" => "Yes",
								"no" => "No"
							]
						]
					]
				);
				break;
			
			case "images":
				$base = array_merge(
					$base,
					[
						"time" => [
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"day" => "Past 24 hours",
								"week" => "Past week",
								"month" => "Past month"
							]
						],
						"size" => [
							"display" => "Size",
							"option" => [
								"any" => "Any size",
								"large" => "Large",
								"medium" => "Medium",
								"small" => "Small"
							]
						],
						"color" => [
							"display" => "Color",
							"option" => [
								"any" => "Any color",
								"coloronly" => "Color only",
								"monochrome" => "Monochrome",
								"black" => "Black",
								"brown" => "Brown",
								"gray" => "Gray",
								"white" => "White",
								"yellow" => "Yellow",
								"orange" => "Orange",
								"red" => "Red",
								"pink" => "Pink",
								"purple" => "Purple",
								"blue" => "Blue",
								"teal" => "Teal",
								"green" => "Green"
							]
						],
						"imagetype" => [
							"display" => "Type",
							"option" => [
								"any" => "Any type",
								"animatedgif" => "Animated GIF",
								"photo" => "Photograph",
								"transparent" => "Transparent"
							]
						],
						"license" => [
							"display" => "License",
							"option" => [
								"any" => "Any license",
								"share" => "Non-commercial reproduction and sharing",
								"sharecommercially" => "Reproduction and sharing",
								"modify" => "Non-commercial reproduction, sharing and modification",
								"modifycommercially" => "Reproduction, sharing and modification",
								"public" => "Public domain"
							]
						]
					]
				);
				break;
			
			case "videos":
				$base = array_merge(
					$base,
					[
						"order" => [
							"display" => "Order by",
							"option" => [
								"relevance" => "Relevance",
								"views" => "Views",
								"date" => "Most recent",
							]
						],
						"source" => [
							"display" => "Source",
							"option" => [
								"any" => "Any source",
								"youtube" => "YouTube",
								"dailymotion" => "Dailymotion",
							]
						]
					]
				);
				break;
			
			case "news":
				$base = array_merge(
					$base,
					[
						"time" => [
							"display" => "Time posted",
							"option" => [
								"any" => "Any time",
								"hour" => "Less than 1 hour ago",
								"day" => "Past 24 hours",
								"week" => "Past week",
								"month" => "Past month"
							]
						],
						"order" => [
							"display" => "Order by",
							"option" => [
								"relevance" => "Relevance",
								"date" => "Most recent"
							]
						]
					]
				);
				break;
		}
		
		return $base;
	}
	
	private function get($proxy, $url, $get = []){
		
		$headers = [
			"User-Agent: " . config::USER_AGENT,
			"Accept: application/json, text/plain, */*",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"DNT: 1",
			"Connection: keep-alive",
			"Origin: https://www.qwant.com",
			"Referer: https://www.qwant.com/",
			"Sec-Fetch-Dest: empty",
			"Sec-Fetch-Mode: cors",
			"Sec-Fetch-Site: same-site",
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
		
		// Bypass HTTP/2 check
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
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
			[$params, $proxy] = $this->backend->get($get["npt"], "web");
			
			$params = json_decode($params, true);
			
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
			
			$params = [
				"q" => $search,
				"freshness" => $get["time"],
				"count" => 10,
				"locale" => $get["country"],
				"offset" => 0,
				"device" => "desktop",
				"tgp" => 3,
				"safesearch" => 0,
				"displayed" => "true"
			];
			
			switch($get["nsfw"]){
				
				case "yes": $params["safesearch"] = 0; break;
				case "maybe": $params["safesearch"] = 1; break;
				case "no": $params["safesearch"] = 2; break;
			}
		}
		/*
		$handle = fopen("scraper/qwant_web.json", "r");
		$json = fread($handle, filesize("scraper/qwant_web.json"));
		fclose($handle);*/
		
		try{
			$json =
				$this->get(
					$proxy,
					"https://fdn.qwant.com/v3/search/web",
					$params
				);
			
		}catch(Exception $error){
			
			throw new Exception("Could not fetch JSON");
		}
		
		$json = json_decode($json, true);
		
		if($json === NULL){
			
			throw new Exception("Failed to decode JSON");
		}
		
		if(isset($json["data"]["message"][0])){
			
			throw new Exception("Server returned an error:\n" . $json["data"]["message"][0]);
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
		
		if(
			$json["status"] != "success" &&
			$json["data"]["error_code"] === 5
		){
			
			// no results
			return $out;
		}
		
		$this->detect_errors($json);
		
		if(!isset($json["data"]["result"]["items"]["mainline"])){
			
			throw new Exception("Server did not return a result object");
		}
		
		// data is OK, parse
		
		// get instant answer
		if(
			$get["extendedsearch"] == "yes" &&
			isset($json["data"]["result"]["items"]["sidebar"][0]["endpoint"])
		){
			
			try{
				$answer =
					$this->get(
						$proxy,
						"https://api.qwant.com/v3" .
						$json["data"]["result"]["items"]["sidebar"][0]["endpoint"],
						[]
					);
				
				$answer = json_decode($answer, true);
				
				if(
					$answer === null ||
					$answer["status"] != "success" ||
					$answer["data"]["result"] === null
				){
					
					throw new Exception();
				}
				
				// parse answer
				$out["answer"][] = [
					"title" => $answer["data"]["result"]["title"],
					"description" => [
						[
							"type" => "text",
							"value" => $this->trimdots($answer["data"]["result"]["description"])
						]
					],
					"url" => $answer["data"]["result"]["url"],
					"thumb" =>
						$answer["data"]["result"]["thumbnail"]["landscape"] == null ?
						null :
						$this->unshitimage(
							$answer["data"]["result"]["thumbnail"]["landscape"],
							false
						),
					"table" => [],
					"sublink" => []
				];
				
			}catch(Exception $error){
				
				// do nothing in case of failure
			}
			
		}
		
		// get word correction
		if(isset($json["data"]["query"]["queryContext"]["alteredQuery"])){
			
			$out["spelling"] = [
				"type" => "including",
				"using" => $json["data"]["query"]["queryContext"]["alteredQuery"],
				"correction" => $json["data"]["query"]["queryContext"]["alterationOverrideQuery"]
			];
		}
		
		// check for next page
		if($json["data"]["result"]["lastPage"] === false){
			
			$params["offset"] = $params["offset"] + 10;
			
			$out["npt"] =
				$this->backend->store(
					json_encode($params),
					"web",
					$proxy
				);
		}
		
		// parse results
		foreach($json["data"]["result"]["items"]["mainline"] as $item){
			
			switch($item["type"]){ // ignores ads
				
				case "web":
					
					$first_iteration = true;
					foreach($item["items"] as $result){
						
						if(isset($result["thumbnailUrl"])){
							
							$thumb = [
								"url" => $this->unshitimage($result["thumbnailUrl"]),
								"ratio" => "16:9"
							];
						}else{
							
							$thumb = [
								"url" => null,
								"ratio" => null
							];
						}
						
						$sublinks = [];
						if(isset($result["links"])){
							
							foreach($result["links"] as $link){
								
								$sublinks[] = [
									"title" => $this->trimdots($link["title"]),
									"date" => null,
									"description" => isset($link["desc"]) ? $this->trimdots($link["desc"]) : null,
									"url" => $link["url"]
								];
							}
						}
						
						// detect gibberish results
						if(
							$first_iteration &&
							!isset($result["urlPingSuffix"])
						){
							
							throw new Exception("Qwant returned gibberish results");
						}
						
						$out["web"][] = [
							"title" => $this->trimdots($result["title"]),
							"description" => $this->trimdots($result["desc"]),
							"url" => $result["url"],
							"date" => null,
							"type" => "web",
							"thumb" => $thumb,
							"sublink" => $sublinks,
							"table" => []
						];
						
						$first_iteration = false;
					}
					break;
				
				case "images":
					foreach($item["items"] as $image){
						
						$out["image"][] = [
							"title" => $image["title"],
							"source" => [
								[
									"url" => $image["media"],
									"width" => (int)$image["width"],
									"height" => (int)$image["height"]
								],
								[
									"url" => $this->unshitimage($image["thumbnail"]),
									"width" => $image["thumb_width"],
									"height" => $image["thumb_height"]
								]
							],
							"url" => $image["url"]
						];
					}
					break;
				
				case "videos":
					foreach($item["items"] as $video){
						
						$out["video"][] = [
							"title" => $video["title"],
							"description" => null,
							"date" => (int)$video["date"],
							"duration" => $video["duration"] === null ? null : $video["duration"] / 1000,
							"views" => null,
							"thumb" =>
								$video["thumbnail"] === null ?
								[
									"url" => null,
									"ratio" => null,
								] :
								[
									"url" => $this->unshitimage($video["thumbnail"]),
									"ratio" => "16:9",
								],
							"url" => $video["url"]
						];
					}
					break;
				
				case "related_searches":
					foreach($item["items"] as $related){
						
						$out["related"][] = $related["text"];
					}
					break;
			}
		}
		
		return $out;
	}
	
	
	public function image($get){
		
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
			
			$params = [
				"t" => "images",
				"q" => $search,
				"count" => 125,
				"locale" => $get["country"],
				"offset" => 0, // increment by 125
				"device" => "desktop",
				"tgp" => 3
			];
			
			if($get["time"] != "any"){
				
				$params["freshness"] = $get["time"];
			}
			
			foreach(["size", "color", "imagetype", "license"] as $p){
				
				if($get[$p] != "any"){
					
					$params[$p] = $get[$p];
				}
			}
			
			switch($get["nsfw"]){
				
				case "yes": $params["safesearch"] = 0; break;
				case "maybe": $params["safesearch"] = 1; break;
				case "no": $params["safesearch"] = 2; break;
			}
		}
		
		try{
			$json = $this->get(
				$proxy,
				"https://api.qwant.com/v3/search/images",
				$params,
			);
		}catch(Exception $err){
			
			throw new Exception("Failed to get JSON");
		}
		
		/*
		$handle = fopen("scraper/yandex.json", "r");
		$json = fread($handle, filesize("scraper/yandex.json"));
		fclose($handle);*/
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		$this->detect_errors($json);
		
		if(isset($json["data"]["result"]["items"]["mainline"])){
			
			throw new Exception("Qwant returned gibberish results");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		if($json["data"]["result"]["lastPage"] === false){
			
			$params["offset"] = $params["offset"] + 125;
			
			$out["npt"] = $this->backend->store(
				json_encode($params),
				"images",
				$proxy
			);
		}
		
		foreach($json["data"]["result"]["items"] as $image){
			
			$out["image"][] = [
				"title" => $this->trimdots($image["title"]),
				"source" => [
					[
						"url" => $image["media"],
						"width" => $image["width"],
						"height" => $image["height"]
					],
					[
						"url" => $this->unshitimage($image["thumbnail"]),
						"width" => $image["thumb_width"],
						"height" => $image["thumb_height"]
					]
				],
				"url" => $image["url"]
			];
		}
		
		return $out;
	}
	
	public function video($get){
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
		$params = [
			"t" => "videos",
			"q" => $search,
			"count" => 50,
			"locale" => $get["country"],
			"offset" => 0, // dont implement pagination
			"device" => "desktop",
			"tgp" => 3
		];
		
		switch($get["nsfw"]){
			
			case "yes": $params["safesearch"] = 0; break;
			case "maybe": $params["safesearch"] = 1; break;
			case "no": $params["safesearch"] = 2; break;
		}
		
		try{
			$json =
				$this->get(
					$this->backend->get_ip(),
					"https://api.qwant.com/v3/search/videos",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Could not fetch JSON");
		}
		
		/*
		$handle = fopen("scraper/yandex-video.json", "r");
		$json = fread($handle, filesize("scraper/yandex-video.json"));
		fclose($handle);
		*/
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Could not parse JSON");
		}
		
		$this->detect_errors($json);
		
		if(isset($json["data"]["result"]["items"]["mainline"])){
			
			throw new Exception("Qwant returned gibberish results");
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
		
		foreach($json["data"]["result"]["items"] as $video){
			
			if(empty($video["thumbnail"])){
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}else{
				
				$thumb = [
					"url" => $this->unshitimage($video["thumbnail"], false),
					"ratio" => "16:9"
				];
			}
			
			$duration = (int)$video["duration"];
			
			$out["video"][] = [
				"title" => $video["title"],
				"description" => $this->limitstrlen($video["desc"]),
				"author" => [
					"name" => $video["channel"],
					"url" => null,
					"avatar" => null
				],
				"date" => (int)$video["date"],
				"duration" => $duration === 0 ? null : $duration,
				"views" => null,
				"thumb" => $thumb,
				"url" => preg_replace("/\?syndication=.+/", "", $video["url"])
			];
		}
		
		return $out;
	}
	
	public function news($get){
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
		$params = [
			"t" => "news",
			"q" => $search,
			"count" => 50,
			"locale" => $get["country"],
			"offset" => 0, // dont implement pagination
			"device" => "desktop",
			"tgp" => 3
		];
		
		switch($get["nsfw"]){
			
			case "yes": $params["safesearch"] = 0; break;
			case "maybe": $params["safesearch"] = 1; break;
			case "no": $params["safesearch"] = 2; break;
		}
		
		try{
			$json =
				$this->get(
					$this->backend->get_ip(),
					"https://api.qwant.com/v3/search/news",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Could not fetch JSON");
		}
		
		/*
		$handle = fopen("scraper/yandex-video.json", "r");
		$json = fread($handle, filesize("scraper/yandex-video.json"));
		fclose($handle);
		*/
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Could not parse JSON");
		}
		
		$this->detect_errors($json);
		
		if(isset($json["data"]["result"]["items"]["mainline"])){
			
			throw new Exception("Qwant returned gibberish results");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"news" => []
		];
		
		foreach($json["data"]["result"]["items"] as $news){
			
			if(empty($news["media"][0]["pict_big"]["url"])){
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}else{
				
				$thumb = [
					"url" => $this->unshitimage($news["media"][0]["pict_big"]["url"], false),
					"ratio" => "16:9"
				];
			}
			
			$out["news"][] = [
				"title" => $news["title"],
				"author" => $news["press_name"],
				"description" => $this->trimdots($news["desc"]),
				"date" => (int)$news["date"],
				"thumb" => $thumb,
				"url" => $news["url"]
			];
		}
		
		return $out;
	}
	
	private function detect_errors($json){
		
		if(
			isset($json["status"]) &&
			$json["status"] == "error"
		){
			
			if(isset($json["data"]["error_data"]["captchaUrl"])){
				
				throw new Exception("Qwant returned a captcha");
			}elseif(isset($json["data"]["error_data"]["error_code"])){
				
				throw new Exception(
					"Qwant returned an API error: " .
					$json["data"]["error_data"]["error_code"]
				);
			}
			
			throw new Exception("Qwant returned an API error");
		}
	}
	
	private function limitstrlen($text){
		
		return explode("\n", wordwrap($text, 300, "\n"))[0];
	}
	
	private function trimdots($text){
		
		return trim($text, ". ");
	}
	
	private function unshitimage($url, $is_bing = true){
		
		// https://s1.qwant.com/thumbr/0x0/8/d/f6de4deb2c2b12f55d8bdcaae576f9f62fd58a05ec0feeac117b354d1bf5c2/th.jpg?u=https%3A%2F%2Fwww.bing.com%2Fth%3Fid%3DOIP.vvDWsagzxjoKKP_rOqhwrQAAAA%26w%3D160%26h%3D160%26c%3D7%26pid%3D5.1&q=0&b=1&p=0&a=0
		parse_str(parse_url($url)["query"], $parts);
		
		if($is_bing){
			$parse = parse_url($parts["u"]);
			parse_str($parse["query"], $parts);
			
			return "https://" . $parse["host"] . "/th?id=" . urlencode($parts["id"]);
		}
		
		return $parts["u"];
	}
}
