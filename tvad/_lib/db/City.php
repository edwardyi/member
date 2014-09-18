<?php


class City extends DBTable {
   
      
   function init() {
       
       // empty constructor
       $this->_table = "city";
             
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
   	 	
   	 	if ($p['id'] != "") $sql .= " AND id='".addslashes($p['id'])."'";
   	 	
   	 	if ($p['name'] != "") $sql .= " AND name like '%".$p['name']."%' ";

   	 	if ($p['city_id'] != "") $sql .= " AND id='".addslashes($p['city_id'])."'";

   	 	if ($p['vw'] != "") $sql .= " AND vw='".addslashes($p['vw'])."'";

   	 	
   	 	
   	 	if ($p['sorting'] != "") {
   	 		$sql .= " ORDER BY ".strtolower($p['sorting'])." ";
   	 	} else {
   	 	    $sql .= " ORDER BY seq ASC ";	
   	 	}
   	 	
   	 	if ($limit != "") $sql .= $limit;
   	 	
   	 	
        return $this->db_query( $sql );
   
   }

  

   
}


?>