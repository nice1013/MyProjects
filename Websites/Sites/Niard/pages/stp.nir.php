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

$hello = $_POST["fname"]; 
$lname = $_POST["lname"];
$phone1 = $_POST["phone1"];
$phone2 = $_POST["phone2"];
$zip = $_POST["zip"];
$address = $_POST["address"];
$email = $_POST["email"];
$emergency = $_POST["emergency"];
$comments = $_POST["comments"];

$body = "Name:" . $hello . " " . $lname . "\n" .  
"Phone:" . $phone1 . "\n" . 
"Alt:" . $phone2 . "\n" .
"Address:" . $address . 
$zip . "\n" .
"911?:" . $emergency . "\n";




$c = "Comments: " . $comments . "\n". 
"Submitted " . date('M/d/Y, g:h:i A');  


$all = $body . $c;


  $to = "mrnice1013@gmail.com";
 $subject = "Form Entry: Niard Drain";
 if (mail($to, $subject, $all)) {
   echo("<h1 class='nblue italic'>Thank You!</h1>");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }

  $to = "2158839315@vtext.com";
 $subject = "Form Entry: Niard Drain";
 if (mail($to, $subject, $c)) {
   echo("");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }
  
    $to = "2672485313@mymetropcs.com";
 $subject = "Form Entry: Niard Drain";
 if (mail($to, $subject, $c)) {
   echo("");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }

    $to = "2674444234@mymetropcs.com";
 $subject = "Form Entry: Niard Drain";
 if (mail($to, $subject, $c)) {
   echo("");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }




 $to = "2158839315@vtext.com";
 $subject = "Form Entry: Niard Drain";
 if (mail($to, $subject, $body)) {
   echo("");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }
  
 $to = "2672485313@mymetropcs.com";
 $subject = "Form Entry: Niard Drain";
 if (mail($to, $subject, $body)) {
   echo("");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }
  
   $to = "2674444234@mymetropcs.com";
 $subject = "Form Entry: Niard Drain";
 if (mail($to, $subject, $body)) {
   echo("");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }
  
  
  
  
 

 
 ?>

<p class="std"> Your request has been sent. A professional Technician will return your call in the next hour. If there is any problems. Please dont hesitate to call.
</p> 

<div class="divider"> </div>    

<h1 class="rethome">Return <a href="index.php">Home</a></h1>

</div>

