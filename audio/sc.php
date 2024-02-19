<?php

new sc_audio();

class sc_audio{
	
	public function __construct(){
		
		include "../data/config.php";
		include "../lib/curlproxy.php";
		$this->proxy = new proxy();
		
		if(isset($_GET["u"])){
			
			/*
				we're now proxying audio
			*/
			$viewkey = $_GET["u"];
			
			if(!isset($_GET["r"])){
				
				$this->do404("Ranges(r) are missing");
			}
			
			$ranges = explode(",", $_GET["r"]);
			
			// sanitize ranges
			foreach($ranges as &$range){
				
				if(!is_numeric($range)){
					
					$this->do404("Invalid range specified");
				}
				
				$range = (int)$range;
			}
			
			// sort ranges (just to make sure)
			sort($ranges);
			
			// convert ranges to pairs
			$last = -1;
			foreach($ranges as &$r){
				
				$tmp = $r;
				$r = [$last + 1, $r];
				
				$last = $tmp;
			}
			
			$browser_headers = getallheaders();
			
			// get the requested range from client
			$client_range = 0;
			foreach($browser_headers as $key => $value){
				
				if(strtolower($key) == "range"){
					
					preg_match(
						'/bytes=([0-9]+)/',
						$value,
						$client_regex
					);
					
					if(isset($client_regex[1])){
						
						$client_range = (int)$client_regex[1];
					}else{
						
						$client_range = 0;
					}
					break;
				}
			}
			
			if(
				$client_range < 0 ||
				$client_range > $ranges[count($ranges) - 1][1]
			){
				
				// range is not satisfiable
				http_response_code(416);
				header("Content-Type: text/plain");
				die();
			}
			
			$rng = null;
			for($i=0; $i<count($ranges); $i++){
				
				if($ranges[$i][0] <= $client_range){
					
					$rng = $ranges[$i];
				}
			}
			
			// proxy data!
			http_response_code(206); // partial content
			header("Accept-Ranges: bytes");
			header("Content-Range: bytes {$rng[0]}-{$rng[1]}/" . ($ranges[count($ranges) - 1][1] + 1));
			
			$viewkey =
				preg_replace(
					'/\/media\/([0-9]+)\/[0-9]+\/[0-9]+/',
					'/media/$1/' . $rng[0] . '/' . $rng[1],
					$viewkey
				);
			
			try{
				
				$this->proxy->stream_linear_audio(
					$viewkey
				);
			}catch(Exception $error){
				
				$this->do404("Could not read stream");
			}
			
			die();
		}
		
		/*
			redirect user to correct resource
			we need to scrape and store the byte positions in the result URL
		*/
		if(!isset($_GET["s"])){
			
			$this->do404("The URL(s) parameter is missing");
		}
		
		$viewkey = $_GET["s"];
		
		if(
			preg_match(
				'/soundcloud\.com$/',
				parse_url($viewkey, PHP_URL_HOST)
			) === false
		){
			
			$this->do404("This endpoint can only be used for soundcloud streams");
		}
		
		try{
			
			$json = $this->proxy->get($viewkey)["body"];
		}catch(Exception $error){
			
			$this->do404("Curl error: " . $error->getMessage());
		}
		
		$json = json_decode($json, true);
		
		if(!isset($json["url"])){
			
			$this->do404("Could not get URL from JSON");
		}
		
		$viewkey = $json["url"];
		
		$m3u8 = $this->proxy->get($viewkey)["body"];
		
		$m3u8 = explode("\n", $m3u8);
		
		$lineout = null;
		$streampos_arr = [];
		foreach($m3u8 as $line){
			
			$line = trim($line);
			if($line[0] == "#"){
				
				continue;
			}
			
			if($lineout === null){
				$lineout = $line;
			}
			
			preg_match(
				'/\/media\/[0-9]+\/([0-9]+)\/([0-9]+)/',
				$line,
				$matches
			);
			
			if(isset($matches[0])){
				
				$streampos_arr[] = [
					(int)$matches[1],
					(int)$matches[2]
				];
			}
		}
		
		if($lineout === null){
			
			$this->do404("Could not get stream URL");
		}
		
		$lineout =
			preg_replace(
				'/\/media\/([0-9]+)\/[0-9]+\/[0-9]+/',
				'/media/$1/0/0',
				$lineout
			);
		
		$streampos = [];
		
		foreach($streampos_arr as $pos){
			
			$streampos[] = $pos[1];
		}
		
		$streampos = implode(",", $streampos);
		
		header("Location: /audio/sc?u=" . urlencode($lineout) . "&r=$streampos");
		header("Accept-Ranges: bytes");
	}
	
	private function do404($error){
		
		http_response_code(404);
		header("Content-Type: text/plain");
		header("X-Error: $error");
		die();
	}
}
