<?php

// https://www.bing.com/search?q=url%3Ahttps%3A%2F%2Flolcat.ca
// https://cc.bingj.com/cache.aspx?q=url%3ahttps%3a%2f%2flolcat.ca&d=4769685974291356&mkt=en-CA&setlang=en-US&w=tEsWuE7HW3Z5AIPQMVkDH4WaotS4LrK-
// <div class="b_attribution" u="0N|5119|4769685974291356|tEsWuE7HW3Z5AIPQMVkDH4WaotS4LrK-" tabindex="0">

new bingcache();

class bingcache{
	
	public function __construct(){
		
		if(
			!isset($_GET["s"]) ||
			$this->validate_url($_GET["s"]) === false
		){
			
			var_dump($this->validate_url($_GET["s"]));
			$this->do404("Please provide a valid URL.");
		}
		
		$url = $_GET["s"];
		
		$curlproc = curl_init();
		
		curl_setopt(
			$curlproc,
			CURLOPT_URL,
			"https://www.bing.com/search?q=url%3A" .
			urlencode($url)
		);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt(
			$curlproc,
			CURLOPT_HTTPHEADER,
			["User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:107.0) Gecko/20100101 Firefox/107.0",
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
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 5);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			$this->do404("Failed to connect to bing servers. Please try again later.");
		}
		
		curl_close($curlproc);
		
		preg_match(
			'/<div class="b_attribution" u="(.*)" tabindex="0">/',
			$data,
			$keys
		);
		
		print_r($keys);
		
		if(count($keys) === 0){
			
			$this->do404("Bing has not archived this URL.");
		}
		
		$keys = explode("|", $keys[1]);
		$count = count($keys);
		
		//header("Location: https://cc.bingj.com/cache.aspx?d=" . $keys[$count - 2] . "&w=" . $keys[$count - 1]);
		echo("Location: https://cc.bingj.com/cache.aspx?d=" . $keys[$count - 2] . "&w=" . $keys[$count - 1]);
	}
	
	public function do404($text){
				
		include "lib/frontend.php";
		$frontend = new frontend();
		
		echo
			$frontend->load(
				"error.html",
				[
					"title" => "Shit",
					"text" => $text
				]
			);
		
		die();
	}
	
	public function validate_url($url){
		
		$url_parts = parse_url($url);
		
		// check if required parts are there
		if(
			!isset($url_parts["scheme"]) ||
			!(
				$url_parts["scheme"] == "http" ||
				$url_parts["scheme"] == "https"
			) ||
			!isset($url_parts["host"])
		){
			return false;
		}
		
		if(
			// if its not an RFC-valid URL
			!filter_var($url, FILTER_VALIDATE_URL)
		){
			return false;
		}
		
		$ip = 
			str_replace(
				["[", "]"], // handle ipv6
				"",
				$url_parts["host"]
			);
		
		// if its not an IP
		if(!filter_var($ip, FILTER_VALIDATE_IP)){
			
			// resolve domain's IP
			$ip = gethostbyname($url_parts["host"] . ".");
		}
		
		// check if its localhost
		return filter_var(
			$ip,
			FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
		);
	}
}
