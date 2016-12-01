<?php


function getpostarray($nameofpostarray, $limitarray )
{
	if (isset($_POST[$nameofpostarray]))
	{
	$tem = $_POST[$nameofpostarray];
	$oldrocvalues = unserialize(base64_decode($tem));
	$size = count($oldrocvalues); 
	$max1 = $limitarray;
	$i = 0;
		if ($size == $max1)
		{
		$i = 1;	
		}
	}
	return $oldrocvalues;
}


?>