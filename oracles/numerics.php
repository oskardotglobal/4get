<?php
include_once("oracles/base.php");
class numerics extends oracle {
	public $info = [
		"name" => "numeric base conversion"
	];
	public function check_query($q) {
		if (str_contains($q, " ")) {
			return false;
		}

		$q = strtolower($q);

		$profiles = [
			["0x", str_split("0123456789abcdef")],
			["", str_split("1234567890")],
			["b", str_split("10")]
		];

		foreach ($profiles as $profile) {
			$good = true;
			$good &= str_starts_with($q, $profile[0]);
			$nq = substr($q, strlen($profile[0]));
			foreach (str_split($nq) as $c) {
				$good &= in_array($c, $profile[1]);
			}
			if ($good) {
				return true;
			}
		}
		return false;
	}
	public function generate_response($q) {
		$n = 0;
		if (str_starts_with($q, "0x")) {
			$nq = substr($q, strlen("0x"));
			$n = hexdec($nq);
		}
		elseif (str_starts_with($q, "b")) {
			$nq = substr($q, strlen("b"));
			$n = bindec($nq);
		}
		else {
			$n = (int)$q;
		}
		return [
			"decimal (base 10)" => (string)$n,
			"hexadecimal (base 16)" => "0x".(string)dechex($n),
			"binary (base 2)" => "b".(string)decbin($n),
			"" => "binary inputs should be prefixed with 'b', hex with '0x'."
		];
	}
}
?>