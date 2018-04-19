<?php

function getColumnWidth($args) {
	(isset($args['columns'])) ? $columns = $args['columns'] : $columns = 12;
	
	if(isset($args['config_base'][0]['columns'])) {
		$columns = $args['config_base'][0]['columns'];
	}
	
	if(isPageFacebook()) {
		$column_width = COL_W_FACEBOOK;
		
	} else {
		$column_width = COL_W;
	}
	
	if(isset($args['col_w']) && $args['col_w'] > 0) {
		$return = $args['col_w'];
	
	} else {
		$return = floor(($columns * $column_width) + (($columns - 1) * COL_GAP));
	}
	
	if(isset($args['gap'])) {
		$return = $return + COL_GAP;
	}
	
	return $return;
}

?>