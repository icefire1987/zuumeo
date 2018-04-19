<?php

function getHeaderSlideshow($args) {
	global $page_id;
	
	(isset($args['w'])) ? $w = $args['w'] : $w = 960;
	
	//!GET slideshow_images
	$h = 999999999999;
	$slideshow_images = array();
	if(get_field('slideshow', $page_id)) {
		$images = get_field('slideshow', $page_id);
		
		foreach($images as $image) {
			//debug($image);
			
			$title 			= $image['title'];
			$image_data 	= wp_get_attachment_image_src($image['image'], 'full');
			
			if($image_data) {
				if($image_data[2] < $h) {
					$h = $image_data[2];
					$current_w = $image_data[1];
				}
				
				$slideshow_images[] = array(
					'title'	=> $title,
					'url'		=> $image_data[0],
				);
			}
		}
	}
	
	if(sizeof($slideshow_images) == 0) {
		$image_data 	= wp_get_attachment_image_src(getOptionWord('slideshow_standard_id'), 'full');
		
		$slideshow_images[] = array(
			'title'	=> getOptionWord('slideshow_standard_title'),
			'url'		=> $image_data[0],
		);
		
		$h = $image_data[2];
		$current_w = $image_data[1];
	}
	
	
	$final_h = floor(($h * $w) / $current_w);
	
	
	$return = array(
		'h'		=> $final_h,
		'images'	=> $slideshow_images,
	);
	
	//debug($return);
	
	return $return;
}

?>