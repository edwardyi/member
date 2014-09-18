<?php


class Submenu extends DBTable {
   
      
   function init() {
       
       // empty constructor
       $this->_table = "sub_menu";
             
   }

   function setData($obj) {
   		//
   	$this->oMainmenu = new Mainmenu();
   	$this->oMainmenu->getData($this->main_menu_id);

   }
   
   function setEmpty() {
   		
	    //
   	$this->oMainmenu = "";
	    	    
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
 	  	
   	 	$sql = "SELECT a.id FROM `$this->_table` a LEFT JOIN `main_menu` b on a.main_menu_id = b.id WHERE 1=1 ";
   	 	
   	 	// if ($p['id'] != "") $sql .= " AND id='".addslashes($p['id'])."'";
   	 	if ($p['name'] != "") $sql .= " AND name LIKE '%".addslashes($p['name'])."%'";
   	 	

   	 	$sql .= " ORDER BY b.seq ASC , a.seq ASC ";
   	 	
   	 	if ($limit != "") $sql .= $limit;
   	 	
   	 	
        return $this->db_query( $sql );
   
   }

  

   
}


?>