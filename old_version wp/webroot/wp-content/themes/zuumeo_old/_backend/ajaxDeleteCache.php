<?php

if(isset($_POST['delete_cache'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	if(is_user_logged_in()) {
		$post_id 		= $_POST['id'];
		
		include_once(get_stylesheet_directory()."/includes.php");
		//include_once(get_stylesheet_directory()."/_backend/getCacheFilepathByID.php");
		
		//$file = getCacheFilepathByID($post_id);
		
		$file = getCacheDir().'/'.$post_id.'.html';
		
		if(file_exists($file)) {
			unlink($file);
		}
		
		$file_mobile = getCacheDir("mobile").'/'.$post_id.'.html';
		
		if(file_exists($file_mobile)) {
			unlink($file_mobile);
		}
		
		echo $post_id.'|||'.$file;
	}
}

?>