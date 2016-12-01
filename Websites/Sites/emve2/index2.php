<!doctype html>
 
<html lang="en">
<head>


<link rel="stylesheet" type="text/css" href="css/background.css" />

<link rel="stylesheet" type="text/css" href="css/padmar.css" />

<link rel="stylesheet" type="text/css" href="css/handwidth.css" />

<link rel="stylesheet" type="text/css" href="css/positions.css" />

<link rel="stylesheet" type="text/css" href="css/textstyle.css" />

<link rel="stylesheet" type="text/css" href="css/pointereffects.css" />

<link rel="stylesheet" type="text/css" href="css/bordershadows.css" />

<link rel="stylesheet" type="text/css" href="css/dropmenu.css" />




<script src="jquery-1.7.2.js"></script>



<script>



</script>



<?php 
	$pages_dir = 'pages';
	$content = "";


	//seeing if p is empty if so, sending it to index.

	if (!empty($_GET['p'])) 
	{   //scanning directory 
		$pages = scandir ($pages_dir, 0);
		unset($pages[0], $pages[1]); 
		$p = $_GET['p']; 

				
				if (in_array($p . '.nir.php', $pages)) 
				{ 
				ob_start();
				include($pages_dir.'/'.$p.'.nir.php'); 
				ob_end_clean();
				}else 
				{
					$content = "";
				}



	}else 
	{ 
	$content = "";
	}
?>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description"
content="<?php echo $content; ?>" />





</head>
<body>

<div id="article">


<?php


include 'phpscripts/sql.php'; 

$t1 = ""; 
$t2 = ""; 
$t3 = "";


//open the database
opendb('henhouse');

$result = mysql_query("SELECT * FROM yokes WHERE id='$p'");


 while ($row = mysql_fetch_array($result)) {
 

 
echo 	'<div class="mshell"><h1>' . $row['name'] . "</h1>";

echo 	'<div class="mbody"><p>' . $row['body'] . '</p></div></div>';



$t1 = $row['name'];
 
}


$t4 = array('thing');

//this section shall be used for our omlet 


$result = mysql_query("SELECT * FROM yokes WHERE parent='$t1'");

$i = 0;
 while ($row = mysql_fetch_array($result)) {
 

 
echo 	'<div class="item">'; 
echo 	'<div class="watermark">';   
echo 	"<h2>" . $row['name'] . "</h2>";
echo 	"</div>";
echo 	'<div class="imgh"><p>' . $row['body'] . '</p></div></div>';

$t4[$i] = $row['name'];
$t3 = $i;
 $i++;
}

$i = 0;

for ($p = 0; $p <= $t3; $p++) { 
	
	
	$result = mysql_query("SELECT * FROM yokes WHERE parent='$t4[$i]'");
	if (!mysql_num_rows($result)==0) { 
		while ($row = mysql_fetch_array($result)) {
			echo 	'<div class="item">'; 
			echo 	'<div class="watermark">';   
			echo 	"<h2>" . $row['name'] . "</h2>";
			echo 	"</div>";
			echo 	'<div class="imgh"><p>' . $row['body'] . '</p></div></div>';
			}
	}

$i++;
}


//ending section for omlet 



 ?> 
  
  
  
  
 




</div>



</body>



</html>