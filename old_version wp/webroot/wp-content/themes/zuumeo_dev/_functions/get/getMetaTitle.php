<?php

function getMetaTitle($args) {
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	$meta_content = get_post_meta($page_id, getIndividoleOption("praefix_seo").'_0_meta_title', true);
	
	$return = array();
	if($meta_content != "") {
		$return[] = $meta_content.' - ';
	
	} else {
		if($page_id != getOptionPage("home")) {
			$return[] = get_the_title($page_id).' - ';
		}
	}
	
	$return[] = getOptionWord('meta_standard_title');
	
	return implode("", $return);
}

?>