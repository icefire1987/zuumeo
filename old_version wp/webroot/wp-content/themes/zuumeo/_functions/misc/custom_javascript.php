<?php

function enqueue_scripts() {
//	wp_register_script( 'mousemove', get_bloginfo('template_directory') . '/_javascript/mousemove.js' );
	//wp_deregister_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

?>