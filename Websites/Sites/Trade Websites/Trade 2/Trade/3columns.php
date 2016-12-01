<?php 
//this holds the three columns for dogecoin. 
echo "<table id='column'><tr><td>LTC/BTC Market</td></tr>
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
<tr><td>Price</td><td>Doge</td><td>Volume(btc)</td></tr>";
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





echo "<table id='column'><tr><td>DOGE/BTC Market</td></tr>
<td><tr><td>SELL</td></tr>
<tr><td>Price</td><td>Doge</td><td>Volume(btc)</td></tr>";
$dogebtcsellprice = $dogebtc["return"]['sellorders'][0]['sellprice'];
$dogebtcsellquantity = $dogebtc["return"]['sellorders'][0]['quantity'];
$dogebtcselltotal = $dogebtc["return"]['sellorders'][0]['total'];
echo "<tr><td>$dogebtcsellprice</td><td>$dogebtcsellquantity</td><td>$dogebtcselltotal</td></tr>";
$price = $dogebtc["return"]['sellorders'][1]['sellprice'];
$quantity = $dogebtc["return"]['sellorders'][1]['quantity'];
$total = $dogebtc["return"]['sellorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $dogebtc["return"]['sellorders'][2]['sellprice'];
$quantity = $dogebtc["return"]['sellorders'][2]['quantity'];
$total = $dogebtc["return"]['sellorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";
echo "<td><tr><td>BUY</td></tr>
<tr><td>Price</td><td>Doge</td><td>Volume(btc)</td></tr>";
$dogebtcbuyprice = $dogebtc["return"]['buyorders'][0]['buyprice'];
$dogebtcbuyquantity = $dogebtc["return"]['buyorders'][0]['quantity'];
$dogebtcbuytotal = $dogebtc["return"]['buyorders'][0]['total'];
echo "<tr><td>$dogebtcbuyprice</td><td>$dogebtcbuyquantity</td><td>$dogebtcbuytotal</td></tr>";
$price = $dogebtc["return"]['buyorders'][1]['buyprice'];
$quantity = $dogebtc["return"]['buyorders'][1]['quantity'];
$total = $dogebtc["return"]['buyorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $dogebtc["return"]['buyorders'][2]['buyprice'];
$quantity = $dogebtc["return"]['buyorders'][2]['quantity'];
$total = $dogebtc["return"]['buyorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";
echo "</table>";



echo "<table id='column'><tr><td>DOGE/LTC Market</td></tr>
<td><tr><td>SELL</td></tr>
<tr><td>Price</td><td>Doge</td><td>Volume(ltc)</td></tr>";
$dogeltcsellprice = $dogeltc["return"]['sellorders'][0]['sellprice'];
$dogeltcsellquantity = $dogeltc["return"]['sellorders'][0]['quantity'];
$dogeltcselltotal = $dogeltc["return"]['sellorders'][0]['total'];
echo "<tr><td>$dogeltcsellprice</td><td>$dogeltcsellquantity</td><td>$dogeltcselltotal</td></tr>";
$price = $dogeltc["return"]['sellorders'][1]['sellprice'];
$quantity = $dogeltc["return"]['sellorders'][1]['quantity'];
$total = $dogeltc["return"]['sellorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $dogeltc["return"]['sellorders'][2]['sellprice'];
$quantity = $dogeltc["return"]['sellorders'][2]['quantity'];
$total = $dogeltc["return"]['sellorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>";
echo "<td><tr><td>BUY</td></tr>
<tr><td>Price</td><td>Doge</td><td>Volume(btc)</td></tr>";
$dogeltcbuyprice = $dogeltc["return"]['buyorders'][0]['buyprice'];
$dogeltcbuyquantity = $dogeltc["return"]['buyorders'][0]['quantity'];
$dogeltcbuytotal = $dogeltc["return"]['buyorders'][0]['total'];
echo "<tr><td>$dogeltcbuyprice</td><td>$dogeltcbuyquantity</td><td>$dogeltcbuytotal</td></tr>";
$price = $dogeltc["return"]['buyorders'][1]['buyprice'];
$quantity = $dogeltc["return"]['buyorders'][1]['quantity'];
$total = $dogeltc["return"]['buyorders'][1]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr>";
$price = $dogeltc["return"]['buyorders'][2]['buyprice'];
$quantity = $dogeltc["return"]['buyorders'][2]['quantity'];
$total = $dogeltc["return"]['buyorders'][2]['total'];
echo "<tr><td>$price</td><td>$quantity</td><td>$total</td></tr></td>
<tr><td colspan='3'><div id='placeholder' ></div></td></tr>";

echo "</table>";

?>