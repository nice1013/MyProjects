<?php 
//tradehandler
include("stockcheck.php");
/* incoming data from javascript tradeagents
arbname:arbname,
	 		currency:currency,
			marketid:marketid,
			tradeid:tradeid,
			amount:amount}
			*/
$arbname = '';
$currency = '';
$marketid = '';
$tradeid = '';
$amount = '';

//check for input for a market if not call it a fail.
if(isset($_POST['arbname']))
{
$arbname = $_POST['arbname'];
}

if(isset($_POST['currency']))
{
$currency = $_POST['currency'];
}
if(isset($_POST['marketid']))
{
$marketid = $_POST['marketid'];
}
if(isset($_POST['tradeid']))
{
$tradeid = $_POST['tradeid'];
}
if(isset($_POST['amount']))
{
$amount = $_POST['amount'];
}


//$result = api_query("createorder", 
//array("marketid" => 132, "ordertype" => "Buy", "quantity" => 1000, "price" => 0.00000100));
echo $arbname . $currency . $marketid . $tradeid . $amount;
?>