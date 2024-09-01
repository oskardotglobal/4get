<?php

include "../../data/config.php";
new autocomplete();

class autocomplete{
	
	public function __construct(){
		
		header("Content-Type: application/json");
		
		$this->scrapers = [
			"brave" => "https://search.brave.com/api/suggest?q={searchTerms}",
			"ddg" => "https://duckduckgo.com/ac/?q={searchTerms}&type=list",
			"yandex" => "https://suggest.yandex.com/suggest-ff.cgi?part={searchTerms}&uil=en&v=3&sn=5&lr=21276&yu=4861394161661655015",
			"google" => "https://www.google.com/complete/search?client=mobile-gws-lite&q={searchTerms}",
			"qwant" => "https://api.qwant.com/v3/suggest/?q={searchTerms}&client=opensearch",
			"yep" => "https://api.yep.com/ac/?query={searchTerms}",
			"marginalia" => "https://search.marginalia.nu/suggest/?partial={searchTerms}",
			"yt" => "https://suggestqueries-clients6.youtube.com/complete/search?client=youtube&q={searchTerms}",
			"sc" => "",
			"startpage" => "https://www.startpage.com/suggestions?q={searchTerms}&format=opensearch&segment=startpage.defaultffx&lui=english",
			"kagi" => "https://kagi.com/api/autosuggest?q={searchTerms}",
			"ghostery" => "https://ghosterysearch.com/suggest?q={searchTerms}"
		];
		
		/*
			Sanitize input
		*/
		if(!isset($_GET["s"])){
			
			$this->do404("Missing search(s) parameter");
		}
		
		if(is_string($_GET["s"]) === false){
			
			$this->do404("Invalid search(s) parameter");
		}
		
		if(strlen($_GET["s"]) > 500){
			
			$this->do404("Search(s) exceeds the 500 char length");
		}
		
		/*
			Get $scraper
		*/
		if(!isset($_GET["scraper"])){
			
			if(isset($_COOKIE["scraper_ac"])){
				
				$scraper = $_COOKIE["scraper_ac"];
			}else{
				
				$scraper = "brave"; // default option
			}
		}else{
			
			$scraper = $_GET["scraper"];
		}
		
		if($scraper == "disabled"){
			
			// this shouldnt happen, but let's handle it anyways
			$this->doempty();
		}
		
		// make sure it exists
		if(!isset($this->scrapers[$scraper])){
			
			$scraper = "brave"; // default option
		}
		
		// return results
		switch($scraper){
			
			case "google":
			case "yt":
				// handle google cause they want to be a special snowflake :(
				$js = $this->get($this->scrapers[$scraper], $_GET["s"]);
				
				preg_match(
					'/\((\[.*\])\)/',
					$js,
					$js
				);
				
				if(!isset($js[1])){
					
					$this->doempty();
				}
				
				$js = json_decode($js[1]);
				$json = [];
				
				foreach($js[1] as $item){
					
					$json[] = htmlspecialchars_decode(strip_tags($item[0]));
				}
				
				echo json_encode(
					[
						$_GET["s"],
						$json
					],
					JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE
				);
				break;
			
			case "sc":
				// soundcloud
				chdir("../../");
				include "scraper/sc.php";
				$sc = new sc();
				
				$token = $sc->get_token("raw_ip::::");
				
				$js = $this->get(
					"https://api-v2.soundcloud.com/search/queries?q={searchTerms}&client_id=" . $token . "&limit=10&offset=0&linked_partitioning=1&app_version=1693487844&app_locale=en",
					$_GET["s"]
				);
				
				$js = json_decode($js, true);
				
				if(!isset($js["collection"])){
					
					$this->doempty();
				}
				
				$json = [];
				foreach($js["collection"] as $item){
					
					$json[] = $item["query"];
				}
				
				echo json_encode(
					[
						$_GET["s"],
						$json
					],
					JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE
				);
				break;
			
			case "marginalia":
				$json = $this->get($this->scrapers[$scraper], $_GET["s"]);
				
				$json = json_decode($json, true);
				if($json === null){
					
					
					$this->doempty();
				}
				
				echo json_encode(
					[
						$_GET["s"],
						$json
					],
					JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE
				);
				break;
			
			default:
				// if it respects the openSearch protocol
				$json = json_decode($this->get($this->scrapers[$scraper], $_GET["s"]), true);
				
				echo json_encode(
					[
						$_GET["s"],
						$json[1] // ensure it contains valid key 0
					],
					JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE
				);
				break;
		}
	}
	
	private function get($url, $query){
		
		try{
			$curlproc = curl_init();
			
			$url = str_replace("{searchTerms}", urlencode($query), $url);
			
			curl_setopt($curlproc, CURLOPT_URL, $url);
			
			curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
			curl_setopt($curlproc, CURLOPT_HTTPHEADER,
				["User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0",
				"Accept: application/json, text/javascript, */*; q=0.01",
				"Accept-Language: en-US,en;q=0.5",
				"Accept-Encoding: gzip",
				"DNT: 1",
				"Connection: keep-alive",
				"Sec-Fetch-Dest: empty",
				"Sec-Fetch-Mode: cors",
				"Sec-Fetch-Site: same-site"]
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
		
		}catch(Exception $error){
			
			do404("Curl error: " . $error->getMessage());
		}
	}
	
	private function do404($error){
		
		echo json_encode(
			["error" => $error],
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE
		);
		die();
	}
	
	private function doempty(){
		
		echo json_encode(
			[
				$_GET["s"],
				[]
			],
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE
		);
		die();
	}
}
