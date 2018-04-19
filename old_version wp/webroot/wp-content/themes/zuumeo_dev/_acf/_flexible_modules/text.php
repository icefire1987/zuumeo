<?php

$m_text = $m_2_text = array(
			'label'				=> $labels['text'],
			'name'				=> 'm_text',
			'key'				=> 'm_text',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_text,
				'm_text_text' 		=> array(
					'label'				=> 'Text',
					'name'				=> 'm_text_text',
					'key'				=> 'm_text_text',
					'type'				=> 'wysiwyg',
					'toolbar'			=> 'full',
					'media_upload' 		=> 'yes',
				),
			),
		);