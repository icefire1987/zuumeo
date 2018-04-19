<?php

add_shortcode('download', 'createDownload');

function createDownload($args) {
	$return = '';
	
	if(isset($args['id'])) {
		$args['link'] = get_permalink($args['id']);
	}
	
	if(isset($args['link'])) {
		(isset($args['text'])) ? $text = $args['text'] : $text = '';
		
		if(isset($args['extern']) && $args['extern'] == 1) {
			$target = 'target="_blank"';
		} else {
			$target = setLinkExternal($args['link']);
		}
		
		$icon = '';
		$class = '';
		$icon_pos = '';
		if(isset($args['icon'])) {
			$icon_url = get_stylesheet_directory().'/_images/icon_'.$args['icon'].'.png';
			
			if(file_exists($icon_url)) {
				$icon = 'background-image:url('.getStylesheetDirectoryURI().'/_images/icon_'.$args['icon'].'.png);';
			
				$class = 'icon';
				
				$icon_pos = 'icon_left';
				(isset($args['icon_pos'])) ? $icon_pos = 'icon_'.$args['icon_pos'] : "";
				(isset($args['pos'])) ? $icon_pos = 'icon_'.$args['pos'] : "";
			}
		}
		
		if(isset($args['id'])) {
			$post_type = get_post_type($args['id']);
			
			if($post_type == "attachment") {
				$link = wp_get_attachment_url($args['id']);
			
			} else {
				$link = urldecode(get_permalink($args['id']));
			}
			
			if(isset($args['text'])) {
				$return = '<a href="'.$link.'" '.$target.' class="'.$class.' '.$icon_pos.'" style="'.$icon.'">'.$args['text'].'</a>';
				
			} else {
				$return = $link;
			}
			
		} else {
			$link = str_replace("http://", "", $args['link']);
			$link = str_replace("https://", "", $link);
			$link = str_replace(",", "", $link);
			$link = str_replace(";", "", $link);
			
			//return $link;
			
			if(checkURLSyntax($link) != false) {
				$pattern = '#(^|[^\"=]{1})([^\s<>]+)([\s\n<>]|$)#sm';
				
				if (trim($text) == "") {
					$final_link = preg_replace($pattern, '<a href="http://\\1\\2\\3" '.$target.' class="'.$class.' '.$icon_pos.'" style="'.$icon.'">\\1\\2\\3</a>', $link);
				
				} else {
					$final_link = preg_replace($pattern, '<a href="http://\\1\\2\\3" '.$target.' class="'.$class.' '.$icon_pos.'" style="'.$icon.'">'.$text.'</a>', $link);
				}
				
				$final_link = str_replace("http:// ", "http://", $final_link);
				
				$return = $final_link;
			}
		}
		
		return $return;
	}
}

?>