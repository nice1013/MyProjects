<?php
include("stockcheck.php");

//$result = api_query("cancelorder", array("orderid" => 139567));

$result = api_query("allmyorders");

//var_dump($result);

echo $result['return'][0]['orderid'];

//insert all of the orders here 
$orders = $result['return'];
foreach ($orders as $order)
{

$result = api_query("cancelorder", $order);
var_dump($result);
echo "<br />";
}


?>

