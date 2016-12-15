<?php

//get database info
global $db;
$db = new mysqli("localhost", "root", "", "trading");

//getmaster functions
include("master.php");
//get cog functions
include("cog.php");
//get cm functions
include("cm.php");
//get ops functions
include("OpsCalculator.php");
include("stockcheck.php");

















function getMarketData(){ 
//Download Market data
$marketData = api_query("getmarkets");
return $marketData;
}



function getSizeofMarket($marketData) {
//get size of array. 
$MaxArray = max(array_map("count", $marketData));
return $MaxArray;		
}




function solidifyMasterList($marketin) 
{ 
		$AddEntryCache = Array(); //array for finding deplicate entries
		$marketData = $marketin; //get market data
		$db = new mysqli("localhost", "root", "", "trading");//create database info
		//get size of the array for market data
		$MaxArray = max(array_map('count', $marketData));
		//start the var insertprimer for queary building, that will be used to insert curr data. 
		$insertPrimer = "";
		$MasterIndex = getMasterIndex(); //Get Master index
		$sizeOfMasterIndex = count($MasterIndex);  //Convert that stuff into an array
		//echo $MasterIndex[0]['Id'];
		//will show 1; 
		//this for loop will check if the database has any new entries. 
		for ($i = 0; $i < $MaxArray; $i++) 
		{
			//Get All values for first array
			$TempSlaveCurrCode = $marketData['return'][$i]['primary_currency_code'];
			$TempMarketID = $marketData['return'][$i]['marketid'];
			$TempLabel = $marketData['return'][$i]['label'];
			$TempCurrencyName = $marketData['return'][$i]['primary_currency_name'];
			$TempMasterCurrCode = $marketData['return'][$i]['secondary_currency_code'];
			$TempMasterCurrName = $marketData['return'][$i]['secondary_currency_name'];
			$TempLastTrade = $marketData['return'][$i]['last_trade'];
			$TempLastHigh = $marketData['return'][$i]['high_trade'];
			$TempLastLow = $marketData['return'][$i]['low_trade'];
		
			
			$addentry = true;
			//Check to see if Currency Exist in MasterList 
			for ($p = 0; $p < $sizeOfMasterIndex; $p++) 
			{
				//if it matches a selection 1) change $p to sizeOfmasterIndex
				//2) change dontdoit var so it doesn't enter a new row
				if (trim($MasterIndex[$p]['CurrCode']) == trim($TempSlaveCurrCode)) 
				{
					$p = $sizeOfMasterIndex; 
					$addentry = false; 
				}
			}
			
			
			//check $addentry
			//to find if we should add this data into 
			if ($addentry == true)
			{
				$confirmedentry = 1; //when set to one this will confirm that we need to enter this to database.
				//add a cach for what one are going to be entered so we 
				//dont have any duplicates. 
				$size = count($AddEntryCache);
				echo "SIZE:" . $size . "<br />";
				if ($size != 0) {
					
				for ($q = 0; $q < $size; $q++)
				{
					
					//we are testing the current 
					if (trim($TempSlaveCurrCode) == trim($AddEntryCache[$q])) 
					{
						$confirmedentry = 0;
					}//end if ($TempMasterCurrCode == $AddEntryCache[$p]) 
				
				}//for ($q = 0; $q < count($AddEntryCache); $q++)
				}
				
				for ($z = 0; $z < $sizeOfMasterIndex; $z++) 
				{
				if ($MasterIndex[$z]['CurrCode'] == trim($TempSlaveCurrCode))
					{
						$confirmedentry = 0;
					}
				
				}
				
				//check to see whether entry needs to be in primer.
				if ($confirmedentry == 1) {
				$AddEntryCache[] = $TempSlaveCurrCode;
				echo $TempSlaveCurrCode . "<br />";
				$insertPrimer = InsertMasterPrimer($TempSlaveCurrCode, $TempCurrencyName, $TempMasterCurrCode, $TempMarketID, $TempLabel, $insertPrimer);	
				}// end if ($confirmedentry == 1
			}//if ($addentry == true)
		}
		//inset the new findings into the dsa
		InsertMasterFinisher($insertPrimer);	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//ReCalculate Values.
		$MasterIndex = getMasterIndex(); //Get Master index
		$sizeOfMasterIndex = count($MasterIndex); 
	
		
		
		
		//check to see if extra markets exist
		//for each listing in master list. Get new list.
		for ($i = 0; $i < $sizeOfMasterIndex; $i++) 
		{
		
			//Now run the currenc MasterListing with all the markets		
			for ($a = 0; $a < $MaxArray; $a++) 
			{
				//check to see if cuurentCurrency In Master Index 
				//Matches Current Currency In Market Data
				if ($MasterIndex[$i]['CurrCode'] == $marketData['return'][$a]['primary_currency_code']) 
				{ 
				
//Check to see if secondary market, matches the MasterIndex's secondary market. 
if ($MasterIndex[$i]['Master1code'] != $marketData['return'][$a]['secondary_currency_code'])			
{
	//check for a match with second currency, is so, we dont need this. skip rest.
	if( $MasterIndex[$i]['Master2code'] != $marketData['return'][$a]['secondary_currency_code']){
		$done = 0;
		
		//check to see if this is open, if so add this info to master list.
		if($MasterIndex[$i]['Master2code'] == NULL) {
			$MasterIndex[$i]['Master2code'] = $marketData['return'][$a]['secondary_currency_code']; 
			$MasterIndex[$i]['Market2code'] = $marketData['return'][$a]['label'];
			$MasterIndex[$i]['M2ID'] = $marketData['return'][$a]['marketid'];
			$done = 1;
		}//if($MasterIndex[$i]['Master2code'] == NULL)
		
	//if were not done, we need to check third market.	
	if (!$done) {
		//check the third market, if we have a match skip, if not continue.
		if( $MasterIndex[$i]['Master3code'] != $marketData['return'][$a]['secondary_currency_code']){
	
			$done = 0;
	
			if($MasterIndex[$i]['Master3code'] == NULL) {
				$MasterIndex[$i]['Master3code'] = $marketData['return'][$a]['secondary_currency_code']; 
				$MasterIndex[$i]['Market3code'] = $marketData['return'][$a]['label'];
				$MasterIndex[$i]['M3ID'] = $marketData['return'][$a]['marketid'];
				$done = 1;
				}//if($MasterIndex[$i]['Master3code'] == NULL)
		
		
			//if not done check the forth market
			if (!$done) {
					//insert this value into the fourth market. 
					$MasterIndex[$i]['Master4code'] = $marketData['return'][$a]['secondary_currency_code']; 
					$MasterIndex[$i]['Market4code'] = $marketData['return'][$a]['label'];
					$MasterIndex[$i]['M4ID'] = $marketData['return'][$a]['marketid']; 
				}//End if (!$done) {	
		}

	}//if (!$done)
}//if ($MasterIndex[$i]['Master1code'] 
}
				
				
		}//if ($MasterIndex[$i]['CurrCode'] == $marketData['return'][$a]['primary_currency_code']) 
	}//for ($a = 0; $a < $MaxArray; $a++) 
}//for ($i = 0; $i < $sizeOfMasterIndex; $i++) 


UpdateMasterPrimer($MasterIndex);


}


		
		



//CheckOpportunities Function
function UpdateDataBase($marketData, $tempPoll) {
global $db;
$db = new mysqli("localhost", "root", "", "trading");
$TempPoll = $tempPoll;
	echo "Echo Base";
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
	$maketablequery = 	"CREATE TABLE IF NOT EXISTS {$month} (
						  ID INT(11) AUTO_INCREMENT,
						  PRIMARY KEY(ID),
						  Poll INT,
						  Lasthigh DOUBLE,
						  Lastlow DOUBLE,
						  Lasttrade DOUBLE,
						  Avgone DOUBLE,
						  Avgtwo DOUBLE,
						  Avgthree DOUBLE  )";
		
    $db->query($maketablequery) or die ("it just doesn't work");
	}
	
	
	foreach($marketTables as $month) 
	{
	$query = "INSERT INTO $month 
	(Poll, Lasthigh, Lastlow, Lasttrade) VALUES(
	'1', $TempLastHigh, $TempLastLow,	$TempLastTrade)";
		
    $db->query($query) or die ("it just doesn't work");
	}
	//insert values.
	
	//insert avgs

	
	


	//getpollnumber
	//We now know we have the currcode 	and the market id within the list. 
	//we now check to see if a table exist for that currency and market. 
	//CheckCreateCMTable($TempLabel);
	
	//$tempAvg1 = getAvgs(1); 
	//$tempAvg2 = getAvgs(2); 
	//$tempAvg3 = getAvgs(3); 
		
		
	//InsertIndexCM($TempLabel, $TempPoll, $TempLastHigh, $TempLastLow,
					// $TempLastTrade, $tempAvg1, $tempAvg2, $tempAvg3); 
		

	
	//NEXT
	//Take first Currency, Check to see if it exist in other market
	//first well grab the master index and find its size
	//CurrCode , LongName , Master1code , M1ID , Market1code
	//create a table for each.

	
	
	

	




//CheckCreateMasterTable();
$marketData = getMarketData();
//solidifyMasterList($marketData);
//CheckCreateCogTable();
echo"Hi google";
//$temppoll = getPoll();
//$t = $temppoll;
//insertCog(++$t);
//UpdateDataBase($marketData, 1);
getrest($marketData);












function getrest($marketData) {
	echo "still here";
		$MasterIndex = getMasterIndex(); //Get Master index
		$sizeOfMasterIndex = count($MasterIndex); 
		
		for($i = 0; $i < $sizeOfMasterIndex; $i++) 
		{
			$marketTables[] = $MasterIndex[$i]['LongName'];
	
			
		}
	
	
	foreach($marketTables as $month) 
	{
	$query = "CREATE TABLE IF NOT EXISTS '$month' (
		  ID int(11) AUTO_INCREMENT, PRIMARY KEY(ID),
		  M1toM2 DOUBLE, M1toM3 DOUBLE, M1toM4 DOUBLE,
		  M2toM1 DOUBLE, M2toM3 DOUBLE, M2toM4 DOUBLE,
		  M3toM1 DOUBLE, M3toM2 DOUBLE, M3toM4 DOUBLE,
		  M4toM1 DOUBLE, M4toM2 DOUBLE, M4toM3 DOUBLE,
		  
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
		
    $db->query($query) or die ("it just doesn't work");
	}
	
	
}



































function getMymoney() {

	//get first market. 
for ($i = 0; $i < $sizeMasterIndex; $i++);
{
	//generate table name for currency
    $tempcmTablename = $masterIndex[$i]['LongName'];
	CheckCreateCurrencyOps($tempcmTablename);	
	//we ask to see if current currncy master code exist.
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
			$SlaveValueInMarket1 = GetLastTrade($tSlaveMarketcode1);
			$SlaveValueInMarket2 = GetLastTrade($tSlaveMarketcode2);



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
	
}
}

	//Get LastTrade Value in MARKET2

	//Subtract SecondPerValue from FirstPerValue
	//Get FirstMarketAdvantageValue
	//Get FirstMarketAdvantagePercentage
	//Store Values IN currency Ops and compile new avgs

//End Function UpdateDataBase

	

//checkDB();
//CheckCreateMasterTable();



?>
