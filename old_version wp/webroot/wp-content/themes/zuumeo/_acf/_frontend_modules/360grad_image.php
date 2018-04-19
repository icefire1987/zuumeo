<?php

$config_modules = array(
	'title'			=> '360 Grad Bild bearbeiten',
	'image_1'		=> array(
	    'label'			=> 'Basis-Bild (1. Frame)',
	    'field'			=> 'm_360grad_images_#_image_1',
	    'type'			=> 'image', 
	),
	'image_2'		=> array(
	    'label'			=> 'Bildsequenz<br>Einzelbild mit allen<br>Frames im Uhrzeigersinn',
	    'field'			=> 'm_360grad_images_#_image_2',
	    'type'			=> 'image', 
	),
	'frames'		=> array(
	    'label'			=> '# Frames',
	    'field'			=> 'm_360grad_images_#_frames',
	    'type'			=> 'number', 
	),
);