<?php

$m_video = $m_2_video = array(
			'label'				=> $labels['video'],
			'name'				=> 'm_video',
			'key'				=> 'm_video',
			'instructions'		=> '',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_video,
				'm_video_configs'	=> array(
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'label'				=> 'Videoplayer<br>Einstellungen',
					'name'				=> 'm_video_configs',
					'key'				=> 'm_video_configs',
					'type'				=> 'repeater',
					'layout' 			=> 'row',
					'sub_fields'		=> array(
						'autostart' 		=> array(
							'label'				=> 'Autostart',
							'name'				=> 'autostart',
							'key'				=> 'autostart',
							'type'				=> 'true_false',
						),
						'controls' 			=> array(
							'label'				=> 'Steuerelemente',
							'name'				=> 'controls',
							'key'				=> 'controls',
							'type'				=> 'true_false',
						),
						'icons' 			=> array(
							'label'				=> 'Play-Button',
							'name'				=> 'icons',
							'key'				=> 'icons',
							'type'				=> 'true_false',
						),
						'w' 				=> array(
							'label'				=> 'Breite',
							'name'				=> 'w',
							'key'				=> 'w',
							'type'				=> 'number',
							'default_value'		=> 640,
						),
						'h' 				=> array(
							'label'				=> 'H&ouml;he',
							'name'				=> 'h',
							'key'				=> 'h',
							'type'				=> 'number',
							'default_value'		=> 480,
						),
					),
				),
				
				'm_video'			=> array(
					'row_limit' 		=> 0,
					'row_min' 			=> 0,
					'label'				=> 'Video(s)',
					'button_label'		=> '+ Video hinzuf&uuml;gen',
					'name'				=> 'm_video',
					'key'				=> 'm_video',
					'type'				=> 'repeater',
					'layout' 			=> 'row',
					'column_width'		=> '70',
					'instructions'		=> '',
					'sub_fields'		=> array(
						'source' 			=> array(
							'label'				=> 'Videoquelle',
							'name'				=> 'source',
							'key'				=> 'source',
							'type'				=> 'select',
							'choices'			=> $individole['choices_video_source'],
							'default_value'		=> 'embed',
						),
						'image' 			=> array(
							'label'				=> 'Vorschau',
							'name'				=> 'image',
							'key'				=> 'image',
							'type'				=> 'image',
							'preview_size'		=> 'medium',
							'save_format'		=> 'id',
						),
						'embed' 			=> array(
							'label'				=> '(A)<br>Embed-Code<br>oder URL',
							'name'				=> 'embed',
							'key'				=> 'embed',
							'type'				=> 'textarea',
							'formatting'		=> 'none',
							'instructions'		=> '',
						),
						'upload'			=> array(
							'row_limit' 		=> 1,
							'row_min' 			=> 1,
							'label'				=> '(B)<br>Upload',
							'name'				=> 'upload',
							'key'				=> 'upload',
							'type'				=> 'repeater',
							'layout' 			=> 'row',
							'instructions'		=> '',
							'sub_fields'		=> array(
								'mp4' 				=> array(
									'label'				=> 'MP4',
									'name'				=> 'mp4',
									'key'				=> 'mp4',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
								'ogg' 				=> array(
									'label'				=> 'OGG',
									'name'				=> 'ogg',
									'key'				=> 'ogg',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
							),
						),
					),
				),
			),
		);