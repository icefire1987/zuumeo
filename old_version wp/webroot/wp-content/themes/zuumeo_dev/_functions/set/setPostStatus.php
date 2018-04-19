<?php

function setPostStatus() {
	if(isAdmin()){
		$return = array('private', 'publish');
	} else {
		$return = 'publish';
	}
	
	return $return;
}

?>