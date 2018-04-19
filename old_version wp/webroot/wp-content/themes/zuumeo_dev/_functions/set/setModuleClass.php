<?php

function setModuleClass($args) {
	//debug($args);
	
	$return = '';
	
	if(isset($args['class_col'])) {
		$return = $args['class_col'];
		
	} else if(isset($args['config_base'][0]['columns'])) {
		$return = 'col_'.$args['config_base'][0]['columns'];
	}
	
	return $return;
}

?>