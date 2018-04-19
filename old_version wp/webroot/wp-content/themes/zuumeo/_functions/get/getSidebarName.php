<?php

function getSidebarName() {
	global $page_id;
	
	$final_page_id = $page_id;
	if(isset($GLOBALS['parent_page_id'])) {
		$final_page_id = $GLOBALS['parent_page_id'];
	}
	
	if(isPageStoLocation()) {
		$sidebar_id = getOptionNumber('sidebar_id_sto_locations');
	
	} else {
		$sidebar_id = get_post_meta($final_page_id, 'sidebar', true);
	}
	
	$sidebar_name = get_post_meta($sidebar_id, 'configuration_0_sidebar_id', true);
	
	//echo '<p>parent_page_id: '.$GLOBALS['parent_page_id'].'<br>SIDEBAR: '.$sidebar_id.'_'.$sidebar_name;
	
	if($sidebar_name != "") {
		$return = $sidebar_name;
	
	} else {
		$return = 'standard_'.getCurrentLanguage(array());
	}
	
	return $return;
}


?>