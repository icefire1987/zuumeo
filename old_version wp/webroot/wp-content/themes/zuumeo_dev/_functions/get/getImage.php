<?php

function getImage($args) {
	$size = 'full';
	if(isset($args['size'])) {
		$size = $args['size'];
	}
	
	
	$img_src = wp_get_attachment_image_src($args['id'], $size);
	
	if($img_src) {
		if(!isset($args['alt'])) {
			$alt = get_the_title($args['id']);
		} else {
			$alt = $args['alt'];
		}
		
		$float = '';
		$float_class = '';
		if(isset($args['float'])) {
			$float = ' float:'.$args['float'].';';
			$float_class = $args['float'];
		}
		
		
		$img_class = '';
		if(isset($args['img_class'])) {
			$img_class = $args['img_class'];
		}
		
		
		
		if(isset($args['w_max'])) {
			if($img_src[1] > $args['w_max']) {
				$w = ' width:'.$args['w_max'].'px;';
			
			}
			
		} else if(isset($args['w'])) {
			$w = ' width:'.$args['w'].'px;';
			
		} else {
			$w = ' width:'.$img_src[1].'px;';
		}
		
		$onmouseover = '';
		if(isset($args['onmouseover'])) {
			$onmouseover = ' onmouseover="'.$args['onmouseover'].'"';
		}
		
		$onmouseout = '';
		if(isset($args['onmouseout'])) {
			$onmouseout = ' onmouseout="'.$args['onmouseout'].'"';
		}
		
		$onmousemove = '';
		if(isset($args['onmousemove'])) {
			$onmousemove = ' onmousemove="'.$args['onmousemove'].'"';
		}
		
		$shadow = '';
		if(isset($args['shadow'])) {
			$shadow = $args['shadow'];
		}
		
		(isset($args['m_t']) && is_numeric($args['m_t'])) ? $m_t = $args['m_t'] : $m_t = 0;
		(isset($args['m_r']) && is_numeric($args['m_r'])) ? $m_r = $args['m_r'] : $m_r = 0;
		(isset($args['m_b']) && is_numeric($args['m_b'])) ? $m_b = $args['m_b'] : $m_b = 0;
		(isset($args['m_l']) && is_numeric($args['m_l'])) ? $m_l = $args['m_l'] : $m_l = 0;
		
		
		$return = '<img class="'.$float_class.' '.$img_class.'" style="'.$shadow.' '.$w.' margin:'.$m_t.'px '.$m_r.'px '.$m_b.'px '.$m_l.'px;" src="'.$img_src[0].'" '.createAltTitleTag($alt).' />';
		
		if(isset($args['link']) && $args['link'] != "") {
			if(!isset($args['target'])) {
				if(isLinkExternal($args['link'])) {
					$final_target = ' target="_blank"';
					
				} else {
					$final_target = '';	
				}
				
			} else if(isset($args['target']) && $args['target'] == "") {
				$final_target = '';
		
			} else {
				$final_target = ' target="'.$args['target'].'"';
			}
			
			
			if(isset($args['extern'])) {
				$final_target = ' target="_blank"';
			}
		
			$return = '<a href="'.formatLink($args['link']).'" '.$final_target.' '.$onmouseover.' '.$onmouseout.' '.$onmousemove.'>'.$return.'</a>';
		}
		
		return $return;
	}
}

?>