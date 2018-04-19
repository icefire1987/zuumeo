<?php

function getOptionGallery($var, $lang="") {	
	global $options_galleries;
	
	$v = $options_galleries;
	
	if(is_array($var)) {
		$var = $var[0];
	}
	
	if(isset($v[$var])) {
		$return = $v[$var];
		
	} else {
		$return = false;
	}
	
	//debug($return);
	
	return $return;
}

?>