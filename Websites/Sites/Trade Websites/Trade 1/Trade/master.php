<?php 


//This is for MasterList Function
//1.Check and Create Master Table
//Categories: Currency, long name, M1, M2, M3, M4,
function CheckCreateMasterTable() {
//get database info
$db = new mysqli("localhost", "root", "", "trading");
//create a queary to find a row from Master Table
//if here the table doesn't exist and
//we have to create a new one.

$create_table = "CREATE TABLE IF NOT EXISTS master
		  (ID INT AUTO_INCREMENT, PRIMARY KEY(ID),
		  CurrCode CHAR(5),
		  LongName CHAR(30),
		  Master1code CHAR(5),
		  Master2code CHAR(5),
		  Master3code CHAR(5),
		  Master4code CHAR(5),
		  M1ID CHAR(5),
		  M2ID CHAR(5),
		  M3ID CHAR(5),
		  M4ID CHAR(5),
		  Market1code  CHAR(10),
		  Market2code CHAR(10),
		  Market3code CHAR(10),
		  Market4code CHAR(10),
		  Poll INT
		  )";
		  
// Create student table
$create_tbl = $db->query($create_table);

}//End CheckCreateMasterTable()

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

	


function InsertMasterPrimer ($curr, $longcurr, $master1code, $m1ID, $Market1code, $oldinput) {
	
	if ($oldinput == "")
	{
	$new = "('$curr', '$longcurr' , '$master1code' , '$m1ID' , '$Market1code')";
	}else 
	{
	$new = $oldinput . ",('$curr', '$longcurr' , '$master1code' , '$m1ID' , '$Market1code')";
	}
	
	return $new;
}


function InsertMasterFinisher ($input) {


//get database info
$db = new mysqli("localhost", "root", "", "trading");
//Insert Values into Mastter Table
$query = "INSERT IGNORE INTO master (CurrCode, LongName, Master1code, M1ID, Market1code) VALUES $input ";

$result = $db->query($query);
if (!$result) {
   printf("%s\n", $db->error);
   exit();
}
}


//Function to insert a Index into the master list
//Quick Short List of Master Table
//CurrCode , LongName , Master1code , M1ID , Market1code
function InsertMasterIndex ($curr, $longcurr, $master1code, $m1ID, $Market1code) {
//get database info
$db = new mysqli("localhost", "root", "", "trading");
//check for table
CheckCreateMasterTable();
//Insert Values into Mastter Table
$query = "INSERT INTO master (CurrCode, LongName, Master1code, M1ID, Market1code) VALUES(
		  $curr, $longcurr, '$master1code', '$m1ID' , '$Market1code')";
$result = $db->query($query);
$db->close();
}//End InsetMasterIndexBasic



function UpdateMasterPrimer ($MasterIndex) {
	$db = new mysqli("localhost", "root", "", "trading");
	$size = count($MasterIndex);
	$quearyBuilder1 = "";
	
	for ($i = 0; $i < $size; $i++) 
	{
	$master1code = trim($MasterIndex[$i]['Master1code']);
	if ($master1code == "") $master1code = NULL;
	
	$m1ID = trim($MasterIndex[$i]['M1ID']);
	if ($m1ID == "") $m1ID = NULL;
	
	$Market1code = trim($MasterIndex[$i]['Market1code']);
	
	if ($Market1code == "") $Market1code = NULL;
	
	$master2code = trim($MasterIndex[$i]['Master2code']);
	if ($master2code == "") $master2code = NULL;
	
	$m2ID = trim($MasterIndex[$i]['M2ID']);
	if ($m2ID == "") $m2ID = NULL;
	
	$Market2code = trim($MasterIndex[$i]['Market2code']);
	if ($Market2code == "") $Market2code = NULL;
	
	$master3code = trim($MasterIndex[$i]['Master3code']);
	if ($master3code == "") $master3code = NULL;
	
	$m3ID = trim($MasterIndex[$i]['M3ID']);
	if ($m3ID == "") $m3ID = NULL;
	
	$Market3code = trim($MasterIndex[$i]['Market3code']);
	if ($Market3code == "") $Market3code = NULL;
	
	$master4code = trim($MasterIndex[$i]['Master4code']);
	if ($master4code == "") $master4code = NULL;
	
	$m4ID = trim($MasterIndex[$i]['M4ID']);
	if ($m4ID == "") $m4ID = NULL;
	
	$Market4code = trim($MasterIndex[$i]['Market4code']);
	if ($Market4code == "") $Market4code = NULL;
	
	$curr =  trim($MasterIndex[$i]['CurrCode']);
	
	
	$quearyBuilder1 =  "UPDATE master SET 
		M1ID = '$m1ID',
		Market1code = '$Market1code',
		Master1code = '$master1code',
		M2ID = '$m2ID',
		Market2code = '$Market2code',
		Master2code = '$master2code',
		M3ID = '$m3ID',
		Market3code = '$Market3code',
		Master3code = '$master3code',
		M4ID = '$m4ID',
		Market4code = '$Market4code',
		Master4code = '$master4code'
		  WHERE CurrCode = '$curr' ";
	
	

	
	
$result = $db->query($quearyBuilder1);

	}
$db->close();
		  
}

	





function UpdateMarketIndexAll($curr, 
$master1code, $m1ID, $Market1code,
$master2code, $m2ID, $Market2code,
$master3code, $m3ID, $Market3code,
$master4code, $m4ID, $Market4code)
{
	
//get database info
$db = new mysqli("localhost", "root", "", "trading");
$query = "UPDATE master SET 
		'Master1code' = '$master1code',
		'M1ID' = '$m1ID',
		'Market1code' = '$Market1code',
		'Master2code' = '$master2code',
		'M2ID' = '$m2ID',
		'Market2code' = '$Market2code',
		'Master3code' = '$master3code',
		'M3ID' = '$m3ID',
		'Market3code' = '$Market3code',
		'Master4code' = '$master4code',
		'M4ID' = '$m4ID',
		'Market4code' = '$Market4code',
		  WHERE  CurrCode = '$curr'";
		  
		  
		  
		  
		  

		  
$result = $db->query($query);

return $result;
	
}

//Quick Short List of Master Table
//CurrCode , LongName , Master1code , M1ID , Market1code
function getSingleIndex ($curr) {
//get database info
$db = new mysqli("localhost", "root", "", "trading");
//get all data from  master that has this currency
$query = "SELECT * FROM master WHERE CurrCode = '$curr'";
$result = $db->query($query);
}



//Quick Short List of Master Table
//CurrCode , LongName , Master1code , M1ID , Market1code
function getMasterIndex () {
//get database info
$db = new mysqli("localhost", "root", "", "trading");
$query = "SELECT * FROM master";
$result = $db->query($query);
$returnthismasterindex = mysqli_fetch_all($result, MYSQLI_ASSOC);
return $returnthismasterindex;
}

function getMasterIndexnum () {
//get database info
$db = new mysqli("localhost", "root", "", "trading");
$query = "SELECT * FROM master";
$result = $db->query($query);
$returnthismasterindex = mysqli_fetch_all($result, MYSQL_NUM);
return $returnthismasterindex;
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
				//echo $TempSlaveCurrCode . "<br />";
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








?>
