<?php

class curlie{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("curlie");
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
	}
	
	public function getfilters($page){
		
		if($page != "web"){
			
			return [];
		}
		
		return [
			"lang" => [
				"display" => "Language",
				"option" => [
					"any" => "Any language",
					"en" => "English",
					"de" => "German",
					"fr" => "French",
					"ja" => "Japanese",
					"it" => "Italian",
					"es" => "Spanish",
					"ru" => "Russian",
					"nl" => "Dutch",
					"pl" => "Polish",
					"tr" => "Turkish",
					"da" => "Danish",
					"sv" => "Swedish",
					"no" => "Norwegian",
					"is" => "Icelandic",
					"fo" => "Faroese",
					"fi" => "Finnish",
					"et" => "Estonian",
					"lt" => "Lithuanian",
					"lv" => "Latvian",
					"cy" => "Welsh",
					"ga" => "Irish",
					"gd" => "Scottish Gaelic",
					"br" => "Breton",
					"fy" => "Frisian",
					"frr" => "North Frisian",
					"gem" => "Saterland Frisian",
					"lb" => "Luxembourgish",
					"rm" => "Romansh",
					"pt" => "Portuguese",
					"ca" => "Catalan",
					"gl" => "Galician",
					"eu" => "Basque",
					"ast" => "Asturian",
					"an" => "Aragonese",
					"fur" => "Friulan",
					"sc" => "Sardinian",
					"scn" => "Sicilian",
					"oc" => "Occitan",
					"be" => "Belarusian",
					"cs" => "Czech",
					"hu" => "Hungarian",
					"sk" => "Slovak",
					"uk" => "Ukrainian",
					"csb" => "Kashubian",
					"tt" => "Tatar",
					"ba" => "Bashkir",
					"os" => "Ossetian",
					"sl" => "Slovene",
					"sr" => "Serbian",
					"hr" => "Croatian",
					"bs" => "Bosnian",
					"bg" => "Bulgarian",
					"sq" => "Albanian",
					"ro" => "Romanian",
					"mk" => "Macedonian",
					"el" => "Greek",
					"iw" => "Hebrew",
					"fa" => "Persian",
					"ar" => "Arabic",
					"ku" => "Kurdish",
					"az" => "Azerbaijani",
					"hy" => "Armenian",
					"af" => "Afrikaans",
					"sw" => "Kiswahili",
					"uz" => "Uzbek",
					"kk" => "Kazakh",
					"ky" => "Kyrgyz",
					"tg" => "Tajik",
					"tk" => "Turkmen",
					"ug" => "Uyghurche",
					"hi" => "Hindi",
					"si" => "Sinhalese",
					"gu" => "Gujarati",
					"ur" => "Urdu",
					"mr" => "Marathi",
					"pa" => "Punjabi",
					"bn" => "Bengali",
					"ta" => "Tamil",
					"te" => "Telugu",
					"kn" => "Kannada",
					"zh_CN" => "Chinese Simplified",
					"zh_TW" => "Chinese Traditional",
					"ko" => "Korean",
					"cfr" => "Taiwanese",
					"th" => "Thai",
					"vi" => "Vietnamese",
					"in" => "Indonesian",
					"ms" => "Malay",
					"tl" => "Tagalog",
					"eo" => "Esperanto",
					"ia" => "Interlingua",
					"la" => "Latin"
				]
			]
		];
	}
	
	private function get($proxy, $url, $get = []){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER,
			["User-Agent: " . config::USER_AGENT,
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
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);
		
		$this->backend->assign_proxy($curlproc, $proxy);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function web($get){
		
		if($get["npt"]){
			
			[$query, $proxy] = $this->backend->get($get["npt"], "web");
			
			try{
				$html = $this->get(
					$proxy,
					"https://curlie.org/" . $query,
					[]
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
			
		}else{
			$proxy = $this->backend->get_ip();
			
			$query = [
				"q" => $get["s"],
				"start" => 0,
				"stime" => 92452189 // ?
			];
			
			if($get["lang"] !== "any"){
				
				$query["lang"] = $get["lang"];
			}
			
			try{
				$html = $this->get(
					$proxy,
					"https://curlie.org/search",
					$query
				);
			}catch(Exception $error){
				
				throw new Exception("Failed to fetch search page");
			}
		}
		
		$this->fuckhtml->load($html);
		
		$nextpage =
			$this->fuckhtml
			->getElementsByClassName(
				"next-page",
				"a"
			);
		
		if(count($nextpage) !== 0){
			
			$nextpage =
				$this->backend->store(
					$nextpage[0]["attributes"]["href"],
					"web",
					$proxy
				);
		}else{
			
			$nextpage = null;
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
		
		$items =
			$this->fuckhtml
			->getElementsByClassName(
				"site-item",
				"div"
			);
		
		foreach($items as $item){
			
			$this->fuckhtml->load($item);
			
			$a =
				$this->fuckhtml
				->getElementsByAttributeValue(
					"target",
					"_blank",
					"a"
				)[0];
			
			$description =
				$this->fuckhtml
				->getElementsByClassName("site-descr");
			
			if(count($description) !== 0){
				
				$description =
					$this->fuckhtml
					->getTextContent(
						$description[0]
					);
			}else{
				
				$description = null;
			}
			
			$out["web"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$a
					),
				"description" => $description,
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$a["attributes"]["href"]
					),
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
}
