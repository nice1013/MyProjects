<?php

$db = new mysqli("localhost", "root", "", "arb");
//currency name

//market id

//trade id

//sell or buy

//



$create_table = "CREATE TABLE IF NOT EXISTS masterarb
			  (id INT AUTO_INCREMENT, PRIMARY KEY(id), arbname CHAR(10) UNIQUE, marketpath CHAR(20),
			  status CHAR(7))";
$result = $db->query($create_table);
	
?>