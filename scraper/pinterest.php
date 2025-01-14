<?php

class pinterest{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("pinterest");
	}
	
	public function getfilters($page){
		
		return [];
	}
	
	private function get($proxy, $url, $get = [], &$cookies, $header_data_post = null){
		
		$curlproc = curl_init();
		
		if($header_data_post === null){
			
			// handling GET
						
			// extract cookies
			$cookies_tmp = [];
			curl_setopt($curlproc, CURLOPT_HEADERFUNCTION, function($curlproc, $header) use (&$cookies_tmp){
				
				$length = strlen($header);
				
				$header = explode(":", $header, 2);
				
				if(trim(strtolower($header[0])) == "set-cookie"){
					
					$cookie_tmp = explode("=", trim($header[1]), 2);
					
					$cookies_tmp[trim($cookie_tmp[0])] =
						explode(";", $cookie_tmp[1], 2)[0];
				}
				
				return $length;
			});
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: application/json, text/javascript, */*, q=0.01",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"Referer: https://ca.pinterest.com/",
				"X-Requested-With: XMLHttpRequest",
				"X-APP-VERSION: 78f8764",
				"X-Pinterest-AppState: active",
				"X-Pinterest-Source-Url: /",
				"X-Pinterest-PWS-Handler: www/index.js",
				"screen-dpr: 1",
				"is-preload-enabled: 1",
				"DNT: 1",
				"Sec-GPC: 1",
				"Sec-Fetch-Dest: empty",
				"Sec-Fetch-Mode: cors",
				"Sec-Fetch-Site: same-origin",
				"Connection: keep-alive",
				"Alt-Used: ca.pinterest.com",
				"Priority: u=0",
				"TE: trailers"]
			);
			
			if($get !== []){
				$get = http_build_query($get);
				$url .= "?" . $get;
			}
		}else{
			
			// handling POST (pagination)
			$get = http_build_query($get);
			
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: " . config::USER_AGENT,
				"Accept: application/json, text/javascript, */*, q=0.01",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"Content-Type: application/x-www-form-urlencoded",
				"Content-Length: " . strlen($get),
				"Referer: https://ca.pinterest.com/",
				"X-Requested-With: XMLHttpRequest",
				"X-APP-VERSION: 78f8764",
				"X-CSRFToken: " . $cookies["csrf"],
				"X-Pinterest-AppState: active",
				"X-Pinterest-Source-Url: /search/pins/?rs=ac&len=2&q=" . urlencode($header_data_post) . "&eq=" . urlencode($header_data_post),
				"X-Pinterest-PWS-Handler: www/search/[scope].js",
				"screen-dpr: 1",
				"is-preload-enabled: 1",
				"Origin: https://ca.pinterest.com",
				"DNT: 1",
				"Sec-GPC: 1",
				"Sec-Fetch-Dest: empty",
				"Sec-Fetch-Mode: cors",
				"Sec-Fetch-Site: same-origin",
				"Connection: keep-alive",
				"Alt-Used: ca.pinterest.com",
				"Cookie: " . $cookies["cookie"],
				"TE: trailers"]
			);
			
			curl_setopt($curlproc, CURLOPT_POST, true);
			curl_setopt($curlproc, CURLOPT_POSTFIELDS, $get);
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
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
		
		if($header_data_post === null){
			
			if(!isset($cookies_tmp["csrftoken"])){
				
				throw new Exception("Failed to grep CSRF token");
			}
			
			$cookies = "";
			
			foreach($cookies_tmp as $cookie_name => $cookie_value){
				
				$cookies .= $cookie_name . "=" . $cookie_value . "; ";
			}
			
			$cookies = [
				"csrf" => $cookies_tmp["csrftoken"],
				"cookie" => rtrim($cookies, " ;")
			];
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
			
			$search = $data["q"];
			$cookies = $data["cookies"];
			
			try{
				$json =
					$this->get(
						$proxy,
						"https://ca.pinterest.com/resource/BaseSearchResource/get/",
						[
							"source_url" => "/search/pins/?q=" . urlencode($search) . "&rs=typed",
							"data" => json_encode(
								[
									"options" => [
										"applied_unified_filters" => null,
										"appliedProductFilters" => "---",
										"article" => null,
										"auto_correction_disabled" => false,
										"corpus" => null,
										"customized_rerank_type" => null,
										"domains" => null,
										"dynamicPageSizeExpGroup" => null,
										"filters" => null,
										"journey_depth" => null,
										"page_size" => null,
										"price_max" => null,
										"price_min" => null,
										"query_pin_sigs" => null,
										"query" => $data["q"],
										"redux_normalize_feed" => true,
										"request_params" => null,
										"rs" => "typed",
										"scope" => "pins",
										"selected_one_bar_modules" => null,
										"source_id" => null,
										"source_module_id" => null,
										"source_url" => "/search/pins/?q=" . urlencode($search) . "&rs=typed",
										"top_pin_id" => null,
										"top_pin_ids" => null,
										"bookmarks" => [
											$data["bookmark"]
										]
									],
									"context" => []
								],
								JSON_UNESCAPED_SLASHES
							)
						],
						$cookies,
						$search
					);
				
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch JSON");
			}
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
						
			// https://ca.pinterest.com/resource/BaseSearchResource/get/?source_url=%2Fsearch%2Fpins%2F%3Feq%3Dhigurashi%26etslf%3D5966%26len%3D2%26q%3Dhigurashi%2520when%2520they%2520cry%26rs%3Dac&data=%7B%22options%22%3A%7B%22applied_unified_filters%22%3Anull%2C%22appliedProductFilters%22%3A%22---%22%2C%22article%22%3Anull%2C%22auto_correction_disabled%22%3Afalse%2C%22corpus%22%3Anull%2C%22customized_rerank_type%22%3Anull%2C%22domains%22%3Anull%2C%22dynamicPageSizeExpGroup%22%3Anull%2C%22filters%22%3Anull%2C%22journey_depth%22%3Anull%2C%22page_size%22%3Anull%2C%22price_max%22%3Anull%2C%22price_min%22%3Anull%2C%22query_pin_sigs%22%3Anull%2C%22query%22%3A%22higurashi%20when%20they%20cry%22%2C%22redux_normalize_feed%22%3Atrue%2C%22request_params%22%3Anull%2C%22rs%22%3A%22ac%22%2C%22scope%22%3A%22pins%22%2C%22selected_one_bar_modules%22%3Anull%2C%22source_id%22%3Anull%2C%22source_module_id%22%3Anull%2C%22source_url%22%3A%22%2Fsearch%2Fpins%2F%3Feq%3Dhigurashi%26etslf%3D5966%26len%3D2%26q%3Dhigurashi%2520when%2520they%2520cry%26rs%3Dac%22%2C%22top_pin_id%22%3Anull%2C%22top_pin_ids%22%3Anull%7D%2C%22context%22%3A%7B%7D%7D&_=1736116313987
			// source_url=%2Fsearch%2Fpins%2F%3Feq%3Dhigurashi%26etslf%3D5966%26len%3D2%26q%3Dhigurashi%2520when%2520they%2520cry%26rs%3Dac
			// &data=%7B%22options%22%3A%7B%22applied_unified_filters%22%3Anull%2C%22appliedProductFilters%22%3A%22---%22%2C%22article%22%3Anull%2C%22auto_correction_disabled%22%3Afalse%2C%22corpus%22%3Anull%2C%22customized_rerank_type%22%3Anull%2C%22domains%22%3Anull%2C%22dynamicPageSizeExpGroup%22%3Anull%2C%22filters%22%3Anull%2C%22journey_depth%22%3Anull%2C%22page_size%22%3Anull%2C%22price_max%22%3Anull%2C%22price_min%22%3Anull%2C%22query_pin_sigs%22%3Anull%2C%22query%22%3A%22higurashi%20when%20they%20cry%22%2C%22redux_normalize_feed%22%3Atrue%2C%22request_params%22%3Anull%2C%22rs%22%3A%22ac%22%2C%22scope%22%3A%22pins%22%2C%22selected_one_bar_modules%22%3Anull%2C%22source_id%22%3Anull%2C%22source_module_id%22%3Anull%2C%22source_url%22%3A%22%2Fsearch%2Fpins%2F%3Feq%3Dhigurashi%26etslf%3D5966%26len%3D2%26q%3Dhigurashi%2520when%2520they%2520cry%26rs%3Dac%22%2C%22top_pin_id%22%3Anull%2C%22top_pin_ids%22%3Anull%7D%2C%22context%22%3A%7B%7D%7D
			// &_=1736116313987
			
			$source_url = "/search/pins/?q=" . urlencode($search) . "&rs=" . urlencode($search);
			
			$filter = [
				"source_url" => $source_url,
				"rs" => "typed",
				"data" =>
					json_encode(
						[
							"options" => [
								"applied_unified_filters" => null,
								"appliedProductFilters" => "---",
								"article" => null,
								"corpus" => null,
								"customized_rerank_type" => null,
								"domains" => null,
								"dynamicPageSizeExpGroup" => null,
								"filters" => null,
								"journey_depth" => null,
								"page_size" => null,
								"price_max" => null,
								"price_min" => null,
								"query_pin_sigs" => null,
								"query" => $search,
								"redux_normalize_feed" => true,
								"request_params" => null,
								"rs" => "ac",
								"scope" => "pins", // pins, boards, videos, 
								"selected_one_bar_modules" => null,
								"source_id" => null,
								"source_module_id" => null,
								"source_url" => $source_url,
								"top_pin_id" => null,
								"top_pin_ids" => null
							],
							"context" => []
						]
					),
				"_" => substr(str_replace(".", "", (string)microtime(true)), 0, -1)
			];
			
			$proxy = $this->backend->get_ip();
			$cookies = [];
			
			try{
				$json =
					$this->get(
						$proxy,
						"https://ca.pinterest.com/resource/BaseSearchResource/get/",
						$filter,
						$cookies,
						null
					);
				
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch JSON");
			}
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
		
		if(
			!isset(
				$json["resource_response"]
				["status"]
			)
		){
			
			throw new Exception("Unknown API failure");
		}
		
		if($json["resource_response"]["status"] != "success"){
			
			$status = "Got non-OK response: " . $json["resource_response"]["status"];
			
			if(
				isset(
					$json["resource_response"]["message"]
				)
			){
				
				$status .= " - " . $json["resource_response"]["message"];
			}
			
			throw new Exception($status);
		}
		
		if(
			isset(
				$json["resource_response"]["sensitivity"]
				["notices"][0]["description"]["text"]
			)
		){
			
			throw new Exception(
				"Pinterest returned a notice: " .
				$json["resource_response"]["sensitivity"]["notices"][0]["description"]["text"]
			);
		}
		
		// get NPT
		if(isset($json["resource_response"]["bookmark"])){
			
			$out["npt"] =
				$this->backend->store(
					json_encode([
						"q" => $search,
						"bookmark" => $json["resource_response"]["bookmark"],
						"cookies" => $cookies
					]),
					"images",
					$proxy
				);
		}
		
		foreach(
			$json
			["resource_response"]
			["data"]
			["results"]
			as $item
		){
			
			switch($item["type"]){
				
				case "pin":
				case "board":
					
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
						"url" =>
							$item["link"] === null ?
							"https://ca.pinterest.com/pin/" . $item["id"] :
							$item["link"]
					];
					break;
			}
		}
		
		return $out;
	}
}
