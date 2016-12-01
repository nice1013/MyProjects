<?php

//getmaster functions
include_once("master.php");
//get cog functions
include_once("cog.php");
//get cm functions
include_once("cm.php");
//get ops functions
include_once("OpsCalculator.php");
include_once("stockcheck.php");

//CheckCreateMasterTable();
$marketData = getMarketData();
solidifyMasterList($marketData);
UpdateDataBase($marketData, 1);
getrest($marketData);
calculateShit();

echo '<html>
<head>
<meta http-equiv="refresh" content="15">
</head>
<body>
</body>
</html>';

?> 
