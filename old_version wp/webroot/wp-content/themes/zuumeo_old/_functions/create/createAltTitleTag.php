<?php

function createAltTitleTag($args) {
	$alt = '';
	$title = '';
	
	if(!is_array($args)) {
		$alt = $args;
		$title = $args;
	
	} else {
		if(isset($args['alt'])) {
			$alt = $args['alt'];
		}
		
		if(isset($args['title'])) {
			$title = $args['title'];
		}
	}
	
	$alt = str_replace("\"", "'", $alt);
	$title = str_replace("\"", "'", $title);
	
	$return = 'alt="'.addslashes($alt).'" title="'.addslashes($title).'"';
		
	return $return;
}

?>