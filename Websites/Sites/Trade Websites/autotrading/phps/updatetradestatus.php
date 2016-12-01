<?php
include("stockcheck.php");
include("countfunction.php");


$db = new mysqli("localhost", "root", "", "arb");

//first we ask cryptsy for our open orders
$returnquery = api_query("allmyorders");
$openorders = $returnquery['return'];

//then we ask our masterarb for open arbs
$getopenarbs = "SELECT * FROM masterarb WHERE status = 'open'  ORDER BY id DESC";

//we take those open orders and grab their trades ids
$result = $db->query($getopenarbs);
$getopenarbs = mysqli_fetch_all($result, MYSQL_BOTH);
//echo $getopenarbs[0]['arbname'];
//we compare the open orders to ours in our database

//for each of our arbtables
foreach ($getopenarbs as $openarb)
{
	//insert the current openarb tablename into it's tablename vairable
	$tablename = $openarb['arbname'];

	//query for that table's trades
	$countmatches = "SELECT COUNT(id) FROM $tablename";
	//get the number of rows that count returned
	$numofrows = querycount($countmatches, $db);
	
	//if the number of rows are greater than 0, we have to do some comparison
	if($numofrows > 0)
	{
		
	//we now find that table table and get all of its trades that are open
	$getopenarbs = "SELECT * FROM $tablename WHERE status = 'open'  ORDER BY id DESC";
	//we take those open orders and grab their trades ids
	$result = $db->query($getopenarbs);
	$tabletradeids = mysqli_fetch_all($result, MYSQL_BOTH);
	
	
	//echo "TRADE ID " . $tabletradeids[0]['tradeid'];
	//for each open trade we compare them to our open orders
	//if there is no match, the order went through, or the order was cancled.
	foreach ($tabletradeids as $singletrade)
	{
		//this bool start as zero to represent no match in cryptsy
		$stillopenbool = 0;
		
		//we now run through the openorder id's against the ones in this table
		foreach ($openorders  as $oneorder)
		{
			
			//echo "TRADE ID " . $singletrade['tradeid'];
			//echo "TRADE ID " . $oneorder['orderid'];
			
			//if this trade id matches the current open order
			if ($singletrade['tradeid'] === $oneorder['orderid'])
			{
				//change the still open bool to one, to show that the trade should
				//still be open
				$stillopenbool = 1;
				echo "HELLO";
				
			}
		}
		
		//if still open is zero, then the trade is either canceled or completed
		//and we need to update the trade
		if($stillopenbool == 0)
		{
$temptradeid = $singletrade['tradeid'];
$updaterow = "UPDATE $tablename SET status ='close' WHERE tradeid = '$temptradeid' LIMIT 1";
$db->query($updaterow) or die("no good boss");
		}
		
		
		
		
		
	}
		
		
		
		
	//query for that table's trades
	$countmatches2 = "SELECT COUNT(id) FROM $tablename WHERE status = 'open'";
	//get the number of rows that count returned
	$numofrows = querycount($countmatches2, $db);
	
	//if the number of rows == 0 then we can close the arbritarage
	if($numofrows == 0)
	{
		$updaterow = "UPDATE masterarb SET status ='close' WHERE arbname = '$tablename' LIMIT 1";
		$db->query($updaterow) or die("no good boss");
	}
		
		
		
		
		
		
		
		
		
		
	}
	//if here the number of rows are 0, and therefore no trades are in that table
	//we can assume that this is a test table, and it's status should be changed to close
	else
	{
		
		$updaterow = "UPDATE masterarb SET status ='close' WHERE arbname = '$tablename' LIMIT 1";
		$db->query($updaterow) or die("no good boss");
		
	}
	
		
}
//what ever doesn't exist in the cryptsy open orders must have traded

//add arbtable and trade id to and array so that further on 
//we can look up arbtable, and update status, where trade id matches 




?>