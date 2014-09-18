<?php


class Permission extends DBTable {
   

   function init() {
       
       // empty constructor
       $this->_table = "permission";
             
   }

   function setData($obj) {
   		//
   	$this->oSubmenu = new Submenu();
   	$this->oSubmenu->getData($this->sub_menu_id);

   }
   
   function setEmpty() {
   		
	    //
	    $this->oSubmenu = "";	    
   }
   
  
   
	 function insert($debug="") {
	 	 
	 	 // if ($this->hasRecord($this->id)) {
	   // 	    $this->update($debug);
	   // 	 } else {
	   	 	
	   	 	$this->insertData(1);
	        
	        $this->id = mysql_insert_id($this->db_conn);
	           	 	
	   	 // }
	   	 
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
 	  	
 	  	$name = empty($p['name']) ? "":$p['name'];
   	 	$sql = "SELECT * FROM `$this->_table` WHERE 1=1 ";
   	 	
   	 	// if ($p['id'] != "") $sql .= " AND id='".addslashes($p['id'])."'";
   	 	if ($name != "") $sql .= " AND name LIKE '%".addslashes($name)."%'";
   	 	if ($p['level_id'] != "") $sql .= " AND level_id = '".addslashes($p['level_id'])."'";
   	 	

   	 	
   	 	// if ($p['sorting'] == "desc") {
   	 	// 	$sql .= " ORDER BY seq DESC ";
   	 	// } else {
   	 	//     $sql .= " ORDER BY seq ASC ";	
   	 	// }
   	 	
   	 	if ($limit != "") $sql .= $limit;
   	 	// echo $sql ."<br>";
   	 	
        return $this->db_query( $sql );
   
   }

   function clearLevel($level_id){

   		$sql = "DELETE FROM `$this->_table` WHERE level_id='".$level_id."'";
	 	
	 	return $this->db_query( $sql );

   }

   function getPermission($level_id,$sub_menu_id){
   		$sql = "SELECT * FROM `$this->_table` WHERE level_id='".$level_id."' AND sub_menu_id = '".$sub_menu_id."'";
	     $rows = $this->db_query( $sql );
	     // echo $sql."<br>";
	     $this->setRowsToVars($rows);
   }

  

   
}


?>