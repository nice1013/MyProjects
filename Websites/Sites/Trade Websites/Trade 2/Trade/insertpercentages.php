<?php
$marketid = "";
$inputdata;

//check for input for a market if not call it a fail.
if(isset($_POST['marketid']))
{
$marketid = $_POST['marketid'];
$inputdata = json_decode($_POST['inputarray'], true);
}

if ($marketid != "") 
{
$db = new mysqli("localhost", "root", "", "test");

$markettablename = "change".$marketid;

$sizeofarray = count($inputdata);
$holdtradetoidnumbers = array();

for ($i=0; $i < $sizeofarray; $i++)
{
	$holdtradetoidnumbers[] = $inputdata[$i][0];
}

$p = 0;
foreach ($holdtradetoidnumbers as $tradeto)
{

if ($inputdata[$p][1] != 0);
$volumn = $inputdata[$p][1];
$tradeavg1 = $inputdata[$p][2];
$tradeavg2= $inputdata[$p][3];
$tradeavg3=$inputdata[$p][4] ;
$weightedavg1=$inputdata[$p][5];
$weightedavg2=$inputdata[$p][6];
$weightedavg3=$inputdata[$p][7] ;
$buys1=$inputdata[$p][8] ;
$buys2=$inputdata[$p][9];
$buys3=$inputdata[$p][10] ;
$sells1=$inputdata[$p][11] ;
$sells2=$inputdata[$p][12];
$sells3=$inputdata[$p][13];


$query = "INSERT INTO $markettablename 
(
tradeto, volumn, 
 
tradeavg1, tradeavg2, tradeavg3,
weightedavg1, weightedavg2, weightedavg3, 

buys1, buys2, buys3,
sells1, sells2, sells3) 
VALUES
($tradeto, $volumn, 

$tradeavg1, $tradeavg2, $tradeavg3,
$weightedavg1, $weightedavg2, $weightedavg3,

$buys1, $buys2, $buys3,
$sells1, $sells2, $sells3)";
$db->query($query);
$p++;
}

}//end if 
	
	//$result = api_query("markettrades", array("marketid" => $marketid));
	//echo"<br><br>" . $result["return"][0]["tradeprice"];
	//var_dump($result);	
}
else 
{
		echo "Failed.<br>
		MarketID:".$marketid;	
}


?>