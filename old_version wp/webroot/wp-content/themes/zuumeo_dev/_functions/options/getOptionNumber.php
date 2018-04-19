<?php

add_shortcode('number', 'getNumber');

function getOptionNumber($var, $lang="") {
	global $options_numbers;
	
	if(isPolylang()) {
		$v = $options_numbers[getCurrentLanguage(array())];
	} else {
		$v = $options_numbers;
	}
	
	//debug($v);
	
	if(isset($v[$var])) {
		$return = $v[$var];
		
	} else {
		$return = false;
	}
	
	return $return;
}

?>