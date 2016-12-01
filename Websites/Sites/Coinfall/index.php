<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="index2.css" />
<script src="jquery-1.7.2.js" ></script>
<script src="Javascript/SendFormValidator.js" ></script>

<title>Coinfall</title>
</head>

<body>


<?php 
$message = $_GET["message"];
$yeah = '
<div id="content">

<h1 id="sitename">Coinfall</h1>




<!-- Form for submitting new Dogecoin address for dns -->
<table id="tableDNSform">
<form name="createTxt" id="txtform" method="post" action="extra/checkSql.php">

<tr> 
<td> 
<p>By using Domain Zone Records, we can link a username to a dogecoin address and add more functionality to Dogecoin wallets.
Multidoge wallets with the TXT Record feature, can send dogecoins to a domain address. My usersname is 4moves, in the send address bar you would enter, "4moves.coinfall.pw" and press send. It will auto input my address and send the coins.</p>
</td> 
<tr>


<!-- Address box and label -->
<tr>
<td> 
<label for="address">Dogecoin Address</label>
</td>
</tr>

<tr>
<td>
<input id="address"  type="text" required="true" name="address" />
</td>
</tr>

<!-- Username box and label -->
<tr>
<td>
<label for="name">Username</label>
</td>
</tr>

<tr>
<td>
<input id="name" type="text" required="true" name="name" /> 
</td>
</tr>


<!-- Password box and label -->
<tr>
<td>
<label for="pw">Password</label>
</td>
</tr>


<tr>
<td>
<input id="pw"  type="password" required="true" name="pw"  /> 
</td>
</tr>


<!-- Password 2 box and label -->
<tr>
<td>
<label for="pw2">Repeat Password</label>
</td>
</tr>

<tr>
<td>
<input id="pw2"  type="password" required="true" name="pw2"  /> 
</form>
</td>
</tr>


<tr> 
<td >
<button id="submit"  onclick="submitform()">Add Doge Address</button>
</td>
</tr>

<tr> 
<td ">
<p id="messages"><br></p>
</td>
</tr>

<tr> 
<td>
<p id="getMessages">' . $message . '</p>
</td>
</tr>


</table>








</div>
';



?>

<script language="javascript">



//document.write(' <?php //echo json_encode($yeah); ?>');

	
$( document ).ready(function() {
	
	$("body").html(<?php echo json_encode($yeah); ?>);
	
});





	

</script>

</body>
</html>