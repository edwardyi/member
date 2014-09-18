<?php

class UserController extends Controller {
      
   var $db_conn;
   
   var $lang;
   var $system;
   var $UserLevel;
   var $UserID;
   var $content_page = "index_content.tpl";
   var $right_menu = "right_menu_user.tpl";
   var $main_menu_name = "main_menu_user";
   var $sub_menu_name = "sub_menu_user";
   
   
   function init() {
     $permission = array(
                    "login_allow"=>all
                    );

     return $permission;

   }

   function doPermission($permission){
      $module = "config_user";
      switch($GLOBALS['controllerAction']){
        case "index":
        case "vw":
         if($permission[$module]['vw'] == 0)
            $this->gotoNotPermissiomPage();
          break;
        case "edit":
        case "save":
        case "chgpwd":
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
          unset($_SESSION['p_user']);
          $p = $_GET;
          $_SESSION['p_user'] = $p; 
        }else{
          $p = $_SESSION['p_user'];
        }
      }else{
        unset($_SESSION['p_user']);
      }

       $pos = empty($_GET['pos']) ? 1 : $_GET['pos'];
       if($_GET['back'] ==1) $pos = $_SESSION['page'];

       $o = new User();
       $p['vw'] = 1;
       $p['sorting'] = $_GET['sorting'];

       $rows = $o->getList($p);
       $total = $o->db_num_rows($rows);
       $limit_str = $this->limit($total, $this->pagesize, $pos);
       $lists = $o->getListObject($p, $limit_str);

      $this->getSelectLists(array("city","area","place","branch"));




       $query_str = "index.php?r=user/index&pos=";

       $this->assign("lists",$lists);

       $this->sub_content = "sub_content_user.tpl";
       $this->assign("p",$p);
       $this->pager($lists, $query_str);

       $this->output();
       
   }

   function vw(){

    $o = new User();
    $o->getData($_GET['id']);


    $this->assign("data",$o);
    $this->sub_content = "sub_content_user_vw.tpl";

    $this->output();

   }

   function edit(){

    $o = new User();
    $o->getData($_GET['id']);

    $this->getSelectLists(array("city","area","place","branch"));

    $oLevel = new Level();
    $levelLists = $oLevel->getListObject(array());

    $this->assign("data",$o);
    $this->sub_content = "sub_content_user_edit.tpl";


    $this->assign("levelLists",$levelLists);

    $this->output();
    
   }

   function save(){

    $o = new User();
    $o->getData($_POST['id']);
    $old_checked = $o->checked;

    foreach($_POST as $key=>$val){
      $o->$key = $val;
    }
      $o->checked = $_POST['checked'];

      $o->update();
      if($old_checked == 0 && $o->checked == 1)
        $this->sendMailByChecked($o);

      $this->gotoURL("index.php?r=user/vw&id=".$o->id);
   }

   function del(){

    $o = new User();
    $o->getData($_GET['id']);
    $o->vw = 0;
    if(!empty($o->id))
      $o->update();
    
    $this->gotoURL("index.php?r=user/index&pos=".$_GET['pos']);

   }

   function chgpwd(){

      $o = new User();
      $o->getData($_GET['id']);

      if($_POST != null){
        $o->getData($_POST['id']);
        $o->pwd = $_POST['pwd'];
        if($o->chgpassword()){
          $this->gotoURL('index.php?r=user/vw&id='.$o->id."&pwd_err=0");
        }
      }else{ 
        $this->sub_content = "sub_content_user_pwd.tpl";
        $this->assign("data",$o);
        $this->output();
      }
   }

   //AJAX
   function checkUsername(){

      $o = new User();
      $o->getDataByUserID($_POST['username']);

      if($o->id > 0 ){
        echo 1;
      }else{
        echo 0;
      }

   }

   //審核通知信
   function sendMailByChecked(&$oUser){

      require APP_ROOT_PATH.'_pkg/PHPMailer-master/PHPMailerAutoload.php';

      $mail = new PHPMailer;
      
      $mail->setLanguage('zh', 'PHPMailer-master/language/');
      
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'mail.jowinwin.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'service@jowinwin.com';                 // SMTP username
      $mail->Password = '29151532';                           // SMTP password
      //$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
      $mail->Port = 25;
      $mail->CharSet = "utf-8";
      
      $mail->From = 'service@jowinwin.com';
      $mail->FromName = '系統通知信';

      $mail->addAddress($oUser->email);               // Name is optional
      //$mail->addReplyTo('info@example.com', 'Information');
      $mail->addCC('samkuo@heran.com.tw');
      //$mail->addBCC('bcc@example.com');

      $mail->isHTML(true);                                  // Set email format to HTML

      $mail->Subject = '廣告機審核通知信';
      $mail->Body    = '已將您的帳號('.$oUser->username.')開通';
      //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {
        echo 'Message has been sent';
      }

   }

}


?>