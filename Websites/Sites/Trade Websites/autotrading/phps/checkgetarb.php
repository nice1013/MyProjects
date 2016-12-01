<?php
include("trade.php");
include("countfunction.php");

$db = new mysqli("localhost", "root", "", "arb");
//create variable to hold incoming json string
//Incoming 3 trade
$tradearray2 = array();
//bool for if we should trade
$marketrade = 0;
$tradearraynew = array();
$trade1 = array();
$trade2 = array();
$trade3 = array();

if(isset($_POST['trade1']))
{
$trade1 = json_decode($_POST['trade1'], true);
$trade2 = json_decode($_POST['trade2'], true);
$trade3 = json_decode($_POST['trade3'], true);


//echo "START: ".$tradearray2[0]['marketid']. "<br />";
$tradearraynew[] = $trade1;
$tradearraynew[] = $trade2;
$tradearraynew[] = $trade3;
}


//MARKET ID, BUYORSELL, QUANTITY, PRICE

$tradearray2 = array( 
		array("marketid" => "132" , "ordertype" => "buy", "quantity" => 101, "price" => "0.00000001" ), 
		array("marketid" => "132" , "ordertype" => "buy", "quantity" => 102, "price" => "0.00000001" ), 
		array("marketid" => "132" , "ordertype" => "buy", "quantity" => 103, "price" => "0.00000001" ));
		





//var_dump($tradearray);
/* OUTPUTS
array(3) { [0]=> array(4) { [0]=> string(2) "14" [1]=> string(3) "buy" [2]=> float(0.998) [3]=> string(6) "0.0003" } [1]=> array(4) { [0]=> string(2) "21" [1]=> string(4) "sell" [2]=> float(0.998) [3]=> string(10) "0.01290203" } [2]=> array(4) { [0]=> string(1) "3" [1]=> string(4) "sell" [2]=> float(0.01283759726218) [3]=> string(10) "0.02495001" } }
*/


//Variable for concated ids
$concatenatedids = "";
//Take the id of each trade. and insert them into concatenateids
for($i=0;$i < 3; $i++)
{
	//this will take all the ids in each trade and concatenate each of them together.
	$concatenatedids = $concatenatedids . "_" . $tradearraynew[$i]['marketid'];
	
}
echo $concatenatedids;
//dummy data
//echo $concatenatedids = "btcdogeltcbtc";

$t = "";
//get the last record with this id
$countmatches = "SELECT COUNT(id) FROM masterarb WHERE marketpath = '$concatenatedids'  ORDER BY id DESC limit 0, 1";
$numofrows = querycount($countmatches, $db);


//the results are successful, we need to check if the trade status is open
if ($numofrows > 0)
{
	//pile the results into t array
	$getarb = "SELECT * FROM masterarb WHERE marketpath = '$concatenatedids'  ORDER BY id DESC limit 0, 1";
	$result = $db->query($getarb);
	$arbdata = mysqli_fetch_all($result, MYSQL_BOTH);
	
	echo "STATUS :".$arbdata[0]['status'];
	
	if ($arbdata[0]['status'] === "open")
	{
	echo "OPEN";	
	}else if ($arbdata[0]['status'] === "close")
	{
	//if status == close then we can goahead and make another trade
	$marketrade = 1;
	echo "CLOSE";
	}else if ($arbdata[0]['status'] === "broken")
	{
	echo "broken";
	}

}else
//if the results didn't bring anything back we can go ahead and maketrade
{
	//changing the maketrade var to 1 to it will make the trade later on
	$marketrade = 1;
}

//if $concatenatedids exist and is closed do this
//if $concatenatedids doesn't exist, do this
if ($marketrade == 1)
{
//create a new arb record by asking for the last arb id
//get the last record
$getid = "SELECT * FROM masterarb ORDER BY id DESC limit 0, 1";
//put the results into a results var
$result = $db->query($getid);
	//pile the results into id array
	$idarray = mysqli_fetch_all($result, MYSQL_BOTH);
	
	//now we take that id and add one to it.
	//and concatenate the id onto "arb"
	//var_dump($idarray);
	$idarray1 = $idarray[0];
	$id = $idarray1['id'];
	//echo "<br />id: ".$id . "<br />";
	$nameofarbtable = "arb". ($id+ 1); 
	
	//we take this and insert a new row into our arb table
	$db = new mysqli("localhost", "root", "", "arb");
	$stmt = $db->prepare("INSERT INTO masterarb (arbname, marketpath, status) VALUES (?, ?, ?)");
	
	$a1 = $nameofarbtable ;
	$a2 =  $concatenatedids;
	$a3 = "open";
	
	$stmt->bind_param('sss', $a1 , $a2, $a3);
	$stmt->execute(); 
	$stmt->close();
	
	
	
	//now we will create that table 
$create_table = "CREATE TABLE IF NOT EXISTS $nameofarbtable
	  			(id INT AUTO_INCREMENT, PRIMARY KEY(id), tradeid CHAR(20) UNIQUE,
	  			marketid CHAR(5), status CHAR(7), amount DOUBLE, price DOUBLE, ordertype CHAR(5))";
$result = $db->query($create_table);
		
	//this is where we would trade to crypsy
	tradearb($tradearraynew, $nameofarbtable);
	
	//$stmt = $db->prepare("INSERT INTO masterarb (tradeid, marketid, currency, status, basecurrency, amount) VALUES (?, ?, ?, ?, ?, ? )");
	

//create a new arb record by asking for the last arb. if none
//insert this as new record with arb1 being table name
//if an arb does exist, take the id, add one and that will be the table name
//insert the name, the concated 3 market ids, and open as its status
//Create new table with the name [arb1] as example, 
//insert 3 rows of trades
//commit the 3 trades
//return Arb!
}



?>