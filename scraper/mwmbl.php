<?php

class mwmbl{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("mwmbl");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($proxy, $url, $get = []){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		// use http2
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: " . config::USER_AGENT,
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"Referer: https://beta.mwmbl.org/",
			"DNT: 1",
			"Sec-GPC: 1",
			"Connection: keep-alive",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: same-origin",
			"Priority: u=0, i",
			"Sec-Fetch-User: ?1"]
		);
		
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
		
		$search = $get["s"];
		if(strlen($search) === 0){
			
			throw new Exception("Search term is empty!");
		}
		
		try{
			$html = $this->get(
				$this->backend->get_ip(), // no next page!
				"https://beta.mwmbl.org/",
				[
					"q" => $search
				]
			);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch HTML. If you're getting a timeout, make sure you have curl-impersonate setup.");
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
		
		$results =
			$this->fuckhtml
			->getElementsByClassName(
				"result",
				"li"
			);
		
		foreach($results as $result){
			
			$this->fuckhtml->load($result);
			
			$p =
				$this->fuckhtml
				->getElementsByTagName("p");
			
			$sublinks = [];
			
			$mores =
				$this->fuckhtml
				->getElementsByClassName(
					"result-link-more",
					"div"
				);
			
			foreach($mores as $more){
				
				$this->fuckhtml->load($more);
				
				$as =
					$this->fuckhtml
					->getElementsByClassName(
						"more",
						"a"
					);
				
				if(count($as) === 0){
					
					// ?? invalid
					continue;
				}
				
				$sublinks[] = [
					"title" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$this->fuckhtml
								->getElementsByClassName(
									"more-title",
									"span"
								)[0]
							)
						),
					"description" =>
						$this->titledots(
							$this->fuckhtml
							->getTextContent(
								$this->fuckhtml
								->getElementsByClassName(
									"more-extract",
									"span"
								)[0]
							)
						),
					"url" =>
						$this->fuckhtml
						->getTextContent(
							$as[0]
							["attributes"]
							["href"]
						)
				];
			}
			
			// reset
			$this->fuckhtml->load($result);
			
			$out["web"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByClassName(
								"title",
								$p
							)[0]
						)
					),
				"description" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByClassName(
								"extract",
								$p
							)[0]
						)
					),
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByTagName("a")
						[0]
						["attributes"]
						["href"]
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
	
	private function titledots($title){
		
		return rtrim($title, "…");
	}
}
