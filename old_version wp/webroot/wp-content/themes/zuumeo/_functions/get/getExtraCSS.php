<?php

function getExtraCSS() {
	$return = array();
	
	if(isPhone()) {
		$return[] = '<link rel="stylesheet" href="'.getStylesheetDirectoryURI().'/style-phone.css?'.rand().'" />';
	}
	
	return implode("", $return);
}