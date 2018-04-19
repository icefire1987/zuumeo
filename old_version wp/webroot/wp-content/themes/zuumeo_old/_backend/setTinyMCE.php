<?php

function setTinyMCE($init) {
	global $configs_tinymce;
		
	//print_r($configs_tinymce);
		
	$init['theme'] 							= @$configs_tinymce['theme'];
    $init['skin'] 							= @$configs_tinymce['skin'];
    $init['language'] 						= @$configs_tinymce['language'];
    $init['theme_advanced_styles'] 			= @$configs_tinymce['styles'];
    $init['theme_advanced_blockformats'] 	= @$configs_tinymce['blockformats'];
    $init['invalid_elements'] 				= @$configs_tinymce['invalid_elements'];
    $init['plugins'] 						= @$configs_tinymce['plugins'];
    $init['theme_advanced_buttons1'] 		= @$configs_tinymce['theme_advanced_buttons1'];
    $init['theme_advanced_buttons2'] 		= @$configs_tinymce['theme_advanced_buttons2'];
    $init['theme_advanced_buttons3'] 		= @$configs_tinymce['theme_advanced_buttons3'];
    $init['theme_advanced_buttons4'] 		= @$configs_tinymce['theme_advanced_buttons4'];
    $init['content_css'] 					= @$configs_tinymce['content_css'];
    $init['force_p_newlines'] 				= true;
		
	return $init;
}
add_filter('tiny_mce_before_init', 'setTinyMCE' );


add_filter( 'acf/fields/wysiwyg/toolbars' , 'setTinyMCEACF'  );
function setTinyMCEACF( $toolbars ) {
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




?>