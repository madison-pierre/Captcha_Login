<?php
//https://www.geeksforgeeks.org/how-to-generate-captcha-image-in-php/#

session_start();

//generate a random number
$captcha = rand(1000,9999);

//store it 
$_SESSION["captcha"] = $captcha;

//generate an image
$im = imagecreatetruecolor(50, 24);
// blue color
$bg = imagecolorallocate($im, 22, 86, 165);
// White color
$fg = imagecolorallocate($im, 255, 255, 255);
// Give the image a blue background
imagefill($im, 0, 0, $bg);
imagestring($im, rand(1,7),rand(1,7),rand(1,7),$captcha,$fg);

//prevent browser caching
header("Cache-control :  no-store, no-cache, must-revalidate");
header('Content-type: image/png');

//display the image
$imagepng($im);
//destroy the image to save memory
$imagedestroy($im);
?>