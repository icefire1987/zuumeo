<?php

$m_downloads = $m_2_downloads = array(
    'label'				=> $labels['downloads'],
    'name'				=> 'm_downloads',
    'key'				=> 'm_downloads',
    'display'			=> 'row',
    'sub_fields'		=> array(
    	'config_base'		=> $config_base_downloads,
    	'm_downloads_content' => array(
    		'label'				=> 'Downloads',
    		'button_label'		=> '+ Download hinzuf&uuml;gen',
    		'name'				=> 'm_downloads_content',
    		'key'				=> 'm_downloads_content',
    		'type'				=> 'repeater',
    		'layout'			=> 'table',
    		'row_limit' 		=> 0,
    		'row_min' 			=> 0,
    		'sub_fields'		=> array(
    			'file' 				=> array(
    				'label'				=> 'Datei',
    				'name'				=> 'file',
    				'key'				=> 'file',
    				'type'				=> 'file',
    				'save_format'		=> 'id',
    				'column_width'		=> 60,
    			),
    			'options' 			=> array(
    				'label'				=> 'Einstellungen',
    				'name'				=> 'options',
    				'key'				=> 'options',
    				'type'				=> 'repeater',
    				'layout'			=> 'row',
    				'row_limit' 		=> 1,
    				'row_min' 			=> 1,
    				'column_width'		=> 40,
    				'sub_fields'		=> array(
    					'title' 			=> array(
    						'label'				=> 'Title',
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