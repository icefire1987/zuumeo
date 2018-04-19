<?php

function getOptionPage($var, $lang="") {
	global $options_pages;
	
	if(isPolylang()) {
		$v = $options_pages[getCurrentLanguage(array())];
	} else {
		$v = $options_pages;
	}
	
	//debug($v);
	
	if(isset($v[$var])) {
		$return = nl2br(html_entity_decode($v[$var]));
		
	} else {
		$return = false;
	}
	
	return $return;
}

?>