<?php

class spotify{
		
	private const req_web = 0;
	private const req_api = 1;
	private const req_clientid = 2;
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("spotify");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		return [
			"category" => [
				"display" => "Category",
				"option" => [
					"any" => "All (no pagination)",
					"audiobooks" => "Audiobooks",
					"tracks" => "Songs",
					"artists" => "Artists",
					"playlists" => "Playlists",
					"albums" => "Albums",
					"podcastAndEpisodes" => "Podcasts & Shows (no pagination)",
					"episodes" => "Episodes",
					"users" => "Profiles"
				]
			]
		];
	}
	
	private function get($proxy, $url, $get = [], $reqtype = self::req_web, $bearer = null, $token = null){
		
		$curlproc = curl_init();
		
		switch($reqtype){
			
			case self::req_api:
				$headers = [
					"User-Agent: " . config::USER_AGENT,
					"Accept: application/json",
					"Accept-Language: en",
					"app-platform: WebPlayer",
					"authorization: Bearer {$bearer}",
					"client-token: {$token}",
					"content-type: application/json;charset=UTF-8",
					"Origin: https://open.spotify.com",
					"Referer: https://open.spotify.com/",
					"DNT: 1",
					"Connection: keep-alive",
					"Sec-Fetch-Dest: empty",
					"Sec-Fetch-Mode: cors",
					"Sec-Fetch-Site: same-site",
					"spotify-app-version: 1.2.27.93.g7aee53d4",
					"TE: trailers"
				];
				break;
			
			case self::req_web:
				$headers = [
					"User-Agent: " . config::USER_AGENT,
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip",
					"DNT: 1",
					"Sec-GPC: 1",
					"Connection: keep-alive",
					"Upgrade-Insecure-Requests: 1",
					"Sec-Fetch-Dest: document",
					"Sec-Fetch-Mode: navigate",
					"Sec-Fetch-Site: cross-site"
				];
				break;
			
			case self::req_clientid:			
				$get = json_encode($get);
				
				curl_setopt($curlproc, CURLOPT_POST, true);
				curl_setopt($curlproc, CURLOPT_POSTFIELDS, $get);
			
				$headers = [
					"User-Agent:" . config::USER_AGENT,
					"Accept: application/json",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip, deflate, br",
					"Referer: https://open.spotify.com/",
					"content-type: application/json",
					"Content-Length: " . strlen($get),
					"Origin: https://open.spotify.com",
					"DNT: 1",
					"Sec-GPC: 1",
					"Connection: keep-alive",
					"Sec-Fetch-Dest: empty",
					"Sec-Fetch-Mode: cors",
					"Sec-Fetch-Site: same-site",
					"TE: trailers"
				];
				break;
		}
		
		if($reqtype !== self::req_clientid){
			if($get !== []){
				$get = http_build_query($get);
				$url .= "?" . $get;
			}
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
	
	public function music($get){
		
		$search = $get["s"];
		$ip = $this->backend->get_ip();
		$category = $get["category"];
		
		/*
		audiobooks first and second page decoded
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchAudiobooks&variables={"searchTerm":"freddie+dredd","offset":0,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"8758e540afdba5afa3c5246817f6bd31d86a15b3f5666c363dd017030f35d785"}}
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchAudiobooks&variables={"searchTerm":"freddie+dredd","offset":30,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"8758e540afdba5afa3c5246817f6bd31d86a15b3f5666c363dd017030f35d785"}}
		*/
		
		/*
		songs
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchTracks&variables={"searchTerm":"asmr","offset":0,"limit":100,"numberOfTopResults":20,"includeAudiobooks":false}&extensions={"persistedQuery":{"version":1,"sha256Hash":"16c02d6304f5f721fc2eb39dacf2361a4543815112506a9c05c9e0bc9733a679"}}
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchTracks&variables={"searchTerm":"asmr","offset":100,"limit":100,"numberOfTopResults":20,"includeAudiobooks":false}&extensions={"persistedQuery":{"version":1,"sha256Hash":"16c02d6304f5f721fc2eb39dacf2361a4543815112506a9c05c9e0bc9733a679"}}
		*/
		
		/*
		artists
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchArtists&variables={"searchTerm":"asmr","offset":0,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"b8840daafdda9a9ceadb7c5774731f63f9eca100445d2d94665f2dc58b45e2b9"}}
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchArtists&variables={"searchTerm":"asmr","offset":30,"limit":23,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"b8840daafdda9a9ceadb7c5774731f63f9eca100445d2d94665f2dc58b45e2b9"}}
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchArtists&variables={"searchTerm":"asmr","offset":53,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"b8840daafdda9a9ceadb7c5774731f63f9eca100445d2d94665f2dc58b45e2b9"}}
		*/
		
		/*
		playlists
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchPlaylists&variables={"searchTerm":"asmr","offset":0,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"19b4143a0500ccec189ca0f4a0316bc2c615ecb51ce993ba4d7d08afd1d87aa4"}}
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchPlaylists&variables={"searchTerm":"asmr","offset":30,"limit":3,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"19b4143a0500ccec189ca0f4a0316bc2c615ecb51ce993ba4d7d08afd1d87aa4"}}
		*/
		
		/*
		albums
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchAlbums&variables={"searchTerm":"asmr","offset":33,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"e93b13cda461482da2940467eb2beed9368e9bb2fff37df3fb6633fc61271a27"}}
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchAlbums&variables={"searchTerm":"asmr","offset":33,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"e93b13cda461482da2940467eb2beed9368e9bb2fff37df3fb6633fc61271a27"}}
		*/
		
		/*
		podcasts & shows (contains authors, no pagination)
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchFullEpisodes&variables={"searchTerm":"asmr","offset":0,"limit":30}&extensions={"persistedQuery":{"version":1,"sha256Hash":"9f996251c9781fabce63f1a9980b5287ea33bc5e8c8953d0c4689b09936067a1"}}
		*/
		
		/*
		episodes
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchDesktop&variables={"searchTerm":"asmr","offset":0,"limit":10,"numberOfTopResults":5,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"da03293d92a2cfc5e24597dcdc652c0ad135e1c64a78fddbf1478a7e096bea44"}}
		??? https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchFullEpisodes&variables={"searchTerm":"asmr","offset":60,"limit":30}&extensions={"persistedQuery":{"version":1,"sha256Hash":"9f996251c9781fabce63f1a9980b5287ea33bc5e8c8953d0c4689b09936067a1"}}
		*/
		
		/*
		profiles
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchUsers&variables={"searchTerm":"asmr","offset":0,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"02026f48ab5001894e598904079b620ebc64f2d53b55ca20c3858abd3a46c5fb"}}
		https://api-partner.spotify.com/pathfinder/v1/query?operationName=searchUsers&variables={"searchTerm":"asmr","offset":30,"limit":30,"numberOfTopResults":20,"includeAudiobooks":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"02026f48ab5001894e598904079b620ebc64f2d53b55ca20c3858abd3a46c5fb"}}
		*/
		
		// get HTML
		try{
			
			$html =
				$this->get(
					$ip,
					"https://open.spotify.com/search/" .
					rawurlencode($search) .
					($category != "any" ? "/" . $category : ""),
					[]
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get initial search page");
		}
		
		// grep bearer and client ID
		$this->fuckhtml->load($html);
		
		$script =
			$this->fuckhtml
			->getElementById(
				"session",
				"script"
			);
		
		if($script === null){
			
			throw new Exception("Failed to grep bearer token");
		}
		
		$script =
			json_decode(
				$script["innerHTML"],
				true
			);
		
		$bearer = $script["accessToken"];
		$client_id = $script["clientId"];
		
		// hit client ID endpoint
		try{
			
			$token =
				json_decode(
					$this->get(
						$ip,
						"https://clienttoken.spotify.com/v1/clienttoken",
						[ // !! that shit must be sent as json data
							"client_data" => [
								"client_id" => $client_id,
								"client_version" => "1.2.27.93.g7aee53d4",
								"js_sdk_data" => [
									"device_brand" => "unknown",
									"device_id" => "4c7ca20117ca12288ea8fc7118a9118c",
									"device_model" => "unknown",
									"device_name" => "computer",
									"os" => "windows",
									"os_version" => "NT 10.0"
								]
							]
						],
						self::req_clientid
					),
					true
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch token");
		}
		
		if($token === null){
			
			throw new Exception("Failed to decode token");
		}
		
		$token = $token["granted_token"]["token"];
		
		try{
			
			switch($get["option"]){
				
				case "any":
					$variables = [
						"searchTerm" => $search,
						"offset" => 0,
						"limit" => 10,
						"numberOfTopResults" => 5,
						"includeAudiobooks" => true
					];
					break;
				
				case "audiobooks":
					
					break;
			}
			
			$payload =
				$this->get(
					$ip,
					"https://api-partner.spotify.com/pathfinder/v1/query",
					[
						"operationName" => "searchDesktop",
						"variables" =>
							json_encode(
								[
									"searchTerm" => $search,
									"offset" => 0,
									"limit" => 10,
									"numberOfTopResults" => 5,
									"includeAudiobooks" => true
								]
							),
						"extensions" =>
							json_encode(
								[
									"persistedQuery" => [
										"version" => 1,
										"sha256Hash" => "21969b655b795601fb2d2204a4243188e75fdc6d3520e7b9cd3f4db2aff9591e" // ?
									]
								]
							)
					],
					self::req_api,
					$bearer,
					$token
				);
			
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON results");
		}
		
		if($payload == "Token expired"){
			
			throw new Exception("Grepped spotify token has expired");
		}
		
		$payload = json_decode($payload, true);
		
		if($payload === null){
			
			throw new Exception("Failed to decode JSON results");
		}
		
		//$payload = json_decode(file_get_contents("scraper/spotify.json"), true);
		
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
		
		// get songs
		foreach($payload["data"]["searchV2"]["tracksV2"]["items"] as $result){
			
			if(isset($result["item"])){
				
				$result = $result["item"];
			}
			
			if(isset($result["data"])){
				
				$result = $result["data"];
			}
			
			[$artist, $artist_link] = $this->get_artists($result["artists"]);
			
			$out["song"][] = [
				"title" => $result["name"],
				"description" => null,
				"url" => "https://open.spotify.com/track/" . $result["id"],
				"views" => null,
				"author" => [
					"name" => $artist,
					"url" => $artist_link,
					"avatar" => null
				],
				"thumb" => $this->get_thumb($result["albumOfTrack"]["coverArt"]),
				"date" => null,
				"duration" => $result["duration"]["totalMilliseconds"] / 1000,
				"stream" => [
					"endpoint" => "spotify",
					"url" => "track." . $result["id"]
				]
			];
		}
		
		// get playlists
		foreach($payload["data"]["searchV2"]["playlists"]["items"] as $playlist){
			
			if(isset($playlist["data"])){
				
				$playlist = $playlist["data"];
			}
			
			$avatar = $this->get_thumb($playlist["ownerV2"]["data"]["avatar"]);
			
			$out["playlist"][] = [
				"title" => $playlist["name"],
				"description" => null,
				"author" => [
					"name" => $playlist["ownerV2"]["data"]["name"],
					"url" =>
						"https://open.spotify.com/user/" .
						explode(
							":",
							$playlist["ownerV2"]["data"]["uri"],
							3
						)[2],
					"avatar" => $avatar["url"]
				],
				"thumb" => $this->get_thumb($playlist["images"]["items"][0]),
				"date" => null,
				"duration" => null,
				"url" =>
					"https://open.spotify.com/playlist/" .
					explode(
						":",
						$playlist["uri"],
						3
					)[2]
			];
		}
		
		// get albums
		foreach($payload["data"]["searchV2"]["albums"]["items"] as $album){
			
			if(isset($album["data"])){
				
				$album = $album["data"];
			}
			
			[$artist, $artist_link] = $this->get_artists($album["artists"]);
			
			$out["album"][] = [
				"title" => $album["name"],
				"description" => null,
				"author" => [
					"name" => $artist,
					"url" => $artist_link,
					"avatar" => null
				],
				"thumb" => $this->get_thumb($album["coverArt"]),
				"date" => mktime(0, 0, 0, 0, 32, $album["date"]["year"]),
				"duration" => null,
				"url" =>
					"https://open.spotify.com/album/" .
					explode(
						":",
						$album["uri"],
						3
					)[2]
			];
		}
		
		// get podcasts
		foreach($payload["data"]["searchV2"]["podcasts"]["items"] as $podcast){
			
			if(isset($podcast["data"])){
				
				$podcast = $podcast["data"];
			}
			
			$description = [];
			foreach($podcast["topics"]["items"] as $subject){
				
				$description[] = $subject["title"];
			}
			
			$description = implode(", ", $description);
			
			if($description == ""){
				
				$description = null;
			}
			
			$out["podcast"][] = [
				"title" => $podcast["name"],
				"description" => $description,
				"author" => [
					"name" => $podcast["publisher"]["name"],
					"url" => null,
					"avatar" => null
				],
				"thumb" => $this->get_thumb($podcast["coverArt"]),
				"date" => null,
				"duration" => null,
				"url" =>
					"https://open.spotify.com/show/" .
					explode(
						":",
						$podcast["uri"],
						3
					)[2],
				"stream" => [
					"endpoint" => null,
					"url" => null
				]
			];
		}
		
		// get audio books (put in podcasts)
		foreach($payload["data"]["searchV2"]["audiobooks"]["items"] as $podcast){
			
			if(isset($podcast["data"])){
				
				$podcast = $podcast["data"];
			}
			
			$description = [];
			foreach($podcast["topics"]["items"] as $subject){
				
				$description[] = $subject["title"];
			}
			
			$description = implode(", ", $description);
			
			if($description == ""){
				
				$description = null;
			}
			
			$authors = [];
			foreach($podcast["authors"] as $author){
				
				$authors[] = $author["name"];
			}
			
			$authors = implode(", ", $authors);
			
			if($authors == ""){
				
				$authors = null;
			}
			
			$uri =
				explode(
					":",
					$podcast["uri"],
					3
				)[2];
			
			$out["podcast"][] = [
				"title" => $podcast["name"],
				"description" => $description,
				"author" => [
					"name" => $authors,
					"url" => null,
					"avatar" => null
				],
				"thumb" => $this->get_thumb($podcast["coverArt"]),
				"date" => strtotime($podcast["publishDate"]["isoString"]),
				"duration" => null,
				"url" => "https://open.spotify.com/show/" . $uri,
				"stream" => [
					"endpoint" => "spotify",
					"url" => "episode." . $uri
				]
			];
		}
		
		// get episodes (and place them in podcasts)
		foreach($payload["data"]["searchV2"]["episodes"]["items"] as $podcast){
			
			if(isset($podcast["data"])){
				
				$podcast = $podcast["data"];
			}
			
			$out["podcast"][] = [
				"title" => $podcast["name"],
				"description" => $this->limitstrlen($podcast["description"]),
				"author" => [
					"name" =>
						isset(
							$podcast["podcastV2"]["data"]["publisher"]["name"]
						) ?
						$podcast["podcastV2"]["data"]["publisher"]["name"]
						: null,
					"url" => null,
					"avatar" => null
				],
				"thumb" => $this->get_thumb($podcast["coverArt"]),
				"date" => strtotime($podcast["releaseDate"]["isoString"]),
				"duration" => $podcast["duration"]["totalMilliseconds"] / 1000,
				"url" =>
					"https://open.spotify.com/show/" .
					explode(
						":",
						$podcast["uri"],
						3
					)[2],
				"stream" => [
					"endpoint" => null,
					"url" => null
				]
			];
		}
		
		// get authors
		foreach($payload["data"]["searchV2"]["artists"]["items"] as $user){
			
			if(isset($user["data"])){
				
				$user = $user["data"];
			}
			
			$avatar = $this->get_thumb($user["visuals"]["avatarImage"]);
			
			$out["author"][] = [
				"title" =>
					(
						$user["profile"]["verified"] === true ?
						"✓ " : ""
					) .
					$user["profile"]["name"],
				"followers" => null,
				"description" => null,
				"thumb" => $avatar,
				"url" =>
					"https://open.spotify.com/artist/" .
					explode(
						":",
						$user["uri"],
						3
					)[2]
			];
		}
		
		// get users
		foreach($payload["data"]["searchV2"]["users"]["items"] as $user){
			
			if(isset($user["data"])){
				
				$user = $user["data"];
			}
			
			$avatar = $this->get_thumb($user["avatar"]);
			
			$out["user"][] = [
				"title" => $user["displayName"] . " (@{$user["id"]})",
				"followers" => null,
				"description" => null,
				"thumb" => $avatar,
				"url" => "https://open.spotify.com/user/" . $user["id"]
			];
		}
		
		return $out;
	}
	
	private function get_artists($artists){
		
		$artist_out = [];
		
		foreach($artists["items"] as $artist){
			
			$artist_out[] = $artist["profile"]["name"];
		}
		
		$artist_out =
			implode(", ", $artist_out);
		
		if($artist_out == ""){
			
			return [null, null];
		}
		
		$artist_link =
			$artist === null ?
			null :
			"https://open.spotify.com/artist/" .
			explode(
				":",
				$artists["items"][0]["uri"]
			)[2];
		
		return [$artist_out, $artist_link];
	}
	
	private function get_thumb($cover){
		
		$thumb_out = null;
		
		if($cover !== null){
			foreach($cover["sources"] as $thumb){
				
				if(
					$thumb_out === null ||
					(int)$thumb["width"] > $thumb_out["width"]
				){
					
					$thumb_out = $thumb;
				}
			}
		}
		
		if($thumb_out === null){
			
			return [
				"url" => null,
				"ratio" => null
			];
		}else{
			
			return [
				"url" => $thumb_out["url"],
				"ratio" => "1:1"
			];
		}
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
