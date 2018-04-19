<?php

if(is_admin()) {
	add_action('admin_menu', 'individole_admin');
	
	function individole_admin() {
		global $configs_individole;
		
		if(isset($configs_individole)) {
			add_menu_page('Individol&eacute;', 'Individol&eacute;', 'edit_posts', 'individole', 'individole_options');
			
			foreach($configs_individole AS $k => $v) {
				if(isset($_GET['page']) && $_GET['page'] == "individole-".$k) {
					$ind_path = get_stylesheet_directory().'/_individole/'.$k.'.php';
					
					include_once($ind_path);
				}
			
				add_submenu_page( 'individole', $v, $v, 'edit_posts', 'individole-'.$k,'individole_'.$k); 
			}
			
			remove_submenu_page( 'individole', 'individole' );
		}
	}
	
	function individole_menu() {
		global $configs_individole;
		
		return clearer(25);
		
		//if(sizeof($configs_individole) > 1) {
		//	return clearer(30);
		//	
		//} else {
		//	return clearer(30);
		//}
	}
}




?>