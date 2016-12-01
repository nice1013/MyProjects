<?php
include("trade.php");
include("countfunction.php");

$db = new mysqli("localhost", "root", "", "arb");
//create variable to hold incoming json string
//Incoming 3 trade
$trade = array();
$tablename = '';
if(isset($_POST['trade']))
{
$trade = json_decode($_POST['trade'], true);
}
if(isset($_POST['tablename']))
{
$tablename = $_POST['tablename'];
}

//echo "table".$trade['marketid'];

//its here for the order id
	//this is where we would trade to crypsy
	//tradearb($trade, $tablename);
//submit trade to crypsty put return data in traderesults
$traderesults1 = api_query("createorder", $trade);
var_dump($traderesults1);
//get the order id of that trade
$tradeid = $traderesults1['orderid'];

//echo the trade id
echo $tradeid;


?>