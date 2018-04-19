<?php

function createImage($args) {
	(isset($args['size'])) 		? $size = $args['size'] 	: $size = 'full';
	(isset($args['w'])) 		? $w = $args['w'] 			: $w = 200;
	(isset($args['h'])) 		? $h = $args['h'] 			: $h = 200;
	(isset($args['float'])) 	? $float = $args['float'] 	: $float = '';
	
	$image = wp_get_attachment_image_src($args['id'], $size);
	$image_full = wp_get_attachment_image_src($args['id'], 'full');
	if($image) {
		$final_w = '';
		$final_h = '';
		if($w > 0) {
			$h = floor(($image[2] * $w) / $image[1]);
		}
		
		if(isset($args['h_box']) && $h < $args['h_box']) {
			$h = $args['h_box'];
			$w = floor(($image[1] * $h) / $image[2]);
		}
		
		$image = getBestImageSource(array(
			'w'		=> $w,
			'id'	=> $args['id'],
		));
			
			
		$final_w = 'width:'.$w.'px;';
		$final_h = 'height:'.$h.'px;';
		
		
		
		$final_w_box = 'width:'.$w.'px;';
		$final_h_box = 'height:'.$h.'px;';
		if(isset($args['w'])) {
			$final_w_box = 'width:'.$args['w'].'px;';
		}
		if(isset($args['h_box'])) {
			$final_h_box = 'height:'.$args['h_box'].'px;';
		}
		
		
		
		$final_position = '';
		if(isset($args['center']) && $w > 0) {
			$final_position = 'position:absolute; left: 50%; top: 50%; margin:-'.floor($h/2).'px 0px 0px -'.floor($w/2).'px;';
		}
		
		
		if(isAdmin() && isset($args['meta_key'])) {
			$e = addFrontpageEdit(array(
				'id' 			=> $args['post_id'],
				'field'			=> $args['meta_key'],
				'type'			=> 'image',
				'meta'			=> 1,
			));
		}
		
		
		$final_sizes = '';
		if(isset($args['set_sizes'])) {
			$final_sizes = $final_w.$final_h;
		}
		
		$return = '<img src="'.$image[0].'" style="'.$final_position.' '.$final_sizes.'" '.@$e['id'].' />';
		
		$shadowbox = '';
		if(isset($args['shadowbox']) && $args['shadowbox'] != false) {
			$shadowbox = 'rel="shadowbox['.$args['shadowbox'].']"';
			$args['link'] = $image_full[0];
		}
		
		if(isset($args['link'])) {
			if(isPageFacebook()) {
				$target = 'target="_blank"';
			} else {
				$target = setLinkExternal($args['link']);
			}
			
			
			$return = '<a href="'.$args['link'].'" '.$target.' '.$shadowbox.'>'.$return.'</a>';
		}
		
		$return = '
			<div class="relative '.$float.'" style="overflow:hidden;'.$final_w_box.$final_h_box.'">
				'.@$e['content'].$return.'
			</div>
		';
		
	} else {
		$return = '';
	}
	
	
	return $return;
}

?>