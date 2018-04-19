<?php

/*
*  my-field.php
*
*  This file acts as a template for creating a new field type in the
*  Advanced Custom Fields plugin.
*
*  @since	4.0.0
*  @date	DD/MM/YYYY
*
*  @info	http://www.advancedcustomfields.com/docs/tutorials/creating-a-new-field-type/
*/

class acf_field_individole_options_standards extends acf_field
{
	
	var $settings;
	
	
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'individole_options_standards';
		$this->label = __('Individolé - Standard-Inhalte');
		$this->category = __("Individole",'acf');
		
		
		// do not delete!
    	parent::__construct();
    	
    	// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);
	}
	
	
	
	function my_sub_fields($field) 
	{
		global $individole;
		
		$choices_pages = getAdminPosts("page");
		
		$my_fields = array(
			'row_limit' 		=> 0,
			'row_min' 			=> 0,
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'layout' 			=> 'table',
			'button_label'		=> '+ hinzuf&uuml;gen',
			'type'				=> 'individole_options_standards',
			'sub_fields' 		=> array(
				'options_options' 	=> array(
					'required'			=> 0,
					'row_limit'			=> 1,
					'row_min'			=> 1,
					'name'				=> 'options_options',
					'key'				=> 'options_options',
					'label'				=> 'Options <sup>Admin only</sup>',
					'type'				=> 'repeater',
					'column_width'		=> '32',
					'layout' 			=> 'row',
					'sub_fields' 		=> array(
						'options_description' => array(
							'required'			=> 0,
							'name'				=> 'options_description',
							'key'				=> 'options_description',
							'label'				=> 'Help',
							'type'				=> 'textarea',
							'formatting'		=> 'none',
							'default_value'		=> '',
							'instructions'		=> '',
							'readonly'			=> 1,
							'column_width'		=> '70',
						),
						'options_var' 	=> array(
							'required'			=> 0,
							'name'				=> 'options_var',
							'key'				=> 'options_var',
							'label'				=> 'Var',
							'type'				=> 'text',
							'formatting'		=> 'none',
							'default_value'		=> '',
							'instructions'		=> '',
							'readonly'			=> 1,
							'hide'				=> 1,
							'column_width'		=> '30',
						),
					),
				),		
			),
		);
		
		switch($field['options']) {
			case "numbers":
		    	$my_fields['button_label'] = '+ Wert hinzuf&uuml;gen';
		    	break;
		    	
		    case "colors":
		    	$my_fields['button_label'] = '+ Farbe hinzuf&uuml;gen';
		    	break;
		    	
		    case "words":
		    	$my_fields['button_label'] = '+ Wort/Wortgruppe hinzuf&uuml;gen';
		    	break;
		    	
		    case "clauses":
		    	$my_fields['button_label'] = '+ Satz hinzuf&uuml;gen';
		    	break;
		    	
		    case "admin":
		    	$my_fields['button_label'] = '+ Wert hinzuf&uuml;gen';
		    	break;
		    	
		    case "texts":
		    	$my_fields['button_label'] = '+ Text hinzuf&uuml;gen';
		    	break;
		    	
		    case "files":
		    	$my_fields['button_label'] = '+ Datei/Bild hinzuf&uuml;gen';
		    	break;
		    
		    case "galleries":
		    	$my_fields['button_label'] = '+ Galerie hinzuf&uuml;gen';
		    	break;
		    	
		    case "status":
		    	$my_fields['button_label'] = '+ Status hinzuf&uuml;gen';
		    	break;
		    
		    case "pages":
		    	$my_fields['button_label'] = '+ Seite hinzuf&uuml;gen';
		    	break;
		}
		
		
		if(isPolylang()) {
			global $polylang;
			
			$options_content_languages = array();
			foreach($polylang->model->get_languages_list() AS $language) {
				$title 	= $language->name;
				$slug 	= $language->slug;
				
				$options_content_languages[$slug] = array(
					'required'			=> 0,
					'name'				=> $slug,
					'key'				=> $slug,
					'label'				=> $title,
					'default_value'		=> '',
					'instructions'		=> '',
				);
				
				
				switch($field['options']) {
					case "numbers":
						$options_content_languages[$slug]['type'] = 'number';
						$options_content_languages[$slug]['default_value'] = 0;
						break;
						
					case "colors":
						$options_content_languages[$slug]['type'] = 'color_picker';
						break;
						
					case "words":
						$options_content_languages[$slug]['type'] = 'text';
						$options_content_languages[$slug]['formatting'] = 'none';
						break;
						
					case "clauses":
						$options_content_languages[$slug]['type'] = 'textarea';
						$options_content_languages[$slug]['formatting'] = 'none';
						break;
						
					case "admin":
						$options_content_languages[$slug]['type'] = 'text';
						$options_content_languages[$slug]['formatting'] = 'none';
						break;
						
					case "texts":
						$options_content_languages[$slug]['type'] = 'wysiwyg';
						$options_content_languages[$slug]['toolbar'] = 'full';
						$options_content_languages[$slug]['media_upload'] = 'yes';
						$options_content_languages[$slug]['the_content'] = 'no';
						break;
						
					case "files":
						$options_content_languages[$slug]['row_limit'] = 1;
						$options_content_languages[$slug]['row_min'] = 1;
						$options_content_languages[$slug]['type'] = 'repeater';
						$options_content_languages[$slug]['sub_fields'] = array(
							'normal' 			=> array(
								'required'			=> 0,
								'name'				=> 'normal',
								'key'				=> 'normal',
								'label'				=> 'Normal',
								'type'				=> 'image',
								'preview_size'		=> 'medium',
								'save_format'		=> 'id',
							),
							'retina' 			=> array(
								'required'			=> 0,
								'name'				=> 'retina',
								'key'				=> 'retina',
								'label'				=> 'Retina <sup>optional</sup>',
								'type'				=> 'image',
								'preview_size'		=> 'medium',
								'save_format'		=> 'id',
							),
						);
						$options_content_languages[$slug]['instructions'] = 'ersetzt Standard';
						break;
					
					case "galleries":
						$options_content_languages[$slug]['type'] = 'gallery';
						$options_content_languages[$slug]['preview_size'] = 'medium';
						$options_content_languages[$slug]['save_format'] = 'id';
						$options_content_languages[$slug]['instructions'] = 'ersetzt Standard';
						break;
					
					case "status":
						$options_content_languages[$slug]['type'] = 'true_false';
						/* $options_content_languages[$slug]['choices'] = array('status' => "Aktiviert"); */
						break;
						
					case "pages":
						$options_content_languages[$slug]['type'] = 'select';
						$options_content_languages[$slug]['choices'] = $choices_pages;
						$options_content_languages[$slug]['allow_null'] = 1;
						
						break;
				}
			}
			
			if(!empty($options_content_languages)) {
				$final_options_content_languages = $options_content_languages;
				
				if($field['options'] == "galleries") {	
					$options_content_languages_standard['standard'] = array(
						'required'			=> 0,
						'label' 		=> 'Standard f&uuml;r alle Sprachen',
						'name' 			=> 'standard',
						'key' 			=> 'standard',
						'type' 			=> 'gallery',
						'preview_size' 	=> 'medium',
						'save_format' 	=> 'id',
					);
					
					$final_options_content_languages = array_merge($options_content_languages_standard, $options_content_languages);
				}
				
				
				if($field['options'] == "files") {	
					$options_content_languages_standard['standard'] = array(
						'label' 		=> 'Standard f&uuml;r alle Sprachen',
						'name' 			=> 'standard',
						'key' 			=> 'standard',
						'row_limit' 	=> 1,
						'row_min'	 	=> 1,
						'type' 			=> 'repeater',
						'sub_fields' 		=> array(
							'normal' 			=> array(
								'required'			=> 0,
								'name'				=> 'normal',
								'key'				=> 'normal',
								'label'				=> 'Normal',
								'type'				=> 'image',
								'preview_size'		=> 'medium',
								'save_format'		=> 'id',
							),
							'retina' 			=> array(
								'required'			=> 0,
								'name'				=> 'retina',
								'key'				=> 'retina',
								'label'				=> 'Retina <sup>optional</sup>',
								'type'				=> 'image',
								'preview_size'		=> 'medium',
								'save_format'		=> 'id',
							),
						),
					);
					
					$final_options_content_languages = array_merge($options_content_languages_standard, $options_content_languages);
				}
				
				
				$layout = 'table';
				if(sizeof($options_content_languages) > 4) {
					$layout = 'row';
				}
				
				if(sizeof($options_content_languages) > 2 && ($field['options'] == "words" || $field['options'] == "clauses")) {
					$layout = 'row';
				}
				
				if($field['options'] == "texts" || $field['options'] == "galleries" || $field['options'] == "files") {
					$layout = 'row';
				}
				
				$my_fields['sub_fields']['options_content'] = array(
					'required'			=> 0,
					'row_limit'			=> 1,
				    'row_min'			=> 1,
				    'name'				=> 'options_content',
				    'key'				=> 'options_content',
				    'label'				=> 'Inhalte',
				    'type'				=> 'repeater',
				    'column_width'		=> '70',
				    'layout' 			=> $layout,
				    'sub_fields'		=> $final_options_content_languages,
				);
				
				if($field['options'] == "files") {
					$my_fields['sub_fields']['options_content']['instructions'] = '<b>Normal:</b> 300x200 --> bildname.png<br><b>Retina:</b> 600x400 --> bildname@2x.png (optional)';
				}
			}
			
		} else {
			$my_fields['sub_fields']['options_content'] = array(
				'name'				=> 'options_content',
				'key'				=> 'options_content',
				'label'				=> 'Inhalt',
				'default_value'		=> '',
				'instructions'		=> '',
				'column_width'		=> '70',
			);
			
			switch($field['options']) {
				case "numbers":
			    	$my_fields['sub_fields']['options_content']['type'] = 'text';
			    	$my_fields['sub_fields']['options_content']['formatting'] = 'none';
			    	break;
			    	
			    case "colors":
			    	$my_fields['sub_fields']['options_content']['type'] = 'color_picker';
			    	break;
			    	
			    case "words":
			    	$my_fields['sub_fields']['options_content']['type'] = 'text';
			    	$my_fields['sub_fields']['options_content']['formatting'] = 'none';
			    	break;
			    	
			    case "clauses":
			    	$my_fields['sub_fields']['options_content']['type'] = 'textarea';
			    	$my_fields['sub_fields']['options_content']['formatting'] = 'none';
			    	break;
			    	
			    case "admin":
			    	$my_fields['sub_fields']['options_content']['type'] = 'text';
			    	$my_fields['sub_fields']['options_content']['formatting'] = 'none';
			    	break;
			    	
			    case "texts":
			    	$my_fields['sub_fields']['options_content']['type'] = 'wysiwyg';
			    	$my_fields['sub_fields']['options_content']['toolbar'] = 'full';
			    	$my_fields['sub_fields']['options_content']['media_upload'] = 'yes';
			    	$my_fields['sub_fields']['options_content']['the_content'] = 'no';
			    	break;
			    	
			    case "files":
			    	$my_fields['sub_fields']['options_content']['row_limit'] = 1;
					$my_fields['sub_fields']['options_content']['row_min'] = 1;
					$my_fields['sub_fields']['options_content']['type'] = 'repeater';
					$my_fields['sub_fields']['options_content']['sub_fields'] = array(
					    'normal' 			=> array(
					    	'name'				=> 'normal',
					    	'key'				=> 'normal',
					    	'label'				=> 'Normal',
					    	'type'				=> 'image',
					    	'preview_size'		=> 'medium',
					    	'save_format'		=> 'id',
					    ),
					    'retina' 			=> array(
					    	'name'				=> 'retina',
					    	'key'				=> 'retina',
					    	'label'				=> 'Retina <sup>optional</sup>',
					    	'type'				=> 'image',
					    	'preview_size'		=> 'medium',
					    	'save_format'		=> 'id',
					    ),
					);
					break;
					
			    case "galleries":
			    	$my_fields['sub_fields']['options_content']['type'] = 'gallery';
			    	$my_fields['sub_fields']['options_content']['preview_size'] = 'medium';
			    	$my_fields['sub_fields']['options_content']['save_format'] = 'id';
			    	break;
			    	
			    case "status":
			    	$my_fields['sub_fields']['options_content']['type'] = 'checkbox';
			    	$my_fields['sub_fields']['options_content']['choices'] = array('status' => "Aktiviert");
			    	break;
			    
			    case "pages":
					$my_fields['sub_fields']['options_content']['type'] = 'select';
					$my_fields['sub_fields']['options_content']['choices'] = $choices_pages;
					$my_fields['sub_fields']['options_content']['allow_null'] = 1;
					
					break;
			}
				
			
		}
		
		
		return $my_fields;
	}
    
    
    
	
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add css + javascript to assist your create_field() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_enqueue_scripts()
	{
		// register acf scripts
		wp_register_script( 'acf-input-repeater', $this->settings['dir'] . '_repeaters/js/input.js', array('acf-input'), $this->settings['version'] );
		wp_register_style( 'acf-input-repeater', $this->settings['dir'] . '_repeaters/css/input.css', array('acf-input'), $this->settings['version'] ); 
		
		
		// scripts
		wp_enqueue_script(array(
			'acf-input-repeater',	
		));

		// styles
		wp_enqueue_style(array(
			'acf-input-repeater',	
		));
		
	}
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add css + javascript to assist your create_field_options() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function field_group_admin_enqueue_scripts()
	{
		wp_register_script( 'acf-field-group-repeater', $this->settings['dir'] . '_repeaters/js/field-group.js', array('acf-field-group'), $this->settings['version']);
		
		// scripts
		wp_enqueue_script(array(
			'acf-field-group-repeater',	
		));
	}
	
	
	/*
	*  load_field()
	*
	*  This filter is appied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$field - the field array holding all the field options
	*/
	
	function load_field( $field )
	{
		$field = array_merge($field, $this->my_sub_fields($field));
		//debug($field);
		
		// apply_load field to all sub fields
		if( isset($field['sub_fields']) && is_array($field['sub_fields']) )
		{
			foreach( $field['sub_fields'] as $k => $sub_field )
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
				$field['sub_fields'][ $k ] = $sub_field;
			}
		}
		
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
		// vars
		$defaults = array(
			'row_limit'		=>	0,
			'row_min'		=>	0,
			'layout' 		=> 'table',
			'sub_fields'	=>	array(),
			'button_label'	=>	__("Add Row",'acf'),
			'value'			=>	array(),
		);
		
		$field = array_merge($defaults, $field, $this->my_sub_fields($field));
		//$field = array_merge($defaults, $field);
		
		
		// validate types
		$field['row_limit'] = (int) $field['row_limit'];
		$field['row_min'] = (int) $field['row_min'];
		
		
		// value may be false
		if( !is_array($field['value']) )
		{
			$field['value'] = array();
		}
		
		
		// row limit = 0?
		if( $field['row_limit'] < 1 )
		{
			$field['row_limit'] = 999;
		}
		
		

		// min rows
		if( $field['row_min'] > count($field['value']) )
		{
			for( $i = 0; $i < $field['row_min']; $i++ )
			{
				// already have a value? continue...
				if( isset($field['value'][$i]) )
				{
					continue;
				}
				
				// populate values
				$field['value'][$i] = array();
				
				foreach( $field['sub_fields'] as $sub_field)
				{
					$sub_value = isset($sub_field['default_value']) ? $sub_field['default_value'] : false;
					$field['value'][$i][ $sub_field['key'] ] = $sub_value;
				}
				
			}
		}

		
		// max rows
		if( $field['row_limit'] < count($field['value']) )
		{
			for( $i = 0; $i < count($field['value']); $i++ )
			{
				if( $i >= $field['row_limit'] )
				{
					unset( $field['value'][$i] );
				}
			}
		}

		
		// setup values for row clone
		$field['value']['acfcloneindex'] = array();
		foreach( $field['sub_fields'] as $sub_field)
		{
			$sub_value = isset($sub_field['default_value']) ? $sub_field['default_value'] : false;
			$field['value']['acfcloneindex'][ $sub_field['key'] ] = $sub_value;
		}

?>
<div class="repeater" data-min_rows="<?php echo $field['row_min']; ?>" data-max_rows="<?php echo $field['row_limit']; ?>">
	<table class="widefat acf-input-table <?php if( $field['layout'] == 'row' ): ?>row_layout<?php endif; ?>">
	<?php if( $field['layout'] == 'table' ): ?>
		<thead>
			<tr>
				<?php 
				
				// order th
				
				if( $field['row_limit'] > 1 ): ?>
					<th class="order"></th>
				<?php endif; ?>
				
				<?php foreach( $field['sub_fields'] as $sub_field): 
					
					// add width attr
					$attr = "";
					
					if( count($field['sub_fields']) > 1 && isset($sub_field['column_width']) && $sub_field['column_width'] )
					{
						$attr = 'width="' . $sub_field['column_width'] . '%"';
					}
					
					?>
					<th class="acf-th-<?php echo $sub_field['name']; ?>" <?php echo $attr; ?>>
						<span><?php echo $sub_field['label']; ?></span>
						<?php if( isset($sub_field['instructions']) ): ?>
							<span class="sub-field-instructions"><?php echo $sub_field['instructions']; ?></span>
						<?php endif; ?>
					</th><?php
				endforeach; ?>
							
				<?php
				
				// remove th
							
				if( $field['row_min'] < $field['row_limit'] ):  ?>
					<th class="remove"></th>
				<?php endif; ?>
			</tr>
		</thead>
	<?php endif; ?>
	<tbody>
	<?php if( $field['value'] ): foreach( $field['value'] as $i => $value ): ?>
		
		<tr class="<?php echo ( (string) $i == 'acfcloneindex') ? "row-clone" : "row"; ?>">
		
		<?php 
		
		// row number
		
		if( $field['row_limit'] > 1 ): ?>
			<td class="order"><?php echo $i+1; ?></td>
		<?php endif; ?>
		
		<?php
		
		// layout: Row
		
		if( $field['layout'] == 'row' ): ?>
			<td class="acf_input-wrap">
				<table class="widefat acf_input">
		<?php endif; ?>
		
		
		<?php
		
		// loop though sub fields
		
		foreach( $field['sub_fields'] as $sub_field ): ?>
		
			<?php
		
			// layout: Row
			
			if( $field['layout'] == 'row' ): ?>
				<tr>
					<td class="label">
						<label><?php echo $sub_field['label']; ?></label>
						<?php if( isset($sub_field['instructions']) ): ?>
							<span class="sub-field-instructions"><?php echo $sub_field['instructions']; ?></span>
						<?php endif; ?>
					</td>
			<?php endif; ?>
			
			<td>
				<?php
				
				// add value
				$sub_field['value'] = isset($value[$sub_field['key']]) ? $value[$sub_field['key']] : '';
					
				// add name
				$sub_field['name'] = $field['name'] . '[' . $i . '][' . $sub_field['key'] . ']';
				
				// clear ID (needed for sub fields to work!)
				unset( $sub_field['id'] );
				
				// create field
				do_action('acf/create_field', $sub_field);
				
				?>
			</td>
			
			<?php
		
			// layout: Row
			
			if( $field['layout'] == 'row' ): ?>
				</tr>				
			<?php endif; ?>
			
		<?php endforeach; ?>
			
		<?php
		
		// layout: Row
		
		if( $field['layout'] == 'row' ): ?>
				</table>
			</td>
		<?php endif; ?>
		
		<?php 
		
		// delete row
		
		if( $field['row_min'] < $field['row_limit'] ): ?>
			<td class="remove">
				<a class="acf-button-add add-row-before" href="javascript:;"></a>
				<a class="acf-button-remove" href="javascript:;"></a>
			</td>
		<?php endif; ?>
		
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
	</table>
	<?php if( $field['row_min'] < $field['row_limit'] ): ?>

	<ul class="hl clearfix repeater-footer">
		<li class="right">
			<a href="javascript:;" class="add-row-end acf-button"><?php echo $field['button_label']; ?></a>
		</li>
	</ul>

	<?php endif; ?>	
</div>
		<?php
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
		// vars
		$defaults = array(
			'row_limit'		=>	'',
			'row_min'		=>	0,
			'layout' 		=> 'table',
			'sub_fields'	=>	array(),
			'button_label'	=>	__("Add Row",'acf'),
			'value'			=>	array(),
			'variables'		=> 'variables',
			'options'		=> '',
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
		
		
		// validate types
		$field['row_min'] = (int) $field['row_min'];
		
		
		// add clone
		$field['sub_fields'][] = apply_filters('acf/load_field_defaults',  array(
			'key' => 'field_clone',
			'label' => __("New Field",'acf'),
			'name' => __("new_field",'acf'),
			'type' => 'text',
		));
		
		
		// get name of all fields for use in field type drop down
		$fields_names = apply_filters('acf/registered_fields', array());
		unset( $fields_names['tab'] );
		
		?>
		
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Options",'acf'); ?></label>
			</td>
			<td>
				<?php 
				do_action('acf/create_field', array(
					'type'	=>	'radio',
					'name'	=>	'fields['.$key.'][options]',
					'value'	=>	$field['options'],
					'choices'	=>	array(
						'admin'		=>	__("Admin (Name: options_admin)",'acf'),
						'words'		=>	__("W&ouml;rter/Wortgruppen (Name: options_words)",'acf'),
						'clauses'	=>	__("Kurztexte (Name: options_clauses)",'acf'),
						'texts'		=>	__("Formatierte Texte (Name: options_texts)",'acf'),
						'numbers'	=>	__("Werte (Name: options_numbers)",'acf'),
						'files'		=>	__("Dateien/Bilder (Name: options_files)",'acf'),
						'colors'	=>	__("Farben (Name: options_colors)",'acf'),
						'galleries'	=>	__("Bildergalerien (Name: options_galleries)",'acf'),
						'status'	=>	__("On/Off (Name: options_status)",'acf'),
						'pages'		=>	__("Seiten (Name: options_pages)",'acf'),
					),
				));
				?>
			</td>
		</tr>
		
		<?php		
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
		
		$total = 0;
		
		if( $value )
		{
			// remove dummy field
			unset( $value['acfcloneindex'] );
			
			$i = -1;
			
			// loop through rows
			foreach( $value as $row )
			{	
				$i++;
				
				// increase total
				$total++;
					
				// loop through sub fields
				foreach( $field['sub_fields'] as $sub_field )
				{
					// get sub field data
					$v = isset( $row[$sub_field['key']] ) ? $row[$sub_field['key']] : false;
					
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
		
		
		$old_total = (int) apply_filters('acf/load_value', 0, $post_id, $field);
		
		if( $old_total > $total )
		{
			for ( $j = $total; $j < $old_total; $j++ )
			{
				foreach( $field['sub_fields'] as $sub_field )
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
		$field = array_merge($field, $this->my_sub_fields($field));
		
		// format sub_fields
		if( $field['sub_fields'] )
		{
			// remove dummy field
			unset( $field['sub_fields']['field_clone'] );
			
			
			// loop through and save fields
			$i = -1;
			$sub_fields = array();
			
			
			foreach( $field['sub_fields'] as $key => $f )
			{
				$i++;
				
				
				// order
				$f['order_no'] = $i;
				$f['key'] = $key;
				
				
				// save
				$f = apply_filters('acf/update_field/type=' . $f['type'], $f, $post_id ); // new filter
				
				
				// add
				$sub_fields[] = $f;
			}
			
			
			// update sub fields
			$field['sub_fields'] = $sub_fields;
			
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
		
		
		// vars
		$values = array();


		if( $value > 0 )
		{
			// loop through rows
			for($i = 0; $i < $value; $i++)
			{
				// loop through sub fields
				foreach( $field['sub_fields'] as $sub_field )
				{
					// update full name
					$key = $sub_field['key'];
					$sub_field['name'] = $field['name'] . '_' . $i . '_' . $sub_field['name'];
					
					$v = apply_filters('acf/load_value', false, $post_id, $sub_field);
					$v = apply_filters('acf/format_value', $v, $post_id, $sub_field);
					
					$values[ $i ][ $key ] = $v;
					
				}
			}
		}
		
		
		// return
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
		
		// vars
		$values = array();
		
		
		if( $value > 0 )
		{
			// loop through rows
			for($i = 0; $i < $value; $i++)
			{
				// loop through sub fields
				foreach( $field['sub_fields'] as $sub_field )
				{
					// update full name
					$key = $sub_field['name'];
					$sub_field['name'] = $field['name'] . '_' . $i . '_' . $sub_field['name'];
					
					$v = apply_filters('acf/load_value', false, $post_id, $sub_field);
					$v = apply_filters('acf/format_value_for_api', $v, $post_id, $sub_field);
					
					$values[ $i ][ $key ] = $v;
					
				}
			}
		}
		
		
		// return
		return $values;
	}
}


// create field
new acf_field_individole_options_standards();

?>