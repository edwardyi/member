<?php
/*
 * Created on 2005/10/19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 session_start();
 
 //生成验证码图片 
header("Content-type: image/PNG"); 
srand((double)microtime()*1000000); 
$im = imagecreatetruecolor(200,40); 

// $backgr_col = imagecolorallocate($image, 238,239,239);
// $border_col = imagecolorallocate($image, 208,208,208);
// $text_col = imagecolorallocate($image, 46,60,31);

$backgr_col = imagecolorallocate($im, 238,239,239);
$border_col = imagecolorallocate($im, 208,208,208);
$text_col = imagecolorallocate($im, 46,60,31);

// $black = imagecolorallocate($im, 0,0,0);
// $white = imagecolorallocate($im, 255,255,255); 
$gray = imagecolorallocate($im, 100,100,100);

$black = $backgr_col;
$white = $border_col; 
// $gray = $text_col;

imagefilledrectangle($im, 0, 0, 210, 40, $backgr_col);
imagerectangle($im, 0, 0, 209, 39, $border_col);
 
imagefill($im,210,40,$gray); 

$authnum=rand(1000, 9999); 

$_SESSION['vcode'] = $authnum;

//将四位整数验证码绘入图片 
$font = imageloadfont('./Trebuchet_MS.gdf');
imagestring($im, $font, 50, 5, $authnum, $gray); 


for($i=0;$i<2000;$i++) //加入干扰象素 
{ 
	$randcolor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
    imagesetpixel($im, rand()%200 , rand()%200 , $randcolor); 

} 




ImagePNG($im); 
ImageDestroy($im); 

?>