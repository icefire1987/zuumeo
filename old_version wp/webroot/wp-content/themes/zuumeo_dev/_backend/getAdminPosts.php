<?php

function getAdminPosts($post_type="page", $args=array()) {
	global $config_cpt;
	
	if(isset($args['city'])) {
		$post_id = 0;
		if(isset($_POST['post_id'])) {
			$post_id = $_POST['post_id'];
		
		} else if(isset($_POST['post_ID'])) {
			$post_id = $_POST['post_ID'];
		}
		
		$post_type = getCityCodeByID($post_id).'_'.$post_type;
	}
	
	$c = $config_cpt[$post_type];
	//debug($config_cpt);
	
	if(isset($args['allow_null']) && $args['allow_null'] === 0) {
		$return = array();
		
	} else {
		$return = array(0 => "");
	}
	
	$posts_args = array( 
	    'post_type' 		=> $post_type, 
	    'posts_per_page' 	=> 999999,
	    'orderby'			=> $c['orderby'],
	    'order'				=> $c['direction'],
	    'post_status'		=> array('publish'),
	);
	
	if(isAdmin()) {
		$posts_args['post_status'] = array('publish', 'draft');
	}
	
	if(isset($_GET['new_lang'])) {
		$posts_args['lang'] = $_GET['new_lang'];
	
	} else if(isset($args['lang'])) {
		$posts_args['lang'] = $args['lang'];
	
	} else if(isPosttypePolylang($post_type) && isset($_GET['post'])) {
		global $polylang;
		
		$posts_args['lang'] = $polylang->model->get_post_language($_GET['post'])->slug;
	
	} else if(isPosttypePolylang($post_type) && isset($_POST['post'])) {
		global $polylang;
		
		$posts_args['lang'] = $polylang->model->get_post_language($_POST['post'])->slug;
	}
			
	$posts 				= get_posts( $posts_args );
	$posts_hierarchy 	= get_page_hierarchy($posts);
	$count_posts 		= sizeof($posts);
		
	$temp_posts = array();
	foreach($posts AS $p) {
	    $temp_posts[$p->ID] = array(
	    	'status'		=> $p->post_status,
	    	'date'			=> $p->post_date,
	    	'title'			=> $p->post_title,
	    	'parent'		=> $p->post_parent,
	    );
	}
	
	foreach($posts_hierarchy AS $post_id => $post_name) {
	   $p = $temp_posts[$post_id];
	   $post_title = $p['title'];
	   if($p['parent'] > 0) {
		   $post_title = '- '.$post_title;
	   }
	   
	   
	   $post_status = '';
	   if($p['status'] != 'publish') {
		   $post_status = ' (DRAFT)';
	   }
	   
	   $return[$post_id] = $c['singular_name'].': '.$post_title.$post_status;
	}
	
	//debug($posts_args);
	//debug($posts);
	//debug($return);
	
	return $return;	
}