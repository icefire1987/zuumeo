<?php

function createAdminGrid(){
	if(isAdmin() && !isPhone()) {
		global $current_user;
		
		$gfx = get_stylesheet_directory_uri().'/_backend/_images';
		
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
			
			if(getIndividoleOption("admin_grid_color")) {
				$background_grid = getIndividoleOption("admin_grid_color");
			} else {
				$background_grid = '#dddddd';
			}
			
			if(getIndividoleOption("admin_grid_color_module")) {
				$background_module = getIndividoleOption("admin_grid_color_module");
			} else {
				$background_module = '#dddddd';
			}
			
			$grid_lines = array();
			$grid_dimensions = array();
			$dim_h = 15;
			$grid_bottom = $dim_h - 3;
			for($i=0; $i<12; $i++) {
				$pos_x = ($i * $w_col) + ($i * $gap);
				
				$class_first_last = '';
				if($i == 0) {
					$class_first_last = 'col_first';
				} else if($i == 11) {
					$class_first_last = 'col_last';
				}
				
				$grid_lines[] = '
					<div class="col col_1 grid_col '.$class_first_last.'">
						<div class="grid_col_inner" style="background:'.$background_grid.';"></div>
						
					</div>
				';
				
				$dim_w = ($w_col*($i+1)) + ($i * $gap);
				$dim_bottom = (($dim_h+1)*($i+1));
				$dim_bottom_right = $dim_bottom - (($dim_h+1) * 12);
				
				$grid_bottom = $grid_bottom + $dim_h;
				
				$grid_dimensions[] = '
					<div class="grid_col grid_col_left box" style="height:'.$dim_h.'px; width:'.$dim_w.'px; margin-bottom:-'.$dim_bottom.'px;">'.$dim_w.' &rarr;</div>
					<div class="grid_col grid_col_right box" style="height:'.$dim_h.'px; width:'.$dim_w.'px; margin-bottom:'.$dim_bottom_right.'px;">&larr; '.$dim_w.'</div>
				';
			}
			
			$rgb = hex2rgb($background_module);
			$opacity = '0.2';
			
			$admin_grid_difference = 0;
			if(getIndividoleOption("admin_grid_difference")) {
				$admin_grid_difference = getIndividoleOption("admin_grid_difference");
			}
			
			if(isPhone() && getIndividoleOption("admin_grid_difference_mobile")) {
				$admin_grid_difference = getIndividoleOption("admin_grid_difference_mobile");
			}
			
			
			
			$return = '
				<div id="admin_grid">
					<div class="admin_grid_inner">
						'.implode("", $grid_lines).'
						'.clearer().'
					</div>
				</div>
				<div id="admin_grid_dimensions" style="width:'.$w.'px; margin-left:-'.(($w/2) - $admin_grid_difference).'px; bottom:'.$grid_bottom.'px;">'.implode("", $grid_dimensions).'</div>
				<style>
					#admin_grid .col { opacity:0.2; }
					.admin_module_column { background:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$opacity.'); }
				</style>
				<script>
					function admin_resize_grid() {
						var w = jQuery("#content_inner").width() + '.$gap.';
						//jQuery("#admin_grid").width(w);
					}
					
					jQuery(window).resize(function() {
						admin_resize_grid();
					});
					
					admin_resize_grid();
				</script>
			';
			
			return $return;
		}
	}
}

?>