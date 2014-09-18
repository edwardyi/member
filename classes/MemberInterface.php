<?php
namespace Edward\Models;
Interface IMember{
	public function getMemberById($member_id);
	public function getRole($member_id);
}