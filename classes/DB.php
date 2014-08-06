<?php 
require_once("../config/params.php");
class DB extends PDO{
	private $DB_HOST;
	private $DB_NAME;
	private $DB_USER;
	private $DB_PWD;
	protected static $instance;
	public function __Construct($params=0){
		
		// 取得設定檔資料夾的參數
		switch ($params) {
			case 0:
				echo "now using first DB";
				$DB_HOST = HOST;
				$DB_NAME = DATABASE_NAME;
				$DB_USER = DATABASE_USERNAME;
				$DB_PWD = DATABASE_PASSWORD;
			break;
			case 1:
				echo "now using second DB";
				$DB_HOST = HOST1;
				$DB_NAME = DATABASE_NAME1;
				$DB_USER = DATABASE_USERNAME1;
				$DB_PWD = DATABASE_PASSWORD1;
			break;
			
		}
		self::$instance = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PWD);
		var_dump(self::$instance);
		// $link = mysql_connect($DB_HOST, $DB_USER, $DB_PWD);
		// mysql_select_db($DB_NAME, $link);
		// mysql_set_charset('UTF-8', $link);
	}
	public function queryTable(){
		
		$instance =self::$instance;
		var_dump($instance);
		$instance->prepare("select * from member");
		
		$instance->execute();

		return $instance;
	}


}
$db = new DB(1);
$test = $db->queryTable();
var_dump($test);
