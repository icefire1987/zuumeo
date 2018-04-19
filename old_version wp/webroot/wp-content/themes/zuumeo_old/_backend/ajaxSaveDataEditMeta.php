<?php

if(isset($_POST['data_edit_save_meta'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	//include("ajax-include.php");
	
	if(is_user_logged_in()) {
		//!GET post-vars
		$post_id 			= $_POST['post_id'];
		$meta_title 		= $_POST['meta_title'];
		$meta_description 	= $_POST['meta_description'];
		$meta_keywords 		= $_POST['meta_keywords'];
		$sitemap 			= $_POST['sitemap'];
		$changefreq 		= $_POST['changefreq'];
		$noindex			= $_POST['noindex'];
		
		update_post_meta($post_id, getIndividoleOption("praefix_seo").'_0_meta_title', $meta_title);
		update_post_meta($post_id, getIndividoleOption("praefix_seo").'_0_meta_description', $meta_description);
		update_post_meta($post_id, getIndividoleOption("praefix_seo").'_0_meta_keywords', $meta_keywords);
		update_post_meta($post_id, getIndividoleOption("praefix_seo").'_0_sitemap', $sitemap);
		update_post_meta($post_id, getIndividoleOption("praefix_seo").'_0_noindex', $noindex);
					
		echo '1|||';
	}
}

?>