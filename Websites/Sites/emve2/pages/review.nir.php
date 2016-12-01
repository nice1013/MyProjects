<!DOCTYPE html><head>

</head>

<?php 
	    // Your code here to handle a successful verification  
	  
	$concern = $_POST['concern']; 
	$name = $_POST['name']; 
	$email = $_POST['email']; ?>
	 

     
     
      
<div class="para">
      
      
      <p>Take a second and look over the details you have entered. If you 
        need to make an edit, Hit the edit button, Otherwise click submit to post your question.
        <br>
		<br>
        <br>

        
      
        Alerts will be sent to:
		<b><?php echo $email; ?></b>
      	</p>
      
      	<hr>
      
      	<div class="bubble"> 
      
      
    <p><strong>"</strong>
    <?php echo $concern; ?>
    
    <strong>"</strong>
    </p>

	<h2 id="reviewheadername">~<?php echo $name; ?></h2>

      
	
    

	  </div> <!--ending div class bubble-->
      
     <hr> 
      
		<form action="index.php?p=edit" method="post"> 
      <input type="hidden" name="email" value="<?php echo $email ?>" /> 
      <input type="hidden" name="name" value="<?php echo $name ?>" /> 
      <input type="hidden" name="concern" value="<?php echo $concern ?> "/> 
       <input type="hidden" name="from" value="review.nir"/> 
      <input type="submit" name="submit" value="Edit"/>
      </form> 



   		<form action="index.php?p=postto" method="post"> 
      <input type="hidden" name="email" value="<?php echo $email ?>" /> 
      <input type="hidden" name="name" value="<?php echo $name ?>" /> 
      <input type="hidden" name="concern" value="<?php echo $concern ?> "/> 
      <input type="submit" name="submit" value="Submit"/>
      </form>    
      
      
      
      
   
      		    
	  </div>






</html>