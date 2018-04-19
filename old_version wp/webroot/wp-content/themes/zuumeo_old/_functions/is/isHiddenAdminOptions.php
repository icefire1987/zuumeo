<?php

function isHiddenAdminOptions() {
	if(isPageFacebook()) {
		return true;
		
	} else {
		return false;
	}
}

?>