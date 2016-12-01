<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script language="javascript" type="text/javascript" src="phps/jquery.js"></script>
<script language="javascript" type="text/javascript" src="javascripts.js"></script>
<script language="javascript" type="text/javascript" src="phps/tradeagents.js"></script>

 <script>controldata = getops();</script>
<link rel="stylesheet" type="text/css" href="gtw.css" />

<?php
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
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Get to Work</title>
</head>
<body>
<div id="top"></div>
<div id="controlconsole" >
	<button id="tradebutton" onclick="switchtradestatus()">Trading is OFF</button>
	<div id="tradehandler"></div>
    <div id="arbhandle"></div>
	<div id="time"></div>
    <div id="clock"></div>
	<div id="amountpositive"></div>
</div>

<div id="resultholder">
<div id="result" ></div></div>
<script>
cantrade = 0 //var that tells whether or not the program is allowed to trade. DEFAULT = 0; no
timethathaspassed = 0;
time=0;
btcmaster = .25;
//used immediately to update data, 
//and trade prices
getmarketorders();


//trade("132", "sell", 1000, .00001);
//arbinsert("arb0002", "btcdogeltcbtc");
$( document ).ready(function() {
   
   //setInterval(function(){ arbinsert("arb0001", "btcdogeltcbtc", "open");},15000);
   
  createmasterarb();
  getops();
   setInterval(function(){tickupsecond()},1000);
   setInterval(function(){ticktime()},1000);
   setInterval(function(){createalltables();}, 100000); 
   setInterval(function(){getops()}, 10000);
   setInterval(function(){getmarketorders()}, 10000);
   setInterval(function(){dothings()}, 5000);
   setInterval(function(){settime(0)}, 10000);
   setInterval(function(){updatestatus()},20000);
  //setInterval(function(){alert(controldata[0]);}, 1000);
   
 });
function ticktime() {
time++;	
$("#time").html("Last Update:"+time)
}

function settime(a){
time = a;
}


function tickupsecond(){
timethathaspassed++;
$("#clock").html("TimeSinceLoaded:"+timethathaspassed)
}

function setseconds(a){
$("#clock").html("Last Update:"+time)
}


function setdata(a){
controldata = a;
}

function switchtradestatus()
{
	if(cantrade == 1)
	{cantrade = 0;
	$("#tradebutton").html("Trading is OFF"+cantrade);
	}
	else
	{cantrade = 1;
	$("#tradebutton").html("Trading is ON "+cantrade);
	}
}

function dothings() {
	//arbmanager("nothing");
	//commit trades dataarray of all possible ops and max btc value per trade
	//committrade(controldata, .0003);
	
	if(cantrade == 1)
	{
		
		committrade(controldata, .0003);
	}
	
	
	
}
//createalltables();
//getmarketorders();
//getops();
</script>

<?php
//get database info
$db = new mysqli("localhost", "root", "", "trading");

?>


</body>
</html>