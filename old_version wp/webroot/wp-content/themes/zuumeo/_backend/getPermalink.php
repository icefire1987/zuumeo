<?php

function getPermalink($args) {
	$permalink 	= get_permalink($args['post_id']);
	
	if(startsWith($permalink, getRealSiteURL())) {
		
	} else {
		$permalink 	= str_replace('http:/', getRealSiteURL().'/', $permalink);
	}
	
	$permalink = ltrim($permalink, "/");
	
	return $permalink;
}

?>