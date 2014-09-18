<?php

class AdController extends Controller {
      
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
      $module = "config_ad";
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
      
       $this->sub_content = "sub_content_ad.tpl";
       $this->content_page = "index_content_no_right_menu.tpl";

       $this->output();
       
   }

   function vw(){

    $o = new Ad();
    $o->getData($_GET['id']);

    if($this->permission['config_mac']['branch_flag'] == 1){
      if($this->oLoginUser->branch_id != $o->oMac->branch_id){
        $this->gotoNotPermissiomPage();
      }
    }


    $this->assign("data",$o);
    $this->sub_content = "sub_content_ad_vw.tpl";

    $this->output();

   }

   function edit(){

    $o = new Ad();
    $o->getData($_GET['id']);

    $this->assign("data",$o);
    $this->sub_content = "sub_content_ad_edit.tpl";

    $this->output();
    
   }

   function save(){

    $o = new Ad();
    $o->getData($_POST['id']);
    foreach($_POST as $key=>$val){
      $o->$key = $val;
    }
      $o->vw = $_POST['vw'];

      $o->update();
      $this->gotoURL("index.php?r=ad/vw&id=".$o->id);
   }

   function del(){

    $o = new Ad();
    $o->getData($_GET['id']);
    $mac_id = $o->mac_id;
    $o->delete();
    $this->gotoURL("index.php?r=mac/vw&id=".$mac_id);

   }



   
}


?>