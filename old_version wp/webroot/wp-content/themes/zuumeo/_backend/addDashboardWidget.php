<?php

function addDashboardWidget($function, $lang="") {
	call_user_func('dashboard_'.$function);
	
	return false;
	
	//global $polylang;
	//global $config_cpt;
	//
	//$c = $config_cpt[$cpt];
	//
	////debug($c);	
	//
	//$my_languages = array();
	//$my_languages_names = array();
	//if(isPolylang() && pll_is_translated_post_type($cpt)) {
	//	foreach($polylang->model->get_languages_list() AS $language) {
	//		$my_languages[] = $language->slug;
	//		$my_languages_names[$language->slug] = $language->name;
	//	}
	//} else {
	//	$my_languages = array("de");
	//	$my_languages_names = array("Deutsch");
	//}
	//
	//
	//$return = array();
	//$btn_add_new 	= array();
	//
	//$drag_table_id = '';
	//
	//if(isPolylang() && pll_is_translated_post_type($cpt)) {
	//	foreach($my_languages AS $lang) {
	//		$rows[$lang] = "";
	//		
	//		$loop_args = array( 
	//		    'post_type' 		=> $cpt, 
	//		    'posts_per_page' 	=> $c['dashboard_limit'],
	//		    'orderby'			=> $c['orderby'],
	//		    'order'				=> $c['direction'],
	//		    'lang' 				=> $lang,
	//		    'post_parent'		=> 0,
	//		    'post_status'		=> array('publish', 'pending', 'draft'),
	//		);
	//		
	//		
	//		if($c['ordermeta'] == 1) {
	//			$loop_args['orderby'] = 'meta_value';
	//			$loop_args['meta_key'] = $c['orderby'];
	//		}
	//		
	//		//debug($loop_args);
	//		
	//		$loop = new WP_Query( $loop_args );
	//		
	//		//debug($loop);
	//		
	//		$temp = array();
	//		$i = 1;
	//		while ( $loop->have_posts() ) : $loop->the_post();
	//			$post_id 		= get_the_ID();
	//			
	//			$post			= get_post($post_id);
	//			$title 			= get_the_title($post_id);
	//			$post_status	= get_post_status($post_id);
	//			
	//			$drag_table_col = '';
	//			if($c['orderby'] == "menu_order") {
	//				//$drag_table_col = '<td class="drag"><img src="'.get_stylesheet_directory_uri().'/_images/drag.gif" /></td>';
	//			}
	//			
	//			$lang_table_col = '';
	//			$edit_l = array();
	//			
	//		   	$post_lang 			= "";
	//			if(isset($polylang->model->get_post_language($post_id)->slug)) {
	//			   	$post_lang = '<img src="'.get_stylesheet_directory_uri().'/_images/_flags/'.$polylang->model->get_post_language($post_id)->slug.'.png" style="height:14px; float:left; padding: 0px 7px 0px 0px;" />';
	//			}
	//			    
	//			foreach($polylang->model->get_languages_list() AS $language) {
	//		   	    //if($lang != $language->slug) {
	//		   	    
	//		   	    	$post_id_l 		= (int)pll_get_post($post_id, $language->slug);   
	//		   	    	$post_id_l_status = get_post_status($post_id_l);
	//		   	    	
	//		   	    	if($post_id_l > 0 && ($post_id_l_status == 'publish' || $post_id_l_status == 'pending' || $post_id_l_status == 'draft')) {	   		
	//		   	    		$l_link = '<a href="/wp-admin/post.php?post='.$post_id_l.'&action=edit">Edit</a>';
	//		   	    	} else {
	//		       			$l_link = '<a href="/wp-admin/post-new.php?post_type='.$cpt.'&from_post='.$post_id.'&new_lang='.$language->slug.'">+</a>';
	//		   	    	}
	//		   	    	
	//		   	    	$edit_l[] = '<td align="center" style="text-align:center;">'.$l_link.'</td>';
	//		   	    //}
	//		   	}
	//		   	
	//		   	$final_children = '';
	//			if($c['hierarchical'] == true) {
	//				$children 		= get_children(array(
	//	    			'post_type' 	=> $cpt,
	//					'post_parent' 	=> $post_id,
	//					'orderby' 		=> 'menu_order',
	//					'order' 		=> 'ASC',
	//				));
	//	    		
	//				if(!empty($children)) {
	//				    $children_rows = array();
	//				    foreach($children AS $child_key => $child_value) {
	//				    	$child_children = get_children(array(
	//				    		'post_type' 	=> $cpt,
	//				    		'post_parent' 	=> $child_value->ID,
	//				    		'orderby' 		=> $c['orderby'],
	//				    		'order' 		=> $c['direction'],
	//				    	));
	//				    	
	//				    	$final_child_children = '';
	//				    	if(!empty($child_children)) {
	//				    		//debug($child_children);
	//				    		$child_children_rows = array();
	//				        	foreach($child_children AS $child_child_key => $child_child_value) {
	//				        		$child_children_rows[] = '
	//				        			<tr id="post-'.$child_child_value->ID.'">
	//				        			    <td class="drag">'.$child_child_value->ID.'</td>
	//				        			    <td style="width:100%;"><a href="/wp-admin/post.php?post='.$child_child_value->ID.'&action=edit">'.$child_child_value->post_title.'</a></td>
	//				        			</tr>
	//				        		';
	//				        	}
	//				        	
	//				        	$final_child_children = '
	//				        		<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
	//				        			'.implode("", $child_children_rows).'
	//				        		</table>
	//				        	';
	//				        		
	//				        }
	//				    	
	//				    	$children_post_lang 			= "";
	//						if(isset($polylang->model->get_post_language($child_value->ID)->slug)) {
	//							$children_post_lang = '<img src="'.get_stylesheet_directory_uri().'/_images/_flags/'.$polylang->model->get_post_language($child_value->ID)->slug.'.png" style="height:14px; float:left; padding: 0px 7px 0px 0px;" />';
	//						}
	//			
	//				    	$children_rows[] = '
	//				    		<tr id="post-'.$child_value->ID.'">
	//				    			<td class="drag">'.$child_value->ID.'</td>
	//				    			<td style="width:100%;"><a href="/wp-admin/post.php?post='.$child_value->ID.'&action=edit">'.$children_post_lang.$child_value->post_title.'</a>'.$final_child_children.'</td>
	//				    		</tr>
	//				    	';
	//				    }
	//				    
	//				    
	//				    
	//				    $final_children = '
	//				    	<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
	//				    		'.implode("", $children_rows).'
	//				    	</table>
	//				    ';
	//				}
	//			}
	//			
	//			$style_draft = '';
	//			if($post_status != "publish") {
	//				$style_draft = 'opacity:0.3;';
	//			}
	//			
	//			$rows[$lang] .= '
	//				<tr id="post-'.$post_id.'">
	//					'.$drag_table_col.'
	//					<td class="drag">'.$post_id.'</td>
	//					<td style="width:100%; '.$style_draft.'"><a href="/wp-admin/post.php?post='.$post_id.'&action=edit">'.$post_lang.$title.'</a>'.$final_children.'</td>
	//					'.implode("", $edit_l).'
	//				</tr>
	//			';
	//			
	//			++$i;
	//		endwhile;
	//		
	//		
	//		$drag_table_id = '';
	//		$drag_table_col = '';
	//		if($c['orderby'] == "menu_order") {
	//			$drag_table_id = 'sortable-table';
	//			//$drag_table_col = '<th class="th1"></th>';
	//		}
	//		
	//		
	//		$lang_table_col = '';
	//		$th_languages = array();
	//		$lang_headline = '';
	//		if(isPolylang() && pll_is_translated_post_type($cpt)) {
	//			$lang_table_col = '<th class="th1" align="center"></th>';
	//			$lang_headline = '<h2 style="font-size: 15px; height: auto; line-height:1.0em; padding: 0px 0px 8px 0px;">'.strtoupper($my_languages_names[$lang]).'</h2>';
	//		 	
	//		 	foreach($polylang->model->get_languages_list() AS $language) {
	//		    	//if($lang != $language->slug) {
	//		    		$th_languages[] = '<th class="th1" align="center" style="text-align:center;">'.strtoupper($language->slug).'</th>';
	//		    	//}
	//		    }
	//		}
	//		
	//		
	//		if($c['add_new'] === true) {
	//			$btn_add_new_lang = '';
	//			if(isPolylang() && pll_is_translated_post_type($cpt)) {
	//				$btn_add_new_lang = '&new_lang='.$lang;
	//			}
	//			//'.$cpt_labels['add_new'].'
	//			$btn_add_new[] = '<a href="/wp-admin/post-new.php?post_type='.$cpt.$btn_add_new_lang.'" class="button acf-button left" style="margin-right:5px;">+ '.strtoupper($lang).'</a>';
	//		}
	//		
	//		
	//	}
	//
	//	$final_rows = array();
	//	foreach($my_languages AS $lang) {
	//	    $row_lang_title = '';
	//	    if(isPolylang()) {
	//	    	$row_lang_title = '
	//	    		<tr>
	//	    			<th colspan="100" class="th2">'.strtoupper($my_languages_names[$lang]).'</th>
	//	    		</tr>
	//	    	';
	//	    }
	//	    
	//	    $final_rows[] = '
	//	    	'.$row_lang_title.'
	//	    	'.$rows[$lang].'
	//	    ';
	//	}
	//
	//
	//} else {
	//	$rows = array();
	//	
	//	$drag_table_id = '';
	//	$drag_table_col = '';
	//	if($c['orderby'] == "menu_order") {
	//	    $drag_table_id = 'sortable-table';
	//	    //$drag_table_col = '<th class="th1"></th>';
	//	}
	//		    	
	//	$loop_args = array( 
	//	    'post_type' 		=> $cpt, 
	//		'posts_per_page' 	=> $c['dashboard_limit'],
	//		'orderby'			=> $c['orderby'],
	//		'order'				=> $c['direction'],
	//		'post_parent'		=> 0,
	//	);
	//	
	//	if($c['ordermeta'] == true) {
	//	    $loop_args['orderby'] = 'meta_value';
	//	    $loop_args['meta_key'] = $c['orderby'];
	//	}
	//		
	//	//debug($loop_args);
	//		
	//	$loop = new WP_Query( $loop_args );
	//	$temp = array();
	//	$i = 1;
	//	while ( $loop->have_posts() ) : $loop->the_post();
	//	    $post_id 		= get_the_ID();
	//			
	//		$post			= get_post($post_id);
	//		$title 			= get_the_title();
	//	    $children 		= get_children(array(
	//	    	'post_type' 	=> $cpt,
	//	    	'post_parent' 	=> $post_id,
	//	    	'orderby' 		=> 'menu_order',
	//	    	'order' 		=> 'ASC',
	//	    ));
	//	    
	//	    $final_children = '';
	//	    if(!empty($children)) {
	//		    $children_rows = array();
	//		    foreach($children AS $child_key => $child_value) {
	//		    	$child_children = get_children(array(
	//		    		'post_type' 	=> $cpt,
	//		    		'post_parent' 	=> $child_value->ID,
	//		    		'orderby' 		=> $c['orderby'],
	//		    		'order' 		=> $c['direction'],
	//		    	));
	//		    	
	//		    	$final_child_children = '';
	//		    	if(!empty($child_children)) {
	//		    		//debug($child_children);
	//		    		$child_children_rows = array();
	//			    	foreach($child_children AS $child_child_key => $child_child_value) {
	//			    		$child_children_rows[] = '
	//			    			<tr id="post-'.$child_child_value->ID.'">
	//			    			    <td class="drag">'.$child_child_value->ID.'</td>
	//			    			    <td style="width:100%;"><a href="/wp-admin/post.php?post='.$child_child_value->ID.'&action=edit">'.$child_child_value->post_title.'</a></td>
	//			    			</tr>
	//			    		';
	//			    	}
	//			    	
	//			    	$final_child_children = '
	//			    		<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
	//			    			'.implode("", $child_children_rows).'
	//			    		</table>
	//			    	';
	//			    		
	//			    }
	//		    	
	//		    	$children_rows[] = '
	//		    		<tr id="post-'.$child_value->ID.'">
	//	    				<td class="drag">'.$child_value->ID.'</td>
	//	    				<td style="width:100%;"><a href="/wp-admin/post.php?post='.$child_value->ID.'&action=edit">'.$child_value->post_title.'</a>'.$final_child_children.'</td>
	//	    			</tr>
	//		    	';
	//		    }
	//		    
	//		    
	//		    
	//		    $final_children = '
	//		    	<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:3px 0px 4px 0px;">
	//		    		'.implode("", $children_rows).'
	//		    	</table>
	//		    ';
	//	    }
	//	    
	//	    
	//	    $rows[] = '
	//	    	<tr id="post-'.$post_id.'">
	//	    		<td class="drag">'.$post_id.'</td>
	//	    		<td style="width:100%;"><a href="/wp-admin/post.php?post='.$post_id.'&action=edit">'.$title.'</a>'.$final_children.'</td>
	//	    	</tr>
	//	    ';
	//	    
	//	    ++$i;
	//	endwhile;
	//	
	//	
	//	
	//	if($c['add_new'] === true) {
	//	    $btn_add_new[] = '<a href="/wp-admin/post-new.php?post_type='.$cpt.'" class="button acf-button left" style="margin-right:5px;">+ Neu</a>';
	//	}
	//	
	//	$final_rows = $rows;
	//	
	//	$lang_table_col = '';
	//	$th_languages = array();
	//}
	//
	//
	//
	//echo '
	//	<table id="'.$drag_table_id.'" class="table_dashboard" cellpadding="0" cellspacing="0" border="0" style="width:100%;">
	//	 	<tr>
	//	 		<th class="th1">ID</th>
	//	 		<th class="th1" style="width:100%;">Titel</th>
	//	 		'.implode("", $th_languages).'
	//	 	</tr>
	//	 	'.implode("", $final_rows).'
	//	 </table>
	//	 <div>
	//	 	'.clearer(10).'
	//	 	'.implode("", $btn_add_new).'
	//	 	'.clearer().'
	//	</div>
	//	<style>
	//    	.table_dashboard {
	//    		width:100%;
	//    		border-collapse: collapse;
	//    	}
	//    	
	//    	.table_dashboard .sup {
	//    		color:#d05d59;
	//    		font-size:70%;
	//    	}
	//    	
	//    	#sortable-table .drag { 
	//    		cursor:pointer; 
	//    		padding-left:12px;
	//    		background: transparent url('.get_stylesheet_directory_uri().'/_backend/_images/drag.gif) 3px 5px no-repeat;
	//    	}
	//		
	//		.table_dashboard tr { 
	//			background: white;
	//		}
	//		
	//		.table_dashboard sup {
	//			line-height: 0.0em;
	//		}
	//		
	//		#sortable-table td.drag:hover { 
	//			background-color: #6dcca7;
	//		}
	//		
	//		.table_dashboard th { 
	//			background: transparent; 
	//		}
	//		
	//		.table_dashboard th.th1 { 
	//			background:#666666; 
	//			color: #ffffff;
	//		}
	//		
	//		.table_dashboard th.th2 { 
	//			background:#f3f3f3; 
	//			/* color: #ffffff; */
	//		}
	//		
	//		.table_dashboard td { 
	//			background: transparent; 
	//		}
	//					
	//    	.table_dashboard th,
	//    	.table_dashboard td {
	//    		border: 1px solid #e3e3e3;
	//    		vertical-align:top;
	//    		text-align: left;
	//    		padding: 2px 5px 1px 5px;
	//    	}
	//    </style>
	//';
} 

?>