<?php

$config_modules = array(
	'title'			=> 'Video bearbeiten',
	'source'		=> array(
	    'label'			=> 'Video-Typ',
	    'field'			=> 'm_video_0_source',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_video_source'],
	    'reload'		=> 1,
	),
	'embed'			=> array(
	    'label'			=> 'URL oder<br>Embed-Code',
	    'field'			=> 'm_video_0_embed',
	    'type'			=> 'textarea',
	    'reload'		=> 1,
	),
	'image'			=> array(
	    'label'			=> 'Vorschaubild',
	    'field'			=> 'm_video_configs_0_image',
	    'type'			=> 'image',
	    'reload'		=> 1,
	),
	'mp4'			=> array(
	    'label'			=> 'Upload / MP4',
	    'field'			=> 'm_video_0_upload_0_mp4',
	    'type'			=> 'file',
	    'reload'		=> 1,
	),
	'ogg'			=> array(
	    'label'			=> 'Upload / OGG',
	    'field'			=> 'm_video_0_upload_0_ogg',
	    'type'			=> 'file',
	    'reload'		=> 1,
	),
	'width'			=> array(
	    'label'			=> 'Original Breite',
	    'field'			=> 'm_video_configs_0_w',
	    'type'			=> 'input',
	    'reload'		=> 1,
	),
	'height'		=> array(
	    'label'			=> 'Original Höhe',
	    'field'			=> 'm_video_configs_0_h',
	    'type'			=> 'input',
	    'reload'		=> 1,
	),
	'autostart'		=> array(
	    'label'			=> 'Autostart',
	    'field'			=> 'm_video_configs_0_autostart',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'controls'		=> array(
	    'label'			=> 'Steuerlemente',
	    'field'			=> 'm_video_configs_0_controls',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'icons'		=> array(
	    'label'			=> 'Play-Button in der Mitte',
	    'field'			=> 'm_video_configs_0_icons',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'text'			=> array(
	    'label'			=> 'Beschriftung',
	    'field'			=> 'm_video_configs_0_text',
	    'type'			=> 'input',
	    'reload'		=> 1,
	),
);