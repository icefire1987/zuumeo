<?php

add_shortcode('url', 'getCurrentURL');

function getCurrentURL() {
	$return = getHTTP().$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
	
	return $return;
}

?>