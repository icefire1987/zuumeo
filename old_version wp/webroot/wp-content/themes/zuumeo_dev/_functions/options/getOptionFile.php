<?php

add_shortcode('file', 'getOptionFile');

function getOptionFile($var, $lang="", $path="") {	
	global $options_files;
	$return = '';
	
	//debug($options_files);
	
	$v = $options_files;
	
	if(is_array($var)) {
		$var = $var[0];
	}
	
	if(isPolylang()) {
		if($lang == "") {
			$lang = getCurrentLanguage(array());
		}
	}
	
	
	if(isPolylang()) {
		$return = $v[$lang][$var];
		
	} else {
		$return = $v[$var];
	}	
	
	if($path != "") {
		$image_data 	= wp_get_attachment_image_src($return, 'full');
		$url 			= $image_data[0];
		$w 				= $image_data[1];
		$h 				= $image_data[2];
		
		if($path == "url") {
			$return 	= $url;
			
		} else if($path == "w") {
			$return 	= $w;
			
		} else if($path == "h") {
			$return 	= $h;
			
		} else if($path == "array") {
			$return = array(
				'url'	=> $url,
				'w'		=> $w,
				'h'		=> $h,
			);
		}
	}
	
	return $return;
}

?>