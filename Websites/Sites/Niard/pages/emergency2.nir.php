<html> 

<div class="estimate">
<h4> Help is right here </h4> 
<div id="sidehelp"> 
<p>
<?php 



?>
			"Please enter your information and within 30 minutes
            one of our reps will contact you."

</p>
</div>


<form  name="form" action="index.php?p=emergency&i=2" method="post"> 
<table> 
<tr> 
<td class="lable">First Name:</td>
<td class="def"> 
<input type="text" name="fname"  size="10"> 
</td> 
</tr> 
<tr> 
<td class="lable">Last Name:</td> 
<td class="def">
<input type="text" name="lname" size="10" > 
</td>
</tr> 
<tr> 
<td class="lable"> 
Phone:
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
Zip Code:
</td> 
<td class="def">
<input type="text" name="zip" maxlength="5" size="3" > 
</td> 
</tr>  
<tr> 
<td class="lable"> 
Address:
</td> 
<td class="def">
<input type="text" name="address"  > 
</td> 
</tr> 
<tr> 
<td class="lable"> 
Email:
</td> 
<td class="def">
<input type="text" name="email"  > 
</td> 
</tr> 
</table>




<table>
<tr> 
<td> 
Whats the problem?
</td> 
</tr>
<tr>
<td>
<select name = ”problem”>
<option value=”dcleaning”>Drain Cleaning
<option value=”prepair”>Plumbing Repair
<option value=”other”>Other

</select>
</td> 
</tr> 
<tr> 
<td>
Do You Have Anymore Info?
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
<input type="submit" name="submit" value="Continue">
</td> 
</tr> 

</table> 
</form>
<h4>Thank You!</h4>



</div>



</html>