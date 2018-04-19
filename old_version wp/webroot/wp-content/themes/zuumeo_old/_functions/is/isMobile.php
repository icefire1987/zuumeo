<?php

function isMobile() {
	global $detect;
	
	if($detect->isMobile()) {
		return true;
	} else {
		return false;	
	}
}

?>