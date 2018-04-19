<?php

function isCache() {
	if(
		!is_user_logged_in() 
		&& !isset($_GET['ajax_cache'])
		&& getCacheStatus()
		&& ((!isPhone() && getCacheTime() > 0) || (isPhone() && getCacheTime("mobile") > 0)) 
		&& !is_feed() 
		&& !is_search() 
		&& (!isset($_POST) || (isset($_POST) && empty($_POST)))
		) {
		
		$cache = get_field(getIndividoleOption("praefix_seo"), getPageID());
		if(isset($cache[0]['cache']) && $cache[0]['cache'] == 1) {
			return false;
		
		} else {
			return true;
		}
		
	} else {
		return false;
	}
}

?>