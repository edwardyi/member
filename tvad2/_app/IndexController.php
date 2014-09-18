<?php

class IndexController extends Controller {
      
   var $db_conn;
   
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $content_page = "index_content.tpl";

   
   
   function init() {
     

   }
   

   function index(){
       $p = array();

      if($_GET['clear'] != 1){
        if($_GET['q'] == 1){
          unset($_SESSION['p_lottery']);
          $p = $_GET;
          $_SESSION['p_lottery'] = $p; 
        }else{
          $p = $_SESSION['p_lottery'];
        }
      }else{
        unset($_SESSION['p_lottery']);
      }

      $pos = empty($_GET['pos']) ? 1 : $_GET['pos'];
       if($_GET['back'] ==1) $pos = $_SESSION['page'];

       $o = new Lottery();


       $rows = $o->getList($p);
       $total = $o->db_num_rows($rows);
       $limit_str = $this->limit($total, $this->pagesize, $pos);
       $lists = $o->getListObject($p, $limit_str);


       $query_str = "index.php?r=index/index&pos=";

       $this->assign("p",$p);
       $this->assign("lists",$lists);
       $this->content_page = "content_lottery.tpl";
       $this->pager($lists, $query_str);
       $this->output();
       
   }

   function save(){

      $o = new Lottery();

      $o->getData($_POST['id']);
      foreach($_POST as $key=>$val){
        $o->$key = $val;
      }

       $o->update();

   }



   
}


?>