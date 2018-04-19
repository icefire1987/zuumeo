<?php

function createImageText($args) {
	(isset($args['title']) && $args['title'] != "") ? $title = $args['title'] : $title = '';
	(isset($args['subtitle']) && $args['subtitle'] != "") ? $subtitle = $args['subtitle'] : $subtitle = '';
	(isset($args['text']) && $args['text'] != "") ? $text = $args['text'] : $text = '';
	
	if(isset($args['mediathek']) && isset($args['id'])) {
		$id = $args['id'];
		
		$title 		= get_post_meta($id, 'attachment_extra_content_0_attachment_title', true);
		$subtitle 	= get_post_meta($id, 'attachment_extra_content_0_attachment_subtitle', true);
		$text 		= get_post_meta($id, 'attachment_extra_content_0_attachment_text', true);
	}
	
	$return = '';
	
	if($title != "") {
		$title = nl2br($title);
		
		$return .= '<div class="image_text_title">'.$title.'</div>';
		
		if($text != "" && $subtitle == "") {
			$return .= clearer(7);
		}
	}
	
	if($subtitle != "") {
		$subtitle = nl2br($subtitle);
		
		$return .= '<div class="image_text_subtitle">'.$subtitle.'</div>';
		
		if($text != "") {
			$return .= clearer(7);
		}	
	}
	
	if($text != "") {
		$text = nl2br($text);
		
		$return .= '<div class="image_text_text">'.$text.'</div>';
	}
	
	return $return;
}

?>