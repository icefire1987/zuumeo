<?php

if(isset($_POST['data_edit_save'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	
	if(is_user_logged_in()) {
		global $wpdb;
		global $config_modules;
		
		//!GET post-vars
		$i_data_edit		= $_POST['i_data_edit'];
		$post_id 			= $_POST['post_id'];
		
		$module_type 		= $_POST['module_type'];
		$data_fields 		= explode(",", $_POST['data_fields']);
		$data_field_keys 	= explode(",", $_POST['data_field_keys']);
		$data_types 		= explode(",", $_POST['data_types']);
		$data_repeaters 	= explode(",", $_POST['data_repeaters']);
		$data_cpt_keys 		= explode(",", $_POST['data_cpt_keys']);
		$data_values 		= explode("######", $_POST['data_values']);
		
		$new_values 		= array();
		$new_types 			= array();
		
		$my_post = array();
		$my_post['ID'] = $post_id;
		
		$success 	= 0;
		$test		= '';
		
		$update_type = '';
		
		$new_gap_top = 0;
		$new_gap_bottom = 0;
		
		$new_gap_innertop = 0;
		$new_gap_innerbottom = 0;
		
		$i = 0;
		foreach($data_fields AS $data_field) {
			$data_field_key 	= $data_field_keys[$i];
			$data_type 			= $data_types[$i];
			$data_value 		= $data_values[$i];
			$data_repeater 		= @$data_repeaters[$i];
			$data_cpt_key 		= @$data_cpt_keys[$i];
			
			$new_types[] = $data_type;
			
			//echo '<p>#'.$i.' --> $data_field:'.$data_field.'<br>$data_type:'.$data_type.'<br>$data_value:'.$data_value;
			
			//!SET new_value for realtime feedback
			if($data_type == "textarea") {
				$new_value = nl2br($data_value);
				
			} else if($data_type == "checkbox") {
				$data_value = explode(",", $data_value);
				$data_value = serialize($data_value);
				$new_value = $data_value;
				
			} else if($data_type == "gallery") {
				$data_value = explode(",", $data_value);
				//$data_value = serialize($data_value);
				$new_value = $data_value;
				
			} else if($module_type == "columns") {
				if($data_value == "default" && isset($_POST['columns_cols'])) {
					$columns_cols = array();
					for($i_col = 0; $i_col<$_POST['columns_cols']; $i_col++) {
						$columns_cols[] = 12/$_POST['columns_cols'];
					}
					
					$data_value = implode("-", $columns_cols);
				}
				
				$test .= getIndividoleOption("col_w").'_____'.$data_value;
				
				$data_value_array = explode("-", $data_value);
				$cols = array();
				foreach($data_value_array AS $col) {
					$cols[] = ($col * getIndividoleOption("col_w")) + (($col - 1) * getIndividoleOption("col_gap"));
				}
				
				$new_value = implode("-", $cols);
				
			} else if($data_type == "image") {
				$image_data = wp_get_attachment_image_src($data_value, 'full');
				$new_value = $image_data[0];
				
			} else {
				$new_value = $data_value;
			}
			
			$new_values[] = stripslashes(do_shortcode($new_value));
			
			
			
			//!CHECK, if field/content exists
			$check = false;
			switch($data_field) {
			    case "post_title":
			    	$check = get_the_title($post_id);
			    	break;
			    	
			    case "post_date":
			    	$check = get_the_time('Y-m-d H:i', $post_id);
			    	break;
			    	
			    case "post_status":
			    	$check = get_post_status($post_id);
			    	break;
			    	
			    default:
			    	$check = get_post_meta($post_id, $data_field, true);
			    	break;
			}
			
			
			$test .= '<p>START<br>$data_field:'.$data_field.'<br>$data_type:'.$data_type.'<br>$data_value:'.$data_value.'<br>$check:'.$check;
			
			
			if($check !== false) {
			    if(contains($data_field, 'config_base') && contains($data_field, '0_top')) {
			    	$new_gap_top = $data_value;
			    }
			    
			    if(contains($data_field, 'config_base') && contains($data_field, '0_bottom')) {
			    	$new_gap_bottom = $data_value;
			    }
			    
			    if(contains($data_field, 'config_base') && contains($data_field, '0_innertop')) {
			    	$new_gap_innertop = $data_value;
			    }
			    
			    if(contains($data_field, 'config_base') && contains($data_field, '0_innerbottom')) {
			    	$new_gap_innerbottom = $data_value;
			    }
			    
			    //!SET standard values from wp-posts-table
			    $update_type = 'post_meta';
			    if($data_field == "post_title") {
			    	$update_type = 'standard';
			    	$my_post['post_title'] = $data_value;
			    
			    }
			    
			    if($data_field == "post_date") {
			    	$update_type = 'standard';
			    	$my_post['post_date'] = $data_value;
			    
			    }
			    
			    if($data_field == "post_status") {
			    	$update_type = 'standard';
			    	$my_post['post_status'] = $data_value;
			    
			    }
			    
			    if($update_type == "standard") {
			    	$success = wp_update_post( $my_post );
			    	
			    	$test .= 'STANDARD';
			    	
			    } else {
			    	$success = wp_update_post(array(
			    		'ID' 					=> $post_id,
			    		'post_modified_gmt' 	=> date("Y-m-d H:i:s"),
			    	));
			    	
			    	update_post_meta($post_id, $data_field, $data_value);
			    	add_post_meta($post_id, '_'.$data_field, $data_field_key, true);
				    
			    	if($data_cpt_key != "") {
				    	update_post_meta($post_id, '_'.$data_field, $data_cpt_key);
			    	}
			    	
			    	if($data_repeater != "") {
				    	$q = '
				    	SELECT
				    		meta_id
				    	FROM 
				    		'.$wpdb->prefix.'postmeta
				    	WHERE
				    		post_id = '.$post_id.'
				    		AND meta_key LIKE "'.$data_repeater.'_%"
				    	';
				    	$result = mysql_query($q);
				    	$count_repeater = mysql_num_rows($result);
				    	
				    	update_post_meta($post_id, $data_repeater, $count_repeater);
			    	}
			    	
			    	$test .= 'UPDATEPOSTMETA';
			    	
			    	$test .= '.post-id:'.$post_id.'/datafieldkey:'.$data_field_key.'/datafield:'.$data_field.'/value:'.$data_value;
			    	
			    	//UPDATEPOSTMETA1715---artikel_links_0_map_filter_0_label---3220
			    }
			}
			
			++$i;
		}
		
		//if($type == "none") {
		//	$success = 1;
		//}
		
		echo '|||'.$success.'|||'.implode("######", $new_values).'|||'.implode("######", $new_types).'|||'.$new_gap_top.'|||'.$new_gap_bottom.'|||'.$new_gap_innertop.'|||'.$new_gap_innerbottom.'|||'.$test;
	}
}

?>