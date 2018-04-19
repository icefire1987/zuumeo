<?php

$i_data_edit = 1;

function addFrontpageEdit($args) {
	if(is_user_logged_in() && isset($args['field']) && !isPageFacebook()) {
		$page_id = getPageID();
		
		if(isset($args['module_type'])) {
			$module_type = $args['module_type'];
		
		} else if(isset($args['meta'])) {
			$module_type = '';
		
		} else {
			global $module_type;
		}
		
		//debug($args);
		
		global $i_data_edit;
		
		(isset($args['type'])) 		? $type = $args['type'] 		: $type = 'input';
		(isset($args['top'])) 		? $top = $args['top'] 			: $top = 0;
		(isset($args['right'])) 	? $right = $args['right'] 		: $right = 0;
		
		if(isset($args['id'])) {
			$edit_id = $args['id'];
		
		} else {
		    $edit_id = $page_id;
		}
		
		
		$return['id'] = 'id="data_'.$i_data_edit.'"';
		$return['edit_id'] = $i_data_edit;
		//$return['edit_inner_id'] = $i_data_edit;
		
		$content = '';
		if(isset($args['content'])) {
		    $content = '
		    	<div '.$return['id'].' style="display:inline;">
		    		'.$args['content'].'
		    	</div>
		    ';
		}
		
		$onclick = 'data_edit('.$i_data_edit.'); return false;';
		if(isset($args['type']) && ($args['type'] == "image" || $args['type'] == "image_list" || $args['type'] == "video")) {
		   $top = 0;
		}
		
		
		$class 				= 'data_edit_default';
		$top 				= 'top:'.$top.'px;';
		$column_line 		= '';
		
		$right 				= 'right:'.$right.'px;';
		if(isset($args['right']) && !is_numeric($args['right'])) {
			$right 			= $args['right'];
		}
		
		
		if(isset($args['columns'])) {
			$class 			= 'data_edit_columns';
			$right 			= '';
			$top 			= '';
			$column_line 	= '<div class="data_edit_columns_line data_edit_object null"></div>';
		}
		
		if(isset($args['table'])) {
			$class 			= 'data_edit_columns';
			$right 			= '';
			$top 			= '';
			$column_line 	= '<div class="data_edit_columns_line data_edit_object null"></div>';
		}
		
		if(isset($args['flex'])) {
			//debug($args);
			$top 			= '';
			$class 			= 'data_edit_flex';
			$column_line 	= '<div class="data_edit_flex_line data_edit_object null"></div>';
		}
		
		
		if(isset($args['center'])) {
			$right 			= '';
			$top 			= 'top:50%; left:50%;';
		}
		
		
		if(isset($args['column'])) {
			if(isset($args['w'])) {
				$final_right = $args['w'];
			} else {
				$final_right = getColumnWidth(array());
			}
			
			$class 			= 'data_edit_column';
			/* $label 			= 'Modul'; */
			/* $right 			= 'left:-31px;'; */
			$top 			= '';
			$column_line 	= '<div class="data_edit_column_line data_edit_column_line_single data_edit_object null"></div>';
		}
		
		if(isset($args['shortcode'])) {
			if(isset($args['w'])) {
				$final_right = $args['w'];
			} else {
				$final_right = getColumnWidth(array());
			}
			
			$class 			= 'data_edit_shortcode';
			$right 			= '';
			$top 			= '';
			$column_line 	= '<div class="data_edit_shortcode_line data_edit_object null"></div>';
		}
		
		if(isset($args['line'])) {
			$class 			= 'data_edit_line';
		}
		
		$data_number = '';
		if(isset($args['number'])) {
			$data_number = $args['number'];
		}
		
		$label = '';
		$class_label = '';
		if(isset($args['label']) && $args['label'] != "") {
			$label = $args['label'];
			$class_label = 'data_edit_button_label';
		}
		
		
		$return['content'] = $column_line.'<div id="data_edit_'.$i_data_edit.'" class="absolute hand data-edit '.$class.' data_edit_button data_edit_object '.$class_label.'" data-post_id="'.$edit_id.'" data-field="'.$args['field'].'" data-type="'.$type.'" data-number="'.$data_number.'" data-module-type="'.$module_type.'" onclick="'.$onclick.'" style="'.$top.' '.$right.'">'.$label.'</div>'.$content;
		
		++$i_data_edit;
		
		return $return;
	
	} else {
		if(isset($args['content'])) {
			$return['id'] = 0;
			$return['content'] = $args['content'];
			
			return $return;
		}
		
		
	}
}

?>