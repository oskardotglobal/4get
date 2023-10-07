<?php
include_once("oracles/base.php");
class calculator extends oracle {
	public $info = [
		"name" => "calculator"
	];
	public function check_query($q) {
		// straight numerics should go to that oracle
		if (is_numeric($q)) {
			return false;
		}
		// all chars should be number-y or operator-y
		$char_whitelist = str_split("1234567890.+-/*^%() ");
		foreach (str_split($q) as $char) {
			if (!in_array($char, $char_whitelist)) {
				return false;
			}
		}
		return true;
	}
	// a custom parser and calculator because FUCK YUO, libraries are
	//  gay.
	public function generate_response($q)
	{
		$nums = str_split("1234567890.");
		$ops = str_split("+-/*^%;");
		$grouping = str_split("()");

		$q = str_replace(" ", "", $q);

		// backstop for the parser so it catches the last
		//  numeric token
		$q .= ";"; 

		// the following comments refer to this example input:
		//  21+9*(3+2^9)+1

		// 2-length lists of the following patterns:
		//  ["n" (umeric), <some number>]
		//  ["o" (perator), "<some operator>"]
		//  ["g" (roup explicit), <"(" or ")">]
		// e.g. [["n", 21], ["o", "+"], ["n", 9], ["o", *],
		//       ["g", "("], ["n", 3], ["o", "+"], ["n", 2],
		//       ["o", "^"], ["n", 9], ["g", ")"], ["o", "+"],
		//       ["n", "1"]]
		$tokens = array();
		$dragline = 0;
		foreach(str_split($q) as $i=>$char) {
			if (in_array($char, $nums)) {
				continue;
			}
			elseif (in_array($char, $ops) || in_array($char, $grouping)) {
				// hitting a non-numeric implies everything since the
				//  last hit has been part of a number
				$capture = substr($q, $dragline, $i - $dragline);
				// prevent the int cast from creating imaginary
				//  ["n", 0] tokens
				if ($capture != "") {
					if (substr_count($capture, ".") > 1) {
						return "";
					}
					array_push($tokens, ["n", (float)$capture]);
				}
				// reset to one past the current (non-numeric) char
				$dragline = $i + 1; 
				// the `;' backstop is not a real token and this should
				//  never be present in the token list
				if ($char != ";") {
					array_push($tokens, [
						($char == "(" || $char == ")") ? "g" : "o",
						$char
					]);
				}
			}
			else {
				return "";
			}
		}

		// two operators back to back should fail
		for ($i = 1; $i < count($tokens); $i++) {
			if ($tokens[$i][0] == "o" && $tokens[$i-1][0] == "o") {
				return "";
			}
		}

		// no implicit multiplication
		for ($i = 0; $i < count($tokens) - 1; $i++) {
			if ($tokens[$i][0] == "n" && $tokens[$i+1] == ["g", "("]) {
				return "";
			}
		}

		//strategy:
		// traverse to group open (if there is one)
		//  - return to start with the internals
		// traverse to ^, attack token previous and after
		// same but for *, then / then + then -
		// poppers all teh way down
		try {
			return [
				substr($q, 0, strlen($q)-1)." = " => $this->executeBlock($tokens)[0][1]
			];
		}   
		catch (\Throwable $e) {
			if (get_class($e) == "DivisionByZeroError") {
				return [
					$q." = " => "Division by Zero Error!!"
				];
			}
			return "";
		}
	}
	public function executeBlock($tokens) {
		if (count($tokens) >= 2 && $tokens[0][0] == "o" && $tokens[0][1] == "-" && $tokens[1][0] == "n") {
			array_splice($tokens, 0, 2, [["n", -1 * (float)$tokens[1][1]]]);
		}
		if (count($tokens) > 0 && $tokens[0][0] == "o" || $tokens[count($tokens)-1][0] == "o") {
			throw new Exception("Error Processing Request", 1);
		}
		while (in_array(["g", "("], $tokens)) {
			$first_open = array_search(["g", "("], $tokens);
			$enclosedality = 1;
			for ($i = $first_open+1; $i < count($tokens); $i++) {
				if ($tokens[$i][0] == "g") {
					$enclosedality += ($tokens[$i][1] == "(") ? 1 : -1;
				}
				if ($enclosedality == 0) {
					array_splice($tokens, 
						$first_open, 
						$i+1 - $first_open, 
						$this->executeBlock(
							array_slice($tokens, $first_open+1, $i-1 - $first_open)
						)
					);
					break;
				}
			}
		}
		$operators_in_pemdas_order = [
			"^" => (fn($x, $y) => $x ** $y),
			"*" => (fn($x, $y) => $x * $y),
			"/" => (fn($x, $y) => $x / $y), 
			"%" => (fn($x, $y) => $x % $y),
			"+" => (fn($x, $y) => $x + $y), 
			"-" => (fn($x, $y) => $x - $y)
		];
		foreach ($operators_in_pemdas_order as $op=>$func) {
			while (in_array(["o", $op], $tokens)) {
				for ($i = 0; $i < count($tokens); $i++) {
					if ($tokens[$i] == ["o", $op]) {
						array_splice(
							$tokens,
							$i-1,
							3,
							[["n", (string)($func((float)$tokens[$i-1][1], (float)$tokens[$i+1][1]))]]
						);
					}
				}
			}
		}
		return $tokens;
	}
}
?>