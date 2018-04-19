<?php

if(isset($_POST['data_edit']) || isset($_POST['data_edit_meta'])) {
	global $individole;
	
	$l = '';
	if(isPolylang()) {
		global $polylang;
		
		$l = @$polylang->model->get_post_language($_POST['post_id'])->slug;
	}
	
	$config_modules_base = array(
		'inactive'		=> array(
			'status'		=> true,
			'label'			=> 'Inactive',
			'type'			=> 'true_false',
		),
		'top'			=> array(
			'status'		=> true,
			'label'			=> 'Gap top',
			'type'			=> 'number',
			'min'			=> 0,
		),
		'bottom'		=> array(
			'status'		=> true,
			'label'			=> 'Gap bottom',
			'type'			=> 'number',
			'min'			=> 0,
		),
		//'column_gaps'	=> array(
		//	'status'		=> true,
		//	'label'			=> 'Column gaps',
		//	'type'			=> 'select',
		//	'choices'		=> $individole['choices_module_column_gaps'],
		//),
		//'inset'			=> array(
		//	'status'		=> true,
		//	'label'			=> 'Gap left/right',
		//	'type'			=> 'select',
		//	'choices'		=> $individole['choices_module_inset'],
		//),
		//'box' 			=> array(
		//	'status'		=> true,
		//	'label'			=> 'Box',
		//	'type'			=> 'true_false',
		//),
		//'view' 			=> array(
		//	'status'		=> false,
		//	'label'			=> 'View',
		//	'type'			=> 'select',
		//	'choices'		=> $individole['choices_module_view'],
		//),
	);
	
	
	foreach($individole['flex_modules_options'] AS $k => $v) {
		if($v == true) {
		    $config_modules_base[$k]['status'] = true;
		}
	}
	
	if(isset($_POST['module_type'])) {
		include(apply_filters('acf/helpers/get_path', __FILE__).'_frontend_modules/'.$_POST['module_type'].'.php');
	}
}

?>