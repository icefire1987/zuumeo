<?php

add_action( 'init', 'createCustomPostTypes', 10, 10);

function createCustomPostTypes() {	
	global $polylang;
	global $config_cpt;
	
	
	//debug($config_cpt);
	
	
	//!REGISTER post types
	$i = 0;
	foreach($config_cpt AS $cpt => $v) {
		if($v['register'] == true) {
			//debug($v);
			
			$cpt_slug = $cpt;
			if(isset($v['slug']) && $v['slug'] != "") {
				$cpt_slug = $v['slug'];
			}
			  
			$array = array(
				'hierarchical'		=> $v['hierarchical'],
				'labels' 			=> array(
					'name' 				=> __($v['name']),
					'singular_name' 	=> __($v['singular_name']),
					'add_new' 			=> __($v['button_label']),
				),
				'rewrite'			=> array(
					'slug'		 	=> $cpt_slug,
					'with_front'	=> $v['with_front'],
					'hierarchical'	=> $v['hierarchical'],
				),
				'_builtin' 			=> false,
				'query_var' 		=> true,
				'capability_type'	=> $v['capability_type'],
				'show_in_nav_menus'	=> $v['show_in_nav_menus'],
				'public' 			=> true,
				'supports' 			=> $v['supports'],
				'has_archive' 		=> false,
				'show_ui' 			=> true,
			);
			
			//debug($v);
			//debug($array);
			
			register_post_type($cpt, $array);
			
			//add_action('_admin_menu', 'custom_posttype_submenu_'.$cpt);
			//
			//eval('function custom_posttype_submenu_'.$cpt.'() {
			//	echo "'.$cpt.'";
			//	add_submenu_page( "edit.php?post_type='.$cpt.'", "drafts", "drafts", "edit_posts", "edit.php?post_type='.$cpt.'&post_status=draft");
			//	}'
			//);
		}
		
		
		if(is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == $cpt) {
			if($v['orderby'] == 'post_title') {
				add_filter('posts_orderby', 'orderby_post_title_int' );
			}
			
			if($v['capability_type'] == 'page') {
				add_action("manage_pages_custom_column", "my_custom_columns"); 
				
			} else {
				add_action("manage_posts_custom_column", "my_custom_columns"); 
			}
		}
		
		
		
		if((!isPolylang() || isPosttypePolylang($cpt)) && isset($v['my_show_in_nav_menus']) && $v['my_show_in_nav_menus'] == true) {
			add_action('admin_head-nav-menus.php', 'custom_admin_metabox_'.$cpt);
			
			eval('function custom_admin_metabox_'.$cpt.'() {
				add_meta_box(
				   "info_meta_box_'.$cpt.'"
				   ,__( "'.$v['name'].'" )
				   ,"renderCustomMetaboxPages"
				   ,"nav-menus"
				   ,"side"
				   ,"high"
				   ,array(
				   		"post_type"		=> "'.$cpt.'",
				   		"orderby"		=> "'.$v['orderby'].'",
				   		"order"			=> "'.$v['direction'].'",
				   		"hierarchical"	=> "'.$v['hierarchical'].'",
				   )
				);
			}');
			
			
		}
		
		if(isset($_GET['post_type']) && $_GET['post_type'] == $cpt) {
			//!-> SET COLUMNS
			$final_cpt_columns = '';
			
			if(!empty($config_cpt[$_GET['post_type']]['columns'])) {
			    $columns = $config_cpt[$_GET['post_type']]['columns'];
			    //debug($columns);
			    
			    foreach($columns AS $cpt_column_key => $cpt_column_value) {
			    	$final_cpt_columns .= '"'.$cpt_column_key.'" => "'.$cpt_column_value['head'].'",';
			    }
			} else {
			    $final_cpt_columns .= '"title" => "Titel",';
			}
			
			
			
			//!---> languages
			$final_cpt_columns_current_language = '';
			$final_cpt_columns_languages = '';
			if(isPosttypePolylang($cpt)) {
			    $final_cpt_columns_current_language .= '"language" => "",';
			    
			    foreach($polylang->model->get_languages_list() AS $language) {
			    	$final_cpt_columns_languages .= '"language_'.$language->slug.'" => "<img src=\"'.get_stylesheet_directory_uri().'/_images/_flags/'.$language->slug.'.png\" />",';
			    }
			}
			
			if(!function_exists('my_'.$cpt.'_columns')) {
				add_filter('manage_edit-'.$cpt.'_columns', 'my_'.$cpt.'_columns');
				eval('function my_'.$cpt.'_columns($columns) {
					$array = array(
						"cb" 			=> "<input type=\"checkbox\" />",
						'.$final_cpt_columns_current_language.'
						'.$final_cpt_columns.'
						'.$final_cpt_columns_languages.'
						"id" 			=> "ID",
					);
			
					//debug($array);
					
					return $array;
				}');
			}
			
			//debug($v);
			
			if(!function_exists('my_'.$cpt.'_columns_admin_order')) {
				add_filter('pre_get_posts', 'my_'.$cpt.'_columns_admin_order');
				eval('function my_'.$cpt.'_columns_admin_order() {
					global $config_cpt;
					global $wp_query;
					
					$v = $config_cpt["'.$cpt.'"];
					
					$wp_query->query_vars["order"] = $v["direction"];
					
					if($v["ordermeta"] == true) {
					    $wp_query->query_vars["orderby"] = "meta_value";
					    $wp_query->query_vars["meta_key"] = $v["orderby"];
					    
					} else {
					    $wp_query->query_vars["orderby"] = $v["orderby"];
					}
				}');
			}
		}
		
		if($v['submenu'] === true) {			
			$submenu_orderby 		= $v['orderby'];
			$submenu_ordermeta 	= $v['ordermeta'];
			$submenu_order 		= $v['direction'];
			$submenu_limit 		= $v['limit'];
			
			//echo '$submenu_orderby:'.$submenu_orderby;
			
			($submenu_orderby == "") 		? $submenu_orderby 		= "menu_order" 	: "";
			($submenu_ordermeta == "") 	? $submenu_ordermeta 	= 0 			: "";
			($submenu_order == "") 		? $submenu_order 		= "ASC" 		: "";
			($submenu_limit == 0) 		? $submenu_limit 		= 99999999999	: "";
			
			($submenu_orderby == "title") ? $submenu_orderby = 'post_title' : '';
			
			$q_orderby = 't1.'.$submenu_orderby;
			$q_where = '';
			if($submenu_ordermeta == 1) {
			    $q_orderby = 't2.meta_value';
			    $q_where = 'AND t2.meta_key = \''.$submenu_orderby.'\'';
			}
			
			add_action('_admin_menu', 'custom_admin_submenus_'.$cpt);
			
			eval('function custom_admin_submenus_'.$cpt.'() {
			global $polylang;
			
			$q = "
			    SELECT 
			    	t1.*
			    FROM 
			    	'.TABLE_PREFIX.'posts AS t1
			    LEFT JOIN
			    	'.TABLE_PREFIX.'postmeta AS t2
			    ON
			    	(t1.ID = t2.post_id)
			    WHERE 
			    	1=1 
			    	AND t1.post_type = \''.$cpt.'\' 
			    	AND (t1.post_status = \'publish\' 
			    		OR t1.post_status = \'future\' 
			    		OR t1.post_status = \'draft\' 
			    		OR t1.post_status = \'pending\' 
			    		OR t1.post_status = \'private\') 
			    	'.$q_where.'
			    GROUP BY
			    	t1.ID
			    ORDER BY 
			    	'.$q_orderby.' '.$submenu_order.'
			    
			    LIMIT
			    	'.$submenu_limit.'
			";
			$result = mysql_query($q);
			//$count = mysql_num_rows($result);
			
			//echo "<p>'.$submenu_ordermeta.'_".$q;
			
			//debug($result);
			    
			$submenu_i = 0;
			
			if($result) {
			  	if(isPosttypePolylang("'.$cpt.'")) {
			  	    foreach($polylang->model->get_languages_list() AS $language) {
			  	    	$rows[$language->slug] = array();
			  	    }
			  	    
			  	} else {
			  	    $rows = array();
			  	}
			  	
			  	while($row = mysql_fetch_array($result)) {
			  	    $submenu_post_id 			= $row["ID"];
			  	    
			  	    
			  	    
			  	    if(isPosttypePolylang("'.$cpt.'") && isset($polylang->model->get_post_language($submenu_post_id)->slug)) {
			  	    	$submenu_post_lang 			= $polylang->model->get_post_language($submenu_post_id)->slug;
			  	    	
			  	    	$rows[$submenu_post_lang][] = $submenu_post_id;
			  	    
			  	    } else {
			  	    	$rows[] = $submenu_post_id;
			  	    }
			  	}
			  	
			  	//echo "'.$cpt.'";
			  	//debug($rows);
			  	
			  	
			  	if(isPosttypePolylang("'.$cpt.'")) {
			  	    $final_rows = array();
			  	    foreach($polylang->model->get_languages_list() AS $language) {
			  	    	//debug($rows[$language->slug]);
			  	    	
			  	    	$final_rows = array_merge($final_rows, $rows[$language->slug]);
			  	    }
			  	    
			  	} else {
			  	    $final_rows = $rows;
			  	}
			  		
			  	//debug($final_rows);
			  	
			  	foreach($final_rows AS $cptey => $submenu_post_id) { 
			  	    //echo "<p>".$submenu_post_id." - ".get_the_title($submenu_post_id);
			  	    
			  	    $submenu_post 				= get_post($submenu_post_id);
			  	    $submenu_title 				= get_the_title($submenu_post_id);
			  	    $submenu_menu_order			= $submenu_post->menu_order;
			  	    
			  	    $submenu_post_lang 			= "";
			  	    if(isPosttypePolylang("'.$cpt.'")) {
			  	    	if(isset($polylang->model->get_post_language($submenu_post_id)->slug)) {
			  	    		$submenu_post_lang 			= $polylang->model->get_post_language($submenu_post_id)->slug;
			  	    	} else {
			  	    		$submenu_post_lang = "de";
			  	    	}
			  	    }
			  	    
			  	    $submenu_output_front = "&nbsp;&nbsp;&nbsp; ";
			  	    if($submenu_post_lang != "") {
			  	    	$submenu_output_front = "<img src=\''.get_stylesheet_directory_uri().'/_images/_flags/".$submenu_post_lang.".png\' style=\'float:left; padding:1px 5px 0px 0px;\' />";
			  	    }
			  	    
			  	    $level 			= getDepthCustomPostType($submenu_post_id);
			  	    if($level == 1) {
			  	    	$submenu_title = "&rarr; ".$submenu_title;
			  	    } else if($level == 2) {
			  	    	$submenu_title = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr; ".$submenu_title;
			  	    } else if($level == 3) {
			  	    	$submenu_title = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr; ".$submenu_title;
			  	    }
				
			  	    $submenu_output = $submenu_output_front.$submenu_title." (".$submenu_post_id.")";
			  	    
			  	    add_submenu_page( "edit.php?post_type='.$cpt.'", $submenu_output, $submenu_output, "edit_posts", "post.php?post=$submenu_post_id&action=edit");
			  	    
			  	    ++$submenu_i;
			  	}
			 }
		}');
		
		}
		
		++$i;	
	}
}

?>