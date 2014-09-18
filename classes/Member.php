<?php 
namespace Edward\Models;
require_once("MemberInterface.php");


class PDOMember implements IMember{
	private $pdo;
	public function __construct($pdo){
		$this->$pdo = $pdo;
	}
	public function getMemberById($member_id){
		$sql = "SELECT * FROM member WHERE mid =:mid";
		$stmt = $this->pdo->prepare($sql);
		if($stmt->execute(array(":mid"=>$member_id))){
			return $stmt->fetch();
		}else{
			return null;
		}
	}
	public function getRole($member_id){
		$sql = "SELECT m.name,r.role_name FROM `member` m LEFT JOIN `role` r ON m.role_id = r.rid WHERE m.mid=:mid";
		$stmt = $this->pdo->prepare($sql);
		if($stmt->execute(array(":mid"=>$member_id))){
			return $stmt->fetch();
		}else{
			return null;
		}
	}
}
$pdo = new PDO("localhost", "root", "");
$member = new PDOMember($pdo);
$result = $member->getMemberById("1");
var_dump($result);