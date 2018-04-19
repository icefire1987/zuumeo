<?php

function formatDomain($url) {
	$blog_url = get_bloginfo('wpurl');
	
	$current_url = "http://".$_SERVER['HTTP_HOST'];
	
	$return = str_replace($blog_url, $current_url, $url);
	
	return $return;
}