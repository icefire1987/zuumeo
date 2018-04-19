<?php

function getPageData($args){
	$page_data = get_page($args['page_id']); // You must pass in a variable to the get_page function. If you pass in a value (e.g. get_page ( 123 ); ), WordPress will generate an error. 

	//$content = apply_filters('the_content', $page_data->post_content); // Get Content and retain Wordpress filters such as paragraph tags. Origin from: http://wordpress.org/support/topic/get_pagepost-and-no-paragraphs-problem
	//$title = $page_data->post_title; // Get title

	//$sl = get_post_meta($page_id, 'slideshow_text_left_1', true);
	
	//print_r($page_data);
	
	return $page_data;
}

?>