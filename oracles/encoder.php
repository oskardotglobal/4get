<?php
include_once("oracles/base.php");
class encoder extends oracle {
	public $info = [
		"name" => "text encoder/hasher"
	];
	private $special_types = [
		"rot13",
		"base64"
	];
	public function check_query($q) {
		$types = array_merge($this->special_types, hash_algos());
		foreach ($types as $type) {
			$type .= " ";
			if (str_starts_with($q, $type)) {
				return true;
			}
		}
		return false;
	}
	public function generate_response($q)
	{
		$type = explode(" ", $q)[0];
		$victim = substr($q, strlen($type)+1);
		if (in_array($type, hash_algos())) {
			return [$type." hash" => hash($type, $victim)];
		}
		switch ($type) {
			case "rot13":
				return ["rot13 encoded" => str_rot13($victim)];
			case "base64":
				return [
					"base64 encoded" => base64_encode($victim),
					"base64 decoded" => base64_decode($victim)
				];
		}
		return "";
	}
}
?>