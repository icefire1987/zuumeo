<?php

class acf_field_individole_flexible_fields extends acf_field
{
	
	function __construct()
	{
		// vars
		$this->name = 'individole_flexible_fields';
		$this->label = __('Individole - Flexible Fields');
		$this->category = __("Individole",'acf');
		
		$this->defaults = array(
			'layouts'		=>	array(),
			'min'			=>	'',
			'max'			=>	'',
			'button_label'	=>	__("Add Row",'acf'),
		);
		$this->l10n = array(
			'layout' 		=> __("layout", 'acf'),
			'layouts'		=> __("layouts", 'acf'),
			'remove'		=> __("remove {layout}?", 'acf'),
			'min'			=> __("This field requires at least {min} {identifier}",'acf'),
			'max'			=> __("This field has a limit of {max} {identifier}",'acf'),
			'min_layout'	=> __("This field requires at least {min} {label} {identifier}",'acf'),
			'max_layout'	=> __("Maximum {label} limit reached ({max} {identifier})",'acf'),
			'available'		=> __("{available} {label} {identifier} available (max {max})",'acf'),
			'required'		=> __("{required} {label} {identifier} required (min {min})",'acf'),
		);		
		
		// do not delete!
    	parent::__construct();
    	

    	// settings
		$this->settings = array(
			'base' 		=> apply_filters('acf/helpers/get_path', __FILE__).'/',
			'modules' 	=> apply_filters('acf/helpers/get_path', __FILE__).'_flexible_modules/',
			'path' 		=> ABSPATH.'wp-content/plugins/acf-flexible-content/',
			'dir' 		=> ABSPATH.'wp-content/plugins/acf-flexible-content/',
			'version' 	=> '1.1.0'
		);
	}
	
	function my_sub_fields($field) {
		global $individole;
		
		$current_post_language = 'de';
		if(isPolylang()) {
			global $polylang;
			
			if(isset($_GET['post'])) {
				$current_post_language = @$polylang->model->get_post_language($_GET['post'])->slug;	
			}
		}
		
		$conditional_logic = array(
			'status'			=> 0,
			'rules'				=> array(
				'field'				=> null,
				'operator'			=> '==',
				'value'				=> '',
			),
		);
		
		include( $this->settings['base'] . 'individole-flexible-fields-options.php' );
		
		foreach($labels AS $label_key => $label_headline) {
		    ${'config_base_'.$label_key} = array(
		    	'label'				=> 'Modul-<br>settings',
		    	'name'				=> 'config_base_'.$label_key,
		    	'key'				=> 'config_base_'.$label_key,
		    	'type'				=> 'repeater',
		    	'layout'			=> 'table',
		    	'row_limit' 		=> 1,
		    	'row_min' 			=> 1,
		    	'sub_fields'		=> array($c['inactive'], $c['top'], $c['bottom']),
		    );
		    
		    foreach($individole['flex_modules_options'] AS $k => $v) {
		    	if($v == true) {
		    		${'config_base_'.$label_key}['sub_fields'][] = $c[$k];
		    	}
		    }
		}
		
		
		array_push($config_base_columns['sub_fields'], $c['column_gap'], $c['grid']);
		
		
		//!INCLUDE all modules
		$modules_folder = $this->settings['modules'];
		foreach(glob($modules_folder.'*') AS $file) {
			if(endsWith2($file, ".php")) {
				include($file);
			}
		}
		
		
		$my_fields = array(
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'display' 			=> 'row',
			'label'				=> '',
			'instructions'		=> 'Added modules will be arranged with each other. If you want to arrange side by side use "Content columns"',
			'button_label'		=> '+ add content module',
			'type'				=> 'individole_flexible_fields',
			'layouts'			=> array(
			    'm_columns'			=> array(
			    	'label'				=> $labels['columns'],
			    	'button_label'		=> '+ add column',
			    	'type'				=> 'repeater',
			    	'name'				=> 'm_columns',
			    	'key'				=> 'm_columns',
			    	'display'			=> 'row',
			    	'sub_fields'		=> array(
			    		'config_base_columns'	=> $config_base_columns,
			    		'm_columns_content'	=> array(
			    			'label'				=> $labels['columns'],
			    			'button_label'		=> '+ add column',
			    			'type'				=> 'flexible_content',
			    			'name'				=> 'm_columns_content',
			    			'key'				=> 'm_columns_content',
			    			'layouts'			=> array(
			    				'm_flex'			=> array(
			    					'label'				=> 'A) mehrere Inhalte untereinander ...',
			    					'type'				=> 'repeater',
			    					'row_limit' 		=> 1,
			    					'row_min' 			=> 1,
			    					'name'				=> 'm_flex',
			    					'key'				=> 'm_flex',
			    					'display'			=> 'row',
			    					'sub_fields'		=> array(
			    						'config_base_flex'	=> $config_base_flex,
			    						'm_flex_content'	=> array(
			    							'label'				=> '...',
			    							'button_label'		=> '+ add column content',
			    							'type'				=> 'flexible_content',
			    							'name'				=> 'm_flex_content',
			    							'key'				=> 'm_flex_content',
			    							'layouts'			=> array(),
			    						),
			    					),
			    				),
			    			),
			    		),
			    	),	
			    ),
			),
		);
		
		
		foreach($individole['flex_modules'] AS $module_key => $module_value) {
			if($module_value == true && isset(${$module_key})) {
				$my_fields['layouts'][$module_key] = ${$module_key};
			}
			
			$module_key_2 = str_replace('m_', 'm_2_', $module_key);
			
			if($module_value == true && isset(${$module_key_2})) {
				$my_fields['layouts']['m_columns']['sub_fields']['m_columns_content']['layouts'][$module_key] = ${$module_key_2};
				$my_fields['layouts']['m_columns']['sub_fields']['m_columns_content']['layouts']['m_flex']['sub_fields']['m_flex_content']['layouts'][$module_key] = ${$module_key_2};
			}
		}
		
		
		return $my_fields;
	}
	
	
	
	
	function load_field( $field )
	{
		$field = array_merge($field, $this->my_sub_fields($field));
		
		// apply_load field to all sub fields
		if( isset($field['layouts']) && is_array($field['layouts']) )
		{
			foreach( $field['layouts'] as $k => $layout )
			{
				if( isset($layout['sub_fields']) && is_array($layout['sub_fields']) )
				{
					foreach( $layout['sub_fields'] as $i => $sub_field )
					{
						// apply filters
						$sub_field = apply_filters('acf/load_field_defaults', $sub_field);
						
						
						// apply filters
						foreach( array('type', 'name', 'key') as $key )
						{
							// run filters
							$sub_field = apply_filters('acf/load_field/' . $key . '=' . $sub_field[ $key ], $sub_field); // new filter
						}


						// update sub field
						$field['layouts'][ $k ]['sub_fields'][ $i ] = $sub_field;
						
					}
					// foreach( $layout['sub_fields'] as $i => $sub_field )
				}
				// if( isset($layout['sub_fields']) && is_array($layout['sub_fields']) )
			}
			// foreach( $field['layouts'] as $k => $layout )
		}
		// if( isset($field['layouts']) && is_array($field['layouts']) )
		
		return $field;
		
	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{
		include( $this->settings['path'] . 'views/field.php' );
	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		include( $this->settings['path'] . 'views/options.php' );
	}
	
	
	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the $post_id of which the value will be saved
	*
	*  @return	$value - the modified value
	*/
	
	function update_value( $value, $post_id, $field )
	{
		$field = array_merge($field, $this->my_sub_fields($field));
		
		// vars
		$sub_fields = array();
		
		foreach( $field['layouts'] as $layout )
		{
			foreach( $layout['sub_fields'] as $sub_field )
			{
				$sub_fields[ $sub_field['key'] ] = $sub_field;
			}
		}

		$total = array();
		
		if( $value )
		{
			// remove dummy field
			unset( $value['acfcloneindex'] );
			
			$i = -1;
			
			// loop through rows
			foreach($value as $row)
			{	
				$i++;
				
				
				// increase total
				$total[] = $row['acf_fc_layout'];
				unset( $row['acf_fc_layout'] );
				
				
				// loop through sub fields
				foreach($row as $field_key => $v)
				{
					$sub_field = $sub_fields[ $field_key ];

					// update full name
					$sub_field['name'] = $field['name'] . '_' . $i . '_' . $sub_field['name'];
					
					// save sub field value
					do_action('acf/update_value', $v, $post_id, $sub_field );
				}
			}
		}
		
		
		/*
		*  Remove Old Data
		*
		*  @credit: http://support.advancedcustomfields.com/discussion/1994/deleting-single-repeater-fields-does-not-remove-entry-from-database
		*/
		
		$old_total = apply_filters('acf/load_value', 0, $post_id, $field);
		$old_total = count( $old_total );
		$new_total = count( $total );

		if( $old_total > $new_total )
		{
			foreach( $sub_fields as $sub_field )
			{
				for ( $j = $new_total; $j < $old_total; $j++ )
				{ 
					do_action('acf/delete_value', $post_id, $field['name'] . '_' . $j . '_' . $sub_field['name'] );
				}
			}
		}
		
		
		// update $value and return to allow for the normal save function to run
		$value = $total;
		
		return $value;
	}
	
	
	/*
	*  update_field()
	*
	*  This filter is appied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the field group ID (post_type = acf)
	*
	*  @return	$field - the modified field
	*/

	function update_field( $field, $post_id )
	{
		// format sub_fields
		if( $field['layouts'] )
		{
			$layouts = array();
			
			// loop through and save fields
			foreach($field['layouts'] as $layout_key => $layout)
			{				
			
				if( $layout['sub_fields'] )
				{
					// remove dummy field
					unset( $layout['sub_fields']['field_clone'] );
				
				
					// loop through and save fields
					$i = -1;
					$sub_fields = array();
					
					
					foreach( $layout['sub_fields'] as $key => $f )
					{
						$i++;
				
				
						// order + key
						$f['order_no'] = $i;
						$f['key'] = $key;
						
						
						// save
						$f = apply_filters('acf/update_field/type=' . $f['type'], $f, $post_id ); // new filter
						
						
						$sub_fields[] = $f;
						
					}
					
					
					// update sub fields
					$layout['sub_fields'] = $sub_fields;
					
				}
				
				$layouts[] = $layout;
				
			}
			
			// clean array keys
			$field['layouts'] = $layouts;
			
		}
		

		// return updated repeater field
		return $field;
	}
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed to the create_field action
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value( $value, $post_id, $field )
	{
		$field = array_merge($field, $this->my_sub_fields($field));
		
		$layouts = array();
		foreach( $field['layouts'] as $l )
		{
			$layouts[ $l['name'] ] = $l;
		}
		

		// vars
		$values = false;
		$layout_order = false;


		if( is_array($value) && !empty($value) )
		{
			$i = -1;
			$values = array();
			
			
			// loop through rows
			foreach( $value as $layout )
			{
				$i++;
				$values[ $i ] = array();
				$values[ $i ]['acf_fc_layout'] = $layout;
				
				
				// check if layout still exists
				if( isset($layouts[ $layout ]) )
				{
					// loop through sub fields
					if( is_array($layouts[ $layout ]['sub_fields']) ){ foreach( $layouts[ $layout ]['sub_fields'] as $sub_field ){

						// update full name
						$key = $sub_field['key'];
						$sub_field['name'] = $field['name'] . '_' . $i . '_' . $sub_field['name'];
						
						$v = apply_filters('acf/load_value', false, $post_id, $sub_field);
						$v = apply_filters('acf/format_value', $v, $post_id, $sub_field);
						
						$values[ $i ][ $key ] = $v;

					}}
				}
			}
		}
		
		
		return $values;
	}
	
	
	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value_for_api( $value, $post_id, $field )
	{
		$field = array_merge($field, $this->my_sub_fields($field));
		
		$layouts = array();
		foreach( $field['layouts'] as $l )
		{
			$layouts[ $l['name'] ] = $l;
		}
		

		// vars
		$values = false;
		$layout_order = false;


		if( is_array($value) && !empty($value) )
		{
			$i = -1;
			$values = array();
			
			
			// loop through rows
			foreach( $value as $layout )
			{
				$i++;
				$values[ $i ] = array();
				$values[ $i ]['acf_fc_layout'] = $layout;
				
				
				// check if layout still exists
				if( isset($layouts[ $layout ]) )
				{
					// loop through sub fields
					if( is_array($layouts[ $layout ]['sub_fields']) ){ foreach( $layouts[ $layout ]['sub_fields'] as $sub_field ){

						// update full name
						$key = $sub_field['name'];
						$sub_field['name'] = $field['name'] . '_' . $i . '_' . $sub_field['name'];
						
						$v = apply_filters('acf/load_value', false, $post_id, $sub_field);
						$v = apply_filters('acf/format_value_for_api', $v, $post_id, $sub_field);
						
						$values[ $i ][ $key ] = $v;

					}}
				}
			}
		}
		
		
		return $values;
		
	}
}


// create field
new acf_field_individole_flexible_fields();

?>