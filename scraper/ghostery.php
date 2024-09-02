<?php

class ghostery{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("ghostery");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		if($page != "web"){
			
			return [];
		}
		
		return [
			"country" => [
				"display" => "Country",
				"option" => [
					"any" => "All regions",
					"AR" => "Argentina",
					"AU" => "Australia",
					"AT" => "Austria",
					"BE" => "Belgium",
					"BR" => "Brazil",
					"CA" => "Canada",
					"CL" => "Chile",
					"DK" => "Denmark",
					"FI" => "Finland",
					"FR" => "France",
					"DE" => "Germany",
					"HK" => "Hong Kong",
					"IN" => "India",
					"ID" => "Indonesia",
					"IT" => "Italy",
					"JP" => "Japan",
					"KR" => "Korea",
					"MY" => "Malaysia",
					"MX" => "Mexico",
					"NL" => "Netherlands",
					"NZ" => "New Zealand",
					"NO" => "Norway",
					"CN" => "People's Republic of China",
					"PL" => "Poland",
					"PT" => "Portugal",
					"PH" => "Republic of the Philippines",
					"RU" => "Russia",
					"SA" => "Saudi Arabia",
					"ZA" => "South Africa",
					"ES" => "Spain",
					"SE" => "Sweden",
					"CH" => "Switzerland",
					"TW" => "Taiwan",
					"TR" => "Turkey",
					"GB" => "United Kingdom",
					"US" => "United States"
				]
			]
		];
	}
	
	private function get($proxy, $url, $get = [], $country){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: " . config::USER_AGENT,
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"Referer: https://ghosterysearch.com",
			"DNT: 1",
			"Sec-GPC: 1",
			"Connection: keep-alive",
			"Cookie: ctry=" . ($country == "any" ? "--" : $country) . "; noads=true",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: same-origin",
			"Sec-Fetch-User: ?1",
			"Priority: u=0, i"]
		);
		
		// http2 bypass
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
			
			[$query, $proxy] = $this->backend->get($get["npt"], "web");
			
			parse_str($query, $query);
			
			// country
			$country = $query["c"];
			unset($query["c"]);
			
			$query = http_build_query($query);
			
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://ghosterysearch.com/search?" . $query,
						[],
						$country
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
		}else{
			
			$proxy = $this->backend->get_ip();
			
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://ghosterysearch.com/search",
						[
							"q" => $get["s"]
						],
						$get["country"]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
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
		
		$this->fuckhtml->load($html);
		
		$results_wrapper =
			$this->fuckhtml
			->getElementsByClassName(
				"results",
				"section"
			);
		
		if(count($results_wrapper) === 0){
			
			throw new Exception("Failed to grep result section");
		}
		
		$this->fuckhtml->load($results_wrapper[0]);
		
		// get search results
		$results =
			$this->fuckhtml
			->getElementsByClassName(
				"result",
				"li"
			);
		
		if(count($results) === 0){
			
			return $out;
		}
		
		foreach($results as $result){
			
			$this->fuckhtml->load($result);
			
			$a =
				$this->fuckhtml
				->getElementsByClassName(
					"url",
					"a"
				);
			
			if(count($a) === 0){
				
				continue;
			}
			
			$a = $a[0];
			
			$out["web"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByTagName(
								"h2"
							)[0]
						)
					),
				"description" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByTagName(
								"p"
							)[0]
						)
					),
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$a
						["attributes"]
						["href"]
					),
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
		
		$this->fuckhtml->load($html);
		
		// get pagination token
		$pagination_wrapper =
			$this->fuckhtml
			->getElementsByClassName(
				"pagination",
				"div"
			);
		
		if(count($pagination_wrapper) !== 0){
			
			// found next page!
			$this->fuckhtml->load($pagination_wrapper[0]);
			
			$a =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($a) !== 0){
				
				$q =
					parse_url(
						$this->fuckhtml
						->getTextContent(
							$a[count($a) - 1]
							["attributes"]
							["href"]
						),
						PHP_URL_QUERY
					);
				
				$out["npt"] =
					$this->backend
					->store(
						$q . "&c=" . $get["country"],
						"web",
						$proxy
					);
			}
		}
		
		return $out;
	}
	
	private function titledots($title){
		
		return trim($title, " .\t\n\r\0\x0B…");
	}
}
