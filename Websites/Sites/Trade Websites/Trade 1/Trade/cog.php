<?php 
//This is for Cog Function
//Function: Check and Create Cog table
//Categories:Poll Number
function CheckCreateCogTable() {
	$db = new mysqli("localhost", "root", "", "trading");
	//create a queary to find a row from cog
	//exucute that queary
	//test the results from the queary.
	//if here the table doesn
	//we have to create a new one.
	$query = "CREATE TABLE IF NOT EXISTS cog 
			   (Poll INT, PRIMARY KEY(Poll))";
	$db->query($query);
	
$db->close();
	
}//End Funtion CheckCreateCogTable()




//Function: Check and Create Cog table
//Categories:Poll Number
function insertCog($Poll) {

	$db = new mysqli("localhost", "root", "", "trading");
	//Insert a New Row into COG poll
	$query = "INSERT INTO cog Poll VALUES '$Poll'";
			echo "insertCog<br />";
	$result = $db->query($query);  
	$db->close(); 
	
}//End Funtion CheckCreateCogTable()
	
	
	
	
	
	
	
	
	
	
//get poll function.
function getPoll() {
	$db = new mysqli("localhost", "root", "", "trading");	
	echo "get Poll<br />";
	
	//quearies for a poll
	$query = 	"SELECT * FROM cog 
				ORDER BY Poll DESC limit 0,1";

$result = $db->query($query);

	if ($result == false)
	{
		
		return 1;
		
	}
	else
	{
		$returnthismasterindex = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$tempPollvalue = $returnthismasterindex['Poll'];
		return $returnthismasterindex['Poll'];
	}
	$db->close();	
}





?>