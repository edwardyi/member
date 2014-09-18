<?php


class Mac extends DBTable {
   
      
   function init() {
       
       // empty constructor
       $this->_table = "mac";
             
   }

   function setData($obj) {
   		//
   	  $this->oBranch = new Branch();
      $this->oBranch->getData($this->branch_id);

      $this->oAdtype = new Adtype();
      $this->oAdtype->getData($this->adtype_id);

   }
   
   function setEmpty() {
   		
	    //
	    $this->oBranch = "";
	    $this->oAdtype = "";	    
   }
   
  
   function getDataByMAC($_id) {
   
     $sql = "SELECT * FROM `$this->_table` WHERE mac='".$_id."'";
     $rows = $this->db_query( $sql );
     
     $this->setRowsToVars($rows);
     
     if(empty($this->id)){
         return 0;
     }else{ 
         return 1;
     }
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
   	 	
   	 	// if ($p['id'] != "") $sql .= " AND id='".addslashes($p['id'])."'";
   	 	
   	 	if ($p['branch_id'] != "") $sql .= " AND branch_id = '".$p['branch_id']."' ";
   	 	if ($p['place_id'] != "") $sql .= " AND place_id = '".$p['place_id']."' ";
   	 	if ($p['area_id'] != "") $sql .= " AND area_id = '".$p['area_id']."' ";
   	 	if ($p['city_id'] != "") $sql .= " AND city_id = '".$p['city_id']."' ";
   	 	if ($p['adtype_id'] != "") $sql .= " AND adtype_id = '".$p['adtype_id']."' ";
   	 	if ($p['name'] != "") $sql .= " AND name LIKE '%".addslashes($p['name'])."%'";
   	 	if ($p['mac'] != "") $sql .= " AND mac='".addslashes($p['mac'])."'";

   	 	
   	 	
   	 	if ($p['sorting'] == "desc") {
   	 		$sql .= " ORDER BY seq DESC ";
   	 	} else {
   	 	    $sql .= " ORDER BY seq ASC ";	
   	 	}
   	 	
   	 	if ($limit != "") $sql .= $limit;
   	 	
   	 	
        return $this->db_query( $sql );
   
   }

  

   
}


?>