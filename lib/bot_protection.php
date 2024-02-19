<?php

class bot_protection{
	
	public function __construct($frontend, $get, $filters, $page, $output){
		
		// check if we want captcha
		if(config::BOT_PROTECTION !== 1){
			
			apcu_inc("real_requests");
			if($output === true){
				$frontend->loadheader(
					$get,
					$filters,
					$page
				);
			}
			return;
		}
		
		/*
			Validate cookie, if it exists
		*/
		if(isset($_COOKIE["pass"])){
			
			if(
				// check if key is not malformed
				preg_match(
					'/^k[0-9]+\.[A-Za-z0-9_]{20}$/',
					$_COOKIE["pass"]
				) &&
				// does key exist
				apcu_exists($_COOKIE["pass"])
			){
					
				// exists, increment counter
				$inc = apcu_inc($_COOKIE["pass"]);
				
				// we start counting from 1
				// when it has been incremented to 102, it has reached
				// 100 reqs
				if($inc >= config::MAX_SEARCHES + 2){
					
					// reached limit, delete and give captcha
					apcu_delete($_COOKIE["pass"]);
				}else{
					
					// the cookie is OK! dont die() and give results
					apcu_inc("real_requests");
					
					if($output === true){
						$frontend->loadheader(
							$get,
							$filters,
							$page
						);
					}
					return;
				}
			}
		}
		
		if($output === false){
			
			http_response_code(401); // forbidden
			echo json_encode([
				"status" => "The \"pass\" token in your cookies is missing or has expired!!"
			]);
			die();
		}
		
		/*
			Validate form data
		*/
		$lines =
			explode(
				"\r\n",
				file_get_contents("php://input")
			);

		$invalid = false;
		$answers = [];
		$key = false;
		$error = "";

		foreach($lines as $line){
			
			$line = explode("=", $line, 2);
			
			if(count($line) !== 2){
				
				$invalid = true;
				break;
			}
			
			preg_match(
				'/^c\[([0-9]+)\]$/',
				$line[0],
				$regex
			);
			
			if(
				$line[1] != "on" ||
				!isset($regex[0][1])
			){
				
				// check if its the v key
				if(
					$line[0] == "v" &&
					preg_match(
						'/^c[0-9]+\.[A-Za-z0-9_]{20}$/',
						$line[1]
					)
				){
					
					$key = apcu_fetch($line[1]);
					apcu_delete($line[1]);
				}
				break;
			}
			
			$regex = (int)$regex[1];
			
			if(
				$regex >= 16 ||
				$regex <= -1
			){
				
				$invalid = true;
				break;
			}
			
			$answers[] = $regex;
		}
		
		if(
			!$invalid &&
			$key !== false // has captcha been gen'd?
		){
			$check = count($key);
			
			// validate answer
			for($i=0; $i<count($answers); $i++){
				
				if(in_array($answers[$i], $key)){
					
					$check--;
				}else{
					
					$check = -1;
					break;
				}
			}
			
			if($check === 0){
				
				// we passed the captcha
				// set cookie
				$inc = apcu_inc("cookie");
				
				$key = "k" . $inc . "." . $this->randomchars();
				
				apcu_inc($key, 1, $stupid, 86400);
				
				apcu_inc("real_requests");
				
				setcookie(
					"pass",
					$key,
					[
						"expires" => time() + 86400, // expires in 24 hours
						"samesite" => "Lax",
						"path" => "/"
					]
				);
				
				$frontend->loadheader(
					$get,
					$filters,
					$page
				);
				return;
				
			}else{
				
				$error = "<div class=\"quote\">You were <a href=\"https://www.youtube.com/watch?v=e1d7fkQx2rk\" target=\"_BLANK\" rel=\"noreferrer nofollow\">kicked out of Mensa.</a> Please try again.</div>";
			}
		}
		
		$key = "c" . apcu_inc("captcha_gen", 1) . "." . $this->randomchars();
		
		$payload = [
			"timetaken" => microtime(true),
			"class" => "",
			"right-left" => "",
			"right-right" => "",
			"left" =>
				'<div class="infobox">' .
					'<h1>IQ test</h1>' .
					'IQ test has been enabled due to bot abuse on the network.<br>' .
					'Solving this IQ test will let you make 100 searches today. I will add an invite system to bypass this soon...' .
					$error .
					'<form method="POST" enctype="text/plain" autocomplete="off">' .
						'<div class="captcha-wrapper">' .
							'<div class="captcha">' .
								'<img src="captcha?v=' . $key . '" alt="Captcha image">' .
								'<div class="captcha-controls">' .
									'<input type="checkbox" name="c[0]" id="c0">' .
									'<label for="c0"></label>' .
									'<input type="checkbox" name="c[1]" id="c1">' .
									'<label for="c1"></label>' .
									'<input type="checkbox" name="c[2]" id="c2">' .
									'<label for="c2"></label>' .
									'<input type="checkbox" name="c[3]" id="c3">' .
									'<label for="c3"></label>' .
									'<input type="checkbox" name="c[4]" id="c4">' .
									'<label for="c4"></label>' .
									'<input type="checkbox" name="c[5]" id="c5">' .
									'<label for="c5"></label>' .
									'<input type="checkbox" name="c[6]" id="c6">' .
									'<label for="c6"></label>' .
									'<input type="checkbox" name="c[7]" id="c7">' .
									'<label for="c7"></label>' .
									'<input type="checkbox" name="c[8]" id="c8">' .
									'<label for="c8"></label>' .
									'<input type="checkbox" name="c[9]" id="c9">' .
									'<label for="c9"></label>' .
									'<input type="checkbox" name="c[10]" id="c10">' .
									'<label for="c10"></label>' .
									'<input type="checkbox" name="c[11]" id="c11">' .
									'<label for="c11"></label>' .
									'<input type="checkbox" name="c[12]" id="c12">' .
									'<label for="c12"></label>' .
									'<input type="checkbox" name="c[13]" id="c13">' .
									'<label for="c13"></label>' .
									'<input type="checkbox" name="c[14]" id="c14">' .
									'<label for="c14"></label>' .
									'<input type="checkbox" name="c[15]" id="c15">' .
									'<label for="c15"></label>' .
								'</div>' .
							'</div>' .
						'</div>' .
						'<input type="hidden" name="v" value="' . $key . '">' .
						'<input type="submit" value="Check IQ" class="captcha-submit">' .
					'</form>' .
				'</div>'
		];
		
		$frontend->loadheader(
			$get,
			$filters,
			$page
		);
		
		echo $frontend->load("search.html", $payload);
		die();
	}
	
	private function randomchars(){
		
		$chars =
			array_merge(
				range("A", "Z"),
				range("a", "z"),
				range(0, 9)
			);
		
		$chars[] = "_";
		
		$c = count($chars) - 1;
		
		$key = "";
		
		for($i=0; $i<20; $i++){
			
			$key .= $chars[random_int(0, $c)];
		}
		
		return $key;
	}
}
