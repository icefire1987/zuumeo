<?php

//!START session
//(!session_id()) ? session_start() : "";


$options 				= getOptions();
$options_admin	 		= $options['admin'];
$options_numbers 		= $options['numbers'];
$options_words 			= $options['words'];
$options_clauses 		= $options['clauses'];
$options_texts 			= $options['texts'];
$options_files 			= $options['files'];
$options_colors 		= $options['colors'];
$options_galleries 		= $options['galleries'];
$options_status 		= $options['status'];
$options_pages 			= $options['pages'];


//!GET page_id

if(!isset($page_id) || $page_id == 0) {
	$redirect = get_permalink(getOptionPage('home'));
	
	//header('refresh:0;url='.'http://'.$_SERVER['HTTP_HOST']);

} else {
	
	if(isset($get_parent_page_id)) {
		$parent_page_id 	= getOptionNumber($get_parent_page_id);
	}
	
	
	//!GET page data
	$page_data 		= get_page($page_id); 
	$page_title 	= $page_data->post_title;
	$page_parent 	= $page_data->post_parent;
	
	
	//!GET header
	ob_start();
	get_header();
	$header = ob_get_contents();
	ob_end_clean(); 
	
	
	
	//!GET footer
	ob_start();
	get_footer();
	$footer = ob_get_contents();
	ob_end_clean();
}





?>