<?php
include("../stockcheck.php");
$marketid = "";

//check for input for a market if not call it a fail.
if(isset($_POST['marketid']))
{
$marketid = $_POST['marketid'];
}

if ($marketid != "") 
{
	$result = api_query("markettrades", array("marketid" => $marketid));
	//echo"<br><br>" . $result["return"][0]["tradeprice"];
	//var_dump($result);	
}
else 
{
		echo "Failed.<br>
		MarketID:".$marketid;	
}








if ($marketid != "") 
{
	$amounttoget = array(50, 200, 1000);
	$sum = array();
	$amountofsells = array();
	$amountofbuys = array();
	$arrayoftradesavgs = array(); 
	$Quanity =0;
	for ($i = 0; $i < count($amounttoget); $i++)
		{
		$amountofsells[$i] = 0;
		$amountofbuys[$i] = 0;
		$sum[$i] = 0;
		for ($p = 0; $p < $amounttoget[$i]; $p++)
			{
			$sum[$i] += $result["return"][$p]["tradeprice"];
			if ($result["return"][$p]["initiate_ordertype"] == "Sell")
			{
			$amountofsells[$i]++;
				
			}else { $amountofbuys[$i]++; }
			
			//this if statement will calculate the total quantity 
			//that moved in the last 1000 trades. 
			//we will used this further on down.
			if($amounttoget[$i] == 1000)
			$Quanity = $Quanity + $result["return"][$p]["quantity"];//the amount of item being sold
			
			}//end for loop $p
		$arrayoftradesavgs[$i] = number_format($sum[$i] / $amounttoget[$i], 12, '.', '');
		echo "<br><br>AVG TRADE:". $arrayoftradesavgs[$i];
		echo "<br><br>BUYS:". $amountofbuys[$i];
		echo "<br><br>SELLS:". $amountofsells[$i];
		}//$i end $i loop

	//finds the weighted avg
	$arrayofweightedsavgs = array();
	$weighted = 10;
	$percenttoweigh = .1;
	$weights = 0; //holds the number of extra values for weighted avgs
	$multinumbersum = 0;

	for ($i = 0; $i < count($amounttoget); $i++)
		{
			$sum[$i] = 0;
			$multinumbersum = 0;
			$ttopamount =  $amounttoget[$i] * $percenttoweigh;
			for ($p = 0; $p < $amounttoget[$i]; $p++)
			{
				$multinumber = 1;
				//check to see if current trade is less than the percent we want to weigh
				if ($p < $ttopamount)
				{
					//get the multinumber.
					$multinumber =  $weighted * (1 - ($p + 1) / $ttopamount);
					//accumulate the weights
					$weights = $weights + $multinumber - 1;					
				}
			
			$multinumbersum = $multinumbersum + $multinumber;
			$sum[$i] += $multinumber * $result["return"][$p]["tradeprice"];
			//echo "<br>WEIGHTS:".$weights;quantity
			}//end FOR loop $p
	
		echo "<br>AmountToGet:".$amounttoget[$i]."MultiNumberSum:".$multinumbersum;
		$arrayofweightedsavgs[$i] = number_format($sum[$i] / $multinumbersum, 12, '.', '');
		echo "<br><br>AVG TRADE:". $arrayofweightedsavgs[$i];
		echo "<br><br>BUYS:". $amountofbuys[$i];
		echo "<br><br>SELLS:". $amountofsells[$i];
		}//end for loop $i

	//find how much volumn move in last 1000 trades.
	$seconds = strtotime($result["return"][0]["datetime"]);
	$tradeonethousand = strtotime($result["return"][999]["datetime"]);
	$tradeone = strtotime($result["return"][0]["datetime"]);
	//timelaspe = is the amount of secounds that occured between first and last trade
	$timelaspe = $tradeone - $tradeonethousand;
	$minlaspe = ($timelaspe / 60);
	$volpermin = $Quanity / $minlaspe;
	echo "<br />tradeone:".$tradeone."<br /><br /><br />tradeonethousand:".$tradeonethousand;
	//end find how much volumn moved in the last 1000 trades



	//create a market table if needed
	$db = new mysqli("localhost", "root", "", "test");
	$markettablename = "market".$marketid;
	
	$create_table = "CREATE TABLE IF NOT EXISTS $markettablename
			  (id INT AUTO_INCREMENT, 
			  time BIGINT, PRIMARY KEY(time), volpermin DOUBLE, 
			  tradeavg1 DOUBLE, tradeavg2 DOUBLE, tradeavg3 DOUBLE, 
			  weightedavg1 DOUBLE, weightedavg2 DOUBLE, weightedavg3 DOUBLE, 
			  buys1 DOUBLE, buys2 DOUBLE, buys3 DOUBLE, 
			  sells1 DOUBLE, sells2 DOUBLE, sells3 DOUBLE
			  )";
		  
// Create student table
$create_tbl = $db->query($create_table);
//Insert Values into Mastter Table
$query = " 	INSERT IGNORE INTO $markettablename 
		(	 time, volpermin,
			 tradeavg1, tradeavg2, tradeavg3,
			 weightedavg1, weightedavg2, weightedavg3,
			 buys1, buys2, buys3,
			 sells1, sells2, sells3) 
			 VALUES
		(	 $seconds, $volpermin,
			 $arrayoftradesavgs[0], $arrayoftradesavgs[1], $arrayoftradesavgs[2],
			 $arrayofweightedsavgs[0], $arrayofweightedsavgs[1], $arrayofweightedsavgs[2],
			 $amountofbuys[0], $amountofbuys[1], $amountofbuys[2],
			 $amountofsells[0], $amountofsells[1], $amountofsells[2]
		  
		  )";
$result = $db->query($query);

$markettablename = "change".$marketid;
$create_table = "CREATE TABLE IF NOT EXISTS $markettablename
		  (id INT AUTO_INCREMENT, time BIGINT, PRIMARY KEY(time), volumn DOUBLE,
		  tradeavg1 DOUBLE, tradeavg2 DOUBLE, tradeavg3 DOUBLE, 
		  weightedavg1 DOUBLE, weightedavg2 DOUBLE, weightedavg3 DOUBLE, 
		  buys1 DOUBLE, buys2 DOUBLE, buys3 DOUBLE, 
		  sells1 DOUBLE, sells2 DOUBLE, sells3 DOUBLE
		  )";
$result = $db->query($create_table);

$query = "INSERT IGNORE INTO $markettablename (time) 
										VALUES
										($seconds)";

$db->query($query);



//create a table for 15min intervals called interval [marketnumber]
$markettablename = "interval".$marketid;
$create_table = "CREATE TABLE IF NOT EXISTS $markettablename
		  (id INT AUTO_INCREMENT, time BIGINT, PRIMARY KEY(time), volumn DOUBLE,
		  tradeavg1 DOUBLE, tradeavg2 DOUBLE, tradeavg3 DOUBLE, 
		  weightedavg1 DOUBLE, weightedavg2 DOUBLE, weightedavg3 DOUBLE, 
		  buys1 DOUBLE, buys2 DOUBLE, buys3 DOUBLE, 
		  sells1 DOUBLE, sells2 DOUBLE, sells3 DOUBLE
		  )";
$result = $db->query($create_table);



//create a table for 15min interval legacy table to keep track of all history called interval [marketnumber]
$markettablename = "intervallegacy".$marketid;
$create_table = "CREATE TABLE IF NOT EXISTS $markettablename
		  (id INT AUTO_INCREMENT, time BIGINT, PRIMARY KEY(time), volumn DOUBLE,
		  tradeavg1 DOUBLE, tradeavg2 DOUBLE, tradeavg3 DOUBLE, 
		  weightedavg1 DOUBLE, weightedavg2 DOUBLE, weightedavg3 DOUBLE, 
		  buys1 DOUBLE, buys2 DOUBLE, buys3 DOUBLE, 
		  sells1 DOUBLE, sells2 DOUBLE, sells3 DOUBLE
		  )";
$result = $db->query($create_table);

//create a table for daily table to keep track of all history called interval [marketnumber]
$markettablename = "daily".$marketid;
$create_table = "CREATE TABLE IF NOT EXISTS $markettablename
		  (id INT AUTO_INCREMENT, time BIGINT, PRIMARY KEY(time), volumn DOUBLE,
		  tradeavg1 DOUBLE, tradeavg2 DOUBLE, tradeavg3 DOUBLE, 
		  weightedavg1 DOUBLE, weightedavg2 DOUBLE, weightedavg3 DOUBLE, 
		  buys1 DOUBLE, buys2 DOUBLE, buys3 DOUBLE, 
		  sells1 DOUBLE, sells2 DOUBLE, sells3 DOUBLE
		  )";
$result = $db->query($create_table);




$db->close();


}
?>