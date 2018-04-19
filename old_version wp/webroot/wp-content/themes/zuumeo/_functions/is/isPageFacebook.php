<?php

function isPageFacebook() {
	global $page_id;
	
	$template_name = get_post_meta($page_id, '_wp_page_template', true);
	
	if($template_name == 'template-Facebook.php') {
		return true;
	}
}