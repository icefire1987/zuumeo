<?php

function getOptionText($var, $lang="") {
	global $options_texts;
	
	$v = $options_texts;
	
	if(isPolylang()) {
		if($lang != "") {
			$v = $options_texts[$lang];
			
		} else {
			$v = $options_texts[getCurrentLanguage(array())];
		}	
	}
		
	
	if(isset($v[$var])) {
		$return = do_shortcode($v[$var]);
		
	} else {
		$return = false;
	}
	
	return $return;
}

?>