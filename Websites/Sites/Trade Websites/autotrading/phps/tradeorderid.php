<?php 
//tradehandler
include("stockcheck.php");
 //incoming data from javascript tradeagents
//$tradearray = 
//		array("marketid" => "132" , "ordertype" => "buy", "quantity" => 103, "price" => "0.00000001" );
$trade = array();
$tablename = '';
if(isset($_POST['trade']))
{
$inputarb = json_decode($_POST['trade'], true);
}
if(isset($_POST['tablename']))
{
$tablename = $_POST['tablename'];
}	
if(isset($_POST['order']))
{
$orderid = $_POST['order'];
}	

//tradearb($tradearray, 'arb200');		
	
	$db = new mysqli("localhost", "root", "", "arb");
	
	var_dump($inputarb);
		
	//we take this and insert a new row into our arb table
	$preparedstatement =
	"INSERT INTO $arbname (tradeid, marketid, amount, price, ordertype, status) VALUES (?, ?, ?, ?, ?, ?)";
	echo "<br /><br />Prepared: " .$preparedstatement;
	$stmt = $db->prepare($preparedstatement);
	
	$tradeid = $orderid;
	$marketid =  $inputarb['marketid'];
	$amount = number_format($inputarb['quantity'], 8, '.', '');
	$price =  floatval($inputarb['price']);
	$price =  number_format($price, 8, '.', '');
	$ordertype = $inputarb['ordertype'];
	$status = "open";
	
	
	echo "<br />tradeid:".$marketid;
	echo "<br />amount:".$amount;
	echo "<br />order:".$ordertype;
	echo "<br />price:".$price;
	//s = tradeid
	//s = marketdi 
	//d = quantity
	//d = price 
	//s = ordertype
	//s = status
	$stmt->bind_param('ssddss', $tradeid , $marketid, $amount, $price, $ordertype, $status);
	$stmt->execute(); 
	$stmt->close();
	

?>