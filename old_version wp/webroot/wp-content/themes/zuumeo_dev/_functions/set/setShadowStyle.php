<?php

function setShadowStyle($w) {
	$w = 10 * floor($w/10);
	
	$img = '/_images/_shadows/shadow-'.$w.'.png';
	$img_rel = get_stylesheet_directory().$img;
	
	if(file_exists($img_rel)) {
		$img_info = getimagesize($img_rel);
		$img_h = $img_info[1];
		
		$return = 'padding-bottom: '.$img_h.'px; background: transparent url('.get_stylesheet_directory_uri().$img.') center bottom no-repeat;';
		
		return $return;
	}
}

?>