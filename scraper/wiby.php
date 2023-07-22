<?php

class wiby{
	
	public function __construct(){
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("wiby");
	}
	
	public function getfilters($page){
		
		if($page != "web"){
			
			return [];
		}
		
		return [
			"nsfw" => [
				"display" => "NSFW",
				"option" => [
					"yes" => "Yes",
					"no" => "No"
				]
			],
			"date" => [
				"display" => "Time posted",
				"option" => [
					"any" => "Any time",
					"day" => "Past day",
					"week" => "Past week",
					"month" => "Past month",
					"year" => "Past year",
				]
			]
		];
	}
	
	private function get($url, $get = [], $nsfw){
		
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
			"Cookie: ws={$nsfw}",
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
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function web($get){
		
		if($get["npt"]){
			
			$q =
				json_decode(
					$this->nextpage->get($get["npt"], "web"),
					true
				);
			
			$nsfw = $q["nsfw"];
			unset($q["nsfw"]);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$date = $get["date"];
			$nsfw = $get["nsfw"] == "yes" ? "0" : "1";
			
			$search =
				str_replace(
					[
						"!g",
						"!gi",
						"!gv",
						"!gm",
						"!b",
						"!bi",
						"!bv",
						"!bm",
						"!td",
						"!tw",
						"!tm",
						"!ty",
						"&g",
						"&gi",
						"&gv",
						"&gm",
						"&b",
						"&bi",
						"&bv",
						"&bm",
						"&td",
						"&tw",
						"&tm",
						"&ty",
					],
					"",
					$search
				);
			
			switch($date){
				
				case "day": $search = "!td " . $search; break;
				case "week": $search = "!tw " . $search; break;
				case "month": $search = "!tm " . $search; break;
				case "year": $search = "!ty " . $search; break;
			}
			
			$q = [
				"q" => $search
			];
		}
		
		try{
			$html = $this->get(
				"https://wiby.me/",
				$q,
				$nsfw
			);
		}catch(Exception $error){
			
			throw new Exception("Failed to fetch search page");
		}
		
		preg_match(
			'/<p class="pin"><blockquote>(?:<\/p>)?<br><a class="more" href="\/\?q=[^"]+&p=([0-9]+)">Find more\.\.\.<\/a><\/blockquote>/',
			$html,
			$nextpage
		);
		
		if(count($nextpage) === 0){
			
			$nextpage = null;
		}else{
			
			$nextpage =
				$this->nextpage->store(
					json_encode([
						"q" => $q["q"],
						"p" => (int)$nextpage[1],
						"nsfw" => $nsfw
					]),
					"web"
				);
		}
		
		$out = [
			"status" => "ok",
			"spelling" => [
				"type" => "no_correction",
				"using" => null,
				"correction" => null
			],
			"npt" => $nextpage,
			"answer" => [],
			"web" => [],
			"image" => [],
			"video" => [],
			"news" => [],
			"related" => []
		];
		
		preg_match_all(
			'/<blockquote>[\s]*<a .* href="(.*)">(.*)<\/a>.*<p>(.*)<\/p>[\s]*<\/blockquote>/Ui',
			$html,
			$links
		);
		
		for($i=0; $i<count($links[0]); $i++){
			
			$out["web"][] = [
				"title" => $this->unescapehtml(trim($links[2][$i])),
				"description" => $this->unescapehtml(trim(strip_tags($links[3][$i]))),
				"url" => trim($links[1][$i]),
				"date" => null,
				"type" => "web",
				"thumb" => [
					"url" => null,
					"ratio" => null
				],
				"sublink" => [],
				"table" => []
			];
		}
		
		return $out;
	}
	
	private function unescapehtml($str){
		
		return html_entity_decode(
			str_replace(
				[
					"<br>",
					"<br/>",
					"</br>",
					"<BR>",
					"<BR/>",
					"</BR>",
				],
				"\n",
				$str
			),
			ENT_QUOTES | ENT_XML1, 'UTF-8'
		);
	}
}
