<?php

$config_modules = array(
	'title'			=> 'Galerie bearbeiten',
	'images'			=> array(
	    'label'			=> 'Bilder',
	    'field'			=> 'm_gallery_images',
	    'type'			=> 'gallery',
	),
	'type'			=> array(
	    'label'			=> 'Art der Darstellung',
	    'field'			=> 'm_gallery_options_0_options_0_type',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_gallery_type'],
	    'reload'		=> 1,
	),
	'w'				=> array(
	    'label'			=> 'Seitenverh&auml;ltnis<br>Breite',
	    'field'			=> 'm_gallery_options_0_options_0_w',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'h'				=> array(
	    'label'			=> 'Seitenverh&auml;ltnis<br>H&ouml;he',
	    'field'			=> 'm_gallery_options_0_options_0_h',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'random'		=> array(
	    'label'			=> 'zuf&auml;llige Reihenfolge',
	    'field'			=> 'm_gallery_options_0_options_0_random',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'zoom'			=> array(
	    'label'			=> 'Zoom/Lightbox',
	    'field'			=> 'm_gallery_options_0_options_0_zoom',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'autoplay'		=> array(
	    'label'			=> 'SLIDESHOW<br>Autoplay',
	    'field'			=> 'm_gallery_options_0_options_0_autoplay',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'pan'			=> array(
	    'label'			=> 'SLIDESHOW<br>Pan',
	    'field'			=> 'm_gallery_options_0_options_0_pan',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'thumbnails'	=> array(
	    'label'			=> 'SLIDESHOW<br>Nav.-Buttons',
	    'field'			=> 'm_gallery_options_0_options_0_dots',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'dots'			=> array(
	    'label'			=> 'SLIDESHOW<br>Thumbnails',
	    'field'			=> 'm_gallery_options_0_options_0_thumbnails',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'sl_text_status'=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay',
	    'field'			=> 'm_gallery_text_0_status',
	    'type'			=> 'true_false',
	),
	'sl_text_background'=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay<br>Hintergrund',
	    'field'			=> 'm_gallery_text_0_background',
	    'type'			=> 'true_false',
	),
	'sl_text_bg_color'=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay<br>Hintergrundfarbe',
	    'field'			=> 'm_gallery_text_0_background_color',
	),
	'sl_text_bg_opacity'=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay<br>HG Deckkraft',
	    'field'			=> 'm_gallery_text_0_background_opacity',
	    'type'			=> 'number',
	),
	'sl_text_position'=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay<br>Position',
	    'help'			=> '(neg. Wert f&uuml;r Position von unten)',
	    'field'			=> 'm_gallery_text_0_position',
	    'type'			=> 'number',
	),
	'sl_text_title'		=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay<br>Title',
	    'field'			=> 'm_gallery_text_0_title',
	),
	'sl_text_subtitle'	=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay<br>Subtitle',
	    'field'			=> 'm_gallery_text_0_subtitle',
	),
	'sl_text_text'		=> array(
	    'label'			=> 'SLIDESHOW<br>Text-Overlay<br>Text',
	    'field'			=> 'm_gallery_text_0_text',
	    'type'			=> 'textarea',
	),
	'wand_masonry'	=> array(
	    'label'			=> 'BILDERWAND<br>autom. Anordnung',
	    'field'			=> 'm_gallery_options_0_options_0_wand_masonry',
	    'type'			=> 'true_false',
	),
	'wand_cols'		=> array(
	    'label'			=> 'BILDERWAND<br>Spalten',
	    'field'			=> 'm_gallery_options_0_options_0_wand_cols',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_gallery_wand_cols'],
	    'reload'		=> 1,
	),
	'wand_gap'		=> array(
	    'label'			=> 'BILDERWAND<br>Bildabstand',
	    'field'			=> 'm_gallery_options_0_options_0_wand_gap',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_gallery_wand_gap'],
	    'reload'		=> 1,
	),
	'wand_shadow'		=> array(
	    'label'			=> 'BILDERWAND<br>Bildschatten',
	    'field'			=> 'm_gallery_options_0_options_0_wand_shadow',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
);