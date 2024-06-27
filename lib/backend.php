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
	public function assign_proxy(&$curlproc, string $ip){
		
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
			case "socks5a":
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
	public function store(string $payload, string $page, string $proxy){
		
		$key = sodium_crypto_secretbox_keygen();
		$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		
		$requestid = apcu_inc("requestid");
		
		apcu_store(
			$page[0] . "." . // first letter of page name
			$this->scraper . // scraper name
			$requestid,
			[
				$nonce,
				$proxy,
				// compress and encrypt
				sodium_crypto_secretbox(
					gzdeflate($payload),
					$nonce,
					$key
				)
			],
			900 // cache information for 15 minutes
		);

		return 
			$this->scraper . $requestid . "." .
			rtrim(strtr(base64_encode($key), '+/', '-_'), '=');
	}
	
	public function get(string $npt, string $page){
		
		$page = $page[0];
		$explode = explode(".", $npt, 2);
		
		if(count($explode) !== 2){
			
			throw new Exception("Malformed nextPageToken!");
		}
		
		$apcu = $page . "." . $explode[0];
		$key = $explode[1];
		
		$payload = apcu_fetch($apcu);
		
		if($payload === false){
			
			throw new Exception("The next page token is invalid or has expired!");
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
		
		// decrypt and decompress data
		$payload[2] =
			gzinflate(
				sodium_crypto_secretbox_open(
					$payload[2], // data
					$payload[0], // nonce
					$key
				)
			);
		
		if($payload[2] === false){
			
			throw new Exception("The next page token is invalid or has expired!");
		}
		
		// remove the key after using successfully
		apcu_delete($apcu);
		
		return [
			$payload[2], // data
			$payload[1] // proxy
		];
	}
}
