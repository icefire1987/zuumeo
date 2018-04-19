<?php

function getMetaDescription($args) {
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	$meta_content = get_post_meta($page_id, getIndividoleOption("praefix_seo").'_0_meta_description', true);
	
	if($meta_content != "") {
		$return = $meta_content;
	
	} else {
		$return = getOptionWord('meta_standard_description');
	}
	
	return $return;
}

?>