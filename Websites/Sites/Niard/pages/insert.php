<?php

$parent = $_POST["parent"];
$title = $_POST["title"];
$body = $_POST["body"];



include 'phpscripts/sql.php'; 



$con = ui();
//The if is the shift saying what your going to do. 
//deciding if your going to the zoo
//or if your going to cry boo hoo hoo hoo
if (!$con)
{
	die('Could not connect: ' .mysql_error()); 
}

//Sir knight of MySql, 
//Finds a data base in the selection forest. 
//along with all the proper instructions to connect. 
mysql_select_db(

//'a3897265_nice'
"henhouse"
, $con);


mysql_query("INSERT INTO yokes (parent, name, body)
VALUES ('$parent', '$title', '$body')");



mysql_close($con);


#Method to go to previous page

 header("Location: {$_SERVER['HTTP_REFERER']}");



?>


