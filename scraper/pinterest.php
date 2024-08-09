<?php

class pinterest{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("pinterest");
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
			
			// @TODO
			// post data for next page
			$data = [
				"source_url" => "/search/pins/?q=" . urlencode($search) . "&rs=typed",
				"data" =>
					json_encode(
						[
							// {"options":{"applied_filters":null,"appliedProductFilters":"---","article":null,"auto_correction_disabled":false,"corpus":null,"customized_rerank_type":null,"domains":null,"filters":null,"journey_depth":null,"page_size":null,"price_max":null,"price_min":null,"query_pin_sigs":null,"query":"higurashi","redux_normalize_feed":true,"rs":"typed","scope":"pins","selected_one_bar_modules":null,"source_id":null,"source_module_id":null,"top_pin_id":null,"bookmarks":["Y2JVSG81V2sxcmNHRlpWM1J5VFVad1ZsWlVRbXhpVmtreVZsZHpOV0pIU2tkV2FscFhVbXhhVkZreU1WSmtNREZWVjIxR1RrMXNTbEJXYlhSaFVtMVdjMVZ1U2xaaWEzQnpXVlJPVTJWV1pISlhhM1JYVm10V05sVldVbE5XVjBwMVVXMUdWVll6VFhoVWJYaFhWMVp3Ums1V1RsTmlSbGt5Vm10YWFtVkdWbkpOU0dSUFZsZG9XRmxzWkc5VlZscHlWbGhrYkdKR1NubFdWelZQWVVaYWRHVkVRbFppUmtwVVZrUktWMlJIVWtWV2JHaHBVakZLU0Zkc1pEUmtNVnBZVW10b2FsSXdXbkJXYlRWRFpHeGFSMWRzVG1oaGVrWllXV3RvVTFVeFpFaFZiRUpoVm5wRk1GbHFSbXRYVjA1R1YyczFWMVpHV2pSWFZtaDNVakZrY2sxWVRsaGlhM0JXV1ZSR1MyRkdiRlZTYm1SVVVteHdXbGxWVlRGVk1VbDVWRmhrVjAxdVVuWlVhMXBTWlVaT2MxcEhSbE5TTWswMVdtdGFWMU5YU2paVmJYaFRUVmhDUjFZeU5YZFVNVkY0VjJ0b1ZXRnJOVlpVVmxwTFVURndXR042VmxOV2ExcGFXVlZWTlZVeFNYZE5WRTVYVWtWYVZGWkhNVTlXTVU1WllVWk9hR1ZyV2s1WFZ6QXhZakpPVjFWWWFHRlNWbkJRVm14U1IwMUdXWGxOVkVKVlRWWnNORll5TURWV1YwVjVWV3hDV21FeGNETmFSVnByVjFkS1IyTkhhR2xYUjJkM1ZtdGFhMlF4VVhsVGJGcE9Wa1p3YjFwWGVFdFZWbFp4VW14YWJGWnRVbHBaTUdoTFZHMUtTR1ZJYUZkV2VrWjJWMVphU21ReVJYcGpSbFpwVW10d1RGZHJVa0pPVms1SFZHNVNUbFl3V2xoVmJYUldaVVpaZUZremFGUk5hM0JYVkZaYVYyRkZNSGxWYkVKYVlrWlZlRnBGV210WFIwNUpVMnMxVTFaR1dscFdWekI0VFVaV1IxTllaR3BUUlhCb1dWUkdWbVZHVm5SbFJuQnNZbFpKTWxSVlVYaFBSVGxGV1hwR1QyVnJSVEZVVlZKT1RrVXhSVkpVUWs5bGJFVXhWRmhzZDFOR1ZsWmtNMFp0VWpGYWIxZFhjRXBsUlRGSVZWaHdUbFl4YTNoVVZWSnFUVVUxV0ZadGFFOVNSVnB6Vkd0a1drMUdiRFpUVkVaT1pXMWplRmRzVWxkaFJuQllWVlJTVDJWdFRqWlVNVkpTWlZad2NWcEhkRTlsYTFwMFZGVlNhMkpWTVZWVFZFcE9Wa1pzTmxkWE1WSk9WVEYwVlcweFVGWXdXVFJXUjNSWFYwZGFRbEJVTVRoUFJHTXhUbnBCTlUxRVRUUk5SRVV3VG5wUk5VMTVjRWhWVlhkeFprUlZlRTlFVVRKWlZHc3lUMWRSTWsxVVVUSk9iVnBvV1RKWmVrNTZXWGhPTWs1cFQwUkZNVTlFVm1sTlZGcHBUV3BTYTFsWFRtcE9SR015VG1wVk5GbHFaR2haVjFacldWUmFiVmxxWkdoYVZGWnFUa1JXT0ZSclZsaG1RVDA5fFVIbzVhRkpYZUc1WFYyUlpWVEpHYkdGNk1XWk5ha1ptVFZSR09FOUVZekZPZWtFMVRVUk5ORTFFUlRCT2VsRTFUWGx3U0ZWVmQzRm1SMWw1VFZSUk1WbDZUVEJhUjFGNVQxZFNhVnB0VlRGT1JFVXdXVlJuZVU1cVRUUk5hbU40VDBSSk1VNXFWVEZOYlZwcVdsUnJlRTFFVVhwWmVsVjNXbXBvYkU1dFJYbE9ha0Y2VDFSSk5VMTZWVEJaYWtJNFZHdFdXR1pCUFQwPXxOb25lfDg3NTcwOTAzODAxNDc0OTMqR1FMKnwzMjM3YjM3ZGNhMGU3YjYyYzYzYzAyZGJkNGU1MjdlNzMyMTExMTNlMmUyMzEyOWM2MDAzYmU1ZTlmZjkwYjAwfE5FV3w="]},"context":{}}
						]
					);
			];
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
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
			
			$proxy = $this->backend->get_ip();
		}
		
		try{
			$json =
				json_decode(
					$this->get(
						$proxy,
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
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
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
