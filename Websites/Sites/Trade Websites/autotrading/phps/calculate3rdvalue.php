<?php 
//get 3rd value




function get3rdvalue($back1, $b1sellprice, $sellamount1, $b1buyprice, $buyamount1, 
					 $back2, $b2sellprice, $sellamount2, $b2buyprice, $buyamount2, 
					 $currencyname, $backingcurrencies, $market1id, $market2id)
{

	
	$oparray = array();
	$oparray['currencyname'] = $currencyname;
	$oparray['back1'] = $back1;
	$oparray['b1sellprice'] = $b1sellprice;
	$oparray['b1sellvol'] = $sellamount1;
	$oparray['b1buyprice'] = $b1buyprice;
	$oparray['b1buyvol'] = $buyamount1;
	$oparray['market1id'] = $market1id;
	
	$oparray['back2'] = $back2;
	$oparray['b2sellprice'] = $b2sellprice;
	$oparray['b2sellvol'] = $sellamount2;
	$oparray['b2buyprice'] = $b2buyprice;
	$oparray['b2buyvol'] = $buyamount2;
	$oparray['market2id'] = $market2id;
	
	
	
	//$oparray['amountperback1'] = $b2price;
	//$oparray['amountperback2'] = $currencyname;
	
	$thirdvalue = 0;
	//if true the frist currency is btc
	if ($back1 === "BTC")
	{
		if ($back2 === "LTC")
		{
			//get the value of litecoin against btc
			 $ltcbtcvalue = $backingcurrencies["litecoin"][0]["lastbuybid"];
			 
			 //how many back1 values are in $valueofback2inback1market 
			 //(ltc/btc) / (dogecoin/btc) =  $amountofback1inback2;
			 $coinperltcbtc = $ltcbtcvalue / $b1sellprice;
			 
			 //how many doges per base currency 
			 $dogeperltc = 1 / $b2sellprice;
			 
			 $pass = "fail";
			 //find out if the last bid is less than the last sell
			 //find out if the last sell is more than last bid
			 if ($backingcurrencies["litecoin"][0]["lastbuybid"] <
			 		$backingcurrencies["litecoin"][0]["lastsellbid"])
				{
					
					 $pass = "pass";
				}
			
			$oparray['parentstatus'] = $pass;
			$oparray['amountperback1'] = $coinperltcbtc;
			$oparray['amountperback2'] = $dogeperltc;
			$oparray['parentprice'] = $ltcbtcvalue;
			$oparray['parentmarketid'] =  $backingcurrencies["litecoin"][0]["marketid"];
			$oparray['parentbuy']  = $backingcurrencies["litecoin"][0]["lastbuybid"] ;
			$oparray['parentsell'] =  $backingcurrencies["litecoin"][0]["lastsellbid"] ;
			
			
			
		}
		else if ($back2 === "XPM")
		{
			//get the value of xpm against btc
			$a =0;
			if ($backingcurrencies["primecoin"][0]["basecurrency"] === "BTC")
			{
				$a = 0;
			}else if ($backingcurrencies["primecoin"][1]["basecurrency"] === "BTC")
			{
				$a = 1;
			}
			
			
			 $xpmbtc = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			 
			 //how many back1 values are in $valueofback2inback1market 
			 //(ltc/btc) / (dogecoin/btc) =  $amountofback1inback2;
			 $dogeperxpmbtc = $xpmbtc / $b1sellprice;
			 
			 //how many doges per base currency 
			 $dogeperltc = 1 / $b2sellprice;
			 
			 
			  $pass = "fail";
			 //find out if the last bid is less than the last sell
			 //find out if the last sell is more than last bid
			 if ($backingcurrencies["primecoin"][$a]["lastbuybid"] <
			 		$backingcurrencies["primecoin"][$a]["lastsellbid"])
				{
					
					 $pass = "pass";
				}
			
			$oparray['parentstatus'] = $pass;
			 
			$oparray['amountperback1'] = $dogeperxpmbtc;
			$oparray['amountperback2'] = $dogeperltc;
			$oparray['parentprice'] = $xpmbtc;
			$oparray['parentmarketid'] =  $backingcurrencies["primecoin"][$a]["marketid"];
			$oparray['parentbuy']  = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			$oparray['parentsell'] =  $backingcurrencies["primecoin"][$a]["lastsellbid"] ;
			
		}
	
	
	}
	else if ($back1 === "LTC")
	{
		
		
		if ($back2 === "BTC")
		{
			
			//get the value of litecoin against btc
			 $valueltcbtc = $backingcurrencies["litecoin"][0]["lastbuybid"];
			 
			 //how many back1 values are in $valueofback2inback1market 
			 //(ltc/btc) / (dogecoin/btc) =  $amountofback1inback2;
			 $dogeperltcbtc = $valueltcbtc / $b2sellprice;
			 
			 //how many doges per base currency 
			 $dogeperltc = 1 / $b1sellprice;
			 
			 
			 
			 
			  $pass = "fail";
			 //find out if the last bid is less than the last sell
			 //find out if the last sell is more than last bid
			 if ($backingcurrencies["litecoin"][0]["lastbuybid"] <
			 		$backingcurrencies["litecoin"][0]["lastsellbid"])
				{
					
					 $pass = "pass";
				}
			
			$oparray['parentstatus'] = $pass;
			 
			 
			$oparray['amountperback1'] = $dogeperltc;
			$oparray['amountperback2'] = $dogeperltcbtc;
			$oparray['parentprice'] = $valueltcbtc;
			$oparray['parentmarketid'] =  $backingcurrencies["litecoin"][0]["marketid"];
			//this is the parent buy and sell price. 
			$oparray['parentbuy']  = $backingcurrencies["litecoin"][0]["lastbuybid"] ;
			$oparray['parentsell'] =  $backingcurrencies["litecoin"][0]["lastsellbid"] ;
			
		}
		else if ($back2 === "XPM")
		{
			//get the value of litecoin against btc
			$a =0;
			if ($backingcurrencies["primecoin"][0]["basecurrency"] === "LTC")
			{
				$a = 0;
			}else if ($backingcurrencies["primecoin"][1]["basecurrency"] === "LTC")
			{
				$a = 1;
			}
			
			
			 $valueofxpmltc = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			 
			 //how many back1 values are in $valueofback2inback1market 
			 //(ltc/btc) / (dogecoin/btc) =  $amountofback1inback2;
			 $dogeperltcbtc = $valueofxpmltc / $b1sellprice;
			 
			 //how many doges per base currency 
			 $dogeperltc = 1 / $b2sellprice;
			 
			 
			 
			 
			  $pass = "fail";
			 //find out if the last bid is less than the last sell
			 //find out if the last sell is more than last bid
			 if ($backingcurrencies["primecoin"][$a]["lastbuybid"] <
			 		$backingcurrencies["primecoin"][$a]["lastsellbid"])
				{
					
					 $pass = "pass";
				}
			
			$oparray['parentstatus'] = $pass;
			 
			$oparray['amountperback1'] = $dogeperltcbtc;
			$oparray['amountperback2'] = $dogeperltc;
			$oparray['parentprice'] = $valueofxpmltc;
			$oparray['parentmarketid'] =  $backingcurrencies["primecoin"][$a]["marketid"];
			//this is the parent buy and sell price. 
			$oparray['parentbuy']  = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			$oparray['parentsell'] =  $backingcurrencies["primecoin"][$a]["lastsellbid"] ;
			
			
		}
		
		
	}
	else if ($back1 === "XPM")
	{
		
		
		
		
		if ($back2 === "BTC")
		{
			//get the value of litecoin against btc
			$a =0;
			if ($backingcurrencies["primecoin"][0]["basecurrency"] === "BTC")
			{
				$a = 0;
			}else if ($backingcurrencies["primecoin"][1]["basecurrency"] === "BTC")
			{
				$a = 1;
			}
			
			
			 $valueofxpmbtc = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			 
			 //how many back1 values are in $valueofback2inback1market 
			 //(ltc/btc) / (dogecoin/btc) =  $amountofback1inback2;
			 $dogeperltcbtc = $valueofxpmbtc / $b2sellprice;
			 
			 //how many doges per base currency 
			 $dogeperltc = 1 / $b1sellprice;
			 
			 
			 
			   $pass = "fail";
			 //find out if the last bid is less than the last sell
			 //find out if the last sell is more than last bid
			 if ($backingcurrencies["primecoin"][$a]["lastbuybid"] <
			 		$backingcurrencies["primecoin"][$a]["lastsellbid"])
				{
					
					 $pass = "pass";
				}
			
			$oparray['parentstatus'] = $pass;
			 
			 
			$oparray['amountperback1'] = $dogeperltc;
			$oparray['amountperback2'] = $dogeperltcbtc;
			$oparray['parentprice'] = $valueofxpmbtc;
			$oparray['parentmarketid'] =  $backingcurrencies["primecoin"][$a]["marketid"];
			//this is the parent buy and sell price. 
			$oparray['parentbuy']  = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			$oparray['parentsell'] =  $backingcurrencies["primecoin"][$a]["lastsellbid"] ;
			
		}
		else if ($back2 === "LTC")
		{
			//get the value of litecoin xpm against its base currency. LTC
			$a =0;
			if ($backingcurrencies["primecoin"][0]["basecurrency"] === "LTC")
			{
				$a = 0;
			}else if ($backingcurrencies["primecoin"][1]["basecurrency"] === "LTC")
			{
				$a = 1;
			}
			
			
			 $valueofxpmltc = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			 
			 //how many back1 values are in $valueofback2inback1market 
			 //(ltc/btc) / (dogecoin/btc) =  $amountofback1inback2;
			 $dogeperltcbtc = $valueofxpmltc / $b2sellprice;
			 
			 //how many doges per base currency 
			 $dogeperltc = 1 / $b1sellprice;
			 
			 
			  $pass = "fail";
			 //find out if the last bid is less than the last sell
			 //find out if the last sell is more than last bid
			 if ($backingcurrencies["primecoin"][$a]["lastbuybid"] <
			 		$backingcurrencies["primecoin"][$a]["lastsellbid"])
				{
					
					 $pass = "pass";
				}
			
			$oparray['parentstatus'] = $pass;
			 
			 
			 
			$oparray['amountperback1'] = $dogeperltc;
			$oparray['amountperback2'] = $dogeperltcbtc;
			$oparray['parentprice'] = $valueofxpmltc;
			$oparray['parentmarketid'] =  $backingcurrencies["primecoin"][$a]["marketid"];
			//this is the parent buy and sell price. 
			$oparray['parentbuy']  = $backingcurrencies["primecoin"][$a]["lastbuybid"] ;
			$oparray['parentsell'] =  $backingcurrencies["primecoin"][$a]["lastsellbid"] ;
			
		}
		
		
		
		
		
		
	}

return $oparray;
}



?>