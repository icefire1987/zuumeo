<?php

function getAllImageSources($args){
	global $_wp_additional_image_sizes;
	
	$all_sizes = array();
	
	if(!empty($_wp_additional_image_sizes)) {
		foreach($_wp_additional_image_sizes AS $size => $size_values) {
			if(!isset($size_values['crop']) || (isset($size_values['crop']) && $size_values['crop'] === false)) {
				$all_sizes[$size] = $size_values['width'];
			}
		}
	}
		
	asort($all_sizes);
		
	return $all_sizes;
}

?>