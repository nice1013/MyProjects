// JavaScript Document

//funcion Hids(c,g) is for hiding and showing the words inside the askholder, #ask box. 
	
	function hides(c,g)
	{
	

		
		a = c + g;			// c which is the controlled string id along with g which is the id 
								// variable makeup the new string for the id. 
		$(a).fadeOut('slow'); //hide previous word
		g++; 
		
		
		
		if ( g == 9 ) 
				{ 
				g = 1; 
				i = 1; 

				
				}
				else 
				{ 
				i++; 
				}
						
		

		a = c + g; 
		$(a).delay(100).slideDown(); //showing 
		

		

		
	}


$(document).ready(function() {
    
	$('#signup').hide(); // Hiding signup window under ask bar. 
	
	
	$('#qb').click(function() {
		
		$('#signup').slideToggle(); 
		
	});
	

    
	i = 1; 

	w = "#w";
	
	while ( i <= 8 ) 
	{
		
		p = i + 1; 
		d = p; // first word will stay showing
		$(w+p).hide(); 
		i++;
		
		
	}
	i = 1;

	
	
	setInterval(function(){hides(w,i)},2000);

	
	
});