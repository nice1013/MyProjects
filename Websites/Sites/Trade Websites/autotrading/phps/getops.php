<?php 

include("calculate3rdvalue.php");

$db = new mysqli("localhost", "root", "", "autotrading");
//show opportunities. 
$tablenames = array();
//get names of all tables








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
	
	
	



//array of currencies are now laid out one by one, 
//each of their tables are paired off into twos and sent to 3rd value calculators
//where they will return all the data that went into it and the percentages gained
$arrayofops = array();
$r = 0;
foreach ($Tableswithmultiplemarkets as $tablename)
{
	

	$buybid1= $Data[$r][0]["lastbuybid"];
	$buyamount1 = $Data[$r][0]["lastbuybidquanity"];
	$sellbid1 = $Data[$r][0]["lastsellbid"];
	$sellamount1 = $Data[$r][0]["lastsellbidquanity"];
	$basecurrency1 = $Data[$r][0]["basecurrency"];
	$market1id = $Data[$r][0]["marketid"];

	
	$buybid2 = $Data[$r][1]["lastbuybid"];
	$buyamount2 = $Data[$r][1]["lastbuybidquanity"];
	$sellbid2 = $Data[$r][1]["lastsellbid"];
	$sellamount2 = $Data[$r][1]["lastsellbidquanity"];
	$basecurrency2 = $Data[$r][1]["basecurrency"];
	$market2id = $Data[$r][1]["marketid"];


	$arrayofops[] = get3rdvalue($basecurrency1, $sellbid1, $sellamount1, 
								$buybid1, $buyamount1, $basecurrency2, 
								$sellbid2, $sellamount2,
								 $buybid2, $buyamount2, $tablename, $backingcurrencies, $market1id, $market2id);

	$t = $Data[$r];
	
	$size = count($t);
	if ($size > 2)
	{
		$buybid2 = $Data[$r][2]["lastbuybid"];
		$buyamount2 = $Data[$r][2]["lastbuybidquanity"];
		$sellbid2 = $Data[$r][2]["lastsellbid"];
		$sellamount2 = $Data[$r][2]["lastsellbidquanity"];
		$basecurrency2 = $Data[$r][2]["basecurrency"];	
		$market2id = $Data[$r][2]["marketid"];
		
	$arrayofops[] = get3rdvalue($basecurrency1, $sellbid1, $sellamount1, 
								$buybid1, $buyamount1, $basecurrency2, 
								$sellbid2, $sellamount2, $buybid2, $buyamount2, $tablename, $backingcurrencies, $market1id, $market2id);
	
		$buybid1= $Data[$r][1]["lastbuybid"];
		$buyamount1 = $Data[$r][1]["lastbuybidquanity"];
		$sellbid1 = $Data[$r][1]["lastsellbid"];
		$sellamount1 = $Data[$r][1]["lastsellbidquanity"];
		$basecurrency1 = $Data[$r][1]["basecurrency"];
		$market1id = $Data[$r][1]["marketid"];
		
		
		
	$arrayofops[] = get3rdvalue($basecurrency1, $sellbid1, $sellamount1, 
								$buybid1, $buyamount1, $basecurrency2, 
								$sellbid2, $sellamount2, $buybid2, $buyamount2, $tablename, $backingcurrencies, $market1id, $market2id);
		
	
	}//end if size > 2



//var_dump($arrayofops);

//echo $Data[$r][0]["marketid"];





$r++;
}//end for loop
$r = 0;

echo json_encode($arrayofops);





?>