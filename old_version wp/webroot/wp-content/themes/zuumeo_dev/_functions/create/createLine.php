<?php

function createLine($args) {
	$top 			= 40;
	$bottom 		= 40;
	$top_border 	= '';
	$bottom_border 	= '';
	$top_color 		= '';
	$bottom_color 	= '';
	$top_title 		= '';
	$bottom_title 	= '';
	
	//debug($args);
	
	if(isset($args['line'][0])) {
		$l = $args['line'][0];	
	} else {
		$l = array();
	}
	
	
	if(isset($args['top'])) {
		$top = $args['top'];	
	}
	
	if(isset($args['bottom'])) {
		$bottom = $args['bottom'];	
	}
	
	if(isset($l['top_color']) && $l['top_color'] != '') {
		$top_color = $l['top_color'];
	}
	
	if(isset($l['top_color']) && ($l['top_color'] == '' || $l['top_color'] == 'no_color')) {
		$top = 0;
		$top_border = 'border-left: 1px solid #ffffff;';
		$top_color = $l['top_color'];
	}
	
	if(isset($l['bottom_color']) && $l['bottom_color'] != '') {
		$bottom_color = $l['bottom_color'];
	}
	
	if(isset($l['bottom_color']) && ($l['bottom_color'] == '' || $l['bottom_color'] == 'no_color')) {
		$bottom = 0;
		$bottom_border = 'border-left: 1px solid #ffffff;';
		$bottom_color = $l['bottom_color'];
	}
	
	
	if(isset($l['top_title']) && $l['top_title'] != "") {
		$top_title = $l['top_title'];
	}
	
	if(isset($l['bottom_title']) && $l['bottom_title'] != "") {
		$bottom_title = $l['bottom_title'];
	}
	
	
	if(isPhone()) {
		$top = $top*1.5;
		$bottom = $bottom*1.5;
	}
	
	
	if(isset($args['clean'])) {
		$top = 0;
		$top_border = 'border-left: 1px solid #ffffff;';
		$bottom = 0;
		$bottom_border = 'border-left: 1px solid #ffffff;';
	}
	
	$return = '
		'.clearer($top).'
		<div class="line">
			<div class="content_inner">
				<div class="line_content left">
					<div class="line_content_top color_'.$top_color.'">
					    '.$top_title.'&nbsp;
					</div>
					<div class="line_content_bottom color_'.$bottom_color.'">
					    '.$bottom_title.'&nbsp;
					</div>
				</div>
				<div class="line_arrows left">
				    <div class="line_arrow line_arrow_top line_arrow_top_'.$top_color.'" style="'.$top_border.'">&nbsp;</div>
				    <div class="line_arrow line_arrow_bottom line_arrow_bottom_'.$bottom_color.'" style="'.$bottom_border.'">&nbsp;</div>
				</div>
				'.clearer().'
			</div>
		</div>
		'.clearer($bottom).'
	';
	
	return $return;
}

?>