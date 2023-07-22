<?php

class marginalia{
	public function __construct(){
		
		$this->key = "public";
	}
	
	public function getfilters($page){
		
		switch($page){
			
			case "web":
				return [
					"profile" => [
						"display" => "Profile",
						"option" => [
							"any" => "Default",
							"modern" => "Modern"
						]
					],
					"format" => [
						"display" => "Format",
						"option" => [
							"any" => "Any",
							"html5" => "html5",
							"xhtml" => "xhtml",
							"html123" => "html123"
						]
					],
					"file" => [
						"display" => "File",
						"option" => [
							"any" => "Any",
							"nomedia" => "Deny media",
							"media" => "Contains media",
							"audio" => "Contains audio",
							"video" => "Contains video",
							"archive" => "Contains archive",
							"document" => "Contains document"
						]
					],
					"javascript" => [
						"display" => "Javascript",
						"option" => [
							"any" => "Allow JS",
							"deny" => "Deny JS",
							"require" => "Require JS"
						]
					],
					"trackers" => [
						"display" => "Trackers",
						"option" => [
							"any" => "Allow trackers",
							"deny" => "Deny trackers",
							"require" => "Require trackers"
						]
					],
					"cookies" => [
						"display" => "Cookies",
						"option" => [
							"any" => "Allow cookies",
							"deny" => "Deny cookies",
							"require" => "Require cookies"
						]
					],
					"affiliate" => [
						"display" => "Affiliate links in body",
						"option" => [
							"any" => "Allow affiliate links",
							"deny" => "Deny affiliate links",
							"require" => "Require affiliate links"
						]
					]
				];
		}
	}
	
	private function get($url, $get = []){
		
		$headers = [
			"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:107.0) Gecko/20100101 Firefox/110.0",
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
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function web($get){
		
		$search = [$get["s"]];
		$profile = $get["profile"];
		$format = $get["format"];
		$file = $get["file"];
		
		foreach(
			[
				"javascript" => $get["javascript"],
				"trackers" => $get["trackers"],
				"cookies" => $get["cookies"],
				"affiliate" => $get["affiliate"]
			]
			as $key => $value
		){
			
			if($value == "any"){ continue; }
			
			switch($key){
				
				case "javascript": $str = "js:true"; break;
				case "trackers": $str = "special:tracking"; break;
				case "cookies": $str = "special:cookies"; break;
				case "affiliate": $str = "special:affiliate"; break;
			}
			
			if($value == "deny"){
				$str = "-" . $str;
			}
			
			$search[] = $str;
		}
		
		if($format != "any"){
			
			$search[] = "format:$format";
		}
		
		switch($file){
			
			case "any": break;
			case "nomedia": $search[] = "-special:media"; break;
			case "media": $search[] = "special:media"; break;
			
			default:
				$search[] = "file:$file";
		}
		
		$search = implode(" ", $search);
		
		$params = [
			"count" => 20
		];
		
		if($profile == "modern"){
			
			$params["index"] = 1;
		}
		
		try{
			$json =
				$this->get(
					"https://api.marginalia.nu/{$this->key}/search/" . urlencode($search),
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get JSON");
		}
		
		if($json == "Slow down"){
			
			throw new Exception("The API key used is rate limited. Please try again in a few minutes.");
		}
		
		$json = json_decode($json, true);
		/*
		$handle = fopen("scraper/marginalia.json", "r");
		$json = json_decode(fread($handle, filesize("scraper/marginalia.json")), true);
		fclose($handle);*/
		
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
		
		foreach($json["results"] as $result){
			
			$out["web"][] = [
				"title" => $result["title"],
				"description" => str_replace("\n", " ", $result["description"]),
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
		}
		
		return $out;
	}
}
	
