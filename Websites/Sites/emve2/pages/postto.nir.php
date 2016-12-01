<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php 



//including php script for quick sql returns.

$con = ui();
//The if is the shift saying what your going to do. 
//deciding if your going to the zoo
//or if your going to cry boo hoo hoo hoo
if (!$con)
{
	die('Could not connect: ' .mysql_error()); 
}

//Sir knight of MySql, 
//Finds a data base in the selection forest. 
//along with all the proper instructions to connect. 
		

		//Declaring Functions Fetch(this,id) a = retr(this,id)

		 if ( $x == 2)
		 { $db = $database;}
		 else
		 {$db = "csystem";};
		 
		$email = $_POST['email']; 
		$name = $_POST['name']; 
		$concern = $_POST['concern']; 
		$datentime = date('M/d/Y, g:h:i A');
		$message = "";


		
		if (!$con)
{
	die('Could not connect: ' .mysql_error()); 
}


		$resultc = mysql_query("SELECT * FROM comments
		WHERE comments='$concern'");
		
		if(isset($resultc))
		  {
		  $message = "Error: Double submission.<br /><br />
					 Click  <a href='index.php'> here </a> to go to homepage.";
		  }
		  else
		  {
			  if (!$con)
{
	die('Could not connect: ' .mysql_error()); 
}

		mysql_select_db("csystem", $con);
		
		mysql_query("INSERT INTO comments (email, name, comments, date) 
		VALUES ('$email','$name', '$concern' , '$datentime')");	
		
		echo $email . $name . $concern . $datentime;
		  
		  $message = "Your message has been sucessfully posted!
		  	<br /><br />
		  			Click  <a href='index.php'> here </a> to go to homepage.";
		  }
		
		mysql_close($con);

?>


<div class="para"> 

<?php echo $message; ?>

</div> 



<?php


/*
		
		function fetch($this,$id){
		
		
		
		$con = ui();
		if (!$con)
		{
				die('Could not connect: ' .mysql_error()); 
		}
		mysql_select_db(
		//'a3897265_nice'
		"spartantest"
		, $con);
		$result = mysql_query("select * from customer where id='".$id."'");
		
				if ($row = mysql_fetch_array($result)) 
				{	echo $row[$this]; }
		}
		
		
		function retr($this,$id){
		
		
		
		$result = mysql_query("select * from customer where id='".$id."'");
		
				if ($row = mysql_fetch_array($result)) 
				{	return($row[$this]); }
		}
		$con = ui();
		if (!$con)
		{
				die('Could not connect: ' .mysql_error()); 
		}
		mysql_select_db(
		//'a3897265_nice'
		"spartantest"
		, $con);




*/




?> 


</body>
</html>