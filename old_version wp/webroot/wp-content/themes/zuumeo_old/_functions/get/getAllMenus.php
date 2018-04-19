<?php

function getAllMenus($args) {
	global $page_id;
	
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	$return = array();
	
	foreach ( $menus as $menu ) {
		$menu_options = wp_get_nav_menu_items($menu->name);
	
		if(!empty($menu_options)) {
			$current_menu_id 	= 0;
			$current_page_id 	= 0;
			$current_page_1		= 0;
			$current_page_2		= 0;
			$current_page_3		= 0;
			$current_title 		= '';
			$set_menu_id 		= 0;
			
			$temp_menu = array();
			$temp_sub = array();
			
			$i_menu = 0;
			foreach($menu_options AS $key) {
			    $key_id 					= $key->ID;
			    $key_object					= $key->object;
			    $key_page_id				= $key->object_id;
			    $key_title					= $key->title;
			    $key_attr_title				= $key->attr_title;
			    $key_url					= $key->url;
			    $key_menu_item_parent 		= $key->menu_item_parent;
			    $key_post_modified			= formatDate(array(
			    	'date' 		=> $key->post_modified, 
			    	'format' 	=> '%Y-%m-%d'
			    ));
			    
			    $menu_array = array(
			    	'url'			=> $key_url,
			        'id'			=> $key_id,
			        'object'		=> $key_object,
			        'page_id'		=> $key_page_id,
			        'modified'		=> $key_post_modified,
			        'type'			=> $key->object,
			        'parent'		=> $key_menu_item_parent,
			        'title'			=> $key_title,
			        'attr_title'	=> $key_attr_title,
			        'sub'			=> array(),
			        'sub_page_ids'	=> array(),
			        'level'			=> 1,
			    );
			    
			    if($key_url != '') {
			    	$return['sitemap'][] = $menu_array;
			    }
			    
			    //echo $key_id.'_'.$key_menu_item_parent.'_'.$key_title.'<br>';
			    
			    if($key_menu_item_parent == 0) {
				    $temp_menu[$key_id] = $menu_array;
				    $parent_page_id = $key_page_id;
				    
				    $last_level_id = $key_id;
			    }
			    
			    //!GET SUB menu
			    if($key_menu_item_parent > 0) {
				    $menu_level = getDepthCustomPostType($key_menu_item_parent);
				    
				    $menu_array['parent_page_id'] = $parent_page_id;
				    
				    //echo '_'.$key_menu_item_parent.':'.$menu_level.'_';
				    
				    $temp_menu[$key_menu_item_parent]['sub_page_ids'][$key_page_id] = true;
				    
				    if($menu_level == 0) {
					    $temp_menu[$key_menu_item_parent]['sub'][$key_id] = $menu_array;
					    
					} else if($menu_level == 1) {
						$temp_menu[$last_level_id]['sub'][$key_menu_item_parent]['sub'][$key_id] = $menu_array;
					}
				}
			    
			    ++$i_menu;
			}
			
			$return[$menu->name] = $temp_menu;
		}
	}
	
	return $return;
}

?>