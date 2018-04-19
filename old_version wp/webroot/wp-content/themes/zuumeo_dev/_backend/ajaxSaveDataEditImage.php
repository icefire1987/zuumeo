<?php

if(isset($_POST['data_edit_save_image'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	global $config_modules;
	//include("ajax-include.php");
	
	
	//!GET post-vars
	$post_id 		= $_POST['post_id'];
	$new_image_id 	= $_POST['new_image_id'];
	$field 			= $_POST['field'];
	
	$final_field = $field;
	if(isset($config_modules['image'])) {
		$final_field = $field.'_'.$config_modules['image'];
	}
	
	$update = update_post_meta($post_id, $final_field, $new_image_id);
	
	echo $update.'|||'.$final_field;
}

?>