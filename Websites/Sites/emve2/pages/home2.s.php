

<?php 


(date("h:i:s") . "<br />");

$time = strtotime(date("H"));

 $time;

?>


<div id="spara" class="para">

<h1 id="sidehelp" style=" "> Need Help? </h1> 

<hr />
    
<div> 
<p>



			Please enter your information and one of our experienced technicians will contact you.
            On-site Calls available from 9am to 5pm, monday - friday for as low as 49.99$. <br />
			
            See <a href="http://www.yourweblog.com/yourfile.html" onclick="window.open('termsofs.php','popup','width=500,height=400,scrollbars=yes,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false">Terms of services</a> for more details.
            

</p>
</div>

<hr />

<!--
<form action="index.php?p=emergency&i=2" method="post"> 
-->
<div id="helptable">

<form   name="myform" action="index.php?p=stp"  method="post">
<table> 
<tr> 
<td class="lable">*First Name:</td>
<td class="def"> 
<input type="text" name="fname"  size="15"> 
</td> 
</tr> 
<tr> 
<td class="lable">*Last Name:</td> 
<td class="def">
<input type="text" name="lname" size="15" > 
</td>
</tr> 
<tr> 
<td class="lable"> 
*Phone:
</td> 
<td class="def">
<input type="text" name="phone1" maxlength="10" size="10" > 
</td> 
</tr> 
<tr> 
<td class="lable"> 
Alt Phone:
</td> 
<td class="def">
<input type="text" name="phone2" maxlength="10" size="10"  > 
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
<td> 
What OS Do you Have?
</td> 
<td>
<select name=”os”>
<option value=”Windows Xp”>Windows Xp</option>
<option value=”Windows Vista”>Windows Vista</option>
<option value=”Windows 7”>Windows 7</option>
<option value=”Dontknow”>Don't Know</option>
<option value=”None”>None</option>
</select>
</td> 
</tr> 
<tr> 
<td colspan="2" style="text-align:center">
Comments/Additional Info?
</td> 
</tr>
<tr>
<td colspan="2">
<textarea style="width:100%; max-width:300px; max-height:300px;" name="comments" cols="25" rows="5">
</textarea>
</td> 
</tr> 
<tr>
<td colspan="2" style="text-align:center">
<input type="submit" name="submit" value="submit">
</td> 
</tr> 
<tr> 
<td colspan="2" style="text-align:center;">
<h4>Thank You!</h4>
</td>
</tr> 

</table> 
</form>

</div>















<script type="text/javascript" src="validate.js"></script>
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

<div id="spara" class="para"> 

<a href="http:\\www.NiardDrains.com">
<img style="width:100%; height:100%;" src="images/gotdrains.gif" alt="Got Drains ad" />
</a>


</div> 
