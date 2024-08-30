<?php

class greppr{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("greppr");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($proxy, $url, $get = [], $cookie = false){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
		if($cookie === false){
			
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
				"Sec-Fetch-Site: none",
				"Sec-Fetch-User: ?1"]
			);
		}else{
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"Cookie: PHPSESSID=" . $cookie,
				"DNT: 1",
				"Connection: keep-alive",
				"Upgrade-Insecure-Requests: 1",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: none",
				"Sec-Fetch-User: ?1"]
			);
		}
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		$this->backend->assign_proxy($curlproc, $proxy);
		
		$headers = [];
		
		curl_setopt(
			$curlproc,
			CURLOPT_HEADERFUNCTION,
			function($curlproc, $header) use (&$headers){
				
				$len = strlen($header);
				$header = explode(':', $header, 2);
				
				if(count($header) < 2){
					
					// ignore invalid headers
					return $len;
				}
				
				$headers[strtolower(trim($header[0]))] = trim($header[1]);

				return $len;
			}
		);
				
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		
		return [
			"headers" => $headers,
			"data" => $data
		];
	}
	
	public function web($get, $first_attempt = true){
		
		if($get["npt"]){
			
			[$q, $proxy] = $this->backend->get($get["npt"], "web");
			
			$q = json_decode($q, true);
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
		}
		
		// get token
		// token[0] = static token that changes once a day
		// token[1] = dynamic token that changes on every request
		// token[1] = PHPSESSID cookie
		$tokens = apcu_fetch("greppr_token");
		
		if(
			$tokens === false ||
			$first_attempt === false // force token fetch
		){
			
			// we haven't gotten the token yet, get it
			try{
				
				$response =
					$this->get(
						$proxy,
						"https://greppr.org",
						[]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search tokens");
			}
			
			$tokens = $this->parse_token($response);
			
			if($tokens === false){
				
				throw new Exception("Failed to grep search tokens");
			}
		}
		
		try{
			
			if($get["npt"]){
				
				$params = [
					$tokens[0] => $q["q"],
					"s" => $q["s"],
					"l" => 30,
					"n" => $tokens[1]
				];
			}else{
				
				$params = [
					$tokens[0] => $search,
					"n" => $tokens[1]
				];
			}
			
			$searchresults = $this->get(
				$proxy,
				"https://greppr.org/search",
				$params,
				$tokens[2]
			);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch search page");
		}
		
		if(strlen($searchresults["data"]) === 0){
			
			// redirected to main page, which means we got old token
			// generate a new one
			
			// ... unless we just tried to do that
			if($first_attempt === false){
				
				throw new Exception("Failed to get a new search token");
			}
			
			return $this->web($get, false);
		}
		
		// refresh the token with new data (this also triggers fuckhtml load)
		$this->parse_token($searchresults, $tokens[2]);
		
		// response object
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
		
		// get results for later
		$results =
			$this->fuckhtml
			->getElementsByClassName(
				"result",
				"div"
			);
		
		// check for next page
		$next_elem =
			$this->fuckhtml
			->getElementsByClassName(
				"pagination",
				"ul"
			);
		
		if(count($next_elem) !== 0){
			
			$this->fuckhtml->load($next_elem[0]);
			
			$as =
				$this->fuckhtml
				->getElementsByClassName(
					"page-link",
					"a"
				);
			
			$break = false;
			foreach($as as $a){
				
				if($break === true){
					
					parse_str(
						$this->fuckhtml
						->getTextContent(
							$a["attributes"]["href"]
						),
						$values
					);
					
					$values = array_values($values);
					
					$out["npt"] =
						$this->backend->store(
							json_encode(
								[
									"q" => $values[0],
									"s" => $values[1]
								]
							),
							"web",
							$proxy
						);
					break;
				}
				
				if($a["attributes"]["href"] == "#"){
					
					$break = true;
				}
			}
		}
		
		// scrape results
		foreach($results as $result){
			
			$this->fuckhtml->load($result);
			
			$a =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				)[0];
			
			$description =
				$this->fuckhtml
				->getElementsByClassName(
					"highlightedDesc",
					"p"
				);
			
			if(count($description) === 0){
				
				$description = null;
			}else{
				
				$description =
					$this->limitstrlen(
						$this->fuckhtml
						->getTextContent(
							$description[0]
						)
					);
			}
			
			$date =
				$this->fuckhtml
				->getElementsByTagName(
					"p"
				);
			
			$date =
				strtotime(
					explode(
						":",
						$this->fuckhtml
						->getTextContent(
							$date[count($date) - 1]["innerHTML"]
						)
					)[1]
				);
			
			$out["web"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$a["innerHTML"]
					),
				"description" => $description,
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$a["attributes"]["href"]
					),
				"date" => $date,
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
	
	private function parse_token($response, $cookie = false){
		
		$this->fuckhtml->load($response["data"]);

		$scripts =
			$this->fuckhtml
			->getElementsByTagName("script");
		
		$found = false;
		foreach($scripts as $script){
			
			preg_match(
				'/window\.location ?= ?\'\/search\?([^=]+).*&n=([0-9]+)/',
				$script["innerHTML"],
				$tokens
			);
			
			if(isset($tokens[1])){
				
				$found = true;
				break;
			}
		}
		
		if($found === false){
			
			return false;
		}
		
		$tokens = [
			$tokens[1],
			$tokens[2]
		];
		
		if($cookie !== false){
			
			// we already specified a cookie, so use the one we have already
			$tokens[] = $cookie;
			apcu_store("greppr_token", $tokens);
			
			return $tokens;
		}
		
		if(!isset($response["headers"]["set-cookie"])){
			
			// server didn't send a cookie
			return false;
		}
		
		// get cookie
		preg_match(
			'/PHPSESSID=([^;]+)/',
			$response["headers"]["set-cookie"],
			$cookie
		);
		
		if(!isset($cookie[1])){
			
			// server sent an unexpected cookie
			return false;
		}
		
		$tokens[] = $cookie[1];
		apcu_store("greppr_token", $tokens);
		
		return $tokens;
	}
	
	private function limitstrlen($text){
		
		return explode("\n", wordwrap($text, 300, "\n"))[0];
	}
}
