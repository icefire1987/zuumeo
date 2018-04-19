<?php

if(isset($_POST['data_edit_post_status'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	if(is_user_logged_in()) {
		$post_id 		= $_POST['post_id'];
		
		$current_value 	= get_post_status($post_id);
		
		if($current_value != "publish") {
			$new_post_status = 'publish';
			
		} else {
			$new_post_status = 'draft';
		}
		
		$success = wp_update_post(array(
		    'ID' 				=> $post_id,
		    'post_modified' 	=> date("Y-m-d H:i:s"),
		    'post_modified_gmt' => date("Y-m-d H:i:s"),
		    'post_status'		=> $new_post_status,
		));
		
		
		//!return to javascript
		echo $new_post_status.'|||';
	}
}

?>