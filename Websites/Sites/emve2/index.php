<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<link rel="stylesheet" type="text/css" href="" />

<link rel="stylesheet" type="text/css" href="css/padmar.css" />

<link rel="stylesheet" type="text/css" href="css/handwidth.css" />

<link rel="stylesheet" type="text/css" href="css/positions.css" />

<link rel="stylesheet" type="text/css" href="css/textstyle.css" />

<link rel="stylesheet" type="text/css" href="css/pointereffects.css" />

<link rel="stylesheet" type="text/css" href="css/bordershadows.css" />

<link rel="stylesheet" type="text/css" href="css/dropmenu.css" />



<script type="text/javascript" src="jquery-1.7.2.js"> </script>

<script type="text/javascript" src="slide.js"></script>

<script type="text/javascript" src="jquery.animate-shadow-min.js"></script>

<script type="text/javascript" src="validate.js"></script>

<script type="text/javascript" src="html5shiv.js"></script>

<!--[if IE]><!-->  

<style type="text/css">@import 'css/ie6.css';</style>  

<!--<![endif]-->  

<!--[if Chrome]><!-->  

<style type="text/css">@import 'css/background.css';</style>  

<!--<![endif]-->  


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
					$content = "Emve technologies is a home based start-up in the Philadelphia area specializing in repair and installation of most technologies like, PCs, Home Theators, Xbox 360, Ps3, and so many more . We have Information on how to maintain a computer and what-to-do and what-not-to-do if ever your computer breaks. ";
				}



	}else 
	{ 
	$content = "Emve technologies is a home based start-up in the Philadelphia area specializing in repair and installation of most technologies including, PCs, Home Theators, Game Consoles, and so many more . We have Information on how to maintain a computer and what-to-do and what-not-to-do if ever your computer breaks. ";
	}
?>


<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="google-site-verification" content="7T9sOt4UgYdW9twSbkKlDThXn0hEvS55tyUNZi2ZaeQ" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description"
content="<?php echo $content; ?>" />


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



</header> 

<div id="nav" style="width:100%; height:25px; min-width:320px; color:#fff;  border-bottom:1px black solid;  background-color:#000;"> 

<div id="nav" style=" text-align:left; width:100%; float:left;"> 

<ul> 
    <li id="homelink"> 
    
    <a href="index.php">Home</a> 
            <ul class="homeextra"> 
            
            <li>Ne Pride</li>
            
            </ul>
            
    </li>
    
    <li>
    
    <a href="index.php?p=services">Services</a> 
    
    </li>
	<li>
		<a href="index.php?p=testimonials">Testimonials</a> 
	</li>
<li style="width:50%; text-align:right; padding-right:10px;">
Live in Philly? Call (215)385-3358 or <a href="index.php?p=services">request for service online</a>
</li>

</ul> 
</div> <!--ending div id nav-->


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



            

    		<?php 



			include "pages/home2.s.php";

			?>

    

    	


    		</div>

            

			</div> <!--ending <div id="bodycontent">-->





<footer> 



<p>Created By Ed Evanosich</p> 





</footer>



</body>

</html>

