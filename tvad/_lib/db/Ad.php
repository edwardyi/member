<?php


class Ad extends DBTable {
   
      
   function init() {
       
       // empty constructor
       $this->_table = "ad";
             
   }

   function setData($obj) {
   		//
   		$this->oMac = new Mac();
   		$this->oMac->getData($this->mac_id);
   }
   
   function setEmpty() {
   		
	    //
	    $this->oMac = "";	    
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
   	 	
   	 	if ($p['mac_id'] != "") $sql .= " AND mac_id = '".$p['mac_id']."' ";
   	 	if ($p['name'] != "") $sql .= " AND name LIKE '%".addslashes($p['name'])."%'";
   	 	if ($p['ad'] != "") $sql .= " AND ad LIKE '%".addslashes($p['ad'])."%'";
   	 	if ($p['vw'] != "") $sql .= " AND vw = '".$p['vw']."' ";
   	 	if($p['s_date'] != "") $sql .= " AND s_date >= '".$p['s_date']."' ";
   	 	if($p['e_date'] != "") $sql .= " AND s_date <= '".$p['e_date']."' ";
   	 	
   	 	if ($p['sorting'] == "desc") {
   	 		$sql .= " ORDER BY seq DESC ";
   	 	} else {
   	 	    $sql .= " ORDER BY seq ASC ";	
   	 	}
   	 	
   	 	if ($limit != "") $sql .= $limit;

   	 	
        return $this->db_query( $sql );
   
   }

   function getListForToday($p){

   			$sdate = date("Y-m-d")." 00:00";
   			$edate = date("Y-m-d")." 23:59";
   			$sql = "SELECT a.id,b.branch_id FROM ad  a LEFT JOIN mac b on a.mac_id = b.id WHERE a.vw = 1";


   			$sql .= " AND (a.s_date <=  '".$sdate."' AND a.e_date >=  '".$edate."' ";
   			$sql .= " OR a.s_date >=  '".$sdate."' AND a.s_date <=  '".$edate."' ";
   			$sql .= " OR a.e_date >=  '".$sdate."' AND a.e_date <=  '".$edate."') ";

   			if ($p['city_id'] != "") $sql .= " AND b.city_id = '".$p['city_id']."' ";
   			if ($p['area_id'] != "") $sql .= " AND b.area_id = '".$p['area_id']."' ";
   			if ($p['place_id'] != "") $sql .= " AND b.place_id = '".$p['place_id']."' ";
   			if ($p['branch_id'] != "") $sql .= " AND b.branch_id = '".$p['branch_id']."' ";
			   if ($p['mac'] != "") $sql .= " AND b.mac = '".$p['mac']."' ";
   	 		if ($p['name'] != "") $sql .= " AND b.name LIKE '%".addslashes($p['name'])."%'";

   	 		$sql .= " ORDER BY b.branch_id ASC,b.city_id ASC,b.area_id ASC,b.place_id ASC";

   	 		$rows = $this->db_query( $sql );

   	 		$i = 0;
	   	    $row_array = array();
	 	  	while ($obj = mysql_fetch_object($rows)) {
	 	  		$this->getData($obj->id);
	 	  		$b = clone $this;
	 	  		$row_array[$i] = $b; 
	 	  		$i++;
	 	  	}
	 	  	// echo $sql;
	 	  	return $row_array;

   }

  

   
}


?>