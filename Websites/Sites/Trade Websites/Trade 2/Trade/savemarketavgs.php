<?php 

function createtableformarkethistory($tablename){

$db = new mysqli("localhost", "root", "", "test");
	
$create_table = "CREATE TABLE IF NOT EXISTS $tablename
		  (ID INT AUTO_INCREMENT, PRIMARY KEY(ID),
		  time DOUBLE,
		  price)";
		  
// Create student table
$create_tbl = $db->query($create_table);

}//End CheckCreateMasterTable()


function insertmarkethistory($tablename, $price, $time){
$db = new mysqli("localhost", "root", "", "test");
$insertrow = "INSERT INTO $tablename (time, price) VALUES( $time, $price)";
		  
// Create student table
$create_tbl = $db->query($insertrow);

}//End CheckCreateMasterTable()






createtableformarkethistory($_POST['name']);




?>