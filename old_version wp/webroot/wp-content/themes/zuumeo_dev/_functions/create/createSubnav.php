<?php

function createSubnav($args) {
	global $page_id;
	global $all_menus;
	
	$menu_name = $args['menu'];
	if(isPolylang()) {
	    $menu_name = $args['menu'].'_'.getCurrentLanguage(array());
	}
	
	$m_subnav = array();
	
	if(isset($all_menus[$menu_name])) {
		//debug($all_menus[$menu_name]);
		
		$ms = $all_menus[$menu_name];
		
		foreach($ms AS $m_key => $m_value) {
			if($m_value['page_id'] == $page_id || isset($m_value['sub_page_ids'][$page_id])) {
				$m_subnav = $m_value['sub'];
			}
			
			if($m_value['page_id'] == getOptionPage("kunden")) {
				$subnav_kunden = $m_value['sub'];
			}
			
			if(isPageKunde() && isset($subnav_kunden)) {
				$m_subnav = $subnav_kunden;	
			}
		}
	
	}
	
	//debug($m_subnav);
	
	if(!empty($m_subnav)) {
		$subnav = array();
		foreach($m_subnav AS $m_key => $m_value) {
			if($m_value['type'] == 'custom' && $m_value['attr_title'] != '') {
				$menu_function = createMenusFunction(array(
				    'function'		=> $m_value['attr_title'],
				    'base_level'	=> 2,
				));
				
				foreach($menu_function AS $menu_function_value) {
				    $subnav[] = $menu_function_value;
				}
			
			} else {
				$title = get_the_title($m_value['page_id']);
				$permalink = get_permalink($m_value['page_id']);
					
				$class = "";
				if($page_id == $m_value['page_id']) {
				    $class = "a_menu_selected";
				}
					
				$subnav[] = '
				    <a href="'.$permalink.'" class="a_menu '.$class.'">'.$title.'</a>
				';
			}
		}
		
		$breadcrumb = '';
		if(isPageKundeParent()) {
			$breadcrumb = '<a href="'.get_permalink(isPageKundeParent()).'" class="a_menu a_menu_selected a_menu_1 softlink"><b>'.get_the_title(isPageKundeParent()).'</b></a><div class="left divider">/</div>';
		}
		    				
		if(!empty($subnav)) {
			if(isset($args['invert'])) {
				$subnav = array_reverse($subnav);
			}
			
			$return = '
				<div id="subnav" class="">
					<div id="subnav_inner" class="relative">
						<div id="subnav_inner_content">
							'.$breadcrumb.implode('<div class="left divider">|</div>', $subnav).'
							'.clearer().'
						</div>
						'.clearer().'
					</div>
				</div>
			';
			
			return $return;
		}
	}
}

?>