<?php

class AdtypeController extends Controller {
      
   var $db_conn;
   
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $content_page = "index_content.tpl";
   var $right_menu = "right_menu_ad.tpl";
   var $main_menu_name = "main_menu_ad";
   var $sub_menu_name = "sub_menu_adtype";
   
   
   function init() {
     $permission = array(
                    "login_allow"=>all
                    );

     return $permission;

   }

   function doPermission($permission){
      $module = "config_adtype";
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
          unset($_SESSION['p_city']);
          $p = $_GET;
          $_SESSION['p_city'] = $p; 
        }else{
          $p = $_SESSION['p_city'];
        }
      }else{
        unset($_SESSION['p_city']);
      }

       $pos = empty($_GET['pos']) ? 1 : $_GET['pos'];
       if($_GET['back'] ==1) $pos = $_SESSION['page'];

       $o = new Adtype();
       $lists = $o->getListArray(array());
       $p['sorting'] = $_GET['sorting'];
       $rows = $o->getList($p);
       $total = $o->db_num_rows($rows);
       $limit_str = $this->limit($total, $this->pagesize, $pos);
       $lists = $o->getListObject($p, $limit_str);


       $query_str = "index.php?r=adtype/index&pos=";
       $this->sub_content = "sub_content_adtype.tpl";

       $this->assign("p",$p);
       $this->assign("lists",$lists);
       $this->pager($lists, $query_str);

       $this->output();
       
   }

   function vw(){

    $o = new Adtype();
    $o->getData($_GET['id']);


    $this->assign("data",$o);
    $this->sub_content = "sub_content_adtype_vw.tpl";

    $this->output();

   }

   function edit(){

    $o = new Adtype();
    $o->getData($_GET['id']);

    $this->assign("data",$o);
    $this->sub_content = "sub_content_adtype_edit.tpl";

    $this->output();
    
   }

   function save(){

    $o = new Adtype();
    $o->getData($_POST['id']);
    foreach($_POST as $key=>$val){
      $o->$key = $val;
    }
      $o->vw = $_POST['vw'];

      $o->update();
      $this->gotoURL("index.php?r=adtype/vw&id=".$o->id);
   }

   function del(){

    $o = new Adtype();
    $o->getData($_GET['id']);

    $o->delete();
    $this->gotoURL("index.php?r=adtype/index&pos=".$_GET['pos']);

   }



   
}


?>