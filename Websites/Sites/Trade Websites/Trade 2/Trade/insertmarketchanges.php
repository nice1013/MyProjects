<?php
$marketid = "";
$inputdata;

//check for input for a market if not call it a fail.
if(isset($_POST['marketid']))
{
$marketid = $_POST['marketid'];
$inputdata = json_decode($_POST['inputarray'], true);;
}

if ($marketid != "") 
{
	$db = new mysqli("localhost", "root", "", "test");
	
	$markettablename = "change".$marketid;
	
	
	
	echo "HELLO WERE HERE and so is".$inputdata[0][0];
	
	
	//$result = api_query("markettrades", array("marketid" => $marketid));
	//echo"<br><br>" . $result["return"][0]["tradeprice"];
	//var_dump($result);	
}
else 
{
		echo "Failed.<br>
		MarketID:".$marketid;	
}


?>