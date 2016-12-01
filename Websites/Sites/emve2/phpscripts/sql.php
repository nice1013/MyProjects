<?php
	$x = 1; 

function ui() { 
				
				$x = 1;
				if ($x == 1 ) 
				{ return(mysql_connect("localhost","root","1mrnice"));
				} 
				
				if ($x == 2 )
				{ return(mysql_connect("mysql5.000webhost.com","a3897265_nice","1mrnice"));
				}
		}
		
		if ( 2 == $x ) 
		{ $database = "a3897265_nice"; 
			$table = "helloenl";}
			
			
		
		
		
		
		
		
		
		
		
		
		
		
	//function to open a database. 
function opendb($database) { 

		
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
		mysql_select_db(
		
		//'a3897265_nice'
		"$database"
		, $con);

}
		
		
		
		

		
		?>
