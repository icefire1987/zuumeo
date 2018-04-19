<?php

function getNextPost($args) {
	global $page_id;
	
	(isset($args['post_type'])) 	? $post_type = $args['post_type'] 	: $post_type = 'page';
	(isset($args['direction'])) 	? $direction = $args['direction'] 	: $direction = 'next';
	(isset($args['orderby'])) 		? $orderby = $args['orderby'] 		: $orderby = 'menu_order';
	(isset($args['order'])) 		? $order = $args['order'] 			: $order = 'ASC';
	
	
	
	$posts = get_posts(array(
		'post_type'		=> $post_type,
		'post_status'	=> 'publish',
		'numberposts'	=> 99999999,
		'orderby'		=> $orderby,
		'order'			=> $order,
	));
	
	//debug($posts);
	
	$pages = get_page_hierarchy($posts);
	$pages = array_keys($pages);
	
	$current = array_search($page_id, $pages);
	
	
	if($current == 0) {
		$prevID = $pages[sizeof($pages)-1];
	
	} else {
		$prevID = $pages[$current-1];
	}
	
	if($current == sizeof($pages)-1) {
		$nextID = $pages[0];
	
	} else {
		$nextID = $pages[$current+1];
	}
	
	if($direction == 'next') {
		$return = $nextID;
		
	} else {
		$return = $prevID;
	}
	
	//debug($pages);
	
	return $return;
}

?>