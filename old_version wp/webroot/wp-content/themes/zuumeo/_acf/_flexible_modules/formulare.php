<?php

$choices_formulare = getAdminPosts("formulare");

$m_formulare = $m_2_formulare = array(
			'label'				=> $labels['formulare'],
			'name'				=> 'm_formulare',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_formulare,
				'm_formulare_id'	=> array(
					'label'				=> 'Formular',
					'name'				=> 'm_formulare_id',
					'key'				=> 'm_formulare_id',
					'type'				=> 'select',
					'choices'			=> $choices_formulare,
				),
			),
		);