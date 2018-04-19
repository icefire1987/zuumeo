<?php

function createDynamicCSS($args) {
	$w = getColumnWidth(array());
	$responsive_w = $w;
	$gap = COL_GAP;
	
	$admin_grid_difference = 0;
	if(defined('ADMIN_GRID_DIFFERENCE')) {
		$admin_grid_difference = ADMIN_GRID_DIFFERENCE;
	}
		
	$responsives = array();
	if(RESPONSIVE == true) {
		for($a=1; $a<4; $a++) {
			$w_col = COL_W_INNER - ($a*7.5);
			$w_gap = COL_GAP - ($a*10);
			
			$w_responsive = (12 * $w_col) + (11 * $w_gap);
			
			$responsive_special = '';
			
			$base_responsive = '
				.header_inner_object {
					width: '.$w_responsive.'px;
				}
				
				#header .menu {
					float: left;
					padding: 17px 0px 0px 0px;
				}
		
				.showreel_content_text {
				    display: none;
				}
				
				.showreel_image {
				    /* margin-bottom: 0px; */
				}
			';
			
			if($a == 2 || isPhone()) {
				$responsive_special = '
					'.$base_responsive.'
				';
			}
			
			if($a == 3 || isPhone()) {
				$responsive_special = '
					'.$base_responsive.'
					
					.module_column,
					.module_column .col_1,
					.module_column .col_2,
					.module_column .col_3,
					.module_column .col_4,
					.module_column .col_5,
					.module_column .col_6,
					.module_column .col_7,
					.module_column .col_8,
					.module_column .col_9,
					.module_column .col_10,
					.module_column .col_11,
					.module_column .col_12,
					.imagelist_box .col_1,
					.imagelist_box .col_2,
					.imagelist_box .col_3,
					.imagelist_box .col_4,
					.imagelist_box .col_5,
					.imagelist_box .col_6,
					.imagelist_box .col_7,
					.imagelist_box .col_8,
					.imagelist_box .col_9,
					.imagelist_box .col_10,
					.imagelist_box .col_11,
					.imagelist_box .col_12 {
						float: none;
						clear: both;
						width: 100%;
					}
					
					.imagelist_box.col_gap {
						margin-right: 0px;
					}
					
					.imagelist_box {
						float: none;
						clearer: both;
						width: 100%;
						margin: 0px 0px '.(COL_GAP/2).'px 0px;
					}
					
					.imagelist_box img {
						width: 100%;
						height: auto;
					}
					
					#footer .col_footer {
						width: 50%;
						margin: 0px 0px 24px 0px;
					}
				';
			}
			
			
			
			$cols = array();
			for($i=1; $i<=12; ++$i) {
			    $pos_x = ($i * $w_col) + ($i * $w_gap);
			    
			    $w_col_showreel = floor(($w_responsive - ($w_gap * ($i - 1))) / $i);
			    $w_col_showreel_inset = floor(($w_responsive - 90 - ($w_gap * ($i - 1))) / $i);
			    
			    $cols[] = '
			    	.col_'.$i.' { width:'.(($w_col * $i) + ($w_gap * ($i-1))).'px; }
			    	.grid_col { width: '.$w_col.'px; }
			    	.grid_col_'.$i.' { left: '.$pos_x.'px; }
			    	.col_showreel_'.$i.' { width:'.$w_col_showreel.'px; }
			    	.col_showreel_'.$i.'.col_showreel_inset { width:'.$w_col_showreel_inset.'px; }
			    ';
			}
			
			
		
			$responsives[] = '
				@media only screen and (max-width: '.($responsive_w + 60).'px) {
					#content,
					#footer,
					#header_inner,
					#subnav_inner {
						width:'.($w_responsive + 30).'px;
						/* background:green; */
					}
					
					#content_inner,
					.content_inner,
					#footer_inner {
						width:'.($w_responsive).'px;
					}
					
					.header_inner_object {
						width:'.floor(($w_responsive/2)-1).'px;
					}
				
					.col_showreel { width:'.floor((($w_responsive - ($w_gap*2))/3)).'px; }
					
					.col_gap { margin-right: '.$w_gap.'px;	}
					.col_gap_bottom { margin-bottom: '.$w_gap.'px;	}
					
					'.implode("", $cols).'
					'.$responsive_special.'
				}
			';
			
			$responsive_w = $w_responsive;
		}
	}
	
	$cols = array();
	for($i=1; $i<=12; ++$i) {
		$w_col = COL_W_INNER;
		$pos_x = ($i * $w_col) + ($i * $gap);
		
		$w_col_showreel = floor((getColumnWidth(array()) - (COL_GAP * ($i - 1))) / $i);
		$w_col_showreel_inset = floor((getColumnWidth(array()) - 90 - (COL_GAP * ($i - 1))) / $i);
		
		$cols[] = '
			.col_'.$i.' { width:'.getColumnWidth(array('columns' => $i)).'px; }
			.grid_col { width: '.$w_col.'px; }
			.grid_col_'.$i.' { left: '.$pos_x.'px; }
			.col_showreel_'.$i.' { width:'.$w_col_showreel.'px; }
			.col_showreel_'.$i.'.col_showreel_inset { width:'.$w_col_showreel_inset.'px; }
		';
		
	}
	
	$return = '
		<style>
			.grid_col {
				width:'.COL_W_INNER.'px;
			}
			
			#content,
			#footer,
			#subnav_inner,
			#header_inner {
				width:'.($w+30).'px;
				
				/* background:red; */
			}
			
			#content_inner,
			#footer_inner {
				margin-left: 15px;
			}			
			
			#content_inner,
			.content_inner,
			#footer_inner {
				width:'.$w.'px;
			}
			
			.header_inner_object {
				width:'.floor(($w/2)-1).'px;
			}
			
			.col_gap { margin-right: '.COL_GAP.'px; }
			.col_gap_bottom { margin-bottom: '.COL_GAP.'px;	}
			
			.galleria-container { background:#ffffff; }
			
			'.implode("", $cols).'
			'.implode("", $responsives).'
		</style>
	';
	
	$return = str_replace("\n", "", $return);
	$return = str_replace("	", "", $return);
	
	return $return;
}

?>