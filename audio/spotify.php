<?php

include "../data/config.php";
new spotify();

class spotify{
	
	public function __construct(){
		
		include "../lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		if(
			!isset($_GET["s"]) ||
			!preg_match(
				'/^(track|episode)\.([A-Za-z0-9]{22})$/',
				$_GET["s"],
				$matches
			)
		){
			
			$this->do404("The track ID(s) parameter is missing or invalid");
		}
		
		try{
			
			if($matches[1] == "episode"){
				
				$uri = "show";
			}else{
				
				$uri = $matches[1];
			}
			
			$embed =
				$this->get("https://embed.spotify.com/{$uri}/" . $matches[2]);
		}catch(Exception $error){
			
			$this->do404("Failed to fetch embed data");
		}
		
		$this->fuckhtml->load($embed);
		
		$json =
			$this->fuckhtml
			->getElementById(
				"__NEXT_DATA__",
				"script"
			);
		
		if($json === null){
			
			$this->do404("Failed to extract JSON");
		}
		
		$json =
			json_decode($json["innerHTML"], true);
		
		if($json === null){
			
			$this->do404("Failed to decode JSON");
		}
		
		switch($matches[1]){
			
			case "track":
				if(
					isset(
						$json
						["props"]
						["pageProps"]
						["state"]
						["data"]
						["entity"]
						["audioPreview"]
						["url"]
					)
				){
					
					header("Content-type: audio/mpeg");
					header(
						"Location: /audio/linear?s=" .
						urlencode(
							$json
							["props"]
							["pageProps"]
							["state"]
							["data"]
							["entity"]
							["audioPreview"]
							["url"]
						)
					);
				}else{
					
					$this->do404("Could not extract playback URL");
				}
				break;
			
			case "episode":
				if(
					isset(
						$json
						["props"]
						["pageProps"]
						["state"]
						["data"]
						["entity"]
						["id"]
					)
				){
					
					try{
						$json =
							$this->get(
								"https://spclient.wg.spotify.com/soundfinder/v1/unauth/episode/" .
								$json
								["props"]
								["pageProps"]
								["state"]
								["data"]
								["entity"]
								["id"] .
								"/com.widevine.alpha"
							);
					}catch(Exception $error){
						
						$this->do404("Failed to fetch audio resource");
					}
					
					$json = json_decode($json, true);
					
					if($json === null){
						
						$this->do404("Failed to decode audio resource JSON");
					}
					
					if(
						isset($json["passthrough"]) &&
						$json["passthrough"] == "ALLOWED" &&
						isset($json["passthroughUrl"])
					){
						
						header(
							"Location:" .
							"/audio/linear.php?s=" .
							urlencode(
								str_replace(
									"http://",
									"https://",
									$json["passthroughUrl"]
								)
							)
						);
					}else{
						
						$this->do404("Failed to find passthroughUrl");
					}
					
				}else{
					
					$this->do404("Failed to find episode ID");
				}
				break;
			}
	}
	
	private function get($url){
		
		$headers = [
			"User-Agent: " . config::USER_AGENT,
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Accept-Encoding: gzip",
			"DNT: 1",
			"Connection: keep-alive",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: none",
			"Sec-Fetch-User: ?1"
		];
		
		$curlproc = curl_init();
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER, $headers);
		
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
	
	private function do404($error){
		
		http_response_code(404);
		header("Content-Type: text/plain");
		header("X-Error: $error");
		die();
	}
}
