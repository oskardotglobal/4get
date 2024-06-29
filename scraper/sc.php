<?php

class sc{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("sc");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		return [
			"type" => [
				"display" => "Type",
				"option" => [
					"any" => "Any type",
					"track" => "Tracks",
					"author" => "People",
					"album" => "Albums",
					"playlist" => "Playlists",
					"goplus" => "Go+ Tracks"
				]
			]
		];
	}
	
	private function get($proxy, $url, $get = [], $web_req = false){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
		// use http2
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
		if($web_req === false){
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"Referer: https://soundcloud.com/",
				"Origin: https://soundcloud.com",
				"DNT: 1",
				"Connection: keep-alive",
				"Sec-Fetch-Dest: empty",
				"Sec-Fetch-Mode: cors",
				"Sec-Fetch-Site: same-site",
				"Priority: u=1"]
			);
		}else{
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"DNT: 1",
				"Connection: keep-alive",
				"Upgrade-Insecure-Requests: 1",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: cross-site",
				"Priority: u=1",
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
	
	public function music($get, $last_attempt = false){
		
		if($get["npt"]){
			
			[$params, $proxy] = $this->backend->get($get["npt"], "music");
			$params = json_decode($params, true);
			
			$url = $params["url"];
			unset($params["url"]);
			
		}else{
			
			// normal search:
			// https://api-v2.soundcloud.com/search?q=freddie%20dredd&variant_ids=&facet=model&user_id=351062-302234-707916-795081&client_id=iMxZgT5mfGstBj8GWJbYMvpzelS8ne0E&limit=20&offset=0&linked_partitioning=1&app_version=1693487844&app_locale=en
			
			// soundcloud go+ search:
			// https://api-v2.soundcloud.com/search/tracks?q=freddie%20dredd&variant_ids=&filter.content_tier=SUB_HIGH_TIER&facet=genre&user_id=630591-269800-703400-765403&client_id=iMxZgT5mfGstBj8GWJbYMvpzelS8ne0E&limit=20&offset=0&linked_partitioning=1&app_version=1693487844&app_locale=en
			
			// tracks search:
			// https://api-v2.soundcloud.com/search/tracks?q=freddie%20dredd&variant_ids=&facet=genre&user_id=630591-269800-703400-765403&client_id=iMxZgT5mfGstBj8GWJbYMvpzelS8ne0E&limit=20&offset=0&linked_partitioning=1&app_version=1693487844&app_locale=en
			
			// users search:
			// https://api-v2.soundcloud.com/search/users?q=freddie%20dredd&variant_ids=&facet=place&user_id=630591-269800-703400-765403&client_id=iMxZgT5mfGstBj8GWJbYMvpzelS8ne0E&limit=20&offset=0&linked_partitioning=1&app_version=1693487844&app_locale=en
			
			// albums search:
			// https://api-v2.soundcloud.com/search/albums?q=freddie%20dredd&variant_ids=&facet=genre&user_id=630591-269800-703400-765403&client_id=iMxZgT5mfGstBj8GWJbYMvpzelS8ne0E&limit=20&offset=0&linked_partitioning=1&app_version=1693487844&app_locale=en
			
			// playlists search:
			// https://api-v2.soundcloud.com/search/playlists_without_albums?q=freddie%20dredd&variant_ids=&facet=genre&user_id=630591-269800-703400-765403&client_id=iMxZgT5mfGstBj8GWJbYMvpzelS8ne0E&limit=20&offset=0&linked_partitioning=1&app_version=1693487844&app_locale=en
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$type = $get["type"];
			$proxy = $this->backend->get_ip();
			$token = $this->get_token($proxy);
			
			switch($type){
				
				case "any":
					$url = "https://api-v2.soundcloud.com/search";
					$params = [
						"q" => $search,
						"variant_ids" => "",
						"facet" => "model",
						"client_id" => $token,
						"limit" => 20,
						"offset" => 0,
						"linked_partitioning" => 1,
						"app_version" => 1713542117,
						"app_locale" => "en"
					];
					break;
				
				case "track":
					$url = "https://api-v2.soundcloud.com/search/tracks";
					$params = [
						"q" => $search,
						"variant_ids" => "",
						"facet_genre" => "",
						"client_id" => $token,
						"limit" => 20,
						"offset" => 0,
						"linked_partitioning" => 1,
						"app_version" => 1713542117,
						"app_locale" => "en"
					];
					break;
				
				case "author":
					$url = "https://api-v2.soundcloud.com/search/users";
					$params = [
						"q" => $search,
						"variant_ids" => "",
						"facet" => "place",
						"client_id" => $token,
						"limit" => 20,
						"offset" => 0,
						"linked_partitioning" => 1,
						"app_version" => 1713542117,
						"app_locale" => "en"
					];
					break;
				
				case "album":
					$url = "https://api-v2.soundcloud.com/search/albums";
					$params = [
						"q" => $search,
						"variant_ids" => "",
						"facet" => "genre",
						"client_id" => $token,
						"limit" => 20,
						"offset" => 0,
						"linked_partitioning" => 1,
						"app_version" => 1713542117,
						"app_locale" => "en"
					];
					break;
				
				case "playlist":
					$url = "https://api-v2.soundcloud.com/search/playlists_without_albums";
					$params = [
						"q" => $search,
						"variant_ids" => "",
						"facet" => "genre",
						"client_id" => $token,
						"limit" => 20,
						"offset" => 0,
						"linked_partitioning" => 1,
						"app_version" => 1713542117,
						"app_locale" => "en"
					];
					break;
				
				case "goplus":
					$url = "https://api-v2.soundcloud.com/search/tracks";
					$params = [
						"q" => $search,
						"variant_ids" => "",
						"filter.content_tier" => "SUB_HIGH_TIER",
						"facet" => "genre",
						"client_id" => $token,
						"limit" => 20,
						"offset" => 0,
						"linked_partitioning" => 1,
						"app_version" => 1713542117,
						"app_locale" => "en"
					];
					break;
			}
		}
			
		try{
			
			$json = $this->get($proxy, $url, $params);
			
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		/*
		$handle = fopen("scraper/soundcloud.json", "r");
		$json = fread($handle, filesize("scraper/soundcloud.json"));
		fclose($handle);
		*/
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			if($last_attempt === true){
				
				throw new Exception("Fetched an invalid token (please report!!)");
			}
			
			// token might've expired, get a new one and re-try search
			$this->get_token($proxy);
			return $this->music($get, true);
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"song" => [],
			"playlist" => [],
			"album" => [],
			"podcast" => [],
			"author" => [],
			"user" => []
		];
		
		/*
			Get next page
		*/
		if(isset($json["next_href"])){
			
			$params["query_urn"] = $json["query_urn"];
			$params["offset"] = $params["offset"] + 20;
			$params["url"] = $url; // we will remove this later
			
			$out["npt"] =
				$this->backend->store(
					json_encode($params),
					"music",
					$proxy
				);
		}
		
		/*
			Scrape items
		*/
		foreach($json["collection"] as $item){
			
			switch($item["kind"]){
				
				case "user":
					// parse author
					$out["author"][] = [
						"title" => $item["username"],
						"followers" => $item["followers_count"],
						"description" => trim($item["track_count"] . " songs. " . $this->limitstrlen($item["description"])),
						"thumb" => [
							"url" => $item["avatar_url"],
							"ratio" => "1:1"
						],
						"url" => $item["permalink_url"]
					];
					break;
				
				case "playlist":
					// parse playlist
					$description = [];
					$count = 0;
					
					foreach($item["tracks"] as $song){
						
						$count++;
						
						if(!isset($song["title"])){
							
							continue;
						}
						
						$description[] = $song["title"];
					}
					
					if(count($description) !== 0){
						
						$description = trim($count . " songs. " . implode(", ", $description));
					}else{
						
						$description = "";
					}
					
					if(
						isset($item["artwork_url"]) &&
						!empty($item["artwork_url"])
					){
						
						$thumb = [
							"ratio" => "1:1",
							"url" => $item["artwork_url"]
						];
						
					}elseif(
						isset($item["tracks"][0]["artwork_url"]) &&
						!empty($item["tracks"][0]["artwork_url"])
					){
						
						$thumb = [
							"ratio" => "1:1",
							"url" => $item["tracks"][0]["artwork_url"]
						];
					}else{
						
						$thumb = [
							"ratio" => null,
							"url" => null
						];
					}
					
					$out["playlist"][] = [
						"title" => $item["title"],
						"description" => $this->limitstrlen($description),
						"author" => [
							"name" => $item["user"]["username"],
							"url" => $item["user"]["permalink_url"],
							"avatar" => $item["user"]["avatar_url"]
						],
						"thumb" => $thumb,
						"date" => strtotime($item["created_at"]),
						"duration" => $item["duration"] / 1000,
						"url" => $item["permalink_url"]
					];
					break;
				
				case "track":
					if(stripos($item["monetization_model"], "TIER") === false){
						
						$stream = [
							"endpoint" => "sc",
							"url" =>
								$item["media"]["transcodings"][0]["url"] .
								"?client_id=" . $token .
								"&track_authorization=" .
								$item["track_authorization"]
						];
					}else{
						
						$stream = [
							"endpoint" => null,
							"url" => null
						];
					}
					
					// parse track
					$out["song"][] = [
						"title" => $item["title"],
						"description" => $item["description"] == "" ? null : $this->limitstrlen($item["description"]),
						"url" => $item["permalink_url"],
						"views" => $item["playback_count"],
						"author" => [
							"name" => $item["user"]["username"],
							"url" => $item["user"]["permalink_url"],
							"avatar" => $item["user"]["avatar_url"]
						],
						"thumb" => [
							"ratio" => "1:1",
							"url" => $item["artwork_url"]
						],
						"date" => strtotime($item["created_at"]),
						"duration" => (int)$item["full_duration"] / 1000,
						"stream" => $stream
					];
					break;
			}
		}
		
		return $out;
	}
	
	public function get_token($proxy){
		
		$token = apcu_fetch("sc_token");
		
		if($token !== false){
			
			return $token;
		}
		
		// search through all javascript components on the main page
		try{
			$html =
				$this->get(
					$proxy,
					"https://soundcloud.com",
					[],
					true
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch front page");
		}
		
		$this->fuckhtml->load($html);
		
		$scripts =
			$this->fuckhtml
			->getElementsByTagName(
				"script"
			);
		
		foreach($scripts as $script){
			
			if(
				!isset($script["attributes"]["src"]) ||
				strpos($script["attributes"]["src"], "sndcdn.com") === false
			){
				
				continue;
			}
			
			try{
				$js =
					$this->get(
						$proxy,
						$script["attributes"]["src"],
						[]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search token");
			}
			
			preg_match(
				'/client_id=([^"]+)/',
				$js,
				$token
			);
			
			if(isset($token[1])){
				
				apcu_store("sc_token", $token[1]);
				return $token[1];
				break;
			}
		}
		
		throw new Exception("Did not find a Soundcloud token in the Javascript blobs");
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
}
