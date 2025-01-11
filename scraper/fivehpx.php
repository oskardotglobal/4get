<?php

class fivehpx{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("fivehpx");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		return [
			"sort" => [
				"display" => "Sort",
				"option" => [
					"relevance" => "Relevance",
					"pulse" => "Pulse",
					"newest" => "Newest"
				]
			]
		];
	}
	
	private function get($proxy, $url, $get = [], $post_data = null){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		
		if($post_data === null){
			
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
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"Referer: https://500px.com/",
				"content-type: application/json",
				//"x-csrf-token: undefined",
				"x-500px-source: Search",
				"Content-Length: " . strlen($post_data),
				"Origin: https://500px.com",
				"DNT: 1",
				"Sec-GPC: 1",
				"Connection: keep-alive",
				// "Cookie: _pin_unauth, _fbp, _sharedID, _sharedID_cst",
				"Sec-Fetch-Dest: empty",
				"Sec-Fetch-Mode: cors",
				"Sec-Fetch-Site: same-site",
				"Priority: u=4",
				"TE: trailers"]
			);
						
			// set post data
			curl_setopt($curlproc, CURLOPT_POST, true);
			curl_setopt($curlproc, CURLOPT_POSTFIELDS, $post_data);
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
			
			[$pagination, $proxy] =
				$this->backend->get(
					$get["npt"], "images"
				);
			
			$pagination = json_decode($pagination, true);
			$search = $pagination["search"];
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$pagination = [
				"sort" => strtoupper($get["sort"]),
				"search" => $search,
				"filters" => [],
				"nlp" => false,
			];
		}
		
		try{
			
			$json =
				$this->get(
					$proxy,
					"https://api.500px.com/graphql",
					[],
					json_encode([
						"operationName" => "PhotoSearchPaginationContainerQuery",
						"variables" => $pagination,
						"query" =>
							'query PhotoSearchPaginationContainerQuery(' .
							(isset($pagination["cursor"]) ? '$cursor: String, ' : "") .
							'$sort: PhotoSort, $search: String!, $filters: [PhotoSearchFilter!], $nlp: Boolean) {  ...PhotoSearchPaginationContainer_query_1vzAZD} fragment PhotoSearchPaginationContainer_query_1vzAZD on Query { photoSearch(sort: $sort, first: 100, ' .
							(isset($pagination["cursor"]) ? 'after: $cursor, ' : "") .
							'search: $search, filters: $filters, nlp: $nlp) { edges { node { id legacyId canonicalPath name description width height images(sizes: [33, 36]) { size url id } } } totalCount pageInfo { endCursor hasNextPage } }}'
					])
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch graphQL object");
		}
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode graphQL object");
		}
		
		if(isset($json["errors"][0]["message"])){
			
			throw new Exception("500px returned an API error: " . $json["errors"][0]["message"]);
		}
		
		if(!isset($json["data"]["photoSearch"]["edges"])){
			
			throw new Exception("No edges returned by API");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		foreach($json["data"]["photoSearch"]["edges"] as $image){
			
			$image = $image["node"];
			$title =
				trim(
					$this->fuckhtml
					->getTextContent(
						$image["name"]
					) . ": " .
					$this->fuckhtml
					->getTextContent(
						$image["description"]
					)
					, " :"
				);
			
			$small = $this->image_ratio(600, $image["width"], $image["height"]);
			$large = $this->image_ratio(2048, $image["width"], $image["height"]);
			
			$out["image"][] = [
				"title" => $title,
				"source" => [
					[
						"url" => $image["images"][1]["url"],
						"width" => $large[0],
						"height" => $large[1]
					],
					[
						"url" => $image["images"][0]["url"],
						"width" => $small[0],
						"height" => $small[1]
					]
				],
				"url" => "https://500px.com" . $image["canonicalPath"]
			];
		}
		
		// get NPT token
		if($json["data"]["photoSearch"]["pageInfo"]["hasNextPage"] === true){
			
			$out["npt"] =
				$this->backend->store(
					json_encode([
						"cursor" => $json["data"]["photoSearch"]["pageInfo"]["endCursor"],
						"search" => $search,
						"sort" => $pagination["sort"],
						"filters" => [],
						"nlp" => false
					]),
					"images",
					$proxy
				);
		}
			
		return $out;
	}
	
	private function image_ratio($longest_edge, $width, $height){
		
		$ratio = [
			$longest_edge / $width,
			$longest_edge / $height
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
