<?php
function querycount($query, $db)
{
	$count = 0;
	
	$result = $db->query($query);
	$t = mysqli_fetch_all($result, MYSQL_BOTH);
	
	return $t[0][0];
}


?>