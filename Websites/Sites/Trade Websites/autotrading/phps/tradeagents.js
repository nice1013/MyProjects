-// JavaScript Document
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

function updatestatus()
{
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	 $.ajax({
	 type: "POST",
	 url: "phps/updatetradestatus.php",
	 data: {}
	 }).done(function( result ) {
	 //$("#msg").html( " This is everything "+result );
	 });	 
}//end get details




function createmasterarb()
{
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	 $.ajax({
	 type: "POST",
	 url: "phps/createarbmastertable.php",
	 data: {}
	 }).done(function( result ) {
	 //$("#msg").html( " This is everything "+result );
	 });	 
}//end get details



function arbmanager(trade1, trade2, trade3)
{
//orderbook1 = JSON.stringify(trade1);
//orderbook2 = JSON.stringify(trade2);
//orderbook3 = JSON.stringify(trade3);
	
	var concatenatedstring = trade1['marketid']+trade2['marketid']+trade3['marketid'];
	
	 $.ajax({
	 type: "POST",
	 url: "phps/createarbentry.php",
	 data: {arbid: concatenatedstring}
	 }).done(function( result ) {
		 //send us back the name of the arb table for later
		 if (result != '0' && result != '')
		 {
			 

			  $("#arbhandle").append( " This is arbmanager(): "+result );
			  //send the trade and the name of the arbtable
			   cryptsytrade(trade1, result);
			   cryptsytrade(trade2, result);
			   cryptsytrade(trade3, result);
		 }
		 
	 });	 
}//end get details


function cryptsytrade(trade1, arbtablename)
{
orderbook1 = JSON.stringify(trade1);
//orderbook2 = JSON.stringify(trade2);
//orderbook3 = JSON.stringify(trade3);

	 $.ajax({
	 type: "POST",
	 url: "phps/tradeinsert.php",
	 data: {trade: orderbook1,
	 		tablename : arbtablename}
	 }).done(function( result ) {
		 
		 //returning the order id of the cryptsy trade and inserting that into database
		 if (result != '0' && result != '')
		 {
			 //send the order id and arb table name to trade insert
			  tradeinsert(trade1, result, arbtablename);
		 }
		 
	 });	 
}//end get details


function tradeinsert(trade1, orderid, arbtablename)
{
orderbook1 = JSON.stringify(trade1);
//orderbook2 = JSON.stringify(trade2);
//orderbook3 = JSON.stringify(trade3);

	 $.ajax({
	 type: "POST",
	 url: "phps/tradeinsert.php",
	 data: {trade: orderbook1,
	 		tablename : arbtablename,
			order : orderid }
	 }).done(function( result ) {
		 
		 if (result != '0' && result != '')
		 {
			 
			  $("#arbhandle").append( "/n Tradeinsert"+result );
		 }
		 
	 });	 
}//end get details



function createarbtable(arbname, currency, marketid, tradeid, amount)
{
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	//var orderbook = JSON.stringify(data);
	
	
	 $.ajax({
	 type: "POST",
	 url: "phps/tradehandler.php",
	 data: {arbname:arbname,
	 		currency:currency,
			marketid:marketid,
			tradeid:tradeid,
			amount:amount}
	 }).done(function( result ) {
	 $("#tradehandler").html(result );
	 });	 
}//end get details


function arbinsert(arbname, marketpath)
{
	 //ajax get market history and add new 
	 //averages to table
	// var rno = $('#rno').val();
	//var orderbook = JSON.stringify(data);
	
	
	 $.ajax({
	 type: "POST",
	 url: "phps/arbinsert.php",
	 data: {arbname:arbname,
	 		marketpath:marketpath}
	 }).done(function( result ) {
	 $("#tradehandler").html(result );
	 });	 
}//end get details



function trade(marketid, buyorsell, quantity, price)
{
	//var orderbook = JSON.stringify(data);
	//array("marketid" => 132, "ordertype" => "Buy", "quantity" => 1000, "price" => 0.00000100));

	var holder = { 
    'marketid' : marketid,
    'ordertype' : buyorsell,
    'quantity' : quantity,
	'price' : price}

	//alert(holder['marketid']);
	var orderbook = JSON.stringify(holder);
	 $.ajax({
	 type: "POST",
	 url: "phps/trade.php",
	 data: {order:orderbook}
	 }).done(function( result ) {
	 $("#tradehandler").html(result );
	 });	 
}//end get details




function committrade(data, maxbtctradevalue)
{
	//var orderbook = JSON.stringify(data);
	//array("marketid" => 132, "ordertype" => "Buy", "quantity" => 1000, "price" => 0.00000100));
	buyfee = .002;
	sellfee = .003;
	ops = data[10];//1-9 of data is our top ten id numbers and 10 is all of our currencies
	failed = new Array();
	maxvalue = maxbtctradevalue;
	perfect = new Array();
	//alert("commitTrade:"+ops[0]['market1id']);
	$("#tradehandler").html("");
	
	//this for loop will check to see if conditions are normal can
	//the buy price should be lower than the sell price if not 
	//if is inserted into the failed array
	for (i=0; i<10; i++)
	{
	if (!(ops[data[i]]['b1sellprice'] > ops[data[i]]['b1buyprice'] && 
			ops[data[i]]['b2sellprice'] > ops[data[i]]['b2buyprice'] ))
		{
			failed.push(data[i]);
		}
		
	}
	
	//checks to see if the parent of the op has a 
	//a buy price that is lower than the sell price if not 
	//the number of that listing is inserted into failed array
	for (i=0; i<10; i++)
	{
	if ((ops[data[i]]['parentstatus'] == "fail"))
		{
			//$("#tradehandler").append("HELgLO"+ops[data[i]]['parentstatus']+"<br />");
			failed.push(data[i]);
		}
		
	}
	
	
	for (i=0; i<10; i++)
	{
		//if we are under 5 we are trading m1tom2
		if (i < 5)
		{ 	
			 if (!(ops[data[i]]['m1tom2'] > 0.001))
			 {
				 failed.push(data[i]);
			 }	
		}
		
		
		if (i > 4)
		{ 	
			if (!(ops[data[i]]['m2tom1'] > 0.001))
				 {
					 failed.push(data[i] );
					 
				 }
		}
		
	}
	
	
	for (i=0; i<10; i++)
	{
		//varaible says that as of now all trades are passing
		//but if they fail have a fail at any piont, the pass var will be set to 0
		pass = 1;
		//Get the length of how many fails have occurred for all currencies
		p = failed.length;
		while (p--)
		{
			if (failed[p] == data[i])
			{
				pass =0;
					//$("#tradehandler").append(i+":FAILED"+data[i]+", "+ops[data[i]]['currencyname']+"<br />");
			}
			
		}
		
		
		$("#tradehandler").append("test"+i+"<br />");
		
		//here should be pass
		if (pass)
		{
			whichprice ='';
			amountwerecieve = "";
			//$("#tradehandler").append("Buy"+ops[data[i]]['b1sellprice'][0]+"<br />");
			$("#tradehandler").append("PASS"+i+"<br />");
			
			
			
		
		
		//var name = "name";
		//var val = 2;
		//obj[name] = val;
		//Details of a Trade
		var details = {};
		var trade1 = {};
		var trade2 = {};
		var trade3 = {};
		
		//Array of trades 
		var trades = {};
		//first the m1tom2 markets	
		if (i < 5)
		{
				
			//for loop to run through the 
			//first 3 of the arborder are the steps to buy from market 1 to market 2
			//for this particular op
		
			//if buy were buying at the sell value
			//if arborder = buy. 
			//get first trade
			if  (ops[data[i]]['arborder'][0] == "buy")
			{	
			    whichmarket = "";
			    //if the priceguide is = to 1
				//then b1sellprice [the price of the first market]
				//is used. this is created at the javascritpps.js
				//this should be set to 2
				if(ops[data[i]]['priceguide'][0] == 1)
				{
					whichprice = 'b1sellprice';
					whichmarket = "market1id";
				}else 
				{
					whichprice = 'b2sellprice';
					whichmarket = "market2id";
				}
					
				
				//get max btc minus buy fee
				nonfeevalue = maxvalue - (maxvalue * buyfee);
				//this is the amount of coin we are going to buy
				amounttobuy = nonfeevalue / ops[data[i]][whichprice];
				marketid = ops[data[i]][whichmarket];
				buyorsell = ops[data[i]]['arborder'][0];
				price = ops[data[i]][whichprice];
				
				$("#tradehandler").append("Buy"+i+":"+amounttobuy+
				", "+ops[data[i]]['currencyname']+","+price+"<br />");
				
				trade1['marketid'] = marketid;
				trade1['ordertype'] = buyorsell;
				trade1['quantity'] = amounttobuy;
				trade1['price'] = price;
			}
					
				
				
				
				
				
		//get second trade				
		if  (ops[data[i]]['arborder'][1] == "sell")
			{
					
				whichmarket = "";
			    //if the priceguide is = to 1
				//then b1sellprice [the price of the first market]
				//is used. this is created at the javascritpps.js
				//this should be set to 2
				if(ops[data[i]]['priceguide'][1] == 1)
				{
					whichprice = 'b1sellprice';
					whichmarket = "market1id";
				}else 
				{
					whichprice = 'b2sellprice';
					whichmarket = "market2id";
				}
				details = new Array();
				
				amountwehave = amounttobuy;	
						//if buy were buying at the sell value
					//get max btc minus buy fee
				//this is the amount of coin we are going to buy
				amounttosell = amountwehave;
				marketid = ops[data[i]][whichmarket];
				buyorsell = ops[data[i]]['arborder'][1];
				price = ops[data[i]][whichprice];
				amountwerecieve = (amounttosell - (amounttosell * sellfee)) * ops[data[i]][whichprice];
				$("#tradehandler").append("Sell"+i+":"+amounttosell+
				", "+ops[data[i]]['currencyname']+","+price+"TO get"+amountwerecieve+"<br />");
					
				//what we will get back	
				trade2['marketid'] = marketid;
				trade2['ordertype'] = buyorsell;
				trade2['quantity'] = amounttobuy;
				trade2['price'] = price;
					
			}
			
			
			
		//get third trade			
		if  (ops[data[i]]['arborder'][2] == "buy")
			{
				
				
				
				details = new Array();	
				amountwehave = amountwerecieve;	
						//if buy were buying at the sell value
					//get max btc minus buy fee
				//this is the amount of coin we are going to buy
				amounttosell = amountwehave;
				marketid = ops[data[i]]['parentmarketid'];
				buyorsell = ops[data[i]]['arborder'][2];
				price = ops[data[i]]['parentsell'];
				
				$("#tradehandler").append("Buy"+i+":"+amounttosell+
				", "+ops[data[i]]['currencyname']+","+price+"<br />");
					
				//what we will get back	
				amountwerecieve = (amounttosell - (amounttosell * sellfee)) * ops[data[i]]['parentsell'];
					
				
				trade3['marketid'] = marketid;
				trade3['ordertype'] = buyorsell;
				trade3['quantity'] = amounttosell;
				trade3['price'] = price;
				arbmanager(trade1, trade2, trade3);
				
				
			}
			else
			{
				details = new Array();
				amountwehave = amountwerecieve;	
						//if buy were buying at the sell value
					//get max btc minus buy fee
				//this is the amount of coin we are going to buy
				amounttosell = amountwehave;
				marketid = ops[data[i]]['parentmarketid'];
				buyorsell = ops[data[i]]['arborder'][2];
				price = ops[data[i]]['parentbuy'];
				
				$("#tradehandler").append("Sell"+i+":"+amounttosell+
				", "+ops[data[i]]['currencyname']+","+price+"<br />");
					
				//what we will get back	
				amountwerecieve = (amounttosell - (amounttosell * sellfee)) * ops[data[i]]['parentbuy'];
				
				
				trade3['marketid'] = marketid;
				trade3['ordertype'] = buyorsell;
				trade3['quantity'] = amounttosell;
				trade3['price'] = price;
				arbmanager(trade1, trade2, trade3);
				
			}
			
		}//end of if i < 5 so it must be 5 - 9
		else
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//M2TOM1
		// this is the else statement
		//this will format the m2tom1 markets
		{
					
				
			//for loop to run through the 
			//first 3 of the arborder are the steps to buy from market 1 to market 2
			//for this particular op
		
			//if buy were buying at the sell value
			//if arborder = buy. 
			if  (ops[data[i]]['arborder'][3] == "buy")
			{	
			
				details = new Array();
				whichmarket = "";
			    //if the priceguide is = to 1
				//then b1sellprice [the price of the first market]
				//is used. this is created at the javascritpps.js
				//this should be set to 2
				if(ops[data[i]]['priceguide'][2] == 1)
				{
					whichprice = 'b1sellprice';
					whichmarket = "market1id";
				}else 
				{
					whichprice = 'b2sellprice';
					whichmarket = "market2id";
				}
					
				//if buy were buying at the sell value
				//get max btc minus buy fee
				nonfeevalue = maxvalue - (maxvalue * buyfee);
				//this is the amount of coin we are going to buy
				amounttobuy = nonfeevalue / ops[data[i]][whichprice];
				marketid = ops[data[i]][whichmarket];
				buyorsell = ops[data[i]]['arborder'][3];
				price = ops[data[i]][whichprice];
				
				$("#tradehandler").append("Buy"+i+":"+amounttobuy+
				", "+ops[data[i]]['currencyname']+","+price+"<br />");
				
				trade1['marketid'] = marketid;
				trade1['ordertype'] = buyorsell;
				trade1['quantity'] = amounttobuy;
				trade1['price'] = price;
				
			}
					
				
				
				
				
				
		//step two of m2tom1
		if  (ops[data[i]]['arborder'][4] == "sell")
			{
				if(ops[data[i]]['priceguide'][3] == 1)
				{
					
					whichprice = 'b1buyprice';
					whichmarket = 'market1id';
				}else if (ops[data[i]]['priceguide'][3] == 2)
				{
					whichprice = 'b2buyprice';
					whichmarket = 'market2id';
				}	
					details = new Array();
				amountwehave = amounttobuy;	
						//if buy were buying at the sell value
					//get max btc minus buy fee
				//this is the amount of coin we are going to buy
				amounttosell = amountwehave;
				//the market id, of the current op, or currency
				marketid = ops[data[i]][whichmarket];
				buyorsell = ops[data[i]]['arborder'][4];
				price = ops[data[i]][whichprice];
				amountwerecieve = (amounttosell - (amounttosell * sellfee)) * ops[data[i]][whichprice];
				$("#tradehandler").append("Sell"+i+":"+amounttosell+
				", "+ops[data[i]]['currencyname']+", "+price+" To Get "+amountwerecieve+" BuyPrice:"+whichprice+"<br />");
				
				
				//what we will get back	
				trade2['marketid'] = marketid;
				trade2['ordertype'] = buyorsell;
				trade2['quantity'] = amounttobuy;
				trade2['price'] = price;
					
			}
			
			
			
					
		if  (ops[data[i]]['arborder'][5] == "buy")
			{
				details = new Array();
						
				amountwehave = amountwerecieve;	
						//if buy were buying at the sell value
					//get max btc minus buy fee
				//this is the amount of coin we are going to buy
				amounttosell = amountwehave;
				marketid = ops[data[i]]['parentmarketid'];
				buyorsell = ops[data[i]]['arborder'][5];
				price = ops[data[i]]['parentsell'];
				
				$("#tradehandler").append("Buy"+i+":"+amounttosell+
				", "+ops[data[i]]['currencyname']+","+price+"<br />");
					
				//what we will get back	
				amountwerecieve = (amounttosell - (amounttosell * sellfee)) * ops[data[i]]['parentsell'];
					
				
				
				trade3['marketid'] = marketid;
				trade3['ordertype'] = buyorsell;
				trade3['quantity'] = amounttosell;
				trade3['price'] = price;
				arbmanager(trade1, trade2, trade3);
				
			}
			else
			//if else, we are selling for parrent price
			{
				details = new Array();
				amountwehave = amountwerecieve;	
						//if buy were buying at the sell value
					//get max btc minus buy fee
				//this is the amount of coin we are going to buy
				amounttosell = amountwehave;
				marketid = ops[data[i]]['parentmarketid'];
				buyorsell = ops[data[i]]['arborder'][5];
				price = ops[data[i]]['parentbuy'];
				
				amountwerecieve = (amounttosell - (amounttosell * sellfee)) * ops[data[i]]['parentbuy'];
				
				$("#tradehandler").append("Sell"+i+":"+amounttosell+
				", "+ops[data[i]]['currencyname']+","+price+"Recieve"+amountwerecieve+"<br />");
				trade3['marketid'] = marketid;
				trade3['ordertype'] = buyorsell;
				trade3['quantity'] = amounttosell;
				trade3['price'] = price;
				arbmanager(trade1, trade2, trade3);
			}
					
				
		} //end else if statement for i < 5
		
		//here we will send our trade data to our trade facilitator
		//which will first check out arb record to see if we
		
		
	}//end if pass
	
	
}//for loop 10
	
	
/*
	//alert(holder['marketid']);
	var orderbook = JSON.stringify(holder);
	 $.ajax({
	 type: "POST",
	 url: "phps/trade.php",
	 data: {order:orderbook}
	 }).done(function( result ) {
	 $("#tradehandler").html(result );
	 });	 */
	 
}//end get details