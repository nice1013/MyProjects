<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Niard Drains. "GOT DRAINS!"</title>

<link rel="stylesheet" type="text/css" href="Css/mainLayout.css" />
<link rel="stylesheet" type="text/css" href="Css/index.css" />
<link rel="stylesheet" type="text/css" href="Css/header2.css" />
<link rel="stylesheet" type="text/css" href="Css/currenttab.css" />
<link rel="stylesheet" type="text/css" href="Css/menu.css" />
<link rel="stylesheet" type="text/css" href="Css/sidebar.css" />
<link rel="stylesheet" type="text/css" href="Css/special.css" />




<script type="text/javascript" src="javascripts/jquery-1.7.2.js"></script>
<script type="text/javascript" src="javascripts/effects.js"></script>
<script src="javascripts/gen_validatorv4.js" type="text/javascript"></script>



<?php 

	$ctab = "ctab";
	$li = "list";
	$page = "";
	
	if (!empty($_GET['p'])) 
	{ 
		
		$p = $_GET['p']; 
		
		$page = $p ;
		
		
		
		
	} else { 

		$p = 'home';
		$page = $p ;
	}

if (!$page == 'home')
{
echo '
<link rel="stylesheet" type="text/css" href="Css/<?php echo $page; ?>.css"/> ';
}




?>

<meta name="description" content="Niard Drain LLC, Located in the heart of Philadelphia Pa. Our mission is provide our customers with quality work at an inexpensive price. Our employees will meet the needs of our consumers on a individual level of professionalism."  /> 
<meta name="google-site-verification" content="blPPDa9ePlnQfjiq_YkN3hKGtWGPiENk-CZlhA0FgL4" />

</head>





<!-- *************START OF BODY*******************-->
<body>






<!-- Javascript if for facebook like section --> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="container" >



<div id="header">



<!-- 
Creating a table. with 2 sides. 1 row.
left side will contain company name. 
right side will contain another table. 
That table will consist of 1 column two rows. 
top will contain phone number. 
Bottom will contain quote. 
--> 

<table> 
    <tr> 
    
    <td> 
        <!-- This will contain company name. -->
        
        <h1 id="bname">Niard Drain<span>llc</span></h1>
        
    </td>
    
    <td> 
        <!--right side will contain another table.-->
            <table> 
            <tr> 
            <td>
            <!--will contain phone number.--> 
            <p id="num" class="nblue">
            <img src="images/creditcardlogo.gif" width="150" height="25" /> 
            267 - 202 - 5237</p>
            </td>
            </tr>
            <tr>
            <td> 
            <!--will contain quote. -->
             <h3 class="nblue">Call Today! Free Estimates. </h3>
            </td>
            </tr>
        	</table>
        
        
        
    </td>
    
    </tr>
</table>



	
    
    
</div> <!-- end header div -->
  


  
  
  
  





<div class="menu">





<!-- if statements on each link is deteremmining whether or not that page is open. 
and if it is, ajust css. --> 

<div  onclick="location.href='index.php?p=emergency';"  style="cursor:pointer;" class="<?php
					if ($page == 'emergency' || $page == 'stp' || $page == 'ste')
					{ echo $ctab; } 
					else
					{ echo $li;	}	?>">
                    
                                
<p><a href="index.php?p=emergency">Emergency</a> </p>
</div>

<div onclick="location.href='index.php?p=special';"  style="cursor:pointer;"  class="<?php
					if ($page == 'special')
					{ echo $ctab; } 
					else
					{ echo $li;	}	?>">
<p><a href="index.php?p=special">$50 Special</a> </p>
</div>


<div onclick="location.href='index.php?p=feedback';"  style="cursor:pointer;"  class="<?php
					if ($page == 'feedback')
					{ echo $ctab; } 
					else
					{ echo $li;	}	?>">
<p><a href="index.php?p=feedback">FeedBack</a> </p>
</div>

<div onclick="location.href='index.php';"  style="cursor:pointer;"  class="<?php
					if ($page == 'home')
					{ echo $ctab; } 
					else
					{ echo $li;	}	?>"> 
<p><a href="index.php">Home</a> </p>
</div>




</div>



<div class="menushell">
&nbsp;
</div> <!--ending <div class="menushell2">-->

<div class="menushell2">  
&nbsp;
</div> <!--ending <div class="menushell">-->

<div class="menushell3">  
&nbsp;
</div> <!--ending <div class="menushell">-->








<div class="extraclass"> 

<div class="inexholder">



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




</div>
</div>


<div id="sidebar">

<div style="background:#999; padding:15px; padding-bottom:5px;">
<div class='std'>
<div class="fb-like" data-href="http://www.Niarddrains.com/gotdrains/" data-send="true" data-layout="standard" data-width="200" data-show-faces="true" data-font="verdana"></div>
</div>
</div>

<div id="insidebar"> 
<a href="index.php?in=services&p=special">
<img src="images/gotdrains.gif" alt="Got Drains ad" />
</a>

<a href="http://www.GoEmve.com">
<img src="images/emvead.gif" alt="Emve Technology ad." />
</a>


</div>



</div>





  
  
<div class='footer'>

<p> Created by Ed Evanosich 8/2012. </p>

</div> 
  



</div>	<!-- end Container -->
</body>
</html>