<?php
require_once("/classes/YahooFinance.php");
$yf = new YahooFinance;

$historicaldata = $yf->getHistoricalData('ASX', '2012-01-01', '2012-01-31');
$quote          = $yf->getQuotes('ASX');	   		// single quote
$quotes	   = $yf->getQuotes(array('ASX', 'WOW'));	// multiple quotes


$SSquote  = $yf->getQuotes('^FTSE');
$array = array("{","}","\"");
$SSquote = str_replace($array,"",$SSquote);
$arr = explode(",", $SSquote);


foreach ($arr as $key => $value) {
	$test = explode(":",$value);
	echo $test[0]."=>".$test[1]."<br/>";
}


// $str = preg_replace('/({) (})/', '', $SSquote);
// var_dump($arr);
// $test = unserialize($SSquote);
// var_dump($test);
// $SSarr = explode(",", $SSquote);
// var_dump($SSarr);
// var_dump($historicaldata);
