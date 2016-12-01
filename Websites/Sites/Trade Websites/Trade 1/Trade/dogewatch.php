<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css" />

    <script language="javascript" type="text/javascript" src="jquery.js"></script>
    <script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="master/jquery.flot.valuelabels"></script>
    <link rel="stylesheet" type="text/css" href="master/plot.css">
    <script language="javascript" type="text/javascript" src="master/jquery.flot.navigationControl"></script>

<script type="text/javascript">
<!--
cookieName="page_scroll"
expdays=365

// An adaptation of Dorcht's cookie functions.

function setCookie(name, value, expires, path, domain, secure){
    if (!expires){expires = new Date()}
    document.cookie = name + "=" + escape(value) + 
    ((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
    ((path == null) ? "" : "; path=" + path) +
    ((domain == null) ? "" : "; domain=" + domain) +
    ((secure == null) ? "" : "; secure")
}

function getCookie(name) {
    var arg = name + "="
    var alen = arg.length
    var clen = document.cookie.length
    var i = 0
    while (i < clen) {
        var j = i + alen
        if (document.cookie.substring(i, j) == arg){
            return getCookieVal(j)
        }
        i = document.cookie.indexOf(" ", i) + 1
        if (i == 0) break
    }
    return null
}

function getCookieVal(offset){
    var endstr = document.cookie.indexOf (";", offset)
    if (endstr == -1)
    endstr = document.cookie.length
    return unescape(document.cookie.substring(offset, endstr))
}

function deleteCookie(name,path,domain){
    document.cookie = name + "=" +
    ((path == null) ? "" : "; path=" + path) +
    ((domain == null) ? "" : "; domain=" + domain) +
    "; expires=Thu, 01-Jan-00 00:00:01 GMT"
}

function saveScroll(){ // added function
    var expdate = new Date ()
    expdate.setTime (expdate.getTime() + (expdays*24*60*60*1000)); // expiry date

    var x = (document.pageXOffset?document.pageXOffset:document.body.scrollLeft)
    var y = (document.pageYOffset?document.pageYOffset:document.body.scrollTop)
    Data=x + "_" + y
    setCookie(cookieName,Data,expdate)
}

function loadScroll(){ // added function
    inf=getCookie(cookieName)
    if(!inf){return}
    var ar = inf.split("_")
    if(ar.length == 2){
        window.scrollTo(parseInt(ar[0]), parseInt(ar[1]))
    }
}

// add onload="loadScroll()" onunload="saveScroll()" to the opening BODY tag

// -->
</script>
</head>

<body onload="loadScroll()" onunload="saveScroll()">

<?php 


//getmaster functions
include("master.php");
include("stockcheck.php");
include("tradeavgs.php");



$LT = array();
$LT1 = array();
$LT2 = array();
$lastTradeTimeArray = array();
$roc = array();
//create two arrays. One to hold the old value coming in. 
//and one to hold the new values
$arrayfornewvalues = array();
$arrayforoldvalues;


//Used to limit the number a results returned from getpostarray.
$max1 = 1000;
//these values of from the post form. 
$oldtimevalues = getpostarray("times", $max1);
$i = 0;
while (($i < count($oldtimevalues)) && ($i < $max1  ))
{
$lastTradeTimeArray[] = $oldtimevalues[$i];

if ($i > 0) {


$roc[] = 	(($oldtimevalues[$i] - $oldtimevalues[$i-1]) / $oldtimevalues[$i]);
	
}
$i++;	
} 


//Used to limit the number a results returned from getpostarray.
$max1 = 1000;
//these values of from the post form. 
$oldLTvalues = getpostarray("LT", $max1);
$i = 0;
while (($i < count($oldLTvalues)) && ($i < $max1  ))
{
$LT[] = $oldLTvalues[$i];
$i++;	
}


//Used to limit the number a results returned from getpostarray.
$max1 = 1000;
//these values of from the post form. 
$oldLTvalues = getpostarray("LT2", $max1);
$i = 0;
while (($i < count($oldLTvalues)) && ($i < $max1  ))
{
$LT1[] = $oldLTvalues[$i];
$i++;	
}


//Used to limit the number a results returned from getpostarray.
$max1 = 1000;
//these values of from the post form. 
$oldLTvalues = getpostarray("LT3", $max1);
$i = 0;
while (($i < count($oldLTvalues)) && ($i < $max1  ))
{
$LT2[] = $oldLTvalues[$i];
$i++;	
}
//end market direction prediction stuff




global $db;
$db = new mysqli("localhost", "root", "", "trading");





//$result = api_query("getinfo");
//doge/btc
$markets = array("marketid" => 132);
$dogebtc = api_query("marketorders",$markets );
//ltc/btc
$markets = array("marketid" => 3);
$ltcbtc = api_query("marketorders",$markets );
$markets = array("marketid" => 135);
$dogeltc = api_query("marketorders",$markets );


//get the the 3 columns for dogecoin.
include_once ("3columns.php");


echo "<div>";

echo "<br><table>";
$DOGEperLTCinBTC = $ltcbtcbuyprice / $dogebtcbuyprice;
echo "<tr><td>Buy VALUES used<td></tr>
<tr><td>LTCperBTC</td><td>" . 1 / $ltcbtcbuyprice . "</td></tr>
<tr><td>DOGEperBTC</td><td>" . 1 / $dogebtcbuyprice . "</td></tr>
<tr><td>DOGEperLTCinBTC</td><td>" . $DOGEperLTCinBTC . "</td></tr>
<tr><td>DOGEperLTC</td><td>" . 1 / $dogeltcbuyprice . "</td></tr>";
$temp = $DOGEperLTCinBTC - 1 / $dogeltcbuyprice ;
echo "<tr><td>Difference</td><td>" . $temp . "</td></tr>";
$whattosay = "";
if ($DOGEperLTCinBTC - 1 / $dogeltcbuyprice > 0) 
{
	$whattosay = "BUY in BTC";
}
else
{
	$whattosay = "BUY in LTC";
}

echo "<tr><td>Where to buy</td><td>".$whattosay ."</td></tr>
</table>";
$amountbought =  1 / $dogebtcbuyprice;
$calculatedfees = 1 / $dogebtcbuyprice * .002;
$amountbought = $amountbought - $calculatedfees;
echo "<table>
		<tr><td>Buy and Sell at Bid Values</td></tr>
		<tr>
			<td>1 bitcoin buys_ doge</td>
			<td>" . $amountbought . "</td>
			<td>@" . $dogebtcbuyprice . "</td>
		</tr>";
//calculate fees 
//get amount bought from last time, sell for current price, charge .002 we have our fee.
$calculatedfees = $amountbought * $dogeltcbuyprice  * .002;	
$amountbought = 	 $amountbought * $dogeltcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling Doge For LTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $dogeltcbuyprice . "</td>
		</tr>";

$calculatedfees = $amountbought * $ltcbtcbuyprice  * .002;	
$amountbought = 	 $amountbought * $ltcbtcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling LTC For BTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $ltcbtcbuyprice . "</td>
		</tr>";
		
		
		

echo "<table>";


echo "<br></table>";
$amountbought =  1 / $dogeltcbuyprice;
$calculatedfees = 1 / $dogeltcbuyprice * .002;
$amountbought = $amountbought - $calculatedfees;
echo "<table>
		<tr><td>Buy at Bid Values</td></tr>
		<tr>
			<td>1 LITEcoin buys_ doge</td>
			<td>" . $amountbought . "</td>
			<td>@" . $dogeltcbuyprice . "</td>
		</tr>";
//calculate fees 
//get amount bought from last time, sell for current price, charge .002 we have our fee.
$calculatedfees = $amountbought * $dogebtcbuyprice  * .002;	
$amountbought = 	 $amountbought * $dogebtcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling Doge For BTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $dogebtcbuyprice . "</td>
		</tr>";

//take bitcoin and sell for ltc
$calculatedfees = $amountbought / $ltcbtcbuyprice  * .002;	
$amountbought = 	 $amountbought / $ltcbtcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling BTC For LTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $ltcbtcbuyprice . "</td>
		</tr> ";
echo "<table>";


echo "</div> ";











$result = api_query("markettrades", array("marketid" => 135));
//echo"<br><br>" . $result["return"][0]["tradeprice"];
$MaxArray = max(array_map("count", $result));
$amounttoget = array(50, 250,1000);
$sum = 0;
$amountofsells = array();
$amountofbuys = array();
$arrayoftradesavgs = array(); 
for ($i = 0; $i < count($amounttoget); $i++)
{
	$amountofsells[$i] = 0;
	$amountofbuys[$i] = 0;
	$sum = 0;
	for ($p = 0; $p < $amounttoget[$i]; $p++){
		$sum += $result["return"][$p]["tradeprice"];
		if ($result["return"][$p]["initiate_ordertype"] == "Sell")
		{
		$amountofsells[$i]++;
			
		}else { $amountofbuys[$i]++; }
		
		
	}
	$arrayoftradesavgs[$i] = number_format($sum / $amounttoget[$i], 15, '.', '');
	echo "<br><br>AVG TRADE:". $arrayoftradesavgs[$i];
	echo "<br><br>BUYS:". $amountofbuys[$i];
	echo "<br><br>SELLS:". $amountofsells[$i];
}


if(count($LT) == 0)
{
	echo "<br>TESTLT1:".number_format($arrayoftradesavgs[0], 15, '.', '');
	$LT[] = number_format($arrayoftradesavgs[0], 15, '.', '');	
	$LT1[] =  number_format($arrayoftradesavgs[1], 15, '.', '');	
	$LT2[] =  number_format($arrayoftradesavgs[2], 15, '.', '');	
	$lastTradeTimeArray[] = $milliseconds = round(microtime(true) * 1000);
}
else
{
	if ($LT[count($LT) - 1] != $arrayoftradesavgs[0]) 
	{	$LT[] =  number_format($arrayoftradesavgs[0], 15, '.', '');
		$LT1[] =  number_format($arrayoftradesavgs[1], 15, '.', '');	
		$LT2[] =  number_format($arrayoftradesavgs[2], 15, '.', '');	
		$lastTradeTimeArray[] = $milliseconds = round(microtime(true) * 1000);
	}
		
}


echo "
<form name='myform' action='dogewatch.php' method='post'>
<input type='hidden' name='LT' value='". base64_encode(serialize($LT )) . "' />
<input type='hidden' name='LT2' value='". base64_encode(serialize($LT1)) . "' />
<input type='hidden' name='LT3' value='". base64_encode(serialize($LT2 )) . "' />
<input type='hidden' name='times' value='". base64_encode(serialize($lastTradeTimeArray)) . "' />
</form>
";

?>












   <?php
   			$data = array();
			$data1 = array();
			$data2 = array();
			var_dump($LT);
			var_dump($lastTradeTimeArray);
			if (count($LT) >0 )
			{
				
			for ($i = 0; $i < count($LT); $i++)
			{
				$data[] = array($lastTradeTimeArray[$i], number_format($LT[$i], 15, '.', ''));
				$data1[] = array($lastTradeTimeArray[$i], number_format($LT1[$i], 15, '.', ''));
				$data2[] = array($lastTradeTimeArray[$i], number_format($LT2[$i], 15, '.', ''));
			}
			}
			else 	
			{
				$array = array(.00000028, .00000032, .00000045, .00000051, .00000039, .00000021);
				$times = array(1,2,3,4,5,6);
						for ($i = 0; $i < count($array); $i++)
						{
							$data[] = array($times[$i], number_format($array[$i], 15, '.', ''));
						}
						
			}
			
		
			?>
        
           <script>
		   var clickedItems = [];
    var d = [{   label: "Fake!",
        data: [[1290802154, 0.3], [1292502155, 0.1]]}];
		
		var obj = <?php echo json_encode($data);?>;
		var obj1 = <?php echo json_encode($data1);?>;
		var obj2 = <?php echo json_encode($data2);?>;
		var dothis = [{ label: "L50:",
        				data: obj, 
						lines:{show:true}
						},
						{
						label: "L250:",
        				data: obj1, 
						lines:{show:true}	
						},
						{
						label: "l1000:",
        				data: obj2, 
						lines:{show:true}	
						}	
					 ];
		 var options = {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
            }
        },
		legend:{position:'ne'},
		valueLabels: {
   		show: false
  		},
        grid: {
            hoverable: true,
            clickable: true
        },
		 zoom: {
            interactive: true
        },
        pan: {
            interactive: true
        },
        yaxis: {
            zoomRange: [0.1, 10],
            panRange: [-1, 11]
        },
		homeRange: {xmin:-10,xmax:10,ymin:-10,ymax:10},
    	panAmount: 100,
    	zoomAmount: 1.5,
    	position: {right: "20px", top: "20px"
		}
	 	
		
		 };
	
	
	
       $( document ).ready(function() {
 
		
		$.plot($("#placeholder"), dothis, options );
	 });
	 

	 function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.5
        }).appendTo("body").fadeIn(200);
    }
	 var previousPoint = null;
    $("#placeholder").bind("plothover", function(event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) {
            if (previousPoint != item.datapoint) {
                previousPoint = item.datapoint;

                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(15),
                    y = item.datapoint[1].toFixed(15),
                    //set default content for tooltip
                    content = item.series.label + y;
                
                // if there is a cached item object at this index use it instead
                if(clickedItems[item.dataIndex])
                    content = clickedItems[item.dataIndex].alternateText;
                //now show tooltip
                showTooltip(item.pageX, item.pageY, content);
            }
        }
        else {
            $("#tooltip").remove();
            previousPoint = null;
        }

    });
	 
	 
	 
	 
	 
        </script>



<script> 
window.onload=function(){ 
    window.setTimeout("redirect()", 15000);
    // OR
    window.setTimeout(function() { redirect(); }, 15000);
};

function redirect() {
    document.myform.submit();
}</script>

</body>
</html>
<?php
/*
$dogebtcbuyprice = $dogebtc["return"]['buyorders'][0]['buyprice'];
$dogebtcbuytotal = $dogebtc["return"]['buyorders'][0]['total'];
echo "<br>testvar1:" . $arrayforoldvalues[1] ;
echo "<br>testvar2:" . $dogebtcbuytotal ;
if ($arrayforoldvalues[1] != $dogebtcbuytotal)
{
	
	//check to see if it is the first time
	if (count($arrayforoldvalues) < 2)
	{
	$arrayfornewvalues[] = $dogebtcbuyprice;
	$arrayfornewvalues[] = $dogebtcbuytotal;
		}
	else 
	//check to see if it does indeed only have two slots.
	if(count($arrayforoldvalues) == 2)
	{
		//does it have the same value as the 
		if ($dogebtcbuyprice == $arrayforoldvalues[0] )
		{
			//if it does get the change value.
		$LT[] = $dogebtcbuytotal - $arrayforoldvalues[1]; 
		$arrayfornewvalues[] = $dogebtcbuyprice;
		$arrayfornewvalues[] = $dogebtcbuytotal;
		}else 
		{
			//since it doesnt we need to add it to the array to pass it on to the instance of this page.
			$arrayfornewvalues[] = $arrayforoldvalues[0];
			$arrayfornewvalues[] = $arrayforoldvalues[1];
			$arrayfornewvalues[] = $dogebtc["return"]['buyorders'][0]['buyprice'];
			$arrayfornewvalues[] = $dogebtc["return"]['buyorders'][0]['total'];
			
		}
	} 
	else 
	//we have 4 spots find the right number being used and calculate the difference. 
	//that means we had a change in bids.
	//we have to see if that was a permanent shift.
	//whatever is used here will now the only thing passed;
	if (count($arrayforoldvalues) > 2){
			//does the new price equal our old price
		if ($dogebtcbuyprice == $arrayforoldvalues[0])
		{
		$LT[] = $dogebtcbuytotal - $arrayforoldvalues[1]; 
		$arrayfornewvalues[] = $dogebtcbuyprice;
		$arrayfornewvalues[] = $dogebtcbuytotal;	
			
		}
		else
		if ($dogebtcbuyprice == $arrayforoldvalues[2])
		{
		$LT[] = $dogebtcbuytotal - $arrayfornewvalues[3]; 
		$arrayfornewvalues[] = $dogebtcbuyprice;
		$arrayfornewvalues[] = $dogebtcbuytotal;
		}
		
	}
}
*/
?>