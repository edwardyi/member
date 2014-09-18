<?php

class AreaController extends Controller {
      
   var $db_conn;
   
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $content_page = "index_content.tpl";
   var $right_menu = "right_menu_branch.tpl";
   var $main_menu_name = "main_menu_branch";
   var $sub_menu_name = "sub_menu_city";
   
   function init() {
     $permission = array(
                    "login_allow"=>all
                    );

     return $permission;

   }
   
   function doPermission($permission){
      $module = "config_area";
      switch($GLOBALS['controllerAction']){
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
       
       $this->gotoURL("index.php?r=home/city");
       
   }

   function vw(){

    $oArea = new Area();
    $oArea->getData($_GET['id']);


    $this->assign("data",$oArea);
    $this->sub_content = "sub_content_area_vw.tpl";

    $this->output();

   }

   function edit(){

    $oArea = new Area();
    $oArea->getData($_GET['id']);

    $this->assign("data",$oArea);
    $this->sub_content = "sub_content_area_edit.tpl";

    $this->output();
    
   }

   function save(){

    $oArea = new Area();
    $oArea->getData($_POST['id']);
    foreach($_POST as $key=>$val){
      $oArea->$key = $val;
    }
      $oArea->vw = $_POST['vw'];

      $oArea->update();
      $this->gotoURL("index.php?r=home/vw&id=".$oArea->city_id);
   }

   function del(){

    $oArea = new Area();
    $oArea->getData($_GET['id']);
    $city_id = $oArea->city_id;
    $oArea->delete();
    $this->gotoURL("index.php?r=home/vw&id=".$city_id);

   }



   
}


?>