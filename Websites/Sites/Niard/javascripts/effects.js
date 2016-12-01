// JavaScript Document
$(document).ready(function(){
	

		var list = $(".list");
		var subtext = $(".subtext");
		var tab = $(".inexclass"); 
		var ctab = $(".ctab")
		
		
		

		$(ctab).show(function(){ $(this).animate({marginLeft: '+=2%' ,marginRight: '+=2%'}, 200); });
		
	  
	  
	 
	  
		
function validateForm()
{
var x=document.forms["myForm"]["email"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Not a valid e-mail address");
  return false;
  }
}
		
		
		
		
	
});