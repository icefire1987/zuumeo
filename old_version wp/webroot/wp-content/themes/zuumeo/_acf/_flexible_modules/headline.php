<?php

$m_headline = $m_2_headline = array(
			'label'				=> $labels['headline'],
			'name'				=> 'm_headline',
			'key'				=> 'm_headline',
			'type'				=> 'repeater',
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'instructions'		=> '',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_headline,
				'm_headline_content'=> array(
					'label'				=> 'Headline<br>Options',
					'name'				=> 'm_headline_content',
					'key'				=> 'm_headline_content',
					'type'				=> 'repeater',
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'sub_fields'		=> array(
						'text' 				=> array(
							'label'				=> 'Text',
							'name'				=> 'text',
							'key'				=> 'text',
							'column_width'		=> 55,
							'type'				=> 'text',
							'formatting'		=> 'none',
						),
						'type' 			=> array(
							'label'				=> 'Typ',
							'name'				=> 'type',
							'key'				=> 'type',
							'column_width'		=> 15,
							'type'				=> 'select',
							'choices'			=> $individole['choices_headline_type'],
							'default_value'		=> 'h2',
						),
						'alignment' 		=> array(
							'label'				=> 'Ausrichtung',
							'name'				=> 'alignment',
							'key'				=> 'alignment',
							'column_width'		=> 15,
							'type'				=> 'select',
							'choices'			=> $individole['choices_alignment'],
							'default_value'		=> 'left',
						),
						'underline' 		=> array(
							'label'				=> 'Unter-<br>strichen',
							'name'				=> 'underline',
							'key'				=> 'underline',
							'column_width'		=> 15,
							'type'				=> 'true_false',
						),
					),
				),
			),
		);