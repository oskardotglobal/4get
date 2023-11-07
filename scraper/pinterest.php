<?php

class pinterest{
	
	public function __construct(){
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("pinterest");

		include "lib/proxy_pool.php";
		$this->proxy = new proxy_pool("pinterest");
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($url, $get = []){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:107.0) Gecko/20100101 Firefox/110.0",
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
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);

		$this->proxy->assign_proxy($curlproc);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function image($get){
		
		$search = $get["s"];
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		$filter = [
			"source_url" => "/search/pins/?q=" . urlencode($search),
			"rs" => "typed",
			"data" =>
				json_encode(
					[
						"options" => [
							"article" => null,
							"applied_filters" => null,
							"appliedProductFilters" => "---",
							"auto_correction_disabled" => false,
							"corpus" => null,
							"customized_rerank_type" => null,
							"filters" => null,
							"query" => $search,
							"query_pin_sigs" => null,
							"redux_normalize_feed" => true,
							"rs" => "typed",
							"scope" => "pins", // pins, boards, videos, 
							"source_id" => null
						],
						"context" => []
					]
				),
			"_" => substr(str_replace(".", "", (string)microtime(true)), 0, -1)
		];
		
		try{
			$json =
				json_decode(
					$this->get(
						"https://www.pinterest.ca/resource/BaseSearchResource/get/",
						$filter
					),
					true
				);
			
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		//print_r($json);
		
		foreach(
			$json
			["resource_response"]
			["data"]
			["results"]
			as $item
		){
			
			switch($item["type"]){
				
				case "pin":
					
					/*
						Handle image object
					*/
					$images = array_values($item["images"]);
					$image = &$images[count($images) - 1]; // original
					$thumb = &$images[1]; // 236x
					
					$title = [];
					
					if(
						isset($item["grid_title"]) &&
						trim($item["grid_title"]) != ""
					){
						
						$title[] = $item["grid_title"];
					}
					
					if(
						isset($item["description"]) &&
						trim($item["description"]) != ""
					){
						
						$title[] = $item["description"];
					}
					
					$title = implode(": ", $title);
					
					if(
						$title == "" &&
						isset($item["board"]["name"]) &&
						trim($item["board"]["name"]) != ""
					){
						
						$title = $item["board"]["name"];
					}
					
					if($title == ""){
						
						$title = null;
					}
					
					$out["image"][] = [
						"title" => $title,
						"source" => [
							[
								"url" => $image["url"],
								"width" => (int)$image["width"],
								"height" => (int)$image["height"]
							],
							[
								"url" => $thumb["url"],
								"width" => (int)$thumb["width"],
								"height" => (int)$thumb["height"]
							]
						],
						"url" => "https://www.pinterest.com/pin/" . $item["id"]
					];
					break;
				
				case "board":
					
					if(isset($item["cover_pin"]["image_url"])){
						
						$image = [
							"url" => $item["cover_pin"]["image_url"],
							"width" => (int)$item["cover_pin"]["size"][0],
							"height" => (int)$item["cover_pin"]["size"][1]
						];
					}elseif(isset($item["image_cover_url_hd"])){
						/*
						$image = [
							"url" => 
							"width" => null,
							"height" => null
						];*/
					}
					break;
			}
		}
		
		return $out;
	}
	
	private function getfullresimage($image, $has_og){
		
		$has_og = $has_og ? "1200x" : "originals";
		
		return
			preg_replace(
				'/https:\/\/i\.pinimg\.com\/[^\/]+\//',
				"https://i.pinimg.com/" . $has_og . "/",
				$image
			);
	}
}
