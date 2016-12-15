<?php 
//This is for CM Functions
//2. Currency_Market table
// Categories:Id, Last high, Last low, last trade,
//:PollCounter, last ten, last 20, 	
//:last100,
function CheckCreateCMTable($tablename) {
//get database info
$db = new mysqli("localhost", "root", "", "trading");	
//if here the table doesn't exist and
//we have to create a new one.
$query = "CREATE TABLE IF NOT EXISTS $tablename (
		  ID INT(11) AUTO_INCREMENT,
		  PRIMARY KEY(ID),
		  Poll INT,
		  Lasthigh DOUBLE,
		  Lastlow DOUBLE,
		  Lasttrade DOUBLE,
		  Avgone DOUBLE,
		  Avgtwo DOUBLE,
		  Avgthree DOUBLE 
		  )";
		  //Avg One = 1hr
		  //Avg 2 = 2hr 
		  //Avg 3 = 1 day = 6 x 24 = 144 polls
		  
		  


		  if(!$result = $db->query($query)){
    die('There was an error running the query [' . $db->error . ']');
	

}
	//$create_tbl = $db->query($query);
	//$db->close();   
}//End CheckCreateCMTable













//Inserts a row into a CM table
function InsertIndexCM ($tablename, $poll, $lHigh, $llow, $ltrade, $avg1, $avg2, $avg3) {

//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");

//check connection to database
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
	$errors = 1;
}



//Insert Values into Mastter Table
$query = "INSERT INTO $tablename (Poll, LongName, Lasthigh, Lastlow, Lasttrade, Avgone, Avgtwo, Avgthree) VALUES(
$tablename, 
$lHigh,
$llow, 
$ltrade, 
$avg1, 
$avg2, 
$avg3)";
$result = mysqli_query($db, $query);
}//End InsertMasterIndex()


function GetLastTrade($tablename) { 

//get database info
$db = new mysqli("localhost", "root", "", "trading");

//check connection to database
$query = "SELECT * FROM {$tablename} ORDER BY ID DESC limit 0,1";
//exucute that queary
$query_result=$db->query($query) or die("Oh well, couldn't get last trade");
//test the results from the queary.

$returnthismasterindex = mysqli_fetch_array($query_result, MYSQLI_ASSOC);
	$db->close();
return $returnthismasterindex['Lasttrade']; 

}


function getAvgs ($amount) { 

//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");




$amounttoavg;
if ($amount == 1) 
{
	$amounttoavg = 12; 
} else if ($amount == 2) 
{
$amounttoavg = 144; 	
} else 
{
$amounttoavg = 2016; 	
}

$query = "SELECT AVG(Lasttrade) FROM master ORDER BY Id DESC limit 0, '$amounttoavg'"; 

$result = mysqli_query($db, $query);

if ($result == false) 
{return "";}

return $result;
}


//CheckOpportunities Function
function UpdateDataBase($marketData, $tempPoll) {
global $db;
$db = new mysqli("localhost", "root", "", "trading");
$TempPoll = $tempPoll;
	//echo "Echo Base";
	//get size of market.
	$sizeMarketData = max(array_map('count', $marketData));
	
//put values into a variable
	$marketTables = array();
	for ($m = 0; $m < $sizeMarketData; $m++)
	{
	$TempMasterCurrCode = $marketData['return'][$m]['secondary_currency_code'];
	$TempSlaveCurrCode = $marketData['return'][$m]['primary_currency_code'];
	$TempLastTrade = $marketData['return'][$m]['last_trade'];
	$TempLastHigh = $marketData['return'][$m]['high_trade'];
	$TempLastLow = $marketData['return'][$m]['low_trade'];
	$marketTables[] = $TempSlaveCurrCode . $TempMasterCurrCode;
	
	
	
	}
	//insert new tables with market names
	foreach($marketTables as $month) 
	{
	$maketablequery = 	"CREATE TABLE IF NOT EXISTS $month (
						  ID INT(11) AUTO_INCREMENT,
						  PRIMARY KEY(ID),
						  Poll INT,
						  Lasthigh DOUBLE,
						  Lastlow DOUBLE,
						  Lasttrade DOUBLE,
						  Avgone DOUBLE,
						  Avgtwo DOUBLE,
						  Avgthree DOUBLE  )";
		
    $db->query($maketablequery) or die ("Update Databse 1: Error. Create Table Last Low<br /><br /><br /> ");
	}
	
	
	
		$rs = 	"CREATE TABLE 
				  IF NOT EXISTS marketnames (
				  ID INT(11) AUTO_INCREMENT,
				  PRIMARY KEY(ID),
				  markets CHAR(10))";
	
	$db->query($rs) or die ("Update Databse 1: new one<br /><br /><br /> ");
	
	
	
	
	$e = 0;
	foreach($marketTables as $month) 
	{
		//echo $TempLastHigh;
	$TempLastTrade = $marketData['return'][$e]['last_trade'];
	$TempLastHigh = $marketData['return'][$e]['high_trade'];
	$TempLastLow = $marketData['return'][$e]['low_trade'];
	//echo "echo EEEEE;::::". $e;
		
	$query = "INSERT INTO $month 
	(Poll, Lasthigh, Lastlow, Lasttrade) VALUES(
	'1', $TempLastHigh, $TempLastLow, $TempLastTrade)";
		
		
    $db->query($query) or die ("<br />Error: Insert Database Last Trade");
	$e++;
	}
	//insert values.
	
	//insert avgs

}

?>
