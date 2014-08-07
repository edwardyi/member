<?php 
require_once("../config/params.php");
class DB {
	private $DB_HOST;
	private $DB_NAME;
	private $DB_USER;
	private $DB_PWD;
	// protected static $instance;
	protected $instance;
	public function __construct($params=0){
		
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
		// 設定連線參數
		$this->instance = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PWD);
		return $this->instance;
		
	}
	// 測試sql Query 是否正常輸出
	public function queryTable(){
		// $instance = $this->instance;
		// 利用建構子產生的實體進行查詢，並取得結果
		$test = $this->instance->query("describe member");
		$result = $test->fetchAll();
		return $result;
	}


}
$db = new DB(0);
$test = $db->queryTable();
// var_dump($test);
