<?php

function resize_image_width($extension, $src_file, $dst_file, $_new_w){

   $url_file = $_GET['src'];
   
   $srcfile = $src_file;
   
   $new_w = $_new_w;
   
   // echo $srcfile."<br>";
   
  // $src = imagecreatefromjpeg($_FILES['pic']['tmp_name']);
   $src = imagecreatefromjpeg($srcfile);
   // get the source image's widht and hight
   
   
   // Content type
   
   if (strtoupper($extension) == 'JPG' || strtoupper($extension) == 'JPEG' ) {
	   $src = @imagecreatefromjpeg($srcfile);
	   header('Content-type: image/jpeg');
   } 
   
   if (strtoupper($extension) == 'PNG') {
	   $src = @imagecreatefrompng($srcfile);
	   header('Content-type: image/png');
   }

   // Get new sizes
   list($src_w, $src_h) = getimagesize($srcfile);
   
   //$src_w = imagesx($src);
   //$src_h = imagesy($src);
 
  // echo $src_w." ".$src_h;
 
   // assign thumbnail's widht and hight
   if ($src_w > $new_w) {
	       
	       $thumb_w = $new_w;
	       $thumb_h = intval($new_w / $src_w * $src_h);
	   
   } else {
   	   $thumb_w = $src_w;
   	   $thumb_h = $src_h;
   }
  
   
 
   // if you are using GD 1.6.x, please use imagecreate()
   $thumb = imagecreatetruecolor($thumb_w, $thumb_h);
  
   // start resize
	  //imagecopyresized($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
	  imagecopyresampled($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
  

   if (strtoupper($extension) == 'JPG' || strtoupper($extension) == 'JPEG' ) {
	   imagejpeg($thumb, $dst_file,100);
   }

   
   if (strtoupper($extension) == 'PNG') {
       imagepng($thumb, $dst_file,100);
   }
   
   
   //echo " ".$dst_file;
   
   // save thumbnail
   // imagejpeg($thumb, $dest_path.$filename);
   return $dst_file;
   
}   
?>