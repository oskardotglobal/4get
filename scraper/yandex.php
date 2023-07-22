<?php

class yandex{
	
	/*
		curl functions
	*/
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("yandex");
	}
	
	private function get($url, $get = [], $nsfw){
		
		$curlproc = curl_init();
		
		$search = $get["text"];
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		switch($nsfw){
			case "yes": $nsfw = "0"; break;
			case "maybe": $nsfw = "1"; break;
			case "no": $nsfw = "2"; break;
		}
		
		$headers =
			["User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/113.0",
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Encoding: gzip",
			"Accept-Language: en-US,en;q=0.5",
			"DNT: 1",
			"Cookie: yp=1716337604.sp.family%3A{$nsfw}#1685406411.szm.1:1920x1080:1920x999",
			"Referer: https://yandex.com/images/search?text={$search}",
			"Connection: keep-alive",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: cross-site",
			"Upgrade-Insecure-Requests: 1"];
		
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
	
	public function getfilters($pagetype){
		
		switch($pagetype){
			
			case "images":
				return
				[
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes",
							"maybe" => "Maybe",
							"no" => "No"
						]
					],
					"time" => [
						"display" => "Time posted",
						"option" => [
							"any" => "Any time",
							"week" => "Last week"
						]
					],
					"size" => [
						"display" => "Size",
						"option" => [
							"any" => "Any size",
							"small" => "Small",
							"medium" => "Medium",
							"large" => "Large",
							"wallpaper" => "Wallpaper"
						]
					],
					"color" => [
						"display" => "Colors",
						"option" => [
							"any" => "All colors",
							"color" => "Color images only",
							"gray" => "Black and white",
							"red" => "Red",
							"orange" => "Orange",
							"yellow" => "Yellow",
							"cyan" => "Cyan",
							"green" => "Green",
							"blue" => "Blue",
							"violet" => "Purple",
							"white" => "White",
							"black" => "Black"
						]
					],
					"type" => [
						"display" => "Type",
						"option" => [
							"any" => "All types",
							"photo" => "Photos",
							"clipart" => "White background",
							"lineart" => "Drawings and sketches",
							"face" => "People",
							"demotivator" => "Demotivators"
						]
					],
					"layout" => [
						"display" => "Layout",
						"option" => [
							"any" => "All layouts",
							"horizontal" => "Horizontal",
							"vertical" => "Vertical",
							"square" => "Square"
						]
					],
					"format" => [
						"display" => "Format",
						"option" => [
							"any" => "Any format",
							"jpeg" => "JPEG",
							"png" => "PNG",
							"gif" => "GIF"
						]
					]
				];
				break;
			
			default:
				return [];
				break;
		}
	}

	public function image($get){
		
		if($get["npt"]){
			
			$request =
				json_decode(
					$this->nextpage->get(
						$get["npt"],
						"images"
					),
					true
				);
			
			$nsfw = $request["nsfw"];
			unset($request["nsfw"]);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$nsfw = $get["nsfw"];
			$time = $get["time"];
			$size = $get["size"];
			$color = $get["color"];
			$type = $get["type"];
			$layout = $get["layout"];
			$format = $get["format"];
			/*
			$handle = fopen("scraper/yandex.json", "r");
			$json = fread($handle, filesize("scraper/yandex.json"));
			fclose($handle);*/
			
			// SIZE
			// large
			// 227.0=1;203.0=1;76fe94.0=1;41d251.0=1;75.0=1;371.0=1;291.0=1;307.0=1;f797ee.0=1;1cf7c2.0=1;deca32.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&isize=large&suggest_reqid=486139416166165501540886508227485&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// medium
			// 227.0=1;203.0=1;76fe94.0=1;41d251.0=1;75.0=1;371.0=1;291.0=1;307.0=1;f797ee.0=1;1cf7c2.0=1;deca32.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&isize=medium&suggest_reqid=486139416166165501540886508227485&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// small
			// 227.0=1;203.0=1;76fe94.0=1;41d251.0=1;75.0=1;371.0=1;291.0=1;307.0=1;f797ee.0=1;1cf7c2.0=1;deca32.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&isize=small&suggest_reqid=486139416166165501540886508227485&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// ORIENTATION
			// Horizontal
			// 227.0=1;203.0=1;76fe94.0=1;41d251.0=1;75.0=1;371.0=1;291.0=1;307.0=1;f797ee.0=1;1cf7c2.0=1;deca32.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&iorient=horizontal&suggest_reqid=486139416166165501540886508227485&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Vertical
			// 227.0=1;203.0=1;76fe94.0=1;41d251.0=1;75.0=1;371.0=1;291.0=1;307.0=1;f797ee.0=1;1cf7c2.0=1;deca32.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&iorient=vertical&suggest_reqid=486139416166165501540886508227485&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Square
			// 227.0=1;203.0=1;76fe94.0=1;41d251.0=1;75.0=1;371.0=1;291.0=1;307.0=1;f797ee.0=1;1cf7c2.0=1;deca32.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&iorient=square&suggest_reqid=486139416166165501540886508227485&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// TYPE
			// Photos
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&text=minecraft&type=photo&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// White background
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&text=minecraft&type=clipart&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Drawings and sketches
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&text=minecraft&type=lineart&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// People
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&text=minecraft&type=face&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Demotivators
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&text=minecraft&type=demotivator&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// COLOR
			// Color images only
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=color&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Black and white
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=gray&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Red
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=red&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Orange
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=orange&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Yellow
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=yellow&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Cyan
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=cyan&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Green
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=green&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Blue
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=blue&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Purple
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=violet&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// White
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=white&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// Black
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&icolor=black&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// FORMAT
			// jpeg
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&itype=jpg&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// png
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&itype=png&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// gif
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&itype=gifan&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// RECENT
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&recent=7D&text=minecraft&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			// WALLPAPER
			// 307.0=1;371.0=1;291.0=1;203.0=1;deca32.0=1;f797ee.0=1;1cf7c2.0=1;41d251.0=1;267.0=1;bde197.0=1"},"extraContent":{"names":["i-react-ajax-adapter"]}}}&yu=4861394161661655015&isize=wallpaper&text=minecraft&wp=wh16x9_1920x1080&uinfo=sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080
			
			
			$request = [
				"format" => "json",
				"request" => [
					"blocks" => [
						[
							"block" => "extra-content",
							"params" => (object)[],
							"version" => 2
						],
						[
							"block" => "i-global__params:ajax",
							"params" => (object)[],
							"version" => 2
						],
						[
							"block" => "search2:ajax",
							"params" => (object)[],
							"version" => 2
						],
						[
							"block" => "preview__isWallpaper",
							"params" => (object)[],
							"version" => 2
						],
						[
							"block" => "content_type_search",
							"params" => (object)[],
							"version" => 2
						],
						[
							"block" => "serp-controller",
							"params" => (object)[],
							"version" => 2
						],
						[
							"block" => "cookies_ajax",
							"params" => (object)[],
							"version" => 2
						],
						[
							"block" => "advanced-search-block",
							"params" => (object)[],
							"version" => 2
						]
					],
					"metadata" => [
						"bundles" => [
							"lb" => "AS?(E<X120"
						],
						"assets" => [
							// las base
							"las" => "justifier-height=1;justifier-setheight=1;fitimages-height=1;justifier-fitincuts=1;react-with-dom=1;"
							
							// las default
							//"las" => "justifier-height=1;justifier-setheight=1;fitimages-height=1;justifier-fitincuts=1;react-with-dom=1;227.0=1;203.0=1;76fe94.0=1;215f96.0=1;75.0=1"
						],
						"extraContent" => [
							"names" => [
								"i-react-ajax-adapter"
							]
						]
					]
				]
			];
			
			/*
				Apply filters
			*/
			if($time == "week"){
				$request["recent"] = "7D";
			}
			
			if($size != "any"){
				
				$request["isize"] = $size;
			}
			
			if($type != "any"){
				
				$request["type"] = $type;
			}
			
			if($color != "any"){
				
				$request["icolor"] = $color;
			}
			
			if($layout != "any"){
				
				$request["iorient"] = $layout;
			}
			
			if($format != "any"){
				
				$request["itype"] = $format;
			}
			
			$request["text"] = $search;
			$request["uinfo"] = "sw-1920-sh-1080-ww-1125-wh-999-pd-1-wp-16x9_1920x1080";
			
			$request["request"] = json_encode($request["request"]);
		}
		
		try{
			$json = $this->get(
				"https://yandex.com/images/search",
				$request,
				$nsfw
			);
		}catch(Exception $err){
			
			throw new Exception("Failed to get JSON");
		}
		/*
		$handle = fopen("scraper/yandex.json", "r");
		$json = fread($handle, filesize("scraper/yandex.json"));
		fclose($handle);*/
		
		$json = json_decode($json, true);
		
		if(
			isset($json["type"]) &&
			$json["type"] == "captcha"
		){
			
			throw new Exception("Yandex blocked this 4get instance. Yandex blocks don't last very long, but the block timer gets reset everytime you make another unsuccessful request. Please try again in ~7 minutes.");
		}
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		// get html
		$html = "";
		foreach($json["blocks"] as $block){
			
			$html .= $block["html"];
		}
		
		$this->fuckhtml->load($html);
		$div = $this->fuckhtml->getElementsByTagName("div");
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		// check for next page
		if(
			count(
				$this->fuckhtml
				->getElementsByClassName(
					"more more_direction_next",
					$div
				)
			) !== 0
		){
			
			$request["nsfw"] = $nsfw;
			
			if(isset($request["p"])){
				
				$request["p"]++;
			}else{
				
				$request["p"] = 1;
			}
			
			$out["npt"] = $this->nextpage->store(json_encode($request), "images");
		}
		
		// get search results
		foreach(
			$this->fuckhtml
			->getElementsByClassName(
				"serp-item serp-item_type_search",
				$div
			)
			as $image
		){
			
			$image =
				json_decode(
					$image
					["attributes"]
					["data-bem"],
					true
				)["serp-item"];
			
			$title = [html_entity_decode($image["snippet"]["title"], ENT_QUOTES | ENT_HTML5)];
			
			if(isset($image["snippet"]["text"])){
				
				$title[] = html_entity_decode($image["snippet"]["text"], ENT_QUOTES | ENT_HTML5);
			}

			$tmp = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$this->titledots(
							implode(": ", $title)
						)
					),
				"source" => [],
				"url" => htmlspecialchars_decode($image["snippet"]["url"])
			];
			
			foreach($image["dups"] as $dup){
				
				$tmp["source"][]  = [
					"url" => htmlspecialchars_decode($dup["url"]),
					"width" => (int)$dup["w"],
					"height" => (int)$dup["h"],
				];
			}
			
			$tmp["source"][] = [
				"url" =>
					preg_replace(
						'/^\/\//',
						"https://",
						htmlspecialchars_decode($image["thumb"]["url"])
					),
				"width" => (int)$image["thumb"]["size"]["width"],
				"height" => (int)$image["thumb"]["size"]["height"]
			];
			
			$out["image"][] = $tmp;
		}
		
		return $out;
	}
	
	private function titledots($title){
		
		$substr = substr($title, -3);
		
		if(
			$substr == "..." ||
			$substr == "…"
		){
						
			return trim(substr($title, 0, -3));
		}
		
		return trim($title);
	}
}
