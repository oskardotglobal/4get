<?php

class solofield{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("solofield");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		return [
			"nsfw" => [
				"display" => "NSFW",
				"option" => [
					"yes" => "Yes",
					"no" => "No",
				]
			]
		];
	}
	
	private function get($proxy, $url, $get = []){
		
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
			"Referer: https://solofield.net",
			"DNT: 1",
			"Connection: keep-alive",
			"Cookie: cross-site-cookie=name; lno=35842050",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: same-origin",
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
		
		if($get["npt"]){
			
			[$query, $proxy] = $this->backend->get($get["npt"], "web");
			
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://solofield.net/search?" . $query,
						[]
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
						"https://solofield.net/search",
						[
							"q" => $get["s"],
							"ie" => "UTF-8",
							"oe" => "UTF-8",
							"hl" => "ja", // changing this doesnt do anything
							"lr" => "lang_ja", // same here
							//"ls" => "", // ??
							"f" => ($get["nsfw"] == "yes" ? "off" : "on")
						]
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
		
		// check for errors and load the result div
		if($this->error_and_load($html)){
			
			return $out;
		}
		
		$items =
			$this->fuckhtml
			->getElementsByClassName(
				"g0",
				"li"
			);
		
		foreach($items as $item){
			
			$this->fuckhtml->load($item);
			
			$title_tag =
				$this->fuckhtml
				->getElementsByClassName(
					"r",
					"h3"
				);
			
			if(count($title_tag) === 0){
				
				continue;
			}
			
			$this->fuckhtml->load($title_tag[0]);
			
			$link =
				$this->fuckhtml
				->getTextContent(
					$this->fuckhtml
					->getElementsByTagName(
						"a"
					)[0]
					["attributes"]
					["href"]
				);
			
			$this->fuckhtml->load($item);
			$thumb =
				$this->fuckhtml
				->getElementsByClassName(
					"webshot",
					"img"
				);
			
			if(count($thumb) !== 0){
				
				$uri =
					$this->fuckhtml
					->getTextContent(
						$thumb[0]
						["attributes"]
						["src"]
					);
				
				if(stripos($uri, "now_printing") === false){
					
					$thumb = [
						"ratio" => "1:1",
						"url" =>
							"https://solofield.net" .
							$this->fuckhtml
							->getTextContent(
								$thumb[0]
								["attributes"]
								["src"]
							)
					];
				}else{
					
					$thumb = [
						"ratio" => null,
						"url" => null
					];
				}
			}else{
				
				$thumb = [
					"ratio" => null,
					"url" => null
				];
			}
			
			$out["web"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$title_tag[0]
					),
				"description" =>
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByClassName(
							"s",
							"div"
						)[0]
					),
				"url" => $link,
				"date" => null,
				"type" => "web",
				"thumb" => $thumb,
				"sublink" => [],
				"table" => []
			];
		}
		
		// get next page
		$this->get_npt($html, $proxy, $out, "web");
		
		return $out;
	}
	
	
	public function image($get){
		
		// no pagination
		$html =
			$this->get(
				$this->backend->get_ip(),
				"https://solofield.net/isearch",
				[
					"q" => $get["s"],
					"ie" => "UTF-8",
					"oe" => "UTF-8",
					"hl" => "ja", // changing this doesnt do anything
					//"lr" => "lang_ja", // same here
					"ls" => "", // ??
					"f" => ($get["nsfw"] == "yes" ? "off" : "on")
				]
			);
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		// check for errors and load the result div
		if($this->error_and_load($html)){
			
			return $out;
		}
		
		$images =
			$this->fuckhtml
			->getElementsByTagName(
				"li"
			);
		
		foreach($images as $image){
			
			$this->fuckhtml->load($image);
			
			$img =
				$this->fuckhtml
				->getElementsByTagName(
					"img"
				);
			
			if(count($img) === 0){
				
				// ?? invalid
				continue;
			}
			
			$img = $img[0];
			
			$size =
				explode(
					"x",
					$this->fuckhtml
					->getTextContent(
						$image
					),
					2
				);
			
			$size = [
				(int)trim($size[0]), // width
				(int)trim($size[1])  // height
			];
			
			$out["image"][] = [
				"title" => null,
				"source" => [
					[
						"url" =>
							"https://solofield.net/" .
							$this->fuckhtml
							->getTextContent(
								$img["attributes"]["src"]
							),
						"width" => $size[0],
						"height" => $size[1]
					]
				],
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByTagName(
							"a"
						)[0]
						["attributes"]
						["href"]
					)
			];
		}
		
		return $out;
	}
	
	
	public function video($get){
		
		if($get["npt"]){
			
			[$query, $proxy] = $this->backend->get($get["npt"], "videos");
			
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://solofield.net/vsearch?" . $query,
						[]
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
						"https://solofield.net/vsearch",
						[
							"q" => $get["s"],
							"ie" => "UTF-8",
							"oe" => "UTF-8",
							"hl" => "ja", // changing this doesnt do anything
							//"lr" => "lang_ja", // same here
							"ls" => "", // ??
							"f" => ($get["nsfw"] == "yes" ? "off" : "on")
						]
					);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
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
		
		// check for errors and load the result div
		if($this->error_and_load($html)){
			
			return $out;
		}
		
		$items =
			$this->fuckhtml
			->getElementsByTagName(
				"li"
			);
		
		foreach($items as $item){
			
			$this->fuckhtml->load($item);
			
			$as =
				$this->fuckhtml
				->getElementsByTagName(
					"a"
				);
			
			if(count($as) === 0){
				
				continue;
			}
			
			$thumb =
				$this->fuckhtml
				->getElementsByTagName(
					"img"
				);
			
			if(count($thumb) !== 0){
				
				$thumb = [
					"ratio" => "16:9",
					"url" =>
						"https://solofield.net/" .
						$thumb[0]
						["attributes"]
						["src"]
				];
			}else{
				
				$thumb = [
					"ratio" => null,
					"url" => null
				];
			}
			
			$date =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"style",
					"font-size: 10px;",
					"span"
				);
			
			if(count($date) !== 0){
				
				$date =
					$this->unfuckdate(
						$this->fuckhtml
						->getTextContent(
							$date[0]
						)
					);
			}else{
				
				$date = null;
			}
			
			$center_td =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"align",
					"center",
					"td"
				);
			
			if(count($center_td) === 2){
				
				$duration =
					$this->fuckhtml
					->getTextContent(
						$this->hms2int(
							$center_td[0]
						)
					);
			}else{
				
				$duration = null;
			}
			
			$out["video"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$as[1]
					),
				"description" => null,
				"author" => [
					"name" => null,
					"url" => null,
					"avatar" => null
				],
				"date" => $date,
				"duration" => $duration,
				"views" => null,
				"thumb" => $thumb,
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$as[0]
						["attributes"]
						["href"]
					)
			];
		}
		
		// get next page
		$this->get_npt($html, $proxy, $out, "videos");
		
		return $out;
	}
	
	
	private function get_npt($html, $proxy, &$out, $type){
		
		// get next page
		$this->fuckhtml->load($html);
		
		$pjs =
			$this->fuckhtml
			->getElementById(
				"pjs"
			);
		
		if($pjs){
			
			$alnk =
				$this->fuckhtml
				->getElementsByClassName(
					"alnk",
					"span"
				);
			
			foreach($alnk as $lnk){
				
				if(
					stripos(
						$this->fuckhtml
						->getTextContent(
							$lnk
						),
						"Next"
					) !== false
				){
					
					$this->fuckhtml->load($lnk);
					
					$out["npt"] =
						$this->backend->store(
							parse_url(
								$this->fuckhtml
								->getElementsByTagName(
									"a"
								)[0]
								["attributes"]
								["href"],
								PHP_URL_QUERY
							),
							$type,
							$proxy
						);
				}
			}
		}
	}
	
	private function error_and_load($html){
		
		if(strlen($html) === 0){
			
			throw new Exception("Solofield blocked the request IP");
		}
		
		$this->fuckhtml->load($html);
		
		$list =
			$this->fuckhtml
			->getElementById(
				"list",
				"div"
			);
		
		if($list === false){
			
			$nosearch =
				$this->fuckhtml
				->getElementById(
					"nosearch",
					"div"
				);
			
			if($nosearch){
				
				return true;
			}
			
			throw new Exception("Failed to grep search list");
		}
		
		$this->fuckhtml->load($list);
		return false;
	}
	
	private function unfuckdate($date){
		
		return
			strtotime(
				rtrim(
					preg_replace(
						'/[^0-9]+/',
						"-",
						explode(
							":",
							$date,
							2
						)[1]
					),
					"-"
				)
			);
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
}
