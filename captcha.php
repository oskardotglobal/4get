<?php

if(
	isset($_GET["v"]) === false ||
	is_array($_GET["v"]) === true ||
	preg_match(
		'/^c[0-9]+\.[A-Za-z0-9_]{20}$/',
		$_GET["v"]
	) === 0
){
	
	http_response_code(401);
	header("Content-Type: text/plain");
	echo "Fuck my feathered cloaca";
	die();
}

//header("Content-Type: image/jpeg");
include "data/config.php";

if(config::BOT_PROTECTION !== 1){
	
	header("Content-Type: text/plain");
	echo "The IQ test is disabled";
	die();
}

$grid = apcu_fetch($_GET["v"]);

if($grid !== false){
	
	// captcha already generated
	http_response_code(304); // not modified
	die();
}

header("Content-Type: image/jpeg");
header("Last-Modified: Thu, 01 Oct 1970 00:00:00 GMT");

// ** generate captcha data
// get the positions for the answers
// will return between 3 and 6 answer positions
$range = range(0, 15);
$answer_pos = [];

array_splice($range, 0, 1);

$picks = random_int(3, 6);

for($i=0; $i<$picks; $i++){
	
	$answer_pos_tmp =
		array_splice(
			$range,
			random_int(
				0,
				14 - $i
			),
			1
		);
	
	$answer_pos[] = $answer_pos_tmp[0];
}

// choose a dataset
$c = count(config::CAPTCHA_DATASET);
$choosen = config::CAPTCHA_DATASET[random_int(0, $c - 1)];
$choices = [];

for($i=0; $i<$c; $i++){
	
	if(config::CAPTCHA_DATASET[$i][0] == $choosen[0]){
		
		continue;
	}
	
	$choices[] = config::CAPTCHA_DATASET[$i];
}

// generate grid data
$grid = [];

for($i=0; $i<16; $i++){
	
	if(in_array($i, $answer_pos)){
		
		$grid[] = $choosen;
	}else{
		
		$grid[] = $choices[random_int(0, count($choices) - 1)];
	}
}

// store grid data for form validation on captcha_gen.php
apcu_store(
	$_GET["v"],
	$answer_pos,
	60 // we give user 1 minute to solve
);

// generate image
if(random_int(0,1) === 0){
	
	$theme = [
		"bg" => "#ebdbb2",
		"fg" => "#1d2021"
	];
}else{
	
	$theme = [
		"bg" => "#1d2021",
		"fg" => "#ebdbb2"
	];
}

$im = new Imagick();
$im->newImage(400, 427, $theme["bg"]);
$im->setImageBackgroundColor($theme["bg"]);
$im->setImageFormat("jpg");

$noise = [
	imagick::NOISE_GAUSSIAN,
	imagick::NOISE_LAPLACIAN
];

$distort = [
	imagick::DISTORTION_AFFINE,
	imagick::DISTORTION_SHEPARDS
];

$i = 0;
for($y=0; $y<4; $y++){
	
	for($x=0; $x<4; $x++){
		
		$tmp = new Imagick("./data/captcha/" . $grid[$i][0] . "/" . random_int(1, $grid[$i][1]) . ".png");
		
		// convert transparency correctly
		$tmp->setImageBackgroundColor("black");
		$tmp->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
		
		// randomly mirror
		if(random_int(0,1) === 1){
			
			$tmp->flopImage();
		}
		
		// distort $tmp
		$tmp->distortImage(
			$distort[random_int(0,1)],
			[
				0, 0,
				random_int(-15, 15), random_int(-15, 15),
				
				100, 0,
				random_int(80, 120), random_int(-15, 15),
				
				100, 100,
				random_int(80, 120), random_int(80, 120),
				
				0, 100,
				random_int(-15, 15), random_int(80, 120)
			],
			false
		);
		
		$tmp->addNoiseImage($noise[random_int(0, 1)]);
		
		// append image
		$im->compositeImage($tmp->getImage(), Imagick::COMPOSITE_DEFAULT, $x * 100, ($y * 100) + 27);
		
		$i++;
	}
}

// add text
$draw = new ImagickDraw();
$draw->setFontSize(20);
$draw->setFillColor($theme["fg"]);
//$draw->setTextAntialias(false);
$draw->setFont("./data/fonts/captcha.ttf");

$text = "Pick " . $picks . " images of " . str_replace("_", " ", $choosen[0]);

$pos = 200 - ($im->queryFontMetrics($draw, $text)["textWidth"] / 2);

for($i=0; $i<strlen($text); $i++){
	
	$im->annotateImage(
		$draw,
		$pos,
		20,
		random_int(-15, 15),
		$text[$i]
	);
	
	$pos += $im->queryFontMetrics($draw, $text[$i])["textWidth"];
		
}

$im->setFormat("jpeg");
$im->setImageCompressionQuality(90);
echo $im->getImageBlob();
