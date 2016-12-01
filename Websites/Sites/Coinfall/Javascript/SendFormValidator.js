// JavaScript Document
/*
Created by Ed Evanosich. 

*/


function submitform() {
	
	//Get username
	username = $("#name").val();
	
	//Get address
	address = $("#address").val();
	
	//Get first password
	pw = $("#pw").val();
	
	//Get second password
	pw2 = $("#pw2").val();
	
	//Setup submit form array. --If it remains with 0 elements, form will submit.
	submitform = [];	
	
	
	
	
	//Check username for maxlength and Characters. 
	ValNumsLets(username, 20, submitform, "Username");
	
	//Check username for maxlength and Characters. 
	ValNumsLets(address, 40, submitform, "Address");
	
	//Check if address is less than 20 chars as that is too small to be an address.
	if(address.length < 20)
	{
	submitform.push("There is no way, that this is a valid address.");
		
	}
	
	
	if(pw.length > 25)
	{
	submitform.push("Password must be less than 25 characters long.");
		
	}
	
	
	//Check to see if passwords match. If matches it will register 'TRUE', so we flipped it.
	if(!(pw.match(pw2))) 
	{
	submitform.push("Your Passwords do not match.");
	}
	
	//Validate password, if it is validates.
	validatePassword(pw, submitform);
	
	
	
	
	
	
	
	if(submitform.length == 0) 
	{
	document.getElementById("txtform").submit();
	}
	else
	{
	
	temp = submitform.join("<br>");
	delete submitform;
	$("#messages").html(temp);
	}
	
}

//Function will check length of username, and ensure that it only has numbers, letters.
function ValNumsLets(input, maxlength, array, name) {
	
	//Check if username is greater than maxlength.
	if(input.length > maxlength)
	{
		array.push(name + " must be 'LESS' than "+ maxlength + " characters."); 
		
	}
	
	
	
	//If special is true, then user need to fix username.
	if(IsLetterNums(input) == false) 
	{
		array.push(name + " can only have letters and numbers."); 
		
	}
	
	
	
	
	
}


function IsLetterNums(input) {
// regular expression
var filter = /^[A-Za-z0-9]+$/;
if (filter.test(input)) return true;
else return false;
}


function validatePassword(password, array) {
	
	//Check length
	if (password.length < 8) {
		array.push("Your password must be at least 8 characters"); 
	}

	//Check for letters
	if (password.search(/[a-z]/i) < 0) {
		array.push("Your password must contain at least one letter."); 
	}
	
	//Check for numbers
	if (password.search(/[0-9]/) < 0) {
		array.push("Your password must contain at least one digit."); 
	}
	
	
	
	//Check for Special Characters.
	//List of Special Characters
	var iChars = "!@#$%^&*()+=-[]\';,./{}|:<>?~_";
	
	//Temp bool.
	special = false;
	
	//Checking for special characters.
	for (var i = 0; i < password.length; i++) {
		  if (iChars.indexOf(password.charAt(i)) != -1) {
		  special = true;
		  }
	}
	
	if(special == false)
	{
		array.push("You must have atleast one Special Character"); 
	}
	  
	  
}