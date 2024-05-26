<?php

include "data/config.php";
include "lib/curlproxy.php";
$proxy = new proxy();

if(!isset($_GET["i"])){
	
	header("X-Error: No URL(i) provided!");
	$proxy->do404();
	die();
}

try{
	
	// original size request, stream file to browser
	if(
		!isset($_GET["s"]) ||
		$_GET["s"] == "original"
	){
		
		$proxy->stream_linear_image($_GET["i"]);
		die();
	}
	
	// bing request, ask bing to resize and stream to browser
	$image = parse_url($_GET["i"]);
	
	if(
		isset($image["host"]) &&
		preg_match(
			'/^[A-z0-9.]*bing\.(net|com)$/i',
			$image["host"]
		)
	){
		
		if(
			!isset($image["query"]) ||
			!isset($image["path"]) ||
			$image["path"] != "/th"
		){
			
			header("X-Error: Invalid bing image path");
			$proxy->do404();
			die();
		}
		
		parse_str($image["query"], $str);
		
		if(!isset($str["id"])){
			
			header("X-Error: Missing bing ID");
			$proxy->do404();
			die();
		}
			
		switch($_GET["s"]){
			
			case "portrait": $req = "&w=50&h=90&p=0&qlt=90"; break;
			case "landscape": $req = "&w=160&h=90&p=0&qlt=90"; break;
			case "square": $req = "&w=90&h=90&p=0&qlt=90"; break;
			case "thumb": $req = "&w=236&h=180&p=0&qlt=90"; break;
			case "cover": $req = "&w=207&h=270&p=0&qlt=90"; break;
		}
		
		$proxy->stream_linear_image("https://" . $image["host"] . "/th?id=" . urlencode($str["id"]) . $req, "https://www.bing.com");
		die();
	}
	
	// resize image ourselves
	$payload = $proxy->get($_GET["i"], $proxy::req_image, true);
	
	// get image format & set imagick
	$image = null;
	$format = $proxy->getimageformat($payload, $image);
	
	try{
		
		if($format !== false){
			$image->setFormat($format);
		}
		
		$image->readImageBlob($payload["body"]);
		
		$image_width = $image->getImageWidth();
		$image_height = $image->getImageHeight();
		
		switch($_GET["s"]){
			
			case "portrait":
				$width = 50;
				$height = 90;
				break;
			
			case "landscape":
				$width = 160;
				$height = 90;
				break;
			
			case "square":
				$width = 90;
				$height = 90;
				break;
			
			case "thumb":
				$width = 236;
				$height = 180;
				break;
			
			case "cover":
				$width = 207;
				$height = 270;
				break;
		}
		
		$ratio = $image_width / $image_height;
		
		if($image_width > $width){
			
			$image_width = $width;
			$image_height = round($image_width / $ratio);
		}
		if($image_height > $height){
			
			$ratio = $image_width / $image_height;
			$image_height = $height;
			$image_width = $image_height * $ratio;
		}
		
		$image->setImageBackgroundColor("#504945");
		$image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
		
		$image->stripImage();
		$image->setFormat("jpeg");
		$image->setImageCompressionQuality(90);
		$image->setImageCompression(Imagick::COMPRESSION_JPEG2000);
		
		$image->resizeImage($image_width, $image_height, Imagick::FILTER_LANCZOS, 1);
		
		$proxy->getfilenameheader($payload["headers"], $_GET["i"]);
		
		header("Content-Type: image/jpeg");
		echo $image->getImageBlob();
		
	}catch(ImagickException $error){
		
		header("X-Error: Could not convert the image: (" . $error->getMessage() . ")");
		$proxy->do404();
	}
	
}catch(Exception $error){
	
	header("X-Error: " . $error->getMessage());
	$proxy->do404();
	die();
}
