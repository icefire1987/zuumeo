<?php

function isPageProjekte() {
	global $page_id;
	
	$post_type = get_post_type( $page_id );
	
	if($post_type == 'projekte') {
		return true;
	}
}