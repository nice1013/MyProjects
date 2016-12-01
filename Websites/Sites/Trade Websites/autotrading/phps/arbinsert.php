<?php 
//tradehandler
$db = new mysqli("localhost", "root", "", "arb");
/* incoming data from javascript tradeagents
arbname:arbname,
	 		currency:currency,
			marketid:marketid,
			tradeid:tradeid,
			amount:amount}
			*/
$arbname = '';
$marketpath = '';

//check for input for a market if not call it a fail.
if(isset($_POST['arbname']))
{
$arbname = $_POST['arbname'];
}

if(isset($_POST['marketpath']))
{
$marketpath = $_POST['marketpath'];
}


if ($marketpath != '')
{
//$result = api_query("createorder", 
//array("marketid" => 132, "ordertype" => "Buy", "quantity" => 1000, "price" => 0.00000100));
	$db = new mysqli("localhost", "root", "", "arb");
	$stmt = $db->prepare("INSERT INTO masterarb (arbname, marketpath, status) VALUES (?, ?, ?)");
	
	$a1 = $arbname;
	$a2 =  $marketpath;
	$a3 = "open";
	
	$stmt->bind_param('sss', $a1 , $a2, $a3);
	
	echo "base".$arbname;
	echo "base".$marketpath;
	
	
	$stmt->execute(); 
	$stmt->close();
	
	
	
	
$create_table = "CREATE TABLE IF NOT EXISTS $arbname
	  			(id INT AUTO_INCREMENT, PRIMARY KEY(id), tradeid CHAR(20) UNIQUE,
	  			marketid CHAR(5), currency CHAR(15), status CHAR(7), basecurrency CHAR(15), amount DOUBLE)";
$result = $db->query($create_table);
	
	
	
	
	
	
	
	
}
?>