// JavaScript Document
function GenericPostAjax(id)
{
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	 $.ajax({
	 type: "POST",
	 url: "phpfunctions/getmarkethistory.php",
	 data: {marketid:id}
	 }).done(function( result ) {
	 //$("#msg").html( " This is everything "+result );
	 });	 
}//end get details


function createalltables()
{
	test = 0;
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	 $.ajax({
	 type: "POST",
	 url: "phps/createall.php",
	 data: {test:test}
	 }).done(function( result ) {
	//alert(result);
	 //$("#msg").html( " This is everything "+result );
	 });	 
}//end get details


function getmarketorders(){
	 test = 0;
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	 $.ajax({
	 type: "POST",
          url: 'phps/insertorders.php', // JQuery loads serverside.php
          data: {test:test}
	 }).done(function( result ) {
             
          
      });
}

function insertorderbook(data)
{
	var test=0;
	var orderbook = JSON.stringify(data);
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	 $.ajax({
		 async: false,
	 type: "POST",
	 url: "phps/insertorders.php",
	 data: {test:data, orders:orderbook},
	 }).done(function( result ) {
	 $("#msg").html( " This is everything "+result );
	
	 
	 });	
}


function getops()
{
	returnarray = new Array();
	test = 0;
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	 $.ajax({
	 type: "POST",
	 url: "phps/getops.php",
	 data: {test:test}
	 }).done(function( result ) {
	 var ops = $.parseJSON(result);
	 
	 
	
	 
	 
	 
	 
	 
	 
	 //initating table.
	 //tables will hold a string that is created dynamically in order to produce
	 //a table of data in html. Table is generated per currency, in a for loop.
	 var tables = "";
	 //tablesholder will hold a string. the string is generatad by the multiple tables 
	 //that are  tied together and placed in here for safekeeping and eventual to be displayed
	 //in html using .html
	 var tablesholder= "";
	 //Step 1 holds the first step to a arbritrage 
	 var Step1 = "";
	 //Step 2 holds the second step to a arbritrage
	 var Step2 = "";
	  //Step 3 holds the third step to a arbritrage
	 var Step3 = "";
	 var howitworks = "";
	 var fakebtc = .1;
	 var fee = .003;
	 var feebuydoge = .002;
	 var feeselldoge = .003;
	 for(i=0; i < ops.length; i++) 
	 {
	//this array will hold the value "buy" or "sell" and is then inserted into the ops currency
	var boyorsell = new Array(); 
	var priceguide = new Array(); 

	//there is a if statement for each back1 and back2 to seperate and analyse
	if(ops[i]['back1'] == "BTC")
	{
		//m1tom2
		//the amount of coin we are hypothetically going to buy.
		//Since back1 is btc we start with btc and this is our first m1tom2
		//We always buy in our first market first.
		buybtcamount = (fakebtc - (fakebtc * feebuydoge)) / ops[i]['b1sellprice'];
		Step1 = "STEP 1: Buy ["+buybtcamount+ "] "+
		//coin name + in the first market
		 ops[i]['currencyname'] +" in the "+ ops[i]['back1']+
		 //at a price of [what the price is] with [this much btc]
				" Market, at a price of ["+ ops[i]['b1sellprice'] +"], with ["+
				fakebtc +
				"] " +ops[i]['back1'] ;
		boyorsell.push("buy");		//insert buy value, so the gtw can know how to structure trade.
		priceguide.push(1);
		//In our ongoing example we will use doge to describe the family of coins
		//right now in our exmple we should have doge and we will sell it for ltcorxpm
		//depending on this coin's parent [doge]
		
		
		
		//Now we will sell the doge for the hypothetical ltc 
		//Ltc would be the second market so b2buyprice is used
		sellthisamount = buybtcamount;
		amounttorecieve = (sellthisamount * ops[i]['b2buyprice']) 
						- ((sellthisamount * ops[i]['b2buyprice']) * feeselldoge);
			//sell this much coin
		Step2 = "STEP 2: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['currencyname']+", in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['b2buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("sell");		
		priceguide.push(2);	
		//now we have ltc or xpm, we will sell that for btc, using the parentbuy value
				
				
		//We have ltc or xpm	
		//get the amount from step two, and assign it to sell this amount.	
		sellthisamount = amounttorecieve;
		//take sell this amount, apply it to the current buy price of the parent. 
		amounttorecieve = (sellthisamount * ops[i]['parentbuy']) 
						- ((sellthisamount * ops[i]['parentbuy']) * feeselldoge);
		//sell this much coin
		Step3 = 
				"STEP 3: Sell ["+ sellthisamount+"] "+ops[i]['back2']+
				", in the "+ ops[i]['back1']+
				" Market, at a price of ["+ ops[i]['parentbuy'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
				
		 //add to array. the percentage gain
		 ops[i]['m1tom2'] = amounttorecieve / fakebtc - 1;    
		 boyorsell.push("sell");	
		 //we are done. we add all of out info into our arrays
		 
		 
		 
		 
		 
		 //M2toM1
		 //Market 2 is either xpm or ltc,
		 //we use btc to create our fake ltc or xpm amount
		 //fakeltc will store either value
		fakeltc = (fakebtc / ops[i]['parentsell']);
		//The amount we end up buying in the second market
		sellthisamount = (fakeltc - (fakeltc * feebuydoge)) / ops[i]['b2sellprice'];
		 //if we buy [amount of coin] in litecoin
		Slide1 = "STEP 1: Buy ["+sellthisamount+ "] "+
		//coin name + in the second market
		 ops[i]['currencyname'] +" in the "+ ops[i]['back2']+
		 //at a price of [what the price is] with [this much btc]
				" Market, at a price of ["+ ops[i]['b2sellprice'] +"], with ["+
				fakeltc +
				"]" + ops[i]['back2'];
		boyorsell.push("buy");		
		priceguide.push(2);	//tells the javascript what market prices are used for quick reference
		//in our calculations we should have our doge. We will take that and sell in the first market.	
		//That market should be btc
				
				
				
		//Calculating how much our sell amount will bring back in the first market.
		amounttorecieve = (sellthisamount * ops[i]['b1buyprice']) 
						- ((sellthisamount * ops[i]['b1buyprice']) * feeselldoge);
		//Sell this muchcoin in the market at that price, to recieve this much, this coin
		Slide2 = "STEP 2: Sell ["+ sellthisamount+"] "+ ops[i]['currencyname']+", in the "+ ops[i]['back1']+
				" Market, at a price of ["+ ops[i]['b1buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		 boyorsell.push("sell");			
		priceguide.push(1);	
			
			
			
				
		//we now have bitcoin, now were going to buy ltc with our bitcoin.
		buythisamount = amounttorecieve;
		//Amount we will recieve after step 3:
		amounttorecieve = (buythisamount / ops[i]['parentsell']) 
						- ((buythisamount / ops[i]['parentsell']) * feebuydoge);
			//sell this much coin
			
		Slide3 = "STEP 3: Buy ["+ buythisamount+"] "+" "+ ops[i]['back1'] +" worth of "+ ops[i]['back2']+
				 " at ["+ops[i]['parentprice']+"] to recieve ["+ amounttorecieve + "] " +ops[i]['back2'];
		 boyorsell.push("buy");	
			//put in the percentage gain 
		ops[i]['m2tom1'] = amounttorecieve / fakeltc - 1;    
		ops[i]['arborder'] = boyorsell; 
		//the price guise is used to keep track of whether we used price 1 or price 2
		ops[i]['priceguide'] = priceguide; 
		 
		 
		 
		 
		 
		var tables = "<div id='holder' style='padding:15px; border:1px solid black;'>"+
		"<h2>"+ ops[i]['currencyname'] +"</h2>"+
		"<p>"+ Step1 + "<br/>"+ Step2 + "<br/>"+ Step3 + "</p>"+
		"<p>"+ Slide1 + "<br/>"+ Slide2 + "<br/>"+ Slide3 + "</p>"+
		
		"<table id='glance' >"+
		"<tr><td>Parent Market Id</td><td>Parent Price</td></tr>"+
		"<tr><td>"+ops[i]['parentmarketid']+"</td><td>"+ops[i]['parentprice']+"</td></tr>"+
		"</table>"+
		
		
		
		
		"<table id='data'>" +
					"<tr>" +
						"<td>Market Name</td>"+
						"<td>Market Id</td>"+
						"<td>Buy Price</td>"+
						"<td>Buy Quantity</td>"+
						"<td>Sell Price</td>"+
						"<td>Sell Quantity</td>"+
						"<td>Ghost Price</td>"+
					"</tr>"+
					
					"<tr>"+
					"<td>"+ops[i]['back1']+"</td>"+
					"<td>"+ops[i]['market1id']+"</td>"+
					"<td>"+ops[i]['b1buyprice']+"</td>"+
					"<td>"+ops[i]['b1buyvol']+"</td>"+
					"<td>"+ops[i]['b1sellprice']+"</td>"+
					"<td>"+ops[i]['b1sellvol']+"</td>"+
					"<td>"+ops[i]['amountperback1']+"</td>"+
					"</tr>"+
					
					"<tr>"+
					"<td>"+ops[i]['back2']+"</td>"+
					"<td>"+ops[i]['market2id']+"</td>"+
					"<td>"+ops[i]['b2buyprice']+"</td>"+
					"<td>"+ops[i]['b2buyvol']+"</td>"+
					"<td>"+ops[i]['b2sellprice']+"</td>"+
					"<td>"+ops[i]['b2sellvol']+"</td>"+
					"<td>"+ops[i]['amountperback2']+"</td>"+
					"</tr>"+
					
					
					
					"</table></div>";
		 
		 
		 tablesholder = tablesholder + tables;
		 
		
		 //$("#sec").html( " This is everything "+result );
		}
		
		 
		
		 
		 
		 
		 

		 
		 
	if(ops[i]['back1'] == "LTC")
	{
		//ltc amount to start with
		if(ops[i]['back2'] == "BTC")
		{
		fakeltc = (fakebtc / ops[i]['parentsell']);
		}
		if(ops[i]['back2'] == "XPM")
		{
		fakexpm = (fakeltc / ops[i]['parentsell']);
		}
		
		
		
//ltc = back1
if (ops[i]['back2'] == "BTC")
{
		//M1toM2
		//We Have LTC
		//Fakeltc is the amount of ltc we would own if we bought the fakebtc amount without fees.
		buyamount =(fakeltc - (fakeltc * feebuydoge)) / ops[i]['b1sellprice'];
		//Read AS: BUY [amount of coin] of [a currency] in the [LTC]
		Step1 = "STEP 1: Buy ["+ buyamount+ "]"+ops[i]['currencyname'] +" in the "+ ops[i]['back1']+
		 //Market, at a price of [what the price is] with [this much ltc]
		" Market, at a price of ["+ ops[i]['b1sellprice'] 
				+"], with ["+fakeltc +"] " +ops[i]['back1'] ;
		 boyorsell.push("buy");
		 priceguide.push(1);
		 
		 
		//we now have doge, we sell the doge to btc in the second market buy price.
		sellthisamount = buyamount;
		amounttorecieve = (sellthisamount * ops[i]['b2buyprice']) 
						- ((sellthisamount * ops[i]['b2buyprice']) * feeselldoge);
		//sell this much coin
		Step2 = "STEP 2: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['currencyname']+", in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['b2buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("sell");		
		priceguide.push(2);	
		//Now we have Btc, well take that to the paren't market and buy the parent
			
			
			
				
		//now we have bitcoin, and well buy ltc using the parent sell value.
		sellthisamount = amounttorecieve;
		amounttorecieve = (sellthisamount / ops[i]['parentsell']) 
						- ((sellthisamount / ops[i]['parentsell']) * feeselldoge);
			//sell this much coin
		Step3 = "STEP 3: Buy ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['back1']+" worth of"+ ops[i]['back1']+
				", at a price of ["+ ops[i]['parentprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		boyorsell.push("buy");			
		 
		 //add to array. the percentage gain  
		ops[i]['m1tom2'] = amounttorecieve / fakeltc - 1;  
		//END M1toM2
		
		
		
		
		
		//M2toM1
		 //This next half of if (ops[i]['back2'] == "BTC")
		 //is to find out the M2toM1 for this currency
		 //We are going to now go From BTC to DOGE, DOGE to LTC, LTC to BTC
		 //We Start with how much will fakebtc buy us in doge to create buyamount
		buyamount = (fakebtc - (fakebtc * feebuydoge)) / ops[i]['b2sellprice'];
		
		//STEP 1: Buy [an amount of coin] [currency name] in this [market name] market,
		//at a price of [what the price is] with [this much btc]
		Slide1 = "STEP 1: Buy ["+buyamount + "] "+ ops[i]['currencyname'] +" in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['b2sellprice'] +"], with ["+
				fakebtc +"] " +ops[i]['back2'] ;
		//make a record of whether we had to buy or sell
		boyorsell.push("buy");	
		//make a record of whether we used market 1 or market 2 for this currency		
		priceguide.push(2);		
				
				
				
				
				
		//We will crunch all the data	
		//now we have doge and well sell that for ltc
		sellthisamount = buyamount;
		//sell the hypothetical doge for what ever the first market is willing to pay
		amounttorecieve = (sellthisamount * ops[i]['b1buyprice']) 
						- ((sellthisamount * ops[i]['b1buyprice']) * feeselldoge);
						
		
		//add into Slide2
		//Read AS: BUY [amount of coin] of [a currency] in the [LTC]
		Slide2 = "STEP 2: Sell ["+ sellthisamount+"] "+ops[i]['currencyname']+", in the "+ ops[i]['back1']+
				" Market, at a price of ["+ ops[i]['b1buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		boyorsell.push("sell");			
		priceguide.push(1);
		 
		 
		 	
		
		//now we have litecoin and going back to bitcoin
		sellthisamount = amounttorecieve;
		amounttorecieve = (sellthisamount * ops[i]['parentbuy']) 
						- ((sellthisamount * ops[i]['parentbuy']) * feeselldoge);
			//sell this much coin
		Slide3 = "STEP 3: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['back1']+", in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['parentbuy'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("sell");			
		
		//add to array. the percentage gain
		ops[i]['m2tom1'] = amounttorecieve / fakebtc - 1;  		
		ops[i]['arborder'] = boyorsell;		
		ops[i]['priceguide'] = priceguide;		
		
		
}
//ltc = back1
if (ops[i]['back2'] == "XPM")
{
		//M1toM2
		//Fake ltc is the hypothetical amount of ltc 
		//we would have if we bought the fakebtc amount with out fees
		//Since our first backing is ltc, we start we ltc for M1toM2
		buyamount = (fakeltc - (fakeltc * feebuydoge)) / ops[i]['b1sellprice'];
		
		Step1 = "STEP 1: Buy ["+buyamount + "] "+
		//coin name + in the first market
		 ops[i]['currencyname'] +" in the "+ ops[i]['back1']+
		 //at a price of [what the price is] with [this much btc]
				" Market, at a price of ["+ ops[i]['b1sellprice'] 
				+"], with ["+fakeltc +"] " +ops[i]['back1'] ;
		boyorsell.push("buy");			
		priceguide.push(1);
		//In our ongoing example, we would now have dogecoin starting our next step
		//
		
		
		
		//we now have doge and we need to sell it to xpm
		//since we have doge we sell it to the second market.
		sellthisamount = buyamount;
		amounttorecieve = (sellthisamount * ops[i]['b2buyprice']) 
						- ((sellthisamount * ops[i]['b2buyprice']) * feeselldoge);
		//sell this much coin in the [name of market] market, 
		Step2 = "STEP 2: Sell ["+ sellthisamount+"] "+ ops[i]['currencyname']+", in the "+ ops[i]['back2']+
				//at a price of market 2 buy price to recieve or xpm
				" Market, at a price of ["+ ops[i]['b2buyprice'] +"], To Recieve ["+amounttorecieve+
				"] "+ ops[i]['back2'];
		boyorsell.push("sell");		
		priceguide.push(2);	
		//Ongoing Example: We should have xpm right now. and the last step will 
		//be exchanging it for ltc again. 
				
				
		//just a note
		//The parent price is 
		//if the currency was doge
		//btc and ltc 
		//parent buy would be 
		//ltc buy value
		
		
		
		//now we have xpm, we are selling that for ltc, [our first market]
		sellthisamount = amounttorecieve;
		amounttorecieve = (sellthisamount * ops[i]['parentbuy']) 
						- ((sellthisamount * ops[i]['parentbuy']) * feeselldoge);
		//Sell this amount of coin, at a price of [parent buy price] 
		Step3 = "STEP 3: Sell ["+ sellthisamount+"] "+ ops[i]['back2']+", at a price of ["+ ops[i]['parentbuy'] +
				//to recieve [amount] coin market
				"], To Recieve ["+amounttorecieve+" ] "+ ops[i]['back1'];
				
		boyorsell.push("sell");			
		 
		 //add to array. the percentage gain
		ops[i]['m1tom2'] = amounttorecieve / fakeltc - 1;
		//End M1toM2
		 
		 
		 
		 
		 
		 
		 
		 //M2toM1
		 //if we buy [amount of coin] Start with Xpm to Ltc
		 //LTC is our M1 currency, Xpm is our M2 currency
		 //Therefore, Well take xpm and exchange it for some doge. 
		 //Going from M2toM1
		 //Amountofdoge = the fakexpmamount that we have - the fee / by the sell price in the second market
		 amountofdoge = (fakexpm - (fakexpm * feebuydoge)) / ops[i]['b2sellprice']
		 //the amount of coin name + in the, name of market
		Slide1 = "STEP 1: Buy ["+ amountofdoge+ "] "+ ops[i]['currencyname'] +" in the "+ ops[i]['back2']+
		 //at a price of [what the price is] with [this much btc]
		" Market, at a price of ["+ ops[i]['b2sellprice'] +"], with ["+fakexpm +"] " +ops[i]['back2'] ;
		boyorsell.push("buy");			
		priceguide.push(2);	
		//We should have doge for our next step. and Well sell that to our first market whcih 
		//happens to be LTC
				
				
				
		//now we have doge, we will sell if for ltc. 
		//Litecoin is our first market so we will be using b1buyprice
		//Selling Doge for the first market
		sellthisamount = amountofdoge;
		//sell the hypothetical doge for what ever the first market is willing to pay
		amounttorecieve = (sellthisamount * ops[i]['b1buyprice']) 
						- ((sellthisamount * ops[i]['b1buyprice']) * feeselldoge);
			//sell this much coin
		Slide2 = "STEP 2: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['currencyname']+", in the "+ ops[i]['back1']+
				" Market, at a price of ["+ ops[i]['b1buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		boyorsell.push("sell");			
		priceguide.push(1);		
		//Now we have our first market currency [ltc]
		//to complete the arbritrage we sell to the second market since this is M2toM1
			
				
				
		//now we have litecoin[m1], now we are going to buy our xpm[m2]
		sellthisamount = amounttorecieve;
		//how much xpm, we should recieve
		amounttorecieve = (sellthisamount / ops[i]['parentsell']) 
						- ((sellthisamount / ops[i]['parentsell']) * feebuydoge);
		//Buy this much coin in the 
		Slide3 = "STEP 3: Buy ["+ sellthisamount+"] "+ ops[i]['back2']+", in the "+ ops[i]['back1']+
				" Market, at a price of ["+ ops[i]['parentsell'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("buy");			
		
		//add to array. the percentage gain
		ops[i]['m2tom1'] = amounttorecieve / fakexpm - 1;
		ops[i]['arborder'] = boyorsell;
		ops[i]['priceguide'] = priceguide;	
}
		 
if(ops[i]['back1'] == "XPM")
	{
		
		
	
		
		
if (ops[i]['back2'] == "BTC")
{
		fakexpm = (fakebtc / ops[i]['parentsell']);
		//if we buy [amount of coin] with xpm
		buyamount = (fakexpm - (fakexpm * feebuydoge)) / ops[i]['b1sellprice'];
		Step1 = "STEP 1: Buy ["+buyamount + "] "+
		//coin name + in the first market
		 ops[i]['currencyname'] +" in the "+ ops[i]['back1']+
		 //at a price of [what the price is] with [this much btc]
				" Market, at a price of ["+ ops[i]['b1sellprice'] 
				+"], with ["+fakexpm +"] " +ops[i]['back1'] ;
		boyorsell.push("buy");		
		priceguide.push(1);	
			
				
		//we now have doge, we sell the doge to btc
		sellthisamount = buyamount;
		amounttorecieve = (sellthisamount * ops[i]['b2buyprice']) 
						- ((sellthisamount * ops[i]['b2buyprice']) * feeselldoge);
			//sell this much coin
		Step2 = "STEP 2: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['currencyname']+", in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['b2buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("sell");			
		priceguide.push(2);
			
			
			
				
		//now we have bitcoin, and well trade that for ltc
		sellthisamount = amounttorecieve;
		amounttorecieve = (sellthisamount / ops[i]['parentsell']) 
						- ((sellthisamount / ops[i]['parentsell']) * feebuydoge);
			//sell this much coin
		Step3 = "STEP 3: Buy ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['back2']+" worth of"+ ops[i]['back1']+
				", at a price of ["+ ops[i]['parentsell'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		boyorsell.push("buy");		
		 
		 //add to array. the percentage gain  
		ops[i]['m1tom2'] = amounttorecieve / fakexpm - 1;  
		
		 
		 
		 
		 
		 
		 
		 
		 //M2toM1 (XPM to BTC) or (LTC to BTC)
		 //buy doge with bitcoin
		Slide1 = "STEP 1: Buy ["+ (fakebtc - (fakebtc * feebuydoge)) / ops[i]['b2sellprice']+ "] "+
		//coin name + in the first market
		 ops[i]['currencyname'] +" in the "+ ops[i]['back2']+
		 //at a price of [what the price is] with [this much btc]
				" Market, at a price of ["+ ops[i]['b2sellprice'] +"], with ["+
				fakebtc +
				"] " +ops[i]['back2'] ;
		boyorsell.push("buy");	
		priceguide.push(2);
		
		
				
				
		//now we have doge and well sell that for xpm
		sellthisamount = (fakebtc - (fakebtc * feebuydoge)) / ops[i]['b2sellprice'];
		//sell the hypothetical doge for what ever the first market is willing to pay
		amounttorecieve = (sellthisamount * ops[i]['b1buyprice']) 
						- ((sellthisamount * ops[i]['b1buyprice']) * feeselldoge);
			//sell this much coin
		Slide2 = "STEP 2: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['currencyname']+", in the "+ ops[i]['back1']+
				" Market, at a price of ["+ ops[i]['b1buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		boyorsell.push("sell");		
		priceguide.push(1);
			
				
		//now we have xpm sell for btc
		sellthisamount = amounttorecieve;
		amounttorecieve = (sellthisamount * ops[i]['parentbuy']) 
						- ((sellthisamount * ops[i]['parentbuy']) * feeselldoge);
			//sell this much coin
		Slide3 = "STEP 3: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['back1']+", in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['parentbuy'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("sell");			
		
		//add to array. the percentage gain
		ops[i]['m2tom1'] = amounttorecieve / fakebtc - 1;  		
		ops[i]['arborder'] = boyorsell;
		ops[i]['priceguide'] = priceguide;			
}


if (ops[i]['back2'] == "LTC")
{
	
	
	
		fakexpm = (fakeltc / ops[i]['parentsell']);
		//ltc amount to start
		//if we buy [amount of coin] with xpm
		buyamount = (fakexpm - (fakexpm * feebuydoge)) / ops[i]['b1sellprice'];
		Step1 = "STEP 1: Buy ["+buyamount + "] "+
		//coin name + in the first market
		 ops[i]['currencyname'] +" in the "+ ops[i]['back1']+
		 //at a price of [what the price is] with [this much btc]
				" Market, at a price of ["+ ops[i]['b1sellprice'] 
				+"], with ["+fakexpm +"] " +ops[i]['back1'] ;
		boyorsell.push("buy");		
		priceguide.push(1);	
			
				
		//we now have doge, we sell the doge to ltc
		sellthisamount = buyamount;
		amounttorecieve = (sellthisamount * ops[i]['b2buyprice']) 
						- ((sellthisamount * ops[i]['b2buyprice']) * feeselldoge);
			//sell this much coin
		Step2 = "STEP 2: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['currencyname']+", in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['b2buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("sell");		
		priceguide.push(2);
		
		
		
				
		//now we have ltc, and well trade that for xpm
		sellthisamount = amounttorecieve;
		amounttorecieve = (sellthisamount / ops[i]['parentsell']) 
						- ((sellthisamount / ops[i]['parentsell']) * feebuydoge);
			//sell this much coin
		Step3 = "STEP 3: Buy ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['back2']+" worth of"+ ops[i]['back1']+
				", at a price of ["+ ops[i]['parentsell'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		boyorsell.push("buy");			
		 
		 //add to array. the percentage gain  
		ops[i]['m1tom2'] = amounttorecieve / fakexpm - 1;  
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 //buy doge with ltc
		Slide1 = "STEP 1: Buy ["+ (fakeltc - (fakeltc * feebuydoge)) / ops[i]['b2sellprice']+ "] "+
		//coin name + in the first market
		 ops[i]['currencyname'] +" in the "+ ops[i]['back2']+
		 //at a price of [what the price is] with [this much btc]
				" Market, at a price of ["+ ops[i]['b2sellprice'] +"], with ["+
				fakeltc +
				"] " +ops[i]['back2'] ;
		boyorsell.push("buy");			
		priceguide.push(2);	
			
				
		//now we have doge and well sell that for xpm
		sellthisamount = (fakebtc - (fakeltc * feebuydoge)) / ops[i]['b2sellprice'];
		//sell the hypothetical doge for what ever the first market is willing to pay
		amounttorecieve = (sellthisamount * ops[i][' ']) 
						- ((sellthisamount * ops[i]['b1buyprice']) * feeselldoge);
			//sell this much coin
		Slide2 = "STEP 2: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['currencyname']+", in the "+ ops[i]['back1']+
				" Market, at a price of ["+ ops[i]['b1buyprice'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back1'];
		boyorsell.push("sell");			
		priceguide.push(1);	
			
			
				
		//now we have xpm sell for btc
		sellthisamount = amounttorecieve;
		amounttorecieve = (sellthisamount * ops[i]['parentbuy']) 
						- ((sellthisamount * ops[i]['parentbuy']) * feeselldoge);
			//sell this much coin
		Slide3 = "STEP 3: Sell ["+ sellthisamount+"] "+ 
		//coin name 
				ops[i]['back1']+", in the "+ ops[i]['back2']+
				" Market, at a price of ["+ ops[i]['parentbuy'] +"], To Recieve ["+amounttorecieve+
				" ] "+ ops[i]['back2'];
		boyorsell.push("sell");			
		
		//add to array. the percentage gain
		ops[i]['m2tom1'] = amounttorecieve / fakeltc - 1;  		
		ops[i]['arborder'] = boyorsell;
		ops[i]['priceguide'] = priceguide;		
}		 
		 
	}
		 
		 
		var tables = "<div id='holder' style='padding:15px; border:1px solid black;'>"+
		"<h2>"+ ops[i]['currencyname'] +"</h2>"+
		"<p>"+ Step1 + "<br/>"+ Step2 + "<br/>"+ Step3 + "</p>"+
		"<p>"+ Slide1 + "<br/>"+ Slide2 + "<br/>"+ Slide3 + "</p>"+
		
		"<table id='glance' >"+
		"<tr><td>Parent Market Id</td><td>Parent Price</td></tr>"+
		"<tr><td>"+ops[i]['parentmarketid']+"</td><td>"+ops[i]['parentprice']+"</td></tr>"+
		"</table>"+
		
		
		
		
		"<table id='data'>" +
					"<tr>" +
						"<td>Market Name</td>"+
						"<td>Market Id</td>"+
						"<td>Buy Price</td>"+
						"<td>Buy Quantity</td>"+
						"<td>Sell Price</td>"+
						"<td>Sell Quantity</td>"+
						"<td>Ghost Price</td>"+
					"</tr>"+
					
					"<tr>"+
					"<td>"+ops[i]['back1']+"</td>"+
					"<td>"+ops[i]['market1id']+"</td>"+
					"<td>"+ops[i]['b1buyprice']+"</td>"+
					"<td>"+ops[i]['b1buyvol']+"</td>"+
					"<td>"+ops[i]['b1sellprice']+"</td>"+
					"<td>"+ops[i]['b1sellvol']+"</td>"+
					"<td>"+ops[i]['amountperback1']+"</td>"+
					"</tr>"+
					
					"<tr>"+
					"<td>"+ops[i]['back2']+"</td>"+
					"<td>"+ops[i]['market2id']+"</td>"+
					"<td>"+ops[i]['b2buyprice']+"</td>"+
					"<td>"+ops[i]['b2buyvol']+"</td>"+
					"<td>"+ops[i]['b2sellprice']+"</td>"+
					"<td>"+ops[i]['b2sellvol']+"</td>"+
					"<td>"+ops[i]['amountperback2']+"</td>"+
					"</tr>"+
					
					
					
					"</table></div>";
		 
		 
		 tablesholder = tablesholder + tables;
		 
	}
	
	

	
		 //$("#sec").html( " This is everything "+result );
		}
		
		
	top1 = null;
	top2 = top1; 
	top3 = top2;
	top4 = top3; 
	top5 = top4;	
	
	mtop1 = null;
	mtop2 = mtop1; 
	mtop3 = mtop2;
	mtop4 = mtop3; 
	mtop5 = mtop4;
		
	positivecount = 0;
	//get the highest ratio of all items
	 for (i=0;i<ops.length;i++)
	 {
		 
		 
		 
		 
		 if (top1== null )
		 {
			 top1 = i;
		 }
		 else if (ops[i]['m1tom2'] > ops[top1]['m1tom2'])
		 {
			 
			 if (!(ops[i]['m1tom2'] < 0))
			 {
				 positivecount++;
				 
			 }
		 
			 
			 top5 = top4;
			 top4 = top3; 
			 top3 = top2;
			 top2 = top1; 
			 top1 = i;
		 
		 }
		 else if (top2== null)
		 {
			 top2 = i;
		 }
		 else if (ops[i]['m1tom2'] > ops[top2]['m1tom2'])
		 {
			 if (!(ops[i]['m1tom2'] < 0))
			 {
				 positivecount++;
				 
			 }
		 	 
			 
			 top5 = top4;
			 top4 = top3; 
			 top3 = top2;
			 top2 = i;
			 
		 } else if (top3== null)
		 {
			 top3 = i;
		 }
		 else if (ops[i]['m1tom2'] > ops[top3]['m1tom2'])
		 {
			 if (!(ops[i]['m1tom2'] < 0))
			 {
				 positivecount++;
				 
			 }
		  
			 top5 = top4;
			 top4 = top3; 
			 top3 =  i;
			 
		 }else if (top4== null)
		 {
			 top4 = i;
		 }
		 else if (ops[i]['m1tom2'] > ops[top4]['m1tom2'])
		 {
				if (!(ops[i]['m1tom2'] < 0))
			 {
				 positivecount++;
				 
			 }
			 top5 = top4;
			 top4 =  i;
			 
		 }else if (top5== null)
		 {
			 top5 = i;
		 }
		 
		 else if (ops[i]['m1tom2'] > ops[top5]['m1tom2'])
		 {
			if (!(ops[i]['m1tom2'] < 0))
			 {
				 positivecount++;
				 
			 }
		 	top5 = i;
		 }
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 if (mtop1== null)
		 {
			 mtop1 = i;
		 }
		 else if (ops[i]['m2tom1'] >  ops[mtop1]['m2tom1'])
		 {
				 if (!(ops[i]['m2tom1'] < 0))
				 {
					 positivecount++;
					 
				 }
		 	 
			 
		
				 mtop5 = mtop4;
				 mtop4 = mtop3; 
				 mtop3 = mtop2;
				 mtop2 = mtop1; 
				 mtop1 = i;
		 
		 }else if (mtop2== null)
		 {
			 mtop2 = i;
		 }
		 else if (ops[i]['m2tom1'] > ops[mtop2]['m2tom1']  || ops[mtop2]['m2tom1'] == null)
		 {
				if (!(ops[i]['m2tom1'] < 0))
				 {
					 positivecount++;
					 
				 }	 
				 mtop5 = mtop4;
				 mtop4 = mtop3; 
				 mtop3 = mtop2;
				 mtop2 = i;
				 
				 
		 }else if (mtop3== null)
		 {
			 mtop3 = i;
		 }
		 else if (ops[i]['m2tom1'] >  ops[mtop3]['m2tom1'])
		 {
		 
		 if (!(ops[i]['m2tom1'] < 0))
		 {
			 positivecount++;
			 
		 }
		 
		 
		 mtop5 = mtop4;
		 mtop4 = mtop3; 
		 mtop3 = i;
		 }else if (mtop4== null)
		 {
			 mtop4 = i;
		 }
		 else if (ops[i]['m2tom1'] >  ops[mtop4]['m2tom1'])
		 {
		
			if (!(ops[i]['m2tom1'] < 0))
				 {
					 positivecount++;
					 
				 }			 
					 
				mtop5 = mtop4;
				mtop4 = i;
		 }else if (mtop5== null)
		 {
			 mtop5 = i;
		 }
		 else if (ops[i]['m2tom1'] >  ops[mtop5]['m2tom1'])
		 {
			if (!(ops[i]['m2tom1'] < 0))
			 {
				 positivecount++;
				 
			 }		 
				 
				 
			 mtop5 =  i;
		 }
	}
		 
	
		
		tableofpercentages = "<table><tr><td colspan='2'>M1toM2</td><td colspan='2'>M2toM1</td></tr>"+
		"<tr><td>"+ops[top1]['currencyname']+"</td><td>"+ops[top1]['m1tom2']+"</td>"+
		"<td>"+ops[mtop1]['currencyname']+"</td><td>"+ops[mtop1]['m2tom1']+"</td></tr>"+
		"<tr><td>"+ops[top2]['currencyname']+"</td><td>"+ops[top2]['m1tom2']+"</td>"+
		"<td>"+ops[mtop2]['currencyname']+"</td><td>"+ops[mtop2]['m2tom1']+"</td></tr>"+
		"<tr><td>"+ops[top3]['currencyname']+"</td><td>"+ops[top3]['m1tom2']+"</td>"+
		"<td>"+ops[mtop3]['currencyname']+"</td><td>"+ops[mtop3]['m2tom1']+"</td></tr>"+
		"<tr><td>"+ops[top4]['currencyname']+"</td><td>"+ops[top4]['m1tom2']+"</td>"+
		"<td>"+ops[mtop4]['currencyname']+"</td><td>"+ops[mtop4]['m2tom1']+"</td></tr>"+
		"<tr><td>"+ops[top5]['currencyname']+"</td><td>"+ops[top5]['m1tom2']+"</td>"+
		"<td>"+ops[mtop5]['currencyname']+"</td><td>"+ops[mtop5]['m2tom1']+"</td></tr>"+
		"</table>";
		
		$("#amountpositive").html("<p>OPS: "+positivecount+"</p>");
		
		$("#top").html(tableofpercentages)
		
		  $("#result").html(tablesholder)
		 
		 
		 returnarray.push(top1);
		 returnarray.push(top2);
		 returnarray.push(top3);
		 returnarray.push(top4);
		 returnarray.push(top5);
		 returnarray.push(mtop1);
		 returnarray.push(mtop2);
		 returnarray.push(mtop3);
		 returnarray.push(mtop4);
		 returnarray.push(mtop5);
		 returnarray.push(ops);
		 //$("#result").html(returnarray[0]);
		 setdata(returnarray);
	
	 });	
	 
}//end get details