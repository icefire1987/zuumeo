<?php


function my_custom_columns($column) {
	createCustomColumn($column);
}


$i_columns = 0;

function createCustomColumn($column) {	
	//echo 'xxxxx';
	
	global $post;
	global $wpdb;
	global $i_columns;
	global $polylang;
	
	$post_id = $post->ID;
	$post_date = $post->post_date;
	
	$width = $standard_width = 100;
	
	
	if(isset($_POST['post_type'])) {
		$post_id = $_POST['ID'];
		$post_type = $_POST['post_type'];
		
	} else if(isset($_GET['post_type'])) {
		$post_type = $_GET['post_type'];
	}
	
	//debug($_POST);
	
	global $config_cpt;
	
	$c = $config_cpt[$post_type];
	
	//debug($c);
	
	$columns = explode("--", $column);
	
	
	//echo '<p>$column:'.$column;
	
	$cpt_lang = 0;
	if(isPosttypePolylang($post_type)) {
	    $cpt_lang = 1;
	}
	
	
	$return = array();
	$image_css = array();
	$config = array();
	$i_col = 1;
	$output = array();
	foreach($columns AS $col) {
		$is_date = 0;
		$is_image = 0;
		$is_num = 0;
		
		foreach($c['columns'] AS $cpt_column_key => $cpt_column_value){
		    //debug($cpt_column_value);
		    
		    $temp_variables 	= explode("--", $cpt_column_key);
		    $temp_formats 		= explode(",", @$cpt_column_value['formats']);
		    $temp_titles		= explode(",", @$cpt_column_value['titles']);
		    $temp_output		= @$cpt_column_value['output'];
		    
		    $temp_width 		= 100;
		    if(isset($cpt_column_value['width'])) {
				$temp_width 	= $cpt_column_value['width']; 
		    }
		    
		    //debug($temp_variables);
		    
		    $i = 0;
		    foreach($temp_variables AS $temp_variable) {
		    	$config[$temp_variable] = array(
		    		'format' 	=> @$temp_formats[$i],
		    		'title' 	=> @$temp_titles[$i],
		    		'output' 	=> @$temp_output,
		    		'width' 	=> @$temp_width,
		    	);
		    	
		    	++$i;
		    }
		}
		
		//debug($config);
		
		
		//add_action('quick_edit_custom_box',  'add_quick_edit', 10, 2);
		//do_action('quick_edit_custom_box', 1, 'xxxxxx'.$column_var);
		
		
		
		$temp_value = get_post_meta($post_id, trim($col), true);
		
		
		
		
		//echo $col;
		//debug($c['columns'][$col]);
		
		//echo '<p>$col:'.$col.'___'.$post_id.'___'.$temp_value;
		
		
		$f = "";
		$t = "";
			
		if(isset($config[$col])) {
			$format = explode(",", $config[$col]['format']);
			$titles = explode(",", $config[$col]['title']);
			$f = trim($format[0]);
			$t = trim($titles[0]);
		}
		
		//debug($titles);
		
		if(isset($config[$col]['width']) && $config[$col]['width'] > 0) {
			$width = $config[$col]['width'];
		}
		
		if($col == "id") {
			$temp_value = $post_id;
		
		} elseif ($col == "language" && isPolylang() && pll_is_translated_post_type($post_type)) {
		    $terms = get_the_terms($post_id , $col);
		    
		    //debug($terms);
		    
		    foreach ( $terms as $term ) {
		    	$temp_value = createAdminFlag($term->slug);
		    	
		    	break;
		    }
		    	
		} else if ($f == "date") {
			$temp_value = get_the_date('d.m.y', $post_id);  
		
		} else if($f == "file") {
			$temp_value = wp_get_attachment_url($temp_value);
			
		} else if($f == "image") {
			$image_src = wp_get_attachment_image_src($temp_value, 'thumbnail');
			$temp_value = '<img src="'.$image_src[0].'" style="width: '.$width.'px; background-color:#cccccc;" />';
		
		} else if($f == "gallery") {
			if(isset($temp_value[0]) && $temp_value[0] > 0) {
				$image_src = wp_get_attachment_image_src($temp_value[0], 'thumbnail');
				$temp_value = '<img src="'.$image_src[0].'" style="height: 50px;" />';
			} else {
				$temp_value = '-';
			}
		
		} else if (startsWith($f, "excerpt")) {
			$words = explode("_", $f);
			if(isset($words[1])) {
				$words = $words[1];
			} else {
				$words = 2;
			}
			
			$temp_value = getExcerpt(array(
				'text'		=> $temp_value,
				'words'		=> $words,
			));
		
		} else if ($f == "color") {
			$temp_value = '<span style="color:'.$temp_value.';">'.$temp_value.'</span>';
		
		} else if ($f == "title" && is_numeric($temp_value) && $temp_value > 0) {
			$temp_post_parent = get_post($temp_value);
			$temp_post_parent = $temp_post_parent->post_parent;
			
			if($temp_post_parent > 0) {
				$temp_value = get_the_title($temp_post_parent).' &raquo; '.get_the_title($temp_value);
			} else {
				$temp_value = get_the_title($temp_value);
			}
			
		} else if ($f == "page") {
			$temp_value = get_permalink($post_id);
			$temp_value = '...'.str_replace(array("http://", $_SERVER['HTTP_HOST']), "", $temp_value);
			
		} else if ($f == "true_false") {
			if($temp_value != 0) {
				$temp_value = '<img src="'.get_stylesheet_directory_uri().'/_backend/_images/ja.png" />';
			} else {
				$temp_value = '<img src="'.get_stylesheet_directory_uri().'/_backend/_images/nein.png" />';
			}
			
		} else if ($f == "repeater") {
			$temp_value = get_field(trim($col), $post_id);
			
			if(!empty($temp_value)) {
				if(isset($config[$col]['output'])) {
					$temp_values = array();
					foreach($temp_value AS $k => $v) {
						//debug($v);
						
						$temp_values_2 = array();
						foreach($config[$col]['output'] AS $k2) {
							$v2 = explode("#", $k2);
							$v3 = explode("->", $v2[0]);
							
							//debug($v2);
							//debug($v3);
							
							if($v3[0] != "") {
								//echo $v3[0];
								
								if(is_object($v[$v3[0]]) && isset($v3[1])) {
									$v_value = $v[$v3[0]]->$v3[1];
									
									if(isset($v2[1])) {
										if($v2[1] == 'post_title') {
											$v_value = get_the_title($v_value);
										}
									}
									
									$temp_values_2[] = $v_value;
								
								} else {
									if($v[$v3[0]] != "") {
										$temp_values_2[] = $v[$v3[0]];
									}
								}
								
								//
								//
								//$temp_values_2[] = $v2[0];
							}
						}
							
						$temp_values[] = '<li>'.implode(", ", $temp_values_2).'</li>';
					}
					
					$temp_value = '
						<ul class="admin_tablecolumn_repeater">
							'.implode("", $temp_values).'
						</ul>
					';
					
				} else {
					$temp_value = 'missing configuration';
				}
				
			} else {
				$temp_value = '&mdash;';
			}
			
			
		} else if ($f == "permalink" && $temp_value != "") {
			if($temp_value > 0) {
				$temp_value = get_permalink($temp_value);
			} else {
				$temp_value = '';
			}
		
		} else if ($f == "comments") {
			$temp_value = get_comments_number($post_id);
		
		}
		
		//$temp_value = 'xxx'.$config[$col]['width'].'xxx'.$temp_value;
		
		
		$column_title = '';
		if(isset($t) && $t != "") {
			$output[] = '<b>'.$t.':</b>&nbsp;'.$temp_value;
		
		} else {
			$output[] = $temp_value;
		}
		
		$nostyle = array('language', 'id');
		
		if ($col == "id") {
		    $image_css[] = '.column-'.$col.' { width:50px; }';
		
		} else if ($col == "language") {
		    $image_css[] = '.column-'.$col.' { width:15px; }';
		
		} else if ($col == "title") {
		    $image_css[] = '';
		
		} else {
		    $image_css[] = '.column-'.$column.' { width:'.$width.'px; }';
		}
	}
	
	echo '<style>'.implode("", $image_css).'</style>'.implode("<br>", $output);
	
	++$i_columns;
}

?>