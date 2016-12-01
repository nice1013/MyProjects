


<?php
	$id = 1; // this will be used to indentify which row to insert new data on.
	$name = $_POST['name'];
	$comment = $_POST['comment'];  
	$rating = $_POST['rating'];

include 'Phpscripts/sql.php'; 

$con = ui();
//error proofing. 
if (!$con)
{
	die('Could not connect: ' .mysql_error()); 
}


//Finds a data base 
mysql_select_db("niard_comments", $con);


		 
$result = mysql_query("select * from data");
	while ($row = mysql_fetch_array($result)) {

	$id++;
	}


mysql_select_db("niard_comments", $con);
	$sql = "INSERT INTO data (comment, rating, name)
VALUES ('$comment', '$rating', '$name')";

 
	if (!mysql_query($sql,$con))
	  {
	  die('Error: ' . mysql_error());
	  }
	echo "1 record added";







  
  
  




mysql_close($con);

	
?> 






