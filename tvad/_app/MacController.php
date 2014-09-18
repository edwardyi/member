<?php

class MacController extends Controller {
      
   var $db_conn;
   
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $content_page = "index_content.tpl";
   var $right_menu = "right_menu_ad.tpl";
   var $main_menu_name = "main_menu_ad";
   var $sub_menu_name = "sub_menu_ad";
   
   
   function init() {
     $permission = array(
                    "login_allow"=>all
                    );

     return $permission;
    
   }

    function doPermission($permission){
      $module = "config_mac";
      switch($GLOBALS['controllerAction']){
        case "index":
        case "vw":
         if($permission[$module]['vw'] == 0)
            $this->gotoNotPermissiomPage();
          break;
        case "edit":
        case "save":
          if($permission[$module]['upd'] == 0)
            $this->gotoNotPermissiomPage();
          break;
        case "del":
          if($permission[$module]['del'] == 0)
            $this->gotoNotPermissiomPage();
          break;
      }

   }
   

  function index(){

      $p = array();

      if($_GET['clear'] != 1){
        if($_GET['q'] == 1){
          unset($_SESSION['p_branch']);
          $p = $_GET;
          $_SESSION['p_branch'] = $p; 
        }else{
          $p = $_SESSION['p_branch'];
        }
      }else{
        unset($_SESSION['p_branch']);
      }

      if($this->permission['config_mac']['branch_flag'] == 1){
        $p['city_id'] = $this->oLoginUser->city_id;
        $p['area_id'] = $this->oLoginUser->area_id;
        $p['place_id'] = $this->oLoginUser->place_id;
        $p['branch_id'] = $this->oLoginUser->branch_id;
      }

       $pos = empty($_GET['pos']) ? 1 : $_GET['pos'];
       if($_GET['back'] ==1) $pos = $_SESSION['page'];
       $o = new Mac();
       
       $p['sorting'] = $_GET['sorting'];
       $rows = $o->getList($p);
       $total = $o->db_num_rows($rows);
       $limit_str = $this->limit($total, $this->pagesize, $pos);
       $lists = $o->getListObject($p, $limit_str);

      $this->getSelectLists(array("city","area","place","branch","adtype"));


       $query_str = "index.php?r=mac/index&pos=";

       $this->sub_content = "sub_content_mac.tpl";
       $this->assign("p",$p);
       $this->assign("lists",$lists);

       
       $this->pager($lists, $query_str);
       $this->output();
       
   }

   function vw(){
      $p = array();

      if( $_SESSION['p_ad']['id'] != $_GET['id']){
        unset($_SESSION['p_ad']);
      }

      if($_GET['clear'] != 1){
        if($_GET['q'] == 1){
          unset($_SESSION['p_ad']);
          $p = $_GET;
          $_SESSION['p_ad'] = $p; 
        }else{
          $p = $_SESSION['p_ad'];
        }
      }else{
        unset($_SESSION['p_ad']);
      }

    $o = new Mac();
    $o->getData($_GET['id']);

    if($this->permission['config_mac']['branch_flag'] == 1){
      if($this->oLoginUser->branch_id != $o->branch_id){
        $this->gotoNotPermissiomPage();
      }
    }

    $oAd = new Ad();
    if($p['vw'] == 0) $p['vw'] == '0';
    $p['mac_id'] = $o->id;
    $p['sorting'] = $_GET['sorting'];
    $lists = $oAd->getListObject($p);

    foreach($lists as $key=>$val){
      if(file_exists (APP_ROOT_PATH.$val->ad)){
        $lists[$key]->file_status = "Y";
      }else{
        $lists[$key]->file_status = "N";
      }
    }

    $this->assign("p",$p);
    $this->assign("data",$o);
    $this->assign("lists",$lists);
    $this->sub_content = "sub_content_mac_vw.tpl";

    $this->output();

   }

   function edit(){

    $o = new Mac();
    $o->getData($_GET['id']);

    if($this->permission['config_mac']['branch_flag'] == 1){
      if($this->oLoginUser->branch_id != $o->branch_id && $o->branch_id != ""){
        $this->gotoNotPermissiomPage();
      }
    }

    $this->getSelectLists(array("city","area","place","branch","adtype"));

    $this->assign("data",$o);


    $this->sub_content = "sub_content_mac_edit.tpl";

    $this->output();
    
   }

   function save(){

    $o = new Mac();
    $o->getData($_POST['id']);

    foreach($_POST as $key=>$val){
      $o->$key = $val;
    }

    if($this->permission['config_mac']['branch_flag'] == 1){
      $o->city_id = $this->oLoginUser->city_id;
      $o->area_id = $this->oLoginUser->area_id;
      $o->place_id = $this->oLoginUser->place_id;
      $o->branch_id = $this->oLoginUser->branch_id;
    }
      $o->vw = $_POST['vw'];

   

      $o->update();
      $this->gotoURL("index.php?r=mac/vw&id=".$o->id);
   }

   function del(){

    $o = new Mac();
    $o->getData($_GET['id']);

    if($this->permission['config_mac']['branch_flag'] == 1){
      if($this->oLoginUser->branch_id != $o->branch_id){
        $this->gotoNotPermissiomPage();
      }
    }

    $p['mac_id'] = $o->id;
    $oAd = new Ad();
    $rows = $oAd->getList($p);
    $total = $oAd->db_num_rows($rows);

    if($total == 0){
      $o->delete();
      $this->gotoURL("index.php?r=mac/index&pos=".$_GET['pos']."&id=".$oCity->id);
    }else{

      $this->gotoURL("index.php?r=mac/vw&pos=".$_GET['pos']."&id=".$o->id."&del_err=1");
    }

   }



   
}


?>