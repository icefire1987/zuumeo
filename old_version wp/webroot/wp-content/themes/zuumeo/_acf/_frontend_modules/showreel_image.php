<?php

$choices_pages = getAdminPosts("page");
$choices_kunde = getAdminPosts("kunde");

$choices_all_posts = $choices_pages + $choices_kunde;

$config_modules = array(
	'title'			=> 'Showreelbild bearbeiten',
	'logo'			=> array(
	    'label'			=> 'Bild/Logo',
	    'field'			=> 'm_showreel_content_#_logo',
	    'type'			=> 'image', 
	),
	'scale'			=> array(
	    'label'			=> 'Bild/Logo Scale in %<br>(0=auto)',
	    'field'			=> 'm_showreel_content_#_scale',
	    'type'			=> 'number', 
	),
	//'text'			=> array(
	//	'label'			=> 'Beschriftung',
	//	'field'			=> 'm_image_list_images_#_text',
	//	'type'			=> 'input', 
	//),
	'page'			=> array(
	    'label'			=> 'Link',
	    'field'			=> 'm_showreel_content_#_page',
	    'type'			=> 'select',
	    'choices'		=> $choices_all_posts,
	    'reload'		=> 1,
	),
	'title2'		=> array(
	    'label'			=> 'label',
	    'field'			=> 'm_showreel_content_#_title',
	    'type'			=> 'text', 
	),
	'subtitle'		=> array(
	    'label'			=> 'Subtitle',
	    'field'			=> 'm_showreel_content_#_subtitle',
	    'type'			=> 'text', 
	),
	'text'			=> array(
	    'label'			=> 'Text',
	    'field'			=> 'm_showreel_content_#_text',
	    'type'			=> 'textarea', 
	),
);