<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<?php

$mysqli = new mysqli("dogecoin.x10.mx", "dogecoin_Dt123", "dt123", "dogecoin_SlideTable"); //Connect to the Database. 


$slide = 0; //Setting the default slide number. 

//Output any connection error
if ($mysqli->connect_error) {
    printf('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
else 
{
	echo "No connection Error\n\n";	
	
}



	$query = "SELECT Slide FROM slidetable LIMIT 1";
	$TheAfterQuery = $mysqli->query($query);
	
	
	
	while($data = $TheAfterQuery->fetch_array())
	{
	  echo $data['Slide'];
	}


// close connection
$mysqli->close();

?>

</body>
</html>