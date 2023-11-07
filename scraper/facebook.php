<?php

class facebook{
	
	const get = 0;
	const post = 1;
	
	public function __construct(){
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("fb");

		include "lib/proxy_pool.php";
		$this->proxy = new proxy_pool("facebook");
	}
	
	public function getfilters($page){
		
		return [
			"sort" => [
				"display" => "Sort by",
				"option" => [
					"relevance" => "Relevance",
					"most_recent" => "Most recent"
				]
			],
			"newer" => [
				"display" => "Newer than",
				"option" => "_DATE"
			],
			"older" => [
				"display" => "Older than",
				"option" => "_DATE"
			],
			"live" => [
				"display" => "Livestream",
				"option" => [
					"no" => "No",
					"yes" => "Yes"
				]
			]
		];
	}
	
	private function get($url, $get = [], $reqtype = self::get){
		
		$curlproc = curl_init();
		
		if($get !== []){
			
			$get = http_build_query($get);
			
			if($reqtype === self::get){
				
				$headers = [
					"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:115.0) Gecko/20100101 Firefox/115.0",
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
				
				$url .= "?" . $get;
			}else{
				
				curl_setopt($curlproc, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
				
				$headers = [
					"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:115.0) Gecko/20100101 Firefox/115.0",
					"Accept: */*",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip, deflate, br",
					"Content-Type: application/x-www-form-urlencoded",
					"X-FB-Friendly-Name: SearchCometResultsPaginatedResultsQuery",
					//"X-FB-LSD: AVptQC4a16c",
					//"X-ASBD-ID: 129477",
					"Content-Length: " . strlen($get),
					"Origin: https://www.facebook.com",
					"DNT: 1",
					"Connection: keep-alive",
					"Referer: https://www.facebook.com/watch/",
					"Cookie: datr=__GMZCgwVF5BbyvAtfJojQwg; oo=v1%7C3%3A1691641171; wd=955x995",
					"Sec-Fetch-Dest: empty",
					"Sec-Fetch-Mode: cors",
					"Sec-Fetch-Site: same-origin",
					"TE: trailers"
				];
				
				curl_setopt($curlproc, CURLOPT_POST, true);
				curl_setopt($curlproc, CURLOPT_POSTFIELDS, $get);
			}
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		curl_setopt($curlproc, CURLOPT_ENCODING, ""); // default encoding
		curl_setopt($curlproc, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($curlproc, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curlproc, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curlproc, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curlproc, CURLOPT_TIMEOUT, 30);

		$this->proxy->assign_proxy($curlproc);
		
		$data = curl_exec($curlproc);
		
		if(curl_errno($curlproc)){
			
			throw new Exception(curl_error($curlproc));
		}
		
		curl_close($curlproc);
		return $data;
	}
	
	public function video($get){
		
		$search = $get["s"];
		$npt = $get["npt"];
		
		$this->out = [
			"status" => "ok",
			"npt" => null,
			"video" => [],
			"author" => [],
			"livestream" => [],
			"playlist" => [],
			"reel" => []
		];
		
		if($get["npt"]){
			
			$nextpage =
				json_decode(
					$this->nextpage->get(
						$npt,
						"videos"
					),
					true
				);
			
			// parse next page
			$this->video_nextpage($nextpage);
			
			return $this->out;
		}
		
		// generate filter data
		// {
		//    "rp_creation_time:0":"{\"name\":\"creation_time\",\"args\":\"{\\\"start_year\\\":\\\"2023\\\",\\\"start_month\\\":\\\"2023-08\\\",\\\"end_year\\\":\\\"2023\\\",\\\"end_month\\\":\\\"2023-08\\\",\\\"start_day\\\":\\\"2023-08-10\\\",\\\"end_day\\\":\\\"2023-08-10\\\"}\"}",
		//    "videos_sort_by:0":"{\"name\":\"videos_sort_by\",\"args\":\"Most Recent\"}",
		//    "videos_live:0":"{\"name\":\"videos_live\",\"args\":\"\"}"
		// }
		$filter = [];
		$sort = $get["sort"];
		$live = $get["live"];
		$older = $get["older"];
		$newer = $get["newer"];
		
		if(
			$older !== false ||
			$newer !== false
		){
			
			if($older === false){
				
				$older = time();
			}
			
			if($newer === false){
				
				$newer = 0;
			}
			
			$filter["rp_creation_time:0"] =
				json_encode(
					[
						"name" => "creation_time",
						"args" =>
							json_encode(
								[
									"start_year" => date("Y", $newer),
									"start_month" => date("Y-m", $newer),
									"end_year" => date("Y", $older),
									"end_month" => date("Y-m", $older),
									"start_day" => date("Y-m-d", $newer),
									"end_day" => date("Y-m-d", $older)
								]
							)
					]
				);
		}
		
		if($sort != "relevance"){
			
			$filter["videos_sort_by:0"] =
				json_encode(
					[
						"name" => "videos_sort_by",
						"args" => "Most Recent"
					]
				);
		}
		
		if($live != "no"){
			
			$filter["videos_live:0"] = json_encode(
				[
					"name" => "videos_live",
					"args" => ""
				]
			);
		}
		
		$req = [
			"q" => $search
		];
		
		if(count($filter) !== 0){
			
			$req["filters"] =
				base64_encode(
					json_encode(
						$filter
					)
				);
		}
		/*
		$html =
			$this->get(
				"https://www.facebook.com/watch/search/",
				$req
			);*/
		
		$handle = fopen("scraper/facebook.html", "r");
		$html = fread($handle, filesize("scraper/facebook.html"));
		fclose($handle);
		
		preg_match_all(
			'/({"__bbox":.*,"sequence_number":0}})\]\]/',
			$html,
			$json
		);
		
		if(!isset($json[1][1])){
			
			throw new Exception("Could not grep JSON body");
		}
		
		$json = json_decode($json[1][1], true);
		
		foreach(
			$json
			["__bbox"]
			["result"]
			["data"]
			["serpResponse"]
			["results"]
			["edges"]
			as $result
		){
			
			$this->parse_edge($result);
		}
		
		// get nextpage data
		if(
			$json
			["__bbox"]
			["result"]
			["data"]
			["serpResponse"]
			["results"]
			["page_info"]
			["has_next_page"]
			== 1
		){
			
			preg_match(
				'/handleWithCustomApplyEach\(ScheduledApplyEach,({.*})\);}\);}\);<\/script>/',
				$html,
				$nextpagedata
			);
			
			// [POST] https://www.facebook.com/api/graphql/
			// FORM data, not JSON!
			
			$nextpage = [
				"av" => "0",
				"__user" => null,
				"__a" => null,
				"__req" => "2",
				"__hs" => null,
				"dpr" => "1",
				"__ccg" => null,
				"__rev" => null,
				// another client side token
				"__s" => $this->randomstring(6) . ":" . $this->randomstring(6) . ":" . $this->randomstring(6),
				"__hsi" => null,
				// tracking fingerprint (probably generated using webgl)
				"__dyn" => "7xeUmwlE7ibwKBWo2vwAxu13w8CewSwMwNw9G2S0im3y4o0B-q1ew65xO2O1Vw8G1Qw5Mx61vw9m1YwBgao6C0Mo5W3S7Udo5q4U2zxe2Gew9O222SUbEaU2eU5O0GpovU19pobodEGdw46wbS1LwTwNwLw8O1pwr86C16w",
				"__csr" => $this->randomstring(null),
				"__comet_req" => null,
				"lsd" => null,
				"jazoest" => null,
				"__spin_r" => null,
				"__spin_b" => null,
				"__spin_t" => null,
				"fb_api_caller_class" => "RelayModern",
				"fb_api_req_friendly_name" => "SearchCometResultsPaginatedResultsQuery",
				"variables" => [ // this is json
					"UFI2CommentsProvider_commentsKey" => "SearchCometResultsInitialResultsQuery",
					"allow_streaming" => false,
					"args" => [
						"callsite" => "comet:watch_search",
						"config" => [
							"exact_match" => false,
							"high_confidence_config" => null,
							"intercept_config" => null,
							"sts_disambiguation" => null,
							"watch_config" => null
						],
						"context" => [
							"bsid" => null,
							"tsid" => null
						],
						"experience" => [
							"encoded_server_defined_params" => null,
							"fbid" => null,
							"type" => "WATCH_TAB_GLOBAL"
						],
						"filters" => [],
						"text" => $search
					],
					"count" => 5,
					"cursor" =>
						$json
						["__bbox"]
						["result"]
						["data"]
						["serpResponse"]
						["results"]
						["page_info"]
						["end_cursor"],
					"displayCommentsContextEnableComment" => false,
					"displayCommentsContextIsAdPreview" => false,
					"displayCommentsContextIsAggregatedShare" => false,
					"displayCommentsContextIsStorySet" => false,
					"displayCommentsFeedbackContext" => null,
					"feedLocation" => "SEARCH",
					"feedbackSource" => 23,
					"fetch_filters" => true,
					"focusCommentID" => null,
					"locale" => null,
					"privacySelectorRenderLocation" => "COMET_STREAM",
					"renderLocation" => "search_results_page",
					"scale" => 1,
					"stream_initial_count" => 0,
					"useDefaultActor" => false,
					"__relay_internal__pv__IsWorkUserrelayprovider" => false,
					"__relay_internal__pv__IsMergQAPollsrelayprovider" => false,
					"__relay_internal__pv__StoriesArmadilloReplyEnabledrelayprovider" => false,
					"__relay_internal__pv__StoriesRingrelayprovider" => false
				],
				"server_timestamps" => "true",
				"doc_id" => "6761275837251607" // is actually dynamic
			];
			
			// append filters to nextpage
			foreach($filter as $key => $value){
				
				$nextpage["variables"]["args"]["filters"][] =
					$value;
			}
			
			$nextpagedata = json_decode($nextpagedata[1], true);
			
			// get bsid
			foreach($nextpagedata["require"] as $key){
				
				foreach($key as $innerkey){
					
					if(is_array($innerkey)){
						foreach($innerkey as $inner_innerkey){
							
							if(is_array($inner_innerkey)){
								foreach($inner_innerkey as $inner_inner_innerkey){
										
									if(
										isset(
											$inner_inner_innerkey
											["variables"]
											["args"]
											["context"]
											["bsid"]
										)
									){
										
										$nextpage
										["variables"]
										["args"]
										["context"]
										["bsid"] =
											$inner_inner_innerkey
											["variables"]
											["args"]
											["context"]
											["bsid"];
									}
								}
							}
						}
					}
				}
			}
			
			foreach($nextpagedata["define"] as $key){
				
				if(isset($key[2]["haste_session"])){
					
					$nextpage["__hs"] = $key[2]["haste_session"];
				}
				
				if(isset($key[2]["connectionClass"])){
					
					$nextpage["__ccg"] = $key[2]["connectionClass"];
				}
				
				if(isset($key[2]["__spin_r"])){
					
					$nextpage["__spin_r"] = (string)$key[2]["__spin_r"];
				}
				
				if(isset($key[2]["hsi"])){
					
					$nextpage["__hsi"] = (string)$key[2]["hsi"];
				}
				
				if(
					isset($key[2]["token"]) &&
					!empty($key[2]["token"])
				){
					
					$nextpage["lsd"] = $key[2]["token"];
				}
				
				if(isset($key[2]["__spin_r"])){
					
					$nextpage["__spin_r"] = (string)$key[2]["__spin_r"];
					$nextpage["__rev"] = $nextpage["__spin_r"];
				}
				
				if(isset($key[2]["__spin_b"])){
					
					$nextpage["__spin_b"] = $key[2]["__spin_b"];
				}
				
				if(isset($key[2]["__spin_t"])){
					
					$nextpage["__spin_t"] = (string)$key[2]["__spin_t"];
				}
			}
			
			preg_match(
				'/{"u":"\\\\\/ajax\\\\\/qm\\\\\/\?__a=([0-9]+)&__user=([0-9]+)&__comet_req=([0-9]+)&jazoest=([0-9]+)"/',
				$html,
				$ajaxparams
			);
			
			if(count($ajaxparams) !== 5){
				
				throw new Exception("Could not grep the AJAX parameters");
			}
			
			$nextpage["__a"] = $ajaxparams[1];
			$nextpage["__user"] = $ajaxparams[2];
			$nextpage["__comet_req"] = $ajaxparams[3];
			$nextpage["jazoest"] = $ajaxparams[4];
			
			/*
			$handle = fopen("scraper/facebook-nextpage.json", "r");
			$json = fread($handle, filesize("scraper/facebook-nextpage.json"));
			fclose($handle);*/
			
			$nextpage["variables"] = json_encode($nextpage["variables"]);
			
			$this->video_nextpage($nextpage);
		}
		
		return $this->out;
	}
	
	private function video_nextpage($nextpage, $getcursor = false){
		
		$json =
			$this->get(
				"https://www.facebook.com/api/graphql/",
				$nextpage,
				self::post
			);
		
		$json = json_decode($json, true);
		
		if($json === null){
			
			throw new Exception("Failed to decode next page JSON");
		}
		
		foreach(
			$json
			["data"]
			["serpResponse"]
			["results"]
			["edges"]
			as $result
		){
			
			$this->parse_edge($result);
		}
		
		if(
			$json
			["data"]
			["serpResponse"]
			["results"]
			["page_info"]
			["has_next_page"] == 1
		){
			
			$nextpage["variables"] = json_decode($nextpage["variables"], true);
			
			$nextpage["variables"]["cursor"] =
				$json
				["data"]
				["serpResponse"]
				["results"]
				["page_info"]
				["end_cursor"];
			
			$nextpage["variables"] = json_encode($nextpage["variables"]);
			
			//change this for second call. after, it's static.
			// TODO: csr also updates to longer string
			$nextpage["__dyn"] = "7xeUmwlEnwn8K2WnFw9-2i5U4e0yoW3q322aew9G2S0zU20xi3y4o0B-q1ew65xOfxO1Vw8G11xmfz81s8hwGwQw9m1YwBgao6C2O0B85W3S7Udo5qfK0EUjwGzE2swwwJK2W2K0zK5o4q0GpovU19pobodEGdw46wbS1LwTwNwLw8O1pwr86C16w";
			
			// TODO: change this on third and 6th call
			//$nextpage["__s"] = $this->randomstring(6) . ":" . explode(":", $nextpage["__s"], 2)[1];
			
			$this->out["npt"] = $this->nextpage->store(json_encode($nextpage), "videos");
		}
	}
	
	private function parse_edge($edge){

		$append = "video";		
		$edge =
			$edge
			["relay_rendering_strategy"]
			["view_model"];
		
		if(
			strtolower(
				$edge
				["video_metadata_model"]
				["video_broadcast_status"]
			)
			== "live"
		){
			
			// handle livestream
			$duration = "_LIVE";
			$append = "livestream";
			$timetext = null;
			$views =
				(int)$edge
				["video_metadata_model"]
				["relative_time_string"];
			
			$url_prefix = "https://www.facebook.com/watch/live/?v=";
			
		}elseif(
			stripos(
				$edge
				["video_metadata_model"]
				["video_broadcast_status"],
				"vod"
			) !== false
		){
			
			// handle VOD format
			$timetext = null;
			$views =
				(int)$edge
				["video_metadata_model"]
				["relative_time_string"];
			
			$duration =
				$this->hms2int(
					$edge
					["video_thumbnail_model"]
					["video_duration_text"]
				);
			
			$url_prefix = "https://www.facebook.com/watch/live/?v=";
			
		}else{
			
			// handle normal format
			$timetext =
				explode(
					" · ",
					$edge
					["video_metadata_model"]
					["relative_time_string"],
					2
				); 
			
			if(count($timetext) === 2){
				
				$views = $this->truncatedcount2int($timetext[1]);
			}else{
				
				$views = null;
			}
			
			$timetext = strtotime($timetext[0]);
			
			$duration =
				$this->hms2int(
					$edge
					["video_thumbnail_model"]
					["video_duration_text"]
				);
			
			$url_prefix = "https://www.facebook.com/watch/?v=";
		}
		
		if(
			isset(
				$edge
				["video_metadata_model"]
				["video_owner_profile"]
				["uri_token"]
			)
		){
			
			$profileurl =
				"https://www.facebook.com/watch/" .
				$edge
				["video_metadata_model"]
				["video_owner_profile"]
				["uri_token"];
		}else{
			
			$profileurl =
				$edge
				["video_metadata_model"]
				["video_owner_profile"]
				["url"];
		}
		
		$this->out[$append][] = [
			"title" =>
				$this->limitstrlen(
					str_replace(
						"\n",
						" ",
						$edge
						["video_metadata_model"]
						["title"]
					),
					100
				),
			"description" =>
				empty(
					$edge
					["video_metadata_model"]
					["save_description"]
				) ?
				null :
				str_replace(
					"\n",
					" ",
					$this->limitstrlen(
						$edge
						["video_metadata_model"]
						["save_description"]
					)
				),
			"author" => [
				"name" =>
					$edge
					["video_metadata_model"]
					["video_owner_profile"]
					["name"],
				"url" => $profileurl,
				"avatar" => null
			],
			"date" => $timetext,
			"duration" => $duration,
			"views" => $views,
			"thumb" =>
				[
					"url" =>
						$edge
						["video_thumbnail_model"]
						["thumbnail_image"]
						["uri"],
					"ratio" => "16:9"
				],
			"url" =>
				$url_prefix .
				$edge
				["video_click_model"]
				["click_metadata_model"]
				["video_id"]
		];
	}
	
	private function randomstring($len){
		
		if($len === null){
			
			$str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789-";
			$len = rand(141, 145);
			$c = 61;
		}else{
						
			$str = "abcdefghijklmnopqrstuvwxyz123456789";
			$c = 34;
		}
		
		$out = null;
		for($i=0; $i<$len; $i++){
			
			$out .= $str[rand(0, $c)];
		}
		
		return $out;
	}
	
	private function limitstrlen($text, $len = 300){
		
		return explode("\n", wordwrap($text, $len, "\n"))[0];
	}
	
	private function hms2int($time){
		
		$parts = explode(":", $time, 3);
		$time = 0;
		
		if(count($parts) === 3){
			
			// hours
			$time = $time + ((int)$parts[0] * 3600);
			array_shift($parts);
		}
		
		if(count($parts) === 2){
			
			// minutes
			$time = $time + ((int)$parts[0] * 60);
			array_shift($parts);
		}
		
		// seconds
		$time = $time + (int)$parts[0];
		
		return $time;
	}
	
	private function truncatedcount2int($number){
		
		// decimal should always be 1 number long
		$number = explode(" ", $number, 2);
		$number = $number[0];
		
		$unit = strtolower($number[strlen($number) - 1]);
		
		$tmp = explode(".", $number, 2);
		$number = (int)$number;
		
		if(count($tmp) === 2){
			
			$decimal = (int)$tmp[1];
		}else{
			
			$decimal = 0;
		}
		
		switch($unit){
			
			case "k":
				$exponant = 1000;
				break;
			
			case "m":
				$exponant = 1000000;
				break;
			
			case "b";
				$exponant = 1000000000;
				break;
			
			default:
				$exponant = 1;
				break;
		}
		
		return ($number * $exponant) + ($decimal * ($exponant / 10));
	}
}
