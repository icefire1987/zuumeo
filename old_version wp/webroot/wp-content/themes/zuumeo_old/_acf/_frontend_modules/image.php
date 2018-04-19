<?php

$choices_pages = getAdminPosts("page");
$choices_kunde = getAdminPosts("kunde");

$choices_all_posts = $choices_pages + $choices_kunde;

$config_modules = array(
	'title'			=> 'Bild bearbeiten',
	'image'			=> array(
	    'label'			=> 'Bild',
	    'field'			=> 'm_image_content_0_image',
	    'type'			=> 'image', 
	),
	'interner_link'	=> array(
	    'label'			=> '1a) Interner Link',
	    'field'			=> 'm_image_content_0_misc_0_page',
	    'type'			=> 'select',
	    'choices'		=> $choices_all_posts,
	    'reload'		=> 1,
	),
	'externer_link'	=> array(
	    'label'			=> '1b) oder externer Link',
	    'field'			=> 'm_image_content_0_misc_0_link',
	),
	'zoom'			=> array(
	    'label'			=> '1c) oder Zoom',
	    'field'			=> 'm_image_content_0_misc_0_zoom',
	    'type'			=> 'true_false', 
	    'reload'		=> 1,
	),
	'shadow'		=> array(
	    'label'			=> '2) Schatten',
	    'field'			=> 'm_image_content_0_misc_0_shadow',
	    'type'			=> 'true_false', 
	    'reload'		=> 1,
	),
	'scale'			=> array(
	    'label'			=> '3) Skalierung in %<br>0 f&uuml;r original Dateigr&ouml;&szlig;e',
	    'field'			=> 'm_image_content_0_misc_0_scale',
	    'type'			=> 'number', 
	),
	'alignment'		=> array(
	    'label'			=> '4) Ausrichtung',
	    'field'			=> 'm_image_content_0_misc_0_alignment',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_alignment'],
	    'reload'		=> 1,
	),
	'text'			=> array(
	    'label'			=> '5) Beschriftung',
	    'field'			=> 'm_image_content_0_misc_0_title',
	),
);