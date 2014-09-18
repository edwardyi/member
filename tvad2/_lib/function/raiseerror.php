<?php
$b_debugmode = 1; // 0 || 1

$system_operator_mail = 'jeffrey@elai.com.tw';
$system_from_mail = 'webadmin@elai.com.tw';

function db_query( $query ){
  global $b_debugmode;
  
  // Perform Query
  $result = mysql_query($query);

  // Check result
  // This shows the actual query sent to MySQL, and the error. Useful for debugging.
  if (!$result) {
   if($b_debugmode){
   	 
   	// echo mysql_errno() . ": " . mysql_error() . "\n<br>";
   	
     $message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
     $message .= '<b>Whole query:</b><br>' . $query . '<br><br>';
    // die($message);
   }

   raise_error('db_query_error: ' . $message);
  }
  return $result;
}

function raise_error( $message ){
   global $system_operator_mail, $system_from_mail;

   $serror=
   "Env:      " . $_SERVER['SERVER_NAME'] . "\r\n" .
   "timestamp: " . Date('m/d/Y H:i:s') . "\r\n" .
   "script:    " . $_SERVER['PHP_SELF'] . "\r\n" .
   "error:    " . $message ."\r\n\r\n";

   // open a log file and write error
   $fhandle = fopen( '/logs/errors'.date('Ymd').'.txt', 'a' );
   if($fhandle){
     fwrite( $fhandle, $serror );
     fclose(( $fhandle ));
     }
  
   // e-mail error to system operator
   if(!$b_debugmode)
     mail($system_operator_mail, 'error: '.$message, $serror, 'From: ' . $system_from_mail );
}

?>