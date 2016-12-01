<?php
include("../stockcheck.php");

$db = new mysqli("localhost", "root", "", "autotrading");

function getMarketData(){ 
	//Download Market data
	$marketData = api_query("getmarkets");
	return $marketData;
}



function getSizeofMarket($marketData) {
	//get size of array. 
	$MaxArray = max(array_map("count", $marketData));
	return $MaxArray;		
}






$markets = getMarketData();
$sizeofmarkets = max(array_map("count", $markets));
//var_dump($markets);
echo "<br />
<br />size".$sizeofmarkets;
//$result["return"]['sellorders'][0]['sellprice'];
echo "<br /><br />".$markets["return"][0]['primary_currency_name'];

//array for holding the names of each currency
$arrayofcurrenciesnames = array();

//put each name of array into array
for($i = 0; $i < $sizeofmarkets; $i++)
{
	
	$arrayofcurrenciesnames[] = preg_replace('/[^\w@,.;]/', '', $markets["return"][$i]['primary_currency_name']);
}



//for each primary currency, create a table for it.
foreach ($arrayofcurrenciesnames as $currency) 
{
	
	$create_table = "CREATE TABLE IF NOT EXISTS $currency
			  (id INT AUTO_INCREMENT, PRIMARY KEY(id), basecurrency CHAR(10) UNIQUE,
			  marketid CHAR(5), code CHAR(7), lastbuybid DOUBLE, lastbuybidquanity DOUBLE, lastsellbid DOUBLE, 		 lastsellbidquanity DOUBLE)";
	$result = $db->query($create_table);
	
}

//for each currency
//insert ignore into each table  the base currency (BTC) and the market id)
$i = 0; //var for holding vars
foreach ($arrayofcurrenciesnames as $currency) 
{
	echo "we are on ".$currency."<br />";
	$basecurrency = $markets['return'][$i]['secondary_currency_code'];
	$marketid = $markets['return'][$i]['marketid'];
	$code = $markets['return'][$i]['primary_currency_code'];
	
	$stmt = $db->prepare("INSERT INTO $currency (basecurrency, marketid, code) VALUES (?, ?, ?)");
	
	$stmt->bind_param('sss', $basecurrency , $marketid, $code);
	
	$basecurrency = $markets['return'][$i]['secondary_currency_code'];
	$marketid = $markets['return'][$i]['marketid'];
	$code = $markets['return'][$i]['primary_currency_code'];
	echo "base".$currency;
	echo "base".$basecurrency;
	
	
	
	$stmt->execute(); 
	$stmt->close();
$i++;
	
}
$i=0;





$db->close();
?>