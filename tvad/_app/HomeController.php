<?php

class HomeController extends Controller {
      
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
                    "login_allow"=>array("index","city","vw","edit","save","del")
                    );

     return $permission;
   }
   

   function index(){

      $p = array();

      if($_GET['clear'] != 1){
        if($_GET['q'] == 1){
          unset($_SESSION['p_today']);
          $p = $_GET;
          $_SESSION['p_today'] = $p; 
        }else{
          $p = $_SESSION['p_today'];
        }
      }else{
        unset($_SESSION['p_today']);
      }

      if($this->permission['config_mac']['branch_flag'] == 1){
        $p['city_id'] = $this->oLoginUser->city_id;
        $p['area_id'] = $this->oLoginUser->area_id;
        $p['place_id'] = $this->oLoginUser->place_id;
        $p['branch_id'] = $this->oLoginUser->branch_id;
      }

      $oAd = new Ad();


      $allLists = $oAd->getListForToday($p);

      $tmp_branch_id = "";
      $i = 0;
      foreach($allLists as $key=>$val){
        // $oAd2 = new Ad();
        // $oAd2->getData($val->id);

        $obj[$key] = clone $val;
        if($key == 0) $tmp_branch_id = $val->oMac->branch_id;
        if($val->oMac->branch_id == $tmp_branch_id){
          $lists[$i][] = $obj[$key];
        }else{
          $i++;
          $lists[$i][] = $obj[$key];
          $tmp_branch_id = $val->oMac->branch_id;
        }


      }



      $this->getSelectLists(array("city","area","place","branch","adtype"));

       $this->assign("p",$p);
       $this->main_menu_name = "main_menu_today_ad";
       $this->sub_content = "sub_content_today_ad.tpl";
       $this->content_page = "index_content_no_right_menu.tpl";

       $this->assign("lists",$lists);

       $this->output();
       
   }

   function doPermission($permission){
      $module = "config_city";
      switch($GLOBALS['controllerAction']){
        case "city":
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

   function city(){
       
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

       $pos = empty($_GET['pos']) || $_GET['q'] ==1 ? 1 : $_GET['pos'];
       if($_GET['back'] ==1) $pos = $_SESSION['page'];

       $oCity = new City();

       $rows = $oCity->getList($p);
       $total = $oCity->db_num_rows($rows);
       $limit_str = $this->limit($total, $this->pagesize, $pos);
       $lists = $oCity->getListObject($p, $limit_str);

       foreach($lists as $key=>$obj){
          $oArea = new Area();
          $q['city_id'] = $obj->id;
          $itemLists = $oArea->getListObject($q);
          $items[$key] = $itemLists;
       }

       $query_str = "index.php?r=home/city&pos=";

        $oCity2 = new City();
        $cityLists = $oCity2->getListObject(array());


       $this->assign("p",$p);
       $this->assign("lists",$lists);
       $this->assign("cityLists",$cityLists);
       $this->assign("items",$items);
       $this->sub_content = "sub_content_city.tpl";
       $this->pager($lists, $query_str);
       $this->output();
       
   }

   function vw(){

      $p = array();

      if( $_SESSION['p_area']['id'] != $_GET['id']){
        unset($_SESSION['p_area']);
      }

      if($_GET['clear'] != 1){
        if($_GET['q'] == 1){
          unset($_SESSION['p_area']);
          $p = $_GET;
          $_SESSION['p_area'] = $p; 
        }else{
          $p = $_SESSION['p_area'];
        }
      }else{
        unset($_SESSION['p_area']);
      }



    $oCity = new City();
    $oCity->getData($_GET['id']);

    $p['city_id'] = $oCity->id;
    $p['sorting'] = $_GET['sorting'];
    $oArea = new Area();
    $lists = $oArea->getListObject($p);


    $this->getSelectLists(array("city","area"));

    $this->assign("p",$p);
    $this->assign("data",$oCity);
    $this->assign("lists",$lists);
    $this->sub_content = "sub_content_city_vw.tpl";

    $this->output();

   }

   function edit(){

    $oCity = new City();
    $oCity->getData($_GET['id']);

    $this->assign("data",$oCity);
    $this->sub_content = "sub_content_city_edit.tpl";

    $this->output();
    
   }

   function save(){

    $oCity = new City();
    $oCity->getData($_POST['id']);
    foreach($_POST as $key=>$val){
      $oCity->$key = $val;
    }
      $oCity->vw = $_POST['vw'];

      $oCity->update();
      $this->gotoURL("index.php?r=home/vw&id=".$oCity->id);
   }

   function del(){

    $oCity = new City();
    $oCity->getData($_GET['id']);

    $p['city_id'] = $oCity->id;
    $oArea = new Area();
    $rows = $oArea->getList($p);
    $total = $oArea->db_num_rows($rows);

    if($total == 0){
      $oCity->delete();
      $this->gotoURL("index.php?r=home/city&pos=".$_GET['pos']."&id=".$oCity->id);
    }else{

      $this->gotoURL("index.php?r=home/vw&pos=".$_GET['pos']."&id=".$oCity->id."&del_err=1");
    }


    

   }



   
}


?>