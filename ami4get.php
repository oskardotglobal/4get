<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "data/config.php";

$real_requests = apcu_fetch("real_requests");
$bot_requests = apcu_fetch("captcha_gen");

echo json_encode(
	[
		"status" => "ok",
		"service" => "4get",
		"server" => [
			"name" => config::SERVER_NAME,
			"description" => config::SERVER_LONG_DESCRIPTION,
			"bot_protection" => config::BOT_PROTECTION,
			"real_requests" => $real_requests === false ? 0 : $real_requests,
			"bot_requests" => $bot_requests === false ? 0 : $bot_requests,
			"api_enabled" => config::API_ENABLED,
			"alt_addresses" => config::ALT_ADDRESSES,
			"version" => config::VERSION
		],
		"instances" => config::INSTANCES
	]
);
