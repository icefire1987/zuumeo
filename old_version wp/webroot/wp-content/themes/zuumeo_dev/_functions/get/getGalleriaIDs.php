<?php

function getGalleriaIDs($images){
	$return = array();
	
	if(is_array($images)) {
		foreach($images AS $image) {
			$return[] = $image['id'];
		}
	}
	
	return $return;
}