<?php

function isPageKunde() {
	global $page_id;
	
	$post_type = get_post_type( $page_id );
	
	if($post_type == 'kunde') {
		return true;
	}
}