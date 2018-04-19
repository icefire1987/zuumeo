<?php

function getDataRepeater($args){
	if(isset($args['id'])) {
		$id = $args['id'];
	} else {
		$id = $GLOBALS['page_id'];
	}
		
	$return = array();
	if(get_field($args['repeater'], $id)) {
		$data = get_field($args['repeater'], $id);
		
		//foreach($images as $image) {
		
		$return[] = $data;
	}
	
	
	
	return $return;
}

?>