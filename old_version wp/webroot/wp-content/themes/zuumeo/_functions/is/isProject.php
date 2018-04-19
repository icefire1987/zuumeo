<?php

function isProject() {
	global $page_id;
	
	if(get_post_type($page_id) == 'projects') {
		return true;
	
	} else {
		return false;
	}
}

?>