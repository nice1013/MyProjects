

<html>
    <head>
        <title>Single line series</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script language="javascript" type="text/javascript" src="jquery.js"></script>
    <script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="master/jquery.flot.valuelabels"></script>
    <link rel="stylesheet" type="text/css" href="master/plot.css">
       
    </head>
    <body>
         <div id="placeholder" style="width:600px;height:300px"></div>
         <div id="tooltip" style="width:600px;height:300px"></div>
   <?php
	
			$array = array(.00000028, .00000032, .00000045, .00000051, .00000039, .00000021);
			$times = array(1,2,3,4,5,6);
			$data = array();
			for ($i = 0; $i < count($array); $i++)
			{
				$data[] = array($times[$i], number_format($array[$i], 8, '.', ''));
				
			}
		
			?>
        
           <script>
		   var clickedItems = [];
    var d = [{   label: "Fake!",
        data: [[1290802154, 0.3], [1292502155, 0.1]]}];
		
		var obj = <?php echo json_encode($data);?>;
		alert(obj);
		var dothis = [{   label: "DOGE",
        data: obj }];
		
		 var options = {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
            }
        },
		valueLabels: {
   		show: true
  		},
        grid: {
            hoverable: true,
            clickable: true
        }
    };
	
	
	
       $( document ).ready(function() {
 
		
		$.plot($("#placeholder"), dothis, options );
	 });
	 

	 function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
	 var previousPoint = null;
    $("#placeholder").bind("plothover", function(event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) {
            if (previousPoint != item.datapoint) {
                previousPoint = item.datapoint;

                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(8),
                    y = item.datapoint[1].toFixed(8),
                    //set default content for tooltip
                    content = item.series.label + " of " + x + " = " + y;
                
                // if there is a cached item object at this index use it instead
                if(clickedItems[item.dataIndex])
                    content = clickedItems[item.dataIndex].alternateText;
                //now show tooltip
                showTooltip(item.pageX, item.pageY, content);
            }
        }
        else {
            $("#tooltip").remove();
            previousPoint = null;
        }

    });
	 
	 
	 
	 
	 
        </script>
   
        
    </body>
</html>
