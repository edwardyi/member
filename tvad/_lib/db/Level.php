<?php
/**
 * Project:     isetam.elaiis.com
 * File:        User.php 
 *
 * @link 
 * @copyright 2010 Jeffrey Yeh <YEH, CHIEN-TING>
 * @author Jeffrey Yeh <YEH, CHIEN-TING>
 * @package DB
 * @version 1.0.0
 *  
 */

class Level extends DBTable {
   
   
   function init() {
       
       // empty constructor
       $this->_table = "level";
             
   }

   function setData($obj) {
   		//
   }
   
   function setEmpty() {
	    //
	    	    
   }
   
   function getDataByPK($level,$menu_id) {
   
     $sql = "SELECT * FROM `$this->_table` WHERE LEVEL='".$level."' AND MENU_ID = '".$menu_id."' ";
     $rows = $this->db_query( $sql );
     
     $this->setRowsToVars($rows);
     
     return 1;
     
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
	    
    
    function delete($id="") {
            if($id == "")$id = $this->id;
        
           $sql = "DELETE FROM `$this->_table` WHERE ID='".$id."'";

           return $this->db_query( $sql );

    }
  
   function getList($p, $limit="") {
 	  	
        $sql = "SELECT * FROM `$this->_table` WHERE 1=1 ";
   	
        if($p['level'] != ""){
            $sql .= " AND LEVEL = '".$p['level']."' ";
        }
        
   	 	
   	 	
        $sql .= " ORDER BY ID ASC ";	

   	 	
        if ($limit != "") $sql .= $limit;
   	 	
   	 	//echo $sql;
   	 	
        return $this->db_query( $sql );
   
   }
   
}


?>