<?php

function getOptionStatus($var, $lang="") {
	global $options_status;
	
	//debug($options_status);
	
	if(isPolylang()) {
		$v = $options_status[getCurrentLanguage(array())];
		
	} else {
		$v = $options_status;
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