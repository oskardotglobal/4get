<?php

class yandex{
	
	/*
		curl functions
	*/
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/backend.php";
		// backend included in the scraper functions
	}
	
	private function get($proxy, $url, $get = [], $nsfw){
		
		$curlproc = curl_init();
		
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
			["User-Agent: " . config::USER_AGENT,
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Encoding: gzip",
			"Accept-Language: en-US,en;q=0.5",
			"DNT: 1",
			"Cookie: yp=1716337604.sp.family%3A{$nsfw}#1685406411.szm.1:1920x1080:1920x999",
			"Referer: https://yandex.com/images/search",
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

		$this->backend->assign_proxy($curlproc, $proxy);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function getfilters($pagetype){
		
		switch($pagetype){
			
			case "web":
				return [
					"lang" => [
						"display" => "Language",
						"option" => [
							"any" => "Any language",
							"en" => "English",
							"ru" => "Russian",
							"be" => "Belorussian",
							"fr" => "French",
							"de" => "German",
							"id" => "Indonesian",
							"kk" => "Kazakh",
							"tt" => "Tatar",
							"tr" => "Turkish",
							"uk" => "Ukrainian"
						]
					],
					"newer" => [
						"display" => "Newer than",
						"option" => "_DATE"
					],
					"older" => [
						"display" => "Older than",
						"option" => "_DATE"
					]
				];
				break;
			
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
			
			case "videos":
				return [
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
							"9" => "Recently"
						]
					],
					"duration" => [
						"display" => "Duration",
						"option" => [
							"any" => "Any duration",
							"short" => "Short"
						]
					]
				];
				break;
		}
	}
	
	public function web($get){
		
		$this->backend = new backend("yandex_w");
		
		// has captcha
		// https://yandex.com/search/touch/?text=lol&app_platform=android&appsearch_header=1&ui=webmobileapp.yandex&app_version=23070603&app_id=ru.yandex.searchplugin&search_source=yandexcom_touch_native&clid=2218567
		
		// https://yandex.com/search/site/?text=minecraft&web=1&frame=1&v=2.0&searchid=3131712
		// &within=777&from_day=26&from_month=8&from_year=2023&to_day=26&to_month=8&to_year=2023
		
		if($get["npt"]){
			
			[$npt, $proxy] = $this->backend->get($get["npt"], "web");
			
			$html =
				$this->get(
					$proxy,
					"https://yandex.com" . $npt,
					[],
					"yes"
				);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$lang = $get["lang"];
			$older = $get["older"];
			$newer = $get["newer"];
			
			$params = [
				"text" => $search,
				"web" => "1",
				"frame" => "1",
				"searchid" => "3131712"
			];
			
			if($lang != "any"){
				
				$params["lang"] = $lang;
			}
			
			if(
				$newer === false &&
				$older !== false
			){
				
				$newer = 0;
			}
			
			if($newer !== false){
				
				$params["from_day"] = date("j", $newer);
				$params["from_month"] = date("n", $newer);
				$params["from_year"] = date("Y", $newer);
				
				if($older === false){
					
					$older = time();
				}
				
				$params["to_day"] = date("j", $older);
				$params["to_month"] = date("n", $older);
				$params["to_year"] = date("Y", $older);
			}
			
			try{
				$html =
					$this->get(
						$proxy,
						"https://yandex.com/search/site/",
						$params,
						"yes"
					);
			}catch(Exception $error){
				
				throw new Exception("Could not get search page");
			}
			
			/*
			$handle = fopen("scraper/yandex.html", "r");
			$html = fread($handle, filesize("scraper/yandex.html"));
			fclose($handle);*/
		}
		
		$out = [
			"status" => "ok",
			"spelling" => [
				"type" => "no_correction",
				"using" => null,
				"correction" => null
			],
			"npt" => null,
			"answer" => [],
			"web" => [],
			"image" => [],
			"video" => [],
			"news" => [],
			"related" => []
		];
		
		$this->fuckhtml->load($html);
		
		// get nextpage
		$npt =
			$this->fuckhtml
			->getElementsByClassName(
				"b-pager__next",
				"a"
			);
		
		if(count($npt) !== 0){
			
			$out["npt"] =
				$this->backend->store(
					$this->fuckhtml
					->getTextContent(
						$npt
						[0]
						["attributes"]
						["href"]
					),
					"web",
					$proxy
				);
		}
		
		// get items
		$items =
			$this->fuckhtml
			->getElementsByClassName(
				"b-serp-item",
				"li"
			);
		
		foreach($items as $item){
			
			$this->fuckhtml->load($item);
			
			$link =
				$this->fuckhtml
				->getElementsByClassName(
					"b-serp-item__title-link",
					"a"
				)[0];
			
			$out["web"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$link
						)
					),
				"description" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$this->fuckhtml
							->getElementsByClassName(
								"b-serp-item__text",
								"div"
							)[0]
						)
					),
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$link
						["attributes"]
						["href"]
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
	
	public function image($get){
		
		$this->backend = new backend("yandex_i");
		
		if($get["npt"]){
			
			[$request, $proxy] =
				$this->backend->get(
					$get["npt"],
					"images"
				);
			
			$request = json_decode($request, true);
			
			$nsfw = $request["nsfw"];
			unset($request["nsfw"]);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
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
				$proxy,
				"https://yandex.com/images/search",
				$request,
				$nsfw,
				"yandex_i"
			);
		}catch(Exception $err){
			
			throw new Exception("Failed to get JSON");
		}
		
		/*
		$handle = fopen("scraper/yandex.json", "r");
		$json = fread($handle, filesize("scraper/yandex.json"));
		fclose($handle);*/
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode JSON");
		}
		
		if(
			isset($json["type"]) &&
			$json["type"] == "captcha"
		){
			
			throw new Exception("Yandex blocked this 4get instance. Please try again in ~7 minutes.");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		// get html
		$html = "";
		foreach($json["blocks"] as $block){
			
			$html .= $block["html"];
			
			// get next page
			if(
				isset($block["params"]["nextPageUrl"]) &&
				!empty($block["params"]["nextPageUrl"])
			){
				
				$request["nsfw"] = $nsfw;
				
				if(isset($request["p"])){
					
					$request["p"]++;
				}else{
					
					$request["p"] = 1;
				}
				
				$out["npt"] =
					$this->backend->store(
						json_encode($request),
						"images",
						$proxy
					);
			}
		}
		
		$this->fuckhtml->load($html);
		
		// get search results
		$data = null;
		
		foreach(
			$this->fuckhtml
			->getElementsByClassName(
				"Root",
				"div"
			) as $div
		){
			
			if(isset($div["attributes"]["data-state"])){
				
				$tmp = json_decode(
					$this->fuckhtml
					->getTextContent(
						$div["attributes"]["data-state"]
					),
					true
				);
				
				if(isset($tmp["initialState"]["serpList"])){
					
					$data = $tmp;
					break;
				}
			}
		}
		
		if($data === null){
			
			throw new Exception("Failed to extract JSON");
		}
		
		foreach($data["initialState"]["serpList"]["items"]["entities"] as $image){
			
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
			
			// add preview URL
			$tmp["source"][]  = [
				"url" => htmlspecialchars_decode($image["viewerData"]["preview"][0]["url"]),
				"width" => (int)$image["viewerData"]["preview"][0]["w"],
				"height" => (int)$image["viewerData"]["preview"][0]["h"],
			];
			
			foreach($image["viewerData"]["dups"] as $dup){
				
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
						htmlspecialchars_decode($image["viewerData"]["thumb"]["url"])
					),
				"width" => (int)$image["viewerData"]["thumb"]["w"],
				"height" => (int)$image["viewerData"]["thumb"]["h"]
			];
			
			$out["image"][] = $tmp;
		}
		
		return $out;
	}
	
	public function video($get){
		
		$this->backend = new backend("yandex_v");
		
		if($get["npt"]){
			
			[$params, $proxy] =
				$this->backend->get(
					$get["npt"],
					"video"
				);
			
			$params = json_decode($params, true);
			
			$nsfw = $params["nsfw"];
			unset($params["nsfw"]);
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$nsfw = $get["nsfw"];
			$time = $get["time"];
			$duration = $get["duration"];
			
			// https://yandex.com/video/search
			// ?tmpl_version=releases/frontend/video/v1.1168.0#8d942de0f4ebc4eb6b8f3c24ffbd1f8dbc5bbe63
			// &format=json
			// &request=
			// {
			//		"blocks":[
			//			{"block":"extra-content","params":{},"version":2},
			//			{"block":"i-global__params:ajax","params":{},"version":2},
			//			{"block":"search2:ajax","params":{},"version":2},
			//			{"block":"vital-incut","params":{},"version":2},
			//			{"block":"content_type_search","params":{},"version":2},
			//			{"block":"serp-controller","params":{},"version":2},
			//			{"block":"cookies_ajax","params":{},"version":2}
			//		],
			//		"metadata":{
			//			"bundles":{"lb":"^G]!q<X120"},
			//			"assets":{"las":"react-with-dom=1;185.0=1;73.0=1;145.0=1;5a502a.0=1;32c342.0=1;b84ac8.0=1"},
			//			"extraContent":{"names":["i-react-ajax-adapter"]}
			//		}
			// }
			// &yu=4861394161661655015
			// &from=tabbar
			// &reqid=1693106278500184-6825210746979814879-balancer-l7leveler-kubr-yp-sas-7-BAL-4237
			// &suggest_reqid=486139416166165501562797413447032
			// &text=minecraft
			
			$params = [
				"tmpl_version" => "releases/frontend/video/v1.1168.0#8d942de0f4ebc4eb6b8f3c24ffbd1f8dbc5bbe63",
				"format" => "json",
				"request" => json_encode([
					"blocks" => [
						(object)[
							"block" => "extra-content",
							"params" => (object)[],
							"version" => 2
						],
						(object)[
							"block" => "i-global__params:ajax",
							"params" => (object)[],
							"version" => 2
						],
						(object)[
							"block" => "search2:ajax",
							"params" => (object)[],
							"version" => 2
						],
						(object)[
							"block" => "vital-incut",
							"params" => (object)[],
							"version" => 2
						],
						(object)[
							"block" => "content_type_search",
							"params" => (object)[],
							"version" => 2
						],
						(object)[
							"block" => "serp-controller",
							"params" => (object)[],
							"version" => 2
						],
						(object)[
							"block" => "cookies_ajax",
							"params" => (object)[],
							"version" => 2
						]
					],
					"metadata" => (object)[
						"bundles" => (object)[
							"lb" => "^G]!q<X120"
						],
						"assets" => (object)[
							"las" => "react-with-dom=1;185.0=1;73.0=1;145.0=1;5a502a.0=1;32c342.0=1;b84ac8.0=1"
						],
						"extraContent" => (object)[
							"names" => [
								"i-react-ajax-adapter"
							]
						]
					]
				]),
				"text" => $search
			];
			
			if($duration != "any"){
				
				$params["duration"] = $duration;
			}
			
			if($time != "any"){
				
				$params["within"] = $time;
			}
		}
		/*
		$handle = fopen("scraper/yandex-video.json", "r");
		$json = fread($handle, filesize("scraper/yandex-video.json"));
		fclose($handle);
		*/
		try{
			$json =
				$this->get(
					$proxy,
					"https://yandex.com/video/search",
					$params,
					$nsfw,
					"yandex_v"
				);
		}catch(Exception $error){
			
			throw new Exception("Could not fetch JSON");
		}
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Could not parse JSON");
		}
		
		if(!isset($json["blocks"])){
			
			throw new Exception("Yandex blocked this 4get instance. Please try again in 7~ minutes.");
		}
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		$html = null;
		foreach($json["blocks"] as $block){
			
			if(isset($block["html"])){
				
				$html .= $block["html"];
			}
		}
		
		$this->fuckhtml->load($html);
		
		$div =
			$this->fuckhtml
			->getElementsByTagName("div");
		
		/*
			Get nextpage
		*/
		$npt =
			$this->fuckhtml
			->getElementsByClassName(
				"more more_direction_next i-bem",
				$div
			);
		
		if(count($npt) !== 0){
			
			$params["p"] = "1";
			$params["nsfw"] = $nsfw;
			$out["npt"] =
				$this->backend->store(
					json_encode($params),
					"video",
					$proxy
				);
		}
		
		$items =
			$this->fuckhtml
			->getElementsByClassName(
				"serp-item",
				$div
			);
		
		foreach($items as $item){
			
			$data =
				json_decode(
					$this->fuckhtml
					->getTextContent(
						$item["attributes"]["data-video"]
					),
					true
				);
			
			$this->fuckhtml->load($item);
			
			$thumb =
				$this->fuckhtml
				->getElementsByClassName(
					"thumb-image__image",
					"img"
				);
			
			$c = 1;
			if(count($thumb) === 0){
				
				$thumb = [
					"url" => null,
					"ratio" => null
				];
			}else{
				
				$thumb = [
					"url" =>
						str_replace(
							"//",
							"https://",
							$this->fuckhtml
							->getTextContent(
								$thumb
								[0]
								["attributes"]
								["src"]
							),
							$c
						),
					"ratio" => "16:9"
				];
			}
			
			$smallinfos =
				$this->fuckhtml
				->getElementsByClassName(
					"serp-item__sitelinks-item",
					"div"
				);
			
			$date = null;
			$views = null;
			$first = true;
			
			foreach($smallinfos as $info){
				
				if($first){
					
					$first = false;
					continue;
				}
				
				$info =
					$this->fuckhtml
					->getTextContent(
						$info
					);
				
				if($temp_date = strtotime($info)){
					
					$date = $temp_date;
				}else{
					
					$views = $this->parseviews($info);
				}
			}
			
			$description =
				$this->fuckhtml
				->getElementsByClassName(
					"serp-item__text serp-item__text_visibleText_always",
					"div"
				);
			
			if(count($description) === 0){
				
				$description = null;
			}else{
				
				$description =
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$description[0]
						)
					);
			}
			
			$out["video"][] = [
				"title" =>
					$this->fuckhtml
					->getTextContent(
						$this->titledots(
							$data["title"]
						)
					),
				"description" => $description,
				"author" => [
					"name" => null,
					"url" => null,
					"avatar" => null
				],
				"date" => $date,
				"duration" =>
					(int)$data
					["counters"]
					["toHostingLoaded"]
					["stredParams"]
					["duration"],
				"views" => $views,
				"thumb" => $thumb,
				"url" =>
					str_replace(
						"http://",
						"https://",
						$this->fuckhtml
						->getTextContent(
							$data["counters"]
							["toHostingLoaded"]
							["postfix"]
							["href"]
						),
						$c
					)
			];
		}
		
		return $out;
	}
	
	private function parseviews($text){
		
		$text = explode(" ", $text);
		
		$num = (float)$text[0];
		$mod = $text[1];
		
		switch($mod){
			
			case "bln.": $num = $num * 1000000000; break;
			case "mln.": $num = $num * 1000000; break;
			case "thsd.": $num = $num * 1000; break;
		}
		
		return $num;
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
