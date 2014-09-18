<?php
/*
 * Created on 2007/4/26 by Jeffrey Yeh
 * Project :
 * Module  :
 * Function:
 * Update  :
 */
 
 require_once(APP_ROOT_PATH.'_pkg/Smarty/Smarty.class.php');
 
 class Template extends Smarty {
 	
    var $db_conn;
   
    var $lang;
    var $system;
    var $UserLevel;
    var $UserID;
    var $from_ip;
   
    var $page = array('pagesize'=>0, 'start_item'=>0, 'page'=>1, 'totalrows'=>0, 'totalpage'=>0, 'prev_pos'=>0,'next_pos'=>0);
 	
    var $pager_tpl = "/pager.tpl";
   
 	function __construct($db_conn) {
 		
 		
 		$this->template_dir = HTML_ROOT_PATH."templates/";
 		$this->compile_dir = HTML_ROOT_PATH."cache/";
 		
 		$this->db_conn = $db_conn;
 	
 		$this->page['pagesize'] = 0;
	 	$this->page['start_item'] = 0;
	 	$this->page['page'] = 1;
	 	$this->page['totalrows'] = 0;
	 	$this->page['totalpage'] = 0;
	 	$this->page['prev_pos'] = 0;
	 	$this->page['next_pos'] = 0;
 		
 	}
 	
 	function limit($totals, $pagesize, $pos) {
   	
	   	//---- Pager ---------------------
	 	 $totalpage = 0;
	 	 $page = 1;
	 	 $limit = "";
	 	 
	     //$pagesize = 12;
	     //總筆數
	     //$total = mysql_num_rows($rows);
		 //總頁数
		 $totalpage = ceil($totals/$pagesize);
		 //目前頁數
		 // $pos = $_GET["pos"];
		 if ($pos == "" || $pos == "0") $pos = 1;  
		 
		 $page = $pos;
		 
		 $_SESSION['page'] = $page;
		 //語句
		 $limit = " LIMIT ".($pagesize * ($page-1)).", ".$pagesize;
		 //$limit = $pagesize * $page;
		 
		 /*
		 if ($limit > $totals) {
		 	
		 	$p['page_size'] = ($pagesize - ($limit - $total));
		 	
		 	$limit = $total;
		 	
		 } else {	
		    $p['page_size'] = $pagesize;
		    
		 }
		 */
	
		 $start_pos = $pos - ($pos % 10);
		 
		 $pages = array();
		 for ($i = 0; $i < 10; $i++) {
		 	
		 	if ( ($i + $start_pos ) < $totalpage) {
		 	  $pages[$i] = $i + $start_pos + 1; 
		 	}
		 }
		 		 
		 
		 $this->page['pos'] = $pos;
		 
		 $this->page['pages'] = $pages;
		 
		 $this->page['pager_page'] = $this->pager_tpl;
   		 $this->page['pagesize'] = $pagesize;
   		 $this->page['start_item'] = $page * $pagesize;
   		 $this->page['page'] = $page;
   		 $this->page['totalrows'] = $totals;
   		 $this->page['totalpage'] = $totalpage;
   		 
         $this->page['prev_pos'] = ($page > 1 ? $page-1:1);
         $this->page['next_pos'] = ($page < $totalpage? $page+1: $totalpage);
         
		 
		 return $limit;
   }
   
   function pager($lists, $query_str) { 
		 

		 $this->assign('pager_page', $this->template.$this->pager_tpl);
	     $this->assign('pagesize', $this->page['pagesize']);
		
		 $this->assign('list',$lists);
		 $this->assign('start_item', $this->page['start_item']);
		
		 $this->assign('page',$this->page['page']);
		 $this->assign('totalrows',$this->page['total']);
		 $this->assign('totalpage',$this->page['totalpage']);
		 $this->assign('prev_pos', $this->page['prev_pos']);
		 $this->assign('next_pos', $this->page['next_pos']);
		 $this->assign('pages', $this->page['pages']);
		 
		 $this->assign('query_str', $query_str);
		 $this->assign('pager_str', $query_str);
		 
   }
 	
 }		
 
?>