<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript" src="jquery-1.7.2.js"> </script>
<head>
<meta http-equiv="Refresh" content="20">
<link rel="stylesheet" type="text/css" href="index.css" />

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

/*
CheckCreateMasterTable();
$marketData = getMarketData();
solidifyMasterList($marketData);
UpdateDataBase($marketData, 1);
getrest($marketData);
calculatestuff();
*/











	


/*
$avg = "SELECT avg(CASE WHEN Lasttrade = 0 THEN NULL ELSE Lasttrade END) FROM DogEbtc
			 ORDER BY ID DESC limit 0, 5";
		echo "<br /><br />QUERY:" .$avg;
		

$result = $db->query($avg) or die ("avg t1 ");
$returnm2m = mysqli_fetch_array($result, MYSQLI_NUM);
*/

//createAvgs();
//createTradeAvgs();

//$avg = getAvgsOps ($amount, $WhichAvg, $table)

function createTradeAvgs() {
	$db = new mysqli("localhost", "root", "", "trading");
	$masterindex = getMasterIndex();
	$sizeofmasterindex = count($masterindex);	
	//list to hold name of markets and avgs
	$listofMarkets = array(array());
	$listofMarketnames = array();
	//create for loop to run through the masterindex array
	for($i = 0; $i < $sizeofmasterindex; $i++)
	{
		//get market one, combine with CurrCode (the code for currency)add to list of markets
		if($masterindex[$i]['Master1code'] != NULL)
		{
			$listofMarkets[][0] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master1code'];
			$listofMarketnames[] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master1code'];
		}
		//get market 2, combine with CurrCode (the code for currency)add to list of markets
		if($masterindex[$i]['Master2code'] != NULL)
		{
			$listofMarkets[][0] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master2code'];
			$listofMarketnames[] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master2code'];
		}
		//get market 3, combine with CurrCode (the code for currency) add to list of markets
		if($masterindex[$i]['Master3code'] != NULL)
		{
			$listofMarkets[][0] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master3code'];
			$listofMarketnames[] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master3code'];
		}
		//get market 4, combine with CurrCode (the code for currency) add to list of markets
		if($masterindex[$i]['Master4code'] != NULL)
		{
			$listofMarkets[][0] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master4code'];
			$listofMarketnames[] = $masterindex[$i]['CurrCode'] . $masterindex[$i]['Master4code'];
		}
		
	}
	//this var is for loop tracking in foreach
	$k = 0;
	
	
	
	//We have an anomily. We are capturing pointbtc and changing it to pointsbtc that is all. 
	//this for loop will now look for pointbtc
	
	$dontdothese = array();
	$sizeoflistofmarkets = count($listofMarketnames); 
	for ($w= 0; $w < $sizeoflistofmarkets; $w++) 
	{
	
		$tstring = $listofMarketnames[$w];
		if ($tstring == "PointBTC" ) 
		{
			echo $listofMarketnames[$w];
			$dontdothese[] = $w;
			echo ":" . $listofMarketnames[$w] .":";
			echo "sucess";
		}
		
	}
	
	$k = 0;
	//get the lasttrade for last 5 dea
	foreach($listofMarketnames as $month) 
	{
		//check for stupid points table
		$do = 1;
		for($m = 0; $m < count($dontdothese);	$m++)
		{
			if($dontdothese[$m] == $k){
			$do = 0;	
			}
			
		}
		  
		//  
		 $avg =  "SELECT * FROM $month ORDER BY ID DESC Limit 5";
			 echo "echo ".$k;
		echo "<br /><br />QUERY:" .$avg;
		
		
		
			if ($do == 1)
		{
		$result = $db->query($avg) or die ("avg t1 ");
		$returnm2m = mysqli_fetch_array($result, MYSQLI_BOTH);
		
		
		var_dump($returnm2m);
		
		$tize = count($returnm2m); 
		$tsum = 0;
		for ($y = 0; $y < $tize; $y++) 
		{
			echo "size:".$tize;
			echo "<br /><br />Whats in here". $returnm2m[0][$y]['Lasttrade'];
				$tsum = $tsum + $returnm2m[0][$y]['Lasttrade'];
			
		}
		
		
		
		
		
		
		$tavg = $tsum / $tize;
			
		
		
		$listofMarkets[$k][1] = $tavg ; 	
		}
		
		
		
	
		$k++;
	}
	
	
	
	
	
	
	
	//avg2
	$k = 0;
	foreach($listofMarketnames as $month) 
	{
		//check for stupid points table
		$do = 1;
		for($m = 0; $m < count($dontdothese);	$m++)
		{
			if($dontdothese[$m] == $k){
			$do = 0;	
			}
			
		}
		
		 $avg =  "SELECT * FROM $month  ORDER BY ID DESC LIMIT 25";
			 echo "echo ".$k;
		echo "<br /><br />QUERY:" .$avg;
		
		
		
			if ($do == 1)
		{
		$result = $db->query($avg) or die ("avg t2 ");
		$returnm2m = mysqli_fetch_array($result, MYSQLI_BOTH);
		
		
		$tize = count($returnm2m); 
		$tsum = 0;
		for ($y = 0; $y < $tize; $y++) 
		{
				echo "<br /><br />Whats in here". $returnm2m[$y]['Lasttrade'];
				$tsum = $tsum + $returnm2m[$y]['Lasttrade'];
		}
		
		
		
		
		
		
		$tavg = $tsum / $tize;
		$listofMarkets[$k][2] = $tavg; 	
		}
		echo "<br /><br />First Query.".$k.".".$listofMarkets[$k][1];
		echo "<br />First Query.".$k.".".$listofMarkets[$k][2];
		$k++;
	}
	
	
	
	//avg3
	$k = 0;
	foreach($listofMarketnames as $month) 
	{
		//check for stupid points table
		$do = 1;
		for($m = 0; $m < count($dontdothese);	$m++)
		{
			if($dontdothese[$m] == $k){
			$do = 0;	
			}
			
		}
		
		
		 $avg =  "SELECT * FROM $month  ORDER BY ID DESC LIMIT 50";
			 echo "echo ".$k;
		echo "<br /><br />QUERY:" .$avg;
		
		
		
			if ($do == 1)
		{
		$result = $db->query($avg) or die ("avg t3 ");
		$returnm2m = mysqli_fetch_array($result, MYSQLI_BOTH);
		
		
		$tize = count($returnm2m); 
		$tsum = 0;
		for ($y = 0; $y < $tize; $y++) 
		{echo "<br /><br />Whats in here". $returnm2m[$y]['Lasttrade'];
				$tsum = $tsum + $returnm2m[$y]['Lasttrade'];
			
		}
		
		
		
		
		
		
		$tavg = $tsum / $tize;
		$listofMarkets[$k][3] = $tavg; 	
		}
		$k++;
	}
	
	//insert into db
	$k = 0;
	foreach($listofMarketnames as $month) 
	{
	
	//check for stupid points table
		$do = 1;
		for($m = 0; $m < count($dontdothese);	$m++)
		{
			if($dontdothese[$m] == $k){
			$do = 0;	
			}
			
		}
		
			 
		$Avgone = round( $listofMarkets[$k][1], 12);
		$Avgtwo = round( $listofMarkets[$k][2], 12);
		$Avgthree = round( $listofMarkets[$k][3], 12);	 
		
			 
		$query = "UPDATE  $month  SET
		Avgone =  $Avgone, Avgtwo =  $Avgtwo, Avgthree = $Avgthree
		ORDER BY ID DESC LIMIT 1";
		
		
			 echo "<br /><br /><br /><br /><br /><br /><br /><br />echo ".$query;
		
		if ($do == 1)
		{
		$result = $db->query($query) or die ("insert ");
		}
		$k++;
	
	
	
	
	}
	
	
}















function createM2MAvgs()
{
	
	$db = new mysqli("localhost", "root", "", "trading");
	$masterindex = getMasterIndex();
	$sizeofmasterindex = count($masterindex);	
	$namesofcurrencytables = array();
	$holder = array();
	
	
	$avgArray = array(array());
	
	
	
	for($i = 0; $i < $sizeofmasterindex; $i++)
	{
		$temparray = array();
	
		$namesofcurrencytables[]  = $masterindex[$i]['LongName'];
		$avgArray[][0] =  $masterindex[$i]['LongName'] ;

		
	}
	
	$k = 0;
	$sizem2m;
	
	for($q = 0; $q < 12; $q++) 
	{
	$k = 0;
	switch ($q) {
	case 0:
	$column = "M1toM2";
	break;	
	case 1:
	$column = "M1toM3";
	break;	
	case 2:
	$column = "M1toM4";
	break;	
	
	case 3:
	$column = "M2toM1";
	break;	
	case 4:
	$column = "M2toM3";
	break;	
	case 5:
	$column = "M2toM4";
	break;	
	
	case 6:
	$column = "M3toM1";
	break;	
	case 7:
	$column = "M3toM2";
	break;	
	case 8:
	$column = "M3toM4";
	break;	
	
	case 9:
	$column = "M4toM1";
	break;	
	case 10:
	$column = "M4toM3";
	break;	
	case 11:
	$column = "M4toM2";
	break;	
		
	}
	//go through each currency and grab its average 5
	foreach($namesofcurrencytables as $month) 
	{
		$avg = "SELECT $column FROM $month
		 ORDER BY ID DESC limit 0, 5";
		$query = "SELECT * FROM $month ORDER BY ID DESC limit 0, 5"; 
	
    $result = $db->query($avg) or die ("avg 3234 ");
	$returnm2m = mysqli_fetch_array($result, MYSQLI_BOTH);
	
	$tize = count($returnm2m); 
	$tsum = 0;
	for ($y = 0; $y < $tize; $y++) 
	{echo "<br /><br />Whats in here". $returnm2m[$y]['Lasttrade'];
				$tsum = $tsum + $returnm2m[$y]['Lasttrade'];
		
	}
	
	
	
	
	
	$tavg = $tsum / $tize;
	
	$avgArray[$k][$q + 1] = $tavg; 	
		$k++;
	}}
	
	
	$k = 0;
	//put new avgs into their tables
	foreach($namesofcurrencytables as $month) 
	{
		
		
		 
		 //find out if values are null
		 for($r = 1; $r < 13; $r++) 
		 {
			if ($avgArray[$k][$r] == "  " || $avgArray[$k][$r] == "" || $avgArray[$k][$r] == NULL){
				$avgArray[$k][$r] = 0;
			}
			 
		 }
		 
		 $AvgM1toM2 = $avgArray[$k][1];
		  $AvgM1toM3 = $avgArray[$k][2]; 
		  $AvgM1toM4 = $avgArray[$k][3];
		$AvgM2toM1 = $avgArray[$k][4];
		 $AvgM2toM3 = $avgArray[$k][5];
		  $AvgM2toM4 = $avgArray[$k][6];
		$AvgM3toM1 = $avgArray[$k][7];
		 $AvgM3toM2 = $avgArray[$k][8];
		  $AvgM3toM4 = $avgArray[$k][9];
		$AvgM4toM1 = $avgArray[$k][10];
		 $AvgM4toM2 = $avgArray[$k][11];
		 $AvgM4toM3 = $avgArray[$k][12];
	
		//Insert row into the M2M table
		$query = "UPDATE  $month  SET
			   AvgM1toM2 =  $AvgM1toM2 , AvgM1toM3 =  $AvgM1toM3 , AvgM1toM4 =  $AvgM1toM4 ,
				AvgM2toM1 =  $AvgM2toM1 , AvgM2toM3 =  $AvgM2toM3 , AvgM2toM4 =  $AvgM2toM4,
				AvgM3toM1 =  $AvgM3toM1 , AvgM3toM2 =  $AvgM3toM2 , AvgM3toM4 =  $AvgM3toM4,
				AvgM4toM1 =  $AvgM4toM1 , AvgM4toM2 =  $AvgM4toM2 , AvgM4toM3 =  $AvgM4toM3
				ORDER BY ID DESC LIMIT 1";

		echo "query:<br /><br /><br />" . $query;
    	$db->query($query) or die ("avg 3234 ");
		$k++;
	}
}





?>







</head>

<body>

<?php
//get master list
$masterlist = getMasterIndex();


//collect names of currencys into a single array
//collect names of markets. 
$currencylist = array(); 
	for ($i = 0; $i < count($masterlist); $i++)
	{
	$currencylist[] = $masterlist[$i]['LongName'];	
		
	}

$resultarrayholder = array();
foreach ($currencylist as $currname)
{
$queryfordata = "SELECT * FROM $currname ORDER BY id DESC LIMIT 1";

	$result = $db->query($queryfordata) or die ("avg 3234 ");
	$resultarrayholder[] = mysqli_fetch_all($result, MYSQLI_ASSOC);
}




$lasttrades=array();
$o=0;
foreach ($currencylist as $currname)
{
	if ($masterlist[$o]['Master2code'] !== " " &&
		$masterlist[$o]['Master1code'] !== "" &&
		$masterlist[$o]['Master1code'] !== NULL)
	{
		
		if ($masterlist[$o]['Master2code'] !== "" &&
			 $masterlist[$o]['Master2code'] !== " " &&
			  $masterlist[$o]['Master2code'] !== NULL)
	{
		$market = array();
		$market[] = $masterlist[$o]['CurrCode'] . $masterlist[$o]['Master1code'];
		$market[] = $masterlist[$o]['CurrCode'] . $masterlist[$o]['Master2code'];
		
		$temparray = array();
		$y=0;
		foreach ($market as $marketn)
		{
		$queryfordata = "SELECT * FROM $marketn ORDER BY id DESC LIMIT 1";
		$result = $db->query($queryfordata) or die ("avg 3234 ");
		$temparra = mysqli_fetch_all($result, MYSQLI_ASSOC);
		if ($y == 0)
		$masterlist[$o]['Trademarket1'] = $temparra[0];
		if ($y == 1)
		$masterlist[$o]['Trademarket2'] = $temparra[0];
		
		$y++;
		}
		
	}else {$masterlist[$o]['Trademarket1'] = 'null';
			$masterlist[$o]['Trademarket2'] = 'null';}
	
	}
	
	$o++;
	
}





//display data
$o = 0;
foreach ($currencylist as $currname)
{
$t = trim($resultarrayholder[$o][0]['P2toP1']);
if (!($t == "null" )) {
		
		
	maketable($masterlist[$o]['LongName'],$resultarrayholder[$o][0]['M2toM1'],
	$resultarrayholder[$o][0]['AvgM2toM1'],$resultarrayholder[$o][0]['P2toP1'],$o, 
	$masterlist[$o]['M1ID'],$masterlist[$o]['M2ID'], $masterlist[$o]['Trademarket1']['Lasttrade'],
	$masterlist[$o]['Trademarket2']['Lasttrade'], $masterlist[$o]['Master1code'], $masterlist[$o]['Master2code'] );	
}





$o++;
}



function maketable($currcode, $m2m, $avgm2m, $p2p, $i, $m1id, $m2id, $m1lasttrade, $m2lasttrade, $m1, $m2) 
{
if ($m2m > 0)
{
$color1 = "#aaf";
$color2 = "#Faa";	
}else
{
$color1 = "#faa";
$color2 = "#aaf";
}
echo 
'<div style=" clear:both; width:100%;" class="currblock full" >
    
        <div id="markets">
           
		   	 <div style="width:50%; float:left;" class="market1">
					<div style="width:100px;" id="currname">
					<h2>'.$currcode.'</h2></div>
					
					
					<div style="width:50%; float:left;"class="m2m'.$i.'">
					<p style="width:auto;">GAIN:'. $m2m .'</p>
					</div>
					
					<div style="width:50%; float:right" class="avgm2m'.$i.'">
					<p style="width:auto;">AVG:'.$avgm2m.'</p>
					</div>
				
					<div style="width:100%; text-align:left; word-wrap: break-word;. clear:both;" class="p2p'.$i.'">
					<p>'.$p2p.'</p>
					</div>
					
           	 </div>
			
			 <div style="width:50%; float:right;" class="tradedetails">
                <table style="background:'.$color1.'; width:50%; float:left;">
                <tr><td><p>'.$m1.'</p></td><td></tr>
                <tr><td><p>'.$m1lasttrade.'</p></td></tr>
                <tr><td><p>'.$m1id.'</p></td></tr>
                <tr><td><input type="button" value="See Market" onclick="window.open(\'http://cryptsy.com/markets/view/'. $m1id.'\')" /></td></tr>
                </table>
                <table style=" background:'.$color2.'; width:50%; float:right;">
                <tr><td><p>'.$m2.'</p></td><td></tr>
                <tr><td><p> '.$m2lasttrade.'</p></td></tr>
                <tr><td><p>'.$m2id.'</p></td></tr>
                <tr><td><input type="button" value="See Market" onclick="window.open(\'http://cryptsy.com/markets/view/'. $m2id.'\')" /></td></tr>
                </table >
                
             
            </div>
			
        
    	</div> 
</div>';
}



?>





</body>
<?php

/*
CheckCreateMasterTable();
$marketData = getMarketData();
solidifyMasterList($marketData);
UpdateDataBase($marketData, 1);
getrest($marketData);
calculatestuff();
*/
?>
</html";
