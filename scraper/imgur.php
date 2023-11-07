<?php

class imgur{
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		$this->backend = new backend("imgur");
	}
	
	public function getfilters($page){
		
		return [
			"sort" => [ // /score/
				"display" => "Sort by",
				"option" => [
					"score" => "Highest scoring",
					"relevance" => "Most relevant",
					"time" => "Newest first"
				]
			],
			"time" => [ // /score/day/
				"display" => "Time posted",
				"option" => [
					"all" => "All time",
					"day" => "Today",
					"week" => "This week",
					"month" => "This month",
					"year" => "This year"
				]
			],
			"format" => [ // q_type
				"display" => "Format",
				"option" => [
					"any" => "Any format",
					"jpg" => "JPG",
					"png" => "PNG",
					"gif" => "GIF",
					"anigif" => "Animated GIF",
					"album" => "Albums"
				]
			],
			"size" => [ // q_size_px
				"display" => "Size",
				"option" => [
					"any" => "Any size",
					"small" => "Small (500px or less)",
					"med" => "Medium (500px to 2000px)",
					"big" => "Big (2000px to 5000px)",
					"lrg" => "Large (5000px to 10000px)",
					"huge" => "Huge (10000px and above)"
				]
			]
		];
	}
	
	private function get($proxy, $url, $get = []){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?scrolled&" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: " . config::USER_AGENT,
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"DNT: 1",
			"Referer: https://imgur.com/search/",
			"Connection: keep-alive",
			"Sec-Fetch-Dest: empty",
			"Sec-Fetch-Mode: cors",
			"Sec-Fetch-Site: same-origin",
			"TE: trailers",
			"X-Requested-With: XMLHttpRequest"]
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
	
	public function image($get){
		
		if($get["npt"]){
			
			[$filter, $proxy] =
				$this->backend->get(
					$get["npt"],
					"images"
				);
			
			$filter = json_decode($filter, true);
			
			$search = $filter["s"];
			unset($filter["s"]);
			
			$sort = $filter["sort"];
			unset($filter["sort"]);
			
			$time = $filter["time"];
			unset($filter["time"]);
			
			$format = $filter["format"];
			unset($filter["format"]);
			
			$size = $filter["size"];
			unset($filter["size"]);
			
			$page = $filter["page"];
			unset($filter["page"]);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$sort = $get["sort"];
			$time = $get["time"];
			$format = $get["format"];
			$size = $get["size"];
			$page = 0;
			
			$filter = [
				"q" => $search
			];
			
			if($format != "any"){
				
				$filter["q_type"] = $format;
			}
			
			if($size != "any"){
				
				$filter["q_size_px"] = $size;
				$filter["q_size_is_mpx"] = "off";
			}
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		try{
			$html =
				$this->get(
					$proxy,
					"https://imgur.com/search/$sort/$time/page/$page",
					$filter
				);
			
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch HTML");
		}
		
		$this->fuckhtml->load($html);
		
		$posts =
			$this->fuckhtml
			->getElementsByClassName(
				"post",
				"div"
			);
		
		foreach($posts as $post){
			
			$this->fuckhtml->load($post);
			
			$image =
				$this->fuckhtml
				->getElementsByTagName("img")[0];
			
			$image_url = "https:" . substr($this->fuckhtml->getTextContent($image["attributes"]["src"]), 0, -5);
			
			$out["image"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$image["attributes"]["alt"]
					),
				"source" => [
					[
						"url" => $image_url . ".jpg",
						"width" => null,
						"height" => null
					],
					[
						"url" => $image_url . "m.jpg",
						"width" => null,
						"height" => null
					]
				],
				"url" =>
					"https://imgur.com" .
					$this->fuckhtml
					->getTextContent(
						$this->fuckhtml
						->getElementsByClassName(
							"image-list-link",
							"a"
						)
						[0]
						["attributes"]
						["href"]
					)
			];
		}
		
		if(isset($out["image"][0])){
			
			// store nextpage
			$filter["s"] = $search;
			$filter["sort"] = $sort;
			$filter["time"] = $time;
			$filter["format"] = $format;
			$filter["size"] = $size;
			$filter["page"] = $page + 1;
			
			$out["npt"] =
				$this->backend->store(
					json_encode($filter),
					"images",
					$proxy
				);
		}
		
		return $out;
	}
}
