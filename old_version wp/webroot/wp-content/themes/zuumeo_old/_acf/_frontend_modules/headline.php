<?php

$config_modules = array(
	'title'			=> 'Überschrift bearbeiten',
	'text'			=> array(
	    'label'			=> 'Text',
	    'field'			=> 'm_headline_content_0_text',
	    'type'			=> 'input', 
	),
	'type'			=> array(
	    'label'			=> 'Typ',
	    'field'			=> 'm_headline_content_0_type',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_headline_type'],
	    'reload'		=> 1,
	),
	'alignment'		=> array(
	    'label'			=> 'Ausrichtung',
	    'field'			=> 'm_headline_content_0_alignment',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_alignment'],
	    'reload'		=> 1,
	),
	'underline'			=> array(
	    'label'			=> 'Unterstrichen',
	    'field'			=> 'm_headline_content_0_underline',
	    'type'			=> 'true_false', 
	),
);