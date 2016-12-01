
<div class="para" style="min-height:400px;">

<?php

$hello = $_POST["fname"]; 
$lname = $_POST["lname"];
$phone1 = $_POST["phone1"];
$phone2 = $_POST["phone2"];
$zip = $_POST["zip"];
$address = $_POST["address"];
$email = $_POST["email"];
$emergency = $_POST["emergency"];
$os = $_POST["os"];
$comments = $_POST["comments"];

$body = "Customer From EMVE Technolgies: \n\n " . 
"Name: " . $hello . " " . $lname . "\n" .  
"Phone: " . $phone1 . "\n" . 
"Phone Alt: " . $phone2 . "\n" .
"Address: " . $address . "\n" . 
$zip . "\n" .
"Emergency: " . $emergency . "\n" .
"OS: " . $os . "\n" .
"Comments: " . $comments . "\n" ."\n" . 
"Submitted " . date('M/d/Y, g:h:i A'); 




 $to = "2672485313@mymetropcs.com";
 $subject = "Hi!";
 if (mail($to, $subject, $body)) {
   echo("<h2>Thank You!</h2>");
  } else {
   echo("<p>Error. If this persist please Report issue to concerns@goemve.com </p>");
  }
 ?>

<p> Your request for service has been sent. A professional Technician will return your call in the next hour. If there is any problems. Please dont hesitate to call.
</p> 


<h1 style="font-size:18px;">Return <a href="index.php">Home</a></h1>

</div>
