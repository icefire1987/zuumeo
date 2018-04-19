<?php

function getMetaKeywords($args) {
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	$meta_content = get_post_meta($page_id, getIndividoleOption("praefix_seo").'_0_meta_keywords', true);
	
	$temp_keywords = array();
	if($meta_content != "") {
		$keywords = explode(",", $meta_content);
		
		foreach($keywords AS $keyword) {
			$temp_keywords[] = trim($keyword);
		}
	}
	
	
	$keywords = explode(",", getOptionWord('meta_standard_keywords'));
	foreach($keywords AS $keyword) {
		$temp_keywords[] = trim($keyword);
	}
	
	
	$return = implode(", ", $temp_keywords);
	
	return $return;
}

?>