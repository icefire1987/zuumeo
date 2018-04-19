<?php

function individole_sort_posts() {
	global $polylang;
	global $config_cpt;
	global $current_user;
	$allcaps = $current_user->allcaps;
	
	if(isset($_GET['cpt'])) {
		$cpt = $_GET['cpt'];
	} else {
		$cpt = "page";
	}
	
	$my_languages = array();
	$my_languages_names = array();
	if(isPolylang() && pll_is_translated_post_type($cpt)) {
		foreach($polylang->model->get_languages_list() AS $language) {
			$my_languages[] = $language->slug;
			$my_languages_names[$language->slug] = $language->name;
		}
	} else {
		$my_languages = array("de");
		$my_languages_names = array("Deutsch");
	}
	
	
	//debug($config_cpt);
	
	$config_cpt = sortArrayByKey($config_cpt, 'name', true);
	
	$i = 0;
	$buttons = array();
	foreach($config_cpt AS $k => $v) {
		if($v['orderby'] == "menu_order") {
			$btn_class = '';
			if($cpt == $k) {
				$btn_class = 'active';
			}
			
			$buttons[] = '<a href="/wp-admin/admin.php?page=individole-sort_posts&cpt='.$k.'" class="button '.$btn_class.'" style="margin: 0px 5px 5px 0px;">'.$v['name'].'</a>';
		}
	}
	
	
	$c = $config_cpt[$cpt];
	
	if(isPolylang() && pll_is_translated_post_type($cpt)) {
		foreach($my_languages AS $lang) {
			$rows[$lang] = "";
			
			$loop_args = array( 
			    'post_type' 		=> $cpt, 
			    'posts_per_page' 	=> $c['dashboard_limit'],
			    'orderby'			=> $c['orderby'],
			    'order'				=> $c['direction'],
			    'lang' 				=> $lang,
			    'post_parent'		=> 0,
			    'post_status'		=> array('publish', 'pending', 'draft'),
			);
			
			
			if($c['ordermeta'] == 1) {
				$loop_args['orderby'] = 'meta_value';
				$loop_args['meta_key'] = $c['orderby'];
			}
			
			//debug($loop_args);
			
			$loop = new WP_Query( $loop_args );
			
			//debug($loop);
			
			$temp = array();
			$i = 0;
			while ( $loop->have_posts() ) : $loop->the_post();
				$post_id 		= get_the_ID();
				
				$post			= get_post($post_id);
				$title 			= get_the_title($post_id);
				$post_status	= get_post_status($post_id);
				
				$drag_table_col = '';
				if($c['orderby'] == "menu_order") {
					//$drag_table_col = '<td class="drag"><img src="'.get_stylesheet_directory_uri().'/_images/drag.gif" /></td>';
				}
				
				$lang_table_col = '';
				$edit_l = array();
				
			   	$post_lang 			= "";
				if(isset($polylang->model->get_post_language($post_id)->slug)) {
				   	$post_lang = '<img src="'.get_stylesheet_directory_uri().'/_images/_flags/'.$polylang->model->get_post_language($post_id)->slug.'.png" style="height:14px; float:left; padding: 0px 7px 0px 0px;" />';
				}
				    
				foreach($polylang->model->get_languages_list() AS $language) {
			   	    //if($lang != $language->slug) {
			   	    
			   	    	$post_id_l 		= (int)pll_get_post($post_id, $language->slug);   
			   	    	$post_id_l_status = get_post_status($post_id_l);
			   	    	
			   	    	if($post_id_l > 0 && ($post_id_l_status == 'publish' || $post_id_l_status == 'pending' || $post_id_l_status == 'draft')) {	   		
			   	    		$l_link = '<a href="/wp-admin/post.php?post='.$post_id_l.'&action=edit">Edit</a>';
			   	    	} else {
			       			$l_link = '<a href="/wp-admin/post-new.php?post_type='.$cpt.'&from_post='.$post_id.'&new_lang='.$language->slug.'">+</a>';
			   	    	}
			   	    	
			   	    	$edit_l[] = '<td align="center" style="text-align:center;">'.$l_link.'</td>';
			   	    //}
			   	}
			   	
			   	$final_children = '';
				if($c['hierarchical'] == true) {
					$children 		= get_children(array(
		    			'post_type' 	=> $cpt,
						'post_parent' 	=> $post_id,
						'orderby' 		=> 'menu_order',
						'order' 		=> 'ASC',
					));
		    		
					if(!empty($children)) {
					    $children_rows = array();
					    $i_child = 0;
					    foreach($children AS $child_key => $child_value) {
					    	$child_children = get_children(array(
					    		'post_type' 	=> $cpt,
					    		'post_parent' 	=> $child_value->ID,
					    		'orderby' 		=> $c['orderby'],
					    		'order' 		=> $c['direction'],
					    	));
					    	
					    	$final_child_children = '';
					    	if(!empty($child_children)) {
					    		//debug($child_children);
					    		$child_children_rows = array();
					        	foreach($child_children AS $child_child_key => $child_child_value) {
					        		$child_children_rows[] = '
					        			<tr id="post-'.$child_child_value->ID.'">
					        			    <td class="drag">'.$child_child_value->ID.'</td>
					        			    <td style="width:100%;"><a href="/wp-admin/post.php?post='.$child_child_value->ID.'&action=edit">'.$child_child_value->post_title.'</a></td>
					        			</tr>
					        		';
					        	}
					        	
					        	$final_child_children = '
					        		<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
					        			'.implode("", $child_children_rows).'
					        		</table>
					        	';
					        		
					        }
					    	
					    	$children_post_lang 			= "";
							if(isset($polylang->model->get_post_language($child_value->ID)->slug)) {
								$children_post_lang = '<img src="'.get_stylesheet_directory_uri().'/_images/_flags/'.$polylang->model->get_post_language($child_value->ID)->slug.'.png" style="height:14px; float:left; padding: 0px 7px 0px 0px;" />';
							}
							
							$class = '';
							if($i_child%2 == 0) {
							    $class = 'alternate';
							}
							
					    	$children_rows[] = '
					    		<tr id="post-'.$child_value->ID.'" class="'.$class.'">
					    			<td class="drag" style="width: 35px;">'.$child_value->ID.'</td>
					    			<td><a href="/wp-admin/post.php?post='.$child_value->ID.'&action=edit">'.$children_post_lang.$child_value->post_title.'</a>'.$final_child_children.'</td>
					    		</tr>
					    	';
					    	
					    	++$i_child;
					    }
					    
					    
					    
					    $final_children = '
					    	<table id="'.$drag_table_id.'" class="wp-list-table widefat fixed posts sortable_table" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
					    		'.implode("", $children_rows).'
					    	</table>
					    ';
					}
				}
				
				$style_draft = '';
				if($post_status != "publish") {
					$style_draft = 'opacity:0.3;';
				}
				
				
				//'.implode("", $edit_l).'
				
				$class = '';
				if($i%2 == 0) {
				    $class = 'alternate';
				}
				
				$rows[$lang] .= '
					<tr id="post-'.$post_id.'" class="'.$class.'">
						'.$drag_table_col.'
						<td class="drag">'.$post_id.'</td>
						<td '.$style_draft.'"><a href="/wp-admin/post.php?post='.$post_id.'&action=edit">'.$post_lang.$title.'</a>'.$final_children.'</td>
						
					</tr>
				';
				
				++$i;
			endwhile;
		}
	
		$final_tables = array();
		foreach($my_languages AS $lang) {
		    $row_lang_title = '';
		    if(isPolylang()) {
		    	$row_lang_title = '
		    		<tr>
		    			<th colspan="100" class="th2">'.strtoupper($my_languages_names[$lang]).'</th>
		    		</tr>
		    	';
		    }
		    
		    //'.implode("", $th_languages).'
		    
		    $final_tables[] = '
		    	<div style="float:left; width: 350px; margin: 0px 12px 0px 0px;">
		    		<table id="sortable_table_'.$lang.'" class="wp-list-table widefat fixed posts sortable_table" cellpadding="0" border="0">
		    			<thead>
		    				<tr>
							    <th style="width: 50px;">ID</th>
							    <th>Titel</th>
							    
							</tr>
						</thead>
						<tbody>
							'.$rows[$lang].'
						</tbody>
					</table>
				</div>
		    ';
		}
		
		$final_tables = implode("", $final_tables);
	
	
	} else {
		$rows = array();
		
		$drag_table_id = '';
		$drag_table_col = '';
		if($c['orderby'] == "menu_order") {
		    $drag_table_id = 'sortable-table';
		    //$drag_table_col = '<th class="th1"></th>';
		}
			    	
		$loop_args = array( 
		    'post_type' 		=> $cpt, 
			'posts_per_page' 	=> $c['dashboard_limit'],
			'orderby'			=> $c['orderby'],
			'order'				=> $c['direction'],
			'post_parent'		=> 0,
		);
		
		if($c['ordermeta'] == true) {
		    $loop_args['orderby'] = 'meta_value';
		    $loop_args['meta_key'] = $c['orderby'];
		}
			
		//debug($loop_args);
			
		$loop = new WP_Query( $loop_args );
		$temp = array();
		$i = 0;
		while ( $loop->have_posts() ) : $loop->the_post();
		    $post_id 		= get_the_ID();
				
			$post			= get_post($post_id);
			$title 			= get_the_title();
		    $children 		= get_children(array(
		    	'post_type' 	=> $cpt,
		    	'post_parent' 	=> $post_id,
		    	'orderby' 		=> 'menu_order',
		    	'order' 		=> 'ASC',
		    ));
		    
		    $final_children = '';
		    if(!empty($children)) {
			    $children_rows = array();
			    foreach($children AS $child_key => $child_value) {
			    	$child_children = get_children(array(
			    		'post_type' 	=> $cpt,
			    		'post_parent' 	=> $child_value->ID,
			    		'orderby' 		=> $c['orderby'],
			    		'order' 		=> $c['direction'],
			    	));
			    	
			    	$final_child_children = '';
			    	if(!empty($child_children)) {
			    		//debug($child_children);
			    		$child_children_rows = array();
				    	foreach($child_children AS $child_child_key => $child_child_value) {
				    		$child_children_rows[] = '
				    			<tr id="post-'.$child_child_value->ID.'">
				    			    <td class="drag">'.$child_child_value->ID.'</td>
				    			    <td style="width:100%;"><a href="/wp-admin/post.php?post='.$child_child_value->ID.'&action=edit">'.$child_child_value->post_title.'</a></td>
				    			</tr>
				    		';
				    	}
				    	
				    	$final_child_children = '
				    		<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
				    			'.implode("", $child_children_rows).'
				    		</table>
				    	';
				    		
				    }
			    	
			    	$children_rows[] = '
			    		<tr id="post-'.$child_value->ID.'">
		    				<td class="drag">'.$child_value->ID.'</td>
		    				<td style="width:100%;"><a href="/wp-admin/post.php?post='.$child_value->ID.'&action=edit">'.$child_value->post_title.'</a>'.$final_child_children.'</td>
		    			</tr>
			    	';
			    }
			    
			    
			    
			    $final_children = '
			    	<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
			    		'.implode("", $children_rows).'
			    	</table>
			    ';
		    }
		    
		    $class = '';
			if($i%2 == 0) {
			    $class = 'alternate';
			}
		    
		    $rows[] = '
		    	<tr id="post-'.$post_id.'" class="'.$class.'">
		    		<td class="drag">'.$post_id.'</td>
		    		<td><a href="/wp-admin/post.php?post='.$post_id.'&action=edit">'.$title.'</a>'.$final_children.'</td>
		    	</tr>
		    ';
		    
		    ++$i;
		endwhile;
		
		
		
		if($c['add_new'] === true) {
		    $btn_add_new[] = '<a href="/wp-admin/post-new.php?post_type='.$cpt.'" class="button acf-button left" style="margin-right:5px;">+ Neu</a>';
		}
		
		$final_tables = '
		    <table id="" class="wp-list-table widefat fixed posts sortable_table" cellpadding="0" cellspacing="0" border="0">
		    	<thead>
		    		<tr>
						<th style="width:50px;">ID</th>
						<th>Titel</th>
					</tr>
				</thead>
				<tbody>
					'.implode("", $rows).'
				</tbody>
			</table>
		';
		
		$lang_table_col = '';
		$th_languages = array();
	}
	
	$return = '
		<div class="wrap">
			<div id="icon-tools" class="icon32"><br></div>
			<h2>Individol&eacute; / Posts sortieren</h2>
			'.individole_menu().'
			'.implode("", $buttons).'
			'.clearer(15).'
			<h2>'.$c['name'].'</h2>
			'.clearer(5).'
			'.$final_tables.'
			'.clearer().'
		</div>
	';
	
	echo $return;
}

?>