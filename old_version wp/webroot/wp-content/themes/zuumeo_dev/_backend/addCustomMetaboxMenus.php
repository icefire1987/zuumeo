<?php

if(is_admin()) {
	//add_action( 'admin_head-nav-menus.php', 'addCustomMetaboxMenus' );
	add_action('admin_head-nav-menus.php', 'removeCustomMetaboxMenus');
}


function removeCustomMetaboxMenus() {      
    remove_meta_box('nav-menu-theme-locations', 'nav-menus', 'side'); 
    remove_meta_box('add-post', 'nav-menus', 'side'); 
    remove_meta_box('add-category', 'nav-menus', 'side'); 
    remove_meta_box('pll_lang_switch_box', 'nav-menus', 'side');
    
    if(!defined("SHOW_NAV_MENUS_PAGE")) {
		remove_meta_box('add-page', 'nav-menus', 'side');    
    }
}


function remove_post_custom_fields() {
	remove_meta_box('attachment_alt', 'post', 'normal'); 
}
add_action('admin_menu','remove_post_custom_fields');




function addCustomMetaboxMenus(){
	add_meta_box(
		'info_meta_box_info'
		,__( 'Hinweise' )
		,'renderCustomMetaboxInfo'
		,'nav-menus' // important !!!
		,'side' // important, only side seems to work!!!
		,'high'
	);
}


function renderCustomMetaboxInfo() {
	$return = '
		<p><b>Optionen "HTML-Attribut title":</b><br>- headerGallery<br>- latestNews<br>- randomSafari
	';
	
	echo $return;
}


function renderCustomMetaboxPages($post, $args) {
	if(isPolylang()) {
		global $polylang;
	}
	
	
	$loop_args = array( 
	    'post_type' 		=> $args['args']['post_type'], 
	    'posts_per_page' 	=> 99999999,
	    'orderby'			=> $args['args']['orderby'],
	    'order'				=> $args['args']['order'],
	    /* 'lang' 				=> $lang, */
	    'post_status'		=> array('publish', 'draft'),
	    'post_parent'		=> 0,
	);
			
			
	$loop = new WP_Query( $loop_args );
			
	//debug($loop);
	
	if(isset($_GET['menu'])) {
		$menu_id = $_GET['menu'];
	
	} else {
		$menus = get_terms('nav_menu');
		
		if(isset($menus[0]->term_id)) {
			$menu_id = $menus[0]->term_id;
			
		} else {
			$menu_id = 0;
		}
	}
	
	
	$choices = array();
	$count = array();
	
	if(isPolylang()) {
		foreach($polylang->model->get_languages_list() AS $language) {
			$choices[$language->slug] = array();
			$count[$language->slug] = 0;
		}
	}
	
	foreach($loop->posts AS $key => $value){
		$post_id 		= $value->ID;
		$permalink 		= get_permalink($value->ID);
		$title 			= $value->post_title;
		$post_parent	= $value->post_parent;
		$menu_order		= $value->menu_order;
		
		$temp_choices = '
			<li>
				<label class="menu-item-title"><input type="checkbox" class="menu-item-checkbox" name="menu-item[-'.$post_id.'][menu-item-object-id]" value="'.$post_id.'">&nbsp;'.$title.'</label><input type="hidden" class="menu-item-db-id" name="menu-item[-'.$post_id.'][menu-item-db-id]" value="0">
				<input type="hidden" class="menu-item-object" name="menu-item[-'.$post_id.'][menu-item-object]" value="'.$args['args']['post_type'].'">
				<input type="hidden" class="menu-item-parent-id" name="menu-item[-'.$post_id.'][menu-item-parent-id]" value="0">
				<input type="hidden" class="menu-item-type" name="menu-item[-'.$post_id.'][menu-item-type]" value="post_type">
				<input type="hidden" class="menu-item-title" name="menu-item[-'.$post_id.'][menu-item-title]" value="'.$title.'">
				<input type="hidden" class="menu-item-url" name="menu-item[-'.$post_id.'][menu-item-url]" value="'.$permalink.'">
				<input type="hidden" class="menu-item-target" name="menu-item[-'.$post_id.'][menu-item-target]" value="">
				<input type="hidden" class="menu-item-attr_title" name="menu-item[-'.$post_id.'][menu-item-attr_title]" value="">
				<input type="hidden" class="menu-item-classes" name="menu-item[-'.$post_id.'][menu-item-classes]" value="">
				<input type="hidden" class="menu-item-xfn" name="menu-item[-'.$post_id.'][menu-item-xfn]" value="">
			</li>
		';
		
		if(isPolylang()) {
			$lang = $polylang->model->get_post_language($value->ID)->slug;
			
			$choices[$lang][] = $temp_choices;
			++$count[$lang];
			
		} else {
			$choices[] = $temp_choices;
			++$count;
		}
		
		
		$children 		= get_children(array(
		    'post_type' 		=> $args['args']['post_type'], 
			'posts_per_page' 	=> 99999999,
			'orderby'			=> $args['args']['orderby'],
			'order'				=> $args['args']['order'],
			'post_status'		=> array('publish', 'draft'),
			'post_parent'		=> $post_id,
		));
		
		if(!empty($children)) {
		    $children_rows = array();
		    foreach($children AS $child_key => $child_value) {
				$c_post_id 			= $child_value->ID;
				$c_permalink 		= get_permalink($child_value->ID);
				$c_title 			= $child_value->post_title;
				$c_post_parent		= $child_value->post_parent;
				$c_menu_order		= $child_value->menu_order;
				
				$children2 		= get_children(array(
				    'post_type' 		=> $args['args']['post_type'], 
				    'posts_per_page' 	=> 99999999,
				    'orderby'			=> $args['args']['orderby'],
				    'order'				=> $args['args']['order'],
				    'post_status'		=> array('publish', 'draft'),
				    'post_parent'		=> $c_post_id,
				));
				
				if(!empty($children2)) {
				    $children_rows2 = array();
				    foreach($children2 AS $child_key2 => $child_value2) {
				    	$c2_post_id 		= $child_value2->ID;
				    	$c2_permalink 		= get_permalink($child_value2->ID);
				    	$c2_title 			= $child_value2->post_title;
				    	$c2_post_parent		= $child_value2->post_parent;
				    	$c2_menu_order		= $child_value2->menu_order;
				    	
						$temp_choices3 = '
						   <li>
						   	<label class="menu-item-title"><input type="checkbox" class="menu-item-checkbox" name="menu-item[-'.$c2_post_id.'][menu-item-object-id]" value="'.$c2_post_id.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$c2_title.'</label><input type="hidden" class="menu-item-db-id" name="menu-item[-'.$c2_post_id.'][menu-item-db-id]" value="0">
						   	<input type="hidden" class="menu-item-object" name="menu-item[-'.$c2_post_id.'][menu-item-object]" value="'.$args['args']['post_type'].'">
						   	<input type="hidden" class="menu-item-parent-id" name="menu-item[-'.$c2_post_id.'][menu-item-parent-id]" value="0">
						   	<input type="hidden" class="menu-item-type" name="menu-item[-'.$c2_post_id.'][menu-item-type]" value="post_type">
						   	<input type="hidden" class="menu-item-title" name="menu-item[-'.$c2_post_id.'][menu-item-title]" value="'.$c2_title.'">
						   	<input type="hidden" class="menu-item-url" name="menu-item[-'.$c2_post_id.'][menu-item-url]" value="'.$c2_permalink.'">
						   	<input type="hidden" class="menu-item-target" name="menu-item[-'.$c2_post_id.'][menu-item-target]" value="">
						   	<input type="hidden" class="menu-item-attr_title" name="menu-item[-'.$c2_post_id.'][menu-item-attr_title]" value="">
						   	<input type="hidden" class="menu-item-classes" name="menu-item[-'.$c2_post_id.'][menu-item-classes]" value="">
						   	<input type="hidden" class="menu-item-xfn" name="menu-item[-'.$c2_post_id.'][menu-item-xfn]" value="">
						   </li>
						';
		
						if(isPolylang()) {
						    $c2_lang = $polylang->model->get_post_language($c2_post_id)->slug;
						
						    $choices[$c2_lang][] = $temp_choices3;
						    ++$count[$c2_lang];
						
						} else {
						    $choices[] = $temp_choices3;
						    ++$count;
						}
					}
				}
				
				$temp_choices2 = '
				    <li>
				    	<label class="menu-item-title"><input type="checkbox" class="menu-item-checkbox" name="menu-item[-'.$c_post_id.'][menu-item-object-id]" value="'.$c_post_id.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$c_title.'</label><input type="hidden" class="menu-item-db-id" name="menu-item[-'.$c_post_id.'][menu-item-db-id]" value="0">
				    	<input type="hidden" class="menu-item-object" name="menu-item[-'.$c_post_id.'][menu-item-object]" value="'.$args['args']['post_type'].'">
				    	<input type="hidden" class="menu-item-parent-id" name="menu-item[-'.$c_post_id.'][menu-item-parent-id]" value="0">
				    	<input type="hidden" class="menu-item-type" name="menu-item[-'.$c_post_id.'][menu-item-type]" value="post_type">
				    	<input type="hidden" class="menu-item-title" name="menu-item[-'.$c_post_id.'][menu-item-title]" value="'.$c_title.'">
				    	<input type="hidden" class="menu-item-url" name="menu-item[-'.$c_post_id.'][menu-item-url]" value="'.$c_permalink.'">
				    	<input type="hidden" class="menu-item-target" name="menu-item[-'.$c_post_id.'][menu-item-target]" value="">
				    	<input type="hidden" class="menu-item-attr_title" name="menu-item[-'.$c_post_id.'][menu-item-attr_title]" value="">
				    	<input type="hidden" class="menu-item-classes" name="menu-item[-'.$c_post_id.'][menu-item-classes]" value="">
				    	<input type="hidden" class="menu-item-xfn" name="menu-item[-'.$c_post_id.'][menu-item-xfn]" value="">
				    </li>
				';
		
				if(isPolylang()) {
					$c_lang = $polylang->model->get_post_language($c_post_id)->slug;
			
					$choices[$c_lang][] = $temp_choices2;
					++$count[$c_lang];
			
				} else {
					$choices[] = $temp_choices2;
					++$count;
				}
		    }
		}
		
				
	}
	
	//debug($choices);
	
	$output = array();
	$tabs = array();
	$panels = array();
	$i = 0;
	$final_tabs = '';
	
	if(isPolylang()) {
		foreach($polylang->model->get_languages_list() AS $language) {
			$title 	= $language->name;
			$slug 	= $language->slug;
			
			$output[] = '
				<div>
					<b>'.strtoupper($title).'</b>
				</div>
				<ul class="categorychecklist form-no-clear">
					'.implode("", $choices[$slug]).'
				</ul>
			';
			
			if($i == 0) {
				$class_tab = 'tabs';
				$status = 'active';
				
			} else {
				$class_tab = '';
				$status = 'inactive';
			}
			
			$tab_id = 'tabs-panel-posttype-'.$args['args']['post_type'].'-'.$slug;
			
			$tabs[] = '
				<li class="'.$class_tab.'"><a class="nav-tab-link" data-type="'.$tab_id.'" href="/wp-admin/nav-menus.php?menu='.$menu_id.'&amp;'.$args['args']['post_type'].'-tab='.$slug.'#'.$tab_id.'">'.$title.'</a></li>
			';
			
			$panels[] = '
				<div id="'.$tab_id.'" class="tabs-panel tabs-panel-'.$status.'">
					<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
						'.implode("", $choices[$slug]).'
					</ul>
				</div><!-- /.tabs-panel -->
			';
			
			++$i;
		}
		
		$final_tabs = '
			<ul id="posttype-'.$args['args']['post_type'].'-tabs" class="posttype-tabs add-menu-item-tabs">
		    	'.implode("", $tabs).'
		    </ul>
		';
	
	} else {
		$panels[] = '
			<div id="tabs-panel-'.$args['args']['post_type'].'" class="tabs-panel tabs-panel-active">
				<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
					'.implode("", $choices).'
				</ul>
			</div><!-- /.tabs-panel -->
		';
			
		++$i;
	}
	
	$return = '
		<div id="posttype-'.$args['args']['post_type'].'" class="posttypediv">
			'.$final_tabs.'
		    '.implode("", $panels).'
		    <p class="button-controls">
		    	<span class="add-to-menu">
		    		<input type="submit" class="button-secondary submit-add-to-menu right" value="Zum Men&uuml; hinzuf&uuml;gen" name="add-post-type-menu-item" id="submit-posttype-'.$args['args']['post_type'].'">
		    		<span class="spinner"></span>
		    	</span>
		    </p>
		</div>
	';
	
	
	echo $return;
}

?>