<?php

if(isset($_POST['data_edit_post_modified'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	if(is_user_logged_in()) {
		$post_id 		= $_POST['post_id'];
		
		$success = wp_update_post(array(
		    'ID' 				=> $post_id,
		    'post_modified' 	=> date("Y-m-d H:i:s"),
		    'post_modified_gmt' => date("Y-m-d H:i:s"),
		));
		
		
		$cache_dir = dirname(ABSPATH).'/cache';
		$file = $cache_dir.'/'.$_POST['cache'];
		
		if(file_exists($file)) {
			unlink($file);
		}
		
		//!return to javascript
		echo $success.'|||'.$file;
	}
}

?>