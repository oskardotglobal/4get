<?php

class ftm{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("ftm");
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($proxy, $url, $search, $offset){
		
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
			["User-Agent: " . config::USER_AGENT,
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

		$this->backend->assign_proxy($curlproc, $proxy);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function image($get){
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		if($get["npt"]){
			
			[$data, $proxy] = $this->backend->get($get["npt"], "images");
			$data = json_decode($data, true);
			
			$count = $data["count"];
			$search = $data["search"];
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$count = 0;
			$proxy = $this->backend->get_ip();
		}
		
		try{
			$json =
				json_decode(
					$this->get(
						$proxy,
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
		
		$out["npt"] =
			$this->backend->store(
				json_encode([
					"count" => $count,
					"search" => $search
				]),
				"images",
				$proxy
			);
		
		return $out;
	}
}
