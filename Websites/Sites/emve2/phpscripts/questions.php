<!DOCTYPE html>

<body>

<?php 



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



// if statement for whether there is a page var using get method 
if (!(empty($_GET['pv'])))
{
	$pv = $_GET['pv']; 
}
else 
{
	$pv = 0; 	
}



//find all questions or concerns 


		
		
		$con = ui();
		if (!$con)
		{
				die('Could not connect: ' .mysql_error()); 
		}
		
		
		
		
		mysql_select_db(
		//'a3897265_nice'
		$db
		, $con);
		
		$singledigit = 0; //setting up for ten pages
		
		while ( $singledigit <= 10 ) //displaying 10 questions.
		{
			
		$adjuster = $pv * 10 ;
		$pv2 = $adjuster + $singledigit;
		

		$result = mysql_query("select * from comments where id='".$pv2."'");  // filling result array with content from table. 
		
		
		
		if ($result) { // if  a result has content continue displaying that row otherwise end. 
		if (mysql_num_rows($result) == 0) {
		 }
		 else {

		if ($row = mysql_fetch_array($result)) 
				{	
				
				$tc  = trim($row['comments']);
				$date = $row['date'];
				$name = $row['name']; 
				
				echo "<div class='qbox'>";
				
				echo "<div class='top60'>";
				
				if ($tc != "")
				{	echo "<p style='font-size:14px;'>". $tc  . "</p>";
				}
				
				echo "</div>";
				
				echo "<div class='bottom40'>";
				
				if ($date != "")
				{	echo "<h1 style='text-align:right; font-size:14px;'>".$date."</h1>"; 
					}
				
				if ($name != "")
				{	echo "<h1 style=' text-align:right; font-size:14px;'>~".$name."</h1>"; 
				}
				
				echo "</div>"; 
				
				echo "</div>";
				
				echo "<hr>";
				

				}


		 }
}
		
		

		$singledigit++;

		}
			





//declare page var 





//if page var is blank use 0 - 9 id in questions list. 



// if page var is valid take page var multiply it by 10 and queary for next ten items 





?> 




</body>
</html>