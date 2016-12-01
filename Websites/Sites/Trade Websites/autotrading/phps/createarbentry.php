<?php
include("trade.php");
include("countfunction.php");

$marketrade = 0;

$db = new mysqli("localhost", "root", "", "arb");
//create variable to hold incoming json string
//Incoming 3 trade
$arbid = '';

if(isset($_POST['arbid']))
{
$arbid = $_POST['arbid'];
}


$t = "";
//get the last record with this id
$countmatches = "SELECT COUNT(id) FROM masterarb WHERE marketpath = '$arbid'  ORDER BY id DESC limit 0, 1";
$numofrows = querycount($countmatches, $db);


//the results are successful, we need to check if the trade status is open
if ($numofrows > 0)
{
	//pile the results into t array
	$getarb = "SELECT * FROM masterarb WHERE marketpath = '$arbid'  ORDER BY id DESC limit 0, 1";
	$result = $db->query($getarb);
	$arbdata = mysqli_fetch_all($result, MYSQL_BOTH);
	
	//echo "STATUS :".$arbdata[0]['status'];
	
	if ($arbdata[0]['status'] === "open")
	{
	//echo "OPEN";	
	}else if ($arbdata[0]['status'] === "close")
	{
	//if status == close then we can goahead and make another trade
	$marketrade = 1;
	//echo "CLOSE";
	}else if ($arbdata[0]['status'] === "broken")
	{
	//echo "broken";
	}

}else
//if the results didn't bring anything back we can go ahead and maketrade
{
	//changing the maketrade var to 1 to it will make the trade later on
	$marketrade = 1;
}


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
	$nameofarbtable = "arb". $id; 
	
	//we take this and insert a new row into our arb table
	$db = new mysqli("localhost", "root", "", "arb");
	$stmt = $db->prepare("INSERT INTO masterarb (arbname, marketpath, status) VALUES (?, ?, ?)");
	
	$a1 = $nameofarbtable ;
	$a2 =  $arbid;
	$a3 = "open";
	
	$stmt->bind_param('sss', $a1 , $a2, $a3);
	$stmt->execute(); 
	$stmt->close();
	
	
	
	//now we will create that table 
$create_table = "CREATE TABLE IF NOT EXISTS $nameofarbtable
	  			(id INT AUTO_INCREMENT, PRIMARY KEY(id), tradeid CHAR(20) UNIQUE,
	  			marketid CHAR(5), status CHAR(7), amount DOUBLE, price DOUBLE, ordertype CHAR(5))";
$result = $db->query($create_table);
}


if ($marketrade == 1)
{
echo $nameofarbtable;
}
else {
echo 0;
}
?>