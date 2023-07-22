<?php

class nextpage{
	
	public function __construct($scraper){
		
		$this->scraper = $scraper;
	}
	
	public function store($payload, $page){
		
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
		
		$key = apcu_inc("key", 1);

		apcu_store(
			$page . "." .
			$this->scraper .
			(string)($key),
			gzdeflate($salt.$iv.$out.$tag),
			420 // cache information for 7 minutes blaze it
		);

		return 
			$this->scraper . $key . "." .
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
		
		return $payload;
	}
}
