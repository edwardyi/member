<?php


class Lottery extends DBTable {
   
      
   function init() {
       
       // empty constructor
       $this->_table = "lottery";
             
   }

   function setData($obj) {
   		//

   }
   
   function setEmpty() {
   		
	    //
	    	    
   }
   
  
   
	 function insert($debug="") {
	 	 
	 	 if ($this->hasRecord($this->id)) {
	   	    $this->update($debug);
	   	 } else {
	   	 	
	   	 	$this->create_time = date("Y-m-d H:i:s");
	   	 	$this->insertData(1);
	        
	        $this->id = mysql_insert_id($this->db_conn);
	           	 	
	   	 }
	   	 
	 }
	 
	 function update($debug="") {
	 	if ($this->hasRecord($this->id)) {
	   	 	
	   	 	$this->updateData(1);

	        
	        // echo $sql;
	        
	   	 } else {
	   	    $this->insert($debug);
	   	 }
	 }
	    
    
	 function delete() {
	 	
	 	$sql = "DELETE FROM `$this->_table` WHERE ID='".$this->id."'";
	 	
	 	return $this->db_query( $sql );
	 	
	 }

   function isRecordByAward() {
   
     $sql = "SELECT * FROM `$this->_table` WHERE type='".$this->type."' AND open_date='".$this->open_date."' AND open_code='".$this->open_code."'";
     $rows = $this->db_query( $sql );
     
     $num = $this->db_num_rows($rows);
 
     if($num == 0){
     	return 0;
     }else{ 
     	return 1;
     }
   }
  
   function getList($p, $limit="") {
 	  	
   	 	$sql = "SELECT * FROM `$this->_table` WHERE 1=1 ";
   	 	
   	 	// if ($p['id'] != "") $sql .= " AND id='".addslashes($p['id'])."'";
   	 	if ($p['type'] != "") $sql .= " AND type = '".addslashes($p['type'])."' ";
   	 	if ($p['open_date'] != "") $sql .= " AND open_date = '".addslashes($p['open_date'])."' ";
   	 	if ($p['open_code'] != "") $sql .= " AND open_code = '".addslashes($p['open_code'])."' ";
   	 	

   	 	
   	 	// if ($p['sorting'] == "desc") {
   	 	// 	$sql .= " ORDER BY seq DESC ";
   	 	// } else {
   	 	//     $sql .= " ORDER BY seq ASC ";	
   	 	// }
   	 	
      $sql .= " ORDER BY create_time DESC "; 
   	 	if ($limit != "") $sql .= $limit;
   	 	
   	 	
        return $this->db_query( $sql );
   
   }

   function getNewAward($type){

   		$sql = "SELECT * FROM `lottery` WHERE type = '".$type."' ORDER BY create_time DESC LIMIT 0,1 ";
 		  $rows = $this->db_query( $sql );
     	$this->setRowsToVars($rows);
     	// echo $sql;
   }

  

   
}


?>