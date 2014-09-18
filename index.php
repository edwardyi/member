<?php 
require_once('/libs/Smarty.class.php');

$dir =  __DIR__;
$smarty = new Smarty();
$smarty->template_dir = $dir.'/templates/';
$smarty->compile_dir =  $dir.'/templates_c/';
// var_dump($smarty);
$smarty->assign('title','會員管理');
$smarty->assign('Name','登入');

$smarty->display('templates/header.tpl');
$smarty->display('templates/menu.tpl');
$smarty->display('templates/memberForm.tpl');
$smarty->display('templates/footer.tpl');
?>