<?php
session_start();
// Generate random code
$randomCode = md5(rand());
// Get a specific length from that generated code
$captchaCode = substr($randomCode, rand(null,null), 7);
// Start a session with that captchaCode
$_SESSION["captcha"] = $captchaCode;
// Set the size of the generated image
$captchaBox = imagecreatetruecolor(105,30);
// Set color of the random lines
$lineColor = imagecolorallocate($captchaBox, rand(0,220),rand(0,220),rand(0,220));
// Generate the random lines
for($i=0; $i < rand(2,9); $i++) {
    imagesetthickness($captchaBox , rand(1,5));
    imageline($captchaBox, 0, rand(0,40), 120, rand(0,35), $lineColor);
}
// Set the background color of the generated image
$captchaBackgroundColor = imagecolorallocate($captchaBox, rand(0,220),rand(0,220),rand(0,220));
// Fill the image
imagefill($captchaBox,0,0,$captchaBackgroundColor);
// Set the color of the text in the image
$codeTextColor = imagecolorallocate($captchaBox, rand(145,255), rand(145,255), rand(145,255));
// Position the text inside the image and generate the final image
imagestring($captchaBox, 25, 20, 7, $captchaCode, $codeTextColor);
imagejpeg($captchaBox);
imagedestroy($captchaBox);