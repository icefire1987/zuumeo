<?php

function setGapTop($args, $data_edit_id=0) {
	if(isset($args['config_base'][0]['top'])) {
		if($args['config_base'][0]['top'] == 'default') {
			$value = MODULE_GAP;
	
		} else if($args['config_base'][0]['top'] == 'empty') {
			$value = '';
	
		} else {
			$value = $args['config_base'][0]['top'];
		}
		
		if(isAdmin() && $data_edit_id > 0) {
			$return = clearer($value, 'data_gap_top_'.$data_edit_id);
		} else {
			$return = clearer($value);
		}
		
		return $return;
	}
}

?>