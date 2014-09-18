<?php

class Controller extends Template {

    
   var $template = "default/";
   
   var $db_conn;
   
   var $_prefix_url = "/";
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $from_ip;
   var $pos;
   var $header_tpl = "header.tpl";
   var $footer_tpl = "footer.tpl";
   var $main_menu_tpl = "main_menu.tpl";
   var $display_tpl = "index_frame.tpl";
   var $index_left_content = "index_left_content.tpl";
   var $index_content = "index_content.tpl";
   var $pager_tpl = "pager.tpl";
   var $main_css = "css/layout/offcanvas.css";
   var $pagesize = 10;
   //var $display_tpl = "/admin/index_frame.tpl";
      
   function __construct() {

       $this->template_dir = HTML_ROOT_PATH."templates/";
       $this->compile_dir = HTML_ROOT_PATH."cache/";
       $permission = $this->init();
       $this->ctrl_permission($permission);
   }

   function ctrl_permission($permission){

      $login_allow = $permission['login_allow'];
      if($login_allow == null)  $login_allow =  array();
      if(in_array($GLOBALS['controllerAction'], $login_allow) || $login_allow == "all"){
        if(!isset($_SESSION['USERID']) || empty($_SESSION['USERID'])){
          $this->gotoURL("index.php?r=index/index");
        }else{
          $oUser = new User();
          $oPermission = new Permission();
          $oUser->getDataByUserID($_SESSION['USERID']);

          $p['level_id'] = $oUser->level_id;
          if(empty($oUser->level_id)){
            $oSubmenu = new Submenu();
            $rows = $oSubmenu->getListObject(array());
            foreach($rows as $key=>$val){
              $permission[$val->code]['ins'] = 0;
              $permission[$val->code]['upd'] = 0;
              $permission[$val->code]['del'] = 0;
              $permission[$val->code]['sel'] = 0;
              $permission[$val->code]['vw'] = 0;
              $permission[$val->code]['branch_flag'] = 1;
            }
          }else{ 
            $rows = $oPermission->getListObject($p);
            foreach($rows as $key=>$val){
              $permission[$val->oSubmenu->code]['ins'] = $val->ins;
              $permission[$val->oSubmenu->code]['upd'] = $val->upd;
              $permission[$val->oSubmenu->code]['del'] = $val->del;
              $permission[$val->oSubmenu->code]['sel'] = $val->sel;
              $permission[$val->oSubmenu->code]['vw'] = $val->vw;
              $permission[$val->oSubmenu->code]['branch_flag'] = $val->branch_flag;
              // print_r($permission);
            }
          }
          $this->oLoginUser = $oUser;
          $this->permission = $permission;
          $this->doPermission($permission);
          $this->assign("oLoginUser",$oUser);
          $this->assign("permission",$permission);
        }
      }

      

   }

   function gotoNotPermissiomPage(){
    $this->gotoURL("not_permission.html");
   }

   //前端SELECT option value
   function getSelectLists($need){

      $p = array();

      if(in_array("city", $need)){
        $oCity = new City();
        if($this->permission['config_city']['vw'] == 0 || !isset($this->permission['config_city']['vw']))
          $p['vw'] = 1;
        $cityLists = $oCity->getListObject($p);
        $this->assign("cityLists",$cityLists);
      }
      if(in_array("area", $need)){
        $oArea = new Area();
        if($this->permission['config_area']['vw'] == 0 || !isset($this->permission['config_area']['vw']))
          $p['vw'] = 1;
        $areaLists = $oArea->getListObject($p);
        $this->assign("areaLists",$areaLists);
      }
      if(in_array("place", $need)){
        $oPlace = new Place();
        if($this->permission['config_place']['vw'] == 0 || !isset($this->permission['config_place']['vw']))
          $p['vw'] = 1;
        $placeLists = $oPlace->getListObject($p);
        $this->assign("placeLists",$placeLists);
      }
      if(in_array("branch", $need)){
        $oBranch = new Branch();
        if($this->permission['config_branch']['vw'] == 0 || !isset($this->permission['config_branch']['vw']))
          $p['vw'] = 1;
        $branchLists = $oBranch->getListObject($p);
        $this->assign("branchLists",$branchLists);
      }
      if(in_array("adtype", $need)){
        $oAdtype = new Adtype();
        if($this->permission['config_adtype']['vw'] == 0 || !isset($this->permission['config_adtype']['vw']))
          $p['vw'] = 1;
        $adtypeLists = $oAdtype->getListObject($p);
        $this->assign("adtypeLists",$adtypeLists);
      }
       
   }
   
   function set_meta(){
       
       $d = new Params($this->db_conn);
       $web_meta['web_title'] = $d->getValue('WEB_TITLE');
       $this->assign("web_meta",$web_meta);

   }
   
   function setHeader($db_conn="") {
   	
       if ($db_conn != "") $this->db_conn = $db_conn;
       
   	   $this->template_dir = HTML_ROOT_PATH."templates/";
 	   $this->compile_dir = HTML_ROOT_PATH."cache/";
 		
 	   $this->assign('prefix_url', $this->_prefix_url."");	 
           $this->assign('header', $this->template."/header.tpl");
	   $this->assign('footer', $this->template."/footer.tpl"); 
	   $this->assign('main_menu', $this->template."/main_menu.tpl"); 
	   //$this->assign('welcome_page', $this->template."/welcome.tpl");	 
	 
	   // $this->assign('tab_panel', ",{ defaultPanel: 2 }");
   	
   }

   function limit($totals, $pagesize, $pos) {
   	
	   	//---- Pager ---------------------
	 	 //$totalpage = 0;
	 	 //$page = 1;
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
            $limit.= " LIMIT ".($pagesize * ($page-1)).", ".$pagesize;
            //$limit = $pagesize * $page;

            $start = (ceil($page/10)-1)*10+1;
            $end  = $start+10;
            if($totalpage+1 < $end)
                $end = $totalpage+1;
            
            for($i=$start;$i<$end;$i++){
                $pages[] = $i;
            }
           

            $this->assign('pager_page', $this->template.$this->pager_tpl);
	          $this->assign('pagesize', $pagesize);
		
            $this->assign('start_item', $page * $pagesize);

            $this->assign('page', $page);
            $this->assign('pos', $pos);
            $this->assign('pages', $pages);
            $this->assign('totalrows', $totals);
            $this->assign('totalpage', $totalpage);
            $this->assign('prev_pos', $page - 1);
            $this->assign('next_pos', $page + 1);
		
		 
		 return $limit;
   }	
   
   
   function pager($lists, $query_str) { 
		
		 $this->assign('list',$lists);
		 
		 $this->assign('query_str', $query_str);
		 $this->assign('pager_str', $query_str);
		 
   }
   
   
 function file_upload(&$obj, $field_id, $file_name, $old_file_name, $vars, $uploaddir) {


		if ($vars[$file_name.'_del'] == "Y") {
			$deletefile = $uploaddir.$old_file_name;
	       	if (file_exists($deletefile)) {
	       	  	unlink($deletefile);
	       	  	$obj->$field_id = "";
	       	  	$obj->fsize = "";
	       	  	$old_file_name="";
	       	}
		}
		
	    if ($vars[$file_name]['name'] != "") {

		    if (!is_dir($uploaddir)) {
		    	mkdir($uploaddir, 0777);
		    }

		    $pos = strrpos($vars[$file_name]['name'], ".");
		    $extension = strtolower(substr($vars[$file_name]['name'], $pos + 1));
		 	
		    $dst_file = $field_id."_".$obj->id.".".$extension;
		    $dst_file_path = $uploaddir.$dst_file;
	        
	        $photoname = $dst_file;

	        if ($old_file_name != "") {
	       	  $deletefile = $uploaddir.$old_file_name;
	       	  if (file_exists($deletefile)) {
	       	  	unlink($deletefile);
	       	  	$obj->$field_id = "";
	       	  }
	        }
	       
	        $photouploadfile = $uploaddir.$dst_file;
             
	        if (copy($vars[$file_name]['tmp_name'], $photouploadfile) ) {
	        	   $obj->$field_id = $photoname;
	        	   $obj->fsize = $vars[$file_name]['size'];
	        } else {
	        	  echo $photouploadfile."<br>";
	        	  echo "Possible Photo file upload attack!\n";
	        }
	}  
	    
   }
   
 
   function output() {
   	   
   	  
   	   

   	  // mysql_close($this->db_conn); 
   	    
    //    $this->assign('lang', $this->lang);
	   // $this->assign('system', $this->system);
           
          // echo $this->main_menu_name;
           
	   
       $this->assign('main_menu_name', $this->main_menu_name);                         
   	   $this->assign('sub_menu_name', $this->sub_menu_name);                         
	     $this->assign('user_level', $this->UserLevel); 
	     $this->assign('userid', $this->UserID); 
   	   $this->assign('main_css', $this->main_css); 
   	   $this->assign('header', $this->template.$this->header_tpl); 
   	   $this->assign('footer', $this->template.$this->footer_tpl); 
   	   $this->assign('main_menu', $this->template.$this->main_menu_tpl);
   	    
   	   $this->assign('index_left_content', $this->template.$this->index_left_content); 
       if(isset($this->sub_content))
        $this->assign('sub_content', $this->template.$this->sub_content); 
       if(isset($this->right_menu))
        $this->assign('right_menu', $this->template.$this->right_menu); 
   	   $this->assign('content', $this->template.$this->content_page); 

   	   

   	   $this->display($this->template.$this->display_tpl);
   }
   
   
   function gotoURL($url) {

      header("Location: ". $url);
      exit;
   }
   

   
}


?>