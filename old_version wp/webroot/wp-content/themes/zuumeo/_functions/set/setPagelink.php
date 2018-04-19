<?php

function setPagelink($args){
	if(isset($args['url']) && $args['url'] != "") {
		$url = $args['url'];
	
	} else {
		$url = getCurrentURL();
	}
	
	$return = str_replace("[pagelink]", urldecode($url), $args['text']);
	
	return $return;
}

?>