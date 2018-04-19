<?php

function createMenus($args) {
	global $page_id;
	global $all_menus;
	
	$menu_name = $args['menu'];
	if(isPolylang()) {
	    $menu_name = $args['menu'].'_'.getCurrentLanguage(array());
	}
	
	
	if(isset($all_menus[$menu_name])) {
		$temp_menu = $all_menus[$menu_name];
		
		//echo $page_id.'_'.$current_submenu;
		
		if(isset($args['invert'])) {
			$temp_menu = array_reverse($temp_menu);
		}
		
		//!RETURN Hauptmenu
		$final_menu = array();
		$temp_2 = array();
		$return = '';
		foreach($temp_menu AS $key => $v) {
			//debug($v);
			
			$class = '';
			if(isset($page_id) && ($v['page_id'] == $page_id || (isset($v['sub_page_ids'][$page_id])) || (isPageKunde() && $v['page_id'] == getOptionPage("kunden")))) {
				$class = "a_menu_selected";
			}
			
			
			$final_menu[] = '<a href="'.$v['url'].'" class="a_menu softlink '.$class.'">'.$v['title'].'</a>';
			
			if($v['type'] == 'custom' && $v['attr_title'] != '') {
				//debug($v);
			}
			
			if(isset($args['levels']) && $args['levels'] >= 2 && !empty($v['sub'])) {
				foreach($v['sub'] AS $sub_key => $sub_v) {
					$class = '';
					if(isset($page_id) && ($sub_v['page_id'] == $page_id)) {
					    $class = "a_menu_selected";
					}
					
					if($sub_v['type'] == 'custom' && $sub_v['attr_title'] != '') {
						$array_menus_function = array(
							'function'		=> $sub_v['attr_title'],
							'base_level'	=> 2,
						);
						
						if(isset($args['all_levels'])) {
							$array_menus_function['all_levels'] = true;
						}
						
						$menu_function = createMenusFunction($array_menus_function);
						
						foreach($menu_function AS $menu_function_value) {
							$final_menu[] = $menu_function_value;
						}
						//debug($menu_function);
						
					} else {
						$final_menu[] = '<a href="'.$sub_v['url'].'" class="a_menu a_menu_2 softlink '.$class.'">'.$sub_v['title'].'</a>';
					
						if(isset($args['levels']) && $args['levels'] >= 3 && !empty($sub_v['sub'])) {
						    foreach($sub_v['sub'] AS $sub_key_2 => $sub_v_2) {
						    	$class = '';
						    	if(isset($page_id) && ($sub_v_2['page_id'] == $page_id || $sub_v_2['id'] == $current_submenu)) {
						    	    $class = "a_menu_selected";
						    	}
							    	
						    	$final_menu[] = '<a href="'.$sub_v_2['url'].'" class="a_menu a_menu_3 softlink '.$class.'">'.$sub_v_2['title'].'</a>';
						    }
						}
					}
				}
			}
			//if(!empty($v['sub'])) {
			//	foreach($v['sub'] AS $sub_key => $sub_v) {
			//		
			//		
			//		$class = '';
			//		if(isset($page_id) && ($sub_v['page_id'] == $page_id || $sub_v['id'] == $current_submenu)) {
			//			$class = "a_menu_selected";
			//		}
			//		
			//		$class_level = 'a_menu_2';
			//		if(isset($sub_v['level'])) {
			//			$class_level = 'a_menu_'.$sub_v['level'];
			//		}
			//		
			//		$final_menu[] = '<a href="'.$sub_v['url'].'" class="a_menu '.$class_level.' softlink '.$class.'">'.$sub_v['title'].'</a>';
			//	}
			//}
		}
		
		(isset($args['divider'])) ? $divider = $args['divider'] : $divider = '';
		
		$return	= '
			<div class="menu">
				'.implode($divider, $final_menu).'
			</div>
		';
		
		
		
		//echo '<p>$current_submenu: '.$current_submenu;
		//debug($temp_menu);
		
		return $return;	
	}
}

?>