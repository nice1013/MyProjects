<?php 
//get market change
$marketid = "";

if(isset($_POST['marketid']))
{
$marketid = $_POST['marketid'];
}



if ($marketid != "") 
{

$db = new mysqli("localhost", "root", "", "test");

$markettablename = "change".$marketid;
$create_table = "CREATE TABLE IF NOT EXISTS $markettablename
		  (ID INT AUTO_INCREMENT, PRIMARY KEY(ID),
		  tradetotrade CHAR(40),
		  sum1 DOUBLE, sum2 DOUBLE, sum3 DOUBLE,
		  tradeavg1 DOUBLE, tradeavg2 DOUBLE, tradeavg3 DOUBLE, 
		  weightedavg1 DOUBLE, weightedavg2 DOUBLE, weightedavg3 DOUBLE, 
		  buys1 DOUBLE, buys2 DOUBLE, buys3 DOUBLE, 
		  sells1 DOUBLE, sells2 DOUBLE, sells3 DOUBLE
		  )";
$result = $db->query($query);

}//end marketid != ""
?>