<?php

function resize_image($extension, $src_file, $dst_file, $_new_w, $_new_h){

   $url_file = $_GET['src'];
   
   $srcfile = $src_file;
   
   $new_w = $_new_w;
   $new_h = $_new_h;
   
   //echo $srcfile."<br>";
   //$pos = strrpos($srcfile, ".");
   //$extension = strtolower(substr($srcfile, $pos + 1));
   
   
  // $src = imagecreatefromjpeg($_FILES['pic']['tmp_name']);
   
   
   
   // Content type
   
   if (strtoupper($extension) == 'JPG' || strtoupper($extension) == 'JPEG' ) {
	   $src = @imagecreatefromjpeg($srcfile);
	   header('Content-type: image/jpeg'); 
   } 
   
   if (strtoupper($extension) == 'PNG') {
	   $src = @imagecreatefrompng($srcfile);
	   header('Content-type: image/png');
	   
   }
   
   if (strtoupper($extension) == 'GIF') {
	   $src = @imagecreatefromgif($srcfile);
	   header('Content-type: image/gif');
	   
   }
   
   // get the source image's widht and hight
   $im = imagecreatetruecolor($new_w, $new_h); 
   $gray = imagecolorallocate($im, 100,100,100);
   $black = imagecolorallocate($im, 0, 0, 0);
   $white = imagecolorallocate($im, 255, 255, 255);
   $dark_blue = imagecolorallocate($im, 0, 90, 130);
   imagefill($im, 0, 0, $black);
   
   // Get new sizes
   list($src_w, $src_h) = getimagesize($srcfile);
   
   //$src_w = imagesx($src);
   //$src_h = imagesy($src);
 
   // echo $src_w." ".$src_h;
 
   // assign thumbnail's widht and hight
   if ($src_w > $new_w) {
	  // if($src_w > $new_w){
	       $thumb_w = $new_w;
	       $thumb_h = intval($new_w / $src_w * $src_h);

	   }
	   
	  else if($src_h > $new_h){
	       $thumb_w = intval($new_h / $src_h * $src_w);;
	       $thumb_h = $new_h;
	   }
	   
   else {
   	   $thumb_w = $src_w;
   	   $thumb_h = $src_h;
   }
   
 
  // echo $thumb_w." ".$thumb_h;
  
   // if you are using GD 1.6.x, please use imagecreate()
  
   $thumb = imagecreatetruecolor($thumb_w, $thumb_h);
    //echo $thumb_w."--".$thumb_h."\n";

   
   // start resize
   // imagecopyresized($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
   $dst_x = ($new_w - $thumb_w)/2;
   $dst_y = ($new_h - $thumb_h)/2;
   
   // start resize
   imagecopyresized($im, $src, $dst_x, $dst_y, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
   //imagecopyresized($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
   
   if (strtoupper($extension) == 'JPG' || strtoupper($extension) == 'JPEG' ) {
	   imagejpeg($im, $dst_file);
   }
   
   if (strtoupper($extension) == 'PNG') {
       imagepng($im, $dst_file);
   }
   
   if (strtoupper($extension) == 'GIF') {
       imagegif($im, $dst_file);
   }
   
   $src_w = imagesx($im);
   $src_h = imagesy($im);
 
   // echo " NEW=".$src_w." ".$src_h;
   // echo " extension=".$extension;
   // save thumbnail
   // imagejpeg($thumb, $dest_path.$filename);
   return $dst_file;

   
}   
?>