<html> 


<div class="divider2">
</div> 


<div class="estimate">

<h4> Emergency Help </h4> 


    
<div id="sidehelp"> 
<p>




			Please enter your information and within 30 minutes
            one of our experienced reps will contact you. $50 promotion
            only available from 9am to 5pm, monday - friday.  

</p>
</div>

<!--
<form action="index.php?p=emergency&i=2" method="post"> 
-->

<form name="myform" action="index.php?p=emergency&i=2"  method="post">
<table> 
<tr> 
<td class="lable">*First Name:</td>
<td class="def"> 
<input type="text" name="fname"  size="10"> 
</td> 
</tr> 
<tr> 
<td class="lable">*Last Name:</td> 
<td class="def">
<input type="text" name="lname" size="10" > 
</td>
</tr> 
<tr> 
<td class="lable"> 
*Phone:
</td> 
<td class="def">
<input type="text" name="phone1" maxlength="10" size="8" > 
</td> 
</tr> 
<tr> 
<td class="lable"> 
Alt Phone:
</td> 
<td class="def">
<input type="text" name="phone2" maxlength="10" size="8"  > 
</td> 
</tr>
<tr> 
<td class="lable"> 
*Zip Code:
</td> 
<td class="def">
<input type="text" name="zip" maxlength="5" size="3" > 
</td> 
</tr>  
<tr> 
<td class="lable"> 
*Address:
</td> 
<td class="def">
<input type="text" name="address"  > 
</td> 
</tr> 
<tr> 
<td class="lable"> 
*Email:
</td> 
<td class="def">
<input type="text" name="email"  > 
</td> 
</tr> 
<tr> 
<td class="lable">
Is this an Emergency?
</td> 
<td class="def">
<input type="radio" name="emergency" value="eyes" /> Yes
<input type="radio" name="emergency" value="eno" /> No
</td> 
</tr>
<tr>

<?php 


(date("h:i:s") . "<br />");

$time = strtotime(date("H"));

 $time;

?>

<td class="lable">

</td> 
<td class="def">
<input type="radio" name="emergency" value="eyes" /> Yes
<input type="radio" name="emergency" value="eno" /> No
</td> 
</tr>
</table>




<table>
<tr> 
<td> 
What Service are you looking For?
</td> 
</tr>
<tr>
<td>
<select name = ”service”>
<option value=”dcleaning”>Drain Cleaning
<option value=”prepair”>Plumbing Repair
<option value=”other”>Other
</select>
</td> 
</tr> 
<tr> 
<td>
Comments/Additional Info?
</td> 
</tr>
<tr>
<td>
<textarea name="comments" cols="25" rows="5">
</textarea>
</td> 
</tr> 
<tr>
<td>
<input type="submit" name="submit" value="submit">
</td> 
</tr> 

</table> 
</form>
<h4>Thank You!</h4>


<script type="text/javascript">
 var frmvalidator  = new Validator("myform");
 
 
 //form validation for first name.
frmvalidator.addValidation("fname","req","Please enter your First Name");
frmvalidator.addValidation("fname","maxlen=20",
        "Max length for FirstName is 20");	
frmvalidator.addValidation("fname","alpha", "Please Enter Your Name with out any Numbers (123) or Symbols (!@#$).");
		
		
		
		
		
 //form validation for last name
frmvalidator.addValidation("lname","req","Please enter your Last Name");
frmvalidator.addValidation("lname","maxlen=20",
        "Max length for FirstName is 20");
frmvalidator.addValidation("lname","alpha", "Please Enter Your Name with out any Numbers (123) or Symbols (!@#$).");


// form validation for phone
frmvalidator.addValidation("phone1","req","Please enter your Phone Number");
frmvalidator.addValidation("phone1","alnum");
 frmvalidator.addValidation("phone1","maxlen=10","Please Enter Your Phone Numbers without letters (abc) or Symbols(!@#$%).");
  frmvalidator.addValidation("phone1","minlen=10","Please Enter Your 10 digit Phone Number without any letters (abc) or Symbols(!@#$%).");
 
 
// form validation for phone2 

frmvalidator.addValidation("phone2","alnum");


  
  
  
  


// form validation for zip
frmvalidator.addValidation("zip","req","Please enter your Zip");
frmvalidator.addValidation("zip","alnum");



 // form validation for email
 frmvalidator.addValidation("email","maxlen=50");
 frmvalidator.addValidation("email","req");
 frmvalidator.addValidation("email","email");
</script>


</div>



</html>