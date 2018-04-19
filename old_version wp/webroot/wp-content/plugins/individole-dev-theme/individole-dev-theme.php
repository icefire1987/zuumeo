<?php
/*
Plugin Name: Individol&eacute; Dev Theme
Description: Shows a theme called "[themename]_dev", ONLY if is_user_logged_in() AND if is administrator --- add capability "individole_show_dev_version" manually and set to 1 to add this function to other usergroups
Version: 1.0
Author: Dennis Kather
Author URI: http://www.individole.de
*/
 
 
add_filter('template', 'showDevTheme');
add_filter('stylesheet', 'showDevTheme');

function showDevTheme($theme) {
	$theme = get_option("template");
	
	if(is_user_logged_in()) {
		global $current_user;
		
		if(
				(
				isset($current_user->caps['administrator']) 
				&& $current_user->caps['administrator'] == 1
				) 
				|| 
				(
				get_option("individole_show_dev_version") 
				&& isset($current_user->allcaps['individole_show_dev_version']) 
				&& $current_user->allcaps['individole_show_dev_version'] == 1
				)
			) 
			{
			
			$dir = WP_CONTENT_DIR.'/themes/'.$theme.'_dev';
			
			if(file_exists($dir) && is_dir($dir)) {				
				return $theme.'_dev';
			
			} else {
				return $theme;
			}
			
		} else {
			return $theme;
		}
		
	} else {
		return $theme;
	}
}

?>