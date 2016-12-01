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
//quark/btc
$markets = array("marketid" => 71);
$quarkbtc = api_query("marketorders",$markets );
//quarkltc market code
$markets = array("marketid" => 126);
$quarkltc = api_query("marketorders",$markets );
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
<tr><td>Price</td><td>quark</td><td>Volume(btc)</td></tr>";
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







echo "<table><tr><td>quark/BTC Market</td></tr>
<td><tr><td>SELL</td></tr>
<tr><td>Price</td><td>quark</td><td>Volume(btc)</td></tr>";
$quarkbtcsellprice = $quarkbtc["return"]['sellorders'][0]['sellprice'];
$quarkbtcsellquantity = $quarkbtc["return"]['sellorders'][0]['quantity'];
$quarkbtcselltotal = $quarkbtc["return"]['sellorders'][0]['total'];
echo "<tr><td>$quarkbtcsellprice</td><td>$quarkbtcsellquantity</td><td>$quarkbtcselltotal</td></tr>";
$price = $quarkbtc["return"]['sellorders'][1]['sellprice'];
$quantity = $quarkbtc["return"]['sellorders'][1]['quantity'];
$total = $quarkbtc["return"]['sellorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $quarkbtc["return"]['sellorders'][2]['sellprice'];
$quantity = $quarkbtc["return"]['sellorders'][2]['quantity'];
$total = $quarkbtc["return"]['sellorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";
echo "<td><tr><td>BUY</td></tr>
<tr><td>Price</td><td>quark</td><td>Volume(btc)</td></tr>";
$quarkbtcbuyprice = $quarkbtc["return"]['buyorders'][0]['buyprice'];
$quarkbtcbuyquantity = $quarkbtc["return"]['buyorders'][0]['quantity'];
$quarkbtcbuytotal = $quarkbtc["return"]['buyorders'][0]['total'];
echo "<tr><td>$quarkbtcbuyprice</td><td>$quarkbtcbuyquantity</td><td>$quarkbtcbuytotal</td></tr>";
$price = $quarkbtc["return"]['buyorders'][1]['buyprice'];
$quantity = $quarkbtc["return"]['buyorders'][1]['quantity'];
$total = $quarkbtc["return"]['buyorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $quarkbtc["return"]['buyorders'][2]['buyprice'];
$quantity = $quarkbtc["return"]['buyorders'][2]['quantity'];
$total = $quarkbtc["return"]['buyorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";

echo "</table>";




echo "<table><tr><td>quark/LTC Market</td></tr>
<td><tr><td>SELL</td></tr>
<tr><td>Price</td><td>quark</td><td>Volume(ltc)</td></tr>";
$quarkltcsellprice = $quarkltc["return"]['sellorders'][0]['sellprice'];
$quarkltcsellquantity = $quarkltc["return"]['sellorders'][0]['quantity'];
$quarkltcselltotal = $quarkltc["return"]['sellorders'][0]['total'];
echo "<tr><td>$quarkltcsellprice</td><td>$quarkltcsellquantity</td><td>$quarkltcselltotal</td></tr>";
$price = $quarkltc["return"]['sellorders'][1]['sellprice'];
$quantity = $quarkltc["return"]['sellorders'][1]['quantity'];
$total = $quarkltc["return"]['sellorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $quarkltc["return"]['sellorders'][2]['sellprice'];
$quantity = $quarkltc["return"]['sellorders'][2]['quantity'];
$total = $quarkltc["return"]['sellorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";
echo "<td><tr><td>BUY</td></tr>
<tr><td>Price</td><td>quark</td><td>Volume(btc)</td></tr>";
$quarkltcbuyprice = $quarkltc["return"]['buyorders'][0]['buyprice'];
$quarkltcbuyquantity = $quarkltc["return"]['buyorders'][0]['quantity'];
$quarkltcbuytotal = $quarkltc["return"]['buyorders'][0]['total'];
echo "<tr><td>$quarkltcbuyprice</td><td>$quarkltcbuyquantity</td><td>$quarkltcbuytotal</td></tr>";
$price = $quarkltc["return"]['buyorders'][1]['buyprice'];
$quantity = $quarkltc["return"]['buyorders'][1]['quantity'];
$total = $quarkltc["return"]['buyorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $quarkltc["return"]['buyorders'][2]['buyprice'];
$quantity = $quarkltc["return"]['buyorders'][2]['quantity'];
$total = $quarkltc["return"]['buyorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";

echo "</table>";


echo "<div>";

echo "<br><table>";
$quarkperLTCinBTC = $ltcbtcbuyprice / $quarkbtcbuyprice;
echo "<tr><td>Buy VALUES used<td></tr>
<tr><td>LTCperBTC</td><td>" . 1 / $ltcbtcbuyprice . "</td></tr>
<tr><td>quarkperBTC</td><td>" . 1 / $quarkbtcbuyprice . "</td></tr>
<tr><td>quarkperLTCinBTC</td><td>" . $quarkperLTCinBTC . "</td></tr>
<tr><td>quarkperLTC</td><td>" . 1 / $quarkltcbuyprice . "</td></tr>";
$temp = $quarkperLTCinBTC - 1 / $quarkltcbuyprice ;
echo "<tr><td>Difference</td><td>" . $temp . "</td></tr>";
$whattosay = "";
if ($quarkperLTCinBTC - 1 / $quarkltcbuyprice > 0) 
{
	$whattosay = "BUY in BTC";
}
else
{
	$whattosay = "BUY in LTC";
}

echo "<tr><td>Where to buy</td><td>".$whattosay ."</td></tr>
</table>";
$amountbought =  1 / $quarkbtcbuyprice;
$calculatedfees = 1 / $quarkbtcbuyprice * .002;
$amountbought = $amountbought - $calculatedfees;
echo "<table>
		<tr><td>Buy and Sell at Bid Values</td></tr>
		<tr>
			<td>1 bitcoin buys_ quark</td>
			<td>" . $amountbought . "</td>
			<td>@" . $quarkbtcbuyprice . "</td>
		</tr>";
//calculate fees 
//get amount bought from last time, sell for current price, charge .002 we have our fee.
$calculatedfees = $amountbought * $quarkltcbuyprice  * .002;	
$amountbought = 	 $amountbought * $quarkltcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling quark For LTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $quarkltcbuyprice . "</td>
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
$amountbought =  1 / $quarkltcbuyprice;
$calculatedfees = 1 / $quarkltcbuyprice * .002;
$amountbought = $amountbought - $calculatedfees;
echo "<table>
		<tr><td>Buy at Bid Values</td></tr>
		<tr>
			<td>1 LITEcoin buys_ quark</td>
			<td>" . $amountbought . "</td>
			<td>@" . $quarkltcbuyprice . "</td>
		</tr>";
//calculate fees 
//get amount bought from last time, sell for current price, charge .002 we have our fee.
$calculatedfees = $amountbought * $quarkbtcbuyprice  * .002;	
$amountbought = 	 $amountbought * $quarkbtcbuyprice - $calculatedfees;
echo "	<tr>
			<td>Selling quark For BTC</td>
			<td>" . $amountbought . "</td>
			<td>@" . $quarkbtcbuyprice . "</td>
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