<?php

function createAdminOptions(){
	if(isAdmin() && !isPhone()) {
		global $current_user;
		
		$gfx = get_stylesheet_directory_uri().'/_backend/_images';
		
		$return = '
			<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/_backend/stylesheet.css">
		';
		
		if(!isset($current_user->allcaps['individole_frontend']) || isSuperAdmin() || (isset($current_user->allcaps['individole_frontend']) && $current_user->allcaps['individole_frontend'] == 1)) {
			$gap = getIndividoleOption("col_gap");
			$w_col = getIndividoleOption("col_w_inner");
			
			if(isPhone()) {
				if(getIndividoleOption("col_w_mobile")) {
					$w_col = getIndividoleOption("col_w_mobile");
				}
				
				if(getIndividoleOption("col_gap_mobile")) {
					$gap = getIndividoleOption("col_gap_mobile");
				}
			}
			
			$w = ($w_col * 12) + ($gap * 11);
			
			
			
			//$w_col = ($w - (11 * $gap)) / 12;
			
			if(getIndividoleOption("admin_grid_color_module")) {
				$background_module = getIndividoleOption("admin_grid_color_module");
			} else {
				$background_module = '#dddddd';
			}
			
			$rgb = hex2rgb($background_module);
			
			$opacity = '0.2';
			
			$my_theme = wp_get_theme();
			
			//debug($my_theme->Template);
			
			$admin_grid_difference = 0;
			if(getIndividoleOption("admin_grid_difference")) {
				$admin_grid_difference = getIndividoleOption("admin_grid_difference");
			}
			
			if(isPhone() && getIndividoleOption("admin_grid_difference_mobile")) {
				$admin_grid_difference = getIndividoleOption("admin_grid_difference_mobile");
			}
			
			$status = get_post_status(getPageID());
			
			if($status == "publish") {
				$option_status_class 	= 'publish';
				$option_status_word 	= 'Veröffentlicht';
				$show_post_status		= '';
			
			} else {
				$option_status_class 	= 'draft';
				$option_status_word 	= 'Entwurf';
				$show_post_status		= '<div id="page_status_stoerer"></div>';
			}
			$show_post_status		= '';
			
			
			$option_status = '
				<div id="admin_frontpage_option_post_status" class="hand admin_frontpage_option_post_status_'.$option_status_class.'" onclick="admin_toggle_post_status('.getPageID().');"></div>
			';
			
			$option_dev = 'Live Version';
			if(isSuperAdmin()) {
				$theme = wp_get_theme();
				
				if($theme->get_template() == $theme.'_dev') {
					$option_dev = 'Developer<br>Version';
				}
			}
			
			$option_cache = '';
					
			if(isAdmin() && getCacheStatus()) {
				$cache_dir = getCacheDir();
				if(isPhone()) {
					$cache_dir = getCacheDir("mobile");
				}
					
				$basefile = urlencode($_SERVER['REQUEST_URI']).'.html';
				$file = $cache_dir.'/'.$basefile;
				
				$option_cache = '
					<div id="admin_frontpage_options_inner">
						<div class="left hand admin_frontpage_options_button"  onclick="admin_create_cache({post_type:\'\', posts_per_page:1, ids:\''.getPageID().'\'})" onmouseover="show_info_admin_option(\'Cache erstellen\')" onmouseout="hide_info_admin_option()">
							<div id="admin_frontpage_options_button_cache" class="admin_frontpage_option_inner"></div>
						</div>
						<div class="right hand admin_frontpage_options_button"  onclick="admin_delete_cache({id:\''.getPageID().'\'})" onmouseover="show_info_admin_option(\'Cache löschen\')" onmouseout="hide_info_admin_option()">
							<div id="admin_frontpage_options_button_cache_delete" class="admin_frontpage_option_inner"></div>
						</div>
						'.clearer().'
					</div>
				';	
				
				//if(file_exists($file)) {
				//	$option_cache .= '
				//		<div class="hand admin_frontpage_options_button" onclick="admin_update_post_modified({post_id:'.getPageID().', cache:\''.$basefile.'\'});" id="admin_frontpage_update_post_modified_'.getPageID().'">Remove Cache</div>
				//	';
				//}
			}
			
			$options_grid = '';
			if(getIndividoleOption("admin_grid") && getIndividoleOption("admin_grid") == 1) {
				$options_grid = '
					'.clearer(7).'
					<div id="admin_frontpage_option_raster" class="left hand admin_frontpage_options_button" onclick="admin_show_grid();" onmouseover="show_info_admin_option(\'Raster anzeigen\')" onmouseout="hide_info_admin_option()">
						<div id="admin_frontpage_options_button_grid" class="admin_frontpage_option_inner"></div>
					</div>
					<div id="admin_frontpage_option_grid_dimensions" class="right hand admin_frontpage_options_button" onclick="admin_show_dimensions();" onmouseover="show_info_admin_option(\'Lineal einblenden\')" onmouseout="hide_info_admin_option()">
						<div id="admin_frontpage_options_button_grid_dimensions" class="admin_frontpage_option_inner"></div>
					</div>
					'.clearer().'
				';
			}
			
			//<div class="right hand admin_frontpage_options_button" onclick="data_edit_meta('.getPageID().'); return false;" onmouseover="show_info_admin_option(\'Meta-Daten bearbeiten\')" onmouseout="hide_info_admin_option()">
			//				<div id="admin_frontpage_options_button_seo" class="admin_frontpage_option_inner"></div>
			//			</div>
			
			$admin_options = '
				<div id="admin_frontpage_options" class="box">
					<div id="admin_frontpage_options_toptitle">Aktuelles<br>Frontend:<br>'.$option_dev.'</div>
					<div id="admin_frontpage_options_info" class="admin_frontpage_options_text">&nbsp;<br>&nbsp;</div>
					<div id="admin_frontpage_options_inner">
						<div id="admin_frontpage_option_edit" class="left hand admin_frontpage_options_button" onclick="admin_show_edit();" onmouseover="show_info_admin_option(\'Optionen anzeigen\')" onmouseout="hide_info_admin_option()">
							<div id="admin_frontpage_options_button_edit" class="admin_frontpage_option_inner"></div>
						</div>
						
						'.clearer(7).'
						<div class="left admin_frontpage_options_button">
							<a id="admin_frontpage_options_button_wordpress" href="/wp-admin/post.php?post='.getPageID().'&action=edit"  target="_blank" class="admin_frontpage_option_inner" onmouseover="show_info_admin_option(\'Im Backend bearbeiten\')" onmouseout="hide_info_admin_option()"></a>
						</div>
						'.clearer().'
						'.$options_grid.'
					</div>
					'.$option_cache.'
					<div id="admin_frontpage_options_inner">
						'.$option_status.'
					</div>
					<div class="admin_frontpage_options_text">ID: '.getPageID().'<br>'.$option_status_word.'</div>
					<div id="admin_frontpage_options_footertitle">&copy; Individol&eacute;</div>
				</div>	
			';
			
			
			
			$return .= '
				<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/_backend/javascript.js"></script>
				<script>var theme = "'.$my_theme->Template.'";</script>
				<input type="hidden" id="theme_path" value="'.get_stylesheet_directory_uri().'">
				'.$show_post_status.'
				<div id="admin_frontpage_edit" class="admin_frontpage_box"></div>
				'.$admin_options.'
				'.queryDbug().'
			';
		}
		
		return $return;
	}
}

?>