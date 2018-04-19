<?php

$choices_pages = getAdminPosts("page");
$choices_kunde = getAdminPosts("kunde");

$choices_all_posts = $choices_pages + $choices_kunde;

$config_modules = array(
	'title'			=> 'Bildlistenbild bearbeiten',
	'image'			=> array(
	    'label'			=> 'Bild',
	    'field'			=> 'm_image_list_images_#_image',
	    'type'			=> 'image', 
	),
	//'text'			=> array(
	//	'label'			=> 'Beschriftung',
	//	'field'			=> 'm_image_list_images_#_text',
	//	'type'			=> 'input', 
	//),
	'link_intern'	=> array(
	    'label'			=> 'Interner Link',
	    'field'			=> 'm_image_list_images_#_options_0_link_intern',
	    'type'			=> 'select',
	    'choices'		=> $choices_all_posts,
	    'reload'		=> 1,
	),
	'link_extern'	=> array(
	    'label'			=> 'oder externer Link',
	    'field'			=> 'm_image_list_images_#_options_0_link_extern',
	),
	'zoom'			=> array(
	  'label'			=> 'oder Zoom',
	  'field'			=> 'm_image_list_images_#_options_0_zoom',
	  'type'			=> 'true_false', 
	),
	'title2'		=> array(
	    'label'			=> 'label',
	    'field'			=> 'm_image_list_images_#_options_0_title',
	),
	'subtitle'		=> array(
	    'label'			=> 'Subtitle',
	    'field'			=> 'm_image_list_images_#_options_0_subtitle',
	),
	'text'			=> array(
	    'label'			=> 'Text',
	    'field'			=> 'm_image_list_images_#_options_0_text',
	    'type'			=> 'textarea',
	),
);