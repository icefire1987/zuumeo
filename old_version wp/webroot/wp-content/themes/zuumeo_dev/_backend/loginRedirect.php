<?php

function jsp_loginredirect($link) {
	// Add redirect_to argument
	$from = $_SERVER['REQUEST_URI'];
	if (substr_count($link,'?') > 0) {
		$link = str_replace('">','&redirect_to='.$from.'">',$link);
	} else {
		$link = str_replace('">','?redirect_to='.$from.'">',$link);
    }
	return $link;
}

add_filter('loginout','jsp_loginredirect');

?>