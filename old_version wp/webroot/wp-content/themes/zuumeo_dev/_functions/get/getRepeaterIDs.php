<?php

function getRepeaterIDs($args){
	if(isset($args['data']) && is_array($args['data']) && !empty($args['data'])) {
		$return = array();
		
		(isset($args['key'])) ? $key = $args['key'] : $key = 'id';
		(isset($args['clean'])) ? $clean = $args['clean'] : $clean = 1;
		
		foreach($args['data'] AS $array_value) {
			$return[] = $array_value[$key];
		}
		
		if($clean == 1) {
			$return = array_unique($return);
		}
			
		return $return;
	}
}