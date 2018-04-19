<?php

function addAdminScripts() {
	wp_enqueue_script(array('jquery', 'editor', 'thickbox', 'media-upload'));
	wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/_javascript/ui/minified/jquery-ui.min.js' );
	wp_enqueue_style('jquery-ui-css', get_template_directory_uri() . '/_javascript/themes/base/minified/jquery-ui.min.css' );
	
	wp_enqueue_script('jquery-ui-timepicker', get_template_directory_uri() . '/_javascript/ui/jquery-ui-timepicker-addon.js' );
	wp_enqueue_style('jquery-ui-css', get_template_directory_uri() . '/_javascript/themes/base/jquery.ui.datetimepicker.css' );
	
	wp_enqueue_script('sneek-admin-scripts', get_template_directory_uri() . '/_javascript_admin/sneek-admin-scripts.js' );
	wp_enqueue_script( 'my_custom_script', get_stylesheet_directory_uri().'/_backend/javascript.js' );
	wp_enqueue_media();
}
add_action( 'wp_enqueue_scripts', 'addAdminScripts' );


function addWPScripts() {
	wp_enqueue_media();
}

if(isAdmin()) {
	add_action( 'wp_enqueue_scripts', 'addWPScripts' );
}

?>