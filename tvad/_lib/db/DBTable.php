<?php
/**
 * Project:     DataModel Core Table
 * File:        DBTable.php 
 *
 * @link 
 * @copyright 2010 Jeffrey Yeh <YEH, CHIEN-TING>
 * @author Jeffrey Yeh <YEH, CHIEN-TING>
 * @package DB
 * @version 1.0.0
 *  
 */
 
class DBTable {
	 
    var $b_debugmode = 1; // 0 || 1

     var $system_operator_mail = '';
     var $system_from_mail = '';
     
	 
	 var $db_conn;
	 var $_pdo;
	 
	 var $_pkey;
	 var $_id;
	 var $_table;
	 var $_fields;
	 
	 var $_vars;       // Array variables  
	 
	 function __construct() {
	 	
	 	 $this->db_conn = $GLOBALS['conn'];
        
	 	// $this->_pdo = new PDO($dsn, $this->_db_user, $this->_db_pass);
	 	
	 	$this->init();
	 	
	 	// 讀取資料欄位
		$sql = "SELECT * from `".$this->_table."` LIMIT 0,1 ";
		$rows = $this->db_query($sql, $this->db_conn);
		
		$i = 0;
		while ($obj = mysql_fetch_field($rows)) {
		      
		      if ($obj->primary_key == 1) {
		      	$this->_pkey = $obj->name;
		      }
		      $this->_fields[$i] = $obj->name;
		      $this->_vars[$i] = strtolower($obj->name);
		      
		      $i++;
		       
		}
	 	
	 }
	 
	 /*
	 function setData($obj="") {
	 	// extends for user define
	 }
	 
	 function setEmpty($obj="") {
	 	// extends for user define
	 }
	 */

	 
	 function setRowsToVars($rows) {
	 	
	 	if ( $rows ) {
	      $num = mysql_num_rows( $rows );//返回結果集的數目
	      if ($num > 0) {
		       $obj = mysql_fetch_object($rows);//以物件傳回記錄
		       $this->setVars($obj);
                       
		       
		       return 0;
	      } else {
	      	$this->setVarsEmpty();
	      }
   	   } else {
   	 	  $this->setVarsEmpty();
  	   }
	 	
	 	
	 }
	 
	function setVars($obj) {
	 	
	 	$this->setVarsEmpty();
	 	
	 	for ($i = 0; $i < count($this->_fields); $i++) {
             	
                 $var = $this->_vars[$i];
                 $obj_name = $this->_fields[$i];
		 		 $this->$var = $obj->$obj_name;// 就是$this->_vars[$i];=$this->_fields[$i]; 塞值
		 		 
             }
             
	 	 $this->setData($obj);   // User define
	 	 
                 
                 $pk = $this->_pkey;
                 $this->_id = $obj->$pk;
	 	
	 }
	 
	 function setVarsEmpty() {
	 	
	 	
	 	 
	 	 for ($i = 0; $i < count($this->_fields); $i++) {//計算陣列數目
                 $var = $this->_vars[$i];
		 		 $this->$var = "";//把陣列清空
             }
             
	 	 $this->setEmpty();
	 	 
                 
         $this->_id = "";
	 	 
	 }
	 
	 
	 function db_fetch_object($rows) {
	 	
	 	return mysql_fetch_object($rows);//以物件傳回記錄
	 	
	 }
	 
	 function db_num_rows($rows) {
	 	
	 	return mysql_num_rows($rows);//返回結果集的數目
	 	
	 }
	 
	 function getData($pk_id)  {//取的以物件形式的資料
	 	
	 	$sql = "SELECT * FROM `".strtolower($this->_table)."` WHERE ".$this->_pkey."='".$pk_id."'";//查詢式的條件
	 	
	 	$rows = $this->db_query( $sql );//執行SQL

               $this->setRowsToVars($rows);//關鍵 物件傳回資料且是動態對好了
           
	 }
	 
	 function hasRecord($pk_id) {
	 	
	 	$sql = "SELECT * FROM `".strtolower($this->_table)."` WHERE ".$this->_pkey."='".$pk_id."'";
	 	
	 	$rows = $this->db_query($sql);
	 	if ( $rows ) {
		      $num = $this->db_num_rows($rows);
		      if ($num > 0) {
			       return true;
		      } else {
		      	   return false;
		      }    	
	   	 } else {
	   	 	return false;
	  	 }
	 	
	 }
	   
		 function insertData($j="",$debug="") {
	 	
	 	 if( $j =="") $j=0;
	 	 
	 	$sql = "INSERT INTO `".$this->_table."` ( ";
                     for ($i = $j; $i < count($this->_fields); $i++) {   //動態資料表欄位
		 	   $sql .= "`".$this->_fields[$i]."`";
                           if ($i < (count($this->_fields) - 1)) $sql .= ",";
                     }
                     $sql .= ") VALUES (";
                     
                     for ($i = $j; $i < count($this->_fields); $i++) {   //動態資料表新增的值
                           $var = $this->_vars[$i]; 
		 	   $sql .= "'".str_replace("'", "''",$this->$var)."'";
                           if ($i < (count($this->_vars) - 1)) $sql .= ",";
                     }
                     $sql .= ")";

	        if ($debug == 1) echo $sql;
	        // echo $sql."<br/>";
	        $this->db_query( $sql );
	        $this->id = mysql_insert_id();
	        $this->_id = $this->id;

	 }
	 
	 function updateData($j="",$debug="") {
	 	
	 	 if( $j =="") $j=0;
	 	 $sql = "UPDATE `".$this->_table."` SET ";
                    for ($i = $j; $i < count($this->_fields); $i++) { //動態資料表欄位=新增的值
                           $var = $this->_vars[$i]; 
		 	   $sql .= "`".$this->_fields[$i]."`='".$this->$var."'";
                           if ($i < (count($this->_fields) - 1)) $sql .= ",";
                    }
                    $sql .= " WHERE `".$this->_pkey."`='".$this->_id."'";//設選擇新增修改的欄位
                    
                   // echo $sql."<br/>";
	        if ($debug == 1) echo $sql;
	        
	        $this->db_query( $sql );
	        
	 }  
	 
	 /*
	 function getList(){
	 	// extends for user define
        
	 }
	 */
	 
	 function getListArray($p, $limit=""){
	 	
	 	$rows = $this->getList($p, $limit);
   	 	
   	    $row_array = $this->getRowsArray($rows);
        
        return $row_array;
	 }
	 
	 function getRowsArray($rows){
	 	
   	    $i = 0;
   	    $row_array = array();
 	  	while ($obj = mysql_fetch_object($rows)) {//以物件傳回記錄
 	  		$this->getData($obj->id);
 	  		$row_array[$i] = get_object_vars($this); 
 	  		$i++;
 	  	}
        
        return $row_array;
	 }
	 
	 function getListObject($p, $limit=""){
	 	
	 	$rows = $this->getList($p, $limit);
   	 	
   	    $row_array = $this->getRowsObject($rows);
        
        return $row_array;
	 }
	 
	 function getRowsObject($rows){
	 	
   	    $i = 0;
   	    $row_array = array();
 	  	while ($obj = mysql_fetch_object($rows)) {
 	  		$this->getData($obj->id);
 	  		$b = clone $this;
 	  		$row_array[$i] = $b; 
 	  		$i++;
 	  	}
        
        return $row_array;
	 }
	 
	 function getRowsCount($rows) {
	 	return mysql_num_rows($rows);//返回結果集的數目
	 }
	 
	 function insDeleteLog($table_name, $row_id, $pkey, $pk_value, $raw) {
	 	
	 	 $sql = "INSERT INTO DEL_LOG (TABLE_NAME, ROW_ID, PKEY, PK_VALUE, RAW_DATA, DEL_TIME) VALUES (" .
	 	 		"'".$table_name."','".$row_id."','".$pkey."','".$pk_value."','".addslashes($raw)."','".time()."')";
	     	 		
	 	 $this->db_query($sql); 		  
	 	
	 }
		 
		 
	//------------------------------------------------------	 
	function db_query( $query ){
	  
	  global $b_debugmode;
	  
	 // echo $this->db_conn;
	  // Perform Query
	  //$result = mysql_query($query, $this->db_conn);
	  $result = mysql_query($query, $this->db_conn);
	  
	  // echo $query."<br>";
	
	  // Check result
	  // This shows the actual query sent to MySQL, and the error. Useful for debugging.
	  if (!$result) {
	   //if($this->b_debugmode){
	   	 
	   	 //echo mysql_errno() . ": " . mysql_error() . "\n<br>";
	   	
	     $message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
	     $message .= '<b>Whole query:</b><br>' . $query . '<br><br>';
	    // die($message);
	   //}
	
	   $this->raise_error('db_query_error: ' . $message);
	  }
	  return $result;
	}
	
	function raise_error( $message ){
	   
	   $serror=
	   "Env:      " . $_SERVER['SERVER_NAME'] . "\r\n" .
	   "timestamp: " . Date('m/d/Y H:i:s') . "\r\n" .
	   "script:    " . $_SERVER['PHP_SELF'] . "\r\n" .
	   "error:    " . $message ."\r\n\r\n";
	
	   // open a log file and write error
	   /*
	   $fhandle = fopen( './logs/errors'.date('Ymd').'.txt', 'a' );
	   if($fhandle){
	     fwrite( $fhandle, $serror );
	     fclose(( $fhandle ));
	     }
	   */
	   // e-mail error to system operator
	   if(!$this->b_debugmode)
	     mail($this->system_operator_mail, 'error: '.$message, $serror, 'From: ' . $this->system_from_mail );
	}
	//-------------------------------------------------
	function getIP(){
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
		
}	

?>