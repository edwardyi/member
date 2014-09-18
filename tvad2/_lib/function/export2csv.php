<?php

function export2csv($params) {
	
	$export = $params['rows'];
	$filename = $params['filename'];
	
	include_once("../config/db_conn.php");
	
	$fields = mysql_num_fields($export);
	
	for ($i = 0; $i < $fields; $i++) { 
       $header .= mysql_field_name($export, $i) . ","; 
    }
    
    
    while($row = mysql_fetch_object($export)) { 
	    $line = ''; 
	    foreach($row as $value) {                                             
	        if ((!isset($value)) OR ($value == "")) { 
	            $value = ","; 
	        } else { 
	            $value = str_replace('"', '""', $value); 
	            $value = '"' . $value . '"' . ","; 
	        } 
	        $line .= $value; 
	    } 
	    $data .= trim($line)."\n"; 
   } 
   //$data = str_replace("r","",$data); 
 
   if ($data == "") { 
    $data = "n(0) Records Found!n";                         
   }
	
    header("Content-type: application/x-msdownload"); 
	header("Content-Disposition: attachment; filename=".$filename.".csv"); 
	header("Pragma: no-cache"); 
	header("Expires: 0");
	 
	print " $header\n$data";  
    	 	 
}

 
?>
