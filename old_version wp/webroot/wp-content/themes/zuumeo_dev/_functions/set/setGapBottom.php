<?php

function setGapBottom($args, $data_edit_id=0) {
	if(isset($args['config_base'][0]['bottom'])) {
		if($args['config_base'][0]['bottom'] == 'default') {
			$value = MODULE_GAP;
	
		} else if($args['config_base'][0]['bottom'] == 'empty') {
			$value = '';
	
		} else {
			$value = $args['config_base'][0]['bottom'];
		}
		
		if(isAdmin() && $data_edit_id > 0) {
			$return = clearer($value, 'data_gap_bottom_'.$data_edit_id);
		} else {
			$return = clearer($value);
		}
		
		return $return;
	}
}

?>