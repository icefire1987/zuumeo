<?php

$createForm_js_embedded = 0;

add_shortcode('formular', 'createForm');

function createForm($args) {
	global $createForm_js_embedded;
	global $col;
	
	//debug($args);
	
	$id = 0;
	if(isset($args['m_formulare_id'])) {
		if(is_object($args['m_formulare_id'])) {
			$id = $args['m_formulare_id']->ID;
			
		} else {
			$id = $args['m_formulare_id'];	
		}
		
	} else if(isset($args['id']) && $args['id'] > 0) {
		$id = $args['id'];
	}
	
	if($id > 0)	{
		$fields = get_field('formulare_config', $id);
		
		//debug($fields);
		
		$c = $fields[0]['formulare_einstellungen'][0];
		$r = $fields[0]['formulare_receiver'];
		$f = $fields[0]['formulare_eingabefelder'];
		
		//debug($c);
		
		$w = "75%";
		$w_right = "20%";
		
		if(sizeof($f) > 0) {
			if(isset($c['w']) && $c['w'] > 0) {
				$w = $c['w'].'px';
			}
			
			if(isset($c['w']) && $c['w'] == 0) {
				$w = '100%';
				$w_right = "0px";
			}
			
			if(isset($c['infotext_right_w']) && $c['infotext_right_w'] > 0) {
				$w_right = $c['infotext_right_w'].'px';
			}
			
			
			//debug($c);
			//debug($r);
			//debug($f);
			
			$rows 				= array();
			$all_fields 		= array();
			$mandatory_fields 	= array();
			$email_fields 		= array();
			$i_field			= 1;
			$last_type 			= '';
			
			foreach($f as $field) {
			    //debug($field);
			    
			    $title 			= $title_base = $field['title'];
			    $type 			= $field['typ'];
			    $mandatory 		= $field['pflichtfeld'];
			    /* $dropdown 	= $field['dropdown']; */
			    $config 		= $field['config'];
			    
			    $all_fields[] = $i_field;
			    
			    if($mandatory == 1) {
			    	$title .= ' *';
			    	$mandatory_fields[] = $i_field;
			    }
			    
			    if($type == "email" || $type == "receiver_mail" || $type == "sender_mail") {
			    	$email_fields[] = $i_field;
			    }
			    
			    
			    $value_key = $id.'_'.$i_field;
			    $value_key_input = ' id="value_'.$value_key.'" name="value_'.$value_key.'"';
			    
			    $class_m_top = '';
			    
			    
			    
			    switch($type) {
			    	case "dropdown":
			    		$td_class = "td_input";
			    		$dropdown_options = explode("\n", $config);
			    		$temp_dropdown = '';
			    		foreach($dropdown_options as $dropdown_option) {
			    			$dropdown_option_values = explode("###", $dropdown_option);
			    			
			    			$temp_dropdown .= '
			    				<option value="'.trim($dropdown_option_values[1]).'">'.trim($dropdown_option_values[0]).'</option>
			    			';
			    		}
			    		
			    		$input = '
			    			<div class="selectbox">
			    				<select class="select" '.$value_key_input.'>
			    					'.$temp_dropdown.'
			    				</select>
			    			</div>
			    		';
			    		break;
			    		
			    		//<option value="" '.$anrede_selected_none.'>'.$dropdown->ID.'Bitte wählen</option>
			    		//			<option value="Herr" '.$anrede_selected_Herr.'>Herr</option>
			    		//			<option value="Frau" '.$anrede_selected_Frau.'>Frau</option>
			    		
			    	case "text":
			    		$config_textarea = explode("###", $config);
			    		
			    		$h_textarea = '';
			    		if(isset($config_textarea[1]) && is_numeric($config_textarea[1]) && $config_textarea[1] > 0) {
				    		$h_textarea = 'height:'.$config_textarea[1].'px;';
			    		}
			    		
			    		//$class_m_top = 'm_top';
			    		$td_class = "td_input";
			    		$input = '<textarea class="textarea" style="'.$h_textarea.'" '.$value_key_input.'>'.$config_textarea[0].'</textarea>';
			    		
			    		if($i_field > 1) {
				    		$class_m_top = 'm_top';
			    		}
			    		
			    		break;
			    			
			    	case "copy":
			    	case "true_false":
			    		$checkbox_options = explode("#", $config);
			    		
			    		if($type != $last_type) {
			    			$class_m_top = 'm_top';
			    		}
			    		
			    		$gfx_checkbox_0 = get_stylesheet_directory_uri().'/_formulare/_images/checkbox_0.gif';
			    		$gfx_checkbox_1 = get_stylesheet_directory_uri().'/_formulare/_images/checkbox_1.gif';

			    		$td_class = "td_checkbox";
			    		$onclick = 'formToggleCheckbox';
			    		$input = '
			    			<table cellpadding="0" cellspacing="0">
			    				<tr>
			    					<th class="checkbox" onclick="formToggleCheckbox(\''.$value_key.'\');" /><img src="'.$gfx_checkbox_0.'" id="checkbox_'.$value_key.'" /></th>
			    					<td class="checkbox_label hand noselect" onclick="formToggleCheckbox(\''.$value_key.'\');">'.$checkbox_options[0].'</td>
			    				</tr>
			    			</table>
			    			</div>
			    			<input type="hidden" '.$value_key_input.'  value="0" />
			    			<input type="hidden" id="form_gfx_checkbox_0" value="'.$gfx_checkbox_0.'" />
			    			<input type="hidden" id="form_gfx_checkbox_1" value="'.$gfx_checkbox_1.'" />
			    			'.clearer().'
			    		';
			    		break;
			    			
			    	case "subject":
			    	default:
			    		$td_class = "td_input";
			    		$input = '<input type="text" class="text" '.$value_key_input.' value="'.$config.'" />';
			    		break;
			    }
			    
			    if($title_base != "") {
				    $cell_title = '<th class="noselect '.$class_m_top.'" id="th_'.$value_key.'">'.$title.'</th>';
				    $colspan = '';
				    
			    } else {
				    $cell_title = '';
				    $colspan = 'colspan="2"';
			    }
			    
			    $rows[] = '
			    	<tr id="tr_'.$i_field.'">
			    		'.$cell_title.'
			    		<td '.$colspan.' class="noselect '.$class_m_top.' td_field '.$td_class.'" id="td_'.$value_key.'">'.$input.'</td>
			    		<input type="hidden" id="fieldtype_'.$value_key.'" value="'.$type.'" />
			    	</tr>
			    ';
			    
			    $last_type = $type;
			    
			    ++$i_field;
			}
			
			
			$text_right = '';
			if(isset($c['infotext_right']) && trim($c['infotext_right']) != "") {
				$form_text_right_top = 0;
				if(isset($c['infotext_right_top'])) {
					$form_text_right_top = $c['infotext_right_top'];
				}
				
				$text_right = '
					<div class="table_form_text right" style="width:'.$w_right.';">
						'.clearer($form_text_right_top).'
						'.$c['infotext_right'].'
					</div>
				';
			}
			
			$text_bottom = '';
			if(isset($c['infotext_bottom']) && trim($c['infotext_bottom']) != "") {
				$text_bottom = '
					'.clearer(15).'
					<div style="width:'.$w.';">
						'.nl2br($c['infotext_bottom']).'
					</div>
				';
			}
			
			
			$title_submit 			= $c['title_submit'];
			$title_submit_pending 	= $c['title_submit_pending'];
			$title_submit_done 		= $c['title_submit_done'];
			
			
			$js_embed = "";
			if($createForm_js_embedded == 0) {
				$js_embed = '<script src="'.getStylesheetDirectoryURI().'/_formulare/sendForm.js"></script><script src="'.getStylesheetDirectoryURI().'/_formulare/formToggleCheckbox.js"></script>';
			}
			
			
			$submit_colspan = 2;
			$submit_class = 'left';
			$submit_th = '';
			
			if(isset($c['submit_position'])) {
				switch($c['submit_position']) {
					case "left":
						break;
						
					case "right":
						$submit_class = 'right';
						break;
						
					case "indent":
						$submit_colspan = 1;
						$submit_th = '<th></th>';
						break;
						
					case "indent_full":
						$submit_colspan = 1;
						$submit_th = '<th></th>';
						$submit_class = '';
						break;
						
					case "full":
						$submit_class = '';
						break;
						
					case "center":
						break;
						
					default:
						break;
				}
			}
			
			$btn_submit = '<div class="submit hand '.$submit_class.' nowrap" onclick="sendForm({id:'.$id.'});" id="submit_'.$id.'" style="">'.$title_submit.'</div>';
			
			if(isset($c['submit_position']) && $c['submit_position'] == "center") {
				$btn_submit = '
					<table style="width:100%;" cellpadding="0" cellspacing="0">
						<tr>
							<td style="width:50%;"></td>
							<td style="width:auto;">'.$btn_submit.'</td>
							<td style="width:50%;"></td>
						</tr>
					</table>
				';
			}
			
			
			$return = '
				'.$js_embed.'
				<div class="left" style="width:'.$w.';">
					<form action="" method="post" id="form_'.$id.'">
						<table class="contactform" cellpadding="0" cellspacing="0" border="0" style="width:100%;">
							'.implode("", $rows).'
							<tr>
			    				'.$submit_th.'<td colspan="'.$submit_colspan.'" class="noselect td_field">'.$btn_submit.'</td>
			    			</tr>
			    			<input type="hidden" id="mandatory_fields" value="'.implode(",", $mandatory_fields).'" />
			    			<input type="hidden" id="email_fields" value="'.implode(",", $email_fields).'" />
			    			<input type="hidden" id="all_fields" value="'.implode(",", $all_fields).'" />
			    			<input type="hidden" id="formular_id" value="'.$id.'" />
			    			<input type="hidden" id="submit_pending" value="'.$title_submit_pending.'" />
			    			<input type="hidden" id="submit_done" value="'.$title_submit_done.'" />
			    			<input type="hidden" id="form_path" value="'.get_stylesheet_directory_uri().'" />
						</table>
					</form>
					<div id="form_test"></div>
				</div>
				<link rel="stylesheet" href="'.getStylesheetDirectoryURI().'/_formulare/stylesheet.css?'.rand().'" />
				'.$text_right.'
				'.clearer().'
				'.$text_bottom.'
			';
			
			$createForm_js_embedded = 1;
			
			return $return;
		}
	}
}

?>