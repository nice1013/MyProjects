<?php
include("calculate3rdvalue.php");
include("stockcheck.php");

//get the post btc amount for each currency
//1)btc cap represents the total amount of btc needed to feul the program
$btccap = .03;
$buyfee = .002;
$sellfee = .003;

if(isset($_POST['btccap']))
{
$btccap = $_POST['btccap'];
}



$db = new mysqli("localhost", "root", "", "autotrading");
$tablenames = array();


//2)We also need to pull the data from our servers so we know how many 
//different currencies we need to buy
//get the table names [the names of all the currencies]
$q = "SHOW TABLES FROM autotrading";
//query and insert into result array
$result = $db->query($q);
//fetch all rows and insert into array
$t = mysqli_fetch_all($result, MYSQL_NUM);
//count and insert the names of the tables into a more managable array
for ($i=0; $i < count($t); $i++)
{
	$tablenames[] = $t[$i][0];
}

//holds all data
$Data = array();
//holds the names of the markets with 
//multiple markets
$Tableswithmultiplemarkets = array();
//holds the markets that will provide arbritrage
$backingcurrencies = array();


//for each table name. get the values of their tables
foreach ($tablenames as $tablename)
{

	$getdata = "SELECT * FROM $tablename";
	$result = $db->query($getdata);
	$temparray = mysqli_fetch_all($result, MYSQL_BOTH);
	//echo $temparray[0]["marketid"];
	
	
	//get base currencies, btc is not needed because btc is always base
	if ($tablename == "primecoin")
	{
		$backingcurrencies["primecoin"] = $temparray;
	}
	if ($tablename == "litecoin")
	{
		$backingcurrencies["litecoin"] = $temparray;
	}
	
	
	
	if (count($temparray) > 1)
	{
		//take the names of each table that does have 2 or more rows
		//insert them into array, and insert the entire array into the big array of array, ah okay.
		$Tableswithmultiplemarkets[] = $tablename;
		$Data[] = $temparray;
	}
	
		
}//end for loop 

$r = 0;
$arrayofbtc = array();
$arrayofltc = array();
	$btcplacement = "";
	$ltcplacement = "";
foreach ($Tableswithmultiplemarkets as $tablename)
{
	//Test echo for name of each currency in loop
	//echo $r."Name:".$tablename."<br />";
	
	$details = array();
	//we need to find where btc is in each currency.
	//If is in some currencies at all.  
	$btcplacement = "false";
	$ltcplacement = "false";
	$t = $Data[$r];
	//this for loop cycles through the base currencies looking for a btc match
	for ($p = 0; $p < count($t); $p++)
	{
		if (($Data[$r][$p]["basecurrency"] === "BTC") || ($Data[$r][$p]["basecurrency"] === "btc"))
		{
			//echo "This Slot: ". $p ."is This: ".$Data[$r][$p]["basecurrency"]." Market<br />";
			$btcplacement = $p;
		}
		
		if ($p + 1 >= count($t) &&  $btcplacement === "false")
		{
    //We are asking btcplacement if it null, if it is, it says that 
	//the previous for loop didn't find a match for bitcoin.
	//inst
			
			for ($p = 0; $p < count($t); $p++)
			{
				
			//check 
			if ($Data[$r][$p]["basecurrency"] === "LTC" || $Data[$r][$p]["basecurrency"] === "ltc")
			{
			//echo "Inside LTC: ". $btcplacement." Market<br />";
			//echo "This Slot: ". $p ."is This: ".$Data[$r][$p]["basecurrency"]." Market<br />";
				$ltcplacement = $p;
			}
			
			
			}
		
		
			
		}
	}
	

	
	
	
	//We need to insert all neccessary data into an array for purchasing
	//First we check to see if bitcoin price existed, if so
	//we will take the market id, the current sell price, and table name
	//By seperating the values into their own array, we can start splitting the money up and 
//determining how much coin of each we should actually be carrying.
	if ($ltcplacement === "false")
	{
		
		//the current table name 
		$details['name'] = $tablename;
		//get the market id 
		$details["marketid"] = $Data[$r][$btcplacement]["marketid"]; 
		//the current sell price 
		$details["price"] = $Data[$r][$btcplacement]["lastsellbid"]; 
		//The currency code
		$details["code"] = $Data[$r][$btcplacement]["code"]; 
		//The ordertype (buy or sell)
		$details["ordertype"] = "Buy";
		//whether it was btc or ltc value
		$details["base"] = "btc";
		$arrayofbtc[]  = $details;
	}
	else
	if ($btcplacement === "false")
	{
		//the current table name 
		$details['name'] = $tablename;
		//get the market id 
		$details["marketid"] = $Data[$r][$ltcplacement]["marketid"]; 
		//The currency code
		$details["code"] = $Data[$r][$ltcplacement]["code"]; 
		//The ordertype (buy or sell)
		$details["ordertype"] = "Buy";
		//the current sell price 
		$details["price"] = $Data[$r][$ltcplacement]["lastsellbid"]; 
		//whether it was btc or ltc value
		$details["base"] = "ltc";
		$arrayofltc[]  = $details;
		
	}
	
	//echo "NAME: ".$details[0]."Marketid: ".$details[1]."Price: ".$details[2]."Market: ".$details[3]."<br />";
	 unset($btcplacement);
	 unset($ltcplacement);
	$r++;
}

//We now have the array of ltc purchases we need to make along with the btc purchases we may 
//need to make
//So were going to count each of them so we can divy up the money
$sizeofbtc = count($arrayofbtc);
//and the ltc
$sizeofltc = count($arrayofltc);

//In order for arbritrage to be sucessful, there needs to be
//10 currency backing in the xpm market. 
//each currency get their own 3 parts, giving them a total 63 parts. 
//ltc needs to hold 20 parts
//btc needs to hold 20 parts
//Total parts is 10, 63, 20, 20 = 113
//Divide 113 by the amountofbtc 
$numberofpartsforcurrency = 2 * count($Tableswithmultiplemarkets);

$ltcparts = .33 * $numberofpartsforcurrency;
$btcparts = .33 * $numberofpartsforcurrency;
$xpmparts = .165 * $numberofpartsforcurrency;
$btcperpart = $btccap / ( $ltcparts + $btcparts + $xpmparts + $numberofpartsforcurrency);
$partspercurrency = $btcperpart *2;
echo "BTCperPart: ".$btcperpart."<br /><br /><br />";

//Now that we have how many btcoin per part we are supposed to have
//we can figure out how many coin are supposed to be in each balance.
//we do that, by taking out the currencyparts and seeing how many 
//coin we can buy at the currenct sell price.

for ($i=0; $i < count($arrayofbtc); $i++)
{
	//for each currency in the btc array,
	//Get amount we should have 
	//by, dividing partspercurrency by the sell price.
	//echo "Loop# : ".$i. "arrayofbtc :".$arrayofbtc[$i]['name']."<br />";
	$amountweshouldhave = ($partspercurrency - ($partspercurrency * $buyfee)) / $arrayofbtc[$i]['price'];
	$arrayofbtc[$i]["quantity"] = $amountweshouldhave;
	//echo "Amountweshouldhave: ".$amountweshouldhave."<br />";
	
}

for ($i=0; $i < count($arrayofltc); $i++)
{
	//for each currency in the btc array,
	//Get amount we should have 
	//by, dividing partspercurrency by the sell price.
	$ltcsellprice = $backingcurrencies["litecoin"][0]["lastsellbid"]; 
	$partspercurencyinltc = ($partspercurrency - ($partspercurrency * $buyfee)) / $ltcsellprice;
	//echo "Loop# : ".$i. "CoinName :".$arrayofltc[$i]['name']."<br />";
	$amountweshouldhave = ($partspercurencyinltc - ($partspercurencyinltc * $buyfee)) / $arrayofltc[$i]['price'];
	$arrayofltc[$i]["quantity"] = $amountweshouldhave;
	//echo "Amountweshouldhave: ".$amountweshouldhave."<br />";
	
}


//Now we are at the point where we need to compare
//our calaculations of what we should have, with what we actually have. 
//We'll ask crypsty for the current balances of our accounts.
$markets = api_query("getinfo");
//This is how we call an available balance
// echo $markets['return']['balances_available']['BTC'];



//this for loop will cycle through our array of bitcoin
//we will find the balance of each currency
for ($i=0; $i < count($arrayofbtc); $i++)
{
	//we take our current currency code and assign it to variable
	$tempcurrcode = $arrayofbtc[$i]['code'];
	//Echo TEST
	// "Currency : ".$tempcurrcode."<br />";
	//put our balace for this currency into a temp varaible	
	$cryptsybalance = $markets['return']['balances_available'][$tempcurrcode];
	//ECHO TEST
	//echo "Balance : ".$cryptsybalance."<br />";
	
	//We are checking to see if our balance is less than what our minimal balance 
	//should be. If at all yes, we
	if ($arrayofbtc[$i]["quantity"]  - $cryptsybalance > 0)
	{
		$arrayofbtc[$i]['confirm'] = 1;
		$arrayofbtc[$i]["quantity"] = $arrayofbtc[$i]["quantity"]  - $cryptsybalance ;
		//echo "Confirmed : ".$arrayofbtc[$i]['confirm']."<br />";
	}else
	{
		$arrayofbtc[$i]['confirm'] = 0;
		//echo "Confirmed : ".$arrayofbtc[$i]['confirm']."<br />";
	}
	
}

//We will have to purchase extra litecoin, in order to purchase 
//some currencies that don't exist in the btc market
$ltcextraparts = 0;
//this for loop will cycle through our array of bitcoin
//we will find the balance of each currency
for ($i=0; $i < count($arrayofltc); $i++)
{
	//we take our current currency code and assign it to variable
	$tempcurrcode = $arrayofltc[$i]['code'];
	//Echo TEST
	//echo "Currency : ".$tempcurrcode."<br />";
	//put our balace for this currency into a temp varaible	
	$cryptsybalance = $markets['return']['balances_available'][$tempcurrcode];
	//ECHO TEST
	//echo "Balance : ".$cryptsybalance."<br />";
	
	//We are checking to see if our balance is less than what our minimal balance 
	//should be. If at all yes, we add it to our ongoing array of ltc
	if ( $arrayofltc[$i]["quantity"]  - $cryptsybalance > 0)
	{
		$arrayofltc[$i]['confirm'] = 1;
		//echo "Confirmed : ".$arrayofltc[$i]['confirm']."<br />";
		$arrayofltc[$i]["quantity"] = $arrayofltc[$i]["quantity"]  - $cryptsybalance ;
		$ltcextraparts = $ltcextraparts + 2;
	}else
	{
		//echo "Confirmed : ".$arrayofltc[$i]['confirm']."<br />";
	}
	
}
 
//Get the ltc extraparts and add it with ltc parts. 
//Now we have how much litecoin we need to order.
$howmanylitecoinparts = $ltcparts + $ltcextraparts;
$howmuchbtctospendonltc = $btcperpart * $howmanylitecoinparts;
$markets['return']['balances_available']['LTC'];
$howmanyltcthatwillget = ($howmuchbtctospendonltc - ($howmuchbtctospendonltc * $buyfee)) / $backingcurrencies["litecoin"][0]['lastsellbid']; 
echo "How MUCH ltc To buy: " . $howmanyltcthatwillget;
//we have how much litecoin we have to buy 
//We will insert that as quantity in our a new array for purchasing.
$ltcorder = array();
$ltcorder["marketid"] = $backingcurrencies["litecoin"][0]['marketid'];
$ltcorder["ordertype"] ="buy";
$ltcorder["quantity"] =$howmanyltcthatwillget;
$ltcorder["price"]  = $backingcurrencies["litecoin"][0]['lastsellbid'];
var_dump($ltcorder);




//now we have to calculate how much xpm to purchase; 
$xpmorder = array();
$howmuchbtctospend = $btcperpart * $xpmparts;
$howmanyxpmthatwillget = ($howmuchbtctospend - ($howmuchbtctospend * $buyfee)) / $backingcurrencies["primecoin"][0]['lastsellbid']; 
$xpmorder["marketid"] = $backingcurrencies["primecoin"][0]['marketid'];
$xpmorder["ordertype"] ="buy";
$xpmorder["quantity"] =$howmanyxpmthatwillget;
$xpmorder["price"]  = $backingcurrencies["primecoin"][0]['lastsellbid'];
var_dump($xpmorder);






var_dump($result);

for ($i=0; $i < count($arrayofbtc); $i++)
{
	$temporder = $arrayofbtc[$i];
	
	$result = api_query("createorder", $temporder);
}

for ($i=0; $i < count($arrayofltc); $i++)
{
	$temporder = $arrayofltc[$i];
	
	$result = api_query("createorder", $temporder);
}

	

?>