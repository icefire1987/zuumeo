<?php

$config_modules = array(
	'title'			=> 'Bildliste bearbeiten',
	'per_row'		=> array(
	    'label'			=> 'Bilder pro Reihe',
	    'field'			=> 'm_image_list_options_0_configs_base_0_per_row',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_image_list_per_row'],
	    'reload'		=> 1,
	),
	'text'			=> array(
	    'label'			=> 'Textanzeige',
	    'field'			=> 'm_image_list_options_0_configs_base_0_text',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_imagelist_text'],
	    'reload'		=> 1,
	),
	'gap'			=> array(
	    'label'			=> 'Abstand Bilder',
	    'field'			=> 'm_image_list_options_0_configs_base_0_gap',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_gap_columns'],
	    'reload'		=> 1,
	),
	'scale'			=> array(
	    'label'			=> 'Bild-Skalierung',
	    'field'			=> 'm_image_list_options_0_configs_base_0_scale',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_image_list_scale'],
	    'reload'		=> 1,
	),
	'overlay_bg_color'	=> array(
	    'label'			=> 'Text-Overlay / Hintergrundfarbe<br>(HEX, z.B. #FFFFFF)',
	    'field'			=> 'm_image_list_options_0_configs_base_0_overlay_bg_color',
	    'type'			=> 'text',
	    'reload'		=> 1,
	),
	'overlay_bg_opacity'	=> array(
	    'label'			=> 'Text-Overlay / Deckkraft Hintergrund<br>(1-100)',
	    'field'			=> 'm_image_list_options_0_configs_base_0_overlay_bg_opacity',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'overlay_position'	=> array(
	    'label'			=> 'Text-Overlay / Positionierung',
	    'field'			=> 'm_image_list_options_0_configs_base_0_overlay_position',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'shadow'		=> array(
	    'label'			=> 'Bildschatten',
	    'field'			=> 'm_image_list_options_0_configs_base_0_shadow',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	    'help_title'	=> 'Infos zu Canvas',
	    'help'			=> 'Die Bilder werden in gleichmäßig vertielte Rahmen eingepasst. Standard sind quadratische Rahmen, alternativ ein Seitenverhältnis angeben. Breite + Höhe MÜSSEN > 0 sein.',
	),
	'canvas'			=> array(
	    'label'			=> 'Canvas an/aus',
	    'field'			=> 'm_image_list_options_0_configs_canvas_0_status',
	    'type'			=> 'true_false',
	    'reload'		=> 1,
	),
	'canvas_w'			=> array(
	    'label'			=> 'Canvas Breite',
	    'field'			=> 'm_image_list_options_0_configs_canvas_0_canvas_w',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
	'canvas_h'			=> array(
	    'label'			=> 'Canvas Höhe',
	    'field'			=> 'm_image_list_options_0_configs_canvas_0_canvas_h',
	    'type'			=> 'number',
	    'reload'		=> 1,
	),
);