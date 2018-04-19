<?php

function getBestImageSource($args){
	if(isset($args['id']) && (isset($args['w']) || isset($args['h']))) {
		global $all_image_sizes;
		//debug($all_image_sizes);
		
		$id = $args['id'];
		
		(isset($args['w'])) ? $w = $args['w'] : $w = 0;
		(isset($args['h'])) ? $h = $args['h'] : $h = 0;
		
		global $_wp_additional_image_sizes;
		$sizes = get_intermediate_image_sizes();
		
		//echo '<p>w:'.$w.'<br>h:'.$h;
		
		$return = '';
		
		$new_sizes = array();
		
		$image_data = $image_data_full = wp_get_attachment_image_src($id, "full");
		$new_sizes['full']['w'] = $image_data[1];
		$new_sizes['full']['h'] = $image_data[2];
		
		if(!empty($_wp_additional_image_sizes)) {
			foreach($_wp_additional_image_sizes AS $size => $size_values) {
				if(!isset($size_values['crop']) || (isset($size_values['crop']) && $size_values['crop'] === false)) {
					$new_sizes[$size]['w'] = $size_values['width'];
					$new_sizes[$size]['h'] = $size_values['height'];
				}
			}
		}
		
		asort($new_sizes);
		
		
		//debug($new_sizes);
		//debug($_wp_additional_image_sizes);
		
		foreach($new_sizes AS $size => $size_value) {
			$image_data = wp_get_attachment_image_src($id, $size);
			
			if($image_data[1] >= $w) {
				//echo '<p>'.$id.':'.$size.'_w:'.$image_data[1].'_h:'.$image_data[2].'___'.$image_data[0];
				
				if($h > 0) {
					if($image_data[2] >= $h) {
						$return = $image_data;
						break;
					}
					
				} else {
					$return = $image_data;
					break;
				}
			}
		}
		
		if($return == "") {
			$return = $image_data_full;
		}
		
		//debug($return);
		
		return $return;
	}
}

?>