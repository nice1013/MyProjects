<?php 
//get market change
$marketid = "";
//what is the id of the trades we are looking for.
if(isset($_POST['marketid']))
{
$marketid = $_POST['marketid'];
}

if ($marketid != "") 
{
	$db = new mysqli("localhost", "root", "", "test");
	$markettablename = "change".$marketid;
	$query = "SELECT COUNT('id') FROM $markettablename";
	$query_result=$db->query($query) or die("couldn't get last trade");
	$tradetotradenumbers = mysqli_fetch_array($query_result, MYSQLI_BOTH);
	var_dump($tradetotradenumbers);
	echo "TRADETONUMBERS:".$tradetotradenumbers[0];
}
?>
