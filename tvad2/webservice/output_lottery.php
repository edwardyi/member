<?php
	header("Content-type:text/X-JSON; charset=UTF-8");
	include_once("config.php");

	$output = array();

	$oLottery = new Lottery();

	$award = array('威力彩','38樂合彩','大樂透','49樂合彩','今彩539','39樂合彩','三星彩','四星彩');
	$output['status'] = "0";
	$output['message'] = "";
	$err = 0;
	foreach($award as $key=>$val){

		$data = array();
		$oLottery->getNewAward($val);

		if($oLottery->id == 0 || !(isset($oLottery->id))){
			$err++;
		}

		$data['name'] = $val;
		$data['date'] = $oLottery->open_date;
		$data['code'] = $oLottery->open_code;

		$data['award'] = $oLottery->result;
		$data['special'] = $oLottery->special;

		$output['data'][] = $data;
		
		$oLottery->setVarsEmpty();
	}

		if($err > 0){
			$output['status'] = "1";
			$output['message'] = "資料傳輸異常";
		}

	$oRequest = new Request();
	$oRequest->type = 1;
	$oRequest->mac = $mac;
	$oRequest->output = json_encode($output);
	$oRequest->insert();
	

	echo json_encode($output);

?>