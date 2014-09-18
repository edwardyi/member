<?php

class LevelController extends Controller {
      
   var $db_conn;
   
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $content_page = "index_content.tpl";
   var $right_menu = "right_menu_user.tpl";
   var $main_menu_name = "main_menu_user";
   var $sub_menu_name = "sub_menu_level";
   
   function init() {
     $permission = array(
                    "login_allow"=>all
                    );

     return $permission;

   }

   function doPermission($permission){
      $module = "config_permission";
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

       $o = new Level();

       $p['sorting'] = $_GET['sorting'];
       $rows = $o->getList($p);
       $total = $o->db_num_rows($rows);
       $limit_str = $this->limit($total, $this->pagesize, $pos);
       $lists = $o->getListObject($p, $limit_str);


       $query_str = "index.php?r=level/index&pos=";

       $this->assign("p",$p);
       $this->assign("lists",$lists);
       $this->sub_content = "sub_content_level.tpl";
       $this->pager($lists, $query_str);
       $this->output();
       
   }

   function vw(){

    $o = new Level();
    $o->getData($_GET['id']);

    $oSubmenu = new Submenu();
    $submenuAll = $oSubmenu->getListObject(array());

    $i = 0;
    foreach($submenuAll as $key=>$val){
      if($key == 0){
        $temp_main_menu_id = $val->main_menu_id;
      }
      $obj[$key] = clone $val;
      if($val->main_menu_id == $temp_main_menu_id){
        $submenuLists[$i][] = $obj[$key];
      }else{
        $i++;
        $submenuLists[$i][] = $obj[$key];
        $temp_main_menu_id = $val->main_menu_id;
      }
    }

    $oPer = new Permission();
    foreach($submenuLists as $key=>$val){
      foreach($val as $key2=>$row){
        $oPer->getPermission($o->id,$row->id);
        $submenuLists[$key][$key2]->per_ins = $oPer->ins;
        $submenuLists[$key][$key2]->per_upd = $oPer->upd;
        $submenuLists[$key][$key2]->per_del = $oPer->del;
        $submenuLists[$key][$key2]->per_sel = $oPer->sel;
        $submenuLists[$key][$key2]->per_vw = $oPer->vw;
        $submenuLists[$key][$key2]->per_branch_flag = $oPer->branch_flag;
      }
    }

    $this->assign("data",$o);
    $this->assign("submenuLists",$submenuLists);
    $this->sub_content = "sub_content_level_vw.tpl";

    $this->output();

   }

   function edit(){

    $o = new Level();
    $o->getData($_GET['id']);


    $oSubmenu = new Submenu();
    $submenuAll = $oSubmenu->getListObject(array());

    $i = 0;
    foreach($submenuAll as $key=>$val){
      if($key == 0){
        $temp_main_menu_id = $val->main_menu_id;
      }
      $obj[$key] = clone $val;
      if($val->main_menu_id == $temp_main_menu_id){
        $submenuLists[$i][] = $obj[$key];
      }else{
        $i++;
        $submenuLists[$i][] = $obj[$key];
        $temp_main_menu_id = $val->main_menu_id;
      }
    }

    $oPer = new Permission();
    foreach($submenuLists as $key=>$val){
      foreach($val as $key2=>$row){
        $oPer->getPermission($o->id,$row->id);
        $submenuLists[$key][$key2]->per_ins = $oPer->ins;
        $submenuLists[$key][$key2]->per_upd = $oPer->upd;
        $submenuLists[$key][$key2]->per_del = $oPer->del;
        $submenuLists[$key][$key2]->per_sel = $oPer->sel;
        $submenuLists[$key][$key2]->per_vw = $oPer->vw;
        $submenuLists[$key][$key2]->per_branch_flag = $oPer->branch_flag;
      }
    }

    $this->assign("data",$o);
    $this->assign("submenuLists",$submenuLists);
    $this->sub_content = "sub_content_level_edit.tpl";

    $this->output();
    
   }

   function save(){

      $o = new Level();
      $o->getData($_POST['id']);
      $o->name = $_POST['name'];
      $o->update();


      $oPer = new Permission();
      $oSubmenu = new Submenu();
      $submenuLists = $oSubmenu->getListObject(array());

      $oPer->clearLevel($o->id);
      foreach($submenuLists as $key=>$val){
        $column = "func_".$val->id."_ins";
        $column2 = "func_".$val->id."_upd";
        $column3 = "func_".$val->id."_del";
        $column4 = "func_".$val->id."_sel";
        $column5 = "func_".$val->id."_vw";
        $column6 = "func_".$val->id."_branch";
        $oPer->level_id = $o->id;
        $oPer->sub_menu_id = $val->id;
        $oPer->ins = $_POST[$column];
        $oPer->upd = $_POST[$column2];
        $oPer->del = $_POST[$column3];
        $oPer->sel = $_POST[$column4];
        $oPer->vw = $_POST[$column5];
        $oPer->branch_flag = $_POST[$column6];
        $oPer->insert();
      }


      $this->gotoURL("index.php?r=level/vw&id=".$o->id);
   }

   function del(){

      $o = new Level();
      $o->getData($_GET['id']);
      $oPer = new Permission();
      $oPer->clearLevel($o->id);
      $o->delete();
      $this->gotoURL("index.php?r=level/index&pos=".$_GET['pos']);

   }



   
}


?>