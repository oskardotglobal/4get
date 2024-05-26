<?php

class marginalia{
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		$this->backend = new backend("marginalia");
	}
	
	public function getfilters($page){
		
		if(config::MARGINALIA_API_KEY === null){
			
			$base = [
				"adtech" => [
					"display" => "Reduce adtech",
					"option" => [
						"no" => "No",
						"yes" => "Yes"
					]
				],
				"recent" => [
					"display" => "Recent results",
					"option" => [
						"no" => "No",
						"yes" => "Yes"
					]
				],
				"intitle" => [
					"display" => "Search in title",
					"option" => [
						"no" => "No",
						"yes" => "Yes"
					]
				]
			];
		}else{
			
			$base = [];
		}
		
		return array_merge(
			$base,
			[
				"format" => [
					"display" => "Format",
					"option" => [
						"any" => "Any format",
						"html5" => "html5",
						"xhtml" => "xhtml",
						"html123" => "html123"
					]
				],
				"file" => [
					"display" => "Filetype",
					"option" => [
						"any" => "Any filetype",
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
			]
		);
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
		
		$search = [$get["s"]];
		if(strlen($get["s"]) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
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
		
		if(config::MARGINALIA_API_KEY !== null){
			
			try{
				$json =
					$this->get(
						$this->backend->get_ip(), // no nextpage
						"https://api.marginalia.nu/" . config::MARGINALIA_API_KEY . "/search/" . urlencode($search),
						[
							"count" => 20
						]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to get JSON");
			}
			
			if($json == "Slow down"){
				
				throw new Exception("The API key used is rate limited. Please try again in a few minutes.");
			}
			
			$json = json_decode($json, true);
			
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
		
		// no more cloudflare!! Parse html by default
		$params = [
			"query" => $search
		];
		
		foreach(["adtech", "recent", "intitle"] as $v){
			
			if($get[$v] == "yes"){
				
				switch($v){
					
					case "adtech": $params["adtech"] = "reduce"; break;
					case "recent": $params["recent"] = "recent"; break;
					case "adtech": $params["searchTitle"] = "title"; break;
				}
			}
		}
		
		try{
			$html =
				$this->get(
					$this->backend->get_ip(),
					"https://search.marginalia.nu/search",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get HTML");
		}
		
		$this->fuckhtml->load($html);
		
		$sections =
			$this->fuckhtml
			->getElementsByClassName(
				"card search-result",
				"section"
			);
		
		foreach($sections as $section){
			
			$this->fuckhtml->load($section);
			
			$title =
				$this->fuckhtml
				->getElementsByClassName(
					"title",
					"a"
				)[0];
			
			$description =
				$this->fuckhtml
				->getElementsByClassName(
					"description",
					"p"
				);
			
			if(count($description) !== 0){
				
				$description =
					$this->fuckhtml
					->getTextContent(
						$description[0]
					);
			}else{
				
				$description = null;
			}
			
			$sublinks = [];
			$sublink_html =
				$this->fuckhtml
				->getElementsByClassName("additional-results");
			
			if(count($sublink_html) !== 0){
				
				$this->fuckhtml->load($sublink_html[0]);
				
				$links =
					$this->fuckhtml
					->getElementsByTagName("a");
				
				foreach($links as $link){
					
					$sublinks[] = [
						"title" =>
							$this->fuckhtml
							->getTextContent(
								$link
							),
						"date" => null,
						"description" => null,
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$link["attributes"]["href"]
							)
					];
				}
			}
			
			$out["web"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$title
					),
				"description" => $description,
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$title["attributes"]["href"]
					),
				"date" => null,
				"type" => "web",
				"thumb" => [
					"url" => null,
					"ratio" => null
				],
				"sublink" => $sublinks,
				"table" => []
			];
		}
		
		return $out;
	}
}
	
