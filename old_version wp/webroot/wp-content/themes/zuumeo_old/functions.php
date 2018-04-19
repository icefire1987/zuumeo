<?php

include_once(get_stylesheet_directory().'/includes.php');


add_filter('acf/options_page/settings', 'my_acf_options_page_settings');

function my_acf_options_page_settings( $settings ) {
	global $configs_acf_options;
	
	if (isset($configs_acf_options) && is_admin()) {
		$settings['title'] = 'Grundinhalte';
		$settings['pages'] = array();
	
		foreach($configs_acf_options AS $configs_acf_key => $configs_acf_value) {
			$settings['pages'][] = $configs_acf_value;
		}
	}
	
	return $settings;
}


include_once('_acf/individole-configs-cpt.php');
include_once('_acf/individole-configs.php');
include_once('_acf/individole-configs-modules.php'); 



add_action('acf/register_fields', 'my_register_fields');

function my_register_fields() {
	include_once('_acf/individole-repeaters.php');
	include_once('_acf/individole-flexible-fields.php');
	include_once('_acf/individole-options-standards.php');
}





//!START a session
function my_start_session() {
	@session_cache_limiter('private, must-revalidate'); //private_no_expire
	@session_cache_expire(0);
	@session_start();
}

function my_init_session() {
	if (!session_id()) {
		my_start_session();
	}
}
add_action('init', 'my_init_session', 1);




function my_formatTinyMCE($init) {
	global $configs_tinymce;
		
	//print_r($configs_tinymce);
		
	$init['theme'] 							= @$configs_tinymce['theme'];
    $init['skin'] 							= @$configs_tinymce['skin'];
    $init['language'] 						= @$configs_tinymce['language'];
    $init['theme_advanced_styles'] 			= @$configs_tinymce['styles'];
    $init['theme_advanced_blockformats'] 	= @$configs_tinymce['blockformats'];
    $init['plugins'] 						= @$configs_tinymce['plugins'];
    $init['theme_advanced_buttons1'] 		= @$configs_tinymce['theme_advanced_buttons1'];
    $init['theme_advanced_buttons2'] 		= @$configs_tinymce['theme_advanced_buttons2'];
    $init['theme_advanced_buttons3'] 		= @$configs_tinymce['theme_advanced_buttons3'];
    $init['theme_advanced_buttons4'] 		= @$configs_tinymce['theme_advanced_buttons4'];
    $init['content_css'] 					= @$configs_tinymce['content_css'];
		
	return $init;
}
add_filter('tiny_mce_before_init', 'my_formatTinyMCE' );


add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars ) {
	global $configs_tinymce;
	
	$toolbars['Full'] = array();
	$toolbars['Full'][1] = apply_filters('mce_buttons', explode(",", $configs_tinymce['theme_advanced_buttons1']));
	$toolbars['Full'][2] = apply_filters('mce_buttons_2', explode(",", $configs_tinymce['theme_advanced_buttons2']));
	$toolbars['Full'][3] = apply_filters('mce_buttons_3', explode(",", $configs_tinymce['theme_advanced_buttons3']));
	$toolbars['Full'][4] = apply_filters('mce_buttons_4', explode(",", $configs_tinymce['theme_advanced_buttons4']));
 
	// remove the 'Basic' toolbar completely
	unset( $toolbars['Basic' ] );
 
 
	// return $toolbars - IMPORTANT!
	return $toolbars;
}


remove_filter('template_redirect', 'redirect_canonical');
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'my_formatter', 99);

$current_date = date("Y-m-d");




function mytheme_addmenus() {
	register_nav_menus(
		array(
			'main_nav' => 'The Main Menu',
		)
	);
}
add_action( 'init', 'mytheme_addmenus' );


if(isSuperAdmin()) {
	//update_option("rewrite_rules", "");
}

//add_action( 'all', create_function( '', 'print_r( current_filter() );' ));



function mediathek_col($columns) {
    $columns['alt_title'] = __('Alt. Title');
    return $columns;
}
add_filter( 'manage_media_columns', 'mediathek_col' );

function column_id_row($columnName, $columnID){
    if($columnName == 'alt_title'){
       echo get_post_meta($columnID, 'attachment_extra_content_0_attachment_title', true);
    }
}
add_filter( 'manage_media_custom_column', 'column_id_row', 10, 2 );


//
//add_filter('manage_edit-attachment_columns', 'my_columns');
//function my_columns($columns) {
//    $columns['alt_title'] = 'Alt-Title';
//    return $columns;
//}
//
//add_action('manage_posts_custom_column',  'my_show_columns');
//function my_show_columns($name) {
//    global $post;
//    switch ($name) {
//        case 'alt_title':
//            $views = get_post_meta($post->ID, 'views', true);
//            echo $views;
//    }
//}


?>