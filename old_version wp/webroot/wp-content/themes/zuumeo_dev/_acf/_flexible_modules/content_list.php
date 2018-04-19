<?php

$choices_pages = getAdminPosts("page");
$choices_kunde = getAdminPosts("kunde");

$choices_all_posts = $choices_pages + $choices_kunde;

$m_content_list = $m_2_content_list = array(
			'label'				=> $labels['content_list'],
			'name'				=> 'm_content_list',
			'key'				=> 'm_content_list',
			'display'			=> 'row',
			'sub_fields'		=> array(
				'config_base'		=> $config_base_content_list,
				'm_content_list_content' => array(
					'label'				=> 'Posts',
					'name'				=> 'm_content_list_content',
					'key'				=> 'm_content_list_content',
					'type'				=> 'repeater',
					'row_limit' 		=> 0,
					'row_min' 			=> 0,
					'sub_fields'		=> array(
						'post' 				=> array(
							'label'				=> 'Post',
							'name'				=> 'post',
							'key'				=> 'post',
							'type'				=> 'select',
							'choices'			=> $choices_all_posts,
						),
					),
				),
			),
		);