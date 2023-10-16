<?php

if(
	!isset($_GET["k"]) ||
	preg_match(
		'/^c\.[0-9]+$/',
		$_GET["k"]
	)
){
	
	header("Content-Type: text/plain");
	echo "Fuck you";
	die();
}

header("Content-Type: image/jpeg");

$grid = apcu_fetch($_GET["k"]);

if(
	$grid === false ||
	$grid[3] === true // has already been generated
){
	
	http_response_code(304); // not modified
	die();
}

header("Last-Modified: Thu, 01 Oct 1970 00:00:00 GMT");

// only generate one captcha with this config
apcu_store(
	$_GET["k"],
	[
		$grid[0],
		$grid[1],
		$grid[2],
		true // has captcha been generated?
	],
	120 // we give user another 2 minutes to solve
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
$im->newImage(400, 400, $theme["bg"]);
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
		
		$tmp = new Imagick("./data/captcha/" . $grid[0][$i][0] . "/" . random_int(1, $grid[0][$i][1]) . ".png");
		
		// convert transparency correctly
		$tmp->setImageBackgroundColor("black");
		$tmp->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);

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
		
		// append image
		$im->compositeImage($tmp->getImage(), Imagick::COMPOSITE_DEFAULT, $x * 100, $y * 100);
		
		$i++;
	}
}

// add noise
$im->addNoiseImage($noise[random_int(0, 1)]);

// expand top of image
$im->setImageGravity(Imagick::GRAVITY_SOUTH);
$im->chopImage(0, -27, 400, 400);
$im->extentImage(0, 0, 0, -27);

// add text
$draw = new ImagickDraw();
$draw->setFontSize(20);
$draw->setFillColor($theme["fg"]);
//$draw->setTextAntialias(false);
$draw->setFont("./data/captcha/font.ttf");

$text = "Pick " . $grid[1] . " images of " . str_replace("_", " ", $grid[2]);

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
$im->setImageCompression(Imagick::COMPRESSION_JPEG2000);
echo $im->getImageBlob();
