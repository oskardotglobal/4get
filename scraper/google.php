<?php

class google{
	
	private const is_class = ".";
	private const is_id = "#";
	
	public function __construct(){
		
		include "lib/fuckhtml.php";
		$this->fuckhtml = new fuckhtml();
		
		include "lib/nextpage.php";
		$this->nextpage = new nextpage("google");
	}
	
	public function getfilters($page){
		
		switch($page){
			
			case "web":
			case "videos":
			case "news":
				return [
					"country" => [ // gl=<country>
						"display" => "Country",
						"option" => [
							"any" => "Instance's country",
							"af" => "Afghanistan",
							"al" => "Albania",
							"dz" => "Algeria",
							"as" => "American Samoa",
							"ad" => "Andorra",
							"ao" => "Angola",
							"ai" => "Anguilla",
							"aq" => "Antarctica",
							"ag" => "Antigua and Barbuda",
							"ar" => "Argentina",
							"am" => "Armenia",
							"aw" => "Aruba",
							"au" => "Australia",
							"at" => "Austria",
							"az" => "Azerbaijan",
							"bs" => "Bahamas",
							"bh" => "Bahrain",
							"bd" => "Bangladesh",
							"bb" => "Barbados",
							"by" => "Belarus",
							"be" => "Belgium",
							"bz" => "Belize",
							"bj" => "Benin",
							"bm" => "Bermuda",
							"bt" => "Bhutan",
							"bo" => "Bolivia",
							"ba" => "Bosnia and Herzegovina",
							"bw" => "Botswana",
							"bv" => "Bouvet Island",
							"br" => "Brazil",
							"io" => "British Indian Ocean Territory",
							"bn" => "Brunei Darussalam",
							"bg" => "Bulgaria",
							"bf" => "Burkina Faso",
							"bi" => "Burundi",
							"kh" => "Cambodia",
							"cm" => "Cameroon",
							"ca" => "Canada",
							"cv" => "Cape Verde",
							"ky" => "Cayman Islands",
							"cf" => "Central African Republic",
							"td" => "Chad",
							"cl" => "Chile",
							"cn" => "China",
							"cx" => "Christmas Island",
							"cc" => "Cocos (Keeling) Islands",
							"co" => "Colombia",
							"km" => "Comoros",
							"cg" => "Congo",
							"cd" => "Congo, the Democratic Republic",
							"ck" => "Cook Islands",
							"cr" => "Costa Rica",
							"ci" => "Cote D'ivoire",
							"hr" => "Croatia",
							"cu" => "Cuba",
							"cy" => "Cyprus",
							"cz" => "Czech Republic",
							"dk" => "Denmark",
							"dj" => "Djibouti",
							"dm" => "Dominica",
							"do" => "Dominican Republic",
							"ec" => "Ecuador",
							"eg" => "Egypt",
							"sv" => "El Salvador",
							"gq" => "Equatorial Guinea",
							"er" => "Eritrea",
							"ee" => "Estonia",
							"et" => "Ethiopia",
							"fk" => "Falkland Islands (Malvinas)",
							"fo" => "Faroe Islands",
							"fj" => "Fiji",
							"fi" => "Finland",
							"fr" => "France",
							"gf" => "French Guiana",
							"pf" => "French Polynesia",
							"tf" => "French Southern Territories",
							"ga" => "Gabon",
							"gm" => "Gambia",
							"ge" => "Georgia",
							"de" => "Germany",
							"gh" => "Ghana",
							"gi" => "Gibraltar",
							"gr" => "Greece",
							"gl" => "Greenland",
							"gd" => "Grenada",
							"gp" => "Guadeloupe",
							"gu" => "Guam",
							"gt" => "Guatemala",
							"gn" => "Guinea",
							"gw" => "Guinea-Bissau",
							"gy" => "Guyana",
							"ht" => "Haiti",
							"hm" => "Heard Island and Mcdonald Islands",
							"va" => "Holy See (Vatican City State)",
							"hn" => "Honduras",
							"hk" => "Hong Kong",
							"hu" => "Hungary",
							"is" => "Iceland",
							"in" => "India",
							"id" => "Indonesia",
							"ir" => "Iran, Islamic Republic",
							"iq" => "Iraq",
							"ie" => "Ireland",
							"il" => "Israel",
							"it" => "Italy",
							"jm" => "Jamaica",
							"jp" => "Japan",
							"jo" => "Jordan",
							"kz" => "Kazakhstan",
							"ke" => "Kenya",
							"ki" => "Kiribati",
							"kp" => "Korea, Democratic People's Republic",
							"kr" => "Korea, Republic",
							"kw" => "Kuwait",
							"kg" => "Kyrgyzstan",
							"la" => "Lao People's Democratic Republic",
							"lv" => "Latvia",
							"lb" => "Lebanon",
							"ls" => "Lesotho",
							"lr" => "Liberia",
							"ly" => "Libyan Arab Jamahiriya",
							"li" => "Liechtenstein",
							"lt" => "Lithuania",
							"lu" => "Luxembourg",
							"mo" => "Macao",
							"mk" => "Macedonia, the Former Yugosalv Republic",
							"mg" => "Madagascar",
							"mw" => "Malawi",
							"my" => "Malaysia",
							"mv" => "Maldives",
							"ml" => "Mali",
							"mt" => "Malta",
							"mh" => "Marshall Islands",
							"mq" => "Martinique",
							"mr" => "Mauritania",
							"mu" => "Mauritius",
							"yt" => "Mayotte",
							"mx" => "Mexico",
							"fm" => "Micronesia, Federated States",
							"md" => "Moldova, Republic",
							"mc" => "Monaco",
							"mn" => "Mongolia",
							"ms" => "Montserrat",
							"ma" => "Morocco",
							"mz" => "Mozambique",
							"mm" => "Myanmar",
							"na" => "Namibia",
							"nr" => "Nauru",
							"np" => "Nepal",
							"nl" => "Netherlands",
							"an" => "Netherlands Antilles",
							"nc" => "New Caledonia",
							"nz" => "New Zealand",
							"ni" => "Nicaragua",
							"ne" => "Niger",
							"ng" => "Nigeria",
							"nu" => "Niue",
							"nf" => "Norfolk Island",
							"mp" => "Northern Mariana Islands",
							"no" => "Norway",
							"om" => "Oman",
							"pk" => "Pakistan",
							"pw" => "Palau",
							"ps" => "Palestinian Territory, Occupied",
							"pa" => "Panama",
							"pg" => "Papua New Guinea",
							"py" => "Paraguay",
							"pe" => "Peru",
							"ph" => "Philippines",
							"pn" => "Pitcairn",
							"pl" => "Poland",
							"pt" => "Portugal",
							"pr" => "Puerto Rico",
							"qa" => "Qatar",
							"re" => "Reunion",
							"ro" => "Romania",
							"ru" => "Russian Federation",
							"rw" => "Rwanda",
							"sh" => "Saint Helena",
							"kn" => "Saint Kitts and Nevis",
							"lc" => "Saint Lucia",
							"pm" => "Saint Pierre and Miquelon",
							"vc" => "Saint Vincent and the Grenadines",
							"ws" => "Samoa",
							"sm" => "San Marino",
							"st" => "Sao Tome and Principe",
							"sa" => "Saudi Arabia",
							"sn" => "Senegal",
							"cs" => "Serbia and Montenegro",
							"sc" => "Seychelles",
							"sl" => "Sierra Leone",
							"sg" => "Singapore",
							"sk" => "Slovakia",
							"si" => "Slovenia",
							"sb" => "Solomon Islands",
							"so" => "Somalia",
							"za" => "South Africa",
							"gs" => "South Georgia and the South Sandwich Islands",
							"es" => "Spain",
							"lk" => "Sri Lanka",
							"sd" => "Sudan",
							"sr" => "Suriname",
							"sj" => "Svalbard and Jan Mayen",
							"sz" => "Swaziland",
							"se" => "Sweden",
							"ch" => "Switzerland",
							"sy" => "Syrian Arab Republic",
							"tw" => "Taiwan, Province of China",
							"tj" => "Tajikistan",
							"tz" => "Tanzania, United Republic",
							"th" => "Thailand",
							"tl" => "Timor-Leste",
							"tg" => "Togo",
							"tk" => "Tokelau",
							"to" => "Tonga",
							"tt" => "Trinidad and Tobago",
							"tn" => "Tunisia",
							"tr" => "Turkey",
							"tm" => "Turkmenistan",
							"tc" => "Turks and Caicos Islands",
							"tv" => "Tuvalu",
							"ug" => "Uganda",
							"ua" => "Ukraine",
							"ae" => "United Arab Emirates",
							"uk" => "United Kingdom",
							"us" => "United States",
							"um" => "United States Minor Outlying Islands",
							"uy" => "Uruguay",
							"uz" => "Uzbekistan",
							"vu" => "Vanuatu",
							"ve" => "Venezuela",
							"vn" => "Viet Nam",
							"vg" => "Virgin Islands, British",
							"vi" => "Virgin Islands, U.S.",
							"wf" => "Wallis and Futuna",
							"eh" => "Western Sahara",
							"ye" => "Yemen",
							"zm" => "Zambia",
							"zw" => "Zimbabwe"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes", // safe=active
							"no" => "No" // safe=off
						]
					],
					"lang" => [ // lr=<lang> (prefix lang with "lang_")
						"display" => "Language",
						"option" => [
							"any" => "Any language",
							"ar" => "Arabic",
							"bg" => "Bulgarian",
							"ca" => "Catalan",
							"cs" => "Czech",
							"da" => "Danish",
							"de" => "German",
							"el" => "Greek",
							"en" => "English",
							"es" => "Spanish",
							"et" => "Estonian",
							"fi" => "Finnish",
							"fr" => "French",
							"hr" => "Croatian",
							"hu" => "Hungarian",
							"id" => "Indonesian",
							"is" => "Icelandic",
							"it" => "Italian",
							"iw" => "Hebrew",
							"ja" => "Japanese",
							"ko" => "Korean",
							"lt" => "Lithuanian",
							"lv" => "Latvian",
							"nl" => "Dutch",
							"no" => "Norwegian",
							"pl" => "Polish",
							"pt" => "Portuguese",
							"ro" => "Romanian",
							"ru" => "Russian",
							"sk" => "Slovak",
							"sl" => "Slovenian",
							"sr" => "Serbian",
							"sv" => "Swedish",
							"tr" => "Turkish",
							"zh-CN" => "Chinese (Simplified)",
							"zh-TW" => "Chinese (Traditional)"
						]
					],
					"newer" => [ // &sort=review-date:r:20090301:20090430
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
				return [
					"country" => [ // gl=<country>
						"display" => "Country",
						"option" => [
							"any" => "Instance's country",
							"af" => "Afghanistan",
							"al" => "Albania",
							"dz" => "Algeria",
							"as" => "American Samoa",
							"ad" => "Andorra",
							"ao" => "Angola",
							"ai" => "Anguilla",
							"aq" => "Antarctica",
							"ag" => "Antigua and Barbuda",
							"ar" => "Argentina",
							"am" => "Armenia",
							"aw" => "Aruba",
							"au" => "Australia",
							"at" => "Austria",
							"az" => "Azerbaijan",
							"bs" => "Bahamas",
							"bh" => "Bahrain",
							"bd" => "Bangladesh",
							"bb" => "Barbados",
							"by" => "Belarus",
							"be" => "Belgium",
							"bz" => "Belize",
							"bj" => "Benin",
							"bm" => "Bermuda",
							"bt" => "Bhutan",
							"bo" => "Bolivia",
							"ba" => "Bosnia and Herzegovina",
							"bw" => "Botswana",
							"bv" => "Bouvet Island",
							"br" => "Brazil",
							"io" => "British Indian Ocean Territory",
							"bn" => "Brunei Darussalam",
							"bg" => "Bulgaria",
							"bf" => "Burkina Faso",
							"bi" => "Burundi",
							"kh" => "Cambodia",
							"cm" => "Cameroon",
							"ca" => "Canada",
							"cv" => "Cape Verde",
							"ky" => "Cayman Islands",
							"cf" => "Central African Republic",
							"td" => "Chad",
							"cl" => "Chile",
							"cn" => "China",
							"cx" => "Christmas Island",
							"cc" => "Cocos (Keeling) Islands",
							"co" => "Colombia",
							"km" => "Comoros",
							"cg" => "Congo",
							"cd" => "Congo, the Democratic Republic",
							"ck" => "Cook Islands",
							"cr" => "Costa Rica",
							"ci" => "Cote D'ivoire",
							"hr" => "Croatia",
							"cu" => "Cuba",
							"cy" => "Cyprus",
							"cz" => "Czech Republic",
							"dk" => "Denmark",
							"dj" => "Djibouti",
							"dm" => "Dominica",
							"do" => "Dominican Republic",
							"ec" => "Ecuador",
							"eg" => "Egypt",
							"sv" => "El Salvador",
							"gq" => "Equatorial Guinea",
							"er" => "Eritrea",
							"ee" => "Estonia",
							"et" => "Ethiopia",
							"fk" => "Falkland Islands (Malvinas)",
							"fo" => "Faroe Islands",
							"fj" => "Fiji",
							"fi" => "Finland",
							"fr" => "France",
							"gf" => "French Guiana",
							"pf" => "French Polynesia",
							"tf" => "French Southern Territories",
							"ga" => "Gabon",
							"gm" => "Gambia",
							"ge" => "Georgia",
							"de" => "Germany",
							"gh" => "Ghana",
							"gi" => "Gibraltar",
							"gr" => "Greece",
							"gl" => "Greenland",
							"gd" => "Grenada",
							"gp" => "Guadeloupe",
							"gu" => "Guam",
							"gt" => "Guatemala",
							"gn" => "Guinea",
							"gw" => "Guinea-Bissau",
							"gy" => "Guyana",
							"ht" => "Haiti",
							"hm" => "Heard Island and Mcdonald Islands",
							"va" => "Holy See (Vatican City State)",
							"hn" => "Honduras",
							"hk" => "Hong Kong",
							"hu" => "Hungary",
							"is" => "Iceland",
							"in" => "India",
							"id" => "Indonesia",
							"ir" => "Iran, Islamic Republic",
							"iq" => "Iraq",
							"ie" => "Ireland",
							"il" => "Israel",
							"it" => "Italy",
							"jm" => "Jamaica",
							"jp" => "Japan",
							"jo" => "Jordan",
							"kz" => "Kazakhstan",
							"ke" => "Kenya",
							"ki" => "Kiribati",
							"kp" => "Korea, Democratic People's Republic",
							"kr" => "Korea, Republic",
							"kw" => "Kuwait",
							"kg" => "Kyrgyzstan",
							"la" => "Lao People's Democratic Republic",
							"lv" => "Latvia",
							"lb" => "Lebanon",
							"ls" => "Lesotho",
							"lr" => "Liberia",
							"ly" => "Libyan Arab Jamahiriya",
							"li" => "Liechtenstein",
							"lt" => "Lithuania",
							"lu" => "Luxembourg",
							"mo" => "Macao",
							"mk" => "Macedonia, the Former Yugosalv Republic",
							"mg" => "Madagascar",
							"mw" => "Malawi",
							"my" => "Malaysia",
							"mv" => "Maldives",
							"ml" => "Mali",
							"mt" => "Malta",
							"mh" => "Marshall Islands",
							"mq" => "Martinique",
							"mr" => "Mauritania",
							"mu" => "Mauritius",
							"yt" => "Mayotte",
							"mx" => "Mexico",
							"fm" => "Micronesia, Federated States",
							"md" => "Moldova, Republic",
							"mc" => "Monaco",
							"mn" => "Mongolia",
							"ms" => "Montserrat",
							"ma" => "Morocco",
							"mz" => "Mozambique",
							"mm" => "Myanmar",
							"na" => "Namibia",
							"nr" => "Nauru",
							"np" => "Nepal",
							"nl" => "Netherlands",
							"an" => "Netherlands Antilles",
							"nc" => "New Caledonia",
							"nz" => "New Zealand",
							"ni" => "Nicaragua",
							"ne" => "Niger",
							"ng" => "Nigeria",
							"nu" => "Niue",
							"nf" => "Norfolk Island",
							"mp" => "Northern Mariana Islands",
							"no" => "Norway",
							"om" => "Oman",
							"pk" => "Pakistan",
							"pw" => "Palau",
							"ps" => "Palestinian Territory, Occupied",
							"pa" => "Panama",
							"pg" => "Papua New Guinea",
							"py" => "Paraguay",
							"pe" => "Peru",
							"ph" => "Philippines",
							"pn" => "Pitcairn",
							"pl" => "Poland",
							"pt" => "Portugal",
							"pr" => "Puerto Rico",
							"qa" => "Qatar",
							"re" => "Reunion",
							"ro" => "Romania",
							"ru" => "Russian Federation",
							"rw" => "Rwanda",
							"sh" => "Saint Helena",
							"kn" => "Saint Kitts and Nevis",
							"lc" => "Saint Lucia",
							"pm" => "Saint Pierre and Miquelon",
							"vc" => "Saint Vincent and the Grenadines",
							"ws" => "Samoa",
							"sm" => "San Marino",
							"st" => "Sao Tome and Principe",
							"sa" => "Saudi Arabia",
							"sn" => "Senegal",
							"cs" => "Serbia and Montenegro",
							"sc" => "Seychelles",
							"sl" => "Sierra Leone",
							"sg" => "Singapore",
							"sk" => "Slovakia",
							"si" => "Slovenia",
							"sb" => "Solomon Islands",
							"so" => "Somalia",
							"za" => "South Africa",
							"gs" => "South Georgia and the South Sandwich Islands",
							"es" => "Spain",
							"lk" => "Sri Lanka",
							"sd" => "Sudan",
							"sr" => "Suriname",
							"sj" => "Svalbard and Jan Mayen",
							"sz" => "Swaziland",
							"se" => "Sweden",
							"ch" => "Switzerland",
							"sy" => "Syrian Arab Republic",
							"tw" => "Taiwan, Province of China",
							"tj" => "Tajikistan",
							"tz" => "Tanzania, United Republic",
							"th" => "Thailand",
							"tl" => "Timor-Leste",
							"tg" => "Togo",
							"tk" => "Tokelau",
							"to" => "Tonga",
							"tt" => "Trinidad and Tobago",
							"tn" => "Tunisia",
							"tr" => "Turkey",
							"tm" => "Turkmenistan",
							"tc" => "Turks and Caicos Islands",
							"tv" => "Tuvalu",
							"ug" => "Uganda",
							"ua" => "Ukraine",
							"ae" => "United Arab Emirates",
							"uk" => "United Kingdom",
							"us" => "United States",
							"um" => "United States Minor Outlying Islands",
							"uy" => "Uruguay",
							"uz" => "Uzbekistan",
							"vu" => "Vanuatu",
							"ve" => "Venezuela",
							"vn" => "Viet Nam",
							"vg" => "Virgin Islands, British",
							"vi" => "Virgin Islands, U.S.",
							"wf" => "Wallis and Futuna",
							"eh" => "Western Sahara",
							"ye" => "Yemen",
							"zm" => "Zambia",
							"zw" => "Zimbabwe"
						]
					],
					"nsfw" => [
						"display" => "NSFW",
						"option" => [
							"yes" => "Yes", // safe=active
							"no" => "No" // safe=off
						]
					],
					"lang" => [ // lr=<lang> (prefix lang with "lang_")
						"display" => "Language",
						"option" => [
							"any" => "Any language",
							"ar" => "Arabic",
							"bg" => "Bulgarian",
							"ca" => "Catalan",
							"cs" => "Czech",
							"da" => "Danish",
							"de" => "German",
							"el" => "Greek",
							"en" => "English",
							"es" => "Spanish",
							"et" => "Estonian",
							"fi" => "Finnish",
							"fr" => "French",
							"hr" => "Croatian",
							"hu" => "Hungarian",
							"id" => "Indonesian",
							"is" => "Icelandic",
							"it" => "Italian",
							"iw" => "Hebrew",
							"ja" => "Japanese",
							"ko" => "Korean",
							"lt" => "Lithuanian",
							"lv" => "Latvian",
							"nl" => "Dutch",
							"no" => "Norwegian",
							"pl" => "Polish",
							"pt" => "Portuguese",
							"ro" => "Romanian",
							"ru" => "Russian",
							"sk" => "Slovak",
							"sl" => "Slovenian",
							"sr" => "Serbian",
							"sv" => "Swedish",
							"tr" => "Turkish",
							"zh-CN" => "Chinese (Simplified)",
							"zh-TW" => "Chinese (Traditional)"
						]
					],
					"time" => [ // tbs=qrd:<size>
						"display" => "Time posted",
						"option" => [
							"any" => "Any time",
							"d" => "Past 24 hours",
							"w" => "Past week",
							"m" => "Past month",
							"y" => "Past year"
						]
					],
					"size" => [
						"display" => "Size",
						"option" => [
							// tbs=isz:<size>
							"any" => "Any size",
							"l" => "Large",
							"m" => "Medium",
							"i" => "Icon",
							// from here
							// tbz:lt,islt:<size>
							"qsvga" => "Larger than 400x300",
							"vga" => "Larger than 640x480",
							"qsvga" => "Larger than 800x600",
							"xga" => "Larger than 1024x768",
							"2mp" => "Larger than 2MP",
							"4mp" => "Larger than 4MP",
							"6mp" => "Larger than 6MP",
							"8mp" => "Larger than 8MP",
							"10mp" => "Larger than 10MP",
							"12mp" => "Larger than 12MP",
							"15mp" => "Larger than 15MP",
							"20mp" => "Larger than 20MP",
							"40mp" => "Larger than 40MP",
							"70mp" => "Larger than 70MP"
						]
					],
					"ratio" => [ // tbs=iar:<size>
						"display" => "Aspect ratio",
						"option" => [
							"any" => "Any ratio",
							"t" => "Tall",
							"s" => "Square",
							"w" => "Wide",
							"xw" => "Panoramic"
						]
					],
					"color" => [ // tbs=ic:<color>
						"display" => "Color",
						"option" => [
							"any" => "Any color",
							"color" => "Full color",
							"gray" => "Black & white",
							"trans" => "Transparent",
							// from there, its ic:specific,isc:<color>
							"red" => "Red",
							"orange" => "Orange",
							"yellow" => "Yellow",
							"green" => "Green",
							"teal" => "Teal",
							"blue" => "Blue",
							"purple" => "Purple",
							"pink" => "Pink",
							"white" => "White",
							"gray" => "Gray",
							"black" => "Black",
							"brown" => "Brown"
						]
					],
					"type" => [ // tbs=itp:<type>
						"display" => "Type",
						"option" => [
							"any" => "Any type",
							"face" => "Faces",
							"clipart" => "Clip Art",
							"lineart" => "Line Drawing",
							"stock" => "Stock",
							"animated" => "Animated"
						]
					],
					"format" => [ // tbs=ift:<format>
						"display" => "Format",
						"option" => [
							"any" => "Any format",
							"jpg" => "JPG",
							"gif" => "GIF",
							"png" => "PNG",
							"bmp" => "BMP",
							"svg" => "SVG",
							"webp" => "WEBP",
							"ico" => "ICO",
							"craw" => "RAW"
						]
					],
					"rights" => [ // tbs=il:<rights>
						"display" => "Usage rights",
						"option" => [
							"any" => "Any license",
							"cl" => "Creative Commons licenses",
							"ol" => "Commercial & other licenses"
						]
					]
				];
				break;
		}
	}
	
	private function get($url, $get = []){
		
		$headers = [
			"User-Agent: Mozilla/5.0 (Linux; U; Android 2.3.3; pt-pt; LG-P500h-parrot Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 MMS/LG-Android-MMS-V1.0/1.2",
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
		
		$curlproc = curl_init();
		
		if($get !== []){
			$get = http_build_query($get);
			$url .= "?" . $get;
		}
		
		curl_setopt($curlproc, CURLOPT_URL, $url);
		
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
	
	public function web($get){
		
		$search = $get["s"];
		$country = $get["country"];
		$nsfw = $get["nsfw"];
		$lang = $get["lang"];
		$older = $get["older"];
		$newer = $get["newer"];
		
		$params = [
			"num" => 20 // get 20 results
		];
		
		// country
		if($country != "any"){
			
			$params["gl"] = $country;
		}
		
		// nsfw
		$params["safe"] = $nsfw == "yes" ? "off" : "active";
		
		// language
		if($lang != "any"){
			
			$params["lr"] = "lang_" . $lang;
		}
		
		// &sort=review-date:r:20090301:20090430
		$older = $older === false ? false : date("Ymd", $older);
		$newer = $newer === false ? false : date("Ymd", $newer);
		
		if(
			$older !== false &&
			$newer === false
		){
			
			$newer = date("Ymd", time());
		}
		
		if(
			$older !== false ||
			$newer !== false
		){
			
			$params["sort"] = "review-date:r:" . $older . ":" . $newer;
		}
		
		$handle = fopen("scraper/google.html", "r");
		$html = fread($handle, filesize("scraper/google.html"));
		fclose($handle);
		
		$this->fuckhtml->load($html);
		
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
	}
	
	
	public function image($get){
		
		// generate parameters
		if($get["npt"]){
			
			$params =
				json_decode(
					$this->nextpage->get(
						$get["npt"],
						"images"
					),
					true
				);
		}else{
			
			$search = $get["s"];
			$country = $get["country"];
			$nsfw = $get["nsfw"];
			$lang = $get["lang"];
			$time = $get["time"];
			$size = $get["size"];
			$ratio = $get["ratio"];
			$color = $get["color"];
			$type = $get["type"];
			$format = $get["format"];
			$rights = $get["rights"];
			
			$params = [
				"q" => $search,
				"tbm" => "isch"
			];
			
			// country
			if($country != "any"){
				
				$params["gl"] = $country;
			}
			
			// nsfw
			$params["safe"] = $nsfw == "yes" ? "off" : "active";
			
			// language
			if($lang != "any"){
				
				$params["lr"] = "lang_" . $lang;
			}
			
			$tbs = [];
			
			// time
			if($time != "any"){
				
				$tbs[] = "qrd:" . $time;
			}
			
			// size
			if($size != "any"){
				
				if(
					in_array(
						$size,
						["l", "s", "i"]
					)
				){
					
					$tbs[] = "isz:" . $size;
				}else{
					
					$tbs[] = "tbz:lt";
					$tbs[] = "islt:" . $size;
				}
			}
			
			// ratio
			if($ratio != "any"){
				
				$tbs[] = "iar:" . $ratio;
			}
			
			// color
			if($color != "any"){
				
				if(
					in_array(
						$color,
						["color", "gray", "trans"]
					)
				){
					
					$tbs[] = "ic:" . $color;
				}else{
					
					$tbs[] = "ic:specific";
					$tbs[] = "isc:" . $color;
				}
			}
			
			// type
			if($type != "any"){
				
				$tbs[] = "itp:" . $type;
			}
			
			// format
			if($format != "any"){
				
				$tbs[] = "ift:" . $format;
			}
			
			// rights
			if($rights != "any"){
				
				$tbs[] = "il:" . $rights;
			}
			
			// append tbs
			if(count($tbs) !== 0){
				
				$params["tbs"] =
					implode(",", $tbs);
			}
		}
		
		/*
		$handle = fopen("scraper/google-img.html", "r");
		$html = fread($handle, filesize("scraper/google-img.html"));
		fclose($handle);*/
		
		// scrape images
		try{
			$html = 
				$this->get(
					"https://www.google.com/search",
					$params
				);
		}catch(Exception $error){
			
			throw new Exception("Failed to get search page");
		}
		
		$this->fuckhtml->load($html);
		
		$out = [
			"status" => "ok",
			"npt" => null,
			"image" => []
		];
		
		$images =
			$this->fuckhtml
			->getElementsByClassName(
				"islrtb isv-r",
				"div"
			);
		
		foreach($images as $image){
			
			$this->fuckhtml->load($image);
			$img =
				$this->fuckhtml
				->getElementsByTagName("img")[0];
			
			$og_width = (int)$image["attributes"]["data-ow"];
			$og_height = (int)$image["attributes"]["data-oh"];
			$thumb_width = (int)$image["attributes"]["data-tw"];
			
			$ratio = $og_width / $og_height;
			
			if(isset($img["attributes"]["data-src"])){
				
				$src = &$img["attributes"]["data-src"];
			}else{
				
				$src = &$img["attributes"]["src"];
			}
			
			$thumb_height = floor($thumb_width / $ratio);
			
			$out["image"][] = [
				"title" =>
					$this->titledots(
						$this->fuckhtml
						->getTextContent(
							$image["attributes"]["data-pt"]
						)
					),
				"source" => [
					[
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$image["attributes"]["data-ou"]
							),
						"width" => $og_width,
						"height" => $og_height
					],
					[
						"url" =>
							$this->fuckhtml
							->getTextContent(
								$src
							),
						"width" => $thumb_width,
						"height" => $thumb_height
					]
				],
				"url" =>
					$this->fuckhtml
					->getTextContent(
						$image["attributes"]["data-ru"]
					)
			];
		}
		
		// get next page
		// https://www.google.com/search
		// ?q=higurashi
		// &tbm=isch
		// &async=_id%3Aislrg_c%2C_fmt%3Ahtml
		// &asearch=ichunklite
		// &ved=0ahUKEwidjYXJqJSAAxWrElkFHZ07CDwQtDIIQygA
		
		if(count($out["image"]) !== 100){
			
			// no more results
			return $out;
		}
		
		if($get["npt"]){
			
			// update nextpage information
			$params["start"] = (int)$params["start"] + count($out["image"]);
			$params["ijn"] = (int)$params["ijn"] + 1;
			
			$out["npt"] =
				$this->nextpage->store(
					json_encode($params),
					"images"
				);
		}else{
			
			// scrape nextpage information
			$this->fuckhtml->load($html);
			
			$ved =
				$this->fuckhtml
				->getElementById("islrg", "div");
			
			if($ved){
				
				$ved =
					$this->fuckhtml
					->getTextContent(
						$ved["attributes"]["data-ved"]
					);
				
				// &vet=1{$ved}..i (10ahUKEwidjYXJqJSAAxWrElkFHZ07CDwQtDIIQygA..i)
				
				/*
					These 2 are handled by us
					start = start + number of results
					ijn = current page number
				*/
				// &start=100
				// &ijn=1
				
				// &imgvl=CAEY7gQgBSj3Aji8VTjXVUC4AUC3AUgAYNdV
				preg_match(
					'/var e=\'([A-z0-9]+)\';/',
					$html,
					$imgvl
				);
				
				$imgvl = $imgvl[1];
				
				$params["async"] = "_id:islrg_c,_fmt:html";
				$params["asearch"] = "ichunklite";
				$params["ved"] = $ved;
				$params["vet"] = "1" . $ved . "..i";
				$params["start"] = 100;
				$params["ijn"] = 1;
				$params["imgvl"] = $imgvl;
				
				$out["npt"] =
					$this->nextpage->store(
						json_encode($params),
						"images"
					);
			}
		}
		
		return $out;
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
	
	private function loadjavascriptcrap($html){
		
		$this->fuckhtml->load($html);
		
		$styles =
			$this->fuckhtml
			->getElementsByTagName("style");
		
		$this->computedstyle = [];
		$this->ask = [];
		
		foreach($styles as $style){
			
			$this->computedstyle =
				array_merge(
					$this->computedstyle,
					$this->parsestyles($style["innerHTML"])
				);	
		}
		
		// get images in javascript var
		preg_match(
			'/google\.ldi=({[^}]+})/',
			$html,
			$this->js_image
		);
		
		if(count($this->js_image) !== 0){
			
			$this->js_image = json_decode($this->js_image[1], true);
		}else{
			
			$this->js_image = [];
		}
		
		// additional js_images present in <script> tags
		// ugh i fucking hate you
		$scripts =
			$this->fuckhtml
			->getElementsByTagName("script");
		
		foreach($scripts as $script){
			
			if(!isset($script["innerHTML"])){
				
				continue;
			}
			
			preg_match_all(
				'/var s=\'(data:image[^\']+)\';var i=\[\'([^\']+)\'];/',
				$script["innerHTML"],
				$image_grep
			);
			
			if(count($image_grep[0]) !== 0){
				
				$this->js_image[trim($image_grep[2][0])] =
					$this->fuckhtml
					->getTextContent(
						$image_grep[1][0]
					);
			}
			
			// even more javascript crap
			// "People also ask" node is loaded trough javascript
			preg_match_all(
				'/window\.jsl\.dh\(\'([^\']+)\',\'(.+)\'\);/',
				$script["innerHTML"],
				$ask_grep
			);
			
			for($i=0; $i<count($ask_grep[0]); $i++){
				
				$this->ask[trim($ask_grep[1][$i])] =
					stripcslashes(
						$ask_grep[2][$i]
					);
			}
		}
	}
	
	private function findstyles($rules, $is){
		
		ksort($rules);
		
		foreach($this->computedstyle as $stylename => $styles){
			
			if($styles == $rules){
				
				preg_match(
					'/\\' . $is . '([^ .]+)/',
					$stylename,
					$out
				);
				
				if(count($out) === 2){
					
					return $out[1];
				}
				
				return false;
			}
		}
		
		return false;
	}
	
	private function parsestyles($style){
		
		// get style tags
		preg_match_all(
			'/([^{]+){([^}]+)}/',
			$style,
			$tags_regex
		);
		
		$tags = [];
		
		for($i=0; $i<count($tags_regex[0]); $i++){
			
			$tagnames = explode(",", trim($tags_regex[1][$i]));
			
			foreach($tagnames as $tagname){
				
				$tagname = trim($tagname);
				
				if(!isset($tags[$tagname])){
					$tags[$tagname] = [];
				}
				
				$values = explode(";", $tags_regex[2][$i]);
				
				foreach($values as $value){
					
					$value = explode(":", $value, 2);
					
					if(count($value) !== 2){
						
						continue;
					}
					
					$tags[$tagname][trim($value[0])] =
						trim($value[1]);
				}
			}
		}
		
		foreach($tags as &$value){
			
			ksort($value);
		}
		
		return $tags;
	}
	
	private function getimage($id){
		
		if(
			isset($this->js_image[$id]) &&
			$this->js_image[$id] != "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABAUlEQVR4AWMYesChoYElLjkzPj4lY3d8csZjIL4MxPNjUzPcSTYsISFLAqj5NBD/h+LPQPwbiT87NCuLh2gDgRr2QzXuT0jNMoBYksARn5zuHJ+UcR0kB6RXE2VYXHJGOlTDZmzyIJcB5e+D1CSkZDgQNBAaZv+jU1JkcKpJygiGeZ0I76a/Byq8jU9NZFqaCNTA48SE33/iDcw8TIyBt0GKQTFN0Msp6f2EIyUpo57YSIlLSrMhIg0WCIBcCfXSdlzJBsheTHQ6jEnOUgEFOLaEDbMIlhZBOYrorAdJk+nroVnvPsSgdGdoOF7HZyhZ2XPoGQoqjbCpIbt0AiejIQMArVLI7k/DXFkAAAAASUVORK5CYII="
		){
			
			if(stripos($this->js_image[$id], "data:image") !== false){
				
				return
					explode(
						"\\x3d",
						$this->js_image[$id],
						2
					)[0];
			}
			
			return $this->js_image[$id];
		}
		
		return null;
	}
	
	private function decodeurl($url){
		
		preg_match(
			'/^\/url\?q=([^&]+)|^\/interstitial\?url=([^&]+)/',
			$this->fuckhtml
			->getTextContent($url),
			$match
		);
		
		if(count($match) === 0){
			
			return null;
		}
		
		$url = empty($match[1]) ? urldecode($match[2]) : urldecode($match[1]);
		
		$domain = parse_url($url, PHP_URL_HOST);
		
		if(
			preg_match(
				'/wikipedia.org$/',
				$domain
			)
		){
			
			// rewrite wikipedia mobile URLs to desktop
			$url =
				$this->replacedomain(
					$url,
					preg_replace(
						'/([a-z0-9]+)(\.m\.)/',
						'$1.',
						$domain
					)
				);
		}
		
		if(
			preg_match(
				'/imdb\.com$|youtube\.[^.]+$/',
				$domain
			)
		){
			
			// rewrite imdb and youtube mobile URLs too
			$url =
				$this->replacedomain(
					$url,
					preg_replace(
						'/^m\./',
						"",
						$domain
					)
				);
			
		}
		
		return $url;
	}
	
	private function replacedomain($url, $domain){
		
		return
			preg_replace(
				'/(https?:\/\/)([^\/]+)/',
				'$1' . $domain,
				$url
			);
	}
	
	private function titledots($title){
		
		return rtrim($title, ".… \t\n\r\0\x0B");
	}
}
