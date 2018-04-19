<?php

if(isset($_POST['get_posts'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	if(is_user_logged_in()) {
		$post_type 		= $_POST['post_type'];
		
		include_once(get_stylesheet_directory()."/includes.php");
		
		$loop_args = array( 
		    'post_type' 		=> $post_type, 
		    'posts_per_page' 	=> $_POST['posts_per_page'],
		    'orderby'			=> 'post_date',
		    'order'				=> 'DESC',
		    'post_status'		=> array('publish'),
		);
			
		if(isPolylang()) {
			$languages = array();
			foreach ($polylang->model->get_languages_list() as $language) {
				$languages[] = $language->slug;
			}
			$loop_args['lang'] = $languages;
		}
			
		$loop = new WP_Query( $loop_args );
		$count_posts = sizeof($loop->posts);
			
		foreach($loop->posts AS $post) {
			$do = 1;
			
			if(isset($_POST['cache_only'])) {
				$nocache 	= get_post_meta($post->ID, get_option("individole_praefix_seo").'_0_cache', true);
		    	if($nocache == 1) {
		    		$do = 0;
		    	}
		    }
			
			if($do == 1) {
				$post_ids[] = $post->ID;
			}
		}
		
		echo '|||'.implode(",", $post_ids).'|||';
	}
}

?>