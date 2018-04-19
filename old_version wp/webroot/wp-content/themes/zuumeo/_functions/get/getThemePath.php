<?php

function getThemePath() {
	global $wpdb;
	
	$theme = wp_get_theme();
	$theme = $theme->Template;
	
	$return = getSiteURL().'/wp-content/themes/'.$theme;
	
	return $return;
}

?>