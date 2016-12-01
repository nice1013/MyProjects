<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DogeWatch</title>
    <script language="javascript" type="text/javascript" src="jquery.js"></script>
    <script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="master/jquery.flot.valuelabels"></script>
    <link rel="stylesheet" type="text/css" href="master/plot.css">
    <script language="javascript" type="text/javascript" src="master/jquery.flot.navigationControl"></script>
</head>
<?php
include("stockcheck.php");

?>
<body>

<script type="text/javascript">
function getdetails(){
 var name = 132;
// var rno = $('#rno').val();
 $.ajax({
 type: "POST",
 url: "getmarkethistory.php",
 data: {marketid:name}
 }).done(function( result ) {
 //$("#msg").html( " This is everything "+result );
 });
}

function createmarketchange(){
 var name = 132;
// var rno = $('#rno').val();
 $.ajax({
 type: "POST",
 url: "createmarketchangetable.php",
 data: {marketid:name}
 }).done(function( result ) {
 //$("#msg").html( " This is everything "+result );
 });
}

function findmarketchange(){
 var name = 132;
// var rno = $('#rno').val();
 $.ajax({
 type: "POST",
 url: "findmarketchanges.php",
 data: {marketid:name}
 }).done(function( result ) {
	 //twoDArr = JSON.parse(result);
		//console.log(twoDArr);
//$("#msg").html( "waiting"+result);
 var obj = $.parseJSON(result);
   
  var newarray = new Array();
  var message = "";
  var length = obj.length - 1;
  var temparray = new Array();
  var holdvalue = 0;
  if (obj.length > 0)
  {
	  for (var i = 0; i < length ; i++)
	  {
		 temparray =  new Array();
		 holdvalue = 0;
		  //get trade to value. 
		  temparray.push(obj[i + 1]['id']);
		  //array 2 = change perecntage for volumn, volpermin
		  holdvalue = obj[i + 1]['volpermin'] -  obj[i]['volpermin'];
		  holdvalue = holdvalue / obj[i]['volpermin'];
		  temparray.push(holdvalue.toFixed(4));
		  //tradeavg1
		  holdvalue = obj[i + 1]['tradeavg1'] -  obj[i]['tradeavg1'];
		  holdvalue = holdvalue / obj[i]['tradeavg1'];
		  temparray.push(holdvalue.toFixed(4));
		  //tradeavg2
		  holdvalue = obj[i + 1]['tradeavg2'] -  obj[i]['tradeavg2'];
		  holdvalue = holdvalue / obj[i]['tradeavg2'];
		  temparray.push(holdvalue.toFixed(4));
		  //tradeavg3
		  holdvalue = obj[i + 1]['tradeavg3'] -  obj[i]['tradeavg3'];
		  holdvalue = holdvalue / obj[i]['tradeavg3'];
		  temparray.push(holdvalue.toFixed(4));
		  //weightedavg1
		  holdvalue = obj[i + 1]['weightedavg1'] -  obj[i]['weightedavg1'];
		  holdvalue = holdvalue / obj[i]['weightedavg1'];
		  temparray.push(holdvalue.toFixed(4));
		  //weightedavg2
		  holdvalue = obj[i + 1]['weightedavg2'] -  obj[i]['weightedavg2'];
		  holdvalue = holdvalue / obj[i]['weightedavg2'];
		  temparray.push(holdvalue.toFixed(4));
		  //weightedavg3
		  holdvalue = obj[i + 1]['weightedavg3'] -  obj[i]['weightedavg3'];
		  holdvalue = holdvalue / obj[i]['weightedavg3'];
		  temparray.push(holdvalue.toFixed(4));
		  //buys1
		  holdvalue = obj[i + 1]['buys1'] -  obj[i]['buys1'];
		  holdvalue = holdvalue / obj[i]['buys1'];
		  temparray.push(holdvalue.toFixed(4));
		  //buys2
		  holdvalue = obj[i + 1]['buys2'] -  obj[i]['buys2'];
		  holdvalue = holdvalue / obj[i]['buys2'];
		  temparray.push(holdvalue.toFixed(4));
		  //buys3
		  holdvalue = obj[i + 1]['buys3'] -  obj[i]['buys3'];
		  holdvalue = holdvalue / obj[i]['buys3'];
		  temparray.push(holdvalue.toFixed(4));
		  //sells1
		  holdvalue = obj[i + 1]['sells1'] -  obj[i]['sells1'];
		  holdvalue = holdvalue / obj[i]['sells1'];
		  temparray.push(holdvalue.toFixed(4));
		  //sells2
		  holdvalue = obj[i + 1]['sells2'] -  obj[i]['sells2'];
		  holdvalue = holdvalue / obj[i]['sells2'];
		  temparray.push(holdvalue.toFixed(4));
		  //sells3
		  holdvalue = obj[i + 1]['sells3'] -  obj[i]['sells3'];
		  holdvalue = holdvalue / obj[i]['sells3'];
		  temparray.push(holdvalue.toFixed(4));
		  
		  
		  newarray.push(temparray);
		  //$("#msg").html( "waiting2"+message);
		  
		  
		  /*
		  volpermin,
		  tradeavg1, tradeavg2, tradeavg3,
		weightedavg1, weightedavg2, weightedavg3,
				 buys1, buys2, buys3,
				 sells1, sells2, sells3) 
		  */
		  
	  }//end i loop for finding changes in market.
	  insertchangevalues(newarray);
  }
  //take this number here and loop with find change of rate for each thing and send all new rates of change
  //in with a second ajax code. 

  //$("#msg").html( "newarray"+newarray[0][3]);
  
   
 });
}

function insertchangevalues(inputdata){
 var name = 132;
 var inputdatastring = JSON.stringify(inputdata);
// var rno = $('#rno').val();
 $.ajax({
 type: "POST",
 url: "insertpercentages.php",
 data: {marketid: name,
 		inputarray: inputdatastring
 					}
 }).done(function( result ) {
// $("#msg").html( " This is everything "+result );
 });
}



function compilelegacy(){
 var name = 132;
// var rno = $('#rno').val();
 $.ajax({
 type: "POST",
 url: "updatelegacy.php",
 data: {marketid:name}
 }).done(function( result ) {
	
 $("#msg").html( " This is everything i know "+result );
 });
}

</script>



<div id="msg">yo</div>
<div id="result"></div>





<script type="text/javascript">
window.onload=function(){ 
    //window.setTimeout("redirect()", 1000);
    // OR
   //window.setTimeout(function() { compilelegacy() }, 3000);
//getdetails();
};


getdetails();
createmarketchange();
findmarketchange();
compilelegacy();


</script>


<!--
   <script language="javascript" type="text/javascript" src="createchart.js"></script>
             run the main function to create chart for market
   <script>main();</script>
-->
</body>
</html>