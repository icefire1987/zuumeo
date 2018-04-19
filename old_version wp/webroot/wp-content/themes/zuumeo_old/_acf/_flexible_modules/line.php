<?php

$m_line = $m_2_line = array(
			'label'				=> $labels['line'],
			'name'				=> 'm_line',
			'key'				=> 'm_line',
			'type'				=> 'repeater',
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'instructions'		=> '',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_line,
				'm_line_options' 	=> array(
					'label'				=> 'Linien-<br>einstellungen',
					'name'				=> 'm_line_options',
					'key'				=> 'm_line_options',
					'type'				=> 'repeater',
					'layout'			=> 'table',
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'sub_fields'		=> array(
						//'top_title'			=> array(
						//	'label'				=> 'Oben / Titel',
						//	'name'				=> 'top_title',
						//	'key'				=> 'top_title',
						//	'type'				=> 'text',
						//	'default_value'		=> '',
						//),
						//'top_color'			=> array(
						//	'label'				=> 'Oben / Farbe',
						//	'name'				=> 'top_color',
						//	'key'				=> 'top_color',
						//	'type'				=> 'select',
						//	'default_value'		=> 'no_color',
						//	'choices'			=> $individole['choices_line_color'],
						//),
						//'bottom_title'		=> array(
						//	'label'				=> 'Unten / Titel',
						//	'name'				=> 'bottom_title',
						//	'key'				=> 'bottom_title',
						//	'type'				=> 'text',
						//	'default_value'		=> '',
						//),
						//'bottom_color'		=> array(
						//	'label'				=> 'Unten / Farbe',
						//	'name'				=> 'bottom_color',
						//	'key'				=> 'bottom_color',
						//	'type'				=> 'select',
						//	'default_value'		=> 'no_color',
						//	'choices'			=> array(
						//		'no_color'			=> 'Keine Farbe',
						//		'grey'				=> 'Hellgrau',
						//		'blue'				=> 'Dunkelgrau',
						//	),
						//),
					),
				),
				
			),
		);