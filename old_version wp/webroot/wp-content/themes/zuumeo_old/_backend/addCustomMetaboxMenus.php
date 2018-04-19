<?php

if(is_admin()) {
	//add_action( 'admin_head-nav-menus.php', 'addCustomMetaboxMenus' );
	add_action('admin_head-nav-menus.php', 'removeCustomMetaboxMenus');
}


function removeCustomMetaboxMenus() {      
    remove_meta_box('nav-menu-theme-locations', 'nav-menus', 'side'); 
    remove_meta_box('add-post', 'nav-menus', 'side'); 
    remove_meta_box('add-page', 'nav-menus', 'side'); 
    remove_meta_box('add-category', 'nav-menus', 'side'); 
    remove_meta_box('pll_lang_switch_box', 'nav-menus', 'side');
}





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
	    'post_parent' 		=> 0,
	    'orderby'			=> $args['args']['orderby'],
	    'order'				=> $args['args']['order'],
	    'post_status'		=> array('publish', 'draft'),
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
	
	if(isPolylang()) {
		foreach($polylang->model->get_languages_list() AS $language) {
			$choices[$language->slug] = array();
			$count[$language->slug] = 0;
		}
	
	} else {
		$count = 0;
	}
	
	
	
	foreach($loop->posts AS $key => $value){
		$post_id 		= $value->ID;
		
		$permalink 		= get_permalink($value->ID);
		$title 			= $value->post_title;
		$post_parent	= $value->post_parent;
		$menu_order		= $value->menu_order;
		
		$temp_choices = array();
		
		$temp_choices[] = '
			<li>
				<label class="menu-item-title"><input type="checkbox" class="menu-item-checkbox" name="menu-item[-'.$post_id.'][menu-item-object-id]" value="'.$post_id.'"> '.$title.'</label><input type="hidden" class="menu-item-db-id" name="menu-item[-'.$post_id.'][menu-item-db-id]" value="0">
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
		
		
		$children = get_children(array(
			'post_type' 		=> $args['args']['post_type'],
			'posts_per_page' 	=> 99999999,
	   	 	'post_parent' 		=> $post_id,
	   	 	'orderby'			=> $args['args']['orderby'],
	   	 	'order'				=> $args['args']['order'],
	   	 	'post_status'		=> array('publish', 'draft'),
		));
		
		if(!empty($children)) {
			foreach($children AS $child => $child_value){
	   		 	$post_id_2 			= $child_value->ID;
	   		 	
	   		 	$permalink_2 		= get_permalink($child_value->ID);
	   		 	$title_2 			= $child_value->post_title;
	   		 	$post_parent_2		= $child_value->post_parent;
	   		 	$menu_order_2		= $child_value->menu_order;
	   		 	
	   		 	$temp_choices[] = '
			  		<li>
			  			<label class="menu-item-title" style="padding-left:15px;"><input type="checkbox" class="menu-item-checkbox" name="menu-item[-'.$post_id_2.'][menu-item-object-id]" value="'.$post_id_2.'"> '.$title_2.'</label><input type="hidden" class="menu-item-db-id" name="menu-item[-'.$post_id_2.'][menu-item-db-id]" value="0">
			  			<input type="hidden" class="menu-item-object" name="menu-item[-'.$post_id_2.'][menu-item-object]" value="'.$args['args']['post_type'].'">
			  			<input type="hidden" class="menu-item-parent-id" name="menu-item[-'.$post_id_2.'][menu-item-parent-id]" value="0">
			  			<input type="hidden" class="menu-item-type" name="menu-item[-'.$post_id_2.'][menu-item-type]" value="post_type">
			  			<input type="hidden" class="menu-item-title" name="menu-item[-'.$post_id_2.'][menu-item-title]" value="'.$title_2.'">
			  			<input type="hidden" class="menu-item-url" name="menu-item[-'.$post_id_2.'][menu-item-url]" value="'.$permalink_2.'">
			  			<input type="hidden" class="menu-item-target" name="menu-item[-'.$post_id_2.'][menu-item-target]" value="">
			  			<input type="hidden" class="menu-item-attr_title" name="menu-item[-'.$post_id_2.'][menu-item-attr_title]" value="">
			  			<input type="hidden" class="menu-item-classes" name="menu-item[-'.$post_id_2.'][menu-item-classes]" value="">
			  			<input type="hidden" class="menu-item-xfn" name="menu-item[-'.$post_id_2.'][menu-item-xfn]" value="">
			  		</li>
			  	';
			  	
			  	
			  	$children_2 = get_children(array(
			  	    'post_type' 		=> $args['args']['post_type'],
			  	    'posts_per_page' 	=> 99999999,
			  	 	'post_parent' 		=> $post_id_2,
			  	 	'orderby'			=> $args['args']['orderby'],
			  	 	'order'				=> $args['args']['order'],
			  	 	'post_status'		=> array('publish', 'draft'),
			  	));
			  	
			  	
			  	if(!empty($children_2)) {
			  	    foreach($children_2 AS $child_2 => $child_value_2){
			  	     	$post_id_3 			= $child_value_2->ID;
			  	     	
			  	     	$permalink_3 		= get_permalink($child_value_2->ID);
			  	     	$title_3 			= $child_value_2->post_title;
			  	     	$post_parent_3		= $child_value_2->post_parent;
			  	     	$menu_order_3		= $child_value_2->menu_order;
			  	     	
			  	     	$temp_choices[] = '
			  	      		<li>
			  	      			<label class="menu-item-title" style="padding-left:30px;"><input type="checkbox" class="menu-item-checkbox" name="menu-item[-'.$post_id_3.'][menu-item-object-id]" value="'.$post_id_3.'"> '.$title_3.'</label><input type="hidden" class="menu-item-db-id" name="menu-item[-'.$post_id_3.'][menu-item-db-id]" value="0">
			  	      			<input type="hidden" class="menu-item-object" name="menu-item[-'.$post_id_3.'][menu-item-object]" value="'.$args['args']['post_type'].'">
			  	      			<input type="hidden" class="menu-item-parent-id" name="menu-item[-'.$post_id_3.'][menu-item-parent-id]" value="0">
			  	      			<input type="hidden" class="menu-item-type" name="menu-item[-'.$post_id_3.'][menu-item-type]" value="post_type">
			  	      			<input type="hidden" class="menu-item-title" name="menu-item[-'.$post_id_3.'][menu-item-title]" value="'.$title_3.'">
			  	      			<input type="hidden" class="menu-item-url" name="menu-item[-'.$post_id_3.'][menu-item-url]" value="'.$permalink_3.'">
			  	      			<input type="hidden" class="menu-item-target" name="menu-item[-'.$post_id_3.'][menu-item-target]" value="">
			  	      			<input type="hidden" class="menu-item-attr_title" name="menu-item[-'.$post_id_3.'][menu-item-attr_title]" value="">
			  	      			<input type="hidden" class="menu-item-classes" name="menu-item[-'.$post_id_3.'][menu-item-classes]" value="">
			  	      			<input type="hidden" class="menu-item-xfn" name="menu-item[-'.$post_id_3.'][menu-item-xfn]" value="">
			  	      		</li>
			  	      	';
			  	    }
			  	}
			}
		}
		
		if(isPolylang()) {
			$lang 			= $polylang->model->get_post_language($value->ID)->slug;
			
			$choices[$lang][] = implode("", $temp_choices);
			
			++$count[$lang];
		
		} else {
			
			$choices[] = implode("", $temp_choices);
			
			++$count;
		}
		
	}
	
	//debug($choices_pages);
	
	$output = array();
	$tabs = array();
	$final_tabs = '';
	$panels = array();
	$i = 0;
	
	
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
			
			$tabs[] = '
				<li class="'.$class_tab.'"><a class="nav-tab-link" href="/wp-admin/nav-menus.php?menu='.$menu_id.'&amp;'.$slug.'=most-recent#tabs-panel-'.$args['args']['post_type'].'-'.$slug.'">'.$title.' ('.$count[$slug].')</a></li>
			';
			
			$panels[] = '
				<div id="tabs-panel-'.$args['args']['post_type'].'-'.$slug.'" class="tabs-panel tabs-panel-'.$status.'">
					<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
						'.implode("", $choices[$slug]).'
					</ul>
				</div><!-- /.tabs-panel -->
			';
			
			++$i;
		
		}
		
	} else {
		$title 	= $args['args']['name'];
		
		$tabs[] = '
				<li class="tabs"><a class="nav-tab-link" href="/wp-admin/nav-menus.php?menu='.$menu_id.'#tabs-panel-'.$args['args']['post_type'].'">'.$title.' ('.$count.')</a></li>
			';
			
		$output[] = '
		    <div>
		    	<b>'.strtoupper($title).'</b>
		    </div>
		    <ul class="categorychecklist form-no-clear">
		    	'.implode("", $choices).'
		    </ul>
		';
		
		$panels[] = '
		    <div id="tabs-panel-'.$args['args']['post_type'].'" class="tabs-panel tabs-panel-active"">
		    	<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
		    		'.implode("", $choices).'
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
		
	$return = '
		<div id="posttype-'.$args['args']['post_type'].'" class="posttypediv">
			<ul id="posttype-'.$args['args']['post_type'].'-tabs" class="posttype-tabs add-menu-item-tabs">
		    	'.implode("", $tabs).'
		    </ul>
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