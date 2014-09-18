<?php

class IndexController extends Controller {
      
   var $db_conn;
   
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $content_page = "index_content.tpl";
   var $main_css = 'css/signin.css';
   
   
   function init() {
     

   }
   

   function index(){
       
       $this->content_page = "login.tpl";
       $this->main_css = "css/signin.css";      
       $this->output();
       
   }

   function verify(){

      //驗證
      $o = new User();

      switch($o->login($_POST['username'],$_POST['pwd'])){
        case 0:
          $this->gotoURL("index.php?r=home/index");
        break;
        default:
          $this->gotoURL("index.php?r=index/index&login_err=1");
        break;
      }


   }

   function logout(){
      $o = new User();
      $o->logout();
      $this->gotoURL("index.php?r=index/index");
   }

   function signup(){

      $this->getSelectLists(array("city","area","place","branch"));

      if($_POST == null){
        $this->content_page = "signup.tpl";
        $this->output();
      }else{
            $o = new User();
            $o->getDataByUserID($_POST['username']);
            if($o->id > 0){
              $this->gotoURL("not_permission.html");
            }
            foreach($_POST as $key=>$val){
              $o->$key = $val;
            }
            $o->insert();
            $this->gotoURL("index.php");
      }

   }


   
}


?>