<?php

$polylang_posttypes = get_option('polylang');

function isPosttypePolylang($post_type) {
	global $polylang_posttypes;
	
	if(isPolylang() && in_array($post_type, $polylang_posttypes['post_types'])) {
		return true;
		
	} else {
		return false;
	}
}

?>