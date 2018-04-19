<?php

if(isset($_POST['create_cache'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	if(is_user_logged_in()) {
		$post_type 		= $_POST['post_type'];
		
		include_once(get_stylesheet_directory()."/includes.php");
		include_once(get_stylesheet_directory()."/_acf/individole-configs-cpt.php");
		include_once(get_stylesheet_directory()."/_backend/getBrowser.php");
		include_once(get_stylesheet_directory()."/_backend/createCache.php");
		
		$post_ids = explode(",", $_POST['ids']);
		
		$create_cache = createCache(array(
		  'post_ids'	=> $post_ids,
		  'user'		=> 'ajax',
		));
		
		echo $create_cache['count'].'|||'.implode("###", $create_cache['urls']).'|||'.implode(",", $post_ids).'|||';
	}
}

?>