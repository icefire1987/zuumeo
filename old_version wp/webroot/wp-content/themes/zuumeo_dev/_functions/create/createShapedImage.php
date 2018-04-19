<?php

add_shortcode('shapedimage', 'createShapedImage');

function createShapedImage($args) {
	if(isset($args['id'])) {
		$image_data = wp_get_attachment_image_src($args['id'], 'medium');
		
		(isset($args['float'])) 	? $float = $args['float'] 	: $float = 'left';
		
		if(isset($args['w'])) {
			$w = $args['w'];
			$h = round(($w * $image_data[2]) / $image_data[1]);
			
		} else {
			$w = $image_data[1];
			$h = $image_data[2];
		}
		
		
		$return = ShapedImage(array(
			'image'		=> $image_data[0],
			'float'		=> $float,
			'w'			=> $w,
			'h'			=> $h,
		));
		
		return $return;
	}
}

?>