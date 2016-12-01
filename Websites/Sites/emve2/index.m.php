<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/mediascreen.css" />
<link rel="stylesheet" type="text/css" href="css/padmar.css" />
<link rel="stylesheet" type="text/css" href="css/handwidth.css" />
<link rel="stylesheet" type="text/css" href="css/positions.css" />
<link rel="stylesheet" type="text/css" href="css/textstyle.css" />
<link rel="stylesheet" type="text/css" href="css/pointereffects.css" />
<link rel="stylesheet" type="text/css" href="css/bordershadows.css" />

<script type="text/javascript" src="jquery-1.7.2.js"> </script>
<script type="text/javascript" src="slide.js"></script>
<script type="text/javascript" src="jquery.animate-shadow-min.js"></script>
<script type="text/javascript" src="validate.js"></script>
<script type="text/javascript" src="html5shiv.js"></script>
<!--[if IE 8]><!-->  
<style type="text/css">@import 'css/ie6.css';</style>  
<!--<![endif]-->  
<!--[if !IE 8]><!-->  
<style type="text/css">@import 'css/background.css';</style>  
<!--<![endif]-->  

</script>

<meta content='True' name='HandheldFriendly' />
<meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Emve Technologies</title>
<!-- 
error_reporting(0);
 -->
		<?php	
include 'phpscripts/sql.php'; 
		?>

</head>
<body>





<header> 

<div id="cname">

<h1>EMV</h1>
<h1 id="mirror">E</h1>

<br />
<h1 id="tech">Technologies</h1> 

</div><!-- ending <div id="cname">-->



<div id="nav"> 

<a href="index.php">YOU KNOW</a> 
<a href="#">Answers</a> 
<a href="#">Forum</a> 

</div> <!--ending div id nav-->



</header> 





<div id="fu" style="border-top-left-radius:0px; border-top-right-radius:0px; z-index:1; border:1px black solid; position:fixed; top:0px; right:10px; background:#000;"> 

<p style="color:#fff;  padding:10px; font-size:18px;">
Live in Philly? Call (267) 248 5313 or <a style=" color:#fff;" href="index.php?p=services">Click Here</a>
</p>
</div> 









<div id="bodycontent">

            <div id="sixtyfive">
           <?php
            
            
            
            
	$pages_dir = 'pages';

	//seeing if p is empty if so, sending it to index.
	if (!empty($_GET['p'])) 
	{   //scanning directory 
		$pages = scandir ($pages_dir, 0);
		unset($pages[0], $pages[1]); 
		
		$p = $_GET['p']; 
		

		
		if(!empty($_GET['i']))
		{
		
			$i = $_GET['i']; 
			

			
			$issue = $i; 
		
		}	else 
		{ $issue = "";	}
		
		
		
		
		if (in_array($p . $issue . '.nir.php', $pages)) 
		{ 
			include($pages_dir.'/'.$p.$issue.'.nir.php'); 
		} else 
		{
			echo 'Sorry, Page not found.';
		}
	} else { 
		$s = '/home';
		include($pages_dir. $s .'.nir.php');
	}
?>
            
    
            
              
            </div> <!--ending <div id="sixtyfive">-->



            <div id="thirtyfive"> 
    		<div> 
            
    		<?php 

			include "pages/home2.s.php";
			?>
    
    	
        	</div>
    		</div>
            
			</div> <!--ending <div id="bodycontent">-->


<footer> 

<p>Created By Ed Evanosich</p> 


</footer>

</body>
</html>
