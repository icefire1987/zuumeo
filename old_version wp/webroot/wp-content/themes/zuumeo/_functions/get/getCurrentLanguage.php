<?php

function getCurrentLanguage($args) {
	if(isPolylang()) {
		global $polylang;
		
		(isset($args['type'])) ? $type = $args['type'] : $type = "slug";
		
		$post_language = $polylang->model->get_post_language(getPageID());
		
		if(property_exists($post_language, "slug") && $type == 'slug') {
			return $post_language->slug;
		
		} else if(property_exists($post_language, "term_id") && $type == 'term_id') {
			return $post_language->term_id;
		
		} else if(property_exists($polylang, "curlang")) {
			
			
			if($type == 'term_id') {
				return $polylang->curlang->term_id;
			
			} else {
				return $polylang->curlang->slug;
			}
		
		} else {
			return 'de';
		}
		
	} else {
		return 'de';
	}
}

?>