<?php

add_shortcode('word', 'getWord');

function getOptionWord($var, $lang="") {	
	global $options_words;
	
	if(isPolylang() && !empty($options_words)) {
		$v = $options_words[getCurrentLanguage(array())];
	} else {
		$v = $options_words;
	}
	
	//debug($v);
	
	if(isset($v[$var])) {
		$return = do_shortcode($v[$var]);
		
	} else {
		$return = false;
	}
	
	return $return;
}

?>