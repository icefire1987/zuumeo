<?php

function createModuleImageList($args) {
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
		
	$o = $args['m_image_list_options'][0];
	$c = $args['config_base'][0];
	
	$con = $o['configs_base'][0];
	$can = $o['configs_canvas'][0];
	$im = $args['m_image_list_images'];
	
	(isset($con['per_row'])) 	? $per_row = $con['per_row'] 	: $per_row = 3;
	(isset($con['shadow'])) 	? $shadow = $con['shadow'] 		: $shadow = false;
	(isset($can['status'])) 	? $canvas = $can['status'] 		: $canvas = false;
	(isset($con['scale'])) 		? $scale = $con['scale'] 		: $scale = 1.0;
	(isset($con['gap'])) 		? $gap = $con['gap'] 			: $gap = 'default';
	
	//debug($can);
	//debug($con);
	//debug($im);
	
	if($gap == 'default') {
		$gap = COL_GAP;
	}
	
	$image_padding = IMAGEPADDING * 2;
	
	
	$max_width = getColumnWidth(array());
	
	if(isset($args['col_w']) && $args['col_w'] < $max_width) {
		$max_width = $args['col_w'];
	}
	
	
	$class_border = '';
	if(isset($c['border']) && $c['border'] == true) {
		$class_border = 'box image_box shadow';
		
		$max_width = $max_width - $image_padding;
	}
	
	
	$w = $w_image = floor(($max_width - ($gap * ($per_row - 1))) / $per_row);	
	
	
	
	
		
	$images = array();
	$i = 0;
	foreach($im AS $v) {
		if($v['image'] > 0) {
			$o = array();
			
			if(isset($v['options'][0])) {
				$o = $v['options'][0];
			}
			
			$m_r = $gap;
			$clearer = '';
			if($i%$per_row == $per_row-1) {
				$m_r = 0;
				
				if($i < sizeof($im)-1) {
					$clearer = clearer($gap);
				}
			}
			
			$h = $h_image = 'auto';
			
			
			
			$class_image_shadow = '';
			if($shadow == true) {
				$class_image_shadow = 'shadow';
				
				$w_image = floor(($w - $image_padding) * $scale);
				$h_image = floor(($h - $image_padding) * $scale);
			
			} else {
				$w_image = floor($w * $scale);
				$h_image = floor($h * $scale);
			}
			
			$image_zoom = wp_get_attachment_image_src($v['image'], "full");
			
			$image_cover = getBestImageSource(array(
				'w'		=> $w_image,
				'id'	=> $v['image'],
			));
			
			
			$image_array = array(
			    'id'		=> $v['image'],
			    'w'			=> $w_image,
			    'size'		=> 'full',
			    'w_dyn'		=> true,
			);
			
			if(isset($args['meta_key'])) {
				//$image_array['post_id'] 	= $page_id;
			    //$image_array['meta_key']	= $args['meta_key'].'_m_image_list_images_'.$i.'_image';
			}
			
			
			$margin_inner = '';
			
			if($canvas == true) {
				if($can['canvas_w'] > 0 && $can['canvas_h'] > 0) {
					$h = floor(($w * $can['canvas_h']) / $can['canvas_w']);
					$image_array['h_box'] = floor((($w * $can['canvas_h']) / $can['canvas_w']) * $scale);
					
				} else {
					$h = $w;
					$image_array['h_box'] = floor($w * $scale);
				}
				
				$image_array['center'] = 1;
				$image_array['fill'] = 1;
			}
			
			
			$link = '';
			if(isset($o['link_intern']) && $o['link_intern'] > 0) {
				$link = '<a href="'.get_permalink($o['link_intern']).'">';
				
			} else if(isset($o['link_extern']) && trim($o['link_extern']) != "") {
				//echo 'xxxxxx'.$o['link'];
				$link = '<a href="'.formatLink($o['link_extern']).'" target="_blank">';
				
			} else if(isset($o['zoom']) && $o['zoom'] == true) {
				$link = '<a href="'.$image_zoom[0].'" rel="shadowbox[]">';
			}
			
			$final_link_image = '';
			if($link != "") {
				$final_link_image = $link.createSpacer(array('w' => '100%', 'h' => '100%')).'</a>';
			}
			
			//debug($image_array);
			
			
			
			$image = createImage($image_array);
			
			$text_below 		= '';
			$text_overlay 		= '';
			$text_mouseover 	= '';
			if(isset($con['text'])) {
			    $final_image_text = createImageText(array(
			    	'title'		=> $o['title'],
			    	'subtitle'	=> $o['subtitle'],
			    	'text'		=> $o['text'],
			    ));
			    
			    if($final_image_text != "") {
			    	switch($con['text']) {
					    case "below":
					    	$text_below = '
					    		'.clearer().'
								<div class="image_text image_text_below">
									'.$final_image_text.'
								</div>
					    	';
					    	break;
					    
					    case "overlay":
					    	$text_overlay_color = '#ffffff';
					    	if($con['overlay_bg_color'] != "") {
						    	$text_overlay_color = 'background:'.$con['overlay_bg_color'].';';
					    	}
					    	
					    	$text_overlay_opacity = '';
					    	if($con['overlay_bg_opacity'] > 0) {
						    	$text_overlay_opacity = 'opacity:'.number_format($con['overlay_bg_opacity']/100, 2, ".", ",").';filter:progid:DXImageTransform.Microsoft.Alpha(opacity='.$con['overlay_bg_opacity'].');';
					    	}
					    	
							if($con['overlay_position'] >= 0) {
							    $overlay_position = 'top:'.$con['overlay_position'].'px;';
							    
							} else {
							    $overlay_position = 'bottom:'.((-1 * $con['overlay_position'])-1).'px;';
							}
					    	
					    	$text_overlay = '
					    		<div class="image_text image_text_overlay" style="'.$overlay_position.'">
									<div class="image_text_overlay_background" style="'.$text_overlay_color.$text_overlay_opacity.'"></div>
									<div class="image_text_overlay_content">
										'.$final_image_text.'
									</div>
								</div>
					    	';
					    	break;
					    
					    case "mouseover":
					    	$text_mouseover = '
					    		<div id="image_text_mouseover_'.$id.'" class="image_text image_text_mouseover">
									'.$final_image_text.'
								</div>
					    	';
					    	break;
					    
					    default:
					    	break;
			    	}
			    }
			}
			
			if(is_numeric($h)) {
				if(isPhone()) {
					$h = ($h*1.5).'px';
					
				} else {
					$h = $h.'px';
				}
			}
			
			if(isAdmin() & isset($args['meta_key'])) {
				$e = addFrontpageEdit(array(
					'id' 			=> $page_id,
					'field'			=> $args['meta_key'],
					'module_type'	=> 'image_list_image',
					'type'			=> 'image',
					'number'		=> $i,
				));
			}
			
			$class_col = floor(12 / $per_row);
			$class_col_gap = 'col_gap col_gap_bottom';
			if($i%$per_row == $per_row-1) {
				$class_col_gap = '';
			}
			
			$images[] = '
				<div class="imagelist_box left relative col_'.$class_col.' '.$class_col_gap.'" style="">
					'.@$e['content'].'
					<div class="imagelist_box_image relative img_rounded col_'.$class_col.' '.$class_image_shadow.'" style="height:'.$h.'; background-image:url('.$image_cover[0].');">
						'.$final_link_image.'
					</div>
					'.$text_overlay.'
					'.$text_mouseover.'
					'.$text_below.'
				</div>
			';
			
			++$i;
		}
	}
	
	$inner_gap = '';
	if(isset($args['config_base'][0]['border']) && $args['config_base'][0]['border'] == true) {
		$inner_gap = clearer($gap);
	}
	
	
	if(isAdmin() & isset($args['meta_key'])) {
		$e_array = array(
	    	'id' 			=> $page_id,
	    	'field'			=> $args['meta_key'],
	    	'column'		=> 1,
	    );
	    
	    if(isset($args['col_w'])) {
		    $e_array['w'] = $args['col_w'];
	    }
	    
	    $e = addFrontpageEdit($e_array);
	}
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
		<div class="relative null '.$class_border.'" style="">
			'.@$e['content'].'
			'.$inner_gap.'
			'.implode("", $images).'
			'.clearer().'
			'.$inner_gap.'
			'.clearer().'
		</div>
		'.clearer().'
		'.setGapBottom($args, @$e['edit_id']).'
		
	';
	
	return $return;
}

?>