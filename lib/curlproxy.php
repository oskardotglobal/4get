<?php

class proxy{
	
	public const req_web = 0;
	public const req_image = 1;
	
	public function __construct($cache = true){
		
		$this->cache = $cache;
	}
	
	public function do404(){
		
		http_response_code(404);
		header("Content-Type: image/png");
		
		$handle = fopen("lib/img404.png", "r");
		echo fread($handle, filesize("lib/img404.png"));
		fclose($handle);
		
		die();
		return;
	}
	
	public function getabsoluteurl($path, $relative){
		
		if($this->validateurl($path)){
			
			return $path;
		}
		
		if(substr($path, 0, 2) == "//"){
			
			return "https:" . $path;
		}
		
		$url = null;
		
		$relative = parse_url($relative);
		$url = $relative["scheme"] . "://";
		
		if(
			isset($relative["user"]) &&
			isset($relative["pass"])
		){
			
			$url .= $relative["user"] . ":" . $relative["pass"] . "@";
		}
		
		$url .= $relative["host"];
		
		if(isset($relative["path"])){
			
			$relative["path"] = explode(
				"/",
				$relative["path"]
			);
			
			unset($relative["path"][count($relative["path"]) - 1]);
			$relative["path"] = implode("/", $relative["path"]);
			
			$url .= $relative["path"];
		}
		
		if(
			strlen($path) !== 0 &&
			$path[0] !== "/"
		){
			
			$url .= "/";
		}
		
		$url .= $path;
		
		return $url;
	}
	
	public function validateurl($url){
		
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
		if(
			filter_var(
				$ip,
				FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
			) === false
		){
			
			return false;
		}
		
		return true;
	}
	
	public function get($url, $reqtype = self::req_web, $acceptallcodes = false, $referer = null, $redirectcount = 0){
		
		if($redirectcount === 5){
			
			throw new Exception("Too many redirects");
		}
		
		if($url == "https://i.imgur.com/removed.png"){
			
			throw new Exception("Encountered imgur 404");
		}
		
		// sanitize URL
		if($this->validateurl($url) === false){
			
			throw new Exception("Invalid URL");
		}
		
		$this->clientcache();
		
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curl, CURLOPT_HEADER, 1);
		
		switch($reqtype){
			case self::req_web:
				curl_setopt(
					$curl,
					CURLOPT_HTTPHEADER,
					[
						"User-Agent: " . config::USER_AGENT,
						"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
						"Accept-Language: en-US,en;q=0.5",
						"Accept-Encoding: gzip, deflate",
						"DNT: 1",
						"Connection: keep-alive",
						"Upgrade-Insecure-Requests: 1",
						"Sec-Fetch-Dest: document",
						"Sec-Fetch-Mode: navigate",
						"Sec-Fetch-Site: none",
						"Sec-Fetch-User: ?1"
					]
				);
				break;
			
			case self::req_image:
				
				if($referer === null){
					$referer = explode("/", $url, 4);
					array_pop($referer);
					
					$referer = implode("/", $referer);
				}
				
				curl_setopt(
					$curl,
					CURLOPT_HTTPHEADER,
					[
						"User-Agent: " . config::USER_AGENT,
						"Accept: image/avif,image/webp,*/*",
						"Accept-Language: en-US,en;q=0.5",
						"Accept-Encoding: gzip, deflate",
						"DNT: 1",
						"Connection: keep-alive",
						"Referer: {$referer}"
					]
				);
				break;
		}
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		
		// limit size of payloads
		curl_setopt($curl, CURLOPT_BUFFERSIZE, 1024);
		curl_setopt($curl, CURLOPT_NOPROGRESS, false);
		curl_setopt(
			$curl,
			CURLOPT_PROGRESSFUNCTION,
			function($downloadsize, $downloaded, $uploadsize, $uploaded
		){
			
			// if $downloaded exceeds 100MB, fuck off
			return ($downloaded > 100000000) ? 1 : 0;
		});
		
		$body = curl_exec($curl);
		
		if(curl_errno($curl)){
			
			throw new Exception(curl_error($curl));
		}
		
		curl_close($curl);
		
		$headers = [];
		$http = null;
		
		while(true){
			
			$header = explode("\n", $body, 2);
			$body = $header[1];
			
			if($http === null){
				
				// http/1.1 200 ok
				$header = explode("/", $header[0], 2);
				$header = explode(" ", $header[1], 3);
				
				$http = [
					"version" => (float)$header[0],
					"code" => (int)$header[1]
				];
				
				continue;
			}
			
			if(trim($header[0]) == ""){
				
				// reached end of headers
				break;
			}
			
			$header = explode(":", $header[0], 2);
			
			// malformed headers
			if(count($header) !== 2){ continue; }
			
			$headers[strtolower(trim($header[0]))] = trim($header[1]);
		}
		
		// check http code
		if(
			$http["code"] >= 300 &&
			$http["code"] <= 309
		){
			
			// redirect
			if(!isset($headers["location"])){
				
				throw new Exception("Broken redirect");
			}
			
			$redirectcount++;
			
			return $this->get($this->getabsoluteurl($headers["location"], $url), $reqtype, $acceptallcodes, $referer, $redirectcount);
		}else{
			if(
				$acceptallcodes === false &&
				$http["code"] > 300
			){
				
				throw new Exception("Remote server returned an error code! ({$http["code"]})");
			}
		}
		
		// check if data is okay
		switch($reqtype){
			
			case self::req_image:
				
				$format = false;
				
				if(isset($headers["content-type"])){
					
					if(stripos($headers["content-type"], "text/html") !== false){
						
						throw new Exception("Server returned html");
					}
					
					if(
						preg_match(
							'/image\/([^ ]+)/i',
							$headers["content-type"],
							$match
						)
					){
						
						$format = strtolower($match[1]);
						
						if(substr(strtolower($format), 0, 2) == "x-"){
							
							$format = substr($format, 2);
						}
					}
				}
				
				return [
					"http" => $http,
					"format" => $format,
					"headers" => $headers,
					"body" => $body
				];
				break;
			
			default:
				
				return [
					"http" => $http,
					"headers" => $headers,
					"body" => $body
				];
				break;
		}
		
		return;
	}
	
	public function stream_linear_image($url, $referer = null){
		
		$this->stream($url, $referer, "image");
	}
	
	public function stream_linear_audio($url, $referer = null){
		
		$this->stream($url, $referer, "audio");
	}
	
	private function stream($url, $referer, $format){
		
		$this->clientcache();
		
		$this->url = $url;
		$this->format = $format;
		
		// sanitize URL
		if($this->validateurl($url) === false){
			
			throw new Exception("Invalid URL");
		}
		
		$curl = curl_init();
		
		// set headers
		if($referer === null){
			$referer = explode("/", $url, 4);
			array_pop($referer);
			
			$referer = implode("/", $referer);
		}
		
		switch($format){
			
			case "image":
				curl_setopt(
					$curl,
					CURLOPT_HTTPHEADER,
					[
						"User-Agent: " . config::USER_AGENT,
						"Accept: image/avif,image/webp,*/*",
						"Accept-Language: en-US,en;q=0.5",
						"Accept-Encoding: gzip, deflate, br",
						"DNT: 1",
						"Connection: keep-alive",
						"Referer: {$referer}"
					]
				);
				break;
			
			case "audio":
				curl_setopt(
					$curl,
					CURLOPT_HTTPHEADER,
					[
						"User-Agent: " . config::USER_AGENT,
						"Accept: audio/webm,audio/ogg,audio/wav,audio/*;q=0.9,application/ogg;q=0.7,video/*;q=0.6,*/*;q=0.5",
						"Accept-Language: en-US,en;q=0.5",
						"Accept-Encoding: gzip, deflate, br",
						"DNT: 1",
						"Connection: keep-alive",
						"Referer: {$referer}"
					]
				);
				break;
		}
		
		// follow redirects
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
		curl_setopt($curl, CURLOPT_AUTOREFERER, 5);
		
		// set url
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_ENCODING, ""); // default encoding
		
		// timeout + disable ssl
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		
		curl_setopt(
			$curl,
			CURLOPT_WRITEFUNCTION,
			function($c, $data){
				
				if(curl_getinfo($c, CURLINFO_HTTP_CODE) !== 200){
					
					throw new Exception("Serber returned a non-200 code");
				}
				
				echo $data;
				return strlen($data);
			}
		);
		
		$this->empty_header = false;
		$this->cont = false;
		$this->headers_tmp = [];
		$this->headers = [];
		curl_setopt(
			$curl,
			CURLOPT_HEADERFUNCTION,
			function($c, $header){
				
				$head = trim($header);
				$len = strlen($head);
				
				if($len === 0){
					
					$this->empty_header = true;
					$this->headers_tmp = [];
				}else{
					
					$this->empty_header = false;
					$this->headers_tmp[] = $head;
				}
				
				foreach($this->headers_tmp as $h){
					
					// parse headers
					$h = explode(":", $h, 2);
					
					if(count($h) !== 2){
						
						if(curl_getinfo($c, CURLINFO_HTTP_CODE) !== 200){
							
							// not HTTP 200, probably a redirect
							$this->cont = false;
						}else{
							
							$this->cont = true;
						}
						
						// is HTTP 200, just ignore that line
						continue;
					}
					
					$this->headers[strtolower(trim($h[0]))] = trim($h[1]);
				}
				
				if(
					$this->cont &&
					$this->empty_header
				){
					
					// get content type
					if(isset($this->headers["content-type"])){
						
						$octet_check = stripos($this->headers["content-type"], "octet-stream");
						
						if(
							stripos($this->headers["content-type"], $this->format) === false &&
							$octet_check === false
						){
							
							throw new Exception("Resource reported invalid Content-Type");
						}
						
					}else{
						
						throw new Exception("Resource is not an {$this->format} (no Content-Type)");
					}
					
					$filetype = explode("/", $this->headers["content-type"]);
					
					if(!isset($filetype[1])){
						
						throw new Exception("Malformed Content-Type header");
					}
					
					if($octet_check !== false){
						
						$filetype[1] = "jpeg";
					}
					
					header("Content-Type: {$this->format}/{$filetype[1]}");
					
					// give payload size
					if(isset($this->headers["content-length"])){
						
						header("Content-Length: {$this->headers["content-length"]}");
					}
					
					// give filename
					$this->getfilenameheader($this->headers, $this->url, $filetype[1]);
				}
				
				return strlen($header);
			}
		);
		
		curl_exec($curl);
		
		if(curl_errno($curl)){
			
			throw new Exception(curl_error($curl));
		}
		
		curl_close($curl);
	}
	
	public function getfilenameheader($headers, $url, $filetype = "jpg"){
		
		// get filename from content-disposition header
		if(isset($headers["content-disposition"])){
			
			preg_match(
				'/filename=([^;]+)/',
				$headers["content-disposition"],
				$filename
			);
			
			if(isset($filename[1])){
				
				header("Content-Disposition: filename=\"" . trim($filename[1], "\"'") . "." . $filetype . "\"");
				return;
			}
		}
		
		// get filename from URL
		$filename = parse_url($url, PHP_URL_PATH);
		
		if($filename === null){
			
			// everything failed! rename file to domain name
			header("Content-Disposition: filename=\"" . parse_url($url, PHP_URL_HOST) . "." . $filetype . "\"");
			return;
		}
		
		// remove extension from filename
		$filename =
			explode(
				".",
				basename($filename)
			);
		
		if(count($filename) > 1){
			array_pop($filename);
		}
		
		$filename = implode(".", $filename);
		
		header("Content-Disposition: inline; filename=\"" . $filename . "." . $filetype . "\"");
		return;
	}
	
	public function getimageformat($payload, &$imagick){
		
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$format = $finfo->buffer($payload["body"]);
		
		if($format === false){
			
			if($payload["format"] === false){
				
				header("X-Error: Could not parse format");
				$this->favicon404();
			}
			
			$format = $payload["format"];
		}else{
			
			$format_tmp = explode("/", $format, 2);
			
			if($format_tmp[0] == "image"){
				
				$format_tmp = strtolower($format_tmp[1]);
				
				if(substr($format_tmp, 0, 2) == "x-"){
					
					$format_tmp = substr($format_tmp, 2);
				}
				
				$format = $format_tmp;
			}
		}
		
		switch($format){
			
			case "tiff": $format = "gif"; break;
			case "vnd.microsoft.icon": $format = "ico"; break;
			case "icon": $format = "ico"; break;
			case "svg+xml": $format = "svg"; break;
		}
		
		$imagick = new Imagick();
		
		if(
			!in_array(
				$format,
				array_map("strtolower", $imagick->queryFormats())
			)
		){
			
			// format could not be found, but imagemagick can
			// sometimes detect it? shit's fucked
			$format = false;
		}
		
		return $format;
	}
	
	public function clientcache(){
		
		if($this->cache === false){
			
			return;
		}
		
		header("Last-Modified: Thu, 01 Oct 1970 00:00:00 GMT");
		$headers = getallheaders();
		
		if(
			isset($headers["If-Modified-Since"]) ||
			isset($headers["If-Unmodified-Since"])
		){
			
			http_response_code(304); // 304: Not Modified
			die();
		}
	}
}
