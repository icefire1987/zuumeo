<?php

$config_modules = array(
	'title'			=> 'Spalten einstellen',
	'grid'			=> array(
	    'label'			=> 'Spalten-Raster',
	    'field'			=> 'config_base_columns_0_grid',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_grid'],
	    'reload'		=> 1,
	),
	'column_gap'	=> array(
	    'label'			=> 'Abstand Spalten',
	    'field'			=> 'config_base_columns_0_column_gap',
	    'type'			=> 'select',
	    'choices'		=> $individole['choices_gap_columns'],
	    'reload'		=> 1,
	),
);