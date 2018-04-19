<?php

function createModule360Grad($args) {
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	
	$o = $args['m_360grad_options'][0];
	$images = $args['m_360grad_images'];
	
	//debug($args);
	
	if(!empty($images)) {
		$content = array();
		
		(isset($o['mouseover'])) 	? $mouseover = $o['mouseover'] 	: $mouseover = true;
		(isset($o['loop'])) 		? $loop = $o['loop'] 			: $loop = true;
		(isset($o['indicator'])) 	? $indicator = $o['indicator'] 	: $indicator = 0;
		(isset($o['speed'])) 		? $speed = $o['speed'] 			: $speed = 3;
		
		if($speed > 0) {
			$final_speed = number_format($speed/10, 1, ".", ",");
		} else {
			$final_speed = 0;
		}
		
		
		$i = 0;
		foreach($images AS $image) {
			$image_base = wp_get_attachment_image_src($image['image_1'], 'full');
			$image_reel = wp_get_attachment_image_src($image['image_2'], 'full');
			
			if(isAdmin() & isset($args['meta_key'])) {
			    $e_single = addFrontpageEdit(array(
			    	'id' 			=> $page_id,
			    	'field'			=> $args['meta_key'],
			    	'module_type'	=> '360grad_image',
			    	'type'			=> 'image',
			    	'number'		=> $i,
			    ));
			}
			
			$content[] = '
				<div class="relative">
					'.@$e_single['content'].'
					<img src="'.$image_base[0].'" width="'.$image_base[1].'" height="'.$image_base[2].'" class="reel" id="image_reel_'.$i.'" data-image="'.$image_reel[0].'" data-frames="'.$image['frames'].'" data-clickfree="'.$mouseover.'" data-cw="false" data-indicator="'.$indicator.'" data-speed="'.$final_speed.'" data-loops="'.$loop.'">
				</div>
			';
			
			++$i;
		}
		
		$final_content = createModuleShowreel(
			array(
				'content_ready'			=> true,
				'class_col'				=> $args['class_col'],
				'm_showreel_content' 	=> $content,
				'm_showreel_options' 	=> array(
					0						=> array(
						'columns'				=> 1,
						'image'					=> 0,
						'arrow_inset'			=> true,
					),
				),
			)
		);
		
		if(isAdmin() & isset($args['meta_key'])) {
			$e = addFrontpageEdit(array(
			 	'id' 			=> $page_id,
			  	'field'			=> $args['meta_key'],
			  	'module_type'	=> '360grad',
			  	'column'		=> true,
			));
		}
		
		$return = '
			<div class="relative '.$args['class_col'].'">
				'.@$e['content'].'
				'.$final_content.'
			</div>
		';
		
		return $return;
	}
}