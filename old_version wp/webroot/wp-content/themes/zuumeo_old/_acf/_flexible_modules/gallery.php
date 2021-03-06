<?php

$m_gallery = $m_2_gallery = array(
			'label'				=>$labels['gallery'],
			'name'				=> 'm_gallery',
			'key'				=> 'm_gallery',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_gallery,
				'm_gallery_images' 	=> array(
					'label'				=> 'Bilder',
					'name'				=> 'm_gallery_images',
					'key'				=> 'm_gallery_images',
					'type'				=> 'gallery',
					'preview_size'		=> 'medium',
					'save_format'		=> 'id',
				),
				'm_gallery_options' => array(
					'label'				=> 'Slideshow-<br>einstellungen',
					'name'				=> 'm_gallery_options',
					'key'				=> 'm_gallery_options',
					'type'				=> 'repeater',
					'layout'			=> 'table',
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'sub_fields'		=> array(
						'options'			=> array(
							'label'				=> 'Options',
							'name'				=> 'options',
							'key'				=> 'options',
							'type'				=> 'repeater',
							'row_limit' 		=> 1,
							'row_min' 			=> 1,
							'layout'			=> 'row',
							'sub_fields'		=> array(
								'type'			=> array(
									'label'				=> 'Art der Darstellung',
									'name'				=> 'type',
									'key'				=> 'type',
									'type'				=> 'select',
									'choices'			=> $individole['choices_gallery_type'],
									'default_value'		=> 'slideshow',
								),
								'random'			=> array(
									'label'				=> 'ALLG. / zuf&auml;llige Reihenfolge',
									'name'				=> 'random',
									'key'				=> 'random',
									'type'				=> 'true_false',
								),
								'zoom'				=> array(
									'label'				=> 'ALLG. / Bilder-Zoom',
									'name'				=> 'zoom',
									'key'				=> 'zoom',
									'type'				=> 'true_false',
								),
								'w'					=> array(
									'label'				=> 'ALLG. / Seitenverh&auml;ltnis - Breite',
									'name'				=> 'w',
									'key'				=> 'w',
									'type'				=> 'number',
									'default_value'		=> 0,
								),
								'h'					=> array(
									'label'				=> 'ALLG. / Seitenverh&auml;ltnis - H&ouml;he',
									'name'				=> 'h',
									'key'				=> 'h',
									'type'				=> 'number',
									'default_value'		=> 0,
								),
								'name'				=> array(
									'label'				=> 'ALLG. / Name',
									'name'				=> 'name',
									'key'				=> 'name',
									'type'				=> 'text',
									'formatting'		=> 'none',
									'default_value'		=> '',
								),
								'initial_transition'=> array(
									'label'				=> 'SLIDESHOW / Effekt 1. Bild',
									'name'				=> 'initial_transition',
									'key'				=> 'initial_transition',
									'type'				=> 'select',
									'choices'			=> array(
										'fade'				=> 'Fade',
										'slide'				=> 'Slide',
									),
									'default_value'		=> 'fade',
								),
								'transition'		=> array(
									'label'				=> 'SLIDESHOW / Effekt ab 2. Bild',
									'name'				=> 'transition',
									'key'				=> 'transition',
									'type'				=> 'select',
									'choices'			=> array(
										'fade'				=> 'Fade',
										'slide'				=> 'Slide',
									),
									'default_value'		=> 'slide',
								),
								'transition_speed'	=> array(
									'label'				=> 'SLIDESHOW / Speed in ms',
									'name'				=> 'transition_speed',
									'key'				=> 'transition_speed',
									'type'				=> 'number',
									'default_value'		=> 800,
								),
								'autoplay'			=> array(
									'label'				=> 'SLIDESHOW / Autoplay',
									'name'				=> 'autoplay',
									'key'				=> 'autoplay',
									'type'				=> 'true_false',
								),
								'thumbnails'		=> array(
									'label'				=> 'SLIDESHOW / Thumbs',
									'name'				=> 'thumbnails',
									'key'				=> 'thumbnails',
									'type'				=> 'true_false',
								),
								'dots'				=> array(
									'label'				=> 'SLIDESHOW / Nav.-Buttons',
									'name'				=> 'dots',
									'key'				=> 'dots',
									'type'				=> 'true_false',
								),
								'pan'				=> array(
									'label'				=> 'SLIDESHOW / Pan',
									'name'				=> 'pan',
									'key'				=> 'pan',
									'type'				=> 'true_false',
								),
								'wand_masonry'		=> array(
									'label'				=> 'BILDERWAND / dynamisch',
									'name'				=> 'wand_masonry',
									'key'				=> 'wand_masonry',
									'type'				=> 'true_false',
								),
								'wand_cols'			=> array(
									'label'				=> 'BILDERWAND / Spalten',
									'name'				=> 'wand_cols',
									'key'				=> 'wand_cols',
									'type'				=> 'select',
									'choices'			=> $individole['choices_gallery_wand_cols'],
									'default_value'		=> 3,
								),
								'wand_gap'			=> array(
									'label'				=> 'BILDERWAND / Bildabstand',
									'name'				=> 'wand_gap',
									'key'				=> 'wand_gap',
									'type'				=> 'select',
									'choices'			=> $individole['choices_gallery_wand_gap'],
									'default_value'		=> 10,
								),
								'wand_shadow'		=> array(
									'label'				=> 'BILDERWAND / Bildschatten',
									'name'				=> 'wand_shadow',
									'key'				=> 'wand_shadow',
									'type'				=> 'true_false',
								),
							),
						),
					),
				),
				'm_gallery_text' 	=> array(
					'label'				=> 'Text-Overlay',
					'name'				=> 'm_gallery_text',
					'key'				=> 'm_gallery_text',
					'type'				=> 'repeater',
					'layout'			=> 'row',
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'sub_fields'		=> array(
						'status'			=> array(
							'label'				=> 'On/Off',
							'name'				=> 'status',
							'key'				=> 'status',
							'type'				=> 'true_false',
						),
						'background'		=> array(
							'label'				=> 'Hintergrundfl&auml;che',
							'name'				=> 'background',
							'key'				=> 'background',
							'type'				=> 'true_false',
						),
						'background_color'	=> array(
							'label'				=> 'Hintergrund',
							'instructions'		=> 'Farbe',
							'name'				=> 'background_color',
							'key'				=> 'background_color',
							'type'				=> 'color_picker',
							'default_value'		=> '#FFFFFF',
						),
						'background_opacity'=> array(
							'label'				=> 'Hintergrund',
							'instructions'		=> 'Deckkraft (1-100)',
							'name'				=> 'background_opacity',
							'key'				=> 'background_opacity',
							'type'				=> 'number',
							'default_value'		=> 0,
						),
						'position'			=> array(
							'label'				=> 'Position (von oben/unten)',
							'instructions'		=> 'neg. Werte f&uuml;r Position von unten',
							'name'				=> 'position',
							'key'				=> 'position',
							'type'				=> 'number',
							'default_value'		=> 0,
						),
						'title'				=> array(
							'label'				=> 'Title',
							'name'				=> 'title',
							'key'				=> 'title',
							'type'				=> 'text',
							'formatting'		=> 'none',
						),
						'subtitle'			=> array(
							'label'				=> 'Subtitle',
							'name'				=> 'subtitle',
							'key'				=> 'subtitle',
							'type'				=> 'text',
							'formatting'		=> 'none',
						),
						'text'				=> array(
							'label'				=> 'Text',
							'name'				=> 'text',
							'key'				=> 'text',
							'type'				=> 'textarea',
							'formatting'		=> 'none',
							/* 'type'				=> 'wysiwyg', */
							/* 'media_upload' 		=> 'no', */
						),
					),
				),
				
			),
		);