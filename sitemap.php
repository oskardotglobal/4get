<?php

header("Content-Type: application/xml");
include "data/config.php";

$domain =
	htmlspecialchars(
		(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "https" : "http") .
		'://' . $_SERVER["HTTP_HOST"]
	);

echo
	'<?xml version="1.0" encoding="UTF-8"?>' .
	'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' .
		'<url>' .
			'<loc>' . $domain . '/</loc>' .
			'<lastmod>2023-07-31T07:56:12+03:00</lastmod>' .
		'</url>' .
		'<url>' .
			'<loc>' . $domain . '/about</loc>' .
			'<lastmod>2023-07-31T07:56:12+03:00</lastmod>' .
		'</url>' .
		'<url>' .
			'<loc>' . $domain . '/instances</loc>' .
			'<lastmod>2023-07-31T07:56:12+03:00</lastmod>' .
		'</url>' .
		'<url>' .
			'<loc>' . $domain . '/settings</loc>' .
			'<lastmod>2023-07-31T07:56:12+03:00</lastmod>' .
		'</url>' .
		'<url>' .
			'<loc>' . $domain . '/api.txt</loc>' .
			'<lastmod>2023-07-31T07:56:12+03:00</lastmod>' .
		'</url>' .
	'</urlset>';
