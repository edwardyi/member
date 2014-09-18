<?php


class Branch extends DBTable {
   
      
   function init() {
       
       // empty constructor
       $this->_table = "branch";
             
   }

   function setData($obj) {
   		//
   		$this->oCity = new City();
   		$this->oCity->getData($this->city_id);
   		$this->oArea = new Area();
   		$this->oArea->getData($this->area_id);
   		$this->oPlace = new Place();
   		$this->oPlace->getData($this->place_id);

   }
   
   function setEmpty() {
   		
	    //
   		$this->oCity = "";
	    	    
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
   	 	if ($p['city_id'] != "") $sql .= " AND city_id='".addslashes($p['city_id'])."'";
   	 	if ($p['area_id'] != "") $sql .= " AND area_id='".addslashes($p['area_id'])."'";
   	 	if ($p['place_id'] != "") $sql .= " AND place_id='".addslashes($p['place_id'])."'";
   	 	if ($p['name'] != "") $sql .= " AND name LIKE '%".addslashes($p['name'])."%'";
         if ($p['vw'] != "") $sql .= " AND vw='".addslashes($p['vw'])."'";
   	 	

   	 	
   	 	if ($p['sorting'] == "desc") {
   	 		$sql .= " ORDER BY seq DESC ";
   	 	} else {
   	 	    $sql .= " ORDER BY id ASC ";	
   	 	}
   	 	
   	 	if ($limit != "") $sql .= $limit;
   	 	
   	 	
        return $this->db_query( $sql );
   
   }

  

   
}


?>