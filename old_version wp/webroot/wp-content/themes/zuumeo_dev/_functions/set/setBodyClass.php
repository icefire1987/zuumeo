<?php

function setBodyClass() {
	global $page_id;
	
	$template_name = get_post_meta($page_id, '_wp_page_template', true);
	
	$return = 'body_default';
	
	if($template_name == 'template-Hoher-Header.php') {
		$return = 'body_long';
	}
	
	
	$current_post = get_post_ancestors($page_id);
	
	if(!empty($current_post)) {
		$final_page_id = $current_post[0];
	
	} else {
		$final_page_id = $page_id;
	}
	
	$children = get_children(array(
	    'post_type' 		=> 'page',
	    'posts_per_page' 	=> 99999999,
	 	'post_parent' 		=> $final_page_id,
	 	'orderby'			=> 'menu_order',
	 	'order'				=> 'ASC',
	 	'post_status'		=> array('publish'),
	));
	
	if(!empty($children)) {
		$return = 'body_default_subnavi';
	}
	
	return $return;
}

?>