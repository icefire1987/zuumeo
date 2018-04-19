<?php

function getOptionAdmin($var, $lang="") {	
	global $options_admin;
	
	//debug($options_admin);
	
	if(isPolylang()) {
		$v = $options_admin[getCurrentLanguage(array())];
	} else {
		$v = $options_admin;
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