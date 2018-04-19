<?php

function getOptionColor($var, $lang="") {	
	global $options_colors;
	$return = '';
	
	//debug($options_files);
	
	$v = $options_colors;
	
	if(is_array($var)) {
		$var = $var[0];
	}
	
	if(isPolylang()) {
		if($lang == "") {
			$lang = getCurrentLanguage(array());
		}
	}
	
	
	if(isset($v[$lang][$var]) && isPolylang()) {
		$return = $v[$lang][$var];
		
	} else if(isset($v[$var])) {
		$return = $v[$var];
	}	
	
	return $return;
}

?>