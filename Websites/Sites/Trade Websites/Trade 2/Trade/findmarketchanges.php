<?php 
//get market change
$marketid = "";
//what is the id of the trades we are looking for.
if(isset($_POST['marketid']))
{
$marketid = $_POST['marketid'];
}



if ($marketid != "") 
{

	$db = new mysqli("localhost", "root", "", "test");
	
	$markettablename = "change".$marketid;
	//find the last change we recorded.
	$query = "SELECT tradeto FROM $markettablename ORDER BY id DESC limit 0,1";
	//exucute that queary
	$query_result=$db->query($query) or die("FUCK couldn't get last trade");
	$tradetotradenumbers = mysqli_fetch_array($query_result, MYSQLI_BOTH);

	//test the results from the queary.
	if ($tradetotradenumbers != false)
	{
	//a var call this amount should be the tradeto value we quearyed for.
	$thisamount = intval($tradetotradenumbers[0]); //thisamount will tell us that we do not have a single change recorded in our history.
		//creating the market name for the new table
		$markettablename = "market".$marketid;
		$create_table = "SELECT * FROM $markettablename WHERE id >= $thisamount";
		$query_result=$db->query($create_table) or die("error, couldn't get last trade 14");
		$tradetotradenumbers = array();
		while($message = $query_result->fetch_assoc()){
		   $tradetotradenumbers[] = $message;
		}

		echo json_encode($tradetotradenumbers);
	
	
	}else 
	{
		//if here we dont have a table for this market
		//and wee neeed to create one. 
		$thisamount = 0; //thisamount will tell us that we do not have a single change recorded in our history.
		//creating the market name for the new table
		$markettablename = "market".$marketid;
		$create_table = "SELECT * FROM $markettablename";
		$query_result=$db->query($create_table) or die("error, couldn't get last trade 2");
		$tradetotradenumbers = array();
			while($message = $query_result->fetch_assoc()){
			   $tradetotradenumbers[] = $message;
			}
		echo json_encode($tradetotradenumbers);
		//echo json_encode($tradetotradenumbers);
		
	}//end else if 
	
	$db->close();

}//end marketid != ""
?>
