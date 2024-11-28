<?php
class fuckhtml{
	
	public function __construct($html = null, $isfile = false){
		
		if($html !== null){
			
			$this->load($html, $isfile);
		}
	}
	
	public function load($html, $isfile = false){
		
		if(is_array($html)){
			
			if(!isset($html["innerHTML"])){
				
				throw new Exception("(load) Supplied array doesn't contain an innerHTML index");
			}
			$html = $html["innerHTML"];
		}
		
		if($isfile){
			
			$handle = fopen($html, "r");
			$fetch = fread($handle, filesize($html));
			fclose($handle);
			
			$this->html = $fetch;
		}else{
			
			$this->html = $html;
		}
		
		$this->strlen = strlen($this->html);
	}
	
	public function getloadedhtml(){
		
		return $this->html;
	}
	
	public function getElementsByTagName(string $tagname){
		
		$out = [];
		
		/*
			Scrape start of the tag. Example
			<div class="mydiv"> ...
		*/
		
		if($tagname == "*"){
			
			$tagname = '[A-Za-z0-9._-]+';
		}else{
			
			$tagname = preg_quote(strtolower($tagname));
		}
		
		preg_match_all(
			'/<\s*(' . $tagname . ')(\s(?:[^>\'"]*|"[^"]*"|\'[^\']*\')+)?\s*>/i',
			/* '/<\s*(' . $tagname . ')(\s[\S\s]*?)?>/i', */
			$this->html,
			$starting_tags,
			PREG_OFFSET_CAPTURE
		);
		
		for($i=0; $i<count($starting_tags[0]); $i++){
			
			/*
				Parse attributes
			*/
			$attributes = [];

			preg_match_all(
				'/([^\/\s\\=]+)(?:\s*=\s*("[^"]*"|\'[^\']*\'|[^\s]*))?/i',
				$starting_tags[2][$i][0],
				$regex_attributes
			);
			
			for($k=0; $k<count($regex_attributes[0]); $k++){
				
				if(trim($regex_attributes[2][$k]) == ""){
					
					$attributes[$regex_attributes[1][$k]] =
						"true";
					
					continue;
				}
				
				$attributes[strtolower($regex_attributes[1][$k])] =
					trim($regex_attributes[2][$k], "'\" \n\r\t\v\x00");
			}
			
			$out[] = [
				"tagName" => strtolower($starting_tags[1][$i][0]),
				"startPos" => $starting_tags[0][$i][1],
				"endPos" => 0,
				"startTag" => $starting_tags[0][$i][0],
				"attributes" => $attributes,
				"innerHTML" => null
			];
		}
		
		/*
			Get innerHTML
		*/
		// get closing tag positions
		preg_match_all(
			'/<\s*\/\s*(' . $tagname . ')\s*>/i',
			$this->html,
			$regex_closing_tags,
			PREG_OFFSET_CAPTURE
		);
		
		// merge opening and closing tags together
		for($i=0; $i<count($regex_closing_tags[1]); $i++){
			
			$out[] = [
				"tagName" => strtolower($regex_closing_tags[1][$i][0]),
				"endTag" => $regex_closing_tags[0][$i][0],
				"startPos" => $regex_closing_tags[0][$i][1]
			];
		}
		
		usort(
			$out,
			function($a, $b){
				
				return $a["startPos"] > $b["startPos"];
			}
		);
		
		// compute the indent level for each element
		$level = [];
		$count = count($out);
		
		for($i=0; $i<$count; $i++){
			
			if(!isset($level[$out[$i]["tagName"]])){
				
				$level[$out[$i]["tagName"]] = 0;
			}
			
			if(isset($out[$i]["startTag"])){
				
				// encountered starting tag
				$level[$out[$i]["tagName"]]++;
				$out[$i]["level"] = $level[$out[$i]["tagName"]];
			}else{
				
				// encountered closing tag
				$out[$i]["level"] = $level[$out[$i]["tagName"]];
				$level[$out[$i]["tagName"]]--;
			}
		}
		
		// if the indent level is the same for a div,
		// we encountered _THE_ closing tag
		for($i=0; $i<$count; $i++){
			
			if(!isset($out[$i]["startTag"])){
				
				continue;
			}
			
			for($k=$i; $k<$count; $k++){
				
				if(
					isset($out[$k]["endTag"]) &&
					$out[$i]["tagName"] == $out[$k]["tagName"] &&
					$out[$i]["level"]
					=== $out[$k]["level"]
				){
					
					$startlen = strlen($out[$i]["startTag"]);
					$endlen = strlen($out[$k]["endTag"]);
					
					$out[$i]["endPos"] = $out[$k]["startPos"] + $endlen;
					
					$out[$i]["innerHTML"] =
						substr(
							$this->html,
							$out[$i]["startPos"] + $startlen,
							$out[$k]["startPos"] - ($out[$i]["startPos"] + $startlen)
						);
					
					$out[$i]["outerHTML"] =
						substr(
							$this->html,
							$out[$i]["startPos"],
							$out[$k]["startPos"] - $out[$i]["startPos"] + $endlen
						);
					
					break;
				}
			}
		}
		
		// filter out ending divs
		for($i=0; $i<$count; $i++){
			
			if(isset($out[$i]["endTag"])){
				
				unset($out[$i]);
			}
			
			unset($out[$i]["startTag"]);
		}
		
		return array_values($out);
	}
	
	public function getElementsByAttributeName(string $name, $collection = null){
		
		if($collection === null){
			
			$collection = $this->getElementsByTagName("*");
		}elseif(is_string($collection)){
			
			$collection = $this->getElementsByTagName($collection);
		}
		
		$return = [];
		foreach($collection as $elem){
			
			foreach($elem["attributes"] as $attrib_name => $attrib_value){
				
				if($attrib_name == $name){
					
					$return[] = $elem;
					continue 2;
				}
			}
		}
		
		return $return;
	}
	
	public function getElementsByFuzzyAttributeValue(string $name, string $value, $collection = null){
		
		$elems = $this->getElementsByAttributeName($name, $collection);
		$value =
			explode(
				" ",
				trim(
					preg_replace(
						'/ +/',
						" ",
						$value
					)
				)
			);
		
		$return = [];
		
		foreach($elems as $elem){
			
			foreach($elem["attributes"] as $attrib_name => $attrib_value){
				
				$attrib_value = explode(" ", $attrib_value);
				$ac = count($attrib_value);
				$nc = count($value);
				$cr = 0;
				
				for($i=0; $i<$nc; $i++){
					
					for($k=0; $k<$ac; $k++){
						
						if($value[$i] == $attrib_value[$k]){
							
							$cr++;
						}
					}
				}
				
				if($cr === $nc){
					
					$return[] = $elem;
					continue 2;
				}
			}
		}
		
		return $return;
	}
	
	public function getElementsByAttributeValue(string $name, string $value, $collection = null){
		
		$elems = $this->getElementsByAttributeName($name, $collection);
		
		$return = [];
		
		foreach($elems as $elem){
			
			foreach($elem["attributes"] as $attrib_name => $attrib_value){
				
				if($attrib_value == $value){
					
					$return[] = $elem;
					continue 2;
				}
			}
		}
		
		return $return;
	}
	
	public function getElementById(string $idname, $collection = null){
		
		$id = $this->getElementsByAttributeValue("id", $idname, $collection);
		
		if(count($id) !== 0){
			
			return $id[0];
		}
		
		return false;
	}
	
	public function getElementsByClassName(string $classname, $collection = null){
		
		return $this->getElementsByFuzzyAttributeValue("class", $classname, $collection);
	}
	
	public function getTextContent($html, $whitespace = false, $trim = true){
		
		if(is_array($html)){
			
			if(!isset($html["innerHTML"])){
				
				throw new Exception("(getTextContent) Supplied array doesn't contain an innerHTML index");
			}
			
			$html = $html["innerHTML"];
		}
		
		$html = preg_split('/\n|<\/?br>/i', $html);
		
		$out = "";
		for($i=0; $i<count($html); $i++){
			
			$tmp =
				html_entity_decode(
					strip_tags(
						$html[$i]
					),
					ENT_QUOTES | ENT_XML1, "UTF-8"
				);
			
			if($trim){
				
				$tmp = trim($tmp);
			}
			
			$out .= $tmp;
			
			if($whitespace === true){
				
				$out .= "\n";
			}else{
				
				$out .= " ";
			}
		}
		
		if($trim){
			
			return trim($out);
		}
		
		return $out;
	}
	
	public function parseJsObject(string $json){
		
		$bracket = false;
		$is_close_bracket = false;
		$escape = false;
		$lastchar = false;
		$json_out = null;
		$last_char = null;
		
		$keyword_check = null;
		
		for($i=0; $i<strlen($json); $i++){
			
			switch($json[$i]){
				
				case "\"":
				case "'":
					if($escape === true){
						
						break;
					}
					
					if($json[$i] == $bracket){
						
						$bracket = false;
						$is_close_bracket = true;
						
					}else{
						
						if($bracket === false){
							
							$bracket = $json[$i];
						}
					}
					break;
				
				default:
					$is_close_bracket = false;
					break;
			}
			
			if(
				$json[$i] == "\\" &&
				!(
					$lastchar !== false &&
					$lastchar . $json[$i] == "\\\\"
				)
			){
				
				$escape = true;
			}else{
				
				$escape = false;
			}
			
			if(
				$bracket === false &&
				$is_close_bracket === false
			){
				
				// do keyword check
				$keyword_check .= $json[$i];
				
				if(in_array($json[$i], [":", "{"])){
					
					$keyword_check = substr($keyword_check, 0, -1);
					
					if(
						preg_match(
							'/function|array|return/i',
							$keyword_check
						)
					){
						
						$json_out =
							preg_replace(
								'/[{"]*' . preg_quote($keyword_check, "/") . '$/',
								"",
								$json_out
							);
					}
					
					$keyword_check = null;
				}
				
				// here we know we're not iterating over a quoted string
				switch($json[$i]){
					
					case "[":
					case "{":
						$json_out .= $json[$i];
						break;
					
					case "]":
					case "}":
					case ",":
					case ":":
						if(!in_array($last_char, ["[", "{", "}", "]", "\""])){
							
							$json_out .= "\"";
						}
						
						$json_out .= $json[$i];
						break;
					
					default:
						if(in_array($last_char, ["{", "[", ",", ":"])){
							
							$json_out .= "\"";
						}
						
						$json_out .= $json[$i];
						break;
				}
			}else{
				
				$json_out .= $json[$i];
			}
			
			$last_char = $json[$i];
		}
		
		return json_decode($json_out, true);
	}
	
	public function parseJsString($string){
		
		return
			preg_replace_callback(
				'/\\\u[A-Fa-f0-9]{4}|\\\x[A-Fa-f0-9]{2}|\\\n|\\\r/',
				function($match){
					
					switch($match[0][1]){
						
						case "u":
							return json_decode('"' . $match[0] . '"');
							break;
						
						case "x":
							return mb_convert_encoding(
								stripcslashes($match[0]),
								"utf-8",
								"windows-1252"
							);
							break;
						
						default:
							return " ";
							break;
					}
				},
				$string
			);
	}
}
