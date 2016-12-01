<?php
$db = new mysqli("localhost", "root", "", "arb");
//create variable to hold incoming json string
//Incoming 3 trade
$tradearray = array();


if(isset($_POST['trades']))
{
$tradearray = json_decode($_POST['trades']);
}

echo "HELLO";

var_dump($tradearray);

//First we select all open arbs
//


?>