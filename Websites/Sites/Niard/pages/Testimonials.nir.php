

<script type="text/javascript">
//This javascript is for google ananlytics. 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36182316-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<div class="feedbackdiv std"> 

<h1 class="nblue italic">Testimonials</h1> 

 

<p class='indent std'> 
Check out what some of our customers have said about us. 
</p> 

<div class="divider"> </div> 


<?php


include 'phpscripts/sql.php'; 



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
"niard_comments"
, $con);


$result = mysql_query("select * from data");

$first = true;


 while ($row = mysql_fetch_array($result)) {
 
 //if first run do nothing. on second run. make devider.
  if ($first)
  	{ //do nothing
	 $first = false;
	}
	else 
	{
	echo '<div class="divider"> </div>'; 	
	}
 
  echo "<div class='comment'><table><tr><td><h1 class='nblue fteen'>" . $row['name'] . "<i class='black twelve'> wrote:</i></h1></td>";
  
  echo "<td class='fteen textr'>" . $row['rating'] . "/5</td></tr></table>";

  echo "<div class='cbox'><p>" . $row['comment'] . "</p></div>"; 

  echo "</div>";


 
}
  ; 
mysql_close($con);
?> 





</div>
