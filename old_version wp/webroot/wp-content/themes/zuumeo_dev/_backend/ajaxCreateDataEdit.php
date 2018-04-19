<?php

if(isset($_POST['data_edit'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	if(is_user_logged_in()) {
		global $config_modules;
		global $config_modules_base;
		global $module_gap_standard;
		//include("ajax-include.php");
		
		//debug($config_modules);
		
		//!GET post-vars
		$i_data_edit	= $_POST['i_data_edit'];
		$post_id 		= $_POST['post_id'];
		$field 			= $_POST['field'];
		$number 		= $_POST['number'];
		$module_type 	= $_POST['module_type'];
		$type 			= $_POST['type'];
		
		
		$input = '';
		$test = '';
		
		$data_fields = array();
		$data_field_keys = array();
		$data_types = array();
		$data_cpt_keys = array();
		$data_repeaters = array();
		$data_options_fields = array();
		$data_options_types = array();
		
		$extras = '';
		
		//debug($post_id.$field);
		
		$c = array();
		$content = array();
		$none = 0;
		$info_reload = 0;
		if($module_type != "") {
			$c = $config_modules;
			
			$i_input = 0;
			
			foreach($c AS $c_key => $c_value) {
				$do = 1;
				if($c_key == 'title' && !is_array($c_key)) {
					$do = 0;
					$maintitle = $c_value;
				}
				
				if($c_key == 'hide_options') {
					$do = 0;
				}
				
				if($do == 1) {
					$data_field_keys[] = $c_key;
					
					$final_field 	= $field.'_'.$c_value['field'];
					
					//debug($final_field);
					
					if(is_numeric($number)) {
						$final_field = str_replace("#", $number, $final_field);
					}
					
					
					(isset($c_value['type'])) ? $input_type = $c_value['type'] : $input_type = 'text';
					$data_types[] = $input_type;
					
					if($c_value['field'] == "post_title" || $c_value['field'] == "post_date" || $c_value['field'] == "post_status") {
						if($c_value['field'] == "post_title") {
							$current_value = get_the_title($post_id);
						
						} else if($c_value['field'] == "post_date") {
							$current_value = get_the_time('Y-m-d H:i', $post_id);
							
						} else if($c_value['field'] == "post_status") {
							$current_value = get_post_status($post_id);
						}
						
						$field_id = 'data_edit_input_'.$c_value['field'];
						$data_fields[] = $c_value['field'];
						
					} else {
						$current_value = get_post_meta($post_id, $final_field, true);
						$field_id = 'data_edit_input_'.$final_field;
						$data_fields[] = $final_field;
					}
					
					
					//echo '<p>'.$c_value['field'].' -> '.$c_value['type'].' -> '.$c_value['choices'];
					$test .= '<p>$final_field:'.$final_field.' / '.$input_type.' / '.$current_value. ' / ';
					
					if($i_input > 0) {
						//$content[] = '<div class="editor_line"></div>';
					}
					
					$title = '';
					if(isset($c_value['label'])) {
						if(isset($c_value['reload'])) {
							$info_reload = 1;
							$c_value['label'] .= ' <sup style="color:red;">1</sup>';
						}
						
						$title = $c_value['label'];
					}
					
					if(isset($c_value['repeater'])) {
						$data_repeaters[] = $c_value['repeater'];
					} else {
						$data_repeaters[] = '';
					}
					
					if(isset($c_value['cpt_key'])) {
						$data_cpt_keys[] = $c_value['cpt_key'];
					} else {
						$data_cpt_keys[] = '';
					}
					
					switch($input_type) {
					    case "none":
					    	$none = 1;
					    	//$content[] = '';
					    	break;
					    	
					    case "array":
					    	++$i_input;
					    	
					    	//$current_value = serialize($current_value);
					    	$input_cols = array();
					    	foreach($current_value AS $k => $v) {
						    	$input_cols[] = '
						    		<div class="left">'.$k.':'.$v.'</div>
						    	';
					    	}
					    	
					    	$current_value_serialized = serialize($current_value);
					    	
					    	$input = implode("", $input_cols).'<textarea id="'.$field_id.'" class="noUniform box data_edit data_edit_textarea">'.$current_value_serialized.'</textarea>';
					    	break;
					    	
					    case "textarea":
					    	++$i_input;
					    	
					    	$input = '<textarea id="'.$field_id.'" class="noUniform box data_edit data_edit_textarea">'.$current_value.'</textarea>';
					    	break;
					    	
					    case "true_false":
					    	++$i_input;
					    	
					    	$checked = '';
					    	if($current_value == 1) {
						    	$checked = 'checked';
					    	}
					    	
					    	$input = '<input type="checkbox" id="'.$field_id.'" class="noUniform data_edit_checkbox" '.$checked.' />';
					    	break;
					    	
					    case "image":
					    	++$i_input;
					    	
					    	$image_data = wp_get_attachment_image_src($current_value, 'medium');
					    	
					    	$url = admin_url( "upload.php?page=enable-media-replace/enable-media-replace.php&action=media_replace&attachment_id=" . $current_value);
							$action = "media_replace";
							$editurl = wp_nonce_url( $url, $action );
							
							$display = '';
							$no_img = '';
							if(!$image_data) {
								$no_img = '<div id="img_hint_'.$field_id.'" style="margin-top: 4px;"><i>Kein Bild ausgewählt</i></div>';
								$display = 'none';
							}
							
							$btn_delete = '<div id="btn_delete_'.$field_id.'" class="absolute data_edit_image_delete shadow hand" onclick="data_edit_image_remove({ field_id:\''.$field_id.'\' });" style="display:'.$display.';"></div>';
							
							$btn_reupload = clearer(1).'<a href="'.$editurl.'" id="btn_reupload_'.$field_id.'" class="left acf-button acf-button-grey acf-button-xsmall hand" style="display:'.$display.';" target="_blank">Datei neu hochladen</a>';
							
							$btn_upload = '<div id="btn_upload_'.$field_id.'" class="left acf-button acf-button-grey acf-button-xsmall hand" style="margin-right:1px;" onclick="data_edit_image({ field_id:\''.$field_id.'\', type:\'image\' });">Bild wählen</div>';
							
					    	$input = '
					    		'.$no_img.'
					    		<div class="relative left">
					    			<img src="'.$image_data[0].'" style="display:'.$display.';" id="file_'.$field_id.'" class="shadow data_edit_image" />
					    			'.$btn_delete.'
					    		</div>
					    		'.clearer(10).'
					    		'.$btn_upload.'
					    		<input type="hidden" id="'.$field_id.'" value="'.$current_value.'">
					    		'.clearer().'
					    	';
					    	break;
					    	
					    case "gallery":
					    	++$i_input;
					    	
					    	$previews = array();
					    	
					    	//$current_images = implode(",", $current_value);
							
							if(!empty($current_value)) {
								foreach($current_value AS $current_image) {
									$image_data = wp_get_attachment_image_src($current_image, 'medium');
								
									$previews[] = '
										<div class="image_container left relative null" id="image_'.$current_image.'">
											<img src="'.$image_data[0].'" class="shadow data_edit_image data_edit_images" />
											<div onclick="data_edit_images_remove({ field_id:\''.$field_id.'\', image_id:\''.$current_image.'\' });" class="absolute data_edit_image_delete hand shadow"></div>
										</div>
									';
								}
							} else {
								$current_value = array();
							}
							
							$btn_upload = '<div id="btn_upload_'.$field_id.'" class="left acf-button acf-button-grey acf-button-xsmall hand" style="margin-right:1px;" onclick="data_edit_images({ field_id:\''.$field_id.'\' });">Bild(er) hinzufügen</div>';
							
							$input = '
					    		<div id="images_'.$field_id.'">
					    			'.implode("", $previews).'
					    		</div>
					    		<input type="hidden" id="'.$field_id.'" value="'.implode(",", $current_value).'" style="width:100%;">
					    		'.clearer(10).'
					    		'.$btn_upload.'
					    		<script>
					    			jQuery("#images_'.$field_id.'").sortable({
									    update: function(event, ui) {
									    	data_edit_images_set("'.$field_id.'");
									    }
									});
					    		</script>
					    	';
					    	break;
					    	
					    case "file":
					    	++$i_input;
					    	
					    	$btn_upload = '<div id="btn_upload_'.$field_id.'" class="left acf-button acf-button-grey acf-button-xsmall hand" style="margin-right:1px;" onclick="data_edit_image({ field_id:\''.$field_id.'\', type:\'file\' });">Datei wählen</div>';
							
							if($current_value > 0) {
								$display = 'block';
								$current_file_url = wp_get_attachment_url($current_value);
								$no_file = '';
								$btn_delete = '<div id="btn_delete_'.$field_id.'" class="left acf-button acf-button-grey acf-button-xsmall hand" onclick="data_edit_image_remove({ field_id:\''.$field_id.'\' });" style="display:'.$display.';">Datei entfernen</div>';
							
							} else {
								$display = 'none';
								$current_file_url = '';
								$no_file = '<div id="img_hint_'.$field_id.'" style="margin-top: 4px;"><i>Keine Datei ausgewählt</i></div>';
							}
							
					    	$input = '
					    		'.$no_file.'
					    		<div class="relative left">
					    			<div id="file_'.$field_id.'" style="display:'.$display.'; word-break:break-word;">'.$current_file_url.'</div>
					    		</div>
					    		'.clearer(10).'
					    		'.$btn_upload.'
					    		'.$btn_delete.'
					    		<input type="hidden" id="'.$field_id.'" value="'.$current_value.'">
					    		'.clearer().'
					    	';
					    	break;
					    	
					    case "select":
					    	++$i_input;
					    	
					    	$options = array();
					    	if(isset($c_value['choices']) && !empty($c_value['choices'])) {
					    		foreach($c_value['choices'] AS $option_value => $option_output) {
						    		$selected = '';
						    		if($current_value == $option_value) {
							    		$selected = 'selected';
						    		}
						    		$options[] = '<option class="noUniform" value="'.$option_value.'" '.$selected.' style="color: red;">'.$option_output.'</option>';
								}
							}
					    	
					    	$input = '<select id="'.$field_id.'" class="noUniform data_edit_select">'.implode("", $options).'</select>';
					    	break;
					    	
					    case "radio":
					    	++$i_input;
					    	
					    	$options = array();
					    	$i_radio = 0;
					    	foreach($c_value['choices'] AS $option_value => $option_output) {
						    	$selected = '';
						    	if($current_value == $option_value) {
							    	$selected = 'checked';
						    	}
						    	$options[] = '<input type="radio" id="radio_'.$field_id.'_'.$i_radio.'" name="radio_'.$field_id.'" value="'.$option_value.'" '.$selected.' class="noUniform data_edit_radio"><label for="radio_'.$field_id.'_'.$i_radio.'" class="hand data_edit_label">'.$option_output.'</label>'.clearer();
						    	
						    	++$i_radio;
					    	}
					    	
					    	$input = '<div id="'.$field_id.'">'.implode("", $options).'</div>';
					    	break;
					    	
					    case "checkbox":
					    	++$i_input;
					    	
					    	if(!is_array($current_value)) {
						    	$current_value = unserialize($current_value);
						    }
					    	
					    	$options = array();
					    	$i_radio = 0;
					    	foreach($c_value['choices'] AS $option_value => $option_output) {
						    	$selected = '';
						    	if(is_array($current_value) && in_array($option_value, $current_value)) {
							    	$selected = 'checked';
						    	}
						    	$options[] = '<input type="checkbox" id="radio_'.$field_id.'_'.$i_radio.'" name="radio_'.$field_id.'" value="'.$option_value.'" '.$selected.' class="data_edit_radio"><label for="radio_'.$field_id.'_'.$i_radio.'" class="hand data_edit_label">'.$option_output.'</label>'.clearer();
						    	
						    	++$i_radio;
					    	}
					    	
					    	$input = '<div id="'.$field_id.'">'.implode("", $options).'</div>';
					    	break;
					    	
					    case "wysiwyg":
					    	++$i_input;
					    	
					    	global $configs_tinymce;
					    	$c_tiny = $configs_tinymce;
					    	
					    	$input = '
					    		<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/_tiny_mce/tiny_mce.js"></script>
					    		
					    		<textarea id="'.$field_id.'" name="'.$field_id.'" class="tinymce box data_edit data_edit_wysiwyg">'.$current_value.'</textarea>
					    		
					    		<script type="text/javascript">
					    			tinyMCE.init({
					    				// General options
					    				mode : "none",
					    				/* elements : "'.$field_id.'", */
					    				theme : "'.$c_tiny['theme'].'",
					    				skin : "thebigreason",
					    				plugins : "paste",
					    				language : "de",
					    				relative_urls: false,
										remove_script_host: false,
										entity_encoding : "raw",
										remove_linebreaks : false,
										convert_newlines_to_brs : true,
										
					    				// Theme options
					    				theme_advanced_styles : "'.$c_tiny['styles'].'",
					    				theme_advanced_blockformats : "'.$c_tiny['blockformats'].'",
					    				invalid_elements : "'.$c_tiny['invalid_elements'].'",
					    				force_p_newlines : true,
					    				theme_advanced_buttons1 : "'.$c_tiny['theme_advanced_buttons1'].'",
					    				theme_advanced_buttons2 : "'.$c_tiny['theme_advanced_buttons2'].'",
					    				theme_advanced_buttons3 : "'.$c_tiny['theme_advanced_buttons3'].'",
					    				theme_advanced_buttons4 : "'.$c_tiny['theme_advanced_buttons4'].'",
					    				theme_advanced_toolbar_location : "top",
					    				theme_advanced_toolbar_align : "left",
					    				theme_advanced_statusbar_location : "none",
					    				theme_advanced_resizing : true,
					    				
					    				
					    				content_css : "'.$c_tiny['content_css'].'",
					    			});
					    		</script>
					    	';
					    	break;
					    	
					    case "number":
					    	++$i_input;
					    	
					    	$input = '<input type="number" step="any" id="'.$field_id.'" value="'.$current_value.'" class="box data_edit" onkeypress="if(keyEnter(event) == true){data_edit_save('.$i_data_edit.');}">';
					    	break;
					    	
					    default:
					    	++$i_input;
					    	
					    	$readonly = '';
					    	$class_readonly = '';
					    	if(isset($c_value['readonly']) || $c_value['field'] == "post_date" || $input_type == "date") {
						    	$readonly = 'readonly';
						    	$class_readonly = 'data_edit_readonly';
					    	}
					    	
					    	$datepicker = '';
					    	if($c_value['field'] == "post_date" || $input_type == "date") {
					    		$datepicker = '
					    			<script>
					    				jQuery(document).ready(function() {
											jQuery("#'.$field_id.'").datetimepicker({
												dateFormat : "yy-mm-dd",
												changeMonth: true,
												changeYear: true,
												showTime: false,
											});
										});
									</script>
					    		';
					    	}
					    	
					    	if(isSuperAdmin()) {
						    	//$readonly = '';
					    	}
					    	
					    	$input = '<input type="text" id="'.$field_id.'" value="'.$current_value.'" class="noUniform box data_edit '.$class_readonly.'" onkeypress="if(keyEnter(event) == true){data_edit_save('.$i_data_edit.');}" '.$readonly.'>'.$datepicker;
					    	break;
					}
					
					$colspan 			= 2;
					$td_class 			= '';
					if($title != "") {
						if($input_type == "wysiwyg") {
							$colspan 		= 2;
							$title 			= '<tr><td class="editor_content_title" colspan="2" nowrap>'.$title.'</td></tr>';
							
						} else {
							$colspan 		= 1;
							$title 			= '<td class="editor_content_title" nowrap>'.$title.'</td>';
							$td_class 		= 'editor_table_data';	
						}
					}
					
					$final_help = '';
					if(isset($c_value['help'])) {
						$help_title = '';
						if(isset($c_value['help_title'])) {
							$help_title = '<td class="editor_content_title" nowrap>'.$c_value['help_title'].'</td>';
						}
						
						if(is_array($c_value['help'])) {
							$help = $c_value['help'];
							$help_rows = array();
							foreach($help AS $help_key => $help_value) {
								$help_rows[] = '
									<tr>
										<td class="editor_content_title" nowrap>'.$help_key.'</td>
										<td>'.$help_value.'</td>
									</tr>
								';
							}
							
							$help = '
								<table cellpadding="0" cellspacing="0">
									'.implode("", $help_rows).'
								</table>
							';
							
						} else {
							$help = $c_value['help'];
						}
						
						//$content[] = '
						//	<tr>
						//		'.$help_title.'
						//		<td colspan="2" class="editor_table_data editor_table_data_help">'.$help.'</td>
						//	</tr>
						//';
						
						$final_help = '
							<div class="editor_table_data_help">'.$help.'</div>
						';
					}
					
					$content[] = '
						<tr>
							'.$title.'
							<td colspan="'.$colspan.'" class="editor_content_data '.$td_class.'" style="width: 100%;">'.$input.$final_help.'</td>
						</tr>
					';
				}
			}
			
		} else {
			$data_fields[] = $field;
			$data_types[] = $type;
				
			switch($field) {
				case "post_title":
					$current_value = get_the_title($post_id);
				   	break;
				
				case "post_status":
					$current_value = get_post_status($post_id);
				   	break;
				
				default:
					$current_value = get_post_meta($post_id, $field, true);
					break;
			}
			
			$field_id = 'data_edit_input_'.$field;
			
			switch($type) {
				case "none":
				    $none = 1;
				    //$content[] = '';
				    break;
				    
				case "image":
				    	++$i_input;
				    	
				    	$image_data = wp_get_attachment_image_src($current_value, 'medium');
				    	
				    	$input = '
				    		<div class="null" style="margin-right:15px;">
				    			<img src="'.$image_data[0].'" style="max-width:250px; max-height:150px;" id="image_'.$field_id.'" class="shadow" />
				    		</div>
				    		'.clearer(10).'
				    		<div class="left button acf-button hand" style="margin-right:10px;" onclick="data_edit_image({ field_id:\''.$field_id.'\' });">Bild wählen</div>
				    		<div class="left button acf-button hand" onclick="data_edit_image_remove({ field_id:\''.$field_id.'\' });">Bild entfernen</div>
				    		<input type="hidden" id="'.$field_id.'" value="'.$current_value.'">
				    		'.clearer().'
				    	';
				    	break;
				    	
				case "textarea":
				    $input = '<textarea id="'.$field_id.'" class="box data_edit data_edit_textarea">'.$current_value.'</textarea>';
				    break;
				    
				case "true_false":
				    $checked = '';
				    if($current_value == 1) {
				    	$checked = 'checked';
				    }
				    
				    $input = '<input type="checkbox" id="'.$field_id.'" class="data_edit_checkbox" '.$checked.' />';
				    break;
				    
				default:
					$input = '<input type="text" id="'.$field_id.'" value="'.$current_value.'" class="box data_edit" onkeypress="if(keyEnter(event) == true){data_edit_save('.$i_data_edit.');}">';
			    	break;
    		}
			
			$content[] = '
				<tr>
			       	<td class="editor_content_title" nowrap>'.$title.'</td>
					<td class="editor_content_data" style="width: 100%;">'.$input.'</td>
				</tr>
			';
		}
		
		$final_options = '';
		if(isset($config_modules_base) && !isset($c['hide_options'])) {
			$content_options = array();
			
			$o = $config_modules_base;
			
			$i_input = 0;
			
			foreach($o AS $o_key => $o_value) {
			    if($o_value['status'] == true) {
			    	$data_field_keys[] = $o_key;
			    	
			    	$final_field 	= $field.'_config_base_'.$module_type.'_0_'.$o_key;
			    	
			    	//debug($o_key);
			    	//debug($post_id.$final_field);
			    		
			    	$data_types[] = $o_value['type'];
			    	
			    	$current_value = get_post_meta($post_id, $final_field, true);
			    	$field_id = 'data_edit_input_'.$final_field;
			    	$data_fields[] = $final_field;
			    	
			    	
			    	//echo '<p>'.$c_value['field'].' -> '.$c_value['type'].' -> '.$c_value['choices'];
			    	$test .= '<p>$final_field:'.$final_field.' / '.$o_value['type'].' / '.$current_value. ' / ';
			    	
			    	//debug($test);
			    	
			    	switch($o_value['type']) {
			    	    case "textarea":
			    	    	++$i_input;
			    	    	
			    	    	$input = '<textarea id="'.$field_id.'" class="box data_edit data_edit_textarea">'.$current_value.'</textarea>';
			    	    	break;
			    	    	
			    	    case "true_false":
			    	    	++$i_input;
			    	    	
			    	    	$checked = '';
			    	    	if($current_value == 1) {
			    	        	$checked = 'checked';
			    	    	}
			    	    	
			    	    	$input = '<input type="checkbox" id="'.$field_id.'" class="data_edit_checkbox" '.$checked.' />';
			    	    	break;
			    	    	
			    	    case "select":
			    	    	++$i_input;
			    	    	
			    	    	$options = array();
			    	    	foreach($o_value['choices'] AS $option_value => $option_output) {
			    	        	$selected = '';
			    	        	if($current_value == $option_value) {
			    	    	    	$selected = 'selected';
			    	        	}
			    	        	$options[] = '<option value="'.$option_value.'" '.$selected.'>'.$option_output.'</option>';
			    	    	}
			    	    	
			    	    	$input = '<select id="'.$field_id.'" class="data_edit_select">'.implode("", $options).'</select>';
			    	    	break;
			    	    	
			    	    case "radio":
			    	    	++$i_input;
			    	    	
			    	    	$options = array();
			    	    	$i_radio = 0;
			    	    	foreach($c_value['choices'] AS $option_value => $option_output) {
			    	        	$selected = '';
			    	        	if($current_value == $option_value) {
			    	    	    	$selected = 'checked';
			    	        	}
			    	        	$options[] = '<input type="radio" id="radio_'.$field_id.'_'.$i_radio.'" name="radio_'.$field_id.'" value="'.$option_value.'" '.$selected.' class="data_edit_radio"><label for="radio_'.$field_id.'_'.$i_radio.'" class="hand data_edit_label">'.$option_output.'</label>'.clearer();
			    	        	
			    	        	++$i_radio;
			    	    	}
			    	    	
			    	    	$input = '<div id="'.$field_id.'">'.implode("", $options).'</div>';
			    	    	break;
			    	    	
			    	    case "checkbox":
			    	    	++$i_input;
			    	    	
			    	    	if(!is_array($current_value)) {
			    	        	$current_value = unserialize($current_value);
			    	        }
			    	    	
			    	    	$options = array();
			    	    	$i_radio = 0;
			    	    	foreach($c_value['choices'] AS $option_value => $option_output) {
			    	        	$selected = '';
			    	        	if(is_array($current_value) && in_array($option_value, $current_value)) {
			    	    	    	$selected = 'checked';
			    	        	}
			    	        	$options[] = '<input type="checkbox" id="radio_'.$field_id.'_'.$i_radio.'" name="radio_'.$field_id.'" value="'.$option_value.'" '.$selected.' class="data_edit_radio"><label for="radio_'.$field_id.'_'.$i_radio.'" class="hand data_edit_label">'.$option_output.'</label>'.clearer();
			    	        	
			    	        	++$i_radio;
			    	    	}
			    	    	
			    	    	$input = '<div id="'.$field_id.'">'.implode("", $options).'</div>';
			    	    	break;
			    	    	
			    	    case "number":
			    	    	++$i_input;
			    	    	
			    	    	$input = '<input type="number" id="'.$field_id.'" value="'.$current_value.'" class="box data_edit" onkeypress="if(keyEnter(event) == true){data_edit_save('.$i_data_edit.');}">';
			    	    	break;
			    	    	
			    	    default:
			    	    	++$i_input;
			    	    	
			    	    	$readonly = '';
			    	    	$class_readonly = '';
			    	    	if(isset($c_value['readonly'])) {
			    	        	$readonly = 'readonly';
			    	        	$class_readonly = 'data_edit_readonly';
			    	    	}
			    	    	
			    	    	if(isSuperAdmin()) {
			    	        	$readonly = '';
			    	    	}
			    	    	
			    	    	$input = '<input type="text" id="'.$field_id.'" value="'.$current_value.'" class="box data_edit '.$class_readonly.'" onkeypress="if(keyEnter(event) == true){data_edit_save('.$i_data_edit.');}" '.$readonly.'>';
			    	    	break;
			    	}
			    	
			    	$content_options[] = '
			    	    <tr>
			    	    	<td class="editor_content_title" nowrap>'.$o_value['label'].'</td>
							<td class="editor_content_data" style="width: 100%;">'.$input.'</td>
						</tr>
			    	';
			    }
			}
			
			$final_options = '
			    <div class="editor_title" id="ind_test1">Modul-Einstellungen</div>
			    <div class="editor_content">
			        <table cellpadding="0" cellspacing="0" style="width: 100%;">
			        	'.implode('', $content_options).'
			        </table>
			    </div>
			';
		}
		
		
		
		//!MODUL status
		$status_standard_options = 0;
		$modul_status = '';
		
		
		
		if(!isset($maintitle)) {
			$maintitle = 'Inhalt bearbeiten';
		}
		
		$header = '
			<div class="editor_title">'.$maintitle.'</div>
		';
		
		$hints = array();
		if($info_reload == 1) {
			$hints[] = '
				<div class="editor_hint"><sup>1</sup> Kein Realtime-Update nach dem Speichern, Reload erforderlich!</sup></div>
			';
		}
		
		//<div class="left editor_hint">'.implode("", $hints).'</div>
		
		$show_save_post_id = '';
		if(isSuperAdmin()) {
			$show_save_post_id = ' &raquo; '.$post_id;
		}
		
		$buttons = '
			<div id="ind_fp_editor_footer">
				<div id="ind_fp_editor_footer_inner">
					<div class="left acf-button acf-button-draft" onclick="data_edit_close('.$i_data_edit.'); return false;">Abbruch</div>
					<div class="right acf-button acf-button-publish" onclick="data_edit_save('.$i_data_edit.'); return false;">Speichern'.$show_save_post_id.'</div>
					'.clearer().'
				</div>
			</div>
		';
		
		
		$final_field_ids = '
			<input type="hidden" id="data_field_keys" value="'.implode(",", $data_field_keys).'">
			<input type="hidden" id="data_fields" value="'.implode(",", $data_fields).'">
			<input type="hidden" id="data_types" value="'.implode(",", $data_types).'">
			<input type="hidden" id="data_repeaters" value="'.implode(",", $data_repeaters).'">
			<input type="hidden" id="data_cpt_keys" value="'.implode(",", $data_cpt_keys).'">
		';
		
		if(empty($content)) {
			$content[] = '<div class="editor_text center" style="padding-top: 15px;"><i>Keine weiteren Einstellungen verfügbar</i></div>';
		}
		
		$final_echo = '
			'.$final_options.'
			'.$header.'
			<div class="editor_content">
				<table cellpadding="0" cellspacing="0" style="width: 100%;">
					'.implode('', $content).'
				</table>
			</div>
			'.$extras.'
			'.$final_field_ids.'
			'.clearer(120).'
			<div id="admin_frontpage_edit_debug"></div>
			<div id="ind_fp_editor_resizer"></div>
			<script>
				//jQuery("#ind_fp_editor_resizer").draggable({
				//    axis: "x",
				//    drag: function() {
				//    	ind_fp_editor_resize($(this));
				//    },
				//    stop: function() {
				//    	ind_fp_editor_resize($(this));
				//    }
				//});
			</script>
			'.$buttons.'
		';
		
		//!return to javascript
		echo $final_echo.'|||'.$test;
	}
}

?>