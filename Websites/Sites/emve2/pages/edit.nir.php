<!DOCTYPE html>

<?php 



if (isset($_POST["from"]))
{
$from = $_POST["from"];
echo $from;

 
if ($from == 'review.nir')
{
// if page is directed from review.ir 
// run this without looking for a recapcha
  require_once('recaptchalib.php');



	$concern = $_POST['concern']; 
	$name = $_POST['name']; 
	$email = $_POST['email']; 
	?> 

	<div class="para">
    
    		<div class="editor">
            <div id="cap">
            
            <form action="index.php?p=edit" method="POST">

			<div id="topedit" class="tleft">
            Name:<br>
        	<input name="name" type="text" value="<?php echo $name; ?>" />
			<br>
            Email:<br>
            <input name="email" type="email" value"<?php echo $email; ?>" />
			<br>
            Concern:<br>
            <textarea id="concerne" name="concern" ><?php echo $concern; ?> </textarea>
            <br>
            <hr>
            
			</div><!--<div id="topedit" class="tleft"> -->
            
            <?php
  $publickey = "6Lf7EtcSAAAAAAbaSvrd0lEyPBzBpv4oJoALokGo"; // you got this from the signup page
  echo recaptcha_get_html($publickey) ;
			?>
            <hr>

            <input type="submit" name="submit" value="Preview" /> 
	
    		

            </form>
            </div><!--<div id="cap"> -->
            </div><!--<div class="editor"> -->
     </div><!--<div class="para"> -->
	
  <?php
	
	
	
	
}
}
else
{
  require_once('recaptchalib.php');
  $privatekey = "6Lf7EtcSAAAAAObjJYNoAEIbDL9aJbRKLn8SyhyA";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    $concern = $_POST['concern']; 
	$name = $_POST['name']; 
	$email = $_POST['email']; 
	?> 

	<div class="para">
    
    		<div class="editor">
            <div id="cap">
            
            <form action="index.php?p=edit" method="POST">
            <br>

			<div id="topedit" class="tleft">
            Name:<br>
        	<input name="name" type="text" value="<?php echo $name; ?>" />
			<br>
            Email:<br>
            <input name="email" type="email" value"<?php echo $email; ?>" />
			<br>
            Concern:<br>
            <textarea id="concerne" name="concern" ><?php echo $concern; ?> </textarea>
            <br>
            
            <hr>
			</div>
            
            <?php
  $publickey = "6Lf7EtcSAAAAAAbaSvrd0lEyPBzBpv4oJoALokGo"; // you got this from the signup page
  echo recaptcha_get_html($publickey) . "The reCAPTCHA wasn't entered correctly. Please Try again." ;
			?>
            <hr>

            <input type="submit" name="submit" value="Preview" /> 
	
    		

            </form>
            </div>
            </div>
           
<?php
	
	echo '</div>';
  } else  {

            include_once("pages/review.nir.php");



    } 
}
	
?>




</html>