<?php 
require_once("../config/params.php");
// 此類別希望能在產生建構子時，使用autoload來載入相對應的類別
class Member{
	private $table;
	
	public function __construct($db){
		// 取不到pdo建構子QQ
		$test = $db->query("describe member");
		$result = $test->fetchAll();
		// new DB();
		echo "Ya!";
	}
	
}
// 在建構子外面使用autoload方法載入其他類別
function __autoload($class_name) {
    include $class_name . '.php';
}
$db = new DB(1);
new Member($db);




