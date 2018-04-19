<?php

add_shortcode('clause', 'getOptionClaus');

function getOptionClause($var, $lang="") {	
	global $options_clauses;
	
	//debug($options_words);
	
	if(isPolylang()) {
		$v = $options_clauses[getCurrentLanguage(array())];
	} else {
		$v = $options_clauses;
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