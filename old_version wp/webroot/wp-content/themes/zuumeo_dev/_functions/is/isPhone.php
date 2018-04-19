<?php

function isPhone() {
	global $detect;
	
	if($detect->isMobile() && !$detect->isTablet()) {
		return true;
	} else {
		return false;	
	}
}

?>