<?php


class Requestad extends DBTable {
   
      
   function init() {
       
       // empty constructor
       $this->_table = "request_ad";
             
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
            $this->create_time = date("Y-m-d");
            $this->create_ip = $this->getIP();
	   	 	$this->create_device = $_SERVER['HTTP_USER_AGENT'];

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
  
   function getList($p, $limit="") {
 	  	
   	 	$sql = "SELECT * FROM `$this->_table` WHERE 1=1 ";
   	 	
   	 	// if ($p['id'] != "") $sql .= " AND id='".addslashes($p['id'])."'";
   	 	
   	 	if ($p['mac_id'] != "") $sql .= " AND mac_id = '".$p['mac_id']."' ";

   	 	
   	 	if ($p['sorting'] == "desc") {
   	 		$sql .= " ORDER BY id DESC ";
   	 	} else {
   	 	    $sql .= " ORDER BY id ASC ";	
   	 	}
   	 	
   	 	if ($limit != "") $sql .= $limit;

   	 	
        return $this->db_query( $sql );
   
   }



}


?>