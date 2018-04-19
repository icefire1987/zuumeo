<?php

$config_modules = array(
	'title'			=> 'Showreel bearbeiten',
	'columns'		=> array(
	    'label'			=> '# Spalten',
	    'field'			=> 'm_showreel_options_0_columns',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_showreel_columns'],
	    'reload'		=> 1,
	),
	'texttype'		=> array(
	    'label'			=> 'Textanzeige',
	    'field'			=> 'm_showreel_options_0_text',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_imagelist_text'],
	    'reload'		=> 1,
	),
	'text_title'	=> array(
	    'label'			=> 'Textanzeige / Title',
	    'field'			=> 'm_showreel_options_0_text_title',
	    'type'			=> 'true_false',
	),
	'text_subtitle'	=> array(
	    'label'			=> 'Textanzeige / Subtitle',
	    'field'			=> 'm_showreel_options_0_text_subtitle',
	    'type'			=> 'true_false',
	),
	'text_text'		=> array(
	    'label'			=> 'Overlay / On/Off',
	    'field'			=> 'm_showreel_options_0_text_text',
	    'type'			=> 'true_false',
	),
	'overlay_bg_color'	=> array(
	    'label'			=> 'Overlay / Hintergrundfarbe<br>HEX-Wert (z.B. #ffffff)',
	    'field'			=> 'm_showreel_options_0_overlay_bg_color',
	    'type'			=> 'input',
	    'reload'		=> 1,
	),
	'overlay_position'=> array(
	    'label'			=> 'Overlay / Position<br>(neg. Wert f&uuml;r Positionierung von unten)',
	    'field'			=> 'm_showreel_options_0_overlay_position',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'overlay_bg_opacity'=> array(
	    'label'			=> 'Overlay / Deckkraft (1-100)',
	    'field'			=> 'm_showreel_options_0_overlay_bg_opacity',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'logo'			=> array(
	    'label'			=> 'Content / Logos bzw. Bilder zeigen',
	    'field'			=> 'm_showreel_options_0_logo',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'w'				=> array(
	    'label'			=> 'Content / Breite Bild<br>Seitenverh&auml;ltnis',
	    'field'			=> 'm_showreel_options_0_w',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'h'				=> array(
	    'label'			=> 'Content / H&ouml;he Bild<br>Seitenverh&auml;ltnis',
	    'field'			=> 'm_showreel_options_0_h',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'image'			=> array(
	    'label'			=> 'Hintergrundbild',
	    'field'			=> 'm_showreel_options_0_image',
	    'type'			=> 'image', 
	),
);