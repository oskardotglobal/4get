<?php
abstract class oracle {
	// some info to spit out alongside the result, so the user knows
	//  what exactly is giving out the answer. prevents confusion
	//   about what oracle is answering them for ambiguous queries.
	public $info = [
		"name" => "some oracle"
	];
	// this function should take in a query string search from $_GET,
	//  and return a bool determining whether or not it is a question
	//   intended for the oracle.
	public function check_query($q) {
		return false;
	}
	// produce the correct answer for the query using the oracle.
	//  note: if it becomes apparent /during generation/ that the
	//   query is not in fact for the oracle, returning an empty
	//    string will kill the oracle pane.
	// answer format: ["ans1 title" => "ans1", ...]
	public function generate_response($q) {
		return "";
	}
}
// backwards compatibility
if (!function_exists('str_starts_with')) {
	function str_starts_with($haystack, $needle) {
		return strncmp($haystack, $needle, strlen($needle)) === 0;;
	}
}
if (!function_exists('str_contains')) {
	function str_contains($haystack, $needle) {
		return strpos((string)$haystack, (string)$needle) !== false;
	}
}

?>