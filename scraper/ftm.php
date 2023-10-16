<?php

class ftm{
	
	public function __construct(){
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("ftm");
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($url, $search, $offset){
		
		$curlproc = curl_init();
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		$payload =
			json_encode(
				[
					"search" => $search,
					"offset" => $offset
				]
			);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:107.0) Gecko/20100101 Firefox/110.0",
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"Content-Length: " . strlen($payload),
			"Content-Type: application/json",
			"DNT: 1",
			"Connection: keep-alive",
			"Origin: https://findthatmeme.com",
			"Referer: https://findthatmeme.com/?search=" . urlencode($search),
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: none",
			"Sec-Fetch-User: ?1",
			"X-Auth-Key: undefined",
			"X-CSRF-Validation-Header: true"]
		);
		
		curl_setopt($curlproc, CURLOPT_POST, true);
		curl_setopt($curlproc, CURLOPT_POSTFIELDS, $payload);
		
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
	
	public function image($get){
		
		$search = $get["s"];
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		if($get["npt"]){
			
			$count = (int)$this->nextpage->get($get["npt"], "images");
		}else{
			
			$count = 0;
		}
		
		try{
			$json =
				json_decode(
					$this->get(
						"https://findthatmeme.com/api/v1/search",
						$search,
						$count
					),
					true
				);
			
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch JSON");
		}
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		foreach($json as $item){
			
			$count++;
			
			if($item["type"] == "VIDEO"){
				
				$thumb = "thumb/" . $item["thumbnail"];
			}else{
				
				$thumb = $item["image_path"];
			}
			
			$out["image"][] = [
				"title" => date("jS \of F Y @ g:ia", strtotime($item["created_at"])),
				"source" => [
					[
						"url" =>
							"https://findthatmeme.us-southeast-1.linodeobjects.com/" .
							$thumb,
						"width" => null,
						"height" => null
					]
				],
				"url" => $item["source_page_url"]
			];
		}
		
		if($count === 50){
			
			$out["npt"] =
				$this->nextpage->store(
					$count,
					"images"
				);
		}
		
		return $out;
	}
}
