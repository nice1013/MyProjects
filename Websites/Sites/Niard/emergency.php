<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Niard Drains. "Were simply the best"</title>

<link rel="stylesheet" type="text/css" href="Css/mainLayout.css" />

<link rel="stylesheet" type="text/css" href="Css/emergency.css" />



<script type="text/javascript" src="javascripts/jquery-1.7.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  	
  var par = $('.aboutus');
  $(par).hide();
 
  var button1 = ('#aboutusb');
  $(button1).click(function()
  {
     $(par).slideToggle("slow");
  }	);
  //ending about us button and slide function
  
  
  
  
  var par2 = $('.rightfirst');
  $(par2).hide();
  var button2 = ('#rightfirstb');
  $(button2).click(function()
  {
     $(par2).slideToggle("fast");
  }	);
  
  $("img").hover(function() {
      $(this).stop().animate({opacity: "0.8"}, 'fast');
	 
    },
    function() {
      $(this).stop().animate({opacity: "2"}, 'fast');
	});
});
</script>








</head>

<body>

<div class="container" >
  

    <div id="header">
        <div class="img">
        <a href="index.php"><img src="images/NiardLogo.gif" alt="niard logo. We're simply the best" width="class='wid'" height="180px" />
        </a>
        </div><!--end img div --> 
        <div class="menu"> 

                  <table> 
                        <tr> 
                        <td class="twofourseven">
                        <a href="emergency.php">24/7 Emergency Service!</a>
                        </td>
                        <td><a href="index.php">Home</a></td> 
                        
                        <td><a href="contactus.php">Contact Us</a></td> 
                        <td><a href="info.php">Learn More</a></td>
                        
                        
                    </tr> 
                  </table>
  
        </div><!--end menu div --> 
          
          
    <div class="phone">
      
      
        <a href="emergency.php" ><img src="images/addbanner3.gif" width="465" height="150" />
  		</a>
  
    </div> <!-- end phone div --> 
	</div> <!-- end header div --><!--ending welcome div-->
  
  <div id="right"> 
<h4>Tips!</h4>
<span class="rightfirst"> 
Niard Drain here saying Hello, please take a second to view all the services that we have to offer. From drain cleanings to Bathroom Remodeling, here at Niard Drain we cover all your needs.  </span><button id="rightfirstb">more</button>

</div> <!-- ending center div -->   
  
  
 
  

<div id="center"> 
<div class="form"> 
<h1>Emergency</h1>
<form action="send_mail.php" method="post">
<table>
<tr>
<td>Name</td>
<td>
<input type="text" name="name" value="" maxlength="100" />
</td>
</tr>
<tr>
<td>Address</td>
<td>
<input type="text" name="address" value="" maxlength="100" />
</td>
</tr>
<tr>
<td>Phone:</td>
<td> 
<input type="text" name="phone" maxlength="100"/>
<tr>
<td>Comments:</td>
<td>
<textarea rows="10" cols="35" name="comments"></textarea>
</td>
</tr>
<tr><td>&nbsp;</td>
<td>
<input type="submit" value="Submit" />
</td>
</tr>
</table>
</form>
</div>
</div> <!-- ending center div --> 



  
  
  
  



</div>	<!-- end Container -->
</body>
</html>