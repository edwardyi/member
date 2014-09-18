<?php
/*
 * Created on 2007/5/27 by Jeffrey Yeh
 * Project :
 * Module  :
 * Function:
 * Update  :
 */
function upload_file($files, $upload_dir) { 
	
	include_once(APP_ROOT_PATH."class/Upload_Files.php");
	
	$upload_class = new Upload_Files; 
	//$upload_class->temp_file_name = trim($_FILES['upload']['tmp_name']); 
	//$upload_class->file_name = trim(strtolower($_FILES['upload']['name'])); 
	$upload_class->temp_file_name = trim($files['tmp_name']); 
	$upload_class->file_name = trim(strtolower($files['name'])); 
	//$upload_class->upload_dir = "uploads/"; 
	//$upload_class->upload_log_dir = "uploads/upload_logs/"; 
	$upload_class->upload_dir = $upload_dir."/"; 
	$upload_class->upload_log_dir = $upload_dir."/logs/"; 
	$upload_class->max_file_size = 5242880; 
	$upload_class->banned_array = array(""); 
	$upload_class->ext_array = array(".zip",".rar",".pdf",".jpg",".gif",".png"); 
	
	$valid_ext = $upload_class->validate_extension(); 
	$valid_size = $upload_class->validate_size(); 
	$valid_user = $upload_class->validate_user(); 
	$max_size = $upload_class->get_max_size(); 
	$file_size = $upload_class->get_file_size(); 
	$file_exists = $upload_class->existing_file(); 

    if (!$valid_ext) { 
        $result = "The file extension is invalid, please try again!"; 
    } 
    elseif (!$valid_size) { 
        $result = "The file size is invalid, please try again! The maximum file size is: $max_size and your file was: $file_size"; 
    } 
    elseif (!$valid_user) { 
        $result = "You have been banned from uploading to this server."; 
    } 
    elseif ($file_exists) { 
        $result = "This file already exists on the server, please try again."; 
    } else { 
        $upload_file = $upload_class->upload_file_with_validation(); 
        if (!$upload_file) { 
            $result = "Your file could not be uploaded!"; 
        } else { 
            // $result = "Your file has been successfully uploaded to the server.";
            $result = ""; 
        } 
    }
    
    return array("result" => $result, "upload" => $upload_class);
     
} 
?>
