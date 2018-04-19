<?php

function formatDate($array) {
	$format			= '%d/%m/%y'; 
	$date 			= '0';
	$date_to 		= '0';
	$error			= '';
	$to				= '-';
	$praefix			= '';
	$result 			= '';
	$month_only		= 0;
	$new_line		= 0;
	
	
	foreach ($array AS $array_var => $array_value) { ${$array_var} = $array_value; }
	
	if(!isset($array['locales_off'])) {
		setLocales();
	}
	
	$date 		= remove_wbr(trim($date));
	$date_to 	= remove_wbr(trim($date_to));
	
	
	if ($date != 0) {
		$result = strftime($format, strtotime($date));
	}
	
	if ($date_to != 0) {
		$result .= " $to " .strftime($format, strtotime($date_to));
	}
	
	$result = $praefix.$result;
	
	if($new_line > 0) {
		$result = '<br>'.$result;
	}
	
	return $result;
}



function formatDayEnglish($date) {
	switch (strftime("%d", strtotime($date))) { 
		case 1: $th = 'st'; break; 
		case 2: $th = 'nd'; break; 
		case 3: $th = 'rd'; break; 
		default: $th = 'th'; break; 
	}
	
	$return = '%d/%m/%y'; 
	
	return $return;
}

?>