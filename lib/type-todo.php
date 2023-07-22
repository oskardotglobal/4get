
	public function type($get){
		
		$search = $get["s"];
		$bang = $get["bang"];
		
		if(empty($search)){
			
			if(!empty($bang)){
				
				// !youtube
				$conn = pg_connect("host=localhost dbname=4get user=postgres password=postgres");
				
				pg_prepare($conn, "bang_get", "SELECT bang,name FROM bangs WHERE bang LIKE $1 ORDER BY bang ASC LIMIT 8");
				$q = pg_execute($conn, "bang_get", ["$bang%"]);
				
				$results = [];
				while($row = pg_fetch_array($q, null, PGSQL_ASSOC)){
					
					$results[] = [
						"s" => "!" . $row["bang"],
						"n" => $row["name"]
					];
				}
				
				return $results;
			}else{
				
				// everything is empty
				// lets just return a bang list
				return [
					[
						"s" => "!w",
						"n" => "Wikipedia",
						"u" => "https://en.wikipedia.org/wiki/Special:Search?search={%q%}"
					],
					[
						"s" => "!4ch",
						"n" => "4chan Board",
						"u" => "https://find.4chan.org/?q={%q%}"
					],
					[
						"s" => "!a",
						"n" => "Amazon",
						"u" => "https://www.amazon.com/s?k={%q%}"
					],
					[
						"s" => "!e",
						"n" => "eBay",
						"u" => "https://www.ebay.com/sch/items/?_nkw={%q%}"
					],
					[
						"s" => "!so",
						"n" => "Stack Overflow",
						"u" => "http://stackoverflow.com/search?q={%q%}"
					],
					[
						"s" => "!gh",
						"n" => "GitHub",
						"u" => "https://github.com/search?utf8=%E2%9C%93&q={%q%}"
					],
					[
						"s" => "!tw",
						"n" => "Twitter",
						"u" => "https://twitter.com/search?q={%q%}"
					],
					[
						"s" => "!r",
						"n" => "Reddit",
						"u" => "https://www.reddit.com/search?q={%q%}"
					],
				];
			}
		}
		
		// now we know search isnt empty
		if(!empty($bang)){
			
			// check if the bang exists
			$conn = pg_connect("host=localhost dbname=4get user=postgres password=postgres");
			
			pg_prepare($conn, "bang_get_single", "SELECT bang,name FROM bangs WHERE bang = $1 LIMIT 1");
			$q = pg_execute($conn, "bang_get_single", [$bang]);
			
			$row = pg_fetch_array($q, null, PGSQL_ASSOC);
			
			if(isset($row["bang"])){
				
				$bang = "!$bang ";
			}else{
				
				$bang = "";
			}
		}
		
		try{
			$res = $this->get(
				"https://duckduckgo.com/ac/",
				[
					"q" => strtolower($search)
				],
				ddg::req_xhr
			);
			
			$res = json_decode($res, true);
			
		}catch(Exception $e){
			
			throw new Exception("Failed to get /ac/");
		}
		
		$arr = [];
		for($i=0; $i<count($res); $i++){
			
			if($i === 8){break;}
			
			if(empty($bang)){
				
				$arr[] = [
					"s" => $res[$i]["phrase"]
				];
			}else{
				
				$arr[] = [
					"s" => $bang . $res[$i]["phrase"],
					"n" => $row["name"]
				];
			}
		}
		
		return $arr;
	}
