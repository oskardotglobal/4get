<?php
class backend{
	
	public function __construct($scraper){
		
		$this->scraper = $scraper;
	}
	
	/*
		Proxy stuff
	*/
	public function get_ip(){
		
		$pool = constant("config::PROXY_" . strtoupper($this->scraper));
		if($pool === false){
			
			// we don't want a proxy, fuck off!
			return 'raw_ip::::';
		}
		
		// indent
		$proxy_index_raw = apcu_inc("p." . $this->scraper);
		
		$proxylist = file_get_contents("data/proxies/" . $pool . ".txt");
		$proxylist = explode("\n", $proxylist);

		// ignore empty or commented lines
		$proxylist = array_filter($proxylist, function($entry){
			$entry = ltrim($entry);
			return strlen($entry) > 0 && substr($entry, 0, 1) != "#";
		});
		
		$proxylist = array_values($proxylist);
		
		return $proxylist[$proxy_index_raw % count($proxylist)];
	}
	
	// this function is also called directly on nextpage
	public function assign_proxy(&$curlproc, $ip){
		
		// parse proxy line
		[
			$type,
			$address,
			$port,
			$username,
			$password
		] = explode(":", $ip, 5);
		
		switch($type){
			
			case "raw_ip":
				return;
				break;
			
			case "http":
			case "https":
				curl_setopt($curlproc, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
				curl_setopt($curlproc, CURLOPT_PROXY, $type . "://" . $address . ":" . $port);
				break;
			
			case "socks4":
				curl_setopt($curlproc, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
				curl_setopt($curlproc, CURLOPT_PROXY, $address . ":" . $port);
				break;
			
			case "socks5":
				curl_setopt($curlproc, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
				curl_setopt($curlproc, CURLOPT_PROXY, $address . ":" . $port);
				break;
			
			case "socks4a":
				curl_setopt($curlproc, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4A);
				curl_setopt($curlproc, CURLOPT_PROXY, $address . ":" . $port);
				break;
			
			case "socks5_hostname":
				curl_setopt($curlproc, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5_HOSTNAME);
				curl_setopt($curlproc, CURLOPT_PROXY, $address . ":" . $port);
				break;
		}
		
		if($username != ""){
			
			curl_setopt($curlproc, CURLOPT_PROXYUSERPWD, $username . ":" . $password);
		}
	}
	
	
	
	/*
		Next page stuff
	*/
	public function store($payload, $page, $proxy){
		
		$page = $page[0];
		$password = random_bytes(256); // 2048 bit
		$salt = random_bytes(16);
		$key = hash_pbkdf2("sha512", $password, $salt, 20000, 32, true);
		$iv =
			random_bytes(
				openssl_cipher_iv_length("aes-256-gcm")
			);
		
		$tag = "";
		$out = openssl_encrypt($payload, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag, "", 16);
		
		$requestid = apcu_inc("requestid");
		
		apcu_store(
			$page . "." .
			$this->scraper .
			$requestid,
			gzdeflate($proxy . "," . $salt.$iv.$out.$tag),
			900 // cache information for 15 minutes blaze it
		);

		return 
			$this->scraper . $requestid . "." .
			rtrim(strtr(base64_encode($password), '+/', '-_'), '=');
	}
	
	public function get($npt, $page){
		
		$page = $page[0];
		$explode = explode(".", $npt, 2);
		
		if(count($explode) !== 2){
			
			throw new Exception("Malformed nextPageToken!");
		}
		
		$apcu = $page . "." . $explode[0];
		$key = $explode[1];
		
		$payload = apcu_fetch($apcu);
		
		if($payload === false){
			
			throw new Exception("The nextPageToken is invalid or has expired!");
		}
		
		$key =
			base64_decode(
				str_pad(
					strtr($key, '-_', '+/'),
					strlen($key) % 4,
					'=',
					STR_PAD_RIGHT
				)
			);
		
		$payload = gzinflate($payload);
		
		// get proxy
		[
			$proxy,
			$payload
		] = explode(",", $payload, 2);
		
		$key =
			hash_pbkdf2(
				"sha512",
				$key,
				substr($payload, 0, 16), // salt
				20000,
				32,
				true
			);
		$ivlen = openssl_cipher_iv_length("aes-256-gcm");
		
		$payload =
			openssl_decrypt(
				substr(
					$payload,
					16 + $ivlen,
					-16
				),
				"aes-256-gcm",
				$key,
				OPENSSL_RAW_DATA,
				substr($payload, 16, $ivlen),
				substr($payload, -16)
			);
		
		if($payload === false){
			
			throw new Exception("The nextPageToken is invalid or has expired!");
		}
		
		// remove the key after using
		apcu_delete($apcu);
		
		return [$payload, $proxy];
	}
}
