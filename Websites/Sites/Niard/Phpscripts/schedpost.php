


<?php
	$id = 0; // this will be used to indentify which row to insert new data on.
	$name = $_POST['name'];
	$comment = $_POST['comment'];  
	$rating = $_POST['rating'];

include 'phpscripts/sql.php'; 

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

	mysql_query("UPDATE data SET comment='$comment', rating='$rating'
WHERE id='$id'");

	if(!mysql_query("UPDATE customer SET nextcut='$date' 
WHERE id='$id'")) 
	{ echo "Sorry, your customer didn't update"; 
	}
 
	






$result = mysql_query("select * from customer where id='$id'");
while ($row = mysql_fetch_array($result)) {
  echo "Lastcut	:" . $row['lastcut'] . "<br />" . "<br />";
  echo "id			:" . $row['id'] . "<br />" . "<br />";
  echo "name		:" . $row['name'] . "<br />" . "<br />";
  echo "Address	:" . $row['address'] . "<br />" . "<br />"; 
  echo "Due		:" . $row['due'] . "<br />" . "<br />";
  echo "Charge		:" . $row['charge'] . "<br />" . "<br />";
  echo "History	:" . $row['history'] . "<br />" . "<br />";
  echo "Phone		:" . $row['phone'] . "<br />" . "<br />";
  echo "Comments	:" . $row['comments'] . "<br />" . "<br />";
  echo "Nextcut	:" . $row['nextcut'] . "<br />" . "<br />";
  echo "Lastcut	:" . $row['lastcut'] . "<br />" . "<br />";
//taking values from array and putting them into variables for 
//copying into sql  

  
  
  
}



mysql_close($con);
header('Location: ../schedule.php');
	
?> 






