<?php

function createMenusFunction($args) {
	global $page_id;
	
	if(isset($args['function'])) {
		$return = array();
		
		$function = explode("_", $args['function']);
		
		switch($function[0]) {
			case "kundenliste":
				$loop_args = array( 
				    'post_type' 		=> 'kunde', 
				    'posts_per_page' 	=> 999999999,
				    'orderby'			=> 'menu_order',
				    'order'				=> 'ASC',
				    'post_parent'		=> 0,
				    'post_status'		=> array("publish"),
				);
		
				$loop = new WP_Query( $loop_args );
				
				
				foreach($loop->posts AS $post) {
					$post_id 		= $post->ID;
					$post_title		= $post->post_title;
					$post_parent	= $post->post_parent;
					$post_url 		= get_permalink($post_id);
					
					$class = '';
					if(isset($page_id) && ($post_id == $page_id)) {
					    $class = "a_menu_selected";
					}
					
					if(isPageKundeParent() && !isset($args['all_levels'])) {
						
						
					} else {
						$return[] = '<a href="'.$post_url.'" class="a_menu a_menu_'.$args['base_level'].' softlink '.$class.'">'.$post_title.'</a>';
					}
					
					if($function[1] >= 2 || isPageKundeParent()) {
						$final_children_post_id = $post_id;
						if(isPageKundeParent() && !isset($args['all_levels'])) {
							$final_children_post_id = isPageKundeParent();
						}
						
						$children = get_children(array( 
							'post_type' 		=> 'kunde', 
							'posts_per_page' 	=> 999999999,
							'orderby'			=> 'menu_order',
							'order'				=> 'ASC',
							'post_parent'		=> $final_children_post_id,
							'post_status'		=> array("publish"),
						));
						
						if(!empty($children)) {
							foreach($children AS $child) {
		    					$child_post_id 		= $child->ID;
		    					$child_post_title	= $child->post_title;
								$child_post_url 	= get_permalink($child_post_id);
								
								$class = '';
								if(isset($page_id) && ($child_post_id == $page_id)) {
									$class = "a_menu_selected";
								}
					
		    					$return[] = '<a href="'.$child_post_url.'" class="a_menu a_menu_'.($args['base_level']+1).' softlink '.$class.'">'.$child_post_title.'</a>';
		    				}
		    				
		    				if(isPageKundeParent() && !isset($args['all_levels'])) {
		    					break;
		    				}
						}
					}
				}
				
				break;
				
			default:
				break;
		}
		
		return $return;
	}
}

?>