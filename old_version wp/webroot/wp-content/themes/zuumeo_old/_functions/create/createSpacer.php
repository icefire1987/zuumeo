<?php

function createSpacer($args) {
	(isset($args['w'])) 		? $w = $args['w'] 			: $w = 1;
	(isset($args['h'])) 		? $h = $args['h'] 			: $h = 1;
	(isset($args['class'])) 	? $class = $args['class'] 	: $class = "";
	
	(is_numeric($w)) ? $w = $w.'px' : "";
	(is_numeric($h)) ? $h = $h.'px' : "";
	
	$return = '<img src="'.get_stylesheet_directory_uri().'/_images/spacer.gif" style="width:'.$w.'; height:'.$h.';" class="'.$class.'" />';
	
	return $return;
}

?>