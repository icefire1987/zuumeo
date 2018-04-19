<?php

function getImageDimensions($id) {
	if(is_numeric($id)) {
		$return = '';
	
	} else {
		$info = getimagesize($id);
		$return = number_format($info[0], 0, ",", ".").' x '.number_format($info[1], 0, ",", ".");
	
	}
	
	return $return;
}

?>