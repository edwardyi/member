<?php
function __autoload($class_name) {
    include $class_name . '.php';
}
$obj = new medoo();
$query = $obj->exec("describe member");
var_dump($query);

$obj2 = new medoo(["database_type"=>"mysql","database_name"=>"webauth","server"=>"localhost","username"=>"root","password"=>""]);
$data = $obj2->select("user_pwd",["name"]);
$data2 = $obj2->select("user_pwd","name");
var_dump($data);
var_dump($data2);

$obj2 = new medoo(["database_type"=>"mysql","database_name"=>"webauth","server"=>"localhost","username"=>"root","password"=>""]);
// var_dump($obj2);
// $result = $obj->fetchAll();
// foreach ($query as $key => $value) {
// 	echo $value;
// }
