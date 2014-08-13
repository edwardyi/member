<?php 
require_once("/config/params.php");
function __autoload($class_name) {
    include "/classes/".$class_name . '.php';
}
$obj = new medoo();
var_dump($obj);