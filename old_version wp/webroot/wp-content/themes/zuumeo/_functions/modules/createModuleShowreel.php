<?php


function createModuleShowreel($args){
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	//debug($args);
	
	$c = $args['m_showreel_content'];
	
	$c_logo_h = 0.3;
	
	if(!empty($c)) {
		$o = $args['m_showreel_options'][0];
		
		$content = array();
		$i = 0;
		$w_inner = 300;
		$top_arrow = '';
		
		$class_col = 'col_12';
		$cols_content = 12;
		if(isset($args['class_col'])) {
			$class_col = $args['class_col'];
			
			//$cols_content = floor(12 / $o['columns']);
			
			$cols_content = str_replace('col_', '', $class_col);
		}
		
		$class_inset = '';
		$left_inset = '';
		$first_left = 0;
		if(isset($o['image']) && $o['image'] > 0) {
			$class_inset = 'col_showreel_inset';
			
			$first_left = 45;
			$left_inset = 'left:'.$first_left.'px;';
		}
		
		
		foreach($c AS $c_key => $c_value) {
			//debug($c_value);
			
			$c_w = getColumnWidth(array('columns' => $cols_content));
			
			$class = '';
			if($i > $o['columns']-1) {
				$class = 'hidden';
			}
			
			$final_class_col = 'col_showreel_'.$o['columns'].' '.$class_inset;
			if($class_col != "col_12") {
				if($o['columns'] == 1) {
					$final_class_col = $class_col;
					
				} else {
					$final_class_col = 'col_showreel_'.floor((12/$cols_content)*$o['columns']).' '.$class_inset;
				}
			}
			
			
			
			if(isset($args['content_ready'])) {
				$final_showreel_content	= $c_value;
				
			} else {
				if(isAdmin() & isset($args['meta_key'])) {
				    $e_single = addFrontpageEdit(array(
				    	'id' 			=> $page_id,
				    	'field'			=> $args['meta_key'],
				    	'module_type'	=> 'showreel_image',
						'type'			=> 'image',
						'number'		=> $i,
				    ));
				}
				
				
				$image = '';
				if($c_value['logo'] > 0) {
					if(isset($c_value['scale']) && $c_value['scale'] > 0) {
						$logo_scale = $c_value['scale'].'%';
					} else {
						$logo_scale = 'contain';
					}
					
					if($o['h'] > 0 && $o['w'] > 0) {
						$c_h = round(($c_w*$o['h']) / $o['w']);
						$logo_scale = 'cover';
					
					} else if($o['h'] > 0 && $o['w'] <= 0) {
						$c_h = $o['h'];
						
					} else {
						$c_h = round($c_w * $c_logo_h);
					}
					
					
					$logo = getBestImageSource(array(
						'id'	=> $c_value['logo'],
						'w'		=> $c_w,
						'h'		=> $c_h,
					));
					
					$title 		= get_post_meta($c_value['logo'], 'attachment_extra_content_0_attachment_title', true);
					if($title == "") {
						$title 		= get_the_title($c_value['logo']);
					}
					
					
					if($o['image'] > 0) {
						$top_arrow = 'top:'.floor($c_h/2 + 20).'px;';
					} else {
						$top_arrow = 'top:'.floor($c_h/2).'px;';
					}
					
					
					$h_img = $c_h;
					if(isset($c_value['scale']) && $c_value['scale'] > 0) {
						$h_img = floor($h_img * ($c_value['scale']/100));
					}
					
					$final_image = '<img src="'.$logo[0].'" style="height:'.$h_img.'px;" title="'.$title.'" alt="'.$title.'"  />';
					if(isset($c_value['page']) && $c_value['page'] > 0) {
						$link = '
							<a href="'.get_permalink($c_value['page']).'">'.$final_image.'</a>
						';
					}
					
					$c_h_final = $c_h.'px';
					if($class_col != "col_12") {
						//$c_h_final = 'auto';
					}
					
					$image = '
						<div class="showreel_image box img_rounded noselect '.$final_class_col.'" style="height:'.$c_h_final.';">
							<table cellpadding="0" cellspacing="0" align="center" style="width:100%; height:100%; text-align:center; vertical-align:center;" border="0">
								<tr>
									<td>'.$final_image.'</td>
								</tr>
							</table>
						</div>
					';
				}
				
				
				$text_below 		= '';
				$text_overlay 		= '';
				$text_mouseover 	= '';
				if($o['text'] != "none") {
					$final_image_text = createImageText(array(
				    	'title'		=> $c_value['title'],
				    	'subtitle'	=> $c_value['subtitle'],
				    	'text'		=> $c_value['text'],
				    ));
					
					
					if($final_image_text != "") {
						switch($o['text']) {
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
						    	if($o['overlay_bg_color'] != "") {
							    	$text_overlay_color = 'background:'.$o['overlay_bg_color'].';';
						    	}
						    	
						    	$text_overlay_opacity = '';
						    	if($o['overlay_bg_opacity'] > 0) {
							    	$text_overlay_opacity = 'opacity:'.number_format($o['overlay_bg_opacity']/100, 2, ".", ",").'; filter: alpha(opacity='.$o['overlay_bg_opacity'].');';
						    	}
						    	
						    	if($o['overlay_position'] >= 0) {
								    $overlay_position = 'top:'.$o['overlay_position'].'px;';
								    
								} else {
								    $overlay_position = 'bottom:'.((-1 * $o['overlay_position'])-1).'px;';
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
						    		<div id="image_text_mouseover_'.$c_key.'" class="image_text image_text_mouseover">
										'.$final_image_text.'
									</div>
						    	';
						    	break;
						    
						    default:
						    	break;
				    	}
					}
				}
				
				$final_showreel_content = '
					'.@$e_single['content'].'
					'.$image.'
					'.$text_overlay.'
					'.$text_mouseover.'
					'.$text_below.'
				';
			}
			
			
			$content[] = '
				<div id="showreel_'.$i.'" class="relative left showreel_content '.$final_class_col.' col_gap '.$class.'" style="'.$left_inset.'">
					'.$final_showreel_content.'
				</div>
			';
			
			$w_inner = $w_inner + COL_GAP + getColumnWidth(array('columns' => $cols_content));
			
			++$i;
		}
		
		$class_showreel_right = '';
		if($i < $o['columns']) {
			$class_showreel_right = 'showreel_arrow_inactive';
		}
		
		$bg_image = '';
		$showreel_position = 'relative';
		$overlay_position = '';
		$showreel_padding = 'padding:0px;';
		$showreel_content_background = '';
		$showreel_arrow_inset = '';		
		$showreel_h = 'auto';
		$overlay_position_left = 0;
		
		if(isset($o['arrow_inset'])) {
			$showreel_arrow_inset = 'showreel_arrow_inset';
		}
		
		if(isset($o['image']) && $o['image'] > 0) {
			$overlay_position_left = 1;
			$showreel_padding = '';
			$showreel_arrow_inset = 'showreel_arrow_inset';
			
			if($o['overlay_position'] >= 0) {
			    $overlay_position = 'top:'.$o['overlay_position'].'px;';
			    
			} else {
			    $overlay_position = 'bottom:'.((-1 * $o['overlay_position'])-1).'px;';
			}
			
			
			$showreel_position = 'absolute';
			
			$image = getBestImageSource(array(
				'w'		=> getColumnWidth(array()),
				'id'	=> $o['image'],
			));
			
			$showreel_h = $image[2].'px';
			
			$bg_image = '<img src="'.$image[0].'" class="'.$class_col.' img_rounded noselect" />';
			
			
			($o['overlay_bg_color'] == '') ? $content_bgcolor = '#ffffff' : $content_bgcolor = $o['overlay_bg_color'];
			$opacity = number_format($o['overlay_bg_opacity']/100, 2, ".", ",");
			
			if($opacity > 0) {
				$showreel_content_background = '<div class="absolute showreel_content_background" style="background:'.$content_bgcolor.'; opacity:'.$opacity.'; filter: alpha(opacity='.$o['overlay_bg_opacity'].');"></div>';
			}
		}
		
		
		
		
		if(isAdmin() & isset($args['meta_key'])) {
		    $e = addFrontpageEdit(array(
		    	'id' 			=> $page_id,
		    	'field'			=> $args['meta_key'],
		    	'columns'		=> 1,
		    	'module_type'	=> 'showreel',
		    	'label'			=> 'Showreel',
		    ));
		}
		
		
		$arrow_left = '';
		$arrow_right = '';
		$arrow_left_inset = '';
		$arrow_right_inset = '';
		if(sizeof($c) > $o['columns']) {
			$arrow_left = $arrow_left_inset = '
				<div id="showreel_left" class="noselect absolute showreel_arrow showreel_arrow_inactive showreel_arrow_left '.$showreel_arrow_inset.' hand" style="'.$top_arrow.'" onclick="moveShowreel({ direction:\'left\' })"></div>
			';
			
			$arrow_right = $arrow_right_inset = '
				<div id="showreel_right" class="'.$class_showreel_right.' noselect absolute right showreel_arrow showreel_arrow_right '.$showreel_arrow_inset.' hand" style="'.$top_arrow.'" onclick="moveShowreel({ direction:\'right\' })"></div>
				<input type="hidden" id="showreel_count" value="'.sizeof($content).'">
				<input type="hidden" id="showreel_columns" value="'.$o['columns'].'">
				<input type="hidden" id="showreel_first_left" value="'.$first_left.'">
			';
		}
		
		if($o['image'] > 0 || isset($o['arrow_inset'])) {
		   $arrow_left = '';
		   $arrow_right = '';
		
		} else {
		   $arrow_left_inset = '';
		   $arrow_right_inset = '';
		}
		
		$return = '
			'.setGapTop($args, @$e['edit_id']).'
			<div class="relative null">
				'.@$e['content'].'
				<div class="relative showreel null" style="height:auto;">
					'.$bg_image.'
					'.$arrow_left.'
					<div class="'.$showreel_position.' '.$class_col.' showreel_contents" style="'.$overlay_position.' left:'.$overlay_position_left.'px;">
						'.$arrow_left_inset.'
						'.$showreel_content_background.'
						<div id="showreel" class="relative showreel_contents_inner '.$class_col.'" style="width:'.$w_inner.'px; '.$showreel_padding.'">
							'.implode("", $content).'
							'.clearer().'
						</div>
						'.$arrow_right_inset.'
					</div>
					'.$arrow_right.'
				</div>
			</div>
			<div id="test"></div>
			'.setGapBottom($args, @$e['edit_id']).'
			'.clearer().'
		';
		
		return $return;
	}
}

?>