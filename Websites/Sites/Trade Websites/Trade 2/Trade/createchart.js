function main() {

var clickedItems = [];
    var d = [{   label: "Fake!",
        data: [[1290802154, 0.3], [1292502155, 0.1]]}];
		
		var obj = <?php echo json_encode($data);?>;
		var obj1 = <?php echo json_encode($data1);?>;
		var obj2 = <?php echo json_encode($data2);?>;
		var dothis = [{ label: "L50:",
        				data: obj, 
						lines:{show:true}
						},
						{
						label: "L200:",
        				data: obj1, 
						lines:{show:true}	
						},
						{
						label: "l1000:",
        				data: obj2, 
						lines:{show:true}	
						}	
					 ];
		 var options = {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
            }
        },
		legend:{position:'ne'},
		valueLabels: {
   		show: false
  		},
        grid: {
            hoverable: true,
            clickable: true
        },
		 zoom: {
            interactive: true
        },
        pan: {
            interactive: true
        },
        yaxis: {
            zoomRange: [0.1, 10],
            panRange: [-1, 11]
        },
		homeRange: {xmin:-10,xmax:10,ymin:-10,ymax:10},
    	panAmount: 100,
    	zoomAmount: 1.5,
    	position: {right: "20px", top: "20px"
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
            opacity: 0.5
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
                var x = item.datapoint[0].toFixed(15),
                    y = item.datapoint[1].toFixed(15),
                    //set default content for tooltip
                    content = item.series.label + y;
                
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

}//end main function
	 
	 
	 