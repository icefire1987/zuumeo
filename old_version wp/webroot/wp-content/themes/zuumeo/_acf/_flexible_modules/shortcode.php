<?php

$m_shortcode = $m_2_shortcode = array(
			'label'				=> $labels['shortcode'],
			'name'				=> 'm_shortcode',
			'key'				=> 'm_shortcode',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_shortcode,
				'm_shortcode_content' => array(
					'label'				=> 'Shortcode',
					'name'				=> 'm_shortcode_content',
					'key'				=> 'm_shortcode_content',
					'type'				=> 'repeater',
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'layout'			=> 'row',
					'sub_fields'		=> array(
						'code' 				=> array(
							'label'				=> 'Code',
							'name'				=> 'code',
							'key'				=> 'code',
							'type'				=> 'select',
							'choices'			=> $individole['choices_shortcode'],
						),
						'parameter' 		=> array(
							'label'				=> 'Parameter',
							'button_label'		=> '+ Parameter hinzuf&uuml;gen',
							'name'				=> 'parameter',
							'key'				=> 'parameter',
							'type'				=> 'repeater',
							'row_limit' 		=> 0,
							'row_min' 			=> 0,
							'layout'			=> 'table',
							'sub_fields'		=> array(
								'var' 				=> array(
								    'label'				=> 'Variable',
								    'name'				=> 'var',
								    'key'				=> 'var',
								    'type'				=> 'text',
								    'formatting'		=> 'none',
								    'column_width'		=> 30,
								),
								'value' 			=> array(
								    'label'				=> 'Wert/Inhalt',
								    'name'				=> 'value',
								    'key'				=> 'value',
								    'type'				=> 'text',
								    'formatting'		=> 'none',
								    'column_width'		=> 70,
								),
							),
						),
					),
				),
			),
		);