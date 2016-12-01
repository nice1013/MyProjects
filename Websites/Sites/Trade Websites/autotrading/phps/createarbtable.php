<?php

$db = new mysqli("localhost", "root", "", "arb");

$create_table = "CREATE TABLE IF NOT EXISTS masterarb
			  (id INT AUTO_INCREMENT, PRIMARY KEY(id), arbname CHAR(10) UNIQUE,
			  arbstatus CHAR(7))";
$result = $db->query($create_table);
	
?>