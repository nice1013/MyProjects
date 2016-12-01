// JavaScript Document


            $(document).ready(function() {
                createStoryJS({
                    type:       'timeline',
                    width:      '100%',
                    height:     '600',
                    source:     'https://docs.google.com/spreadsheet/pub?key=0At3GjVZJ_LVrdFktT0VURUhpWFJyZmhhM2ZKVUQzVHc&output=html',
                    embed_id:   'timeline-embed'
                });
            });

        
		/*
         createStoryJS({
            width:              '100%',
            height:             '600',
            source:             'https://docs.google.com/spreadsheet/pub?key=0At3GjVZJ_LVrdFktT0VURUhpWFJyZmhhM2ZKVUQzVHc&output=html',
            embed_id:           'timeline-embed',               //OPTIONAL USE A DIFFERENT DIV ID FOR EMBED
            start_at_end:       true,                          //OPTIONAL START AT LATEST DATE
            start_at_slide:     '15',                            //OPTIONAL START AT SPECIFIC SLIDE
            start_zoom_adjust:  '3',                            //OPTIONAL TWEAK THE DEFAULT ZOOM LEVEL
            hash_bookmark:      true,                           //OPTIONAL LOCATION BAR HASHES
            font:               'Bevan-PotanoSans',             //OPTIONAL FONT
            debug:              false,                           //OPTIONAL DEBUG TO CONSOLE
            lang:               'en',                           //OPTIONAL LANGUAGE
            maptype:            'watercolor',                   //OPTIONAL MAP STYLE
            css:                'dark.css',     //OPTIONAL PATH TO CSS
            //js:                 'path_to_js/timeline-min.js'    //OPTIONAL PATH TO JS
        });*/
		
		$(document).ready(function() {
			//setting up vars for rocket movement
			margintomove = 0;
			countup = true;
			
			
			
			
			

			});
				
				
		//space effect
		$("body").mousemove(function( event ) {
		var msg = "Handler for .mousemove() called at ";
		msg += event.pageX + ", " + event.pageY;
		
		pagex = (event.pageX) / 4;
		
		pagey = (event.pageY / 5) / 5;
		
		whattomove = pagex + "px " + pagey + "px";
		whattomove2 =  (-1 * pagex ) + "px " + (-1 * pagey ) + "px";
		
		
		$('#body2').css('background-position', whattomove);
		$('body').css('background-position', whattomove2);
		$('#windowHolder').css('background-position', whattomove2);
		$('.button').css('background-position', whattomove2);
		//ending space effect
		
		
		//handleing the rocket movement
		if(countup == true)
		{
			
			if(margintomove > 200) 
			{
			countup = false;
				
			}
			
			margintomove++;
			
		} else 
		{
			if (margintomove < 5) 
			{
			countup = true;
				
			}
			
			margintomove--;
			
			
		}
		
		
		
		$('#rocket').css('margin-left', margintomove);
		//ending rocket effect
		
		
		
	
		
		
		});
		
		