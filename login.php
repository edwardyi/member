<?php 
require_once("/config/params.php");
function __autoload($class_name) {
    include "/classes/".$class_name . '.php';
}
$db = new Database();

// $query = $db->prepare("select * from member");
// foreach ($query as $key => $value) {
// 	echo $value;
// }

// $all = $query->fetchAll();
// var_dump($all);
// $query->execute();

// $obj = new medoo();
// var_dump($obj); 