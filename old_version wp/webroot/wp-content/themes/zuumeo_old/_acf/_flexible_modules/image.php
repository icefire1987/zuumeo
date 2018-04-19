<?php

$choices_pages = getAdminPosts("page");
$choices_kunde = getAdminPosts("kunde");

$choices_all_posts = $choices_pages + $choices_kunde;

$m_image = $m_2_image = array(
			'label'				=> $labels['image'],
			'name'				=> 'm_image',
			'key'				=> 'm_image',
			'type'				=> 'repeater',
			'instructions'		=> '',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_image,
				'm_image_content'	=> array(
					'label'				=> 'Bild',
					'name'				=> 'm_image_content',
					'key'				=> 'm_image_content',
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'type'				=> 'repeater',
					'layout'			=> 'table',
					'sub_fields'		=> array(
						'image' 			=> array(
							'label'				=> 'Bild',
							'name'				=> 'image',
							'key'				=> 'image',
							'type'				=> 'image',
							'preview_size'		=> 'medium',
							'save_format'		=> 'id',
							'column_width'		=> 20,
						),
						'misc' 				=> array(
							'label'				=> 'Einstellungen',
							'name'				=> 'misc',
							'key'				=> 'misc',
							'type'				=> 'repeater',
							'layout'			=> 'row',
							'row_limit' 		=> 1,
							'row_min' 			=> 1,
							'column_width'		=> 80,
							'sub_fields'		=> array(
								'page' 				=> array(
									'label'				=> '1a) Interner Link',
									'name'				=> 'page',
									'key'				=> 'page',
									'type'				=> 'select',
									'choices'			=> $choices_all_posts,
									'allow_null'		=> '1',
								),
								'link' 				=> array(
									'label'				=> '1b) oder externer Link',
									'name'				=> 'link',
									'key'				=> 'link',
									'type'				=> 'text',
									'formatting'		=> 'none',
								),
								'zoom' 				=> array(
									'label'				=> '1c) oder Zoom',
									'name'				=> 'zoom',
									'key'				=> 'zoom',
									'type'				=> 'true_false',
									'default_value'		=> 'false',
								),
								'shadow' 			=> array(
									'label'				=> '2) Schatten',
									'name'				=> 'shadow',
									'key'				=> 'shadow',
									'type'				=> 'true_false',
									'default_value'		=> 'true',
								),
								'scale' 			=> array(
									'label'				=> '3) Skalierung',
									'instructions'		=> '0 f&uuml;r original Dateigr&ouml;&szlig;e',
									'name'				=> 'scale',
									'key'				=> 'scale',
									'type'				=> 'number',
									'default_value'		=> 100,
								),
								'alignment' 		=> array(
									'label'				=> '4) Ausrichtung',
									'name'				=> 'alignment',
									'key'				=> 'alignment',
									'type'				=> 'select',
									'choices'			=> $individole['choices_alignment'],
									'default_value'		=> 'left',
								),
								'title' 			=> array(
									'label'				=> '5) Beschriftung',
									'name'				=> 'title',
									'key'				=> 'title',
									'type'				=> 'text',
									'formatting'		=> 'none',
								),
							),
						),
					),
				),
			),
		);