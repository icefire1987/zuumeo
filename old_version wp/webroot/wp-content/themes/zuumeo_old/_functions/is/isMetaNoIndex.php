<?php

function isMetaNoIndex() {
	global $page_id;
	
	
	$noindex = get_post_meta($page_id, 'robots_0_noindex', true);
	
	if($noindex == 1) {
		return true;
	
	} else {
		return false;
	}
}

?>