<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' .
     DIRECTORY_SEPARATOR . 'Highchart.php';

$chart = new Highchart(Highchart::HIGHSTOCK);

$chart->chart->renderTo = "container";
$chart->rangeSelector->selected = 1;
$chart->title->text = "AAPL Stock Price";
$chart->series[] = array(
    'name' => "AAPL",
	'minPointLength' => 1,
    'data' => array (.00000054, .00000084, .00000023),
    'tooltip' => array('valueDecimals' => 10)
	
);

?>

<html>
    <head>
        <title>Single line series</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php $chart->printScripts(); ?>
    </head>
    <body>
        <div id="container"></div>
        <script type="text/javascript">
            $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function(data) {
                // Create the chart
                window.chart = <?php echo $chart->render(); ?>;
            });
        </script>
    </body>
</html>