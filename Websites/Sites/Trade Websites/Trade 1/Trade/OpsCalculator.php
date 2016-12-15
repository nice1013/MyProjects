<?php 


//This is for CM Functions

//3. Create Table For EachCurrencyOps
//Categories:
//			Id, Poll
//			M1toM2, M1toM3, M1toM4
//			M2toM1, M2toM3, M2toM4
//			M3toM1, M3toM2, M3toM4
//			M4toM1, M4toM2, M4toM3
//			AvgM1toM2, AvgM1toM3, AvgM1toM4
//			AvgM2toM1, AvgM2toM3, AvgM2toM4
//			AvgM3toM1, AvgM3toM2, AvgM3toM4
//			AvgM4toM1, AvgM4toM2, AvgM4toM3
//			$M1toM2, $M1toM3, $M1toM4
//			$M2toM1, $M2toM3, $M2toM4
//			$M3toM1, $M3toM2, $M3toM4
//			$M4toM1, $M4toM2, $M4toM3
//			$AvgM1toM2, $AvgM1toM3, $AvgM1toM4
//			$AvgM2toM1, $AvgM2toM3, $AvgM2toM4
//			$AvgM3toM1, $AvgM3toM2, $AvgM3toM4
//			$AvgM4toM1, $AvgM4toM2, $AvgM4toM3
function CheckCreateCurrencyOps($tablename) {
//get database info
$db = new mysqli("localhost", "root", "", "trading");
//if here the table doesn't exist and
//we have to create a new one.
$query = "CREATE TABLE IF NOT EXIST $tablename (
		  ID int(11) AUTO_INCREMENT, PRIMARY KEY(ID),
		  M1toM2 DOUBLE, M1toM3 DOUBLE, M1toM4 DOUBLE,
		  M2toM1 DOUBLE, M2toM3 DOUBLE, M2toM4 DOUBLE,
		  M3toM1 DOUBLE, M3toM2 DOUBLE, M3toM4 DOUBLE,
		  M4toM1 DOUBLE, M4toM2 DOUBLE, M4toM3 DOUBLE,
		  
		  P1toP2 TEXT, P1toP3 TEXT, P1toP4 TEXT,
		  P2toP1 TEXT, P2toP3 TEXT, P2toP4 TEXT,
		  P3toP1 TEXT, P3toP2 TEXT, P3toP4 TEXT,
		  P4toP1 TEXT, P4toP2 TEXT, P4toP3 TEXT,
		  
		  AvgM1toM2 DOUBLE, 
		  AvgM1toM3 DOUBLE, 
		  AvgM1toM4 DOUBLE,
		  
		  AvgM2toM1 DOUBLE, 
		  AvgM2toM3 DOUBLE, 
		  AvgM2toM4 DOUBLE,
		  
		  AvgM3toM1 DOUBLE, 
		  AvgM3toM2 DOUBLE, 
		  AvgM3toM4 DOUBLE,
		  
		  AvgM4toM1 DOUBLE, 
		  AvgM4toM2 DOUBLE, 
		  AvgM4toM3 DOUBLE

		  )";
$create_tbl = $db->query($query);

}//End CheckCreateMasterTable()






//Inserts a row into a Currency Market Ops Table
function InsertM2MCurrOps ($tablename, $MtoM, $M2MValue, $P2P, $P2PValue) {
//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");

//Insert row into the M2M table
$query = "INSERT INTO $tablename ($MtoM, $P2P) VALUES ($M2MValue, $P2PValue)";
$db->query($query) or die ("Oh well, we couldn't get yo uthat");
	
	
}//End InsertM2MCurrOps()

function UpdateM2MAtPoll ($tablename, $poll, $MtoM, $M2MValue) {
//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");

//check connection to database
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
	$errors = 1;
} 
//Insert row into the M2M table
$query = "UPDATE $tablename SET
		$MtoM = $M2MValue, 
		WHERE Poll = $poll";
$result = mysqli_query($db, $query);
	

}



function Insert2M2MAtPoll ($tablename, $poll, $MtoM, $M2MValue, $MtoM2, $M2MValue2) { 
//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");

//check connection to database
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
	$errors = 1;
}
//Insert row into the M2M table
$query = "UPDATE $tablename SET
		$MtoM = $M2MValue,
		$MtoM2 = $M2MValue2 
		WHERE Poll = $poll";
$create_tbl = $db->query($query);
}










//Inserts a row into a Currency Market Ops Table
function UpdateM2MCurrOps ($tablename, $id, $MtoM, $M2MValue) {
//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");

//check connection to database
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
	$errors = 1;
}
//Updates a row into the M2M table by finding a certain ID
$query = "UPDATE $tablename SET '$MtoM' = '$M2MValue' WHERE Id = '$id'";

$create_tbl = $db->query($query);
	
	
}//End UpdateM2MCurrOps()


//insert a master index along with the current index number, 
//the markets to check within that currency
//with the poll count
//to insert a new calc into Ops

function getCalcs($masterIndex, $indexNumber, $marketnum1, $marketnum2, $TempPoll) {
	//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");

//check connection to database
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
	$errors = 1;
}
	
	//if statement used to tell which market we should focus on. 
	//our only option $marketnum1 and marketnum2 are ===== 1, 2, 3, 4,
	$master1code;
	$market1code ;
	$master2code;
	$market2code ;
	if (($marketnum1 == 1)) 
	{
		$master1code = "Master1code";
		$market1code = "Market1code";
	} 
	else if ($marketnum1 == 2) 
	{
		$master1code = "Master2code";
		$market1code = "Market2code";
	} 
	else if ($marketnum1 == 3) 
	{
		$master1code = "Master3code";
		$market1code = "Market3code";
	} 
	else if ($marketnum1 == 4) 
	{
		$master1code = "Master4code";
		$market1code = "Market4code";
		
	} 
	

	$firstCalc; 
//		  M1toM2 DOUBLE, M1toM3 DOUBLE, M1toM4 DOUBLE,
//		  M2toM1 DOUBLE, M2toM3 DOUBLE, M2toM4 DOUBLE,
//		  M3toM1 DOUBLE, M3toM2 DOUBLE, M3toM4 DOUBLE,
//		  M4toM1 DOUBLE, M4toM2 DOUBLE, M4toM3 DOUBLE,
	//get the markets we will be saving to. 
	//		  M1toM2 DOUBLE, M2toM1 DOUBLE,
		if ($marketnum1 == 1 && $marketnum2 == 2) 
	{
		$firstCalc = 'M1toM2';
		
	} 
	
	else if ($marketnum1 == 1 && $marketnum2 == 3) 
	{
		$firstCalc = 'M1toM3';
		
	} 
	else if ($marketnum1 == 1 && $marketnum2 == 4) 
	{
		$firstCalc = 'M1toM4';
		
	} 
	else if ($marketnum1 == 2 && $marketnum2 == 1) 
	{
		$firstCalc = 'M2toM1';
		
	} 
	else if ($marketnum1 == 2 && $marketnum2 == 3) 
	{
		$firstCalc = 'M2toM3';
		
	} 
	else if ($marketnum1 == 2 && $marketnum2 == 4) 
	{
		$firstCalc = 'M2toM4';
		
	} 
	else if ($marketnum1 == 3 && $marketnum2 == 1) 
	{
		$firstCalc = 'M3toM1';		
	}
	else if ($marketnum1 == 3 && $marketnum2 == 2) 
	{
		$firstCalc = 'M3toM2';		
	}
	else if ($marketnum1 == 3 && $marketnum2 == 4) 
	{
		$firstCalc = 'M3toM4';		
	}
	else if ($marketnum1 == 4 && $marketnum2 == 1) 
	{
		$firstCalc = 'M4toM1';		
	}
	else if ($marketnum1 == 4 && $marketnum2 == 2) 
	{
		$firstCalc = 'M4toM2';		
	}
	else if ($marketnum1 == 4 && $marketnum2 == 3) 
	{
		$firstCalc = 'M4toM3';	
	}
	
	
	
	
	//put all variables into tempvars
	//check to see if a first market exist
	//if not were done. 
	if ($masterIndex[$indexNumber][$master1code] != "NULL")
	{
		//Create a master1currcode for easy access.
		$Master1CurrCode = $masterIndex[$indexNumber][$master1code];
		//Create Martet1code for this variable
		$tSlaveMarketcode1 = $masterIndex[$indexNumber][$market1code];
		//if we pass this marker
		//we have atleast two markets for this currency.
		if ($masterIndex[$indexNumber][$master2code] != "NULL")
			{	
			//get the master2currcode
			$Master2CurrCode = $masterIndex[$indexNumber][$master2code];
			//get masketCurrency2
			$tSlaveMarketcode2 = $masterIndex[$indexNumber][$market2code];
			
			
			
			//find master1currcode last trade value
			$SlaveValueInMarket1 = GetLastTrade($tSlaveMarketcode1, $TempPoll);
			$SlaveValueInMarket2 = GetLastTrade($tSlaveMarketcode2, $TempPoll);



			//Mission: Get second market currency code
			$masterSlaveMASTERIndex = getMasterIndex($Master2CurrCode);
			$masterSlaveValue;
			//create var for secondary market code 
			$MSMarketCode; 
			$didwegetamatch = 0; //if set to one we recieved a match in our search for a second market
			
			//check to see whether it is traded in the same market as our slave currency 
			for ($p = 1; $p < 5; $p++) 
			{
				
				//if a master currency of our master-slave currnecy matches our slave currency's master currency
				//insert it into $MSMarketCode so we can look up its last trade value.
				if ($masterSlaveMASTERIndex['Master' . $p . 'code'] == $masterIndex[$indexNumber][$master1code]) 
					{ 
					$MSMarketCode = $masterIndex[$indexNumber][$market1code];
					$p = 5;
					$didwegetamatch = 1;
					}
			}//end for loop
			//if it does exist, get its last trade value within that market.
			if ($didwegetamatch == 1) { 
	        //get the value of the masterslave currency within the first market
			$masterSlaveValue = GetLastTrade($MSMarketCode, $TempPoll);
			}

			//how many slave currencies can we buy with one master slave currency. 
			//lets find out. 
			//Divide M1-MasterSlaveValue by M1-CurrValue 
			//Get SlavePerSlave Value
			$amountperCurr1M = $masterSlaveValue / $SlaveValueInMarket1;
			 	//Divide 1 by lasttradevalue
			$amountperCurr2M = 1 / $SlaveValueInMarket2;
			
			$firstMarketAdvantageValue = $amountperCurr1M - $amountperCurr2M;
			$firstMarketAdvantagePercentage = $firstMarketAdvantageValue / $amountperCurr2M;
			
			
			UpdateM2MAtPoll($masterIndex[$indexNumber]['LongName'],$TempPoll, $firstCalc,	$firstMarketAdvantagePercentage);
			
			
			
				
	
	}
	}
}








function getMymoney($masterIndex, $indexNumber, $m1, $m2) {
	$master1code;
	$market1code ;
	$master2code;
	$market2code ;
	$sizeOfMasterIndex = count($masterIndex); 
	
	switch($m1) {
    case 1:  
	$master1code = "Master1code";
	$market1code = "Market1code";
	break;
    case 2: 
	$master1code = "Master2code";
	$market1code = "Market2code";
	 break;
    case 3: 
	$master1code = "Master3code";
	$market1code = "Market3code";
	 break;
	 case 4: 
	$master1code = "Master4code";
	$market1code = "Market4code";
	 break;
	}
	 
	 switch($m2) {
    case 1:  
	$master2code = "Master1code";
	$market2code = "Market1code";
	break;
    case 2: 
	$master2code = "Master2code";
	$market2code = "Market2code";
	 break;
    case 3: 
	$master2code = "Master3code";
	$market2code = "Market3code";
	 break;
	 case 4: 
	$master2code = "Master4code";
	$market2code = "Market4code";
	 break;
    
}

	
	//we ask to see if current currncy master code exist.
	if ($masterIndex[$indexNumber][$master1code] != "null")
	{
		
		$currCode = $masterIndex[$indexNumber]['CurrCode'];
		//Create a master1currcode for easy access.
		$Master1CurrCode = $masterIndex[$indexNumber][$master1code];
		//Create Martet1code for this variable
		$tSlaveMarketcode1 = $masterIndex[$indexNumber][$market1code];
		//if we pass this marker
		//we have atleast two markets for this currency.
		if ($masterIndex[$indexNumber][$master2code] != "null")
			{	
			//get the master2currcode
			$Master2CurrCode = $masterIndex[$indexNumber][$master2code];
			
			//find master1currcode last trade value
			$SlaveValueInMarket1 = GetLastTrade($currCode . $Master2CurrCode);
			$SlaveValueInMarket2 = GetLastTrade($currCode . $Master1CurrCode);
			
			//echo "<br />LastTrade:". $Master1CurrCode . $Master2CurrCode ;
			if (( $Master1CurrCode . $Master2CurrCode != "BTCLTC") && 
				($Master1CurrCode . $Master2CurrCode  != "LTCXPM") && 
				($Master1CurrCode . $Master2CurrCode  != "BTCXPM"))
			{
	        //get the value of the masterslave currency within the first market
			$masterSlaveValue = GetLastTrade($Master1CurrCode . $Master2CurrCode);
			
			//how many slave currencies can we buy with one master slave currency. 
			//lets find out. 
			//Divide M1-MasterSlaveValue by M1-CurrValue 
			//Get SlavePerSlave Value

			//echo "Amount Per Backup currency in First market $Master2CurrCode:" . $amountperCurr1M;
			$amountperCurr1M =  $masterSlaveValue / $SlaveValueInMarket1 ;


			 	//Divide 1 by lasttradevalue
			$amountperCurr2M = 1 / $SlaveValueInMarket2;
			//echo "<br /><br />Amount Per Backup currency in $Master1CurrCode:" . $amountperCurr2M;
			
			$firstMarketAdvantageValue = $amountperCurr1M - $amountperCurr2M;
			$firstMarketAdvantagePercentage = $firstMarketAdvantageValue / $amountperCurr2M;
			$values = array();
			//STORE THE PER  CURRENCY VALUE 
			$values[] =  $firstMarketAdvantagePercentage  ;
			
			
			
			$values[] = $Master2CurrCode . "/" . $Master1CurrCode .  "/" .  $currCode . ":"
					 .  $amountperCurr1M 
					. ", ". $Master1CurrCode . "/" . $currCode . ":" . $amountperCurr2M .
					", Difference:" .  $firstMarketAdvantageValue;
			echo "Percentage:" . $values[0]. "<br />" . $values[1] . "<br /><br />";
			return $values;
			} 
			
			
			}
				
	
	}
}	









function calculateShit() {
$db = new mysqli("localhost", "root", "", "trading");

	//get what we have in the database
	$MasterIndex = getMasterIndex(); //Get Master index
	//duplicate it
	$masterIndex = $MasterIndex;
	//count how much we recieved from the database
	$sizeOfMasterIndex = count($MasterIndex); 
	//create array for the market tables.
	$marketTables = array(); 	
	$percentage = array();
	$holder = array();
	

for ($y = 0; $y < $sizeOfMasterIndex; $y++) 
{
unset($holder);
$holder = array();
$holder['LongName'] = $masterIndex[$y]['LongName'];


for($p = 1; $p < 5; $p++){
	for($a = 1; $a < 5; $a++){
		if(empty($holder['M' . $p . 'toM' . $a] ))
		{
			$holder['M' . $p . 'toM' . $a] = "null";
		}
		if(empty($holder['P' . $p . 'toP' . $a] ))
		{
			$holder['P' . $p . 'toP' . $a] = "null";
		}
		
	}
}

for($a = 1; $a < 5; $a++){


//pre eliminate blank master2codes, master3codes, and master4codes,
	
if ($masterIndex[$y]['Master2code'] == " " ||
	$masterIndex[$y]['Master2code'] == ""  ||
	$masterIndex[$y]['Master2code'] == "null")
	{
		$masterIndex[$y]['Master2code'] = "null";
		
	}

if ($masterIndex[$y]['Master3code'] == " " ||
	$masterIndex[$y]['Master3code'] == ""  ||
	$masterIndex[$y]['Master3code'] == "null")
	{
		$masterIndex[$y]['Master3code'] = "null";
		
	}

if ($masterIndex[$y]['Master4code'] == " " ||
	$masterIndex[$y]['Master4code'] == ""  ||
	$masterIndex[$y]['Master4code'] == "null")
	{
		$masterIndex[$y]['Master4code'] = "null";
		
	}





//echo "Master2code:" . $masterIndex[$y]['Master2code']. "<br /><br />";
//echo "CurrCode:" . $masterIndex[$y]['CurrCode']. "<br /><br />";

if ($masterIndex[$y]['Master2code'] != '' && $masterIndex[$y]['Master2code'] != 'null')
{
	//echo "Master2code:" . $masterIndex[$y]['Master2code']. "<br /><br />";
	
	if ($a != 1){
	$tp = array();	
	$tp = getMymoney($masterIndex, $y, 1, $a);
	
	$holder['M1toM' . $a] = $tp[0];
	$holder['P1toP' . $a] = $tp[1];
	}
	
	if ($masterIndex[$y]['Master3code'] != '' && $masterIndex[$y]['Master3code'] != 'null')
	{
		
		if ($a != 2){
		$tp = array();
		$tp = getMymoney($masterIndex, $y, 2,  $a);
		$holder['M2toM' . $a] = $tp[0];
		$holder['P2toP' . $a] = $tp[1];
		}
		
		if ($masterIndex[$y]['Master4code'] != '' && $masterIndex[$y]['Master4code'] != 'null')
		{	
		
			if ($a != 3){
			$tp = array();
			$tp = getMymoney($masterIndex, $y, 3, $a);
			$holder['M3toM' . $a] = $tp[0];
			$holder['P3toP' . $a] = $tp[1];
			}
		
		}
	}
}	
	
	
	
	
	
	
	
for($a = 1; $a < 5; $a++){

	
	if ($masterIndex[$y]['Master2code'] != '' && $masterIndex[$y]['Master2code'] != 'null')
	{
		if ($a != 1){
		$tp = array();
		$tp = getMymoney($masterIndex, $y, $a, 1);
		$holder['M' . $a . 'toM1'] = $tp[0];
		$holder['P' . $a . 'toP1'] = $tp[1];
		}
		
		
		if ($masterIndex[$y]['Master3code'] != '' && $masterIndex[$y]['Master3code'] != 'null')
		{
			if ($a != 2){
			$tp = array();
			$tp = getMymoney($masterIndex, $y, $a, 2);
			$holder['M' . $a . 'toM2'] = $tp[0];
			$holder['P' . $a . 'toP2'] = $tp[1];
			}
			
			
			
		if ($masterIndex[$y]['Master4code'] != '' && $masterIndex[$y]['Master4code'] != 'null')
		{
			if ($a != 3){
			$tp = array();
			$tp = getMymoney($masterIndex, $y, $a, 3);
			$holder['M' . $a . 'toM3'] = $tp[0];
			$holder['P' . $a . 'toP3'] = $tp[1];
			}
		}//end master4code
		}//end master3
	}//end master2code requirement

}//end second for loop


$percentage[] = $holder;

}

}

//echo $percentage[0]['LongName'];
$zi = count($percentage);
$Currency = array();
for ($f = 0; $f < $zi; $f++)
{
	$Currency[] = $percentage[$f]['LongName'];
}


$f = 0;
foreach($Currency as $month) 
	{		//used to store values into compatiable queary
			$values;
			unset($values); 
			$values = "";
			//take all values place in a array;
			unset($p);
			$p = array();
		 	$p[] =  $percentage[$f]['M1toM2'];
			$p[]  = $percentage[$f]['M1toM3'];
			$p[]  = $percentage[$f]['M1toM4'];
			$p[]  = $percentage[$f]['M2toM1']; 
			$p[]  = $percentage[$f]['M2toM3']; 
			$p[]  = $percentage[$f]['M2toM4'];
			$p[] = $percentage[$f]['M3toM1']; 
			$p[]  = $percentage[$f]['M3toM2']; 
			$p[]  = $percentage[$f]['M3toM4'];
			$p[] = $percentage[$f]['M4toM1']; 
			$p[]  = $percentage[$f]['M4toM3'];
			$p[] = $percentage[$f]['M4toM4'];
			$p[]  = $percentage[$f]['P1toP2'];
			$p[] = $percentage[$f]['P1toP3']; 
			$p[]  = $percentage[$f]['P1toP4'];
			$p[]  = $percentage[$f]['P2toP1'];
			$p[] = $percentage[$f]['P2toP3']; 
			$p[]  = $percentage[$f]['P2toP4'];
			$p[] = $percentage[$f]['P3toP1']; 
			$p[]  = $percentage[$f]['P3toP2']; 
			$p[]  = $percentage[$f]['P3toP4'];
			$p[]  = $percentage[$f]['P4toP1'];
			$p[]  = $percentage[$f]['P4toP3']; 
			$p[]  = $percentage[$f]['P4toP4'];
		
			$values = '"' . implode('","', $p) . '"';
		
		
		

	$dropall = "DROP TABLE IF EXISTS {$month}";	
		
	$query ="INSERT INTO $month
		(M1toM2, M1toM3, M1toM4,
		  M2toM1, M2toM3, M2toM4,
		  M3toM1, M3toM2, M3toM4,
		  M4toM1, M4toM2, M4toM3,
		  P1toP2, P1toP3, P1toP4,
		  P2toP1, P2toP3, P2toP4,
		  P3toP1, P3toP2, P3toP4,
		  P4toP1, P4toP2, P4toP3,
		  AvgM1toM2, AvgM1toM3, AvgM1toM4,
		  AvgM2toM1, AvgM2toM3, AvgM2toM4,
		  AvgM3toM1, AvgM3toM2, AvgM3toM4,
		  AvgM4toM1, AvgM4toM2, AvgM4toM3) 
		  VALUES($values, 
		  'NULL', 'NULL', 'NULL',
		  'NULL', 'NULL', 'NULL',
		  'NULL', 'NULL', 'NULL',
		  'NULL', 'NULL', 'NULL')";
		  


		
		  
		  
    $db->query($query) or die ("<br /><br />Calculate Shi.t Error::: Insert into P1<br /><br />");
	$f++;
	}








}//end Calc Function


function getrest($marketData) {
	$db = new mysqli("localhost", "root", "", "trading");
		//get stuff we have stored in database
		$MasterIndex = getMasterIndex(); //Get Master index
		//count how many currencies we currently have
		$sizeOfMasterIndex = count($MasterIndex); 
		//create an array to hold all of the names of the currencies. 
		$marketTables = array(); 
		//use this for loop to capture all the LongName 's of th
		for($i = 0; $i < $sizeOfMasterIndex; $i++) 
		{
			$marketTables[] = $MasterIndex[$i]['LongName'];
	
			
		}
	
	
	foreach($marketTables as $month) 
	{
	$dropall = "DROP TABLE IF EXISTS {$month}";	
		
	$query = "CREATE TABLE IF NOT EXISTS $month (
		  ID int(11) AUTO_INCREMENT, PRIMARY KEY(ID),
		  M1toM2 DOUBLE, M1toM3 DOUBLE, M1toM4 DOUBLE,
		  M2toM1 DOUBLE, M2toM3 DOUBLE, M2toM4 DOUBLE,
		  M3toM1 DOUBLE, M3toM2 DOUBLE, M3toM4 DOUBLE,
		  M4toM1 DOUBLE, M4toM2 DOUBLE, M4toM3 DOUBLE,
		  
		   P1toP2 TEXT, P1toP3 TEXT, P1toP4 TEXT,
		  P2toP1 TEXT, P2toP3 TEXT, P2toP4 TEXT,
		  P3toP1 TEXT, P3toP2 TEXT, P3toP4 TEXT,
		  P4toP1 TEXT, P4toP2 TEXT, P4toP3 TEXT,
		  
		  
		  AvgM1toM2 DOUBLE, 
		  AvgM1toM3 DOUBLE, 
		  AvgM1toM4 DOUBLE,
		  
		  AvgM2toM1 DOUBLE, 
		  AvgM2toM3 DOUBLE, 
		  AvgM2toM4 DOUBLE,
		  
		  AvgM3toM1 DOUBLE, 
		  AvgM3toM2 DOUBLE, 
		  AvgM3toM4 DOUBLE,
		  
		  AvgM4toM1 DOUBLE, 
		  AvgM4toM2 DOUBLE, 
		  AvgM4toM3 DOUBLE)";
    $db->query($query) or die ("<br />We Were unable to The Currency for each table. 53<br />");
	}
	
	
}



?>
