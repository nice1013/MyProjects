<?php 


?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css" />

    <script language="javascript" type="text/javascript" src="jquery.js"></script>
    <script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="master/jquery.flot.valuelabels"></script>
    <link rel="stylesheet" type="text/css" href="master/plot.css">
    <script language="javascript" type="text/javascript" src="master/jquery.flot.navigationControl"></script>

<script>
function getdetails(){
 var name = 132;
 var rno = $('#rno').val();
 $.ajax({
 type: "POST",
 url: "ajaxphptest.php",
 data: {id:name, id:rno}
 }).done(function( result ) {
 $("#msg").html( " Address of Roll no " +rno +" is "+result );
 });
}
</script>
</head>
<body> 
<table>
<tr>
<td>Your Name:</td>
<td><input type="text" name="name" id="name" /><td>
</tr>
<tr>
<td>Roll Number:</td>
<td><input type="text" name="rno" id="rno" /><td>
</tr>
<tr>
<td></td>
<td><input type="button" name="submit" id="submit" value="submit" onClick = "getdetails()" /></td>
</tr>
</table>
<div id="msg"></div>
<div id="result"></div>
</body>
</html>
