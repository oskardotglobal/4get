<?php
include_once("oracles/base.php");
class time extends oracle {
	public $info = [
		"name" => "what time is it?"
	];
	public function check_query($q) {
		$prompts = [
			"what", "time", "is", "it",
			"right", "now", "the", "current",
			"get", "date"
		];
		$q = str_replace(",", "", $q);
		$q = str_replace("?", "", $q);
		$q = str_replace("what's", "what is", $q);
		$oq = $q;
		$q = explode(" ", $q);
		$count = 0;
		foreach ($q as $word) {
			if (in_array($word, $prompts)) {
				$count++;
			}
		}
		// remove one from total count if a timezone is specified
		return ($count/(count($q) + (str_contains($oq, "tz:") ? -1 : 0))) > 3/4;
	}
	public function generate_response($q) {
		$timezone = timezone_name_from_abbr("UTC");
		foreach (explode(" ", $q) as $word) {
			if (str_starts_with($word, "tz:")) {
				$decltz = timezone_name_from_abbr(substr($word, 3, 3));
				if ($decltz) {
					$timezone = $decltz;
				}
			}
		}
		date_default_timezone_set($timezone);
		return [
			"The time in ".$timezone => date("H:i:s"),
			" " => date("l, F jS"),
			"" => "include the string \"tz:XXX\" to use timezone XXX"
		];
	}
}
?>