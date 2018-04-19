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

class acf_field_individole_repeaters extends acf_field
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
		$this->name = 'individole_repeaters';
		$this->label = __('Individole - Repeater');
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
		$my_fields = array();
		
		$current_post_language = 'de';
		if(isPolylang()) {
			global $polylang;
			
			if(isset($_GET['post'])) {
				$current_post_language = @$polylang->model->get_post_language($_GET['post'])->slug;	
			}
		}
		
		//debug($field);
		
		$conditional_logic = array(
		  'status'			=> 0,
		  'rules'				=> array(
		  	'field'				=> null,
		  	'operator'			=> '==',
		  	'value'				=> '',
		  ),
		);
		
		$option = $field['options'];
		
		//debug($option);
		//debug($pages);
		
		
		$my_fields['meta'] = array(
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'layout' 			=> 'row',
			'type'				=> 'individole_repeaters',
			'sub_fields' 		=> array(
				'meta_title' 		=> array(
					'name'				=> 'meta_title',
					'key'				=> 'meta_title',
					'label'				=> 'Title',
					'type'				=> 'text',
					'formatting'		=> 'none',
					'default_value'		=> '',
					'instructions'		=> '',
				),
				
				'meta_description' 	=> array(
					'name'				=> 'meta_description',
					'key'				=> 'meta_description',
					'label'				=> 'Description',
					'type'				=> 'textarea',
					'formatting'		=> 'none',
					'default_value'		=> '',
					'instructions'		=> '',
				),
				
				'meta_keywords' 	=> array(
					'name'				=> 'meta_keywords',
					'key'				=> 'meta_keywords',
					'label'				=> 'Keywords',
					'type'				=> 'textarea',
					'formatting'		=> 'none',
					'default_value'		=> '',
					'instructions'		=> '',
				),
				
				'noindex' 			=> array(
					'name'				=> 'noindex',
					'key'				=> 'noindex',
					'label'				=> 'Nicht indexieren',
					'type'				=> 'true_false',
					'default_value'		=> '',
					'instructions'		=> '',
				),
				
				'sitemap' 			=> array(
					'name'				=> 'sitemap',
					'key'				=> 'sitemap',
					'label'				=> 'Sitemap Prio',
					'type'				=> 'select',
					'choices'			=> $individole['choices_sitemap'],
					'default_value'		=> '1.0',
					'instructions'		=> '',
				),
				
				'changefreq' 		=> array(
					'name'				=> 'changefreq',
					'key'				=> 'changefreq',
					'label'				=> 'Aktualisierung',
					'type'				=> 'select',
					'choices'			=> $individole['choices_changefreq'],
					'default_value'		=> 'weekly',
					'instructions'		=> '',
				),
			),
		);
		
		
		$my_fields['attachment'] = array(
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'layout' 			=> 'row',
			'type'				=> 'individole_repeaters',
			'sub_fields' 		=> array(
				'attachment_slideshow_title' 		=> array(
					'name'				=> 'attachment_title',
					'key'				=> 'attachment_title',
					'label'				=> 'Title',
					'type'				=> 'text',
					'formatting'		=> 'none',
					'default_value'		=> '',
					'instructions'		=> '',
				),
				
				'attachment_slideshow_subtitle' 		=> array(
					'name'				=> 'attachment_subtitle',
					'key'				=> 'attachment_subtitle',
					'label'				=> 'Subtitle',
					'type'				=> 'text',
					'formatting'		=> 'none',
					'default_value'		=> '',
					'instructions'		=> '',
				),
				
				'attachment_slideshow_text' 		=> array(
					'name'				=> 'attachment_text',
					'key'				=> 'attachment_text',
					'label'				=> 'Text',
					'type'				=> 'wysiwyg',
				    'media_upload' 		=> 'no',
					'formatting'		=> 'none',
					'default_value'		=> '',
					'instructions'		=> '',
				),
			),
		);
		
		
		$my_fields['page'] = array(
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'layout' 			=> 'row',
			'type'				=> 'individole_repeaters',
			'sub_fields' 		=> array(
				'page_header' 		=> array(
					'name'				=> 'page_header',
					'key'				=> 'page_header',
					'label'				=> 'Header',
					'type'				=> 'select',
					'choices'			=> array(
						'default'			=> 'Standard (Slideshow)',
						'small'				=> 'Schmaler Streifen',
					),
					'default_value'		=> 'default',
				),
			),
		);
		
		
		
		$my_fields['formulare'] = array(
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'button_label'		=> '',
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'display'			=> 'row',
			'layout'			=> 'row',
			'type'				=> 'individole_repeaters',
			'conditional_logic'	=> 0,
			'sub_fields'		=> array(
				'formulare_einstellungen' 	=> array(
				    'label'				=> 'Einstellungen',
				    'name'				=> 'formulare_einstellungen',
				    'key'				=> 'formulare_einstellungen',
				    'type'				=> 'repeater',
				    'row_limit' 		=> 1,
				    'row_min' 			=> 1,
				    'layout'			=> 'row',
				    'sub_fields'		=> array(
				    	'title_submit' 		=> array(
				    		'label'				=> 'Button: Senden',
				    		'name'				=> 'title_submit',
				    		'key'				=> 'title_submit',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'title_submit_pending'=> array(
				    		'label'				=> 'Button: wird gesendet',
				    		'name'				=> 'title_submit_pending',
				    		'key'				=> 'title_submit_pending',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'title_submit_done' => array(
				    		'label'				=> 'Button: ist gesendet',
				    		'name'				=> 'title_submit_done',
				    		'key'				=> 'title_submit_done',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'submit_position' => array(
				    		'label'				=> 'Button Gr&ouml;&szlig;e + Position',
				    		'name'				=> 'submit_position',
				    		'key'				=> 'submit_position',
				    		'type'				=> 'select',
				    		'choices'			=> $individole['choices_form_submit_position'],
				    		'default_value'		=> 'left',
				    	),
				    	'subject' 			=> array(
				    		'label'				=> 'Betreff',
				    		'name'				=> 'subject',
				    		'key'				=> 'subject',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'sender_name' 		=> array(
				    		'label'				=> 'Absender: Name',
				    		'name'				=> 'sender_name',
				    		'key'				=> 'sender_name',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'sender_mail' 		=> array(
				    		'label'				=> 'Absender: E-Mail',
				    		'name'				=> 'sender_mail',
				    		'key'				=> 'sender_mail',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'w' 				=> array(
				    		'label'				=> 'Formular / Breite',
				    		'name'				=> 'w',
				    		'key'				=> 'w',
				    		'type'				=> 'number',
				    		'default_value'		=> 0,
				    	),
				    	'mailtext_start' 	=> array(
				    		'label'				=> 'E-Mail-Text am Anfang',
				    		'name'				=> 'mailtext_start',
				    		'key'				=> 'mailtext_start',
				    		'type'				=> 'textarea',
				    		'formatting'		=> 'none',
				    	),
				    	'mailtext_end' 		=> array(
				    		'label'				=> 'E-Mail-Text am Ende',
				    		'name'				=> 'mailtext_end',
				    		'key'				=> 'mailtext_end',
				    		'type'				=> 'textarea',
				    		'formatting'		=> 'none',
				    	),
				    	'infotext_right_w' 	=> array(
				    		'label'				=> 'Text neben dem Formular / Breite',
				    		'name'				=> 'infotext_right_w',
				    		'key'				=> 'infotext_right_w',
				    		'type'				=> 'number',
				    		'default_value'		=> 0,
				    	),
				    	'infotext_right_top' 	=> array(
				    		'label'				=> 'Text neben dem Formular / Abstand oben',
				    		'name'				=> 'infotext_right_top',
				    		'key'				=> 'infotext_right_top',
				    		'type'				=> 'number',
				    		'default_value'		=> 0,
				    	),
				    	'infotext_right' 		=> array(
				    		'label'				=> 'Text neben dem Formular',
				    		'name'				=> 'infotext_right',
				    		'key'				=> 'infotext_right',
				    		'type'				=> 'wysiwyg',
				    		'media_upload' 		=> 'no',
				    	),
				    	'infotext_bottom' 		=> array(
				    		'label'				=> 'Text unter dem Formular',
				    		'name'				=> 'infotext_bottom',
				    		'key'				=> 'infotext_bottom',
				    		'type'				=> 'textarea',
				    		'formatting'		=> 'none',
				    	),
				    ),
				),
				
				'formulare_eingabefelder' 	=> array(
				    'label'				=> 'Eingabefelder',
				    'name'				=> 'formulare_eingabefelder',
				    'key'				=> 'formulare_eingabefelder',
				    'type'				=> 'repeater',
				    'row_limit' 		=> 0,
				    'row_min' 			=> 0,
				    'layout'			=> 'table',
				    'sub_fields'		=> array(
				    	'pflichtfeld' 		=> array(
				    		'label'				=> 'Pflicht-<br>feld',
				    		'name'				=> 'pflichtfeld',
				    		'key'				=> 'pflichtfeld',
				    		'type'				=> 'true_false',
				    	),
				    	'show_in_mail' 			=> array(
				    		'label'				=> 'In E-Mail anzeigen',
				    		'name'				=> 'show_in_mail',
				    		'key'				=> 'show_in_mail',
				    		'type'				=> 'true_false',
				    	),
				    	'title' 			=> array(
				    		'label'				=> 'Beschriftung Formular',
				    		'name'				=> 'title',
				    		'key'				=> 'title',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'alt_title' 		=> array(
				    		'label'				=> 'Altern. Beschriftung in E-Mail',
				    		'name'				=> 'alt_title',
				    		'key'				=> 'alt_title',
				    		'type'				=> 'text',
				    		'formatting'		=> 'none',
				    	),
				    	'typ' 				=> array(
				    		'label'				=> 'Feldtyp',
				    		'name'				=> 'typ',
				    		'key'				=> 'typ',
				    		'type'				=> 'select',
				    		'default_value'		=> 'input',
				    		'column_width'		=> 15,
				    		'choices'			=> array(
				    			'input'				=> 'Einzeilige Texteingabe',
				    			'text'				=> 'Mehrzeilige Texteingabe',
				    			'email'				=> 'E-Mail Feld',
				    			'subject'			=> 'Betreffzeile',
				    			'receiver_name'		=> 'Empf&auml;nger Name',
				    			'receiver_mail'		=> 'Empf&auml;nger E-Mail',
				    			'sender_name'		=> 'Absender Name',
				    			'sender_mail'		=> 'Absender E-Mail',
				    			'dropdown'			=> 'Auswahlmen&uuml;',
				    			'true_false'		=> 'Checkbox',
				    			'copy'				=> 'Checkbox "Kopie an mich"',
				    		),
				    	),
				    	'config' 			=> array(
				    		'label'				=> 'Special',
				    		'name'				=> 'config',
				    		'key'				=> 'config',
				    		'type'				=> 'textarea',
				    		'formatting'		=> 'none',
				    		'column_width'		=> 30,
				    	),
				    ),
				),
				
				'formulare_receiver' => array(
				    'label'				=> 'Empf&auml;nger',
				    'name'				=> 'formulare_receiver',
				    'key'				=> 'formulare_receiver',
				    'type'				=> 'repeater',
				    'row_limit' 		=> 1,
				    'row_min' 			=> 1,
				    'layout'			=> 'row',
				    'sub_fields'		=> array(
				    	'standard' 			=> array(
				    		'label'				=> 'Hauptempf&auml;nger',
				    		'name'				=> 'standard',
				    		'key'				=> 'standard',
				    		'type'				=> 'repeater',
				    		'row_limit' 		=> 1,
				    		'row_min' 			=> 1,
				    		'sub_fields'		=> array(
				    			'name' 				=> array(
				    				'label'				=> 'Name',
				    				'name'				=> 'name',
				    				'key'				=> 'name',
				    				'type'				=> 'text',
				    				'formatting'		=> 'none',
				    			),
				    			'mail' 				=> array(
				    				'label'				=> 'E-Mail',
				    				'name'				=> 'mail',
				    				'key'				=> 'mail',
				    				'type'				=> 'text',
				    				'formatting'		=> 'none',
				    			),
				    		),
				    	),
				    	'cc' 				=> array(
				    		'label'				=> 'CC',
				    		'name'				=> 'cc',
				    		'key'				=> 'cc',
				    		'type'				=> 'repeater',
				    		'row_limit' 		=> 0,
				    		'row_min' 			=> 0,
				    		'sub_fields'		=> array(
				    			'name' 				=> array(
				    				'label'				=> 'Name',
				    				'name'				=> 'name',
				    				'key'				=> 'name',
				    				'type'				=> 'text',
				    				'formatting'		=> 'none',
				    			),
				    			'mail' 				=> array(
				    				'label'				=> 'E-Mail',
				    				'name'				=> 'mail',
				    				'key'				=> 'mail',
				    				'type'				=> 'text',
				    				'formatting'		=> 'none',
				    			),
				    		),
				    	),
				    	'bcc' 				=> array(
				    		'label'				=> 'BCC',
				    		'name'				=> 'bcc',
				    		'key'				=> 'bcc',
				    		'type'				=> 'repeater',
				    		'row_limit' 		=> 0,
				    		'row_min' 			=> 0,
				    		'sub_fields'		=> array(
				    			'name' 				=> array(
				    				'label'				=> 'Name',
				    				'name'				=> 'name',
				    				'key'				=> 'name',
				    				'type'				=> 'text',
				    				'formatting'		=> 'none',
				    			),
				    			'mail' 				=> array(
				    				'label'				=> 'E-Mail',
				    				'name'				=> 'mail',
				    				'key'				=> 'mail',
				    				'type'				=> 'text',
				    				'formatting'		=> 'none',
				    			),
				    		),
				    	),
				    ),
				),
			),
		);
		
		
		$my_fields['videos'] = array(
			'row_limit' 		=> 1,
			'row_min' 			=> 1,
			'button_label'		=> '',
			'key'				=> $field['key'],
			'name'				=> $field['name'],
			'display'			=> 'row',
			'layout'			=> 'row',
			'type'				=> 'individole_repeaters',
			'conditional_logic'	=> 0,
			'sub_fields'		=> array(
				'video_configs'	=> array(
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'label'				=> 'Videoplayer<br>Einstellungen',
					'name'				=> 'video_configs',
					'key'				=> 'video_configs',
					'type'				=> 'repeater',
					'layout' 			=> 'row',
					'sub_fields'		=> array(
						'title'		 		=> array(
							'label'				=> 'Titel',
							'name'				=> 'title',
							'key'				=> 'title',
							'type'				=> 'text',
							'formatting'		=> 'none',
							'instructions'		=> 'nicht sichtbar',
						),
						'image' 			=> array(
							'label'				=> 'Vorschau',
							'name'				=> 'image',
							'key'				=> 'image',
							'type'				=> 'image',
							'preview_size'		=> 'medium',
							'save_format'		=> 'id',
						),
						'background'		=> array(
							'label'				=> 'Hintergrundfarbe',
							'name'				=> 'background',
							'key'				=> 'background',
							'type'				=> 'color_picker',
						),
						'text'		 		=> array(
							'label'				=> 'Beschriftung',
							'name'				=> 'text',
							'key'				=> 'text',
							'type'				=> 'textarea',
							'formatting'		=> 'none',
						),
					),
				),
				
				'video'			=> array(
					'row_limit' 		=> 1,
					'row_min' 			=> 1,
					'label'				=> 'Video',
					'name'				=> 'video',
					'key'				=> 'video',
					'type'				=> 'repeater',
					'layout' 			=> 'row',
					'column_width'		=> '70',
					'instructions'		=> '',
					'sub_fields'		=> array(
						'source' 			=> array(
							'label'				=> 'Videoquelle',
							'name'				=> 'source',
							'key'				=> 'source',
							'type'				=> 'select',
							'choices'			=> $individole['choices_video_source'],
							'default_value'		=> 'embed',
						),
						
						'embed' 			=> array(
							'label'				=> '(A)<br>Embed-Code<br>oder URL',
							'name'				=> 'embed',
							'key'				=> 'embed',
							'type'				=> 'textarea',
							'formatting'		=> 'none',
							'instructions'		=> '',
						),
						'upload'			=> array(
							'row_limit' 		=> 1,
							'row_min' 			=> 1,
							'label'				=> '(B)<br>Upload',
							'name'				=> 'upload',
							'key'				=> 'upload',
							'type'				=> 'repeater',
							'layout' 			=> 'row',
							'instructions'		=> '',
							'sub_fields'		=> array(
								'mp4' 				=> array(
									'label'				=> 'MP4',
									'name'				=> 'mp4',
									'key'				=> 'mp4',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
								'mp4_hd' 			=> array(
									'label'				=> 'MP4 HD',
									'name'				=> 'mp4_hd',
									'key'				=> 'mp4_hd',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
								'webm' 				=> array(
									'label'				=> 'WebM',
									'name'				=> 'webm',
									'key'				=> 'webm',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
								'webm_hd' 			=> array(
									'label'				=> 'WebM HD',
									'name'				=> 'webm_hd',
									'key'				=> 'webm_hd',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
								'ogg' 				=> array(
									'label'				=> 'OGG',
									'name'				=> 'ogg',
									'key'				=> 'ogg',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
								'ogg_hd' 			=> array(
									'label'				=> 'OGG HD',
									'name'				=> 'ogg_hd',
									'key'				=> 'ogg_hd',
									'type'				=> 'file',
									'save_format'		=> 'id',
								),
							),
						),
					),
				),
			),
		);	
		
		
		//if(isset($field['modul']) && isset(${$field['modul']})) {
		//	$my_fields = array_merge($my_fields, ${$field['modul']});
		//
		//}
		
		//debug($my_fields[$field['options']]);
		
		return $my_fields[$field['options']];
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
				global $individole;
				
				do_action('acf/create_field', array(
					'type'	=>	'radio',
					'name'	=>	'fields['.$key.'][options]',
					'value'	=>	$field['options'],
					'choices'	=>	$individole['repeater_modules'],
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
new acf_field_individole_repeaters();

?>