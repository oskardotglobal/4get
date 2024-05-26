<?php

//$yt = new youtube();
//header("Content-Type: application/json");
//echo json_encode($yt->video("minecraft", null, "today", "any", "any", "live", "relevance"));

class yt{
	
	public function __construct(){
		
		include "lib/backend.php";
		$this->backend = new backend("yt");
	}
	
	public function getfilters($page){
		
		if($page != "videos"){
			
			return [];
		}
		
		return [
			"date" => [
				"display" => "Time posted",
				"option" => [
					"any" => "Any time",
					"hour" => "Last hour",
					"today" => "Today",
					"week" => "This week",
					"month" => "This month",
					"year" => "This year"
				]
			],
			"type" => [
				"display" => "Type",
				"option" => [
					"video" => "Video",
					"channel" => "Channel",
					"playlist" => "Playlist",
					"Movie" => "Movie"
				]
			],
			"duration" => [
				"display" => "Duration",
				"option" => [
					"any" => "Any duration",
					"short" => "Short (>4min)",
					"medium" => "Medium (4-20min)",
					"long" => "Long (<20min)"
				]
			],
			"feature" => [
				"display" => "Feature",
				"option" => [
					"any" => "No features",
					"live" => "Live",
					"4k" => "4K",
					"hd" => "HD",
					"subtitles" => "Subtitles/CC",
					"creativecommons" => "Creative Commons",
					"360" => "VR 360°",
					"vr180" => "VR 180°",
					"3d" => "3D",
					"hdr" => "HDR"
				]
			],
			"sort" => [
				"display" => "Sort by",
				"option" => [
					"relevance" => "Relevance",
					"upload_date" => "Upload date",
					"view_count" => "View count",
					"rating" => "Rating"
				]
			]
		];
	}
	
	private function ytfilter($date, $type, $duration, $feature, $sort){
		
		// ------------
		// INCOMPATIBLE FILTERS
		// channel,playlist		DURATION, FEATURES, SORT BY
		// Movie				Features=[live, subtitles, creative commons, 3d]
		
		// live, 3D
		// Type[channel, playlist, movie]
		
		// UPLOAD DATE, DURATION, 4k, 360, VR180, HDR
		// Type[channel, playlist]
		
		// -----------
		
		// MUST BE TOGETHER
		// Relevance,upload date		Type=Video
		
		switch($type){
			
			case "channel":
			case "playlist":
				if($duration != "any"){ $duration = "any"; }
				if($feature != "any"){ $feature = "any"; }
				if($sort != "any"){ $sort = "any"; }
				break;
			
			case "movie":
				if(
					in_array(
						$feature,
						[
							"live",
							"subtitles",
							"creative_commons",
							"3d"
						],
					)
				){
					
					$feature = "any";
				}
				break;
		}
		
		switch($feature){
			
			case "live":
			case "3d":
				if(
					in_array(
						$type,
						[
							"channel",
							"playlist",
							"movie"
						],
					)
				){
					
					$type = "video";
				}
				break;
		}
		
		if(
			(
				$date != "any" ||
				$duration != "any" ||
				$feature == "4k" ||
				$feature == "360" ||
				$feature == "vr180" ||
				$feature == "hdr"
			) &&
			(
				$type == "channel" ||
				$type == "playlist"
			)
		){
			
			$type = "video";
		}
		
		if(
			$date == "any" &&
			$type == "video" &&
			$duration == "any" &&
			$feature == "any" &&
			$sort == "relevance"
		){
			
			return null;
		}
		
		//print_r([$date, $type, $duration, $feature, $sort]);
		
		/*
			Encode hex data
		*/
		
		// UPLOAD DATE
		// hour				EgQIARAB			12 04 08 01 10 01
		// today			EgQIAhAB			12 04 08 02 10 01
		// week				EgQIAxAB			12 04 08 03 10 01
		// month			EgQIBBAB			12 04 08 04 10 01
		// year				EgQIBRAB			12 04 08 05 10 01
		
		// TYPE
		// video			EgIQAQ%253D%253D	12 02 10 01
		// channel			EgIQAg%253D%253D	12 02 10 02
		// playlist			EgIQAw%253D%253D	12 02 10 03
		// movie			EgIQBA%253D%253D	12 02 10 04
		
		// DURATION
		// -4min			EgIYAQ%253D%253D	12 02 18 01
		// 4-20min			EgIYAw%253D%253D	12 02 18 03
		// 20+min			EgIYAg%253D%253D	12 02 18 02
		
		// FEATURE
		// live				EgJAAQ%253D%253D	12 02 40 01
		// 4K				EgJwAQ%253D%253D	12 02 70 01
		// HD				EgIgAQ%253D%253D	12 02 20 01
		// Subtitles/CC		EgIoAQ%253D%253D	12 02 28 01
		// Creative Commons	EgIwAQ%253D%253D	12 02 30 01
		// 360				EgJ4AQ%253D%253D	12 02 78 01
		// VR180			EgPQAQE%253D		12 03 d0 01 01
		// 3D				EgI4AQ%253D%253D	12 02 38 01
		// HDR				EgPIAQE%253D		12 03 c8 01 01
		// (location & purchased unused)
		
		// SORT BY
		// Relevance		CAASAhAB			08 00 12 02 10 01 (is nothing by default)
		// Upload date		CAI%253D			08 02
		// View count		CAM%253D			08 03
		// Rating			CAE%253D			08 01
		
		// video
		// 12 02 10 01
		
		// under 4 minutes
		// 12 02 18 01
		
		// video + under 4 minutes
		// 12 04 10 01 18 01
		
		// video + under 4 minutes + HD
		// 08 00 12 06 10 01 18 01 20 01
		
		// video + under 4 minutes + upload date
		// 08 02 12 04 10 01 18 01
		
		// video + under 4 minutes + HD + upload date
		// 08 02 12 06 10 01 18 01 20 01
		
		// this year + video + under 4 minutes + HD + upload date
		// 08 02 12 08 08 05 10 01 18 01 20 01
		
		// this week + video + over 20 minutes + HD + view count
		// 08 03 12 08 08 03 10 01 18 02 20 01
		
		//echo urlencode(urlencode(base64_encode(hex2bin($str))));
		//echo bin2hex(base64_decode(urldecode(urldecode("CAI%253D"))));
		
		// week + video + 20min + rating
		// 08 01 12 06 08 03 10 01 18 02
		
		// week + video + 20min + live + rating
		// 08 01 12 08 08 03 10 01 18 02 40 01
		
		// live 12 02 40 01
		
		$hex = null;
		if(
			$date == "any" &&
			$type == "video" &&
			$duration == "any" &&
			$feature == "any" &&
			$sort == "relevance"
		){
			
			return $hex;
		}
		
		$opcode = 0;
		
		if($date != "any"){ $opcode += 2; }
		if($type != "any"){ $opcode += 2; }
		if($duration != "any"){ $opcode += 2; }
		
		switch($feature){
			
			case "live":
			case "4k":
			case "hd":
			case "subtitles":
			case "creativecommons":
			case "360":
			case "3d":
				$opcode += 2;
				break;
			
			case "hdr":
			case "vr180":
				$opcode += 3;
				break;
		}
		
		switch($sort){
			
			case "relevance": $hex .= "0800"; break;
			case "upload_date": $hex .= "0802"; break;
			case "view_count": $hex .= "0803"; break;
			case "rating": $hex .= "0801"; break;
		}
		
		$hex .= "12" . "0".$opcode;
		
		switch($date){
			
			case "hour": $hex .= "0801"; break;
			case "today": $hex .= "0802"; break;
			case "week": $hex .= "0803"; break;
			case "month": $hex .= "0804"; break;
			case "year": $hex .= "0805"; break;
		}
		
		switch($type){
			
			case "video": $hex .= "1001"; break;
			case "channel": $hex .= "1002"; break;
			case "playlist": $hex .= "1003"; break;
			case "movie": $hex .= "1004"; break;
		}
		
		switch($duration){
			
			case "short": $hex .= "1801"; break;
			case "medium": $hex .= "1803"; break;
			case "long": $hex .= "1802"; break;
		}
		
		switch($feature){
			
			case "live": $hex .= "4001"; break;
			case "4k": $hex .= "7001"; break;
			case "hd": $hex .= "2001"; break;
			case "subtitles": $hex .= "2801"; break;
			case "creativecommons": $hex .= "3001"; break;
			case "360": $hex .= "7801"; break;
			case "vr180": $hex .= "d00101"; break;
			case "3d": $hex .= "3801"; break;
			case "hdr": $hex .= "c80101"; break;
		}
		
		//echo $hex . "\n\n";
		return urlencode(base64_encode(hex2bin($hex)));
	}
	
	// me reading youtube's json
	// https://imgur.com/X9hVlFX
	
	const req_web = 0;
	const req_xhr = 1;
	
	private function get($proxy, $url, $get = [], $reqtype = self::req_web, $continuation = null){
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
		switch($reqtype){
			case self::req_web:
				$headers =
					["User-Agent: " . config::USER_AGENT,
					"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip",
					"Cookie: PREF=tz=America.New_York",
					"DNT: 1",
					"Connection: keep-alive",
					"Upgrade-Insecure-Requests: 1",
					"Sec-Fetch-Dest: document",
					"Sec-Fetch-Mode: navigate",
					"Sec-Fetch-Site: none",
					"Sec-Fetch-User: ?1"];
				break;
			
			case self::req_xhr:
				$headers =
					["User-Agent: " . config::USER_AGENT,
					"Accept: */*",
					"Accept-Language: en-US,en;q=0.5",
					"Accept-Encoding: gzip",
					"Cookie: PREF=tz=America.New_York",
					"Referer: https://youtube.com.com/",
					"Content-Type: application/json",
					"Content-Length: " . strlen($continuation),
					"DNT: 1",
					"Connection: keep-alive",
					"Sec-Fetch-Dest: empty",
					"Sec-Fetch-Mode: same-origin",
					"Sec-Fetch-Site: same-origin"];
				
				curl_setopt($curlproc, CURLOPT_POST, true);
				curl_setopt($curlproc, CURLOPT_POSTFIELDS, $continuation);
				break;
		}
		
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
	
	public function video($get){
		
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
			
			// parse nextPage
			// https://www.youtube.com/youtubei/v1/search?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8&prettyPrint=false
			/*
			$handle = fopen("nextpage.json", "r");
			$json = fread($handle, filesize("nextpage.json"));
			fclose($handle);*/
			
			[$npt, $proxy] =
				$this->backend->get(
					$get["npt"],
					"videos"
				);
			
			$npt = json_decode($npt, true);
			
			try{
				$json = $this->get(
					$proxy,
					"https://www.youtube.com/youtubei/v1/search",
					[
						"key" => $npt["key"],
						"prettyPrint" => "false"
					],
					self::req_xhr,
					json_encode($npt["post"])
				);
			}catch(Exception $error){
				
				throw new Exception("Could not fetch results page");
			}
			
			$json = json_decode($json);
			
			foreach(
				$json
				->onResponseReceivedCommands[0]
				->appendContinuationItemsAction
				->continuationItems[0]
				->itemSectionRenderer
				->contents
				as $video
			){
				
				$this->parsevideoobject($video);
			}
			
			if(
				!isset(
					$json
					->onResponseReceivedCommands[0]
					->appendContinuationItemsAction
					->continuationItems[1]
					->continuationItemRenderer
					->continuationEndpoint
					->continuationCommand
					->token
				)
			){
				
				$npt = null;
				
			}else{
				// prepare nextpage for later..
				$npt["post"]["continuation"] =
					$json
					->onResponseReceivedCommands[0]
					->appendContinuationItemsAction
					->continuationItems[1]
					->continuationItemRenderer
					->continuationEndpoint
					->continuationCommand
					->token;
			}
			
			$this->out["npt"] = $npt;
			
		}else{
			
			$search = $get["s"];
			if(strlen($search) === 0){
				
				throw new Exception("Search term is empty!");
			}
			
			$proxy = $this->backend->get_ip();
			$date = $get["date"];
			$type = $get["type"];
			$duration = $get["duration"];
			$feature = $get["feature"];
			$sort = $get["sort"];
			
			// parse ytInitialData
			
			$get = [
				"search_query" => $search
			];
			
			if(
				(
					$filter =
					$this->ytfilter(
						$date,
						$type,
						$duration,
						$feature,
						$sort
					)
				) !== null
			){
				
				$get["sp"] = $filter;
			}
			
			try{
				$json = $this->get(
					$proxy,
					"https://www.youtube.com/results",
					$get
				);
			}catch(Exception $error){
				
				throw new Exception("Could not fetch results page");
			}
			/*
			$handle = fopen("test.html", "r");
			$json = fread($handle, filesize("test.html"));
			fclose($handle);
			*/
			if(
				!preg_match(
					'/ytcfg\.set\(({".*})\); *window\.ytcfg/',
					$json,
					$ytconfig
				)
			){
				
				throw new Exception("Could not get ytcfg");
			}
			
			$ytconfig = json_decode($ytconfig[1]);
			
			if(
				!preg_match(
					'/ytInitialData *= *({.*});<\/script>/',
					$json,
					$json
				)
			){
				
				throw new Exception("Could not get ytInitialData");
			}
			
			$json = json_decode($json[1]);
			
			// generate POST data for nextpage
			
			$ytconfig->INNERTUBE_CONTEXT->client->screenWidthPoints = 1239;
			$ytconfig->INNERTUBE_CONTEXT->client->screenHeightPoints = 999;
			$ytconfig->INNERTUBE_CONTEXT->client->screenPixelDensity = 1;
			$ytconfig->INNERTUBE_CONTEXT->client->screenDensityFloat = 1;
			$ytconfig->INNERTUBE_CONTEXT->client->utcOffsetMinutes = -240;
			$ytconfig->INNERTUBE_CONTEXT->request->internalExperimentFlags = [];
			$ytconfig->INNERTUBE_CONTEXT->request->consistencyTokenJars = [];
			
			$ytconfig->INNERTUBE_CONTEXT->client->mainAppWebInfo = [
				"graftUrl" => $ytconfig->INNERTUBE_CONTEXT->client->originalUrl,
				"webDisplayMode" => "WEB_DISPLAY_MODE_BROWSER",
				"isWebNativeShareAvailable" => false
			];
			
			$ytconfig->INNERTUBE_CONTEXT->adSignalsInfo = [
				"params" => [
					[
						"key" => "dt",
						"value" => (string)$ytconfig->TIME_CREATED_MS
					],
					[
						"key" => "flash",
						"value" => "0"
					],
					[
						"key" => "frm",
						"value" => "0"
					],
					[
						"key" => "u_tz",
						"value" => "-240"
					],
					[
						"key" => "u_his",
						"value" => "3"
					],
					[
						"key" => "u_h",
						"value" => "1080"
					],
					[
						"key" => "u_w",
						"value" => "1920"
					],
					[
						"key" => "u_ah",
						"value" => "1080"
					],
					[
						"key" => "u_cd",
						"value" => "24"
					],
					[
						"key" => "bc",
						"value" => "31"
					],
					[
						"key" => "bih",
						"value" => "999"
					],
					[
						"key" => "biw",
						"value" => "1239"
					],
					[
						"key" => "brdim",
						"value" => "0,0,0,0,1920,0,1920,1061,1239,999"
					],
					[
						"key" => "vis",
						"value" => "1"
					],
					[
						"key" => "wgl",
						"value" => "true"
					],
					[
						"key" => "ca_type",
						"value" => "image"
					]
				]
			];
			
			/*
			echo json_encode($json);
			die();*/
			
			// *inhales*
			foreach(
				$json
				->contents
				->twoColumnSearchResultsRenderer
				->primaryContents
				->sectionListRenderer
				->contents[0]
				->itemSectionRenderer
				->contents
				as $video
			){
				
				$this->parsevideoobject($video);
			}
			
			// get additional data from secondaryContents
			if(
				isset(
					$json
					->contents
					->twoColumnSearchResultsRenderer
					->secondaryContents
					->secondarySearchContainerRenderer
					->contents[0]
					->universalWatchCardRenderer
				)
			){
				
				$video =
					$json
					->contents
					->twoColumnSearchResultsRenderer
					->secondaryContents
					->secondarySearchContainerRenderer
					->contents[0]
					->universalWatchCardRenderer;
				/*
				echo json_encode($video);
				die();*/
				
				$author =
					[
						"name" =>
							$video
							->header
							->watchCardRichHeaderRenderer
							->title
							->simpleText,
						"url" =>
							"https://www.youtube.com/channel/" .
							$video
							->header
							->watchCardRichHeaderRenderer
							->titleNavigationEndpoint
							->browseEndpoint
							->browseId,
						"avatar" => null
					];
				
				if(
					isset(
						$video
						->header
						->watchCardRichHeaderRenderer
						->avatar
						->thumbnails[0]
						->url
					)
				){
					
					$author["avatar"] =
						$video
						->header
						->watchCardRichHeaderRenderer
						->avatar
						->thumbnails[0]
						->url;
				}
				
				// add video in callToAction if present
				if(
					isset(
						$video
						->callToAction
						->watchCardHeroVideoRenderer
						->lengthText
					)
				){
					
					array_push(
						$this->out["video"],
						[
							"title" =>
								$video
								->callToAction
								->watchCardHeroVideoRenderer
								->title
								->simpleText,
							"description" => null,
							"author" => $author,
							"date" =>
								$this->textualdate2unix(
									trim(
										explode(
											"•",
											$video
											->callToAction
											->watchCardHeroVideoRenderer
											->subtitle
											->simpleText
										)[2]
									)
								),
							"duration" =>
								$this->hms2int(
									$video
									->callToAction
									->watchCardHeroVideoRenderer
									->lengthText
									->simpleText
								),
							"views" =>
								$this->truncatedcount2int(
									trim(
										explode(
											"•",
											$video
											->callToAction
											->watchCardHeroVideoRenderer
											->subtitle
											->simpleText,
											2
										)[1]
									)
								),
							"thumb" => [
								"url" =>
									$video
									->callToAction
									->watchCardHeroVideoRenderer
									->heroImage
									->singleHeroImageRenderer
									->thumbnail
									->thumbnails[0]
									->url,
								"ratio" => "16:9"
							],
							"url" =>
								"https://www.youtube.com/watch?v=" .
								$video
								->callToAction
								->watchCardHeroVideoRenderer
								->navigationEndpoint
								->watchEndpoint
								->videoId
						]
					);
				}
				
				// get all playlists, ignore videos
				$out = null;
				
				foreach(
					$video
					->sections
					as $section
				){
					
					if(
						isset(
							$section
							->watchCardSectionSequenceRenderer
							->lists[0]
							->horizontalCardListRenderer
							->cards
						)
					){
						
						$out =
							$section
							->watchCardSectionSequenceRenderer
							->lists[0]
							->horizontalCardListRenderer
							->cards;
						break;
					}
				}
				
				if($out !== null){
					
					foreach(
						$out as $video
					){
						
						if(
							!isset(
								$video
								->searchRefinementCardRenderer
							)
						){
							
							continue;
						}
						
						$video =
							$video
							->searchRefinementCardRenderer;
						
						array_push(
							$this->out["playlist"],
							[
								"title" =>
									$video
									->query
									->runs[0]
									->text,
								"description" => null,
								"author" => $author,
								"date" => null,
								"duration" => null,
								"views" => null,
								"thumb" => [
									"url" =>
										$video
										->thumbnail
										->thumbnails[0]
										->url,
									"ratio" => "1:1"
								],
								"url" =>
									"https://www.youtube.com" .
									$video
									->searchEndpoint
									->commandMetadata
									->webCommandMetadata
									->url
							]
						);
					}
				}
			}
			
			foreach(
				$json
				->contents
				->twoColumnSearchResultsRenderer
				->primaryContents
				->sectionListRenderer
				->contents
				as $cont
			){
				
				if(isset($cont->continuationItemRenderer)){
					
					$this->out["npt"] = [
						"key" =>
							$ytconfig
							->INNERTUBE_API_KEY,
						"post" => [
							"context" =>
								$ytconfig
								->INNERTUBE_CONTEXT,
							"continuation" =>
								$cont
								->continuationItemRenderer
								->continuationEndpoint
								->continuationCommand
								->token
						]
					];
					break;
				}
			}
		}
		
		if($this->out["npt"] !== null){
			
			$this->out["npt"] =
				$this->backend->store(
					json_encode(
						$this->out["npt"]
					),
					"videos",
					$proxy
				);
		}
		
		return $this->out;
	}
	
	private function parsevideoobject($video){
		
		if(isset($video->videoRenderer)){
			
			$video = $video->videoRenderer;
			
			$description = null;
			
			if(isset($video->detailedMetadataSnippets)){
				foreach(
					$video
					->detailedMetadataSnippets[0]
					->snippetText
					->runs
					as $description_part
				){
					
					$description .= $description_part->text;
				}
			}
			
			if(
				isset(
					$video
					->badges[0]
					->metadataBadgeRenderer
					->icon
					->iconType
				) &&
				$video
				->badges[0]
				->metadataBadgeRenderer
				->icon
				->iconType
				== "LIVE"
			){
				
				$type = "livestream";
				$date = null;
				$duration = "_LIVE";
				
				if(isset($video->viewCountText->runs[0]->text)){
					
					$views =
						$this->views2int(
							$video
							->viewCountText
							->runs[0]
							->text
						);
				}else{
					
					$views = null;
				}
			}else{
				
				$type = "video";
				
				if(isset($video->publishedTimeText->simpleText)){
					
					$date = $this->textualdate2unix(
						$video
						->publishedTimeText
						->simpleText
					);
				}else{
					
					$date = null;
				}
				
				if(isset($video->lengthText->simpleText)){
					
					$duration =
						$this->hms2int(
							$video
							->lengthText
							->simpleText
						);
				}else{
					
					$duration = null;
				}
				
				if(isset($video->viewCountText->simpleText)){
					
					$views =
						$this->views2int(
							$video
							->viewCountText
							->simpleText
						);
				}else{
					
					$views = null;
				}
			}
			
			if(
				$video
				->navigationEndpoint
				->commandMetadata
				->webCommandMetadata
				->webPageType
				== "WEB_PAGE_TYPE_SHORTS"
			){
				
				// haha you thought you could get me, youtube
				// jokes on you i dont go outside
				$type = "reel";
			}
			
			array_push(
				$this->out[$type],
				[
					"title" =>
						$video
						->title
						->runs[0]
						->text,
					"description" =>
						$this->titledots($description),
					"author" => [
							"name" =>
								$video
								->longBylineText
								->runs[0]
								->text,
							"url" =>
								"https://www.youtube.com/channel/" .
								$video
								->longBylineText
								->runs[0]
								->navigationEndpoint
								->browseEndpoint
								->browseId,
							"avatar" =>
								$this->checkhttpspresence(
									$video
									->channelThumbnailSupportedRenderers
									->channelThumbnailWithLinkRenderer
									->thumbnail
									->thumbnails[0]
									->url
								)
						],
					"date" => $date,
					"duration" => $duration,
					"views" => $views,
					"thumb" => [
						"url" =>
							$video
							->thumbnail
							->thumbnails[0]
							->url,
						"ratio" => "16:9"
					],
					"url" =>
						"https://www.youtube.com/watch?v=" .
						$video
						->videoId
				]
			);
		}elseif(isset($video->watchCardCompactVideoRenderer)){
			
			$video =
				$video
				->watchCardCompactVideoRenderer;
			
			array_push(
				$this->out["video"],
				[
					"title" =>
						$video
						->title
						->simpleText,
					"description" => null,
					"author" => [
							"name" =>
								$video
								->byline
								->runs[0]
								->text,
							"url" =>
								"https://www.youtube.com/channel/" .
								$video
								->byline
								->runs[0]
								->navigationEndpoint
								->browseEndpoint
								->browseId,
							"avatar" => null
						],
					"date" =>
						$this->textualdate2unix(
							trim(
								explode(
									"•",
									$video
									->subtitle
									->simpleText,
									2
								)[1]
							)
						),
					"duration" =>
						$this->hms2int(
							$video
							->lengthText
							->simpleText
						),
					"views" =>
						$this->truncatedcount2int(
							trim(
								explode(
									"•",
									$video
									->subtitle
									->simpleText,
									2
								)[0]
							)
						),
					"thumb" => [
						"url" =>
							$video
							->thumbnail
							->thumbnails[0]
							->url,
						"ratio" => "16:9"
					],
					"url" =>
						"https://www.youtube.com/watch?v=" .
						$video
						->navigationEndpoint
						->watchEndpoint
						->videoId
				]
			);
			
		}elseif(isset($video->reelShelfRenderer)){
			
			foreach(
				$video
				->reelShelfRenderer
				->items
				as $reel
			){
				
				$reel =
					$reel
					->reelItemRenderer;
				
				array_push(
					$this->out["reel"],
					[
						"title" =>
							$reel
							->headline
							->simpleText,
						"description" => null,
						"author" => [
							"name" => null,
							"url" => null,
							"avatar" => null
						],
						"date" => null,
						"duration" =>
							$this->textualtime2int(
								$reel
								->accessibility
								->accessibilityData
								->label
							),
						"views" =>
							$this->truncatedcount2int(
								$reel
								->viewCountText
								->simpleText
							),
						"thumb" => [
							"url" =>
								$reel
								->thumbnail
								->thumbnails[0]
								->url,
							"ratio" => "9:16"
						],
						"url" =>
							"https://www.youtube.com/watch?v=" .
							$reel
							->videoId
					]
				);
			}
		}
		
		elseif(isset($video->channelRenderer)){
			
			$video = $video->channelRenderer;
			
			$description = null;
			
			if(isset($video->descriptionSnippet)){
				
				foreach(
					$video
					->descriptionSnippet
					->runs
					as $description_part
				){
					
					$description .= $description_part->text;
				}
			}
			
			array_push(
				$this->out["author"],
				[
					"title" =>
						$video
						->title
						->simpleText,
					"followers" =>
						isset(
							$video
							->videoCountText
							->simpleText
						) ?
						$this->truncatedcount2int(
							$video
							->videoCountText
							->simpleText
						) :
						0,
					"description" => $this->titledots($description),
					"thumb" =>
						[
							"url" =>
								$this->checkhttpspresence(
									$video
									->thumbnail
									->thumbnails[
										count(
											$video
											->thumbnail
											->thumbnails
										) - 1
									]
									->url
								),
							"ratio" => "1:1"
						],
					"url" =>
						"https://www.youtube.com/channel/" .
						$video
						->channelId
				]
			);
		}
		
		elseif(isset($video->shelfRenderer)){
			
			if(
				!is_object(
					$video
					->shelfRenderer
					->content
					->verticalListRenderer
				)
			){
				return;
			}
			
			foreach(
				$video
				->shelfRenderer
				->content
				->verticalListRenderer
				->items
				as $shelfvideo
			){
				
				$this->parsevideoobject($shelfvideo);
			}
			
		}elseif(isset($video->radioRenderer)){
			
			$video = $video->radioRenderer;
			
			$description =
				$video
				->videoCountText
				->runs[0]
				->text
				. ".";
			
			$tmp = [];
			foreach(
				$video->videos
				as $childvideo
			){
				
				$tmp[] =
					$childvideo
					->childVideoRenderer
					->title
					->simpleText;
			}
			
			if(count($tmp) !== 0){
				
				$description .=
					" " . implode(", ", $tmp);
			}
			
			array_push(
				$this->out["playlist"],
				[
					"title" =>
						$video
						->title
						->simpleText,
					"description" => $description,
					"author" => [
						"name" =>
							$video
							->longBylineText
							->simpleText,
						"url" => null,
						"avatar" => null
					],
					"date" => null,
					"duration" => null,
					"views" => null,
					"thumb" => [
						"url" =>
							$video
							->thumbnail
							->thumbnails[
								count(
									$video
									->thumbnail
									->thumbnails
								) - 1
							]
							->url,
						"ratio" => "16:9"
					],
					"url" =>
						"https://www.youtube.com/watch?v=" .
						$video
						->videos[0]
						->childVideoRenderer
						->videoId .
						"&list=" .
						$video
						->playlistId .
						"&start_radio=1"
				]
			);
			
		}elseif(isset($video->playlistRenderer)){
			
			$video = $video->playlistRenderer;
			
			$description = $video->videoCount . " videos.";
			
			$tmp = [];
			foreach(
				$video
				->videos
				as $childvideo
			){
				
				$tmp[] =
					$childvideo
					->childVideoRenderer
					->title
					->simpleText;
			}
			
			if(count($tmp) !== 0){
				
				$description .=
					" " . implode(", ", $tmp);
			}
			
			array_push(
				$this->out["playlist"],
				[
					"title" =>
						$video
						->title
						->simpleText,
					"description" => $description,
					"author" => [
						"name" =>
							$video
							->longBylineText
							->runs[0]
							->text,
						"url" =>
							"https://www.youtube.com/channel/" .
							$video
							->longBylineText
							->runs[0]
							->navigationEndpoint
							->browseEndpoint
							->browseId,
						"picture" => null
					],
					"date" => null,
					"duration" => null,
					"views" => null,
					"thumb" =>
						[
							"url" =>
								$video
								->thumbnails[0]
								->thumbnails[
									count(
										$video
										->thumbnails[0]
										->thumbnails
									) - 1
								]
								->url,
							"ratio" => "16:9"
						],
					"url" =>
						"https://www.youtube.com/watch?v=" .
						$video
						->videos[0]
						->childVideoRenderer
						->videoId .
						"&list=" .
						$video
						->playlistId .
						"&start_radio=1"
				]
			);
			
		}/*else{
			if(!isset($video->searchPyvRenderer)){
			echo json_encode($video);
			die();}
		}*/
	}
	
	private function textualdate2unix($number){
		
		$number =
			explode(
				" ",
				str_replace(
						[
							" ago",
							"seconds",
							"minutes",
							"hours",
							"days",
							"weeks",
							"months",
							"years"
						],
						[
							"",
							"second",
							"minute",
							"hour",
							"day",
							"week",
							"month",
							"year"
						],
						$number
					),
				2
			);
		
		$time = 0;
		switch($number[1]){
			
			case "second":
				$time = (int)$number[0];
				break;
			
			case "minute":
				$time = (int)$number[0] * 60;
				break;
			
			case "hour":
				$time = (int)$number[0] * 3600;
				break;
				
			case "day":
				$time = (int)$number[0] * 86400;
				break;
				
			case "week":
				$time = (int)$number[0] * 604800;
				break;
				
			case "month":
				$time = (int)$number[0] * 2629746;
				break;
				
			case "year":
				$time = (int)$number[0] * 31556952;
				break;
		}
		
		return time() - $time;
	}
	
	private function checkhttpspresence($link){
		
		if(substr($link, 0, 2) == "//"){
			
			return "https:" . $link;
		}
		
		return $link;
	}
	
	private function textualtime2int($number){
		
		$number = explode(" - ", $number);
		
		if(count($number) >= 2){
			
			$number = $number[count($number) - 2];
		}else{
			
			$number = $number[0];
		}
		
		$number =
			str_replace(
				[
					" ",
					"seconds",
					"minutes",
					"hours",
				],
				[
					"",
					"second",
					"minute",
					"hour"
				],
				$number
			);
		
		preg_match_all(
			'/([0-9]+)(second|minute|hour)/',
			$number,
			$number
		);
		
		$time = 0;
		
		for($i=0; $i<count($number[0]); $i++){
			
			switch($number[2][$i]){
				
				case "second":
					$time = $time + (int)$number[1][$i];
					break;
					
				case "minute":
					$time = $time + ((int)$number[1][$i] * 60);
					break;
					
				case "hour":
					$time = $time + ((int)$number[1][$i] * 3600);
					break;
			}
		}
		
		return $time;
	}
	
	private function views2int($views){
		
		return
			(int)str_replace(
				",", "",
				explode(" ", $views, 2)[0]
			);
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
	
	private function titledots($title){
		
		$substr = substr($title, -3);
		
		if(
			$substr == "..." ||
			$substr == "…"
		){
			
			return trim(substr($title, 0, -3), " \n\r\t\v\x00\0\x0B\xc2\xa0");
		}
		
		return trim($title, " \n\r\t\v\x00\0\x0B\xc2\xa0");
	}
}
