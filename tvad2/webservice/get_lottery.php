<?php

	include_once("config.php");

	if(isset($_GET['reload'])) sleep(1);
	$oLottery = new Lottery();

	// echo 8/35 "2334樂透彩開獎號碼信息僅供參考,具體請參照官方公告";

	$url = "http://www.taiwanlottery.com.tw/";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($ch);
	curl_close($ch);
	$target[0]="";
	$result[0]="";
	preg_match_all('/<span class="font_black15">(.+?)<\/span>/',$content,$title); // 獎項 第幾期
	preg_match_all('/<div class="ball_tx ball_green">(.+?)<\/div>/',$content,$ball_green); // 威力彩 38樂合彩
	preg_match_all('/<div class="ball_tx ball_yellow">(.+?)<\/div>/',$content,$ball_yellow); // 大樂透 49樂合彩
	preg_match_all('/<div class="ball_red">(.+?)<\/div>/',$content,$ball_red); //特別號
	preg_match_all('/<div class="ball_tx ball_lemon">(.+?)<\/div>/',$content,$ball_lemon); // 今彩539 39樂合彩
	preg_match_all('/<div class="ball_tx ball_purple">(.+?)<\/div>/',$content,$ball_purple); // 三星彩 四星彩
	
	
	//獎項
	foreach($title[0] as $key=>$val){
		$aa = explode("&nbsp;",$val);
		preg_match_all('/第(.+?)期/',$aa[1],$result);
		if($key != 0){ 
			$award_date[] = trim(str_replace("<span class=\"font_black15\">","",$aa[0]));
			$award_name[] = trim($result[1][0]);
		}
	}

	//威力彩
	foreach($ball_green[1] as $key=>$val){
	 	 if($key >=  6 && $key <= 11)
		 	$green[] = trim($val);
	}

	//大樂透
	foreach($ball_yellow[1] as $key=>$val){
		 if($key >=  26 && $key <= 31)
			$yellow[] = trim($val);
	}

	foreach($ball_red[1] as $key=>$val){
			if($key == 1)
			 $green_s = trim($val);
			if($key == 2)
			 $yellow_s = trim($val);			
	}

	//今彩539
	foreach($ball_lemon[1] as $key=>$val){
			if($key >=  5 && $key <= 9)
				$lemon[] = trim($val);
	}

	//三星彩 四星彩
	foreach($ball_purple[1] as $key=>$val){
			if($key >=  0 && $key <= 2)
				$purple1[] = trim($val);
			if($key >=  3 && $key <= 6)
				$purple2[] = trim($val);
	}
	/*
	 * 威力彩 38樂合彩 => 星期一 星期四
	 * 大樂透 49樂合彩 => 星期二 星期五
	 * 今彩539 39樂合彩 三星彩 四星彩 =>星期一到星期六
	 */
	$award = array('威力彩','38樂合彩','大樂透','49樂合彩','今彩539','39樂合彩','三星彩','四星彩');

	$countHasRecord = 0;
	foreach($award as $key=>$val){

		$oLottery->type = $val;
		$oLottery->open_date = $award_date[$key];
		$oLottery->open_code = $award_name[$key];
		switch($val){
			case "威力彩":
				$oLottery->result = implode(",",$green);
				$oLottery->special = $green_s;
			break;
			case "38樂合彩":
				$oLottery->result = implode(",",$green);
			break;
			case "大樂透":
				$oLottery->result = implode(",",$yellow);
				$oLottery->special = $yellow_s;
			break;
			case "49樂合彩":
				$oLottery->result = implode(",",$yellow);
				$oLottery->special = "";
			break;
			case "今彩539":
				$oLottery->result = implode(",",$lemon);
			break;
			case "39樂合彩":
				$oLottery->result = implode(",",$lemon);
			break;
			case "三星彩":
				$oLottery->result = implode(",",$purple1);
			break;
			case "四星彩":
				$oLottery->result = implode(",",$purple2);
			break;
		}

			if(! ($oLottery->isRecordByAward())){ 
				$oLottery->update();
				$countHasRecord++;
			}
				$oLottery->setVarsEmpty();

	}


		if($countHasRecord > 0){
			echo 1;
		}else{
			echo 0;
		}




?>