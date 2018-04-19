<?php

function formatDateTime($array) {
	$format				= '%d. %B %Y'; 
	$lang					= $GLOBALS['lang_standard'];
	$date 				= '0';
	$error				= '';
	$to					= '-';
	$prefix				= '';
	$result 				= '';
	$new_line			= 0;
	$gap_date_time 	= ', ';
	$gap_time_time 	= ' - ';
	$time					= "00:00:00";
	$time_to				= "00:00:00";
	
	foreach ($array AS $array_var => $array_value) { ${$array_var} = $array_value; }
	
	setLocales();
	
	$result = formatDate(array(
		'date'	=> $date,
	));
	
	if(strftime("%H", strtotime($time)) != "00" || strftime("%M", strtotime($time)) != "00") {
		$result .= $gap_date_time.(int)strftime("%I", strtotime($time));
		
		if(strftime("%M", strtotime($time)) > 0) {
			$result .= ":".strftime("%M", strtotime($time));
		};
		
		$result .= strtolower(strftime(" %p", strtotime($time)));
	}
	
	if(strftime("%H", strtotime($time_to)) != "00" || strftime("%M", strtotime($time_to)) != "00") {
		$result .= $gap_time_time.(int)strftime("%I", strtotime($time_to));
		
		if(strftime("%M", strtotime($time_to)) > 0) {
			$result .= ":".strftime("%M", strtotime($time_to));
		};
		
		$result .= strtolower(strftime(" %p", strtotime($time_to)));
	}
	
	if(trim($prefix) != "") {
		$result = trim($prefix).' '.$result;
	}
	
	if($new_line > 0) {
		$result = '<br>'.$result;
	}
	
	return $result;
}

?>