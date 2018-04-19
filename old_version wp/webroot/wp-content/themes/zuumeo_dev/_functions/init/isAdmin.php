<?php

function isAdmin() {
	if(is_user_logged_in()) {
		return true;
	
	} else {
		return false;
	}
}

?>