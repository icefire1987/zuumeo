<?php

$i_galleria = 1;

function createGalleria($args) {
	global $i_galleria;
	
	if(isset($args['images']) && is_array($args['images']) && sizeof($args['images']) > 0) {
		//debug($args);
		
		$o = array();
		if(isset($args['options'])) {
			$o = $args['options'];
		}
		
		//debug($options);
		
		
		(isset($args['config'])) 	? $c = $args['config'] 			: $c = array();
		
		(isset($c['view'])) 		? $view = $c['view'] 			: $view = 'full';
		
		(isset($o['w']) && $o['w'] > 0) 	? $w = $o['w'] 			: $w = 640;
		(isset($o['h']) && $o['h'] > 0) 	? $h = $o['h'] 			: $h = 480;
		
		
		(isset($t['w']) && $t['w'] >0) 		? $w_t = $t['w'] 		: $w_t = 100;
		(isset($t['h']) && $t['h'] >0) 		? $h_t = $t['h'] 		: $h_t = 60;
		(isset($t['gap']) && $t['gap'] >0) 	? $gap_t = $t['gap'] 	: $gap_t = 3;
		(isset($t['thumbs_per_row']) && $t['thumbs_per_row'] >0) 	? $thumbs_per_row = $t['thumbs_per_row'] 	: $thumbs_per_row = 3;
		
		//debug($args['images']);
		//debug($o);
		
		if(isset($args['configs']['col_w']) && $args['configs']['col_w'] > 0) {
		   $h = floor(($args['configs']['col_w']*$h) / $w);
		   $w = $args['configs']['col_w'];
		
		}
		
		$gallery = array();
		$thumbs = array();
		$i = 0;
				
		foreach($args['images'] AS $image) {
			$image_data = getBestImageSource(array(
				'w'		=> $w,
				'h'		=> $h,
				'id'	=> $image,
			));
			
			$image_data_big 		= wp_get_attachment_image_src($image, 'full');
			$image_data_thumb 		= wp_get_attachment_image_src($image, 'custom_2');
			
			
			if($image_data[0] == $image_data_big[0] && isset($o['alt_size'])) {
				$image_data 		= wp_get_attachment_image_src($image, $o['alt_size']);
			}
			
			if($image_data_thumb[0] == $image_data_big[0]) {
				$image_data_thumb 	= wp_get_attachment_image_src($image, "thumbnail");
			}
			
			$alt 		= get_post_meta($image, '_wp_attachment_image_alt', true);
			$title 		= get_the_title($image);
			
			$final_alt = '';
			if($alt != "") {
				$final_alt = ' alt="'.addslashes($alt).'"';
			}
			
			$image_title = 'title: "'.$title.'", description: "'.$title.'", ';
			if(isset($args['titles'])) {
				$image_title = 'title: "'.$args['titles'][$i].'", alt: "'.$args['titles'][$i].'", ';
			}
				
			if($image_data) {
				$data[] = '{'.$image_title.'thumb: "'.$image_data_thumb[0].'", image: "'.$image_data[0].'", big: "'.$image_data_big[0].'"}';
				
				if(isset($o['thumbnails']) && $o['thumbnails'] == 1) {
					$thumb = createImage(array(
						'id'		=> $image,
						'w'			=> $w_t,
						/* 'h_box'		=> $h, */
						'size'		=> 'medium',
						'center'	=> 1,
						'shadowbox'	=> 1,
					));
					
					$m_r = $gap_t;
					if($i%$thumbs_per_row-1 == 1) {
						$m_r = 0;
					}
					
					$thumbs[] = '
						<div class="thumb shadow left nofont relative" style="width:'.$w_t.'px; height:'.$h_t.'px; margin: 0px '.$m_r.'px '.$gap_t.'px 0px;">
		  					'.$thumb.'
	 					</div>
	 				';
				}
				
				++$i;
			}
		}
		
		//debug($data);
				
		if($i > 0) {
			$option_autoplay = 'autoplay: false,';
			if(isset($o['autoplay']) && $o['autoplay'] == 1 && getOptionNumber('galleria_autoplay')) {
			    $option_autoplay = 'autoplay:'.getOptionNumber('galleria_autoplay').',';
			}
			
			$option_caroussel = 'caroussel: true,';
			if(isset($o['caroussel']) && $o['caroussel'] == 0) {
			    $option_caroussel = 'caroussel:false,';
			}
			
			$option_initial_transition = 'initialTransition: "fade",';
			if(isset($o['initial_transition']) && $o['initial_transition'] != "") {
				$option_initial_transition = 'initialTransition: "'.$o['initial_transition'].'",';
			
			} else if(getOptionWord('galleria_initial_transition')) {
			    $option_initial_transition = 'initialTransition: "'.getOptionWord('galleria_initial_transition').'",';
			}
			
			$option_transition = 'transition: "fade",';
			if(isset($o['transition']) && $o['transition'] != "") {
				$option_transition = 'transition: "'.$o['transition'].'",';
			
			} else if(getOptionWord('galleria_transition')) {
			    $option_transition = 'transition: "'.getOptionWord('galleria_transition').'",';
			}
			
			$option_transitionspeed = 'transitionSpeed: 800,';
			if(isset($o['transition_speed']) && $o['transition_speed'] > 0) {
				$option_transitionspeed = 'transitionSpeed: '.$o['transition_speed'].',';
			
			} else if(getOptionNumber('galleria_transition_speed')) {
			    $option_transitionspeed = 'transitionSpeed: "'.getOptionNumber('galleria_transition_speed').'",';
			}
			
			$option_lightbox = 'lightbox:false,';
			if(isset($o['zoom']) && $o['zoom'] == 1) {
				$option_lightbox = 'lightbox:true,';
			}
			
			$option_pan = 'imagePan:false,';
			if(isset($o['pan']) && $o['pan'] == 1) {
			    $option_pan = 'imagePan:true,';
			}
			
			$option_caption = 'showInfo:true,';
			if(isset($args['caption'])) {
			    $option_caption = 'showInfo:'.$args['caption'].',';
			}
			
			$option_thumbnails = 'thumbnails:false,';
			$style_thumbnails = '';
			if(isset($o['thumbnails']) && $o['thumbnails'] == 1) {
			    $option_thumbnails = 'thumbnails:true,';
			    
			    $stage_bottom = 51;
			    if(defined("GALLERIA_THUMBS_H")) {
			    	$stage_bottom = GALLERIA_THUMBS_H + 1;
			    }
			    $style_thumbnails = '<style>#'.$args['id'].' .galleria-stage { bottom: '.$stage_bottom.'px; }</style>';
			    $h = $h + 51;
			}
			
			$return['count'] = sizeof($gallery);
			
			//debug($gallery);
			
			$cols = 12;
			$class_col = '';
			if(isset($args['configs']['class_col'])) {
				$class_col = $args['configs']['class_col'];
				
			} else if(isset($args['configs']['config_base'][0]['columns']) && $args['configs']['config_base'][0]['columns'] > 0) {
				$class_col = 'col_'.$args['configs']['config_base'][0]['columns'];
			}
			
			$return['images'] = '
			    <div id="'.$args['id'].'" class="galleria relative '.$class_col.'" style="height:'.$h.'px; ">
			    	'.implode("", $gallery).'
				</div>
				<script>
			    	var data = ['.implode(",", $data).'];
			    	Galleria.run("#'.$args['id'].'", {
			    		dataSource: data,
			    		id: "'.$args['id'].'",
			    		width: "100%",
			    		height: '.$h.',
			    		'.$option_autoplay.'
			    		'.$option_lightbox.'
			    		'.$option_caption.'
			    		'.$option_pan.'
			    		'.$option_thumbnails.'
			    		'.$option_caroussel.'
			    		'.$option_transitionspeed.'
			    		'.$option_transition.'
			    		'.$option_initial_transition.'
			    		showCounter: false,
			    		showInfo: false,
			    		showImagenav: true,
			    		wait: true,
			    		extend: function() {
			    			this.bind("image", function(e) {
			    				//galleriaControl({ id:\''.$args['id'].'\', type:\'\' });
			    			});
			    		}
			    	});
			    </script>
			    '.$style_thumbnails.'
			';
			
			++$i_galleria;
			
			return $return;
		}
	}
}

?>