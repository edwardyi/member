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

class User extends DBTable {
   
   var $id;
   
   var $user_id;
   var $user_name;
   var $user_password;
   var $title;
   var $level;     //LEVEL:A, M, U
   var $email;
   var $active;
      
   function init() {
       
       // empty constructor
       $this->_table = "user";
             
   }

   function setData($obj) {
   		//
      $this->oBranch = new Branch();
      $this->oBranch->getData($this->branch_id);

      $this->oLevel= new Level();
      $this->oLevel->getData($this->level_id);

   }
   
   function setEmpty() {
   		
	    //
	    	$this->oBranch = "";    
        $this->oLevel = "";
   }
   


   function getDataByUserID($_id) {
   
     $sql = "SELECT * FROM `$this->_table` WHERE username='".$_id."'";
     $rows = $this->db_query( $sql );
     
     $this->setRowsToVars($rows);
     // echo $sql;
     return 1;
     
   }
   
	 function insert($debug="") {
	 	 
	 	 if ($this->hasRecord($this->id)) {
	   	    $this->update($debug);
	   	 } else {
	   	 	   
          $this->vw = 1;
          $this->pwd = md5($this->pwd);
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
   	 	
   	 	// if ($p['id'] != "") $sql .= " AND ID='".addslashes($p['id'])."'";
   	 	
      if ($p['name'] != "") $sql .= " AND name like '%".$p['name']."%' ";
      if ($p['username'] != "") $sql .= " AND username like '%".$p['username']."%' ";
      if ($p['vw'] != "") $sql .= " AND vw = '".$p['vw']."' ";
      if ($p['city_id'] != "") $sql .= " AND city_id = '".$p['city_id']."' ";
      if ($p['area_id'] != "") $sql .= " AND area_id = '".$p['area_id']."' ";
      if ($p['place_id'] != "") $sql .= " AND place_id = '".$p['place_id']."' ";
   	 	if ($p['branch_id'] != "") $sql .= " AND branch_id = '".$p['branch_id']."' ";
   	 	if ($p['checked'] == "Y") $sql .= " AND checked='1' ";
   	 	if ($p['checked'] == "N") $sql .= " AND checked<>'1' ";
   	 	
   	 	
   	 	
   	 	if ($p['sorting'] == "desc") {
   	 		
   	 		$sql .= " ORDER BY id DESC ";
   	 	} else {
   	 	    $sql .= " ORDER BY id ASC";	
   	 	}
   	 	
   	 	if ($limit != "") $sql .= $limit;
   	 	
   	 	//echo $sql;
   	 	
        return $this->db_query( $sql );
   
   }

   function login($_user_id, $_password) {
   	
   	 $today = date('Y-m-d');
   	
     $sql = "SELECT * FROM `$this->_table` WHERE username = '".$_user_id."' AND checked = 1 ";
     $rows = $this->db_query( $sql );

     //echo $sql;
  	 if ( $rows ) {
	      $num = mysql_num_rows( $rows );
	      if ($num > 0) {
	         $obj = mysql_fetch_object($rows);
	         
	         //if ($obj->USER_PASSWORD == sha1(md5($_password)) ) {
	         if ($obj->pwd== md5($_password) ) {
	         	  $_SESSION['USERID'] = $obj->username;
	            return 0;
	         } else {
	         	  session_destroy();
	       	    return 2; // password no correct
	         }	     	
	      } else {
           session_destroy();
	      	 return 1; // no user;
	      }  	
      }
	     
     session_destroy(); 
	   return 1;   //  no user;
	
   }

   function logout($_user_id="") {
   	
   		if ($_user_id == "") {
 	  	   $_user_id = $this->id;	
 	  	}
 	  	
 	  // 	$now = date('Y-m-d h:i:s');
 	  	
    //  	// Update online flag;
    // 	$sql = "UPDATE `$this->_table` SET LASTLOGOUT='$now' WHERE USER_ID='$_user_id'";
		  // $this->db_query( $sql );
      session_destroy();
	
   }
   
   function chgpassword($_id="") {
   	 
   	 if ($_id == "") { $_id = $this->id; }

   	 if ($this->hasRecord($_id)) {
   	 	//$sql = "UPDATE `USER` SET USER_PASSWORD = SHA1(MD5('".$this->user_password."')) WHERE ID = '".$_id."'";
        $sql = "UPDATE `$this->_table` SET pwd = '".md5($this->pwd)."' WHERE id = '".$_id."'";
        $this->db_query( $sql );
        
        return true;
        
   	 } else {
   	 	return false;
   	 }
   	 	
   
   }

   
}


?>