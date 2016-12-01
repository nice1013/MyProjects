<?php

$db = new mysqli("localhost", "root", "", "autotrading");


 $ch = curl_init();
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptsy API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
    
        curl_setopt($ch, CURLOPT_URL, 'http://pubapi.cryptsy.com/api.php?method=marketdatav2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
        // run the query
        $res = curl_exec($ch);

        if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
        $dec = json_decode($res, true);
        if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
       
	   
	   
	   
/*
$q = "SHOW TABLES FROM autotrading";

$result = $db->query($q);
$returnthismasterindex = mysqli_fetch_all($result, MYSQL_NUM);
var_dump($returnthismasterindex);
*/

//var_dump($dec);
$orders = array_values($dec);

$array = $orders[1];

$a = $array['markets'];
	
$orderbook = array_values($a);
//$orderbook[0]['marketid'];



if ($array == true)
{
	
//var_dump($orderbook);
//echo $orderbook[0]['primaryname'];
$currencylist = array();




for($i = 0; $i< count($orderbook); $i++) 
{
	$t =  strtolower ($orderbook[$i]['primaryname']);
	$temp =  preg_replace('/[^\w@,.;]/', '', $t);
	$currencylist[] = $temp;
}

$i = 0;
foreach($currencylist as $tablename)
{
	$buybid = $orderbook[$i]['buyorders'][0]['price'];
	$buyamount = $orderbook[$i]['buyorders'][0]['quantity'];
	$sellbid = $orderbook[$i]['sellorders'][0]['price'];
	$sellamount = $orderbook[$i]['sellorders'][0]['quantity'];
	$basecurrency = $orderbook[$i]['secondarycode'];
	
	
	
	$updaterow = "UPDATE $tablename SET lastbuybid='$buybid', lastbuybidquanity='$buyamount', 
	lastsellbid='$sellbid', lastsellbidquanity='$sellamount' WHERE basecurrency='$basecurrency' LIMIT 1";
	
	$db->query($updaterow) or die("no good boss");
	
$i++;
}
$i = 0;


}
?>