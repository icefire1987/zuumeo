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

class acf_field_individole_flexible_fields extends acf_field
{
	
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
		$this->name = 'individole_flexible_fields';
		$this->label = __('Individole - Flexible Fields');
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
		//debug($field);
		
		
		if(isPolylang()) {
			global $polylang;
		}
		
		
		
		$conditional_logic = array(
			'status'			=> 0,
			'rules'				=> array(
				'field'				=> null,
				'operator'			=> '==',
				'value'				=> '',
			),
		);
		
		
		$c = array(
			'inactive'			=> array(
		        'label'				=> 'Deaktivieren (nur eingeloggt sichtbar)',
		        'name'				=> 'inactive',
		        'key'				=> 'inactive',
		        'type'				=> 'true_false',
		        'default_value'		=> false,
		        
		    ),
		    'view' 				=> array(
				'label'				=> 'Darstellung',
				'name'				=> 'view',
				'key'				=> 'view',
				'type'				=> 'select',
				'choices'			=> array(
					'full'				=> 'Volle Breite',
					'inner'				=> 'nur Innen',
					'full_inner'		=> 'Volle Breite, Inhalt innen',
				),
				'default_value'		=> 'full',
			),
			'top'				=> array(
				'label'				=> 'Abstand oben',
				'name'				=> 'top',
				'key'				=> 'top',
				'type'				=> 'select',
				'default_value'		=> 'empty',
				'choices'			=> $individole['choices_gap'],
			),
			'bottom'			=> array(
				'label'				=> 'Abstand unten',
				'name'				=> 'bottom',
				'key'				=> 'bottom',
				'type'				=> 'select',
				'default_value'		=> 'empty',
				'choices'			=> $individole['choices_gap'],
			),
			'left'				=> array(
				'label'				=> 'Abstand links',
				'name'				=> 'left',
				'key'				=> 'left',
				'type'				=> 'select',
				'default_value'		=> 0,
				'choices'			=> $individole['choices_gap'],
			),
			'right'				=> array(
				'label'				=> 'Abstand rechts',
				'name'				=> 'right',
				'key'				=> 'right',
				'type'				=> 'select',
				'default_value'		=> 0,
				'choices'			=> $individole['choices_gap'],
			),
			'column_gap'		=> array(
				'label'				=> 'Abstand Spalten',
				'name'				=> 'column_gap',
				'key'				=> 'column_gap',
				'type'				=> 'select',
				'default_value'		=> 'default',
				'choices'			=> $individole['choices_gap_columns'],
			),
			'grid'				=> array(
				'label'				=> 'Spaltenraster',
				'name'				=> 'grid',
				'key'				=> 'grid',
				'type'				=> 'select',
				'default_value'		=> 'default',
				'choices'			=> $individole['choices_grid'],
			),
			'post_type'			=> array(
				'label'				=> 'Post Type',
				'name'				=> 'post_type',
				'key'				=> 'post_type',
				'type'				=> 'select',
				'default_value'		=> '',
				'choices'			=> $individole['choices_post_types'],
			),
			'background'		=> array(
				'label'				=> 'Background',
				'name'				=> 'background',
				'key'				=> 'background',
				'type'				=> 'select',
				'default_value'		=> 'none',
				'choices'			=> $individole['module_background'],
			),
			'columns'		=> array(
				'label'				=> '# Spalten',
				'name'				=> 'columns',
				'key'				=> 'columns',
				'type'				=> 'select',
				'default_value'		=> 12,
				'choices'			=> $individole['module_columns'],
			),
		);
		
		$labels = array(
			'columns'		=> 'A) mehrere Inhalte nebeneinander',
			'headline'		=> 'B1) &Uuml;berschrift',
			'text'			=> 'B2) Text',
			'image'			=> 'B3) Einzelbild',
			'image_list'	=> 'B4) mehrere (verlinkbare) Bilder',
			'content_list'	=> 'B5) Linkliste',
			'gallery'		=> 'B6) Bildergalerie',
			'downloads'		=> 'B7) Downloads',
			'line'			=> 'B8) Trennlinie',
			'video'			=> 'B9) Video/Videoshowreel',
			'shortcode'		=> 'B10) Shortcode',
			'empty'			=> 'B11) Leere Spalte',
			'tables'		=> 'C) SPECIAL / Tabelle',
			'formulare'		=> 'C) SPECIAL / Formular',
			'showreel'		=> 'C) SPECIAL / Zuumeo Showreel',
			'360grad'		=> 'C) SPECIAL / Zuumeo 360 Grad',
		);
		
		
		foreach($labels AS $label_key => $label_headline) {
			${'config_base_'.$label_key} = array(
				'label'				=> 'Modul-<br>einstellungen',
				'name'				=> 'config_base_'.$label_key,
				'key'				=> 'config_base_'.$label_key,
				'type'				=> 'repeater',
				'layout'			=> 'row',
				'row_limit' 		=> 1,
				'row_min' 			=> 1,
				'sub_fields'		=> array($c['inactive'], $c['top'], $c['bottom'], $c['columns'], $c['background']),
			);
		}
		
		
		//! COLUMNS
		array_push($config_base_columns['sub_fields'], $c['column_gap'], $c['grid']);
		
		
		//! TEXT
		//array_push($config_base_text['sub_fields'], $c['view'], $c['top'], $c['bottom']);
		
		
		//!HEADLINE
		//array_push($config_base_headline['sub_fields'], $c['view'], $c['top'], $c['bottom']);
		
		
		//!IMAGE
		//array_push($config_base_image['sub_fields'], $c['view'], $c['top'], $c['bottom']);
		
		
		
		//!IMAGE LIST
		//array_push($config_base_image_list['sub_fields'], $c['view'], $c['top'], $c['bottom']);
		
		
		//!CONTENT LIST
		array_push($config_base_content_list['sub_fields'], $c['post_type']);
		
		
		//!GALLERY
		//array_push($config_base_gallery['sub_fields'], $c['view'], $c['top'], $c['bottom']);
		
		
		//!LINE
		//array_push($config_base_line['sub_fields'], $c['view'], $c['top'], $c['bottom']);
		
		
		//!VIDEO
		//array_push($config_base_video['sub_fields'], $c['view'], $c['top'], $c['bottom']);
		
		
		//!SHORTCODE
		//array_push($config_base_shortcode['sub_fields']);
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		foreach($labels AS $label_key => $label_value) {
			//if(isset(${'m_2_'.$label_key})) {
			//	unset(${'m_2_'.$label_key}['sub_fields']['config_base']['sub_fields'][0]);
			//}
		}
		
		$my_fields = array(
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'display' 			=> 'row',
			'label'				=> 'Inhalte',
			'button_label'		=> '+ Seiteninhalt hinzuf&uuml;gen',
			'type'				=> 'individole_flexible_fields',
			'layouts'			=> array(
				'm_columns'			=> array(
					'label'				=> 'A) mehrere Spalten nebeneinander',
					'button_label'		=> '+ Spalte hinzuf&uuml;gen',
					'type'				=> 'repeater',
					'name'				=> 'm_columns',
					'key'				=> 'm_columns',
					'display'			=> 'row',
					'sub_fields'		=> array(
						'config_base_columns'	=> $config_base_columns,
						'm_columns_content'	=> array(
							'label'				=> $labels['columns'],
							'button_label'		=> '+ Spalte hinzuf&uuml;gen (maximal 4!)',
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
			    						'm_flex_content'	=> array(
			    							'label'				=> '...',
			    							'button_label'		=> '+ Spalteninhalt hinzuf&uuml;gen',
			    							'type'				=> 'flexible_content',
			    							'name'				=> 'm_flex_content',
			    							'key'				=> 'm_flex_content',
			    							'layouts'			=> array(
												'm_headline'		=> $m_2_headline,
												'm_text'			=> $m_2_text,
												'm_image'			=> $m_2_image,
												'm_image_list'		=> $m_2_image_list,
												'm_gallery'			=> $m_2_gallery,
												'm_downloads'		=> $m_2_downloads,
												'm_content_list'	=> $m_2_content_list,
												'm_line'			=> $m_2_line,
												'm_video'			=> $m_2_video,
												'm_shortcode'		=> $m_2_shortcode,
												'm_formulare'		=> $m_2_formulare,
			    							),
			    						),
			    					),
			    				),
			    				'm_headline'		=> $m_2_headline,
								'm_text'			=> $m_2_text,
								'm_image'			=> $m_2_image,
								'm_image_list'		=> $m_2_image_list,
								'm_gallery'			=> $m_2_gallery,
								'm_downloads'		=> $m_2_downloads,
								'm_content_list'	=> $m_2_content_list,
								'm_line'			=> $m_2_line,
								'm_video'			=> $m_2_video,
								'm_shortcode'		=> $m_2_shortcode,
								'm_empty'			=> $m_2_empty,
								'm_formulare'		=> $m_2_formulare,
								'm_showreel'		=> $m_2_showreel,
								'm_360grad'			=> $m_2_360grad,
							),
						),
					),
				),
				
				'm_headline'		=> $m_headline,
				'm_text'			=> $m_text,
				'm_image'			=> $m_image,
				'm_image_list'		=> $m_image_list,
				'm_gallery'			=> $m_gallery,
				'm_downloads'		=> $m_downloads,
				'm_content_list'	=> $m_content_list,
				'm_line'			=> $m_line,
				'm_video'			=> $m_video,
				'm_shortcode'		=> $m_shortcode,
				'm_formulare'		=> $m_formulare,
				'm_showreel'		=> $m_showreel,
				'm_360grad'			=> $m_360grad,
			),
		);
		
		
		//debug($my_fields);
		
		return $my_fields;
	}
	
	
	
	
	/*
	*  load_value()
	*
	*  This filter is appied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value found in the database
	*  @param	$post_id - the $post_id from which the value was loaded from
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the value to be saved in te database
	*/
	
	function load_value( $value, $post_id, $field )
	{
		$field = array_merge($field, $this->my_sub_fields($field));
		
		return $value;
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
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed to the create_field action
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
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
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - an array holding all the field's data
	*/
	
	
	function create_field( $field )
	{
		$button_label = ( isset($field['button_label']) && $field['button_label'] != "" ) ? $field['button_label'] : __("+ Add Row",'acf');
		$layouts = array();
		foreach($field['layouts'] as $l)
		{
			$layouts[$l['name']] = $l;
		}
		
		?>
		<div class="acf_flexible_content">
			
			<div class="no_value_message" <?php if($field['value']){echo 'style="display:none;"';} ?>>
				<?php _e("Click the \"$button_label\" button below to start creating your layout",'acf'); ?>
			</div>
			
			<div class="clones">
			<?php $i = -1; ?>
			<?php foreach($layouts as $layout): $i++; ?>
			
				<div class="layout" data-layout="<?php echo $layout['name']; ?>">
					
					<input type="hidden" name="<?php echo $field['name']; ?>[acfcloneindex][acf_fc_layout]" value="<?php echo $layout['name']; ?>" />
					
					<a class="ir fc-delete-layout" href="#"></a>
					<p class="menu-item-handle"><span class="fc-layout-order"><?php echo $i+1; ?></span>. <?php echo $layout['label']; ?></p>
					
					<table class="widefat acf-input-table <?php if( $layout['display'] == 'row' ): ?>row_layout<?php endif; ?>">
						<?php if( $layout['display'] == 'table' ): ?>
							<thead>
								<tr>
									<?php foreach( $layout['sub_fields'] as $sub_field_i => $sub_field): 
										
										// add width attr
										$attr = "";
										
										if( count($layout['sub_fields']) > 1 && isset($sub_field['column_width']) && $sub_field['column_width'] )
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
								</tr>
							</thead>
						<?php endif; ?>
						<tbody>
							<tr>
							<?php
		
							// layout: Row
							
							if( $layout['display'] == 'row' ): ?>
								<td class="acf_input-wrap">
									<table class="widefat acf_input">
							<?php endif; ?>
							
							
							<?php
		
							// loop though sub fields
							
							foreach( $layout['sub_fields'] as $j => $sub_field ): ?>
							
								<?php
							
								// layout: Row
								
								if( $layout['display'] == 'row' ): ?>
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
									$sub_field['value'] = isset($sub_field['default_value']) ? $sub_field['default_value'] : false;
									
									// add name
									$sub_field['name'] = $field['name'] . '[acfcloneindex][' . $sub_field['key'] . ']';
									
									// clear ID (needed for sub fields to work!)
									unset( $sub_field['id'] );
				
									// create field
									do_action('acf/create_field', $sub_field);
									
									?>
								</td>
								
								<?php
							
								// layout: Row
								
								if( $layout['display'] == 'row' ): ?>
									</tr>
								<?php endif; ?>
								
							
							<?php endforeach; ?>
							
							<?php
	
							// layout: Row
							
							if( $layout['display'] == 'row' ): ?>
									</table>
								</td>
							<?php endif; ?>
															
							</tr>
						</tbody>
						
					</table>
				</div>
			<?php endforeach; ?>
			</div>
			<div class="values">
				<?php 
				
				if($field['value']):
					
					foreach($field['value'] as $i => $value):
						
						// validate layout
						if( !isset($layouts[$value['acf_fc_layout']]) )
						{
							continue;
						}
						
						
						// vars
						$layout = $layouts[$value['acf_fc_layout']]; 
						
						
						?>
						<div class="layout" data-layout="<?php echo $layout['name']; ?>">
							
							<input type="hidden" name="<?php echo $field['name'] ?>[<?php echo $i ?>][acf_fc_layout]" value="<?php echo $layout['name']; ?>" />
							
							<a class="ir fc-delete-layout" href="#"></a>
							<p class="menu-item-handle"><span class="fc-layout-order"><?php echo $i+1; ?></span>. <?php echo $layout['label']; ?></p>
							
							
							<table class="widefat acf-input-table <?php if( $layout['display'] == 'row' ): ?>row_layout<?php endif; ?>">
							<?php if( $layout['display'] == 'table' ): ?>
								<thead>
									<tr>
										<?php foreach( $layout['sub_fields'] as $sub_field_i => $sub_field): 
											
											// add width attr
											$attr = "";
											
											if( count($layout['sub_fields']) > 1 && isset($sub_field['column_width']) && $sub_field['column_width'] )
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
									</tr>
								</thead>
							<?php endif; ?>
							<tbody>
								<tr>
								<?php
			
								// layout: Row
								
								if( $layout['display'] == 'row' ): ?>
									<td class="acf_input-wrap">
										<table class="widefat acf_input">
								<?php endif; ?>
								
								
								<?php
			
								// loop though sub fields
								
								foreach( $layout['sub_fields'] as $j => $sub_field ): ?>
								
									<?php
								
									// layout: Row
									
									if( $layout['display'] == 'row' ): ?>
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
										$sub_field['value'] = isset($value[$sub_field['key']]) ? $value[$sub_field['key']] : false;
										
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
									
									if( $layout['display'] == 'row' ): ?>
										</tr>
									<?php endif; ?>
									
								
								<?php endforeach; ?>
								
								<?php
		
								// layout: Row
								
								if( $layout['display'] == 'row' ): ?>
										</table>
									</td>
								<?php endif; ?>
																
								</tr>
							</tbody>
							
						</table>
						</div>
					<?php
					
					endforeach; 
					// foreach($field['value'] as $i => $value)
					
				endif; 
				// if($field['value']): 
				
				?>
			</div>

			<ul class="hl clearfix flexible-footer">
				<li class="right">
					<a href="javascript:;" class="add-row-end acf-button"><?php echo $button_label; ?></a>
					<div class="acf-popup">
						<ul>
							<?php foreach($field['layouts'] as $layout): $i++; ?>
							<li><a href="javascript:;" data-layout="<?php echo $layout['name']; ?>"><?php echo $layout['label']; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<div class="bit"></div>
					</div>
				</li>
			</ul>

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
			'layouts' 		=> array(),
			'button_label'	=>	__("Add Row",'acf'),
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
		
		
		// load default layout
		if(empty($field['layouts']))
		{
			$field['layouts'][] = array(
				'name' => '',
				'label' => '',
				'display' => 'row',
				'sub_fields' => array(),
			);
		}
		
		
		// get name of all fields for use in field type drop down
		$fields_names = apply_filters('acf/registered_fields', array());
		unset( $fields_names['flexible_content'], $fields_names['tab'] );
		
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
		wp_register_script( 'acf-input-flexible-content', $this->settings['dir'] . '_flexible/js/input.js', array('acf-input'), $this->settings['version']);
		wp_register_style( 'acf-input-flexible-content', $this->settings['dir'] . '_flexible/css/input.css', array('acf-input'), $this->settings['version'] ); 
		
		
		// scripts
		wp_enqueue_script(array(
			'acf-input-flexible-content',	
		));

		// styles
		wp_enqueue_style(array(
			'acf-input-flexible-content',	
		));
		
	}

	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add css and javascript to assist your create_field() action.
	*
	*  @info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_head()
	{

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
		wp_register_script( 'acf-field-group-flexible-content', $this->settings['dir'] . '_flexible/js/field-group.js', array('acf-field-group'), $this->settings['version']);
		wp_register_style( 'acf-field-group-flexible-content', $this->settings['dir'] . '_flexible/css/field-group.css', array('acf-field-group'), $this->settings['version'] ); 
		
		// scripts
		wp_enqueue_script(array(
			'acf-field-group-flexible-content',	
		));
		
		// styles
		wp_enqueue_style(array(
			'acf-field-group-flexible-content',	
		));
	}

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add css and javascript to assist your create_field_options() action.
	*
	*  @info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function field_group_admin_head()
	{
?>
<script type="text/javascript">acf.text.flexible_content_no_fields = "<?php _e('Flexible Content requires at least 1 layout','acf'); ?>";</script>
<?php
	}
}


// create field
new acf_field_individole_flexible_fields();


?>