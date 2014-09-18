<?php
/*
 * Created on 2007/6/25 by Jeffrey Yeh
 * Project :
 * Module  :
 * Function:
 * Update  :
 */
function duration_days($enddate, $startdate) {
         
     $difference = strtotime($enddate) - strtotime($startdate); 
	 $duration = floor($difference/60/60/24);
	 
	 // 計算週六,日天數
	 $j=0;
	 for ($i=strtotime($startdate); $i<=strtotime($enddate); $i=$i+86400) {
	 	$weekend = date("w", $i);
	 	
	 	if ($weekend == 0 || $weekend == 6 ) {
	 		$j = $j + 1;
	 	}	
	 
	 }
     
     $duration = $duration - $j;
     
     return $duration;     

} 
?>
