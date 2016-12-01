
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

<div class="std" style="min-height:400px;">

<?php

$name = $_POST["name"]; 
$rating = $_POST["rating"];
$comments = $_POST["comments"];

$body = "Name:" . $name . "\n" .  
		"Rating:" . $rating . "\n" . 
		"Comments:" . $comments ; 


 
  $to = "mrnice1013@gmail.com";
 $subject = "Review:";
 if (mail($to, $subject, $body)) {
   echo("<h1 class='nblue italic'>Thank You!</h1>");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }
  
    $to = "2672485313@mymetropcs.com";
 $subject = "Review:";
 if (mail($to, $subject, $body)) {
   echo("");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }

 
 ?>

<p class="std"> Thank you so much for feedback. We hope to do business with you again. 
</p> 

<div class="divider"> </div>   

<h1 class="rethome">Return <a href="index.php">Home</a></h1>

</div>

