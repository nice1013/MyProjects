<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css" />
<meta http-equiv="Refresh" content="3">
</head>

<body>

<?php 
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



//$result = api_query("getinfo");
//CNC/btc
$markets = array("marketid" => 8);
$CNCbtc = api_query("marketorders",$markets );
//CNCltc market code
$markets = array("marketid" => 17);
$CNCltc = api_query("marketorders",$markets );
//ltc/btc
$markets = array("marketid" => 3);
$ltcbtc = api_query("marketorders",$markets );




echo "<table><tr><td>LTC/BTC Market</td></tr>
<tr><td>SELL</td></tr>
<tr><td>Price</td><td>LTC</td><td>Volume(btc)</td></tr>";
$ltcbtcsellprice = $ltcbtc["return"]['sellorders'][0]['sellprice'];
$ltcbtcsellquantity = $ltcbtc["return"]['sellorders'][0]['quantity'];
$ltcbtcselltotal = $ltcbtc["return"]['sellorders'][0]['total'];
echo "<tr><td>$ltcbtcsellprice</td><td>$ltcbtcsellquantity</td><td>$ltcbtcselltotal</td></tr>";
$price = $ltcbtc["return"]['sellorders'][1]['sellprice'];
$quantity = $ltcbtc["return"]['sellorders'][1]['quantity'];
$total = $ltcbtc["return"]['sellorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $ltcbtc["return"]['sellorders'][2]['sellprice'];
$quantity = $ltcbtc["return"]['sellorders'][2]['quantity'];
$total = $ltcbtc["return"]['sellorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
echo "<tr><td>BUY</td></tr>
<tr><td>Price</td><td>CNC</td><td>Volume(btc)</td></tr>";
$ltcbtcbuyprice = $ltcbtc["return"]['buyorders'][0]['buyprice'];
$ltcbtcbuyquantity = $ltcbtc["return"]['buyorders'][0]['quantity'];
$ltcbtcbuytotal = $ltcbtc["return"]['buyorders'][0]['total'];
echo "<tr><td>$ltcbtcbuyprice</td><td>$ltcbtcbuyquantity</td><td>$ltcbtcbuytotal</td></tr>";
$price = $ltcbtc["return"]['buyorders'][1]['buyprice'];
$quantity = $ltcbtc["return"]['buyorders'][1]['quantity'];
$total = $ltcbtc["return"]['buyorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $ltcbtc["return"]['buyorders'][2]['buyprice'];
$quantity = $ltcbtc["return"]['buyorders'][2]['quantity'];
$total = $ltcbtc["return"]['buyorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";

echo "</table>";







echo "<table><tr><td>CNC/BTC Market</td></tr>
<td><tr><td>SELL</td></tr>
<tr><td>Price</td><td>CNC</td><td>Volume(btc)</td></tr>";
$CNCbtcsellprice = $CNCbtc["return"]['sellorders'][0]['sellprice'];
$CNCbtcsellquantity = $CNCbtc["return"]['sellorders'][0]['quantity'];
$CNCbtcselltotal = $CNCbtc["return"]['sellorders'][0]['total'];
echo "<tr><td>$CNCbtcsellprice</td><td>$CNCbtcsellquantity</td><td>$CNCbtcselltotal</td></tr>";
$price = $CNCbtc["return"]['sellorders'][1]['sellprice'];
$quantity = $CNCbtc["return"]['sellorders'][1]['quantity'];
$total = $CNCbtc["return"]['sellorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $CNCbtc["return"]['sellorders'][2]['sellprice'];
$quantity = $CNCbtc["return"]['sellorders'][2]['quantity'];
$total = $CNCbtc["return"]['sellorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";
echo "<td><tr><td>BUY</td></tr>
<tr><td>Price</td><td>CNC</td><td>Volume(btc)</td></tr>";
$CNCbtcbuyprice = $CNCbtc["return"]['buyorders'][0]['buyprice'];
$CNCbtcbuyquantity = $CNCbtc["return"]['buyorders'][0]['quantity'];
$CNCbtcbuytotal = $CNCbtc["return"]['buyorders'][0]['total'];
echo "<tr><td>$CNCbtcbuyprice</td><td>$CNCbtcbuyquantity</td><td>$CNCbtcbuytotal</td></tr>";
$price = $CNCbtc["return"]['buyorders'][1]['buyprice'];
$quantity = $CNCbtc["return"]['buyorders'][1]['quantity'];
$total = $CNCbtc["return"]['buyorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $CNCbtc["return"]['buyorders'][2]['buyprice'];
$quantity = $CNCbtc["return"]['buyorders'][2]['quantity'];
$total = $CNCbtc["return"]['buyorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";

echo "</table>";




echo "<table><tr><td>CNC/LTC Market</td></tr>
<td><tr><td>SELL</td></tr>
<tr><td>Price</td><td>CNC</td><td>Volume(ltc)</td></tr>";
$CNCltcsellprice = $CNCltc["return"]['sellorders'][0]['sellprice'];
$CNCltcsellquantity = $CNCltc["return"]['sellorders'][0]['quantity'];
$CNCltcselltotal = $CNCltc["return"]['sellorders'][0]['total'];
echo "<tr><td>$CNCltcsellprice</td><td>$CNCltcsellquantity</td><td>$CNCltcselltotal</td></tr>";
$price = $CNCltc["return"]['sellorders'][1]['sellprice'];
$quantity = $CNCltc["return"]['sellorders'][1]['quantity'];
$total = $CNCltc["return"]['sellorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $CNCltc["return"]['sellorders'][2]['sellprice'];
$quantity = $CNCltc["return"]['sellorders'][2]['quantity'];
$total = $CNCltc["return"]['sellorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";
echo "<td><tr><td>BUY</td></tr>
<tr><td>Price</td><td>CNC</td><td>Volume(btc)</td></tr>";
$CNCltcbuyprice = $CNCltc["return"]['buyorders'][0]['buyprice'];
$CNCltcbuyquantity = $CNCltc["return"]['buyorders'][0]['quantity'];
$CNCltcbuytotal = $CNCltc["return"]['buyorders'][0]['total'];
echo "<tr><td>$CNCltcbuyprice</td><td>$CNCltcbuyquantity</td><td>$CNCltcbuytotal</td></tr>";
$price = $CNCltc["return"]['buyorders'][1]['buyprice'];
$quantity = $CNCltc["return"]['buyorders'][1]['quantity'];
$total = $CNCltc["return"]['buyorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $CNCltc["return"]['buyorders'][2]['buyprice'];
$quantity = $CNCltc["return"]['buyorders'][2]['quantity'];
$total = $CNCltc["return"]['buyorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";

echo "</table>";


echo "<div>";

echo "<br><table>";
$CNCperLTCinBTC = $ltcbtcbuyprice / $CNCbtcbuyprice;
echo "<tr><td>Buy VALUES used<td></tr>
<tr><td>LTCperBTC</td><td>" . 1 / $ltcbtcbuyprice . "</td></tr>
<tr><td>CNCperBTC</td><td>" . 1 / $CNCbtcbuyprice . "</td></tr>
<tr><td>CNCperLTCinBTC</td><td>" . $CNCperLTCinBTC . "</td></tr>
<tr><td>CNCperLTC</td><td>" . 1 / $CNCltcbuyprice . "</td></tr>";
$temp = $CNCperLTCinBTC - 1 / $CNCltcbuyprice ;
echo "<tr><td>Difference</td><td>" . $temp . "</td></tr>";
$whattosay = "";
if ($CNCperLTCinBTC - 1 / $CNCltcbuyprice > 0) 
{
	$whattosay = "BUY in BTC";
}
else
{
	$whattosay = "BUY in LTC";
}

echo "<tr><td>Where to buy</td><td>".$whattosay ."</td></tr>
</table>";
$amountbought =  1 / $CNCbtcbuyprice;
$calculatedfees = 1 / $CNCbtcbuyprice * .002;
$amountbought = $amountbought - $calculatedfees;
echo "<table>
		<tr><td>Buy and Sell at Bid Values</td></tr>
		<tr>
			<td>1 bitcoin buys_ CNC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $CNCbtcbuyprice . "</td>
		</tr>";
//calculate fees 
//get amount bought from last time, sell for current price, charge .002 we have our fee.
$calculatedfees = $amountbought * $CNCltcbuyprice  * .002;	
$amountbought = 	 $amountbought * $CNCltcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling CNC For LTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $CNCltcbuyprice . "</td>
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
$amountbought =  1 / $CNCltcbuyprice;
$calculatedfees = 1 / $CNCltcbuyprice * .002;
$amountbought = $amountbought - $calculatedfees;
echo "<table>
		<tr><td>Buy at Bid Values</td></tr>
		<tr>
			<td>1 LITEcoin buys_ CNC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $CNCltcbuyprice . "</td>
		</tr>";
//calculate fees 
//get amount bought from last time, sell for current price, charge .002 we have our fee.
$calculatedfees = $amountbought * $CNCbtcbuyprice  * .002;	
$amountbought = 	 $amountbought * $CNCbtcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling CNC For BTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $CNCbtcbuyprice . "</td>
		</tr>";

//take bitcoin and sell for ltc
$calculatedfees = $amountbought / $ltcbtcbuyprice  * .002;	
$amountbought = 	 $amountbought / $ltcbtcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling BTC For LTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $ltcbtcbuyprice . "</td>
		</tr> 
<tr><td><form action='trade2.php' method='post'>
<input type='text' name='yourname' /><br />
<p><input type='submit' value='Send it!'></p>
</form></td></tr>";
echo "<table>";


echo "</div> ";



?>


</body>
</html>