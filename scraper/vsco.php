<?php

class vsco{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("vsco");
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($proxy, $url, $get = [], $bearer = null){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get_tmp = http_build_query($get);
			$url .= "?" . $get_tmp;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
		if($bearer === null){
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"DNT: 1",
				"Sec-GPC: 1",
				"Connection: keep-alive",
				"Upgrade-Insecure-Requests: 1",
				"Sec-Fetch-Dest: document",
				"Sec-Fetch-Mode: navigate",
				"Sec-Fetch-Site: same-origin",
				"Sec-Fetch-User: ?1",
				"Priority: u=0, i",
				"TE: trailers"]
			);
		}else{
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: */*",
				"Accept-Language: en-US",
				"Accept-Encoding: gzip",
				"Referer: https://vsco.co/search/images/" . urlencode($get["query"]),
				"authorization: Bearer " . $bearer,
				"content-type: application/json",
				"x-client-build: 1",
				"x-client-platform: web",
				"DNT: 1",
				"Sec-GPC: 1",
				"Connection: keep-alive",
				"Sec-Fetch-Dest: empty",
				"Sec-Fetch-Mode: cors",
				"Sec-Fetch-Site: same-origin",
				"Priority: u=0",
				"TE: trailers"]
			);
		}
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		// http2 bypass
		curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
		
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
			
			[$data, $proxy] =
				$this->backend->get(
					$get["npt"], "images"
				);
			
			$data = json_decode($data, true);
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			
			// get bearer token
			try{
				
				$html =
					$this->get(
						$proxy,
						"https://vsco.co/feed"
					);
				
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch feed page");
			}
			
			preg_match(
				'/"tkn":"([A-z0-9]+)"/',
				$html,
				$bearer
			);
			
			if(!isset($bearer[1])){
				
				throw new Exception("Failed to grep bearer token");
			}
			
			$data = [
				"pagination" => [
					"query" => $search,
					"page" => 0,
					"size" => 100
				],
				"bearer" => $bearer[1]
			];
		}
		
		try{
			
			$json =
				$this->get(
					$proxy,
					"https://vsco.co/api/2.0/search/images",
					$data["pagination"],
					$data["bearer"]
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		if(!isset($json["results"])){
			
			throw new Exception("Failed to access results object");
		}
		
		foreach($json["results"] as $image){
			
			$image_domain = parse_url("https://" . $image["responsive_url"], PHP_URL_HOST);
			$thumbnail = explode($image_domain, $image["responsive_url"], 2)[1];
			
			if(substr($thumbnail, 0, 3) != "/1/"){
				
				$thumbnail =
					preg_replace(
						'/^\/[^\/]+/',
						"",
						$thumbnail
					);
			}
			
			$thumbnail = "https://img.vsco.co/cdn-cgi/image/width=480,height=360" . $thumbnail;
			$size =
				$this->image_ratio(
					(int)$image["dimensions"]["width"],
					(int)$image["dimensions"]["height"]
				);
			
			$out["image"][] = [
				"title" => $image["description"],
				"source" => [
					[
						"url" => "https://" . $image["responsive_url"],
						"width" => (int)$image["dimensions"]["width"],
						"height" => (int)$image["dimensions"]["height"]
					],
					[
						"url" => $thumbnail,
						"width" => $size[0],
						"height" => $size[1]
					]
				],
				"url" => "https://" . $image["grid"]["domain"] . "/media/" . $image["imageId"]
			];
		}
		
		// get NPT
		$max_page = ceil($json["total"] / 100);
		$data["pagination"]["page"]++;
		
		if($max_page > $data["pagination"]["page"]){
			
			$out["npt"] =
				$this->backend->store(
					json_encode($data),
					"images",
					$proxy
				);
		}
		
		return $out;
	}
	
	private function image_ratio($width, $height){
		
		$ratio = [
			480 / $width,
			360 / $height
		];
		
		if($ratio[0] < $ratio[1]){
			
			$ratio = $ratio[0];
		}else{
			
			$ratio = $ratio[1];
		}
		
		return [
			floor($width * $ratio),
			floor($height * $ratio)
		];
	}
}
