<?php

$current_manual_columns = 0;

function setModuleWidth($args) {
	global $current_manual_columns;
	global $current_m_column_columns;
	
	//debug($args);
	
	$return = '';
	
	if(isset($args['config_base'][0]['columns'])/*  && !isset($args['col_w']) */) {
		$cols = $args['config_base'][0]['columns'];
		
		if($cols < 12 || $current_manual_columns < 12) {
			$margin_right = '';
			
			if(($current_manual_columns + $cols) > 12) {
				$cols = 12 - $current_manual_columns;
			
			} else {
				$current_manual_columns = $current_manual_columns + $cols;
				
				if($current_manual_columns < 12) {
					$margin_right = 'margin-right:'.MODULE_GAP.'px; ';
			
				} else {
					$current_manual_columns = 0;
				}
			}
			
			$return = 'float: left; '.$margin_right;
			
		} else {
			$current_manual_columns = 0;
		}
	}
	
	return $return;
}

?>