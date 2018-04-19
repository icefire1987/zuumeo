<?php

add_shortcode('button', 'createButton');

function createButton($args) {
	if(isset($args['text']) && isset($args['link'])) {
		if(isset($args['alt'])) {
			$alt = $args['alt'];
		
		} else {
			$alt = $args['text'];
		}
		
		$w = '';
		if(isset($args['w'])) {
			if(is_numeric($args['w'])) {
				$w = 'width:'.$args['w'].'px;';
			} else {
				$w = 'width:'.$args['w'].';';
			}
		}
		
		$h = $h_button = '';
		if(isset($args['h'])) {
			if(is_numeric($args['h'])) {
				$h = 'height:'.$args['h'].'px;';
				$h_button = 'height:'.($args['h']-14).'px;';
			} else {
				$h = $h_button = 'height:'.$args['h'].';';
			}
		}
		
		$margin_left = '0px';
		if(isset($args['indent']) && $args['indent'] == 1) {
			$margin_left = '10px';
		}
		
		
		$margin_right = '0px';
		if(isset($args['m_r']) && is_numeric($args['m_r'])) {
			$margin_right = $args['m_r'].'px';
		}
		
		
		$margin_top = '0px';
		if(isset($args['top']) && is_numeric($args['top'])) {
			$margin_top = $args['top'].'px';
		}
		
		
		$rotis = '';
		if(isset($args['rotis']) && $args['rotis'] == 1) {
			$rotis = 'rotis';
		}
		
		$center = '';
		if(isset($args['center']) && $args['center'] == 1) {
			$center = 'selters_button_center';
		}
		
		$float = '';
		if(isset($args['float']) && ($args['float'] == 'left' || $args['float'] == 'right')) {
			$float = ' float:'.$args['float'].';';
		}
		
		if(isset($args['javascript']) && $args['javascript'] == 1) {
			$link = 'javascript:'.$args['link'];
			
		} else {
			if(is_numeric($args['link'])) {
				$link = createPermalink(array('id' => $args['link']));
			
			} else {
				$link = formatLink($args['link']);
			}
		}
		
		if(isset($args['extern']) && $args['extern'] == 1) {
			$target = ' target="_blank"';
			
		} else {
			$target = '';
		}
		
		if(isset($args['no-shadow'])) {
			$shadow = '';
			
		} else {
			$shadow = 'selters_button_shadow';
		}
		
		$return = '
			<div class="selters_button '.$shadow.' '.$center.' '.$rotis.'" style="'.$float.' '.$w.'  '.$h.' margin:'.$margin_top.' '.$margin_right.' 0px '.$margin_left.';">
				<div class="selters_button_inner">
					<a href="'.formatLink($link).'" '.createAltTitleTag($alt).' '.$target.' style="'.$h_button.'">'.$args['text'].'</a>
				</div>
			</div>
		';
		
		$return = str_replace("<p></p>", "", $return);
		$return = trim($return);
		
		return $return;
	}
}

?>